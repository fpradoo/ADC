<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package heal-wp
 */

global $heal_option;

?>


<!-- Scroll to Top -->
<div id="scroll-to-top">
	<div class="hex scroll-top">
		<span><i class="fa fa-chevron-up"></i></span>
	</div>
</div><!-- /#scroll-to-top -->
<!-- Scroll to Top End-->	


<!-- Footer Section -->
<footer id="footer-section">
	<div class="footer-section">
		<div class="container">
			<div class="copyrights pull-left">
				<?php echo wp_kses_stripslashes($heal_option['heal_copyright_text']); ?>				
			</div><!-- .site-info -->

			<div class="footer-social-btn pull-right">
				<?php if($heal_option['heal_twitter']) { ?>
				<a href="<?php echo esc_url($heal_option['heal_twitter']); ?>" class="twitter-btn"><i class="fa fa-twitter"></i></a>
				<?php } ?>

				<?php if($heal_option['heal_facebook']) { ?>
				<a href="<?php echo esc_url($heal_option['heal_facebook']); ?>" class="facebook-btn"><i class="fa fa-facebook"></i></a>
				<?php }?>

				
				<?php if($heal_option['heal_google_plus']) { ?>
				<a href="<?php echo esc_url($heal_option['heal_google_plus']); ?>" class="google-plus-btn"><i class="fa fa-google-plus"></i></a>
				<?php } ?>

				<?php if($heal_option['heal_youtube']) { ?>
				<a href="<?php echo esc_url($heal_option['heal_youtube']); ?>" class="youtube-btn"><i class="fa fa-youtube"></i></a>
				<?php } ?>

			
				<?php if($heal_option['heal_linkedin']) { ?>
				<a href="<?php echo esc_url($heal_option['heal_linkedin']); ?>" class="linkedin-btn"><i class="fa fa-linkedin"></i></a>
				<?php } ?>

				

			</div><!-- /.footer-social-btn -->

	</div><!-- /.container -->
</div><!-- /.footer-section -->
</footer><!-- /#footer-section -->


<?php wp_footer(); ?>
</body>
</html>
