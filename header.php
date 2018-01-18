<?php

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
<style>
html, body {
	padding: 0;
	margin: 0;
}
nav {
	padding: 10px;
	background: #ccc;
}
.post {
	padding: 10px;
	border: 1px solid black;
}
#wrapper {
	padding: 10px;
}
</style>	
</head>

<body <?php body_class(); ?>>
