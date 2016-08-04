<?php 
/*
Plugin Name: Heal Plugin
Plugin URI: http://codexcoder.com
Description: After install the Heal WordPress Theme, you must need to install this "Heal Essential Plugin" first to get all functions of Heal WP Theme.
Author: Jahirul Islam Mamun- CodexCoder
Author URI: http://www.CodexCoder.com
Version: 1.0.3
Text Domain: heal
*/


if(!class_exists('Heal_Essential_Plg')) :

	/*-----------------------------------------------------------
		define class.
		-----------------------------------------------------------*/
		class Heal_Essential_Plg {

	 /*-----------------------------------------------------------
	 	public plugin url.
	 	-----------------------------------------------------------*/
	 	public $plugin_url;

    /*-----------------------------------------------------------
    	plugin path.
    	-----------------------------------------------------------*/
    	public $plugin_path;

    /*-----------------------------------------------------------
    	plugin construct function.
    	-----------------------------------------------------------*/	
    	public function __construct() {

    		// define url
    		define( 'HEAL_URL', $this->plugin_url() );
    		define( 'HEAL_DIR', dirname( __FILE__ ) ); 


    		// include metabox function
    		$this->heal_plugin_script_include();
    		$this->heal_theme_shortcode();

    		add_action('init', array($this, 'heal_all_custom_post_meta_box' ));

    	}

    /*-----------------------------------------------------------
    	include metabox.
    	-----------------------------------------------------------*/

    	public function heal_plugin_script_include() {

    		require_once(HEAL_DIR . '/heal-post-type-with-metabox/cuztom.php');
    	}

    /*-----------------------------------------------------------
    	custom post type.
    	-----------------------------------------------------------*/

    	public function heal_all_custom_post_meta_box() {

    		require(HEAL_DIR . '/heal-post-type-metabox.php');
    	}

    /*-----------------------------------------------------------
        shortcode.
        -----------------------------------------------------------*/  

        public function heal_theme_shortcode() {

            require(HEAL_DIR . '/theme-shortcode.php');
        }


    /*-----------------------------------------------------------
    	plugin url.
    	-----------------------------------------------------------*/
    	public function plugin_url() {
    		if ( $this->plugin_url ) return $this->plugin_url;
    		return $this->plugin_url = untrailingslashit( plugins_url( '', __FILE__ ) );
    	}

    /*-----------------------------------------------------------
    	plugin dir.
    	-----------------------------------------------------------*/	
    	public function plugin_path() {
    		if ( $this->plugin_path ) return $this->plugin_path;
    		return $this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
    	}



    }

    new Heal_Essential_Plg;

    endif;

    ?>