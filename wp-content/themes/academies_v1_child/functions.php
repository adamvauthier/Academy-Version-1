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

add_action('admin_menu', 'register_my_custom_submenu_page');

function register_my_custom_submenu_page() {
	add_submenu_page( 'tools.php', 'Theme Deployment', 'Theme Deployment', 'manage_options', 'theme-deployment-page', 'theme_deployment_page_callback' );
}

function theme_deployment_page_callback() {
	
	echo '<div class="wrap"><div id="icon-tools" class="icon32"></div>';
		echo '<h2>Theme Deployment</h2>';
	echo '</div>';
  echo '<div class="deployButton" style="margin-top:20px; width:80%;">Press the button below to initiate the deployment of the active theme for the Acadmies websites.  Once clicked all other academy websites will have an update under dashboard->updates.  This update process must be completed for the theme to update on the other academy sites.</div>';
  echo '<div class="deployButton" style="margin-top:20px; width:80%;"><input name="save" type="submit" class="button button-primary button-large" id="publish" value="DEPLOY THEME"><div class="deploy-update" style="margin-top:20px;"></div></div><script type="text/javascript">jQuery(document).ready(function(){
jQuery("#publish").click(function(){
jQuery(".deploy-update").html("<h3>Deploying</h3><br /><img src=\'http://olscorona.org/wp-content/uploads/2015/07/712-2.gif\'/>");
	var request = new XMLHttpRequest();
request.open(\'GET\', \'https://beta.saintsaviourcatholicacademy.org/wp-content/themes/versionEdit.php\', true);

request.onload = function() {
  if (request.status >= 200 && request.status < 400) {
    console.log("Success");
		jQuery(".deploy-update").html("<h3>Deployment Successful</h3>");
  } else {
    // We reached our target server, but it returned an error
	console.log("fail");
  }
};
request.send();
});
});</script>';

}

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