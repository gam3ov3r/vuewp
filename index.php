<?php get_header(); ?>
<div id="app" class="container">
	<h1>Current route name: {{ $route.name }}</h1>
	<ul class="nav">
	  <li class="nav-item"><router-link to="/">Home</router-link></li>
	  <li class="nav-item"><router-link to="/posts">Posts</router-link></li>
	</ul>    
    <div id="wrapper">
    <router-view></router-view>
    <post-list></post-list>
    </div>
</div>

<script type="text/html" id="post-list-tmpl">
	<div class="list-group">
		<router-link :to="{ name: 'post', params: { id: post.id }}" class="list-group-item list-group-item-action flex-column align-items-start" v-bind:id="'post-' + post.id" v-for="post in posts">
			<div class="d-flex w-100 justify-content-between">
				<h5 class="mb-1">{{post.title.rendered}}</h5>
				<small class="text-muted">{{post.date | formatDate}}</small>
			</div>
			<p class="mb-1" v-html="post.excerpt.rendered">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
		</router-link>
	</div>    
</script>
<script type="text/html" id="post-tmpl">
	
	<div class="card border-primary mb-3">	
		<div class="card-body" v-bind:id="'post-' + post.id">
			<h5 class="card-title">{{post.title}}</h5>
			<h6 class="card-subtitle mb-2 text-muted">Posted {{post.date | formatDate}}</h6>
			<p class="card-text" v-html="post.content"></p>
		</div>
	</div>
    
</script>
<script>
(function($){

Vue.filter('formatDate', function(value) {
  if (value) {
    return moment(String(value), 'YYYYMMDD').fromNow()
    
  }
});
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
            { path: '/posts', name: 'posts', component: posts },
            { path: '/posts/:id', name: 'post', component: post },
        ]
    });


    new Vue({
        router,
    }).$mount('#app')



})( jQuery );

</script>

<?php get_footer(); ?>
