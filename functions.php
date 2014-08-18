<?php 
/**
 * @package WordPress
 * @subpackage Downbeat
 */
add_action( 'after_setup_theme', 'downbeat_theme_setup' );

function downbeat_theme_setup() {

	/* Add Theme Support for Menus */
	add_theme_support( 'menus' );
	register_nav_menu( 'navigation', 'Navigation Bar' );

	/* Automatic RSS Links (useful for feed readers) */
	automatic_feed_links();	

	/* Adds support for Post Thumbnails */
	add_theme_support( 'post-thumbnails' );	

	/* Allows for shortcodes in widgets */
	add_filter('widget_text', 'do_shortcode');	

	add_action( 'widgets_init', 'downbeat_register_right_sidebars' );
	add_action( 'widgets_init', 'downbeat_register_footer_sidebars' );
	add_filter('dynamic_sidebar_params','downbeat_widget_first_last_classes');

	/** Add Theme Editor to Admin Bar (to save time!) **/
	add_action( 'admin_bar_menu', 'downbeat_admin_bar_theme_editor_option', 100 );

}

function downbeat_register_right_sidebars() { 
	/* Right Sidebar Setup */
	register_sidebar(array(
	  'name' => 'Right Sidebar',
	  'id' => 'right-sidebar',
	  'description' => 'Widgets in this area will be shown on the right-hand side.',
	        'before_widget' => '<li id="%1$s" class="widget %2$s">',
	        'after_widget' => '</li>',
	        'before_title' => '<h4 class="widgettitle">',
	        'after_title' => '</h4>',
	));
}

function downbeat_register_footer_sidebars() {
	/* Footer Widgets Sidebar Setup */
	register_sidebar(array(
	  'name' => 'Footer Sidebar',
	  'id' => 'footer-sidebar',
	  'description' => 'Widgets in this area will be shown in the footer_widgets area.',
	        'before_widget' => '<div id="%1$s" class="one-third column widget %2$s">',
	        'after_widget' => '</div>',
	        'before_title' => '<h4 class="widgettitle">',
	        'after_title' => '</h4>',
	));	
}

/* Add "first" and "last" CSS classes to dynamic sidebar widgets. */
/* Also adds numeric index class for each widget (widget-1, widget-2, etc.) */
function downbeat_widget_first_last_classes($params) {

	global $my_widget_num; // Global a counter array
	$this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
	$arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets	

	if(!$my_widget_num) {// If the counter array doesn't exist, create it
		$my_widget_num = array();
	}

	if(!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) { // Check if the current sidebar has no widgets
		return $params; // No widgets in this sidebar... bail early.
	}

	if(isset($my_widget_num[$this_id])) { // See if the counter array has an entry for this sidebar
		$my_widget_num[$this_id] ++;
	} else { // If not, create it starting with 1
		$my_widget_num[$this_id] = 1;
	}

	$class = 'class="widget-' . $my_widget_num[$this_id] . ' '; // Add a widget number class for additional styling options

	if($my_widget_num[$this_id] == 1) { // If this is the first widget
		$class .= 'widget-first ';
	} elseif($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) { // If this is the last widget
		$class .= 'widget-last ';
	}

	//$params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']); // Insert our new classes into "before widget"
	$params[0]['before_widget'] = preg_replace('/class=\"/', "$class", $params[0]['before_widget'], 1);
	return $params;

}
	
function downbeat_admin_bar_theme_editor_option() {  
	global $wp_admin_bar;   
	if ( !is_super_admin() || !is_admin_bar_showing() )      
	return;    
	$wp_admin_bar->add_menu(        
		array( 'id' => 'edit-theme',            
		'title' => __('Edit Theme'),            
		'href' => '' . get_bloginfo('url') . '/wp-admin/theme-editor.php'        
	)    
	);
}	