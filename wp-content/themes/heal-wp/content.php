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
			<span><i class="fa fa-picture-o"></i></span>
		</div><!-- /.post-category -->

	</div><!-- /.col-sm-2 -->
	<div class="col-sm-10">
		<article id="post-<?php the_ID(); ?>" <?php post_class('post-content'); ?>>

			<header class="entry-header">
				<?php 
				
				if(has_post_thumbnail()) { ?>
				<figure class="featured-image">
					<?php the_post_thumbnail(); ?>
				</figure>
				<?php } ?>
				<?php the_title( sprintf( '<h2 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

				<?php if ( 'post' == get_post_type() ) : ?>
					<div class="entry-meta">
						<?php heal_posted_on(); ?>
					</div><!-- .entry-meta -->
				<?php endif; ?>
			</header><!-- .entry-header -->

			<div class="entry-content">

				<?php
				/* translators: %s: Name of current post */
				the_excerpt( sprintf(
					__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'heal' ), 
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
					) );
					?>
					<a class="btn custom-btn angle-effect" href="<?php the_permalink(); ?>"><?php _e('Read More', 'heal') ?></a>
					<?php
					wp_link_pages( array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'heal' ),
						'after'  => '</div>',
						) );
						?>
					</div><!-- .entry-content -->

				</article><!-- #post-## -->
			</div>
		</div>
