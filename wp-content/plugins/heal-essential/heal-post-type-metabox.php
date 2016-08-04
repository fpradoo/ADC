<?php 

/*-----------------------------------------------------------------------------------*/
/*	  team custom post type with meta box
/*-----------------------------------------------------------------------------------*/ 


$team = register_cuztom_post_type( 'team', array(
	'supports' => array('title', 'thumbnail'),
	'menu_icon' => 'dashicons-groups'
	) );

$team->add_meta_box( 
	'team_setting_id',
	'Team Settings', 
	array(
		array(
			'name'          => 'sort_team_bio',
			'label'         => 'Member Bio',
			'description'   => '',
			'type'          => 'textarea'
			),
		array(
			'name'          => 'designation',
			'label'         => 'Designation',
			'description'   => '',
			'type'          => 'text'
			),
		array(
			'name'          => 'facebook',
			'label'         => 'Facebook',
			'description'   => '',
			'type'          => 'text'
			),
		array(
			'name'          => 'twitter',
			'label'         => 'Twitter',
			'description'   => '',
			'type'          => 'text'
			),
		array(
			'name'          => 'dribbble',
			'label'         => 'Dribbble',
			'description'   => '',
			'type'          => 'text'
			),
		array(
			'name'          => 'google_plus',
			'label'         => 'Google Plus',
			'description'   => '',
			'type'          => 'text'
			),
		array(
			'name'          => 'linkedin',
			'label'         => 'Linkedin',
			'description'   => '',
			'type'          => 'text'
			)
		)
	);


// filter the placeholder text of 'team' post type enter title here
function change_default_title( $title ){
	$screen = get_current_screen();

	if  ( 'team' == $screen->post_type ) {
		$title = 'Add Name';
	}

	return $title;
}

add_filter( 'enter_title_here', 'change_default_title' );



/*-----------------------------------------------------------------------------------*/
/*	  custom meta box of service section 
/*-----------------------------------------------------------------------------------*/ 

$service = register_cuztom_post_type('service', array (
	'supports' => array('title', 'editor'),
	'show_names'  => false, // Show field names on the left
	'menu_icon' => 'dashicons-id'
	));

$service->add_meta_box( 
	'service_setting_id',
	'Service Section Settings', 
	array(
		array(
			'name'          => 'icon',
			'label'         => 'Icon',
			'description'   => 'Write icon class - "li_star, li_lab, li_world" <a target="_blank" href="https://github.com/fontello/linecons.font">Click Here</a>',
			'type'          => 'text'
			),
		array(
			'name'          => 'learn_more',
			'label'         => 'Edit Learn More',
			'description'   => '',
			'type'          => 'text',
			'default_value' => 'Learn More'
			),
		array(
			'name'          => 'animation',
			'label'         => 'Animation',
			'description'   => 'Write the class here like "from-bottom delay-200"',
			'type'          => 'text',
			'default_value' => 'from-bottom delay-200'
			)
		)
	);


/*-----------------------------------------------------------------------------------*/
/*	  portfolio custom post type with  metabox
/*-----------------------------------------------------------------------------------*/ 

$gallery = register_cuztom_post_type('gallery', array(
	'menu_icon' => 'dashicons-analytics',

	'rewrite' => array( 'slug' => 'galleries', 'with_front' => false ),

	'supports' => array('title', 'thumbnail')

	));

$gallery->add_meta_box( 
	'gallery_setting_id',
	'gallery Section Settings', 
	array(
		array(
			'name'          => 'caption',
			'label'         => 'Caption',
			'description'   => 'Write Image Caption',
			'type'          => 'textarea'
			)
		)
	);
$gallery = register_cuztom_taxonomy('filter_menu', array('gallery'), array( 

	'hierarchical' => true,  

	'show_ui' => true,  

	'query_var' => true,  

	'rewrite' => true,  

	));


/*-----------------------------------------------------------------------------------*/
/*	  causes custom post type with  metabox
/*-----------------------------------------------------------------------------------*/ 

$causes = register_cuztom_post_type('causes', array(
	'menu_icon' => 'dashicons-migrate',
	'rewrite' => array( 'slug' => 'causes', 'with_front' => false ),
	'supports' => array('title', 'thumbnail', 'editor')

	));

$causes->add_meta_box( 
	'causes_setting_id',
	'Causes Section Settings', 
	array(
		array(
			'name'          => 'donation_currency_symbol',
			'label'         => 'Currency Symbol',
			'description'   => 'Add your Currency Symbol',
			'default_value' => '$',
			'type'          => 'text'
			),
		array(
			'name'          => 'donation_goal',
			'label'         => 'Donation goal',
			'description'   => 'How much is the donation goal for this cause.',
			'type'          => 'text'
			),
		array(
			'name'          => 'donation_manual',
			'label'         => 'Donate manually',
			'description'   => 'Write manual ammount, that will add with current ammount',
			'type'          => 'text'
			),


		array(
			'name'          => 'donation_paypal',
			'label'         => 'PayPal',
			'description'   => 'Write Your PayPal Id.',
			'type'          => 'text'
			),

		array(
			'name'          => 'bank_transfer_manual',
			'label'         => 'Direct Bank Transfer',
			'description'   => 'Trasfer money to the following bank account (Write the bank account info)',
			'type'          => 'textarea'
			),

		array(
			'name'          => 'chaque_payment',
			'label'         => 'Check Payment',
			'description'   => 'Send chaque to the following address. (Writer the address)',
			'type'          => 'textarea'
			),

		
		array(
			'name'          => 'menual_payment_link',
			'label'         => 'Custom URL/WooCommerce Product link',
			'description'   => "<b style=\"color: red;\">If PayPal Donate field blank, This custom link will work. Paste woocommerce product link</b>",
			'type'          => 'text'
			),


		)
);


/*-----------------------------------------------------------------------------------*/
/*	custom post type of event with meta box 
/*-----------------------------------------------------------------------------------*/ 

$event = register_cuztom_post_type('event', array(	
	'menu_icon' => 'dashicons-art',
	'rewrite' => array( 'slug' => 'events', 'with_front' => false ),
	'supports' => array('title', 'thumbnail', 'editor')
	));

$event ->add_meta_box(
	'events_setting_id',
	'Events Section Settings', 
	array(
		array(
			'name'          => 'event_time',
			'label'         => 'Event Start',
			'description'   => 'When event will start',
			'type'          => 'time'
			),

		array(
			'name'          => 'event_time_end',
			'label'         => 'Event End',
			'description'   => 'When event will end',
			'type'          => 'time'
			),

		array(
			'name'          => 'event_date',
			'label'         => 'Event Date',
			'description'   => 'Event starting date',
			'type'          => 'date'
			),	
		array(
			'name'          => 'event_timezone',
			'label'         => 'Event Timezone',
			'description'   => 'Write Time zone',
			'type'          => 'text',
			),
		array(
			'name'          => 'event_place',
			'label'         => 'Event Place',
			'description'   => 'Where event will held',
			'type'          => 'textarea'
			),
	
		array(
			'name'          => 'event_place_map',
			'label'         => 'Map',
			'description'   => 'write longitude & latitude with coma. <a target="_blank" href="http://www.gps-coordinates.net/">Click here</a> for help.',
			'type'          => 'text'
			)
		)
	);

/*-----------------------------------------------------------------------------------*/
/*	post formate meta box 
/*-----------------------------------------------------------------------------------*/ 

$posts = new Cuztom_Post_Type('post');

$posts->add_meta_box( 
	'post-meta-quote',
	'Page Head', 
	array(
		array(
			'name'          => 'speaker',
			'label'         => 'Who said that',
			'description'   => 'Write the name of speaker name',
			'type'          => 'text'
			)
		)
	);

$posts->add_meta_box( 
	'post-meta-audio',
	'Audio settings', 
	array(
		array(
			'name'          => 'audio',
			'label'         => 'Upload Audio file',
			'description'   => 'It will play above the title',
			'type'          => 'file'
			)
		)
	);

$posts->add_meta_box( 
	'post-meta-video',
	'Video settings', 
	array(
		array(
			'name'          => 'video',
			'label'         => 'Link',
			'description'   => 'It will play above the title',
			'type'          => 'text'
			)
		)
	);



?>