<?php
/**
 * @package heal-wp
 */
?>
<div class="row post-box">
	<div class="col-sm-2">
		<div class="publish-date">
			<p class="day"><?php echo get_the_date('j'); ?></p>
			<p class="month-year"><time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('M Y'); ?></time></p>
		</div><!-- /.publish-date -->

		<div class="post-category">	
			<span><?php heal_post_format_icon(); ?></span>		
		</div><!-- /.post-category -->

	</div><!-- /.col-sm-2 -->

	<div class="col-sm-10">

		<article id="post-<?php the_ID(); ?>" <?php post_class('post-content'); ?>>
			<?php 
				if ( get_post_meta( $post->ID, '_post_meta_video_video', true ) ) {
					echo "<div class='meta-video'>";
					global $wp_embed;
					echo $wp_embed->run_shortcode('
						[embed]' . esc_url(get_post_meta( $post->ID, '_post_meta_video_video', true )) . '[/embed]'
						);
					echo "</div>";
				}
			?>
			<h2 class="post-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>


			<?php heal_posted_on(); ?>


			<div class="entry-content">
				<?php the_excerpt(); ?>
				<a class="btn custom-btn angle-effect" href="<?php the_permalink(); ?>"><?php _e('Read More', 'heal') ?></a>

				<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'heal' ),
					'after'  => '</div>',
					) );
					?>
				</div><!-- .entry-content -->

			</article><!-- #post-## -->
		</div><!-- /.col-sm-10 -->
	</div>