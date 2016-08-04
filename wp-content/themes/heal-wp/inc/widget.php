<?php 

/*-----------------------------------------------------------------------------------*/
/*	 popular post widget 
/*-----------------------------------------------------------------------------------*/ 

   class CCR_Heal_Popular_Posts_Widget extends WP_Widget {

        /**
        * Register widget with WordPress.
        */
        public function __construct() {
            parent::__construct(
                'ccr_popular_posts', // Base ID
                'Heal Popular Posts', // Name
                array( 'description' => __( 'Popular Posts Display Widget', 'heal' ), ) // Args
            );
        }

        /**
        *
        * Limit Popular Text 
        *
        *
        **/
        function cText($text, $limit = 10, $sep='...') {

            $text = strip_tags($text);
            $text = explode(' ',$text);
            $sep = (count($text)>$limit) ? '...' : '';
            $text=implode(' ', array_slice($text,0,$limit)) . $sep;

            return $text;
        }

        /**
        * Front-end display of widget.
        *
        * @see WP_Widget::widget()
        *
        * @param array $args     Widget arguments.
        * @param array $instance Saved values from database.
        */
        public function widget( $args, $instance ) {
            extract( $args );

            $title = apply_filters('widget_title', empty($instance['title']) ? __( 'Popular Posts', 'heal' ) : $instance['title'], $instance, $this->id_base);
            $count = empty($instance['count']) ? 5 : $instance['count'];

            echo $before_widget;

            echo $before_title . $title . $after_title;

            ?>
            <ul class="popular-post">

                <?php $pc = new WP_Query('orderby=comment_count&posts_per_page=' . $count . ''); 
                
                while ($pc->have_posts()) : $pc->the_post(); ?>
                    <li>
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('widget-thumb');
                            } else {
                                echo '<img src="'.get_template_directory_uri().'/assets/images/no-img-thumb.jpg">';
                            }
                         ?>
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a> <br/ >
                    <time class="post-meta-element" datetime="<?php echo get_post_time('U', true); ?>"><?php echo get_the_date('j F, Y'); ?></time> | <span class="popular-post-comment"> <?php comments_popup_link('No Comments;', '1 Comment', '% Comments'); ?></span>
                    </li>
                <?php endwhile; ?>
                <?php wp_reset_query(); ?>
            </ul><!-- /.latest-post -->

            <?php

            echo $after_widget;
        }

        /**
        * Sanitize widget form values as they are saved.
        *
        * @see WP_Widget::update()
        *
        * @param array $new_instance Values just sent to be saved.
        * @param array $old_instance Previously saved values from database.
        *
        * @return array Updated safe values to be saved.
        */
        public function update( $new_instance, $old_instance ) {
            $instance                   = array();
            $instance['title']          = strip_tags( $new_instance['title'] );
            $instance['count']          = strip_tags( $new_instance['count'] );

            return $instance;
        }

        /**
        * Back-end widget form.
        *
        * @see WP_Widget::form()
        *
        * @param array $instance Previously saved values from database.
        */
        public function form( $instance ) {
            $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
            $count = isset($instance['count']) ? esc_attr($instance['count']) : '5';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'heal' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Post Count:', 'heal' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
        </p>

        <?php
        }

    } // class CCR_Heal_Popular_Posts_Widget

    // register CCR Heal Popular Posts widget
add_action( 'widgets_init', create_function( '', 'register_widget( "CCR_Heal_Popular_Posts_Widget" );' ) );

 

 ?>