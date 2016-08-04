<?php
class CC_Love_Count {

	function __construct() {
		add_action( 'wp_ajax_cc_love', array( &$this, 'ajax' ) );
		add_action( 'wp_ajax_nopriv_cc_love', array( &$this, 'ajax' ) );
		add_action( 'wp_ajax_cc_love_randomize', array( &$this, 'randomize' ) );
		add_action( 'wp_ajax_nopriv_cc_love_randomize', array( &$this, 'randomize' ) );
	}

	function ajax( $post_id ) {

		if ( isset( $_POST['post_id'] ) ) {
			echo $this->love( intval($_POST['post_id']), 'update' );
		}
		else {
			echo $this->love( intval($_POST['post_id']), 'get' );
		}

		exit;
	}
	
	function randomize( ){
		
		$post_type = htmlspecialchars(stripslashes($_POST['post_type']));
		
		$aPosts = get_posts(array( 
			'posts_per_page' 	=> -1,
			'post_type' 		=> $post_type ? $post_type : false,
		));

		if( is_array( $aPosts ) ){
			foreach( $aPosts as $post ){
				$love_count = rand( 10, 100 );	// Random number of loves [min:10, max:100]
				update_post_meta( $post->ID, 'cc-post-love', $love_count );
			}
			
			_e( 'Love randomized',  'cc-opts' );
		}

		exit;
	}

	function love( $post_id, $action = 'get' ) {
		if ( ! is_numeric( $post_id ) ) return;

		switch ( $action ) {

		case 'get':
			$love_count = get_post_meta( $post_id, 'cc-post-love', true );
			if ( !$love_count ) {
				$love_count = 0;
				add_post_meta( $post_id, 'cc-post-love', $love_count, true );
			}

			return $love_count;
			break;

		case 'update':
			$love_count = get_post_meta( $post_id, 'cc-post-love', true );
			if ( isset( $_COOKIE['cc-post-love-'. $post_id] ) ) return $love_count;

			$love_count++;
			update_post_meta( $post_id, 'cc-post-love', $love_count );
			setcookie( 'cc-post-love-'. $post_id, $post_id, time()*20, '/' );

			return $love_count;
			break;

		}
	}

	function get() {
		global $post;

		$output = $this->love( $post->ID );
		$class = '';
		if ( isset( $_COOKIE['cc-post-love-'. $post->ID] ) ) {
			$class = 'loved';
		}

		return '<span class="project-like"> <a href="#" class="cc-love '.$class .'" data-id="'. $post->ID .'"><span class="updated-counter"><i>'. $output .'</i></span> <i class="fa fa-heart-o"></i></a></span>';	
	}

}

global $cc_love;
$cc_love = new CC_Love_Count();

function cc_love( $return = '' ) {
	global $cc_love;
	return $cc_love->get();
}

?>