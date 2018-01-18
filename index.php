<?php get_header(); ?>
<div id="app">
    <nav>
	    Current route name: {{ $route.name }}
        <router-link to="/vue">Home</router-link>
        <router-link to="/vue/posts">Posts</router-link>
    </nav>
    <div id="wrapper">
    <router-view></router-view>
    <post-list></post-list>
    </div>
</div>

<script type="text/html" id="post-list-tmpl">
    <div id="posts">
        <div v-for="post in posts">
            <article v-bind:id="'post-' + post.id">
                <header>
                    <h2 class="post-title">
                        {{post.title.rendered}}
                    </h2>
                </header>
                <div class="entry-content" v-html="post.excerpt.rendered"></div>
                <router-link :to="{ name: 'post', params: { id: post.id }}">
                    Read More
                </router-link>
            </article>
        </div>
    </div>
</script>
<script type="text/html" id="post-tmpl">
    <div class="post">
 
        <article v-bind:id="'post-' + post.id">
            <header>
                <h2 class="post-title">
                    {{post.title}}
                </h2>
            </header>
            <div class="entry-content" v-html="post.content"></div>
 
        </article>
    </div>
</script>

<script>
	
(function($){
    var config = {
        api: {
            posts: "<?php echo esc_url_raw( rest_url( 'wp/v2/posts/' ) ); ?>"
        },
        nonce: "<?php echo wp_create_nonce( 'wp_rest' ); ?>"
    };

    var posts = Vue.component('post-list', {
        template: '#post-list-tmpl',
        data: function() {
            return{
                posts: []
            }
        },
        mounted: function () {
            this.getPosts();
        },
        methods: {
            getPosts: function () {
                var self = this;
                $.get( config.api.posts, function( r ){
                    self.$set( self, 'posts', r );
                });

            },
        }
    });

	var post = Vue.component( 'post', {
	    template: '#post-tmpl',
	    data: function() {
	        return{
	            post: []
	        }
	    },
	    mounted: function () {
	        this.getPost();
	    },
	    methods: {
	        getPost: function(){
	           var self = this;
	           $.get( config.api.posts +  self.$route.params.id, function(r){
	               r.title = r.title.rendered;
	               r.content = r.content.rendered;
	               self.$set( self, 'post', r );
	            });
	        }
	    }
	});


    var router = new VueRouter({
        mode: 'history',
        routes: [
            { path: '/', name: 'home', template: '<div>Hi Roy.</div>' },
            { path: '/vue/posts', name: 'posts', component: posts },
            { path: '/vue/posts/:id', name: 'post', component: post },
        ]
    });


    new Vue({
        router,
    }).$mount('#app')



})( jQuery );

</script>

<?php get_footer(); ?>
