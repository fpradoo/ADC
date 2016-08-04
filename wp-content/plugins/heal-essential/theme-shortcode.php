<?php 

/*-----------------------------------------------------------
  Pricing table sortcode.
  -----------------------------------------------------------*/
  add_shortcode( 'pricing_table', 'pricing_table_func'); 

  function pricing_table_func( $atts, $content= null ) {
    
    $atts = shortcode_atts(
      array(
        'title'  => '',
        'price'   => '',
        'f_des'  => '',
        's_des'  => '',
        't_des'  => '',
        'fth_des'  => '',
        'link'  => '#'
        ), $atts);

    extract($atts);
    $output = '';
    $output = '<div class="pricing-item">
    <div class="item-head">
      <span class="item-name">'. $title . '</span>
      <span class="item-currency">$</span><span class="item-price">' .$price . '</span> 
    </div><!-- /.item-head -->
    <ul class="item-description">
      <li>'.$s_des.'</li>
      <li>'.$t_des.'</li>
      <li>'.$f_des.'</li>
      <li>'.$fth_des.'</li>
    </ul><!-- /.item-description -->
    <div class="item-footer">
      <a href="'.$link.'" class="btn custom-btn angle-effect">Purchase</a>
    </div><!-- /.item-footer -->
  </div>';

  return do_shortcode($output);
}


/*-----------------------------------------------------------
  service shortcode.
  -----------------------------------------------------------*/
  add_shortcode( 'service_shortcode', 'service_shortcode_func');


  function service_shortcode_func( $atts, $content= null ){
    $atts = shortcode_atts(
      array(
        'icon'  => 'li_star',
        'title'   => '',
        'description'  => '',
        'link' => '#',
        'css_class' => ''
        ), $atts);

    extract($atts); 
    $output = '';
    $output .= '<div class="' .$css_class. '" style="opacity: 1; bottom: 0px;">
    <div class="service-box">
      <div class="hex service-icon-hex">
        <div class="service-icon">
          <span aria-hidden="true" class="' . $icon . '"></span>
        </div><!-- /.service-icon -->
      </div><!-- /.hex -->
      <h3 class="service-title content-title">' . $title .'</h3>
      <!-- /.service-title content-title -->
      <p class="service-description">' . $description . '</p>
      <!-- /.service-description -->

      <div class="services-button">
        <a href="' . $link . '" class="btn custom-btn angle-effect">
          Learn More                    </a>
        </div><!-- /.services-button -->
      </div><!-- /.service-box -->
    </div>';

    return do_shortcode($output);
  }

/**  gallery shortcode.
--------------------------------------------------------------------------------------------------- */

add_shortcode( 'heal_gallery', 'heal_gallery_shorcode_special' );

function heal_gallery_shorcode_special($atts, $content = null) {
    extract( shortcode_atts(
        array(
            'title'         => '',
            'description'   => '',
            'post_no'       => '',
            'category_slug'       => '',
            ), $atts )
    );
    ob_start();
    ?>

   
            <div class="gallery-section white-bg section-padding">
                <div class="container">
                                    
                    <div class="section-head clearfix">
                        <?php if(!empty($title)) { ?>
                        <h2 class="section-title">
                            <?php echo esc_html($title); ?>
                        </h2><!-- /.section-title -->
                        <?php } ?>
                       
                        <?php if(!empty($description) ) { ?>
                        <div class="section-description">
                            <?php echo wp_kses_stripslashes( $description ); ?>
                        </div>
                        <?php } ?>
                      </div><!-- /.section-head clearfix -->

                    <div id="gallery-container" class="gallery-container">
                        <div class="galleryFilter">
                            <a href="#" data-filter="" class="current">All</a>
                            <?php

                            $strings="$category_slug";
                            $str = str_replace(',', '', $strings);
                            $array=explode(" ",$str);
                            $args = array(
                              'slug'           => $array, 
                              ); 
                            $filters = get_terms( 'filter_menu', $args );
                            foreach ($filters as $filter) {
                                echo "<a href=\"#\" data-filter=\".$filter->slug\">$filter->name</a>";
                            }
                            ?>
                        </div> <!-- /.galleryFilter -->
                         <?php 

                            global $post;
                            $args = array(
                              'post_type' => 'gallery',
                              'posts_per_page' => esc_attr($post_no),
                              'tax_query' => array(
                                array(
                                  'taxonomy' => 'filter_menu',
                                  'field' => 'slug',
                                  'terms' => $array,
                                  )
                                )
                            );
                            $query = new WP_Query( $args );

                            ?>
                            <div class="gallery-item isotope-gallery-items element-from-bottom">
                              <?php 

                              if($query->have_posts()) : while($query->have_posts()) : $query->the_post(); 

                              $terms = wp_get_post_terms(get_the_ID(), 'filter_menu' ); 
                              $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );


                              $t = array();       
                              foreach($terms as $term) 
                                $t[] = $term->slug;
                              ?> 
                              <figure class="item <?php echo implode(' ', $t); ?>">
                                <?php if ( has_post_thumbnail() ) { 
                                  the_post_thumbnail('gallery-thumb'); 
                                } else {
                                  echo '<img src="'.get_template_directory_uri().'/assets/images/no-img.jpg">';
                                }
                                ?>
                                <div class="item-link">
                                    <a class="link-hex boxer" data-boxer-height="500" data-boxer-width="500" href="<?php echo esc_url( $url ); ?>">
                                        <span>
                                            <i class="fa fa-plus"></i>
                                        </span>
                                    </a>
                                </div><!-- /.item-link -->
                                <figcaption class="item-description">
                                    <h4 class="item-title"><?php the_title(); ?></h4><!-- /.item-title -->
                                    <p class="gallery-item-description"><?php echo esc_html(get_post_meta( $post->ID, '_gallery_setting_id_caption', true ) ); ?></p><!-- /.gallery-item-description -->
                                </figcaption>
                            </figure>
                            <?php 
                              endwhile;endif;

                              //reset
                              wp_reset_query();

                              ?>
                            </div><!-- /.gallery-item -->
                          </div><!-- /gallery-container -->
                        </div><!-- /.container -->
                      </div><!-- /.gallery-section -->

        <?php
        return ob_get_clean();
    }



