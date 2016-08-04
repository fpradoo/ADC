<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: https://docs.reduxframework.com
     * */

    if ( ! class_exists( 'Heal_FrameWord_Redux' ) ) {

        class Heal_FrameWord_Redux {

            public $args = array();
            public $sections = array();
            public $theme;
            public $ReduxFramework;

            public function __construct() {

                if ( ! class_exists( 'ReduxFramework' ) ) {
                    return;
                }

                // This is needed. Bah WordPress bugs.  ;)
                if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                    $this->initSettings();
                } else {
                    add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
                }

            }

            public function initSettings() {

                // Just for demo purposes. Not needed per say.
                $this->theme = wp_get_theme();

                // Set the default arguments
                $this->setArguments();

                // Set a few help tabs so you can see how it's done
                $this->setHelpTabs();

                // Create the sections and fields
                $this->setSections();

                if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                    return;
                }

                $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
            }

            /**
             * This is a test function that will let you see when the compiler hook occurs.
             * It only runs if a field    set with compiler=>true is changed.
             * */


            /**
             * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
             * Simply include this function in the child themes functions.php file.
             * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
             * so you must use get_template_directory_uri() if you want to use any of the built in icons
             * */
            function dynamic_section( $sections ) {
                //$sections = array();
                $sections[] = array(
                    'title'  => __( 'Section via hook', 'heal' ),
                    'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'heal' ),
                    'icon'   => 'el-icon-paper-clip',
                    // Leave this as a blank section, no options just some intro text set above.
                    'fields' => array()
                    );

                return $sections;
            }

            /**
             * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
             * */
            function change_arguments( $args ) {
                //$args['dev_mode'] = true;

                return $args;
            }

            /**
             * Filter hook for filtering the default value of any given field. Very useful in development mode.
             * */
            function change_defaults( $defaults ) {
                $defaults['str_replace'] = 'Testing filter hook!';

                return $defaults;
            }

            // Remove the demo link and the notice of integrated demo from the redux-framework plugin
            function remove_demo() {

                // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
                if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                    remove_filter( 'plugin_row_meta', array(
                        ReduxFrameworkPlugin::instance(),
                        'plugin_metalinks'
                        ), null, 2 );

                    // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                    remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
                }
            }

            public function setSections() {


                ob_start();

                $ct          = wp_get_theme();
                $this->theme = $ct;
                $item_name   = $this->theme->get( 'Name' );
                $tags        = $this->theme->Tags;
                $screenshot  = $this->theme->get_screenshot();
                $class       = $screenshot ? 'has-screenshot' : '';

                $customize_title = sprintf( __( 'Customize &#8220;%s&#8221;', 'heal' ), $this->theme->display( 'Name' ) );

                ?>
                <div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
                    <?php if ( $screenshot ) : ?>
                        <?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
                            <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize"
                               title="<?php echo esc_attr( $customize_title ); ?>">
                               <img src="<?php echo esc_url( $screenshot ); ?>"
                               alt="<?php esc_attr_e( 'Current theme preview', 'heal' ); ?>"/>
                           </a>
                       <?php endif; ?>
                       <img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>"
                       alt="<?php esc_attr_e( 'Current theme preview', 'heal' ); ?>"/>
                   <?php endif; ?>

                   <h4><?php echo $this->theme->display( 'Name' ); ?></h4>

                   <div>
                    <ul class="theme-info">
                        <li><?php printf( __( 'By %s', 'heal' ), $this->theme->display( 'Author' ) ); ?></li>
                        <li><?php printf( __( 'Version %s', 'heal' ), $this->theme->display( 'Version' ) ); ?></li>
                        <li><?php echo '<strong>' . __( 'Tags', 'heal' ) . ':</strong> '; ?><?php printf( $this->theme->display( 'Tags' ) ); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display( 'Description' ); ?></p>
                    <?php
                    if ( $this->theme->parent() ) {
                        printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'heal' ) . '</p>', __( 'http://codex.wordpress.org/Child_Themes', 'heal' ), $this->theme->parent()->display( 'Name' ) );
                    }
                    ?>

                </div>
            </div>

            <?php
            ob_end_clean();
            $sitename = 'http://www.codexcoder.com';
/*-----------------------------------------------------------
    Global Settings.
    -----------------------------------------------------------*/
    $this->sections[] = array(
        'title'  => __( 'Global', 'heal' ),
        'icon'   => 'el-icon-globe',
        'fields' => array(

         array(
            'id'       => 'heal_logo_on_off',
            'type'     => 'switch',
            'title'    => __( 'Logo Section', 'heal' ),
            'default'  => 1,
            'on'       => 'ON',
            'off'      => 'OFF',
            ),

         array(
            'id'       => 'heal_logo',
            'type'     => 'media',
            'url'      => true,
            'indent'   => false, 
            'required' => array( 'heal_logo_on_off', "=", 1 ),
            'default'  => array( 'url' => CC_IMG .'logo.png' ),
            ),

         array(
            'id' => 'heal_favicon_icon',
            'type' => 'media',
            'title' => __('Favicon Icon', 'heal'),
            'default' => array("url" => get_template_directory_uri() . "/assets/images/favicon.png"),
            'preview' => true,
            "url" => true
            ),

         array(
            'id' => 'admin_logo',
            'type' => 'media',
            'title' => __('Admin Logo', 'heal'),
            'default' => array("url" => get_template_directory_uri() . "/assets/images/wp-icon.jpg"),
            'preview' => true,
            "url" => true
            ),


         array(
            'id'       => 'heal_seciton_sorter',
            'type'     => 'sorter',
            'title'    => 'Section Sorting',
            'subtitle' => 'You can sort section and also you can enable or disabled those sections',
            'compiler' => 'true',
            'options'  => array(
                'Enabled'  => array(
                    'about'     => 'About',
                    'team'      => 'Team',
                    'service'   => 'Service',
                    'testimonial'   => 'Testimonial',
                    'gallery'   => 'Gallery',
                    'causes'    => 'Causes',
                    'news'      => 'News',
                    'event'     => 'Event',
                    'client'     => 'Client',
                    'contact'   => 'Contact' 
                    ),
                'Disabled' => array(),
                ),
            ),


         )
); 

 
/*------------------------------------------------------------------------------------------------------------------*/
/*    Header settings 
/*------------------------------------------------------------------------------------------------------------------*/ 

     $this->sections[] = array(
            'title'  => __( 'Header', 'heal' ),
            'icon'   => 'el-icon-circle-arrow-up',
            'fields' => array(


             array(
                'id'       => 'header_style',
                'type'     => 'select_image',
                'title'    => __('Header Style', 'heal'), 
                'subtitle' => __('Select One of header layout.', 'heal'),
                'options'  => array(
                   '1'      =>  array(
                       'alt'  => 'Transparent Header',
                        'img'   => ReduxFramework::$_url.'assets/img/Screenshot.jpg'
                       ),
                   '2'      =>  array(
                       'alt'  => 'Slide Down Style',
                       'img'   => ReduxFramework::$_url.'assets/img/Screenshot2.jpg'
                       )
                    ),
                'default'  => 'http://localhost/codexcoder/heal/wp-content/themes/heal-wp/framework/ReduxCore/assets/img/Screenshot.jpg',
                ),


               ),
    );

/*-----------------------------------------------------------
    slider settings.
    -----------------------------------------------------------*/
    $this->sections[] = array(
        'title'  => __( 'Slider', 'heal' ),
        'icon'   => 'el-icon-slideshare',
        'fields' => array(

         array(
            'id' => 'slider_parallax_control',
            'type' => 'switch',
            'title' => __('Slider Type', 'heal'),
            'default' => '1',
            'off'       => 'Static Slider',
            'on'      => 'Revolution Slider',
            ),
         array(
            'id' => 'slider_revolution',
            'type' => 'text',
            'title' => __('Shortcode', 'heal'),
            'description' => 'Add Revolution Slider. for example [rev_slider homeslider_fullscreen]',
            'default'   => "[rev_slider homepage]",
            'required' => array( 'slider_parallax_control', "=", 1 ),
            ),
         array(
            'id'       => 'heal_slider_section_bg',
            'type'     => 'background',
            'output'   => array( '#top-section' ),
            'title'    => __( 'Image Parallax', 'heal' ),
            'subtitle' => __( 'Upload Slider Parallax Image Here', 'heal' ),
            'transparent' => false,
            'background-color' => false,
            'background-repeat' => false,
            'background-attachment' => false,
            'background-image' => true,
            'background-size' => false,
            'background-position' => false,
            'default' => array(
                'background-image' => CC_IMG . 'no-img-parallax-bg.jpg',
                ),
            'required' => array( 'slider_parallax_control', "=", 0 ),
            ),

         array(
            'id'          => 'heal-slides',
            'type'        => 'slides',
            'required' => array( 'slider_parallax_control', "=", 0 ),
            'title'       => __( 'Slides Options', 'heal' ),
            'subtitle'    => __( 'Unlimited slides with drag and drop sortings. Please use at list 2 slider to see the effects', 'heal' ),
            'show'        => array(
                'upload'     => false,
                'title'     => true,
                'description' => true,
                'url'       => true,
                ),
            'placeholder' => array(
                'title'       => __( 'Button Text', 'heal' ),
                'description' => __( 'Write html text here', 'heal' ),
                'url'         => __( 'Button link', 'heal' ),
                )
            ),


         )
);

/*-----------------------------------------------------------
    About Seciton.
    -----------------------------------------------------------*/

    $this->sections[] = array(
        'icon'   => 'el-icon-adult',
        'title'  => __( 'About', 'heal' ),
        'fields' => array(

           array(
            'id' => 'heal_about_menu',
            'type' => 'text',
            'title' => __('About Menu ', 'heal'),
            'description' => 'Write the title, it will display in menubar *',
            'default'   => "About"
            ),
           array(
            'id' => 'heal_about_title',
            'type' => 'text',
            'title' => __('About Section Title ', 'heal'),
            'description' => 'Write the title, it will display in about section *',
            'default'   => "About"
            ),
           array(
            'id' => 'heal_about_des',
            'type' => 'editor',
            'title' => __('About Section Description ', 'heal'),
            'description' => 'Write the description, it will display in about section *',
            'default'   => "HEAL IS A CHARITY WEBSITE TEMPLATE AND A NOON PROFIT ORGANIZATION WORK WORLDWIDE FOR CHILDREN IN THE BANNER OF \"SAVE THE CHILDREN\". WE HELP THE CHILDREN FOR PROPER PHYSICAL AND MENTAL GROWTH."
            ),

           array(
            'id'   => 'opt-divide',
            'type' => 'divide'
            ),

           array(
            'id'     => 'heal-info-normal',
            'type'   => 'info',
            'notice' => false,
            'title'  => __( '<strong>Story Section</strong>', 'heal' ),
            ),

           array(
            'id' => 'heal_story_title',
            'type' => 'text',
            'title' => __('Story Title', 'heal'),
            'description' => 'Write the title, it will display in about section *',
            'default'   => "OUR STORY"
            ),
           array(
            'id' => 'heal_story_icon',
            'type' => 'text',
            'title' => __('Story Icon Class', 'heal'),
            'description' => 'Write the the class of icon, to get icon <a target="_blank" href="https://github.com/fontello/linecons.font">Click Here</a>  * You can add Font Awesome icon also. for example: "fa fa-facebook".',
            'default'   => "li_bulb"
            ),

           array(
            'id' => 'heal_story_des',
            'type' => 'textarea',
            'title' => __('Story Description', 'heal'),
            'description' => 'Write your html code, it will show on story desctiption section *',
            'args'   => array(
                'teeny'            => false,
                'dfw'               => true,
                'textarea_rows'    => 10
                ),
            'default'   => "<p><strong>10 Years long run, we are working for the welfare of children. It was a little step, but now this is a big organization and worldwide activity as a child welfare non-profit organization.</strong></p>
            <p>We felt the risky environment and circumstances for children over the world. Then we started working for them in a village. Day after day, we received a delightful response from the people who keep our thinking in their mind. Now, we are helping children in more than 100 countries and huge volunteers are working worldwide.</p>"
            ),


array(
    'id'          => 'heal_story_slides',
    'type'        => 'slides',
    'title'       => __( 'Story Section Slider', 'heal' ),
    'show'        => array(
        'title'     => false,
        'description' => false,
        'url'       => false,
        ),
    'desc'        => __( 'This slider will display right side of story section', 'heal' ),
    ),

array(
    'id'     => 'heal-story-settings-heading',
    'type'   => 'info',
    'notice' => false,
    'title'  => __( 'Angular-Linear Settings', 'heal' ),
    ),

array(
    'id' => 'heal_about_color_scheam',
    'type' => 'background',
    'transparent' => false,
    'background-color' => true,
    'background-repeat' => false,
    'background-attachment' => false,
    'background-image' => false,
    'background-size' => false,
    'background-position' => false,
    'output'   => array('.about-section .white-bg,.about-section .white-bg.angular .top-angle:before'),
    'title' => __('About Section Background color', 'heal'),
    ),
array(
    'id' => 'heal_about_font_color_scheam',
    'type' => 'color',
    'transparent' => false,
    'output'   => array('.about-section .white-bg .section-description,.about-section .white-bg .section-title,.about-section .white-bg .section-content,.about-section .white-bg .content-title'),
    'title' => __('About Section Font color', 'heal'),
    ),

array(
    'id' => 'heal_about_agular',
    'type' => 'switch',
    'title' => __('Anglular/Linear', 'heal'),
    'default' => '1',
    'on'       => 'Linear',
    'off'      => 'Angular',
    ),

array(
    'id' => 'heal_about_lr_agular',
    'type' => 'switch',
    'title' => __('Left/Right', 'heal'),
    'default' => '1',
    'required' => array( 'heal_about_agular', "=", 0 ),
    'on'       => 'Right',
    'off'      => 'Left',
    ),

array(
    'id'     => 'heal-info-normal',
    'type'   => 'info',
    'notice' => false,
    'title'  => __( '<strong>Mission Section</strong>', 'heal' ),
    ),

array(
    'id' => 'heal_mission_title',
    'type' => 'text',
    'title' => __('Mission Title', 'heal'),
    'description' => 'Write the title, it will display in Mission section *',
    'default'   => "OUR MISSION"
    ),
array(
    'id' => 'heal_mission_icon',
    'type' => 'text',
    'title' => __('Mission Icon Class', 'heal'),
    'description' => 'Write the the class of icon, to get icon <a target="_blank" href="https://github.com/fontello/linecons.font">Click Here</a> |  You can add Font Awesome icon also. for example: "fa fa-facebook".',
    'default'   => "li_params"
    ),

array(
    'id' => 'heal_mission_des',
    'type' => 'textarea',
    'title' => __('Mission Description', 'heal'),
    'description' => 'Write your html code, it will show on Mission Desctiption section *',
    'default'   => "<p><strong>We dream about a new world for the children with no harm. We are aiming to build a strong and a bouncing platform where anyone can work for children worldwide.</strong></p>
    <p>Together, we're going to make the future of the children where we are able to fulfill all of their requirements to keep them safe from withered world. We have already stepped out and start changing the world. Keeping safe them from war, inhumanity, Child labor, child abuse and more what we feel harmful for them.</p>"
    ),

array(
    'id'       => 'heal_mission_on_off',
    'type'     => 'switch',
    'title'    => __( 'Video Type', 'heal' ),
    'default'  => 1,
    'on'       => 'Youtube',
    'off'      => 'MP4',
    ),

array(
    'id' => 'heal_mission_youtube',
    'type' => 'text',
    'title' => __('Write Youtube URL', 'heal'),
    'required' => array( 'heal_mission_on_off', "=", 1 ),
    'description' => 'Just paste your youtube video link here *',
    'default'   => "//www.youtube.com/embed/WOC5kHtn_x4"
    ),


array(
    'id' => 'heal_mission_mp4',
    'type' => 'media',
    'url'      => true,
    'mode'      => false,
    'preview'   => false,
    'required' => array( 'heal_mission_on_off', "=", 0 ),
    'title' => __('Mission Video Upload', 'heal'),
    'description' => 'Upload MP4 video file here *'
    ),


array(
    'id'     => 'heal-mission-settings-heading',
    'type'   => 'info',
    'notice' => false,
    'title'  => __( 'Angular-Linear Settings', 'heal' ),
    ),

array(
    'id' => 'heal_mission_color_scheam',
    'type' => 'background',
    'transparent' => false,
    'background-color' => true,
    'background-repeat' => false,
    'background-attachment' => false,
    'background-image' => false,
    'background-size' => false,
    'background-position' => false,
    'output'   => array('.about-section .gray-bg,.about-section .gray-bg.angular .top-angle:before'),
    'title' => __('Mission Section Background color', 'heal'),
    ),
array(
    'id' => 'heal_mission_font_color_scheam',
    'type' => 'color',
    'transparent' => false,
    'output'   => array('.about-section .section-description,.about-section  .section-title,.about-section .section-content,.about-section .content-title'),
    'title' => __('Mission Section Font color', 'heal'),
    ),

array(
    'id' => 'heal_mission_agular',
    'type' => 'switch',
    'title' => __('Anglular/Linear', 'heal'),
    'default' => '1',
    'on'       => 'Linear',
    'off'      => 'Angular',
    ),

array(
    'id' => 'heal_mission_lr_agular',
    'type' => 'switch',
    'title' => __('Left/Right', 'heal'),
    'default' => '1',
    'required' => array( 'heal_mission_agular', "=", 0 ),
    'on'       => 'Right',
    'off'      => 'Left',
    ),



)
);

/*-----------------------------------------------------------
    team section.
    -----------------------------------------------------------*/

    $this->sections[] = array(
        'icon'   => 'el-icon-myspace',
        'title'  => __( 'Team', 'heal' ),
        'fields' => array(

            array(
                'id' => 'heal_team_menu',
                'type' => 'text',
                'title' => __('Team Menu', 'heal'),
                'description' => 'Write the title, it will display in menubar *',
                'default'   => "Team"
                ),
            array(
                'id' => 'heal_team_title',
                'type' => 'text',
                'title' => __('Team Section Title ', 'heal'),
                'description' => 'Write the title, it will display in team section *',
                'default'   => "Team"
                ),
            array(
                'id' => 'heal_team_des',
                'type' => 'editor',
                'title' => __('Team Section Description ', 'heal'),
                'description' => 'Write the Description, it will display in team section *',
                'default'   => "WE WORK WORLDWIDE, HAVE A BIG TEAM WORKING DEDICATEDLY TO SAVE THE CHILD. THE TEAM CONSIST OF EXPERTS WHO FEEL CHILDREN'S' DANGER AND ENJOY THE WORK."
                ),

            array(
                'id' => 'heal_team_no',
                'type' => 'text',
                'title' => __('Display Team Member', 'heal'),
                'description' => 'How many team member will display in homepage. Default 4',
                'default'   => 4
                ),

            array(
                'id'     => 'opt-info-normal',
                'type'   => 'info',
                'notice' => true,
                'title'  => __( 'For Add Your Team Member, Please <a href="'.home_url().'/wp-admin/post-new.php?post_type=team">Click Here</a>', 'heal' ),

                ),

            array(
                'id'     => 'heal-team-settings-heading',
                'type'   => 'info',
                'notice' => false,
                'title'  => __( 'Angular-Linear Settings', 'heal' ),
                ),

            array(
                'id' => 'heal_team_color_scheam',
                'type' => 'background',
                'transparent' => false,
                'background-color' => true,
                'background-repeat' => false,
                'background-attachment' => false,
                'background-image' => false,
                'background-size' => false,
                'background-position' => false,
                'output'   => array('.team-section .white-bg,.team-section .white-bg.angular .top-angle:before'),
                'title' => __('Team Section Background color', 'heal'),
                ),
            array(
                'id' => 'heal_team_font_color_scheam',
                'type' => 'color',
                'transparent' => false,
                'output'   => array('.team-section .section-description,.team-section .section-title,.team-section .section-content,.team-section .content-title, .team-member-box .member-name, .team-member-box .member-designation, .team-member-box'),
                'title' => __('Team Section Font color', 'heal'),
                ),

            array(
                'id' => 'heal_team_agular',
                'type' => 'switch',
                'title' => __('Anglular/Linear', 'heal'),
                'default' => '1',
                'on'       => 'Linear',
                'off'      => 'Angular',
                ),

            array(
                'id' => 'heal_team_lr_agular',
                'type' => 'switch',
                'title' => __('Left/Right', 'heal'),
                'default' => '1',
                'required' => array( 'heal_team_agular', "=", 0 ),
                'on'       => 'Right',
                'off'      => 'Left',
                ),


            array(
                'id'     => 'heal-info-normal',
                'type'   => 'info',
                'notice' => false,
                'title'  => __( '<strong>Volunteer Section</strong>', 'heal' ),
                ),

            array(
                'id' => 'heal_volunteer_off_on',
                'type' => 'switch',
                'title' => __('ON/OFF', 'heal'),
                'default' => '1',
                'on'       => 'ON',
                'off'      => 'OFF',
                ),


            array(
                'id' => 'heal_team_volunteer_title',
                'type' => 'text',   
                'required' => array( 'heal_volunteer_off_on', "=", 1 ),
                'title' => __('Volunteer Title ', 'heal'),
                'description' => 'Write the title, it will display in volunteer section *',
                'default'   => "Become a Volunteer"
                ),
            array(
                'id' => 'heal_team_volunteer_des',
                'type' => 'textarea',
                'required' => array( 'heal_volunteer_off_on', "=", 1 ),
                'title' => __('Description ', 'heal'),
                'description' => 'Write the Description, it will display in team section *',
                'default'   => "<p><strong>Do you like to work for children? Do you feel the slogan \"Save the Children\". Yes. Here, you are welcome to our team and you can work as a volunteer.</strong></p>
                <p>At first, you have to submit your information and apply for becoming a volunteer. We will review your information within a few days and then contact with you. After finalizing your information, a confirmation message will send to you with necessary documents.</p>"
                ),

            array(
                'id' => 'heal_team_volunteer_icon',
                'type' => 'text',   
                'required' => array( 'heal_volunteer_off_on', "=", 1 ),
                'title' => __('Volunteer Icon ', 'heal'),
                'description' => 'Add volunteer section linecons.  You can add Font Awesome icon also. for example: "fa fa-facebook".',
                'default'   => "li_user"
                ),

            array(
                'id' => 'heal_team_volunteer_img',
                'type' => 'media',
                'required' => array( 'heal_volunteer_off_on', "=", 1 ),
                'url'      => true,
                'mode'      => false,
                'preview'   => true,
                'title' => __('Upload', 'heal'),
                'default' => array(
                    'url'=> CC_IMG . 'no-img-parallax-bg.jpg',
                    )
                ),

            array(
                'id' => 'heal_team_volunteer_text_link',
                'type' => 'text',
                'required' => array( 'heal_volunteer_off_on', "=", 1 ),
                'title' => __('Button Text ', 'heal'),
                'description' => 'Write the URL, it will display in apply now button *',
                'default'   => "APPLY NOW"
                ),

            array(
                'id' => 'heal_team_volunteer_link',
                'type' => 'text',
                'required' => array( 'heal_volunteer_off_on', "=", 1 ),
                'title' => __('URL ', 'heal'),
                'description' => 'Write the URL, it will display in apply now button *',
                'default'   => "#"
                ),

             array(
            'id'     => 'heal-volun-settings-heading',
            'type'   => 'info',
            'notice' => false,
            'title'  => __( 'Angular-Linear Settings', 'heal' ),
            ),

            array(
                'id' => 'heal_volunteer_color_scheam',
                'type' => 'background',
                'transparent' => false,
                'required' => array( 'heal_volunteer_off_on', "=", 1 ),
                'background-color' => true,
                'background-repeat' => false,
                'background-attachment' => false,
                'background-image' => false,
                'background-size' => false,
                'background-position' => false,
                'output'   => array('.volunteer-section .gray-bg,.volunteer-section .gray-bg.angular .top-angle:before'),
                'title' => __('Volunteer Section Background color', 'heal'),
                ),
            array(
                'id' => 'heal_volunteer_font_color_scheam',
                'type' => 'color',
                'required' => array( 'heal_volunteer_off_on', "=", 1 ),
                'transparent' => false,
                'output'   => array('.volunteer-section .section-description,.volunteer-section .section-title,.volunteer-section .section-content,.volunteer-section .content-title'),
                'title' => __('Volunteer Section Font color', 'heal'),
                ),

            array(
                'id' => 'heal_volunteer_agular',
                'type' => 'switch',
                'required' => array( 'heal_volunteer_off_on', "=", 1 ),
                'title' => __('Anglular/Linear', 'heal'),
                'default' => '1',
                'on'       => 'Linear',
                'off'      => 'Angular',
                ),

            array(
                'id' => 'heal_volunteer_lr_agular',
                'type' => 'switch',
                'title' => __('Left/Right', 'heal'),
                'default' => '1',
                'required' => array( 'heal_volunteer_agular', "=", 0 ),
                'on'       => 'Right',
                'off'      => 'Left',
                ),
            )
);

/*-----------------------------------------------------------
    Service Section.
    -----------------------------------------------------------*/

    $this->sections[] = array(
        'icon'   => 'el-icon-bullhorn',
        'title'  => __( 'Service', 'heal' ),
        'fields' => array(

         array(
            'id' => 'heal_service_menu',
            'type' => 'text',
            'title' => __('Service Menu ', 'heal'),
            'description' => 'Write the title, it will display in menubar *',
            'default'   => "Service"
            ),

         array(
            'id' => 'heal_service_title',
            'type' => 'text',
            'title' => __('Service Section Title ', 'heal'),
            'description' => 'Write the title, it will display in service section *',
            'default'   => "SERVICES"
            ),

         array(
            'id' => 'heal_service_des',
            'type' => 'editor',
            'title' => __('Service Section Description ', 'heal'),
            'description' => 'Write the Description, it will display in service section *',
            'default'   => "ALL OF OUR SERVICES IS CENTRALIZED TO THE WELFARE OF THE CHILDREN. WE SERVE THE CHILD WITH FOOD, EDUCATION, HABITATION, SAFETY AND EVERYTHING THE NEED."
            ),
         array(
            'id'     => 'opt-info-normal',
            'type'   => 'info',
            'notice' => true,
            'title'  => __( 'For Add Your Service, Please <a href="'.home_url().'/wp-admin/post-new.php?post_type=service">Click Here</a>', 'heal' ),

            ),

         array(
            'id'   => 'opt-divide',
            'type' => 'divide'
            ),
         array(
            'id' => 'heal_service_color_scheam',
            'type' => 'background',
            'transparent' => false,
            'background-color' => true,
            'background-repeat' => false,
            'background-attachment' => false,
            'background-image' => false,
            'background-size' => false,
            'background-position' => false,
            'output'   => array('.services-section.white-bg, .services-section.white-bg.angular .top-angle:before'),
            'title' => __('Service Section Background color', 'heal'),
            ),
         array(
            'id' => 'heal_service_font_color_scheam',
            'type' => 'color',
            'transparent' => false,
            'output'   => array('.services-section .section-description,.services-section .section-title,.services-section .section-content,.services-section .content-title'),
            'title' => __('Service Section Font color', 'heal'),
            ),

         array(
            'id' => 'heal_service_agular',
            'type' => 'switch',
            'title' => __('Anglular/Linear', 'heal'),
            'default' => '1',
            'on'       => 'Linear',
            'off'      => 'Angular',
            ),

         array(
            'id' => 'heal_service_lr_agular',
            'type' => 'switch',
            'title' => __('Left/Right', 'heal'),
            'default' => '1',
            'required' => array( 'heal_service_agular', "=", 0 ),
            'on'       => 'Right',
            'off'      => 'Left',
            ),

         // array(
         //    'id'     => 'opt-info-normal',
         //    'type'   => 'info',
         //    'notice' => false,
         //    'title'  => __( 'Guardian Section', 'heal' ),

         //    ),

         array(
            'id'     => 'opt-info-normal',
            'type'   => 'info',
            'notice' => false,
            'title'  => __( 'Pricing Table', 'heal' ),

            ),


         array(
            'id' => 'heal_pricing_on_off',
            'type' => 'switch',
            'title' => __('ON/OFF', 'heal'),
            'default' => '1',
            'on'       => 'On',
            'off'      => 'Off',
            ),

         array(
            'id' => 'heal_guardian_title',
            'type' => 'text',
            'title' => __('Guardian Title', 'heal'),
            'description' => 'Write the title, it will display in Guardian section *',
            'default'   => "BECOME A GUARDIAN"
            ), 

         array(
            'id' => 'heal_guardian_des',
            'type' => 'editor',
            'title' => __('Guardian Description ', 'heal'),
            'description' => 'Write the description, it will display in Guardian section *',
            'default'   => "It is a big opportunity to work with us having a guardianship. We cordially offer you for becoming a guardian of orphans and help them to keep them safe."
            ), 

         array(
            'id' => 'heal_team_guardian_icon',
            'type' => 'text',   
            'title' => __('Pricing section Icon ', 'heal'),
            'description' => 'Add Pricing section linecons. To get icon <a target="_blank" href="https://github.com/fontello/linecons.font">Click Here</a> |  You can add Font Awesome icon also. for example: "fa fa-facebook".',
            'default'   => "li_banknote"
            ),

         array(
            'id'   => 'opt-divide',
            'type' => 'divide'
            ),

         array(
            'id' => 'heal_basic_pricing_title',
            'type' => 'text',
            'title' => __('Basic Pricing Table ', 'heal'),
            'description' => 'Write the title, it will display in pricing table title *',
            'default'   => "BASIC"
            ),

         array(
            'id' => 'heal_basic_pricing_price',
            'type' => 'text',
            'title' => __('Price ', 'heal'),
            'description' => 'Write price, it will display in pricing table price section *',
            'default'   => "$35"
            ),

         array(
            'id'       => 'heal_pricing_des',
            'type'     => 'editor',
            'title'    => __( 'Desctiption', 'heal' ),
            'subtitle' => __('Input list style for work', 'heal' ),
            'desc'     => __( 'This is basic pricing table example, Use list style for this section', 'heal' ),
            'default'  => '<ul><li>First Description</li>
            <li>Second Description</li>
            <li>Third Description</li>
            <li>Fourth Description</li></ul>
            '
            ), 

         array(
            'id' => 'heal_basic_pricing_price_button_text',
            'type' => 'text',
            'title' => __('Button Text ', 'heal'),
            'description' => 'Write The Custom Payment text',
            'default'   => "Purchase"
            ),

         array(
            'id' => 'heal_basic_pricing_price_link',
            'type' => 'text',
            'title' => __('Link ', 'heal'),
            'description' => 'Write The Custom Payment Link',
            'default'   => "#"
            ),
         array(
            'id'   => 'opt-divide',
            'type' => 'divide'
            ),
         array(
            'id' => 'heal_gold_pricing_title',
            'type' => 'text',
            'title' => __('Gold Pricing Table ', 'heal'),
            'description' => 'Write the title, it will display in pricing table title *',
            'default'   => "GOLD"
            ),

         array(
            'id' => 'heal_gold_pricing_price',
            'type' => 'text',
            'title' => __('Price ', 'heal'),
            'description' => 'Write price, it will display in pricing table price section *',
            'default'   => "$99"
            ),

         array(
            'id'       => 'heal_gold_pricing_des',
            'type'     => 'editor',
            'title'    => __( 'Desctiption', 'heal' ),
            'subtitle' => __('list style system', 'heal' ),
            'desc'     => __( 'This is basic pricing table example, Use list style for this section', 'heal' ),
            'default'  => '<ul><li>First Description</li>
            <li>Second Description</li>
            <li>Third Description</li>
            <li>Fourth Description</li></ul>
            '
            ), 

         array(
            'id' => 'heal_gold_pricing_price_button_text',
            'type' => 'text',
            'title' => __('Button Text ', 'heal'),
            'description' => 'Write The Custom Payment text',
            'default'   => "Purchase"
            ),

         array(
            'id' => 'heal_gold_pricing_price_link',
            'type' => 'text',
            'title' => __('Link ', 'heal'),
            'description' => 'Write The Custom Payment Link',
            'default'   => "#"
            ),
         array(
            'id'   => 'opt-divide',
            'type' => 'divide'
            ),
         array(
            'id' => 'heal_silver_pricing_title',
            'type' => 'text',
            'title' => __('Silver Pricing Table ', 'heal'),
            'description' => 'Write the title, it will display in pricing table title *',
            'default'   => "SILVER"
            ),

         array(
            'id' => 'heal_silver_pricing_price',
            'type' => 'text',
            'title' => __('Price ', 'heal'),
            'description' => 'Write price, it will display in pricing table price section *',
            'default'   => "$65"
            ),

         array(
            'id'       => 'heal_silver_pricing_des',
            'type'     => 'editor',
            'title'    => __( 'Desctiption', 'heal' ),
            'subtitle' => __('list style system', 'heal' ),
            'desc'     => __( 'This is basic pricing table example, Use list style for this section', 'heal' ),
            'default'  => '<ul><li>First Description</li>
            <li>Second Description</li>
            <li>Third Description</li>
            <li>Fourth Description</li></ul>
            '
            ), 

         array(
            'id' => 'heal_silver_pricing_price_button_text',
            'type' => 'text',
            'title' => __('Button Text ', 'heal'),
            'description' => 'Write The Custom Payment text',
            'default'   => "Purchase"
            ),

         array(
            'id' => 'heal_silver_pricing_price_link',
            'type' => 'text',
            'title' => __('Link ', 'heal'),
            'description' => 'Write The Custom Payment Link',
            'default'   => "#"
            ),

         array(
            'id'     => 'heal-pricing-settings-heading',
            'type'   => 'info',
            'notice' => false,
            'title'  => __( 'Angular-Linear Settings', 'heal' ),
            ),


         array(
            'id' => 'heal_service_pricing_color_scheam',
            'type' => 'background',
            'transparent' => false,
            'background-color' => true,
            'background-repeat' => false,
            'background-attachment' => false,
            'background-image' => false,
            'background-size' => false,
            'background-position' => false,
            'output'   => array('.pricing-section .gray-bg, .pricing-section .gray-bg.angular .top-angle:before'),
            'title' => __('Pricing Section Background color', 'heal'),
            ),
         array(
            'id' => 'heal_service_pricing_font_color_scheam',
            'type' => 'color',
            'transparent' => false,
            'output'   => array('.pricing-section .content-box, .pricing-section .content-title,.pricing-item .item-name, .pricing-item .item-currency, .pricing-item .item-price, .pricing-item .item-description li'),
            'title' => __('Pricing table Section Font color', 'heal'),
            ),

         array(
            'id' => 'heal_service_pricing_agular',
            'type' => 'switch',
            'title' => __('Anglular/Linear', 'heal'),
            'default' => '1',
            'on'       => 'Linear',
            'off'      => 'Angular',
            ),

         array(
            'id' => 'heal_service_pricing_lr_agular',
            'type' => 'switch',
            'title' => __('Left/Right', 'heal'),
            'default' => '1',
            'required' => array( 'heal_service_pricing_agular', "=", 0 ),
            'on'       => 'Right',
            'off'      => 'Left',
            ),



         )
);

/*-----------------------------------------------------------
    Testimonial Section.
    -----------------------------------------------------------*/   

    $this->sections[] = array(
        'icon'   => 'el-icon-file-edit',
        'title'  => __( 'Testimonial', 'heal' ),
        'fields' => array(
            array(
                'id' => 'heal_testimonial_on_off',
                'type' => 'switch',
                'title' => __('Testimonial on off', 'heal'),
                'default' => '0',
                'on'       => 'Enable',
                'off'      => 'Disable',
                ),

            array(
                'id' => 'heal_team_testimonial_parallax',
                'type' => 'background',
                'required' => array( 'heal_testimonial_on_off', "=", 1 ),
                'transparent' => false,
                'background-color' => false,
                'background-repeat' => false,
                'background-attachment' => false,
                'background-image' => true,
                'background-size' => false,
                'background-position' => false,
                'output'   => array('#testimonial'),
                'title' => __('Testimonial Parallax', 'heal'),
                'default' => array(
                    'background-image'=> CC_IMG . 'no-img-parallax-bg.jpg',
                    )
                ),
            array(
                'id'          => 'heal_testimonial_slides',
                'type'        => 'slides',
                'required' => array( 'heal_testimonial_on_off', "=", 1 ),
                'title'       => __( 'Add Testimonial', 'heal' ),
                'subtitle'    => __( 'Add testimonial, it will display in testimonial section', 'heal' ),
                'show'        => array(
                    'title'     => true,
                    'description' => true,
                    'url'       => false,
                    ),
                'placeholder' => array(
                    'title'       => __( 'Write the name', 'heal' ),
                    'description' => __( 'Write his testimonial', 'heal' ),
                    )
                ),

            array(
                'id'     => 'heal-angular-linear-settings-heading',
                'type'   => 'info',
                'notice' => false,
                'required' => array( 'heal_testimonial_on_off', "=", 1 ),
                'title'  => __( 'Angular-Linear Settings', 'heal' ),
                ),


            array(
                'id' => 'heal_testimonial_agular',
                'type' => 'switch',
                'required' => array( 'heal_testimonial_on_off', "=", 1 ),
                'title' => __('Anglular/Linear', 'heal'),
                'default' => '1',
                'on'       => 'Linear',
                'off'      => 'Angular',
                ),

            array(
                'id' => 'heal_testimonial_lr_agular',
                'type' => 'switch',
                'title' => __('Left/Right', 'heal'),
                'default' => '1',
                'required' => array( 'heal_testimonial_agular', "=", 0 ),
                'on'       => 'Right',
                'off'      => 'Left',
                ),

            array(
                'id' => 'heal_testimonial_color_scheam',
                'type' => 'background',
                'required' => array( 'heal_testimonial_agular', "=", 0 ),
                'transparent' => false,
                'background-color' => true,
                'background-repeat' => false,
                'background-attachment' => false,
                'background-image' => false,
                'background-size' => false,
                'background-position' => false,
                'output'   => array('.testimonial-section .angular .top-angle:before'),
                'title' => __('Testimonial Angle color', 'heal'),
                ),
            array(
                'id' => 'heal_testimonial_font_color_scheam',
                'type' => 'color',
                'required' => array( 'heal_testimonial_agular', "=", 0 ),
                'transparent' => false,
                'output'   => array('.testimonial-figure .parallax-title, .testimonial-figure .authors-review'),
                'title' => __('Testimonial Section Font color', 'heal'),
                ),

            )
);

/*-----------------------------------------------------------
    Gallery Section.
    -----------------------------------------------------------*/

    $this->sections[] = array(
        'icon'   => 'el-icon-folder-close',
        'title'  => __( 'Gallery', 'heal' ),
        'fields' => array(

         array(
            'id' => 'heal_gallery_menu',
            'type' => 'text',
            'title' => __('Gallery Menu ', 'heal'),
            'description' => 'Write the title, it will display in menubar *',
            'default'   => "Gallery"
            ),

         array(
            'id' => 'heal_gallery_title',
            'type' => 'text',
            'title' => __('Gallery Section Title ', 'heal'),
            'description' => 'Write the title, it will display in gallery section *',
            'default'   => "Gallery"
            ),

         array(
            'id' => 'heal_gallery_des',
            'type' => 'editor',
            'title' => __('Gallery Section Description ', 'heal'),
            'description' => 'Write the Description, it will display in gallery description section *',
            'default'   => "TAKE A LOOK AT OUR GALLERY TO SEE HOW WE ENDANGER THE CHILD. YOU MAY ALSO SEE OUR WORLDWIDE ACTIVITY AROUND THE GLOBE HOW WE WORKING FOR CHILDREN."
            ),
         array(
            'id' => 'heal_gallery_post_no',
            'type' => 'text',
            'title' => __('Number Of Image', 'heal'),
            'description' => 'Write the Number of How many image you want to display in gallery section? ',
            'default'   => "8"
            ),
         array(
            'id'     => 'opt-info-normal',
            'type'   => 'info',
            'notice' => true,
            'title'  => __( 'For Adding Your Gallery, Please <a href="'.home_url().'/wp-admin/post-new.php?post_type=gallery">Click Here</a>', 'heal' ),

            ),

         array(
            'id'     => 'heal-angular-linear-settings-heading',
            'type'   => 'info',
            'notice' => false,
            'title'  => __( 'Angular-Linear Settings', 'heal' ),
            ),
         array(
            'id' => 'heal_gallery_color_scheam',
            'type' => 'background',
            'transparent' => false,
            'background-color' => true,
            'background-repeat' => false,
            'background-attachment' => false,
            'background-image' => false,
            'background-size' => false,
            'background-position' => false,
            'output'   => array('.gallery-section.white-bg, .gallery-section.white-bg.angular .top-angle:before'),
            'title' => __('Gallery Section Background color', 'heal'),
            ),
         array(
            'id' => 'heal_gallery_font_color_scheam',
            'type' => 'color',
            'transparent' => false,
            'output'   => array('.gallery-section .section-title, .gallery-section .section-description, .galleryFilter a:focus, .galleryFilter a:hover, .galleryFilter .current, .gallery-item figure .item-title, .gallery-item figure .item-title a, .gallery-item .gallery-item-description'),
            'title' => __('Gallery Section Font color', 'heal'),
            ),

         array(
            'id' => 'heal_gallery_agular',
            'type' => 'switch',
            'title' => __('Anglular/Linear', 'heal'),
            'default' => '1',
            'on'       => 'Linear',
            'off'      => 'Angular',
            ),

         array(
            'id' => 'heal_gallery_lr_agular',
            'type' => 'switch',
            'title' => __('Left/Right', 'heal'),
            'default' => '1',
            'required' => array( 'heal_gallery_agular', "=", 0 ),
            'on'       => 'Right',
            'off'      => 'Left',
            ),



         )
);

/*-----------------------------------------------------------
    Causes Section.
    -----------------------------------------------------------*/

    $this->sections[] = array(
        'icon'   => 'el-icon-paper-clip',
        'title'  => __( 'Causes', 'heal' ),
        'fields' => array(

         array(
            'id' => 'heal_causes_menu',
            'type' => 'text',
            'title' => __('Causes Menu ', 'heal'),
            'description' => 'Write the title, it will display in menubar *',
            'default'   => "Causes"
            ),
         array(
            'id' => 'heal_causes_title',
            'type' => 'text',
            'title' => __('Causes Section Title ', 'heal'),
            'description' => 'Write the title, it will display in causes section *',
            'default'   => "CAUSESS WE PROVIDE"
            ),
         array(
            'id' => 'heal_causes_des',
            'type' => 'editor',
            'title' => __('Causes Section Description ', 'heal'),
            'description' => 'Write the Description, it will display in causes section *',
            'default'   => "We have a fixed plan to improve the child world. Moreover, we are careful about the sudden disaster and harmful environment."
            ),
         array(
            'id' => 'heal_causes_icon',
            'type' => 'text',
            'title' => __('Causes Section Icon ', 'heal'),
            'description' => 'Write the icon class, it will display in causes section *',
            'default'   => "li_megaphone"
            ),

         array(
            'id'     => 'opt-info-normal',
            'type'   => 'info',
            'notice' => true,
            'title'  => __( 'For Adding Your Causes, Please <a href="'.home_url().'/wp-admin/post-new.php?post_type=causes">Click Here</a>', 'heal' ),

            ),

         array(
            'id'     => 'heal-angular-linear-settings-heading',
            'type'   => 'info',
            'notice' => false,
            'title'  => __( 'Angular-Linear Settings', 'heal' ),
            ),
         array(
            'id' => 'heal_causes_color_scheam',
            'type' => 'background',
            'transparent' => false,
            'background-color' => true,
            'background-repeat' => false,
            'background-attachment' => false,
            'background-image' => false,
            'background-size' => false,
            'background-position' => false,
            'output'   => array('.causes-section.gray-bg, .causes-section.gray-bg.angular .top-angle:before'),
            'title' => __('Causes Section Background color', 'heal'),
            ),
         array(
            'id' => 'heal_causes_font_color_scheam',
            'type' => 'color',
            'transparent' => false,
            'output'   => array('.causes-section .content-title, .causes-section .content-description, .causes-section .causes-post-title, .causes-section .post-text'),
            'title' => __('Causes Section Font color', 'heal'),
            ),

         array(
            'id' => 'heal_causes_agular',
            'type' => 'switch',
            'title' => __('Anglular/Linear', 'heal'),
            'default' => '1',
            'on'       => 'Linear',
            'off'      => 'Angular',
            ),

         array(
            'id' => 'heal_causes_lr_agular',
            'type' => 'switch',
            'title' => __('Left/Right', 'heal'),
            'default' => '1',
            'required' => array( 'heal_causes_agular', "=", 0 ),
            'on'       => 'Right',
            'off'      => 'Left',
            ),




         )
);


/*-----------------------------------------------------------
    Donation Settings.
    -----------------------------------------------------------*/

    $this->sections[] = array(
        'icon'   => 'el-icon-adjust-alt',
        'title'  => __( 'Donation', 'heal' ),
        'fields' => array(
            array(
                'id' => 'heal_donation_on_off',
                'type' => 'switch',
                'title' => __('ON/OFF', 'heal'),
                'default' => '1',
                'on'       => 'On',
                'off'      => 'Off',
                ),


            array(
                'id' => 'heal_donation_button_on_off',
                'type' => 'switch',
                'required' => array( 'heal_donation_on_off', "=", 1 ),
                'title' => __('Menubar Donate Button', 'heal'),
                'default' => '1',
                'on'       => 'Default',
                'off'      => 'Menual',
                ),

            array(
                'id' => 'heal_donation_menual_url',
                'type' => 'text',
                'required' => array( 'heal_donation_button_on_off', "=", 0 ),
                'title' => __('Custom Donation URL', 'heal'),
                'description' => 'Write your menual link.. This link will active top menubar donate button.',
                'default'   => "#"
                ),


            array(
                'id'       => 'heal_about_donation_parallax',
                'type'     => 'background',
                'output'   => array( '.donate-bg' ),
                'title'    => __( 'Image Parallax', 'heal' ),
                'subtitle' => __( 'Upload Slider Parallax Image', 'heal' ),
                'transparent' => false,
                'background-color' => false,
                'background-repeat' => false,
                'background-attachment' => false,
                'background-image' => true,
                'background-size' => false,
                'background-position' => false,
                'default' => array(
                    'background-image' => CC_IMG . 'no-img-parallax-bg.jpg',
                    ),

                ),

            array(
                'id' => 'heal_about_donation',
                'type' => 'text',
                'title' => __('Title', 'heal'),
                'description' => 'Write the title, it will display in about donation section *',
                'default'   => "WE ARE VERY THANKFUL"
                ),


            array(
                'id'       => 'heal-causes-feature-posts-donation',
                'type'     => 'select',
                'data'     => 'causes',
                'multi'    => false,
                'default'  => 1,
                'title'    => __( 'Feature Causes ', 'heal' ),
                'subtitle' => __( 'Which causes you want to display as feature cause to donate in homepage', 'heal' ),
                'desc'     => __( 'This cause will display in homepage as feature donation', 'heal' ),
                ),

            array(
                'id'     => 'heal-info-normal',
                'type'   => 'info',
                'notice' => false,
                'title'  => __( '<strong>Payment System Settings</strong>', 'heal' ),
                ),


            array(
                'id' => 'heal_sandbox_paypal',
                'type' => 'select',      
                'title' => __('PayPal Sandbox/Active', 'heal'),
                'options'  => array(
                    "https://www.sandbox.paypal.com/cgi-bin/webscr" =>"Enable",
                    "https://www.paypal.com/cgi-bin/webscr" =>"Disable" ,
                    ),
                'default' => 'https://www.sandbox.paypal.com/cgi-bin/webscr'
                ),

            array(
                'id' => 'heal_default_donation',
                'type' => 'text',      
                'title' => __('Default donation', 'heal'),
                'default' => '50'
                ),

            array(
                'id' => 'heal_select_currency',
                'type' => 'select',
                'title' => __('Select Your Currency Code', 'heal'),
                'default' => 'USD',
                'options'  => array(
                    "AUD" =>"Australian Dollar",
                    "BRL" =>"Brazilian Real" ,
                    "CAD" =>"Canadian Dollar",
                    "CZK" =>"Czech Koruna",
                    "DKK" =>"Danish Krone",
                    "EUR" =>"Euro",
                    "HKD" =>"Hong Kong Dollar" ,
                    "HUF" =>"Hungarian Forint" ,
                    "ILS" =>"Israeli New Sheqel",
                    "JPY" =>"Japanese Yen",
                    "MYR" =>"Malaysian Ringgit",
                    "MXN" =>"Mexican Peso",
                    "NOK" =>"Norwegian Krone",
                    "NZD" =>"New Zealand Dollar",
                    "PHP" =>"Philippine Peso",
                    "PLN" =>"Polish Zloty",
                    "GBP" =>"Pound Sterling",
                    "SGD" =>"Singapore Dollar",
                    "SEK" =>"Swedish Krona",
                    "CHF" =>"Swiss Franc",
                    "TWD" =>"Taiwan New Dollar",
                    "THB" =>"Thai Baht",
                    "TRY" =>"Turkish Lira",
                    "USD" => "U.S. Dollar",
                    ),
),


array(
    'id' => 'heal_about_parallax_agular',
    'type' => 'switch',
    'title' => __('Anglular/Linear', 'heal'),
    'default' => '1',
    'on'       => 'Linear',
    'off'      => 'Angular',
    ),

array(
    'id' => 'heal_about_parallax_lr_agular',
    'type' => 'switch',
    'title' => __('Left/Right', 'heal'),
    'default' => '1',
    'required' => array( 'heal_about_parallax_agular', "=", 0 ),
    'on'       => 'Right',
    'off'      => 'Left',
    ),

array(
    'id' => 'heal_about_parallax_color_scheam',
    'type' => 'background',
    'required' => array( 'heal_about_parallax_agular', "=", 0 ),
    'transparent' => false,
    'background-color' => true,
    'background-repeat' => false,
    'background-attachment' => false,
    'background-image' => false,
    'background-size' => false,
    'background-position' => false,
    'output'   => array('.about-parallax .angular .top-angle:before'),
    'title' => __('Parallax Angle color', 'heal'),
    ),
array(
    'id' => 'heal_about-parallax_font_color_scheam',
    'type' => 'color',
    'required' => array( 'heal_about_parallax_agular', "=", 0 ),
    'transparent' => false,
    'output'   => array('.about-parallax .parallax-title, .about-parallax .parallax-description'),
    'title' => __('Parallax Section Font color', 'heal'),
    ),




)

);


/*-----------------------------------------------------------
    News Section.
    -----------------------------------------------------------*/

    $this->sections[] = array(
        'icon'   => 'el-icon-brush',
        'title'  => __( 'News', 'heal' ),
        'fields' => array(

            array(
                'id' => 'heal_news_menu',
                'type' => 'text',
                'title' => __('News Menu ', 'heal'),
                'description' => 'Write the title, it will display in menubar *',
                'default'   => "News"
                ),
            array(
                'id' => 'heal_news_title',
                'type' => 'text',
                'title' => __('News Section Title ', 'heal'),
                'description' => 'Write the title, it will display in news section *',
                'default'   => "NEWS"
                ),
            array(
                'id' => 'heal_news_des',
                'type' => 'editor',

                'title' => __('News Section Description ', 'heal'),
                'args'   => array(
                    'teeny'            => false,
                    ),
                'description' => 'Write the Description, it will display in news section *',
                'default'   => "CHECK THE NEWS OF CHILDREN WHAT GOING ON THE WORLD WITH THEM. COLLECT CHARITY WEBSITE TEMPLATES TO BUILD YOUR OWN CHARITY ORGANIZATION. "
                ),

            array(
                'id' => 'heal_news_button_text',
                'type' => 'text',
                'title' => __('View All News Button Text', 'heal'),
                'description' => 'Write the title, it will display in news section *',
                'default'   => "View All News"
                ),


            array(
                'id'     => 'heal-angular-linear-settings-heading',
                'type'   => 'info',
                'notice' => false,
                'title'  => __( 'Angular-Linear Settings', 'heal' ),
                ),
            array(
                'id' => 'heal_news_color_scheam',
                'type' => 'background',
                'transparent' => false,
                'background-color' => true,
                'background-repeat' => false,
                'background-attachment' => false,
                'background-image' => false,
                'background-size' => false,
                'background-position' => false,
                'output'   => array('.news-section.white-bg, .news-section.white-bg.angular .top-angle:before, .news-article .post-details'),
                'title' => __('News Section Background color', 'heal'),
                ),
            array(
                'id' => 'heal_news_font_color_scheam',
                'type' => 'color',
                'transparent' => false,
                'output'   => array('.news-section .section-title, .news-section .section-description, .news-section .content-title,.news-section .post-meta,.news-section .post-meta a, .news-section .content-title a, .news-article .post-details, .news-article .post-details a'),
                'title' => __('News Section Font color', 'heal'),
                ),

            array(
                'id' => 'heal_news_agular',
                'type' => 'switch',
                'title' => __('Anglular/Linear', 'heal'),
                'default' => '1',
                'on'       => 'Linear',
                'off'      => 'Angular',
                ),

            array(
                'id' => 'heal_news_lr_agular',
                'type' => 'switch',
                'title' => __('Left/Right', 'heal'),
                'default' => '1',
                'required' => array( 'heal_news_agular', "=", 0 ),
                'on'       => 'Right',
                'off'      => 'Left',
                ),

            

            )
);

/*-----------------------------------------------------------
    Event Section .
    -----------------------------------------------------------*/

    $this->sections[] = array(
        'icon'   => 'el-icon-filter',
        'title'  => __( 'Event', 'heal' ),
        'fields' => array(

            array(
                'id' => 'heal_event_menu',
                'type' => 'text',
                'title' => __('Upcoming Event Menu ', 'heal'),
                'description' => 'Write the title, it will display in menubar *',
                'default'   => "Event"
                ),
            array(
                'id' => 'heal_event_title',
                'type' => 'text',
                'title' => __('Upcoming Event Title ', 'heal'),
                'description' => 'Write the title, it will display in Upcoming Event section *',
                'default'   => "UPCOMING EVENT"
                ),
            array(
                'id' => 'heal_event_des',
                'type' => 'editor',
                'title' => __('Event Description ', 'heal'),
                'description' => 'Write the Description, it will display in Upcoming Event section *',
                'default'   => "We create events aiming to spear the voice for children and gather for support. Please update with our events and confirm your presence."
                ),
            array(
                'id' => 'heal_event_icon',
                'type' => 'text',
                'title' => __('Upcoming Event Icon ', 'heal'),
                'description' => 'Write the class name of linecons. You can add Font Awesome icon also. for example: "fa fa-facebook".',
                'default'   => "li_calendar"
                ),
            
            array(
                'id'     => 'heal-angular-linear-settings-heading',
                'type'   => 'info',
                'notice' => false,
                'title'  => __( 'Angular-Linear Settings', 'heal' ),
                ),

            array(
                'id' => 'heal_upcomming_color_scheam',
                'type' => 'background',
                'transparent' => false,
                'background-color' => true,
                'background-repeat' => false,
                'background-attachment' => false,
                'background-image' => false,
                'background-size' => false,
                'background-position' => false,
                'output'   => array('.upcoming-events-section.gray-bg, .upcoming-events-section.gray-bg.angular .top-angle:before'),
                'title' => __('Upcomming Event Section Background', 'heal'),
                ),
            array(
                'id' => 'heal_upcomming_font_color_scheam',
                'type' => 'color',
                'transparent' => false,
                'output'   => array('.upcoming-events-section .content-box,.upcoming-events-section .content-title'),
                'title' => __('Upcomming Section Font color', 'heal'),
                ),

            array(
                'id' => 'heal_upcomming_agular',
                'type' => 'switch',
                'title' => __('Anglular/Linear', 'heal'),
                'default' => '1',
                'on'       => 'Linear',
                'off'      => 'Angular',
                ),

            array(
                'id' => 'heal_upcomming_lr_agular',
                'type' => 'switch',
                'title' => __('Left/Right', 'heal'),
                'default' => '1',
                'required' => array( 'heal_upcomming_agular', "=", 0 ),
                'on'       => 'Right',
                'off'      => 'Left',
                ),

            array(
                'id'     => 'heal-info-normal',
                'type'   => 'info',
                'notice' => false,
                'title'  => __( '<strong>Upcomming Event Countdown Setup</strong>', 'heal' ),
                ),

            array(
                'id'       => 'heal_upevent_section_off',
                'type'     => 'switch',
                'title'    => __( 'Uncoming Event Coundown ON/OFF', 'heal' ),
                'default'  => 0,
                'on'       => 'ON',
                'off'      => 'OFF',
                ),


            array(
                'id'       => 'heal-event-posts-countdown',
                'type'     => 'select',
                'required' => array( 'heal_upevent_section_off', "=", 1 ),
                'data'     => 'event',
                'multi'    => false,
                'title'    => __( 'Feature Event ', 'heal' ),
                'subtitle' => __( 'Which event you want to display in homepage as event counter', 'heal' ),
                'desc'     => __( 'This event post will display in homepage counter', 'heal' ),
                ),

            array(
                'id' => 'heal_event_parallax',
                'type' => 'background',
                'required' => array( 'heal_upevent_section_off', "=", 1 ),
                'transparent' => false,
                'background-color' => false,
                'background-repeat' => false,
                'background-attachment' => false,
                'background-image' => true,
                'background-size' => false,
                'background-position' => false,
                'output'   => array('#next-event'),
                'title' => __('Next Event Parallax background', 'heal'),
                'default' => array(
                    'background-image'=> CC_IMG . 'no-img-parallax-bg.jpg',
                    )
                ),


            array(
                'id'     => 'heal-upcoming-event-heading',
                'type'   => 'info',
                'required' => array( 'heal_upevent_section_off', "=", 1 ),
                'notice' => false,
                'title'  => __( 'Angular-Linear Settings', 'heal' ),
                ),


            array(
                'id' => 'heal_upevent_section_agular',
                'type' => 'switch',
                'required' => array( 'heal_upevent_section_off', "=", 1 ),
                'title' => __('Anglular/Linear', 'heal'),
                'default' => '1',
                'on'       => 'Linear',
                'off'      => 'Angular',
                ),

            array(
                'id' => 'heal_upevent_section_lr_agular',
                'type' => 'switch',
                'title' => __('Left/Right', 'heal'),
                'default' => '1',
                'required' => array( 'heal_upevent_section_agular', "=", 0 ),
                'on'       => 'Right',
                'off'      => 'Left',
                ),

            array(
                'id' => 'heal_upevent_section_color_scheam',
                'type' => 'background',
                'required' => array( 'heal_upevent_section_agular', "=", 0 ),
                'transparent' => false,
                'background-color' => true,
                'background-repeat' => false,
                'background-attachment' => false,
                'background-image' => false,
                'background-size' => false,
                'background-position' => false,
                'output'   => array('.next-event.angular .top-angle:before'),
                'title' => __('Angle color', 'heal'),
                ),
            array(
                'id' => 'heal_upevent_section_font_color_scheam',
                'type' => 'color',
                'required' => array( 'heal_upevent_section_agular', "=", 0 ),
                'transparent' => false,
                'output'   => array('.next-event .parallax-title'),
                'title' => __('Section Font color', 'heal'),
                ),    



            )
);

/*-----------------------------------------------------------
    Contact Section.
    -----------------------------------------------------------*/

    $this->sections[] = array(
        'icon'   => 'el-icon-compass',
        'title'  => __( 'Contact', 'heal' ),
        'fields' => array(
           array(
            'id' => 'heal_contact_menu',
            'type' => 'text',
            'title' => __('Contact Menu ', 'heal'),
            'description' => 'Write the title, it will display in menubar *',
            'default'   => "Contact"
            ),
           array(
            'id' => 'heal_contact_title',
            'type' => 'text',
            'title' => __('Contact Section Title ', 'heal'),
            'description' => 'Write the title, it will display in contact section *',
            'default'   => "CONTACT"
            ),
           array(
            'id' => 'heal_contact_des',
            'type' => 'editor',
            'title' => __('Contact Section Description ', 'heal'),
            'description' => 'Write the Description, it will display in contact section *',
            'default'   => "IF YOU FEEL, NEED WORKING FOR CHILD PLEASE CONTACT WITH US AND LET US KNOW HOW YOU LIKE TO WORK FOR THEM. CONTENT WITH US IF ANY MORE INFORMATION NEEDED."
            ),
           array(
            'id'     => 'heal-info-normal',
            'type'   => 'info',
            'notice' => false,
            'title'  => __( '<strong>CONTACT INFO</strong>', 'heal' ),
            ),

           array(
            'id' => 'heal_contact_address_title',
            'type' => 'text',
            'title' => __('Contact Address Title ', 'heal'),
            'description' => 'Write the address Title, it will display in contact info section *',
            'default'   => "Contact Info"
            ),

           array(
            'id' => 'heal_contact_msg',
            'type' => 'textarea',
            'title' => __('Contact Message ', 'heal'),
            'description' => 'Write the message, it will display in contact info section *',
            'default'   => "If you need more charity website templates or this charity website template contact with us. We will help you to make successful any of your charity works. Feel free to contact with us through mail address."
            ),
           array(
            'id' => 'heal_contact_address',
            'type' => 'text',
            'title' => __('Address ', 'heal'),
            'description' => 'Write the address, it will display in contact info section *',
            'default'   => "13/2 Elizabeth St, Melbourne VIC 3000, Australia"
            ),

           array(
            'id' => 'heal_contact_mobile',
            'type' => 'text',
            'title' => __('Phone ', 'heal'),
            'description' => 'Write the phone no, it will display in contact info section *',
            'default'   => "+61 3146 8728, +61 0987 6543"
            ),

           array(
            'id' => 'heal_contact_email',
            'type' => 'text',
            'title' => __('Email ', 'heal'),
            'description' => 'Write the email, it will display in contact info section *',
            'default'   => "support@envato.net"
            ),

             array(
            'id'     => 'heal-contact-settings-heading',
            'type'   => 'info',
            'notice' => false,
            'title'  => __( 'Angular-Linear Settings', 'heal' ),
            ),

           array(
            'id' => 'heal_contact_section_color_scheam',
            'type' => 'background',
            'transparent' => false,
            'background-color' => true,
            'background-repeat' => false,
            'background-attachment' => false,
            'background-image' => false,
            'background-size' => false,
            'background-position' => false,
            'output'   => array('.contact-section.angular .top-angle:before, .contact-section '),
            'title' => __('Section Background Color', 'heal'),
            ),

           array(
            'id' => 'heal_contact_section_font_color_scheam',
            'type' => 'color',
            'transparent' => false,
            'output'   => array('.contact-section, .contact-section .section-title, .contact-section .section-description, .contact-section .content-title, .contact-section .content-description,.contact-section .contact-address li'),
            'title' => __('Section Font color', 'heal'),
            ),  
           array(
            'id' => 'heal_contact_section_agular',
            'type' => 'switch',
            'title' => __('Anglular/Linear', 'heal'),
            'default' => '1',
            'on'       => 'Linear',
            'off'      => 'Angular',
            ),

           array(
            'id' => 'heal_contact_section_lr_agular',
            'type' => 'switch',
            'title' => __('Left/Right', 'heal'),
            'default' => '1',
            'required' => array( 'heal_contact_section_agular', "=", 0 ),
            'on'       => 'Right',
            'off'      => 'Left',
            ),


           array(
            'id'     => 'opt-info-normal',
            'type'   => 'info',
            'notice' => true,
            'title'  => __( 'Get <a target="_blank" href="'.home_url().'/wp-admin/admin.php?page=wpcf7">Contact Form 7</a> Shortcode', 'heal'),

            ),

           array(  
            "id"        => "heal_contact_form_7_title",
            "title"      => "Write The Title",
            "desc"      => "This title will display in contact form section.", 
            "default"   => "Drop us a message",
            "type"      => "text"
            ),


           array(  
            "id"        => "heal_contact_form_7",
            "title"      => "Paste Contact Form 7 Shortcode",
            "desc"      => "Paste Contact Form Shortcode Here. For example [contact-form-7 id=\"273\" title=\"Contact form 1\"]", 
            "default"       => "Please Add Contact form 7 shortcode here.",
            "type"      => "text"
            ),


           array(
            'id'     => 'heal-info-normal',
            'type'   => 'info',
            'notice' => false,
            'title'  => __( '<strong>Google Map Settings</strong>', 'heal' ),
            ),

           array(
            'id' => 'heal_map_on_off',
            'type' => 'switch',
            'title' => __('ON/OFF', 'heal'),
            'default' => '1',
            'on'       => 'ON',
            'off'      => 'OFF',
            ),

           array(  
            "title"      => "Latitude",
            "desc"      => "Paste your DD (Decimal Degrees) tracking code here. <a target=\"_blank\" href=\"http://www.gps-coordinates.net/\">Click Here</a> for help.",
            "id"        => "heal_lati",
            'required' => array( 'heal_map_on_off', "=", 1 ),
            "default"       => "23.7322302",
            "type"      => "text"
            ),

           array(  
            "title"      => "Longitude",
            "desc"      => "Paste your DD (Decimal Degrees) tracking code here. <a target=\"_blank\" href=\"http://www.gps-coordinates.net/\">Click Here</a> for help.",
            "id"        => "heal_longi",
            'required' => array( 'heal_map_on_off', "=", 1 ),
            "default"       => "90.418276",
            "type"      => "text"
            ),

           array(
            'id' => 'heal_map_icon',
            'type' => 'media',
            'required' => array( 'heal_map_on_off', "=", 1 ),
            'url'      => true,
            'mode'      => false,
            'preview'   => true,
            'title' => __('Upload Map Icon', 'heal'),
            'default' => array(
                'url'=> CC_IMG. 'mapicon.png',
                )
            ),

           array(
            'id' => 'heal_map_agular',
            'type' => 'switch',
            'required' => array( 'heal_map_on_off', "=", 1 ),
            'title' => __('Anglular/Linear', 'heal'),
            'default' => '1',
            'on'       => 'Linear',
            'off'      => 'Angular',
            ),

           array(
            'id' => 'heal_map_color_scheam',
            'type' => 'background',
            'required' => array( 'heal_map_agular', "=", 0 ),
            'transparent' => false,
            'background-color' => true,
            'background-repeat' => false,
            'background-attachment' => false,
            'background-image' => false,
            'background-size' => false,
            'background-position' => false,
            'output'   => array('.map-container.angular .top-angle:before '),
            'title' => __('Map Angle Color', 'heal'),
            ),

           array(
            'id' => 'heal_map_lr_agular',
            'type' => 'switch',
            'title' => __('Left/Right', 'heal'),
            'default' => '1',
            'required' => array( 'heal_map_agular', "=", 0 ),
            'on'       => 'Right',
            'off'      => 'Left',
            ),






           )
);

/*-----------------------------------------------------------
    footer settings.
    -----------------------------------------------------------*/
    $this->sections[] = array(
        'icon'   => 'el-icon-heart-empty',
        'title'  => __( 'Footer', 'heal' ),
        'fields' => array(

         array(
            'id' => 'heal_copyright_text',
            'type' => 'editor',
            'title' => __('Copyright Text', 'heal'),
            'default' => '&copy; <a href="#">Heal</a> 2014, All Rights Reserved, Developed by <a href="'.$sitename.'" title="Premium WordPress Themes">CodexCoder</a>'
            ),     

         

         )
        );

/*-----------------------------------------------------------
    Client Settings.
    -----------------------------------------------------------*/

    $this->sections[] = array(
        'icon'   => 'el-icon-leaf',
        'title'  => __( 'Client', 'heal' ),
        'fields' => array(
           array(
            'id'       => 'heal_partner_section_off',
            'type'     => 'switch',
            'title'    => __( 'Client Section ON/OFF', 'heal' ),
            'default'  => 1,
            'on'       => 'ON',
            'off'      => 'OFF',
            ),
           array(
            'id' => 'heal_client_parallax',
            'type' => 'background',
            'required' => array( 'heal_partner_section_off', "=", 1 ),
            'transparent' => false,
            'background-color' => false,
            'background-repeat' => false,
            'background-attachment' => false,
            'background-image' => true,
            'background-size' => false,
            'background-position' => false,
            'output'   => array('#clients'),
            'title' => __('Client Section Parallax', 'heal'),
            'default' => array(
                'background-image'=> CC_IMG . 'no-img-parallax-bg.jpg',
                )
            ),

           array(
            'id' => 'heal_client_one',
            'type' => 'media',
            'required' => array( 'heal_partner_section_off', "=", 1 ),
            'url'      => true,
            'mode'      => false,
            'preview'   => true,
            'title' => __('Upload Client One', 'heal'),
            'default' => array(
                'url'=> CC_IMG. 'client-1.jpg',
                )
            ),

           array(
            'id' => 'heal_client_one_url',
            'required' => array( 'heal_partner_section_off', "=", 1 ),
            'type' => 'text',
            'title' => __('Client One URL', 'heal'),
            'default' => '#'
            ),

           array(
            'id' => 'heal_client_two',
            'type' => 'media',
            'required' => array( 'heal_partner_section_off', "=", 1 ),
            'url'      => true,
            'mode'      => false,
            'preview'   => true,
            'title' => __('Upload Client Two', 'heal'),
            'default' => array(
                'url'=> CC_IMG. 'client-1.jpg',
                )
            ),
           array(
            'id' => 'heal_client_two_url',
            'required' => array( 'heal_partner_section_off', "=", 1 ),
            'type' => 'text',
            'title' => __('Client Two URL', 'heal'),
            'default' => '#'
            ),

           array(
            'id' => 'heal_client_three',
            'type' => 'media',
            'required' => array( 'heal_partner_section_off', "=", 1 ),
            'url'      => true,
            'mode'      => false,
            'preview'   => true,
            'title' => __('Upload Client Three', 'heal'),
            'default' => array(
                'url'=> CC_IMG. 'client-1.jpg',
                )
            ),
           array(
            'id' => 'heal_client_three_url',
            'required' => array( 'heal_partner_section_off', "=", 1 ),
            'type' => 'text',
            'title' => __('Client Three URL', 'heal'),
            'default' => '#'
            ),
           array(
            'id' => 'heal_client_four',
            'required' => array( 'heal_partner_section_off', "=", 1 ),
            'type' => 'media',
            'url'      => true,
            'mode'      => false,
            'preview'   => true,
            'title' => __('Upload Client Four', 'heal'),
            'default' => array(
                'url'=> CC_IMG. 'client-1.jpg',
                )
            ),
           array(
            'id' => 'heal_client_four_url',
            'required' => array( 'heal_partner_section_off', "=", 1 ),
            'type' => 'text',
            'title' => __('Client Four URL', 'heal'),
            'default' => '#'
            ),

           array(
            'id'   => 'opt-divide',
            'type' => 'divide'
            ),

           array(
            'id' => 'heal_Client_agular',
            'type' => 'switch',
            'required' => array( 'heal_partner_section_off', "=", 1 ),
            'title' => __('Anglular/Linear', 'heal'),
            'default' => '1',
            'on'       => 'Linear',
            'off'      => 'Angular',
            ),

           array(
            'id' => 'heal_Client_color_scheam',
            'type' => 'background',
            'required' => array( 'heal_Client_agular', "=", 0 ),
            'transparent' => false,
            'background-color' => true,
            'background-repeat' => false,
            'background-attachment' => false,
            'background-image' => false,
            'background-size' => false,
            'background-position' => false,
            'output'   => array('#clients .angular .top-angle:before'),
            'title' => __('Client Angle Color', 'heal'),
            ),

           array(
            'id' => 'heal_Client_lr_agular',
            'type' => 'switch',
            'title' => __('Left/Right', 'heal'),
            'default' => '1',
            'required' => array( 'heal_Client_agular', "=", 0 ),
            'on'       => 'Right',
            'off'      => 'Left',
            ),




           )
);



/*-----------------------------------------------------------
    Social Settings.
    -----------------------------------------------------------*/

    $this->sections[] = array(
        'icon'   => 'el-icon-plus',
        'title'  => __( 'Social', 'heal' ),
        'fields' => array(
           array(
            'id' => 'heal_twitter',
            'type' => 'text',
            'title' => __('Twitter', 'heal'),
            'default' => 'http://twitter.com/codexcoder'
            ),

           array(
            'id' => 'heal_facebook',
            'type' => 'text',
            'title' => __('Facebook', 'heal'),
            'default' => 'http://facebook.com/codexcoderltd'
            ),

           array(
            'id' => 'heal_github',
            'type' => 'text',
            'title' => __('Github', 'heal'),
            'default' => 'http://github.com/codexcoder'
            ),

           array(
            'id' => 'heal_vimeo',
            'type' => 'text',
            'title' => __('Vimeo', 'heal'),
            'default' => '#'
            ),
           array(
            'id' => 'heal_pinterest',
            'type' => 'text',
            'title' => __('Pinterest', 'heal'),
            'default' => '#'
            ),

           array(
            'id' => 'heal_google_plus',
            'type' => 'text',
            'title' => __('Google Plus', 'heal'),
            'default' => '#'
            ),

           array(
            'id' => 'heal_youtube',
            'type' => 'text',
            'title' => __('Youtube', 'heal'),
            'default' => '#'
            ),

           array(
            'id' => 'heal_dribbble',
            'type' => 'text',
            'title' => __('Dribbble', 'heal'),
            'default' => '#'
            ),

           array(
            'id' => 'heal_linkedin',
            'type' => 'text',
            'title' => __('Linkedin', 'heal'),
            'default' => '#'
            ),
           array(
            'id' => 'heal_instagram',
            'type' => 'text',
            'title' => __('Instagram', 'heal'),
            'default' => '#'
            ),




           )
);

 $this->sections[] = array(
        'icon'   => 'el-icon-shopping-cart',
        'title'  => __( 'WooCommerce', 'heal' ),
        'fields' => array(

            array(
                'id' => 'wo_to_cart',
                'type' => 'text',
                'title' => __('Add To Cart', 'heal'),
                'default' => 'Donate Now',
                ),

             array(
                'id' => 'wo_select_opt',
                'type' => 'text',
                'title' => __('Select Options', 'heal'),
                'default' => 'Choose ammount',
                ),
             array(
                'id' => 'wo_view_pro',
                'type' => 'text',
                'title' => __('View Product', 'heal'),
                'default' => 'View Causes',
                ),

             array(
                'id' => 'wo_buy_pro',
                'type' => 'text',
                'title' => __('Buy Product', 'heal'),
                'default' => 'Buy Smile',
                ),


            )
);

/*-----------------------------------------------------------
    Advance Settings.
    -----------------------------------------------------------*/

    $this->sections[] = array(
        'icon'   => 'el-icon-cogs',
        'title'  => __( 'Advance', 'heal' ),
        'fields' => array(

            array(
                'id' => 'heal_layout',
                'type' => 'switch',
                'title' => __('Theme Layout', 'heal'),
                'default' => '1',
                'on'       => 'Wide',
                'off'      => 'Boxed',
                ),

            array(
                'id' => 'heal_nice_scroll',
                'type' => 'switch',
                'title' => __('Smooth Mouse Scroll', 'heal'),
                'default' => '1',
                'on'       => 'Enable',
                'off'      => 'Disable',
                ),

            array(
                'id' => 'heal_smoot_scroll_menu_on_off',
                'type' => 'switch',
                'title' => __('Homepage menu', 'heal'),
                'default' => '1',
                'on'       => 'Onepage Menu',
                'off'      => 'Wordpress Menu'
                ),



            array(
                'id' => 'heal_show_number',
                'type' => 'text',
                'title' => __('Display Post Number', 'heal'),
                'description' => 'How many post you want to display in homepage',
                'default' => 4
                ),

            array(
                'id' => 'blog_excerpt_length',
                'type' => 'text',
                'title' => __('Excerpt Length', 'heal'),
                'default' => 20
                ),

            array(
                'id' => 'heal_custom_css',
                'type' => 'ace_editor',
                'title' => __('Custom CSS', 'heal'),
                'description' => 'Write your custom CSS code inside &lt;style> &lt;/style> block'
                ),


            array(
                'id'     => 'heal-info-normal',
                'type'   => 'info',
                'notice' => false,
                'title'  => __( '<strong>Theme Color Settings</strong>', 'heal' ),
                ),

            array(
                'id' => 'heal_unlimited_color_scheam',
                'type' => 'background',
                'transparent' => false,
                'background-color' => true,
                'background-repeat' => false,
                'background-attachment' => false,
                'background-image' => false,
                'background-size' => false,
                'background-position' => false,
                'title' => __('Theme Color', 'heal'),
                ),

            array(
                'id' => 'heal_donate_color_scheam',
                'type' => 'background',
                'transparent' => false,
                'background-color' => true,
                'background-repeat' => false,
                'background-attachment' => false,
                'background-image' => false,
                'background-size' => false,
                'background-position' => false,
                'output'   => array('.donate'),
                'title' => __('Donate Button Color', 'heal'),
                ),

            array(
                'id' => 'heal_donate_hover_color_scheam',
                'type' => 'background',
                'transparent' => false,
                'background-color' => true,
                'background-repeat' => false,
                'background-attachment' => false,
                'background-image' => false,
                'background-size' => false,
                'background-position' => false,
                'output'   => array('.donate:hover'),
                'title' => __('Donate Button Hover Color', 'heal'),
                ),

            array(
                'id' => 'heal_dropdown_color_scheam',
                'type' => 'background',
                'transparent' => false,
                'background-color' => true,
                'background-repeat' => false,
                'background-attachment' => false,
                'background-image' => false,
                'background-size' => false,
                'background-position' => false,
                'output'   => array('.dropdown-menu'),
                'title' => __('Drop Down Backgound Color', 'heal'),
                ),

            array(
                'id' => 'heal_dropdown_hover_color_scheam',
                'type' => 'background',
                'transparent' => false,
                'background-color' => true,
                'background-repeat' => false,
                'background-attachment' => false,
                'background-image' => false,
                'background-size' => false,
                'background-position' => false,
                'output'   => array('.donate-btn:hover, .dropdown-menu>li>a:hover, .dropdown-menu>li>a:focus, .dropdown-menu>.active>a, .dropdown-menu>.active>a:hover, .dropdown-menu>.active>a:focus'),
                'title' => __('Hover Backgound Color', 'heal'),
                ),


            array(
                'id' => 'heal_overlay_change',
                'type' => 'switch',
                'title' => __('Parallax Overlay', 'heal'),
                'default' => '1',
                'on'       => 'Default',
                'off'      => 'Custom',
                ),


            array(
                'id' => 'heal_unlimited_parallax_overlay',
                'type' => 'color_rgba',
                'required' => array( 'heal_overlay_change', "=", 0 ),
                'output'   => array('.parallax-overlay'),
                'mode'      => 'background-color',
                ),




            array(
                'id'     => 'heal-info-normal',
                'type'   => 'info',
                'notice' => false,
                'title'  => __( '<strong>Mobile Version Settings</strong>', 'heal' ),
                ),

            array(
                'id' => 'mob_slider_of_off',
                'type' => 'switch',
                'title' => __('Slider on off', 'heal')
                ),


            )
);

/*-----------------------------------------------------------
    Typography Settings.
    -----------------------------------------------------------*/

    $this->sections[] = array(
        'icon'   => 'el-icon-font',
        'title'  => __( 'Typography', 'heal' ),
        'fields' => array(

          array(
            'id'     => 'heal-info-normal',
            'type'   => 'info',
            'notice' => false,
            'title'  => __( '<strong>Typography</strong>', 'heal' ),
            ),

          array(
            'id'       => 'main_body_font',
            'type'     => 'typography',
            'title'    => __( 'Body Font', 'heal' ),
            'subtitle' => __( 'Specify the body font properties.', 'heal' ),
            'google'   => true,
            'subsets'  => false,
                // 'font-size'=> false,
                // 'color'    => false,
                // 'text-align'    => false,
                // 'line-height'    => false,
            'output'   => array('body'),
            'default'  => array(
                'font-family' => 'Raleway',
                'google'      => true
                ),
            ),



          array(
            'id' => 'heal_menu_hover_text_scheam',
            'type'     => 'link_color',
            'output'   => array('.navbar-default .navbar-nav>li>a '),
            'title' => __('Menu Text Color', 'heal'),
            ),




          )
);



$this->sections[] = array(
    'type' => 'divide',
    );

/*-----------------------------------------------------------
    Documentation.
    -----------------------------------------------------------*/

    $this->sections[] = array(
        'icon'   => 'el-icon-cogs',
        'title'  => __( 'Documentation', 'heal' ),
        'fields' => array(

          array(
            'id'     => 'opt-info-normal',
            'type'   => 'info',
            'notice' => true,
            'title'  => __( 'Please <a target="_blank" href="http://themes.codexcoder.com/doc/heal-wp/">Click Here</a> To see documentaion', 'heal' ),

            ),

          )
        );

}

public function setHelpTabs() {

                // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
    $this->args['help_tabs'][] = array(
        'id'      => 'redux-help-tab-1',
        'title'   => __( 'Theme Information 1', 'heal' ),
        'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'heal' )
        );

    $this->args['help_tabs'][] = array(
        'id'      => 'redux-help-tab-2',
        'title'   => __( 'Theme Information 2', 'heal' ),
        'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'heal' )
        );

                // Set the help sidebar
    $this->args['help_sidebar'] = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'heal' );
}

            /**
             * All the possible arguments for Redux.
             * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
             * */
            public function setArguments() {

                $theme = wp_get_theme(); // For use with some settings. Not necessary.

                $this->args = array(
                    // TYPICAL -> Change these values as you need/desire
                    'opt_name'             => 'heal_option',
                    // This is where your data is stored in the database and also becomes your global variable name.
                    'display_name'         =>  '<img width="75px" src="' .get_template_directory_uri() . '/assets/images/logo.png"> v',
                    // Name that appears at the top of your panel
                    'display_version'      => $theme->get('Version'),
                    // Version that appears at the top of your panel
                    'menu_type'            => 'menu',
                    //menu icon
                    'menu_icon'             => get_template_directory_uri() . "/assets/images/menu-icon.png",
                    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                    'allow_sub_menu'       => true,
                    // Show the sections below the admin menu item or not
                    'menu_title'           => __( 'Heal Options', 'heal' ),
                    'page_title'           => __( 'Heal Options', 'heal' ),
                    // Set it you want google fonts to update weekly. A google_api_key value is required.
                    'google_update_weekly' => false,
                    // Must be defined to add google fonts to the typography module
                    'async_typography'     => true,
                    // Use a asynchronous font on the front end or font string
                    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                    'admin_bar'            => true,
                    // Show the panel pages on the admin bar
                    'admin_bar_icon'     => 'dashicons-portfolio',
                    // Choose an icon for the admin bar menu
                    'admin_bar_priority' => 50,
                    // Choose an priority for the admin bar menu
                    'global_variable'      => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'             => false,
                    // Show the time the page took to load, etc
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'            => 'heal_options',
                    // On load save the defaults to DB before user clicks save or not
                    'default_show'         => false,
                    // If true, shows the default value next to each field that is not the default value.
                    'default_mark'         => '',
                    // What to print by the field's title if the value shown is default. Suggested: *
                    'show_import_export'   => true,

                    );


}

}

global $reduxConfig;
$reduxConfig = new Heal_FrameWord_Redux();
}