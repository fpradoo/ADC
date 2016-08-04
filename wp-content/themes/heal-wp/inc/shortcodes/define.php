<?php
#-----------------------------------------------------------------
# Columns
#-----------------------------------------------------------------

$ccr_shortcodes = array();

/*-----------------------------------------------------------
    Basic shortcode.
    -----------------------------------------------------------*/
    $ccr_shortcodes['header_1'] = array( 
        'type'=>'heading', 
        'title'=>__('Basic Shortcodes', 'heal')
        );

/*-----------------------------------------------------------
     Pricing table.
     -----------------------------------------------------------*/ 

     $ccr_shortcodes['pricing_table'] = array( 
        'type'=>'dynamic', 
        'title'=>__('Pricing Table', 'heal'),

        'attr'=>array(
            'title'=>array(
                'type'=>'text', 
                'title'=> __('Title', 'heal')
                ),

            'price'=>array(
                'type'=>'text', 
                'title'=> __('Price', 'heal')
                ),        

            'f_des'=>array(
                'type'=>'text', 
                'title'=> __('First Description', 'heal')
                ), 

            's_des'=>array(
                'type'=>'text', 
                'title'=> __('Second Description', 'heal')
                ),
            't_des'=>array(
                'type'=>'text', 
                'title'=> __('Third Description', 'heal')
                ),
            'fth_des'=>array(
                'type'=>'text', 
                'title'=> __('Fourth Description', 'heal')
                ),
            'link'=>array(
                'type'=>'text', 
                'title'=> __('Purchase Link', 'heal')
                )

            )
        );

/*-----------------------------------------------------------
     Service shortcode.
     -----------------------------------------------------------*/ 

     $ccr_shortcodes['service_shortcode'] = array( 
        'type'=>'dynamic', 
        'title'=>__('Service', 'heal'),

        'attr'=>array(
            'icon'=>array(
                'type'=>'text', 
                'title'=> __('Icon', 'heal'),
                ),

            'title'=>array(
                'type'=>'text', 
                'title'=> __('Title', 'heal')
                ),        

            'description'=>array(
                'type'=>'text', 
                'title'=> __('Description', 'heal')
                ), 

            'link'=>array(
                'type'=>'text', 
                'title'=> __('Link', 'heal')
                ),
            'css_class'=>array(
                'type'=>'text', 
                'title'=> __('Write Bootstrap/Animation Class', 'heal')
                )

            )
        );


/**  gallery shortcode.
--------------------------------------------------------------------------------------------------- */


$ccr_shortcodes['heal_gallery'] = array( 
    'type'=>'dynamic', 
    'title'=>__('Gallery', 'heal'),

    'attr'=>array(
        
        'title'=>array(
            'type'=>'text', 
            'title'=> __('Title', 'heal')
            ),        

        'description'=>array(
            'type'=>'text', 
            'title'=> __('Description', 'heal')
            ), 

        'post_no'=>array(
            'type'=>'number', 
            'title'=> __('How many portfolio will display?', 'heal')
            ), 

        'category_slug' => array(

            'type' => 'text',
            'title'=> __('Filter Menu (slug with comma ie- slug1, slug2)', 'heal'),
            )

        )
    );
