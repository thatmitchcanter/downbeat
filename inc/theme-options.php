<?php
add_action('customize_register', 'downbeat_header_customize');
add_action('customize_register', 'downbeat_layout_customize');

function downbeat_header_customize($wp_customize) {
 
    $wp_customize->add_section( 'downbeat_header_settings', array(
        'title'          => 'Header Options',
        'priority'       => 35,
    ) );
 
    $wp_customize->add_setting( 'downbeat_logo', array(
    	 'default'        => 'left',
    ) );
 
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'downbeat_logo', array(
        'label'   => 'Logo',
        'section' => 'downbeat_header_settings',
        'settings'   => 'downbeat_logo',
    ) ) ); 
 
	if ( $wp_customize->is_preview() && ! is_admin() )
	    add_action( 'wp_footer', 'downbeat_customize_preview', 21);
}

function downbeat_layout_customize($wp_customize) {
 
    $wp_customize->add_section( 'downbeat_layout_settings', array(
        'title'          => 'Layout Options',
        'priority'       => 36,
    ) );

    $wp_customize->add_setting( 'downbeat_layout', array(
    ) );    

	$wp_customize->add_control( 'downbeat_layout', array(
	    'label'   => 'Preferred Layout',
        'section' => 'downbeat_layout_settings',
	    'type'    => 'select',
	    'choices'    => array(
	        'left' => 'Left',	    	
	        'right' => 'Right',
	        'full' => 'Full',
	        ),
	) );    
 
}

function downbeat_customize_preview() { ?>
    <script type="text/javascript">
    ( function( $ ){
    wp.customize('blogname',function( value ) {
        value.bind(function(to) {
            $('.site-title').html(to);
        });
    });
    wp.customize('blogdescription',function( value ) {
        value.bind(function(to) {
            $('.site-description').html(to);
        });
    });
    } )( jQuery )
    </script>
    <?php
}