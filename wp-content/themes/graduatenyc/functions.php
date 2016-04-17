<?php

/*
* Add your own functions here. You can also copy some of the theme functions into this file. 
* Wordpress will use those functions instead of the original functions then.
*/



/* RVC - Function to disable theme options in admin panel

add_action('admin_print_scripts', 'avia_gravity_forms_admin');
function avia_gravity_forms_admin()
{
    echo "<style type='text/css'>";
    echo "#toplevel_page_avia, li#menu-posts-portfolio, li#wp-admin-bar-new-portfolio { display: none; }";
    echo "</style>";
}

*/

/* RVC - Hide the admin menu on the front end */
show_admin_bar( false );


/* RVC - Add custom fonts */
add_filter( 'avf_google_heading_font',  'avia_add_heading_font');
function avia_add_heading_font($fonts)
{
$fonts['Source Sans Pro'] = 'Source Sans Pro:400,600,800';
return $fonts;
}

add_filter( 'avf_google_content_font',  'avia_add_content_font');
function avia_add_content_font($fonts)
{
$fonts['Source Sans Pro'] = 'Source Sans Pro:400,600,800';
return $fonts;
}


/* RVC - Add shortcode for page titles */
function myshortcode_title( ){
   return get_the_title();
}
add_shortcode( 'page_title', 'myshortcode_title' );


/* RVC - Add buttons to header, V1 */

function add_paypal_button_script(){

	$paypal_button = '<a class="paypal-donate-button" href="http://wp.ignacior67.webfactional.com/get-involved/donate/"></a>';
	echo $paypal_button;

}
add_action('ava_main_header', 'add_paypal_button_script');



function add_nyccl_button_script(){

	$nyccl_button = '<a class="nyccl-button" href="http://nyccollegeline.org/" target="_blank"></a>';
	echo $nyccl_button;

}
add_action('ava_main_header', 'add_nyccl_button_script');




/* RVC - Add buttons to header, V2 

add_action( 'ava_after_main_menu', 'enfold_customization_header_widget_area' );
function enfold_customization_header_widget_area() {
	dynamic_sidebar( 'header' );
}

*/


/* RVC - Add sidebar parent title */

function avia_sidebar_menu($echo = true)
    {
        $sidebar_menu = "";

        $subNav = avia_get_option('page_nesting_nav');
  
        
        $the_id = @get_the_ID();
        $args 	= array();
		global $post;

        if($subNav && $subNav != 'disabled' && !empty($the_id) && is_page())
        {
            $subNav = false;
            $parent = $post->ID;
            $sidebar_menu = "";

            if (!empty($post->post_parent))
            {
                if(isset($post->ancestors)) $ancestors  = $post->ancestors;
                if(!isset($ancestors)) $ancestors  = get_post_ancestors($post->ID);
                $root		= count($ancestors)-1;
                $parent 	= $ancestors[$root];
            }

            $args = array('title_li'=>'', 'child_of'=>$parent, 'echo'=>0, 'sort_column'=>'menu_order, post_title');

            //enables user to change query args
            $args = apply_filters('avia_sidebar_menu_args', $args, $post);

            //hide or show child pages in menu - if the class is set to 'widget_nav_hide_child' the child pages will be hidden
            $display_child_pages = apply_filters('avia_sidebar_menu_display_child', 'widget_nav_hide_child', $args, $post);

            $children = wp_list_pages($args);

            if ($children)
            {
                $default_sidebar = false;
				$parent = get_the_title($post->post_parent);
				$parentlink = get_the_permalink($post->post_parent);
				$sidebar_menu .= "<nav class='widget widget_nav_menu $display_child_pages'><ul class='nested_nav'>";
				$sidebar_menu .= "<h4><a href='{$parentlink}'>$parent</a></h4>";
				$sidebar_menu .= $children;
				$sidebar_menu .= "</ul></nav>";
            }
        }

        $sidebar_menu = apply_filters('avf_sidebar_menu_filter', $sidebar_menu, $args, $post);

        if($echo == true) { echo $sidebar_menu; } else { return $sidebar_menu; }
    }




