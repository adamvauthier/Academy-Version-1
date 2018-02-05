<?php
/**
 * Academies_V1 Child functions and definitions
 *
 * @package Academies_V1
 */
function theme_enqueue_styles() {
	wp_dequeue_style('academies_v1-style-css');
    $parent_style = 'parent-style';
  $url2 = "/home/betasaintsaviour/public_html/wp-content/themes/academies_v1/style.css"; $version= filemtime($url2);
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css','',$version );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );


// Include the Google Analytics Tracking Code (ga.js)
// @ https://developers.google.com/analytics/devguides/collection/gajs/
function google_analytics_tracking_code(){ 
?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45642331-6', 'auto');
  ga('send', 'pageview');

</script>

<?php }

// include GA tracking code before the closing head tag
add_action('wp_head', 'google_analytics_tracking_code');

function parish_scripts() {

$url = "/home/betasaintsaviour/public_html/wp-content/themes/academies_v1_child/style.css"; $version= filemtime($url);  
wp_enqueue_style( 'child-style', '/wp-content/themes/academies_v1_child/style.css','',$version );
}
add_action( 'wp_enqueue_scripts', 'parish_scripts' );