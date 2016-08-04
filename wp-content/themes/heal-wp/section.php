<?php 
/**
*
* sorting different section
* @ package heal
**/

global $heal_option;
$sort_section = $heal_option['heal_seciton_sorter']['Enabled'];

if ($sort_section): foreach ($sort_section as $key=>$value) {

	switch($key) {

		case 'about': get_template_part( 'sections/about', 'about' );
		break;

		case 'team': get_template_part( 'sections/team', 'team' );
		break;

		case 'service': get_template_part( 'sections/service', 'service' );
		break;

		case 'testimonial': get_template_part( 'sections/testimonial', 'testimonial' );
		break;

		case 'gallery': get_template_part( 'sections/gallery', 'gallery' );    
		break;  

		case 'causes': get_template_part( 'sections/causes', 'causes' );    
		break; 

		case 'news': get_template_part( 'sections/news', 'news' );    
		break; 

		case 'event': get_template_part( 'sections/event', 'event' );    
		break; 

		case 'client': get_template_part( 'sections/client', 'client' );    
		break; 

		case 'contact': get_template_part( 'sections/contact', 'contact' );    
		break;   

	}

}

endif;
?>