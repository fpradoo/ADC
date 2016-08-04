<?php
/**
 * heal-wp functions and definitions
 *
 * @package heal-wp
 */


/*-----------------------------------------------------------------------------------*/
/*	define 
/*-----------------------------------------------------------------------------------*/ 

define("CC_LANG", get_template_directory_uri() . '/languages/');
define("CC_AST", get_template_directory_uri() . '/assets/');
define("CC_FONT", get_template_directory_uri() . '/assets/fonts/');
define("CC_CSS", get_template_directory_uri() . '/assets/css/');
define("CC_IMG", get_template_directory_uri() . '/assets/images/');
define("CC_JS", get_template_directory_uri() . '/assets/js/');
define("CC_INC", get_template_directory() . '/inc/');

/*-----------------------------------------------------------------------------------*/
/*	define theme essential file 
/*-----------------------------------------------------------------------------------*/ 

//require CC_INC . 'custom-header.php';
require CC_INC . 'template-tags.php';
require CC_INC . 'extras.php';
require CC_INC . 'customizer.php';
require CC_INC . 'jetpack.php';
require CC_INC . 'wp_bootstrap_navwalker.php';
require CC_INC . 'widget.php';
require CC_INC . 'love-count.php';
require_once( CC_INC  . 'shortcodes/tinymce.button.php');
require_once( CC_INC . 'class-tgm-plugin-activation.php');


/*-----------------------------------------------------------------------------------*/
/*	theme option framework 
/*-----------------------------------------------------------------------------------*/ 

if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/framework/ReduxCore/framework.php' ) ) {
	require_once( dirname( __FILE__ ) . '/framework/ReduxCore/framework.php' );
}
if ( !isset( $redux_demo ) && file_exists( dirname( __FILE__ ) . '/framework/theme-options.php' ) ) {
	require_once( dirname( __FILE__ ) . '/framework/theme-options.php' );
}



/*-----------------------------------------------------------------------------------*/
/*	Content Width
/*-----------------------------------------------------------------------------------*/

if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

/*-----------------------------------------------------------------------------------*/
/*	theme setup 
/*-----------------------------------------------------------------------------------*/ 

if ( ! function_exists( 'heal_setup' ) ) :

	function heal_setup() {

	/*-----------------------------------------------------------
		Make theme available for translation
		-----------------------------------------------------------*/

		load_theme_textdomain( 'heal', get_template_directory() . '/languages' );

	/*-----------------------------------------------------------
		Add default posts and comments RSS feed links to head
		-----------------------------------------------------------*/

		add_theme_support( 'automatic-feed-links' );

	/*-----------------------------------------------------------
		Enable support for Post Thumbnails on posts and pages
		-----------------------------------------------------------*/

		add_theme_support( 'post-thumbnails' );

		add_theme_support( "title-tag" );

	/*-----------------------------------------------------------
		crop image size.
		-----------------------------------------------------------*/
		add_image_size( 'widget-thumb', 70, 70, true ); 
		add_image_size( 'home-thumb', 500, 280, true );
		add_image_size( 'causes-thumb', 360, 200, true );
		add_image_size( 'gallery-thumb', 275, 190, true );

	/*-----------------------------------------------------------
		Register menu
		-----------------------------------------------------------*/

		register_nav_menus( array(
			'inner_menu' => __( 'Inner page menu', 'heal' ),
			) );

	/*-----------------------------------------------------------
		Enable html5 support
		-----------------------------------------------------------*/

		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
			) );

	/*-----------------------------------------------------------
		Enable support for Post Formats
		-----------------------------------------------------------*/

		add_theme_support( 'post-formats', array(
			'aside', 'image', 'audio', 'video', 'quote',
			) );

	/*-----------------------------------------------------------
			shortcode works on widet.
		-----------------------------------------------------------*/	

			add_filter('widget_text', 'do_shortcode');


	/*-----------------------------------------------------------
		Add theme Support Custom Background
		-----------------------------------------------------------*/

		add_theme_support( 'custom-background', apply_filters( 'heal_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
			) ) );

	}
endif; // heal_setup
add_action( 'after_setup_theme', 'heal_setup' );


/*-----------------------------------------------------------------------------------*/
/*	define sidebar 
/*-----------------------------------------------------------------------------------*/ 

function heal_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'heal' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title title">',
		'after_title'   => '</h3>',
		) );
}
add_action( 'widgets_init', 'heal_widgets_init' );


/*-----------------------------------------------------------------------------------*/
/*	load css and js file 
/*-----------------------------------------------------------------------------------*/ 

add_action('wp_enqueue_scripts', 'heal_cc_script');

if(!function_exists('heal_cc_script')) {
	function heal_cc_script(){

		// modernizr
		wp_enqueue_script('modernizr', CC_JS . 'modernizr-2.8.0.min.js', array(), '', false  );

		//css include
		wp_enqueue_style('wp-mediaelement');
		wp_enqueue_style('all-style', CC_CSS .'all-style.css' );
		wp_enqueue_style( 'cc-style', get_stylesheet_uri() );

		//js include
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script('google-maps', 'http://maps.google.com/maps/api/js?sensor=true', array(), '', true  );
		wp_enqueue_script('plugins', CC_JS . 'plugins.min.js', array(), '', true  );
		wp_enqueue_script('functions', CC_JS . 'functions.js', array(), '', true  );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}


/*-----------------------------------------------------------------------------------*/
/*	js script for show and hide post formet meta box 
/*-----------------------------------------------------------------------------------*/ 


if(!function_exists('heal_post_format_meta_script')){

	function heal_post_format_meta_script()
	{
		if(is_admin())
		{
			wp_register_script('postmeta-js', CC_JS .'post-format-meta.js');
			wp_enqueue_script('postmeta-js');
		}
	}

	add_action('admin_enqueue_scripts','heal_post_format_meta_script');

}





/*-----------------------------------------------------------------------------------*/
/*	load script on footer 
/*-----------------------------------------------------------------------------------*/ 

add_action('wp_footer', 'cc_js_load_on_footer', 100 );

function cc_js_load_on_footer(){
	if(is_front_page()) {
		?>
		<script type="text/javascript">

			/*---------------------- Current Menu Item -------------------------*/
			jQuery(document).ready(function($) {
				"use strict";

				window.cc_ajax = "<?php echo admin_url('admin-ajax.php'); ?>";
				 /* ---------------------------------------------------------------------------
				 * Love
				 * --------------------------------------------------------------------------- */
				 jQuery('.cc-love').click(function() {
				 	var el =jQuery(this);
				 	if( el.hasClass('loved') ) return false;

				 	var post = {
				 		action: 'cc_love',
				 		post_id: el.attr('data-id')
				 	};

				 	jQuery.post(window.cc_ajax, post, function(data){
				 		el.find('.updated-counter').html(data);
				 		el.addClass('loved');
				 	});

				 	return false;
				 }); 


				<?php 
				global $heal_option; 

				if(!empty($heal_option['heal_upevent_section_off']) ) {

					query_posts('post_type=event&p=' .$heal_option['heal-event-posts-countdown']);
					if(have_posts()) : while(have_posts()) : the_post(); 

					$date_formate = get_post_meta( get_the_ID(), '_events_setting_id_event_date', true );	
					$start_time = get_post_meta( get_the_ID(), '_events_setting_id_event_time', true );
					$start_end = get_post_meta( get_the_ID(), '_events_setting_id_event_time_end', true );
					
					?> 
					/*----------- Event ----------------*/	
					var eventID = jQuery('#event_time_countdown');

					if ( eventID.length){
				
					jQuery('#event_time_countdown').countDown({
						targetDate: {
							'day': '<?php echo esc_attr(date("j", $date_formate)); ?>',
							'month': '<?php echo esc_attr(date("m", $date_formate)); ?>',
							'year': '<?php echo esc_attr(date("Y", $date_formate)); ?>',
							'hour': '<?php echo esc_attr(date("H", $start_time)); ?>',
							'min': '<?php echo esc_attr(date("i", $start_time)); ?>',
							'sec': '0'
						},
						omitWeeks: true
					});
				}
				<?php endwhile;endif;
			}

			?>	

			<?php if(!empty($heal_option['heal_nice_scroll'])) { ?>
				/*------------------------------ Nice Scroll (for Mouse Wheel) ----------------------*/
				jQuery("html").niceScroll({
					cursorcolor: "<?php echo esc_attr($heal_option['heal_unlimited_color_scheam']['background-color']); ?>",
					scrollspeed: 30,
					mousescrollstep: 70,
					cursorwidth: 12,
					cursorborderradius: 0,
					hwacceleration: true,
					autohidemode: true,
					cursorborder: "1px solid <?php echo esc_attr($heal_option['heal_unlimited_color_scheam']['background-color']); ?>",
					// background: "#F39C12",
				});

				<?php } ?>

				/*----------- Google Map - with support of gmaps.js ----------------*/
				function isMobile() { 
					return ('ontouchstart' in document.documentElement);
				}

				function init_gmap() {
					if ( typeof google == 'undefined' ) return;
					var options = {
						center: [<?php global $heal_option; echo esc_js($heal_option['heal_lati']); ?>, <?php echo esc_js($heal_option['heal_longi']); ?>],
						zoom: 15,
						mapTypeControl: true,
						mapTypeControlOptions: {
							style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
						},
						navigationControl: true,
						scrollwheel: false,
						streetViewControl: true
					}

					if (isMobile()) {
						options.draggable = false;
					}

					jQuery('#googleMaps').gmap3({
						map: {
							options: options
						},
						marker: {
							latLng: [<?php echo esc_js($heal_option['heal_lati']); ?>, <?php echo esc_js($heal_option['heal_longi']); ?>],
							options: { icon: '<?php echo esc_js($heal_option['heal_map_icon']['url']); ?>' }
						}
					});
				}

				init_gmap();


			
				/*------------------------- Team Member Slider ----------------------------*/
				var teamID = jQuery("#team-slider");
				if(teamID.length) {
				jQuery("#team-slider").owlCarousel({

					loop:true,
					margin:10,
					responsiveClass:true,
					responsive:{
						0:{
							items:1,
							nav:false
						},
						600:{
							items:2,
							nav:false
						},
						1000:{
							items:<?php echo esc_js($heal_option['heal_team_no']); ?>,
							nav:false,
							loop:false
						}
					}
				});
				}


			});
</script>
<?php
}
}


/*-----------------------------------------------------------------------------------*/
/*	 custom css load before head tag 
/*-----------------------------------------------------------------------------------*/ 

add_action('wp_head', 'cc_css_load_on_head', 100 );

function cc_css_load_on_head() { 
	global $heal_option; 
	
	?>
	<style>
		<?php 

		if(function_exists('is_woocommerce')){ ?>
			.page-title {
				text-transform: uppercase;
				margin: 0;
			}
			#primary-area {
				margin-top: 80px;
			}
			.woocommerce .woocommerce-ordering select {
				padding: 10px;
				border-color: #D9D9D9;
			}  
			.product-item .product-image:before {
				border: 1px solid <?php echo esc_attr($heal_option['heal_unlimited_color_scheam']['background-color']); ?>;
			}  
			.star-rating span:before  {
				color: <?php echo esc_attr($heal_option['heal_unlimited_color_scheam']['background-color']); ?>;
			}   
        <?php }

		/**  woocommerce.
		--------------------------------------------------------------------------------------------------- */
		
		/*-----------------------------------------------------------
			Unlimited color scheam.
			-----------------------------------------------------------*/
			if(!empty($heal_option['heal_unlimited_color_scheam']['background-color'])) { ?>

				a:hover,
				.navbar-default .navbar-nav>li>a:focus,
				.blog-section .post-title a:hover,
				.blog-section .comments:hover,
				.blog-sidebar .widget_categories a:hover, 
				.blog-sidebar .widget_archive a:hover, 
				.blog-sidebar .widget_nav_menu a:hover, 
				.blog-sidebar .widget_recent_entries a:hover,
				.copyrights a:hover, 
				.footer-social-btn a:hover,
				.galleryFilter a:focus, 
				.galleryFilter a:hover, 
				.galleryFilter .current,
				.parallax-description span,
				.causes-post .caption-txt .donated {
					color:  <?php echo esc_attr($heal_option['heal_unlimited_color_scheam']['background-color']); ?>;
				}

				.dropdown-menu>li>a:hover, .dropdown-menu>li>a:focus, .dropdown-menu>.active>a, .dropdown-menu>.active>a:hover, .dropdown-menu>.active>a:focus {
					background-color: <?php echo esc_attr($heal_option['heal_unlimited_color_scheam']['background-color']); ?>;
				}

				.link-hex span {
					color:  <?php echo esc_attr($heal_option['heal_unlimited_color_scheam']['background-color']); ?>;
				}

		
				.menu-style2 #main-menu.navbar-default, 
				.blog #main-menu.navbar-default, 
				.archive #main-menu.navbar-default, 
				.single #main-menu.navbar-default, 
				.page-template-default #main-menu.navbar-default,
				.page-template-full-width #main-menu.navbar-default,
				.page-template-full-page-without-title #main-menu.navbar-default,
				.publish-date,
				.custom-btn:after,
				.hex, .hex:before, .hex:after,
				.content-icon-hex,
				.hex.scroll-top:after, 
				.hex.scroll-top:before,
				.hex.scroll-top,
				.section-title:after,
				.carousel-indicators li.active,
				.pricing-item:hover .item-head,
				.pricing-item .item-name:after,
				.slide-nav:hover,
				.gallery-item figure:hover .item-description,
				.news-article .meta-icon,
				.parallax-title:after,
				.causes-post .custom-progress-bar, 
				.single-causes-post .custom-progress-bar,
				.donate-btn,
				.progress-bar-container .progress-bar-warning,
				.team-member-box:hover .member-designation:after,
				.owl-page.active,
				.team-member-box:before,
				.service-box:hover .service-icon-hex, 
				.service-box:hover .service-icon-hex:before, 
				.service-box:hover .service-icon-hex:after,
				.event-timeline,
				.page-template-page-templatefront-page-php .blog-page,
				.blog-sidebar .btn:hover,
				.link-hex:hover {
					background-color: <?php echo esc_attr($heal_option['heal_unlimited_color_scheam']['background-color']); ?>;
				}

				.page-template-page-templatefront-page-php .menu-bg {
					background-color: <?php echo esc_attr($heal_option['heal_unlimited_color_scheam']['background-color']); ?>;
				}

				.service-box .service-icon-hex, 
				.service-box .service-icon-hex:before, 
				.service-box .service-icon-hex:after {
					background-color: transparent;
				}

				.hex, .hex:before, .hex:after,
				.carousel-indicators li.active,
				.white-bg .custom-btn, .gray-bg .custom-btn,
				.custom-btn:hover,
				.post-box .custom-btn,
				.galleryFilter .current,
				.time-circle .time-number,
				.contact-form-container .custom-btn,
				.contact-info .contact-address li:before,
				.comment-form .form-control:focus, 
				.contact-form-container .form-control:focus,
				.contact-form-container .custom-btn:hover,
				.owl-page.active,
				.single-event-post .time-circle .time-number,
				.link-hex,
				.custom-btn,
				.service-box .hex ,
				.service-box .hex:before, 
				.service-box .hex:after {
					border-color:  <?php echo esc_attr($heal_option['heal_unlimited_color_scheam']['background-color']); ?>;
				}

				<?php } ?>

				<?php if($heal_option['heal_about_lr_agular']) { ?>
					.about-section .white-bg.angular .top-angle:before {
						-webkit-transform: skewY(-4deg);
						-moz-transform: skewY(-4deg);
						-o-transform: skewY(-4deg);
						-ms-transform: skewY(-4deg);
						transform: skewY(4deg);
					}
				<?php } ?>

				<?php if($heal_option['heal_mission_lr_agular']) { ?>
					.about-section .gray-bg.angular .top-angle:before{
						-webkit-transform: skewY(-4deg);
						-moz-transform: skewY(-4deg);
						-o-transform: skewY(-4deg);
						-ms-transform: skewY(-4deg);
						transform: skewY(4deg);
					}
				<?php } ?>

				<?php if($heal_option['heal_team_lr_agular']) { ?>
					.team-section .white-bg.angular .top-angle:before {
						-webkit-transform: skewY(-4deg);
						-moz-transform: skewY(-4deg);
						-o-transform: skewY(-4deg);
						-ms-transform: skewY(-4deg);
						transform: skewY(4deg);
					}
				<?php } ?>

				<?php if($heal_option['heal_volunteer_lr_agular']) { ?>
					.volunteer-section .gray-bg.angular .top-angle:before {
						-webkit-transform: skewY(-4deg);
						-moz-transform: skewY(-4deg);
						-o-transform: skewY(-4deg);
						-ms-transform: skewY(-4deg);
						transform: skewY(4deg);
					}
				<?php } ?>

				<?php if($heal_option['heal_service_lr_agular']) { ?>
					.services-section.white-bg.angular .top-angle:before {
						-webkit-transform: skewY(-4deg);
						-moz-transform: skewY(-4deg);
						-o-transform: skewY(-4deg);
						-ms-transform: skewY(-4deg);
						transform: skewY(4deg);
					}
				<?php } ?>

				<?php if($heal_option['heal_service_pricing_lr_agular']) { ?>
					.pricing-section .gray-bg.angular .top-angle:before	{
						-webkit-transform: skewY(-4deg);
						-moz-transform: skewY(-4deg);
						-o-transform: skewY(-4deg);
						-ms-transform: skewY(-4deg);
						transform: skewY(4deg);
					}
				<?php } ?>

				<?php if($heal_option['heal_testimonial_agular']) { ?>
					.testimonial-section .angular .top-angle:before	{
						-webkit-transform: skewY(-4deg);
						-moz-transform: skewY(-4deg);
						-o-transform: skewY(-4deg);
						-ms-transform: skewY(-4deg);
						transform: skewY(4deg);
					}
				<?php } ?>

				<?php if($heal_option['heal_gallery_lr_agular']) { ?>

					.gallery-section.angular .top-angle:before	{
						-webkit-transform: skewY(-4deg);
						-moz-transform: skewY(-4deg);
						-o-transform: skewY(-4deg);
						-ms-transform: skewY(-4deg);
						transform: skewY(4deg);
					}

				<?php } ?>

				<?php if($heal_option['heal_news_lr_agular']) { ?>
					.news-section.angular .top-angle:before	{
						-webkit-transform: skewY(-4deg);
						-moz-transform: skewY(-4deg);
						-o-transform: skewY(-4deg);
						-ms-transform: skewY(-4deg);
						transform: skewY(4deg);
					}
				<?php } ?>
				<?php if($heal_option['heal_upevent_section_lr_agular']) { ?>
					.news-section.angular .top-angle:before	{
						-webkit-transform: skewY(-4deg);
						-moz-transform: skewY(-4deg);
						-o-transform: skewY(-4deg);
						-ms-transform: skewY(-4deg);
						transform: skewY(4deg);
					}
				<?php } ?>

				<?php if($heal_option['heal_upcomming_lr_agular']) { ?>
					.upcoming-events-section.angular .top-angle:before	{
						-webkit-transform: skewY(-4deg);
						-moz-transform: skewY(-4deg);
						-o-transform: skewY(-4deg);
						-ms-transform: skewY(-4deg);
						transform: skewY(4deg);
					}
				<?php } ?>

				<?php if($heal_option['heal_Client_lr_agular']) { ?>
					.clients-section.angular .top-angle:before	{
						-webkit-transform: skewY(-4deg);
						-moz-transform: skewY(-4deg);
						-o-transform: skewY(-4deg);
						-ms-transform: skewY(-4deg);
						transform: skewY(4deg);
					}
				<?php } ?>


					<?php if($heal_option['heal_contact_section_lr_agular']) { ?>
					.contact-section.angular .top-angle:before	{
						-webkit-transform: skewY(-4deg);
						-moz-transform: skewY(-4deg);
						-o-transform: skewY(-4deg);
						-ms-transform: skewY(-4deg);
						transform: skewY(4deg);
					}
				<?php } ?>


				<?php if($heal_option['heal_map_lr_agular']) { ?>
					#google-map .angular .top-angle:before	{
						-webkit-transform: skewY(-4deg);
						-moz-transform: skewY(-4deg);
						-o-transform: skewY(-4deg);
						-ms-transform: skewY(-4deg);
						transform: skewY(4deg);
					}
				<?php } ?>

						<?php if(!$heal_option['heal_layout']) { ?>
							
							body {
								background: #FAFAFA;
							}
							#wrapper {
								max-width: 1200px;
								margin: 0 auto;
								overflow-x: hidden;
							}
							#top-section {
								overflow: hidden;
							}
							.navbar-fixed-top {
								max-width: 1200px;
								margin: 0 auto;
							}

						<?php } ?>	

						/*responsive*/
				<?php if(!empty($heal_option['heal_unlimited_color_scheam']['background-color'])) { ?>
				@media (max-width: 992px) {
					.navbar-default {
						background: <?php echo esc_attr($heal_option['heal_unlimited_color_scheam']['background-color']); ?>;
					}
					.navbar-fixed-top {
						background: <?php echo esc_attr($heal_option['heal_unlimited_color_scheam']['background-color']); ?>;
					}
					.navbar-nav>li {
						background: <?php echo esc_attr($heal_option['heal_unlimited_color_scheam']['background-color']); ?>;
					}
				}

				@media screen and (max-width: 480px) {
					.donate, .donate-custom {
						width: 100%;
						display: block;
						padding: 0;
						text-align: center;
					}
				}
				
				<?php } ?>


	</style>

<?php }

/*-----------------------------------------------------------------------------------*/
/*	post formate quote 
/*-----------------------------------------------------------------------------------*/ 


function get_blockquote() {
	$dom = new DOMDocument;
	$dom->loadHTML( apply_filters( 'the_content', get_the_content( '' ) ) );
	$blockquotes = $dom->getElementsByTagname( 'blockquote' );

	if ( $blockquotes->length > 0 ) {

        // First blockquote
		$blockquote = $blockquotes->item(0);

		$cite = $blockquote->getElementsByTagName( 'cite' )->item( 0 );
		$p = $blockquote->getElementsByTagName( 'p' );

		$cite_content = '';
		if ( $cite && $p ) {

            // Remove the cite from the paragraph
			foreach ( $p as $paragraph )
				try { $paragraph->removeChild( $cite ); }
			catch( Exception $e ) {}

			$cite_content = $dom->saveXML( $cite );
		}

		$blockquote_content = '';
		foreach ( $p as $paragraph ) {
			if ( strlen( trim( $paragraph->nodeValue ) ) > 0 )
				$blockquote_content .= $dom->saveXML( $paragraph );
			else
				$paragraph->parentNode->removeChild( $paragraph );

			$blockquote->parentNode->removeChild( $blockquote );
			$remaining_content = $dom->saveXML();
		}
    return $blockquote_content; // $cite_content or $remaining_content
}

}


/*-----------------------------------------------------------------------------------*/
/*	  filter the hook   
/*-----------------------------------------------------------------------------------*/ 

// avatar filter
add_filter('get_avatar','heal_change_avatar_class');

function heal_change_avatar_class($class) {
	$class = str_replace("class='avatar", "class='img-circle ", $class) ;
	return $class;
}


// filter replay class
add_filter('comment_reply_link', 'heal_comment_reply_link' ); 

function heal_comment_reply_link($class) {
	$class = str_replace("comment-reply-link", "comment-reply-link btn custom-btn angle-effect", $class) ;
	return $class;
}

/*-----  End of filter the hook  ------*/


/*-----------------------------------------------------------------------------------*/
/*	 require plugin of heal 
/*-----------------------------------------------------------------------------------*/ 

add_action( 'tgmpa_register', 'heal_req_plugins_include');

if(!function_exists('heal_req_plugins_include')){

	function heal_req_plugins_include()
	{
		$plugins = array(
			array(
					'name'                  => 'Heal Essential', // The plugin name
					'slug'                  => 'heal-essential', // The plugin slug (typically the folder name)
					'source'                => get_template_directory() . '/assets/plugin/heal-essential.zip', // The plugin source
					'required'              => true, // If false, the plugin is only 'recommended' instead of required
					'version'               => '1.0.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
					'force_activation'      => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
					'force_deactivation'    => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
					'external_url'          => '', // If set, overrides default API URL and points to an external URL
					),
			array(
					'name'                  => 'Revolution Slider', // The plugin name
					'slug'                  => 'revslider', // The plugin slug (typically the folder name)
					'source'                => get_template_directory() . '/assets/plugin/revslider.zip', // The plugin source
					'required'              => true, // If false, the plugin is only 'recommended' instead of required
					'version'               => '4.6.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
					'force_activation'      => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
					'force_deactivation'    => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
					'external_url'          => '', // If set, overrides default API URL and points to an external URL
					),
			array(
				'name'      => 'Contact Form 7',
				'slug'      => 'contact-form-7',
				'required'  => true,
				),
			array(
				'name'      => 'WooCommerce',
				'slug'      => 'woocommerce',
				'required'  => true,
				)

			);


	/**
	* Array of configuration settings. Amend each line as needed.
	* If you want the default strings to be available under your own theme domain,
	* leave the strings uncommented.
	* Some of the strings are added into a sprintf, so see the comments at the
	* end of each line for what each argument will be.
	*/
	$config = array(
			'domain'            => 'heal',           			 // Text domain - likely want to be the same as your theme.
			'default_path'      => '',                           // Default absolute path to pre-packaged plugins
			'parent_menu_slug'  => 'themes.php',         		 // Default parent menu slug
			'parent_url_slug'   => 'themes.php',         		 // Default parent URL slug
			'menu'              => 'install-required-plugins',   // Menu slug
			'has_notices'       => true,                         // Show admin notices or not
			'is_automatic'      => true,            			 // Automatically activate plugins after installation or not
			'message'           => '',               			 // Message to output right before the plugins table
			'strings'           => array(
				'page_title'                                => __( 'Install Required Plugins', 'heal' ),
				'menu_title'                                => __( 'Install Plugins', 'heal' ),
						'installing'                                => __( 'Installing Plugin: %s', 'heal' ), // %1$s = plugin name
						'oops'                                      => __( 'Something went wrong with the plugin API.', 'heal' ),
						'notice_can_install_required'               => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
						'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
						'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
						'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
						'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
						'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
						'notice_ask_to_update'                      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
						'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
						'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
						'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
						'return'                                    => __( 'Return to Required Plugins Installer', 'heal' ),
						'plugin_activated'                          => __( 'Plugin activated successfully.', 'heal' ),
						'complete'                                  => __( 'All plugins installed and activated successfully. %s', 'heal' ) // %1$s = dashboard link
						)
);

tgmpa( $plugins, $config );

}
}


/*-----------------------------------------------------------------------------------*/
/*	 filter 
/*-----------------------------------------------------------------------------------*/ 


/*-----------------------------------------------------------
	remove wpcf7- text from contact form 7 form.
	-----------------------------------------------------------*/

	add_filter( 'wpcf7_form_elements', 'ccr_wpcf7_form_elements_filter' );
	function ccr_wpcf7_form_elements_filter( $content ) {

		$ccr_pfind = '/wpcf7-/';
		$ccr_preplace = '';
		$content = preg_replace( $ccr_pfind, $ccr_preplace, $content );

		return $content;	
	}

/*-----------------------------------------------------------
	Boxer filter.
	-----------------------------------------------------------*/

	add_filter( 'wp_get_attachment_link', 'wp_shorcode_prettyadd');
	
	function wp_shorcode_prettyadd ($content) {
		
		$content = preg_replace("/<a/","<a class=\"boxer\"",$content,1);
		return $content;
	}


/*-----------------------------------------------------------------------------------*/
/*	demo import set home page settings 
/*-----------------------------------------------------------------------------------*/ 

/************************************************************************
* Extended Example:
* Way to set menu, import revolution slider, and set home page.
*************************************************************************/
if ( !function_exists( 'wbc_extended_example' ) ) {
	function wbc_extended_example( $demo_active_import , $demo_directory_path ) {
		reset( $demo_active_import );
		$current_key = key( $demo_active_import );
		/************************************************************************
		* Import slider(s) for the current demo being imported
		*************************************************************************/
		if ( class_exists( 'RevSlider' ) ) {
			//If it's demo3 or demo5
			$wbc_sliders_array = array(
				'angular' => 'heal-revolution-homepage.zip', //Set slider zip name
				'linear' => 'heal-revolution-homepage.zip', //Set slider zip name
			);
			if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_sliders_array ) ) {
				$wbc_slider_import = $wbc_sliders_array[$demo_active_import[$current_key]['directory']];
				if ( file_exists( $demo_directory_path.$wbc_slider_import ) ) {
					$slider = new RevSlider();
					$slider->importSliderFromPost( true, true, $demo_directory_path.$wbc_slider_import );
				}
			}
		}
		/************************************************************************
		* Setting Menus
		*************************************************************************/
		// If it's demo1 - demo6
		$wbc_menu_array = array( 'linear', 'angular');
		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && in_array( $demo_active_import[$current_key]['directory'], $wbc_menu_array ) ) {
			$top_menu = get_term_by( 'name', 'Temp Menu', 'nav_menu' );
			if ( isset( $top_menu->term_id ) ) {
				set_theme_mod( 'nav_menu_locations', array(
						'inner_menu' => $top_menu->term_id,
						'theme-footer'  => $top_menu->term_id
					)
				);
			}
		}
		/************************************************************************
		* Set HomePage
		*************************************************************************/
		// array of demos/homepages to check/select from
		$wbc_home_pages = array(
			'angular' => 'Home',
			'linear' => 'Home',
		);
		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_home_pages ) ) {
			$page = get_page_by_title( $wbc_home_pages[$demo_active_import[$current_key]['directory']] );
			if ( isset( $page->ID ) ) {
				update_option( 'page_on_front', $page->ID );
				update_option( 'show_on_front', 'page' );
			}
		}
	}
	// Uncomment the below
	add_action( 'wbc_importer_after_content_import', 'wbc_extended_example', 10, 2 );
} 


/**  add to cart text.
--------------------------------------------------------------------------------------------------- */
add_filter( 'woocommerce_product_add_to_cart_text' , 'custom_woocommerce_product_add_to_cart_text' );
/**
 * custom_woocommerce_template_loop_add_to_cart
*/
function custom_woocommerce_product_add_to_cart_text() {
	global $product;
	global $heal_option;
	
	$product_type = $product->product_type;
	
	switch ( $product_type ) {
		case 'external':
			return $heal_option['wo_buy_pro'];
		break;
		case 'grouped':
			return $heal_option['wo_view_pro'];
		break;
		case 'simple':
			return $heal_option['wo_to_cart'];
		break;
		case 'variable':
			return $heal_option['wo_select_opt'];
		break;
		default:
			return __( 'Read more', 'woocommerce' );
	}
	
}