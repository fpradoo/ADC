<?php
 //error_reporting(E_ALL);
	include_once( '../../../../wp-load.php' );

	global $heal_option;

	if ( $heal_option['heal_sandbox_paypal'] ) {
		$sandbox = true;
	} else {
		$sandbox = false;
	}

	/* STEP 1: Read POST data */

	$raw_post_data = file_get_contents('php://input');
	$raw_post_array = explode('&', $raw_post_data);
	$myPost = array();

	foreach ( $raw_post_array as $keyval ) {
		$keyval = explode ('=', $keyval);
		if ( count( $keyval ) == 2 ) {
			$myPost[$keyval[0]] = urldecode( $keyval[1] );
		}
	}
	
	$req = 'cmd=_notify-validate';
	
	if(function_exists('get_magic_quotes_gpc')) {
		$get_magic_quotes_exists = true;
	}

	foreach ($myPost as $key => $value) {
		if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
			$value = urlencode(stripslashes($value)); 
		} else {
			$value = urlencode($value);
		}
		$req .= "&$key=$value";
	}


	/* STEP 2: Post IPN data back to paypal to validate */
	if ( $sandbox ) {
		$ch = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
	} else {
		$ch = curl_init('https://www.paypal.com/cgi-bin/webscr');	
	}

	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

	if(  ! ( $res = curl_exec( $ch ) ) ) {
		curl_close( $ch );
		exit;
	}
	curl_close( $ch );


	/* STEP 3: Inspect IPN validation result and act accordingly */

	if (strcmp ($res, "VERIFIED") == 0) {

		//// check whether the payment_status is Completed
		//// check that receiver_email is your Primary PayPal email
		//// check that payment_amount/payment_currency are correct
		//// process payment

		// assign posted variables to local variables

		$item_name = $_POST['item_name'];
		$item_number = $_POST['item_number'];
		$payment_status = $_POST['payment_status'];
		$payment_amount = $_POST['mc_gross'];
		$payment_currency = $_POST['mc_currency'];
		$txn_id = $_POST['txn_id'];
		$receiver_email = $_POST['receiver_email'];
		$payer_email = $_POST['payer_email'];

		/**
 		* Get id of a post by using different methods
		 */
		function heal_get_post_id($by, $needle){

			global $wpdb;

			$to_return = '';

			if( $by == 'name' ) { $to_return = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '".$needle."'"); }

			if( $by == 'title' ) { $to_return = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '".$needle."'"); }

			if( $by == 'template' ) { $pages = $wpdb->get_row("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_wp_page_template' AND meta_value='".$needle."'", ARRAY_A); $to_return = $pages['post_id']; }

			// if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {

				$to_return = icl_object_id( $to_return, get_post_type( $to_return ), true );

			//}

			return $to_return;

		}

		$donate_page_id = heal_get_post_id( 'content', 'content-causes.php' );


		// If the payment was from regular donate page
		if ( $item_number == $donate_page_id  ) {

				$args = array(
					'paged' => $paged, 
					'post_type' => 'causes',
					'order_by' => 'meta_value_num',
					'order' => 'DESC',
				);

				// Do the Query
				$donate_query = new WP_Query($args);

				// Loop
				if ( $donate_query->have_posts() ) {

					$causes_amount = $donate_query->found_posts ;
					$donation_per_cause = $payment_amount / $causes_amount;

					while ( $donate_query->have_posts() ) { 

						$donate_query->the_post();

						// Get current amount
						$cause_curr_amount = get_post_meta( get_the_ID(), '_causes_setting_id_donation_manual', true );
						$cause_new_amount = $donation_per_cause + $cause_curr_amount;
						update_post_meta( get_the_ID(), '_causes_setting_id_donation_manual', $cause_new_amount );

					} 

				}

				wp_reset_query();

			

		// If the payment was from a cause page
		} else {

			$cause_curr_amount = get_post_meta( $item_number, '_causes_setting_id_donation_manual', true );
			$cause_new_amount = $payment_amount + $cause_curr_amount;
			update_post_meta( $item_number, '_causes_setting_id_donation_manual', $cause_new_amount );

		}		

	}

?>