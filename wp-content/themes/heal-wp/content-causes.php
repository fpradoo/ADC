<?php
/**
 * @package heal-wp
 */

global $heal_option;

$heal_causes_id = get_the_ID();

$donation_goal = get_post_meta( $heal_causes_id, '_causes_setting_id_donation_goal', true );
$donation_current = round( get_post_meta( $heal_causes_id, '_causes_setting_id_donation_manual', true ) );
$currency_symbol = get_post_meta( $heal_causes_id, '_causes_setting_id_donation_currency_symbol', true );
$display_donation_bar = true;
if ( $donation_goal == '' || $donation_goal == 0 ) {
	$display_donation_bar = false;
}

if ( $donation_current == '' || $donation_current == 0 ) {
	$donation_percentage = 0;
	$donation_current = 0;
	$donation_need = 0;
} else {
	if ( $display_donation_bar ) {
		$donation_percentage = round ( $donation_current / $donation_goal * 100, 2 );
		$donation_need = $donation_goal-$donation_current;
	} else {
		$donation_percentage = '0';
	}
}




?>

<div class="col-sm-12">
	
	<article id="post-<?php the_ID(); ?>" <?php post_class('post-content'); ?>>
		<div class="single-causes-post">
			<figure class="featured-image">
				<?php if ( has_post_thumbnail() ) { 
					the_post_thumbnail(); 
				} else {
					echo '<img src="'.get_template_directory_uri().'/assets/images/no-img.jpg">';
				}
				?>
				<figcaption>
					<div class="col-sm-9">
						<?php if ( $display_donation_bar ) : ?>
							<div class="caption-txt pull">
								<span class="donated"><?php echo esc_html($donation_percentage); ?><?php _e('% Donated', 'heal') ?></span>
								<span class="to-go">/ <?php echo esc_html($currency_symbol); ?><?php echo esc_html($donation_need); ?> <?php _e('To Go', 'heal') ?></span>
								<span class="to-need">/ <?php echo esc_html($currency_symbol); ?><?php echo esc_html($donation_goal); ?> <?php _e('Goal', 'heal') ?></span>
							</div>


							<div class="progress">
								<div id="causes-progress-1" class="progress-bar custom-progress-bar" role="progressbar" aria-valuenow="60" style="width:<?php echo esc_html($donation_percentage); ?>%;" aria-valuemin="0" aria-valuemax="100">
									<span class="sr-only">
										<?php echo esc_html($donation_percentage); ?><?php _e('% Complete', 'heal') ?></span>
									</div>
								</div>
							<?php endif; ?>
							<!-- /.progress -->
						</div>
						<div class="col-sm-3">
						
						<?php if(get_post_meta($post->ID, '_causes_setting_id_donation_paypal', true )) { ?>	
							<button class="btn donate-btn pull-right btn-toggle">
<a class="btn donate-btn pull-right btn-toggle" href="http://adc.org.ar/#pricing">APORTÁ A LA CAUSA</a>

								<?php _e('Donate Now', 'heal') ?>
								
							</button>
							<?php } else { ?>

								<a href="<?php echo esc_url(get_post_meta( $heal_causes_id, '_causes_setting_id_menual_payment_link', true ) );
								?>"><button class="btn donate-btn pull-right btn-toggle">
<a class="btn donate-btn pull-right btn-toggle" href="http://adc.org.ar/#pricing">APORTÁ A LA CAUSA</a>	
							
							<?php } ?>
						</div>
					</figcaption>
				</figure>


				<div class="panel-group widget" id="accordion">
					<?php if(get_post_meta( $post->ID, '_causes_setting_id_donation_paypal', true )) { ?>

					<div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="">
									Paypal
								</a>
							</h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse in" style="height: auto;">
							<div class="panel-body">
								<form action="<?php echo esc_html($heal_option['heal_sandbox_paypal']); ?>" method="post">
									<input type="number" name="amount" class="form-control" value="<?php echo esc_attr($heal_option['heal_default_donation']); ?>" min="1" placeholder="How Much You Want To Donate">
									<input type="hidden" name="cmd" value="_xclick">
									<input type="hidden" name="business" value="<?php echo esc_attr(get_post_meta( $post->ID, '_causes_setting_id_donation_paypal', true ) ); ?>">
									<input type="hidden" name="item_name" value="<?php the_title(); ?>">
									<input type="hidden" name="item_number" value="<?php echo get_the_ID(); ?>">
									<input type="hidden" name="currency_code" value="<?php echo esc_attr($heal_option['heal_select_currency'] ); ?>">		
									<input type="hidden" name="return" value="<?php echo add_query_arg( 'processed', 'yes', get_permalink( get_the_ID() ) ); ?>">		
									<input type="hidden" name="notify_url" value="<?php echo get_template_directory_uri(); ?>/inc/ipn.php">
									<input type="submit" class="btn donate-btn pull-right" value="<?php _e('Donate Now', 'heal') ?>">
									
								</form>
							</div>	
						</div>
					</div>
					<?php } ?>

					<?php if(get_post_meta( $post->ID, '_causes_setting_id_bank_transfer_manual', true )) { ?>
					<div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed">
									<?php _e('Direct Bank Transfer', 'heal') ?>
								</a>
							</h4>
						</div>
						<div id="collapseTwo" class="panel-collapse collapse">
							<div class="panel-body">
								<?php echo wp_kses_post(get_post_meta( $post->ID, '_causes_setting_id_bank_transfer_manual', true )); ?>
							</div>	
						</div>
					</div>
					<?php } ?>

					<?php if(get_post_meta( $post->ID, '_causes_setting_id_chaque_payment', true )) { ?>
					<div class="panel">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="collapsed">
									<?php _e('Check Payment', 'heal') ?>
								</a>
							</h4>
						</div>
						<div id="collapseThree" class="panel-collapse collapse">
							<div class="panel-body">
								<?php echo esc_html(get_post_meta( $post->ID, '_causes_setting_id_chaque_payment', true )); ?>
							</div>	
						</div>	
					</div>
					<?php } ?>
				</div>
			<h2 class="post-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>

			<div class="entry-content">
				<?php the_content(); ?>
				<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'heal' ),
					'after'  => '</div>',
					) );
					?>
				</div><!-- .entry-content -->

				<footer class="entry-footer">
					<?php heal_entry_footer(); ?>
				</footer><!-- .entry-footer -->
			</div>
			<!-- ./single-causes-post -->
		</article><!-- #post-## -->
</div><!-- /.col-sm-10 -->