<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package heal-wp
 */

global $heal_option;
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	
	<?php echo ccr_favicon();?>
	
	<?php if(!empty($heal_option['heal_custom_css'])) { ?>
	<style>
		<?php echo esc_html($heal_option['heal_custom_css']); ?>
	</style>
	<?php } ?>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> id="wrapper">

<?php 

function heal_header_style() {

	if(is_home()) {
		$default = ReduxFramework::$_url.'assets/img/Screenshot2.jpg'; 

		if($heal_option['header_style'] == $default) { 
			echo 'menu-style2'; 
		} else { 
			echo 'navbar-fixed-top';
		} 

	} else {
		echo 'navbar-fixed-top';
	}
}

?>

	<!-- Main Menu -->
	<div class="main-menu-container <?php heal_header_style() ?>">
		<div id="main-menu" class="navbar navbar-default <?php if( get_option( 'page_for_posts' )) {echo "blog-page";} ?>" role="navigation">
			<div class="container">

				<div class="navbar-header">
					<!-- responsive navigation -->
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only"><?php _e('Toggle navigation', 'heal') ?></span>
						<i class="fa fa-bars"></i>
					</button> <!-- /.navbar-toggle -->
					<!-- Logo -->
					<h1>
						<?php if($heal_option['heal_logo_on_off']){ ?>
						<a class="navbar-brand" href="<?php echo home_url(); ?>">
							<img class="logo" src="<?php echo esc_url($heal_option['heal_logo']['url']); ?>" alt="Logo" rel="hoome">
						</a><!-- /.navbar-brand -->
						<?php }else { ?>
						<a class="navbar-brand" href="<?php echo home_url(); ?>">
							<?php echo bloginfo('name' ); ?>
						</a>
						<?php } ?>
					</h1>
				</div> <!-- /.navbar-header -->

				<nav id="nav-collapse" class="navbar-collapse collapse ">
					<!-- Main navigation -->
					<?php  if( is_page_template('page-template/front-page.php')) { 
						if($heal_option['heal_smoot_scroll_menu_on_off']) {
						?>
					<ul id="headernavigation" class="nav navbar-nav pull-right">
						<li><a class="home-menu" href="#top-section"><?php _e('Home', 'heal') ?></a></li>
						<?php 
						$about_menu = $heal_option['heal_about_menu'];
						$team_menu = $heal_option['heal_team_menu'];
						$service_menu = $heal_option['heal_service_menu'];
						//$testimonial_menu = $heal_option['heal_testimonial_menu'];
						$gallery_menu = $heal_option['heal_gallery_menu'];
						$causes_menu = $heal_option['heal_causes_menu'];
						$about_menu = $heal_option['heal_about_menu'];
						$news_menu = $heal_option['heal_news_menu'];
						$event_menu = $heal_option['heal_event_menu'];
						$contact_menu = $heal_option['heal_contact_menu'];

						//make id
						$about_id = strtolower(str_replace(' ', '_', $about_menu));
						$team_id = strtolower(str_replace(' ', '_', $team_menu));
						$service_id = strtolower(str_replace(' ', '_', $service_menu));
						//$testimonial_id = strtolower(str_replace(' ', '_', $testimonial_menu));
						$gallery_id = strtolower(str_replace(' ', '_', $gallery_menu));
						$causes_id = strtolower(str_replace(' ', '_', $causes_menu));
						$news_id = strtolower(str_replace(' ', '_', $news_menu));
						$event_id = strtolower(str_replace(' ', '_', $event_menu));
						$contact_id = strtolower(str_replace(' ', '_', $contact_menu));
						$menu_sorting = $heal_option['heal_seciton_sorter']['Enabled'];
						if ($menu_sorting): foreach ($menu_sorting as $key=>$value) {

							switch($key) {

								case 'about': echo "<li><a href='#$about_id'>$about_menu</a></li>";
								break;

								case 'team': echo "<li><a href='#$team_id'>$team_menu</a></li>";
								break;

								case 'service': echo "<li><a href='#$service_id'>$service_menu</a></li>";
								break;

								case 'gallery': echo "<li><a href='#$gallery_id'>$gallery_menu</a></li>";
								break;

								case 'causes': echo "<li><a href='#$causes_id'>$causes_menu</a></li>";
								break;

								case 'news': echo "<li><a href='#$news_id'>$news_menu</a></li>";
								break;

								case 'event': echo "<li><a href='#$event_id'>$event_menu</a></li>";
								break;

								case 'contact': echo "<li><a href='#$contact_id'>$contact_menu</a></li>";
								break;

							}

						}

						endif;

						?>
						<?php 
						if( $heal_option['heal_donation_on_off'] ) {
							if($heal_option['heal_donation_button_on_off'] ) {
								query_posts('post_type=causes' );
								if(have_posts()) {
									?>			
									<li><span class="donate"><?php _e('Donate ', 'heal') ?><i class="fa fa-heart"></i></span></li>
									<?php }
									wp_reset_query();

									} else { ?>

								<li><span class="donate-custom"><a href="<?php echo esc_url($heal_option['heal_donation_menual_url']); ?>"><?php _e('Donate ', 'heal') ?><i class="fa fa-heart"></i></a></span></li>

								<?php }

							}

							?>
						
						</ul> <!-- /.nav .navbar-nav -->
						
						<?php 
							} else {
						heal_nav_menu();
						} 

					} else { 
							heal_nav_menu(); 

							} ?>

					</nav> <!-- /.navbar-collapse  -->
				</div> <!-- /.container -->
			</div><!-- /#main-menu -->
		</div><!-- /.main-menu-container -->
		<!-- Main Menu End -->