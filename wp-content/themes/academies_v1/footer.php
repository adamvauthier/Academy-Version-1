<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Academies_V1
 */

?>

	</div><!-- #content -->
</div><!-- #page -->
	<footer id="colophon" class="site-footer" role="contentinfo">
    <section class="container">
      <div class="site-info">
        <a href= "<?php the_field('footer_image_link', 'option');?>" ><img src="<?php the_field('footer_image', 'option') ?>"  /></a>
        <section class="address">
          <?php the_field('footer_address', 'option'); ?>
        </section>
        <?php wp_nav_menu( array( 'theme_location' => 'footer-menu' ) ); ?>
        <?php get_field('social-media-links', '42'); ?>
        <?php if(get_field('social_media', 'option')): ?>
          <section class="social-media">	
            <?php while(has_sub_field('social_media', 'option')): ?>
                <a href="<?php the_sub_field('site_link', 'option'); ?>"  target="_blank" class="<?php the_sub_field('site', 'option'); ?> sm"><?php the_sub_field('site', 'option'); ?></a>
            <?php endwhile; ?>
            <h6>Follow Us:</h6>
           </section> 
        <?php endif; ?>
       <p class="copyright">
        &copy;<?php echo date("Y");  ?> <?php the_field('copyright', 'option'); ?>
         </p>
      </div><!-- .site-info -->
     
		</section>
    <div id="mylightbox"><h3>SECURITY CODE</h3><p>To make your online shopping experience even more secure, please enter your credit card's 3- or 4- digit security code.</p><div class="card"><strong>VISA/MASTERCARD/DISCOVER</strong><img src="/wp-content/themes/academies_v1/images/cvv-visa.gif" /></div><div class="card card2"><strong>AMERICAN EXPRESS</STRONG><img src="/wp-content/themes/academies_v1/images/cvv-amex.gif" /></div></div>
  </footer><!-- #colophon -->


<?php wp_footer(); ?>
<script src='https://cdnjs.cloudflare.com/ajax/libs/tinysort/2.2.2/tinysort.js' type="text/javascript"></script>
<script>
	jQuery(document).ready(function(){
      jQuery('.hint').click(function(){
  console.log('test');
  	jQuery.featherlight(jQuery('#mylightbox'));
  });
  	tinysort('.event',{attr:'data-date'});  
    jQuery('#events').show();
    jQuery('.event:nth-child(2), .event:nth-child(3), .event:nth-child(4), .event:nth-child(5)').css('display', 'block');
  });
</script>
<script type=text/javascript>  
            jQuery(document).ready(function(){
var slider = jQuery('.royalSlider').data('royalSlider');
slider.ev.on('rsAfterSlideChange', function() { 
    if(slider.currSlideId === 0) {
        slider.stopAutoPlay();
    }
});
});
jQuery(document).on('click', '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    jQuery(this).ekkoLightbox();
});
				</script>
</body>
</html>
