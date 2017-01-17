<?php
/*
 WARNING: This is a core Generate file. DO NOT edit
 this file under any circumstances. Please do all modifications
 in the form of a child theme.
 */

/**
 * Generate Spacing integration
 *
 * This file is a core Generate file and should not be edited.
 *
 * @package  GeneratePress
 * @author   Thomas Usborne
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.generatepress.com
 */
 
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'generate_spacing_get_defaults' ) ) :
function generate_spacing_get_defaults( $filter = true )
{
	$generate_spacing_defaults = array(
		'header_top' => '40',
		'header_right' => '40',
		'header_bottom' => '40',
		'header_left' => '40',
		'menu_item' => '20',
		'menu_item_height' => '60',
		'sub_menu_item_height' => '10',
		'content_top' => '40',
		'content_right' => '40',
		'content_bottom' => '40',
		'content_left' => '40',
		'mobile_content_padding' => '30',
		'separator' => '20',
		'left_sidebar_width' => '25',
		'right_sidebar_width' => '25',
		'widget_top' => '40',
		'widget_right' => '40',
		'widget_bottom' => '40',
		'widget_left' => '40',
		'footer_widget_container_top' => '40',
		'footer_widget_container_right' => '0',
		'footer_widget_container_bottom' => '40',
		'footer_widget_container_left' => '0',
		'footer_top' => '20',
		'footer_right' => '10',
		'footer_bottom' => '20',
		'footer_left' => '10',
	);
	
	if ( $filter )
		return apply_filters( 'generate_spacing_option_defaults', $generate_spacing_defaults );
	
	return $generate_spacing_defaults;
}
endif;

if ( ! function_exists( 'generate_spacing_css' ) ) :
function generate_spacing_css()
{
	$spacing_settings = wp_parse_args( 
		get_option( 'generate_spacing_settings', array() ), 
		generate_spacing_get_defaults() 
	);
			
	$og_defaults = generate_spacing_get_defaults( false );
	
	$css = new GeneratePress_CSS;
	
	// Header padding
	$css->set_selector( '.inside-header' );
	$css->add_property( 'padding', generate_padding_css( $spacing_settings[ 'header_top' ], $spacing_settings[ 'header_right' ], $spacing_settings[ 'header_bottom' ], $spacing_settings[ 'header_left' ] ), generate_padding_css( $og_defaults[ 'header_top' ], $og_defaults[ 'header_right' ], $og_defaults[ 'header_bottom' ], $og_defaults[ 'header_left' ] ) );
	
	// Content padding
	$css->set_selector( '.separate-containers .inside-article, .separate-containers .comments-area, .separate-containers .page-header, .separate-containers .paging-navigation, .one-container .site-content' );
	$css->add_property( 'padding', generate_padding_css( $spacing_settings[ 'content_top' ], $spacing_settings[ 'content_right' ], $spacing_settings[ 'content_bottom' ], $spacing_settings[ 'content_left' ] ), generate_padding_css( $og_defaults[ 'content_top' ], $og_defaults[ 'content_right' ], $og_defaults[ 'content_bottom' ], $og_defaults[ 'content_left' ] ) );
	
	// One container
	if ( 'one-container' == generate_get_setting( 'content_layout_setting' ) || is_customize_preview() ) {
		$css->set_selector( '.one-container.right-sidebar .site-main,.one-container.both-right .site-main' );
		$css->add_property( 'margin-right', absint( $spacing_settings['content_right'] ), absint( $og_defaults['content_right'] ), 'px' );
		
		$css->set_selector( '.one-container.left-sidebar .site-main,.one-container.both-left .site-main' );
		$css->add_property( 'margin-left', absint( $spacing_settings['content_left'] ), absint( $og_defaults['content_left'] ), 'px' );
	
		$css->set_selector( '.one-container.both-sidebars .site-main' );
		$css->add_property( 'margin', generate_padding_css( '0', $spacing_settings[ 'content_right' ], '0', $spacing_settings[ 'content_left' ] ), generate_padding_css( '0', $og_defaults[ 'content_right' ], '0', $og_defaults[ 'content_left' ] ) );
	}
	
	// Separate containers
	if ( 'separate-containers' == generate_get_setting( 'content_layout_setting' ) || is_customize_preview() ) {
		// Container bottom margins
		$css->set_selector( '.separate-containers .widget, .separate-containers .site-main > *, .separate-containers .page-header, .widget-area .main-navigation' );
		$css->add_property( 'margin-bottom', absint( $spacing_settings[ 'separator' ] ), absint( $og_defaults[ 'separator' ] ), 'px' );
		
		// Right sidebar
		if ( 'right-sidebar' == generate_get_layout() ) {
			// Right sidebar separating space
			$css->set_selector( '.right-sidebar.separate-containers .site-main' );
			$css->add_property( 'margin', generate_padding_css( $spacing_settings[ 'separator' ], $spacing_settings[ 'separator' ], $spacing_settings[ 'separator' ], '0' ), generate_padding_css( $og_defaults[ 'separator' ], $og_defaults[ 'separator' ], $og_defaults[ 'separator' ], '0' ) );
		}
		
		// Left sidebar
		if ( 'left-sidebar' == generate_get_layout() ) {
			// Left sidebar separating space
			$css->set_selector( '.left-sidebar.separate-containers .site-main' );
			$css->add_property( 'margin', generate_padding_css( $spacing_settings[ 'separator' ], '0', $spacing_settings[ 'separator' ], $spacing_settings[ 'separator' ] ), generate_padding_css( $og_defaults[ 'separator' ], '0', $og_defaults[ 'separator' ], $og_defaults[ 'separator' ] ) );
		}
		
		// Both sidebars
		if ( 'both-sidebars' == generate_get_layout() ) {
			// Both sidebars separating space
			$css->set_selector( '.both-sidebars.separate-containers .site-main' );
			$css->add_property( 'margin', absint( $spacing_settings['separator'] ), absint( $og_defaults['separator'] ), 'px' );
		}
		
		// Both sidebars on the right
		if ( 'both-right' == generate_get_layout() ) {
			// Both right sidebar content separating space
			$css->set_selector( '.both-right.separate-containers .site-main' );
			$css->add_property( 'margin', generate_padding_css( $spacing_settings[ 'separator' ], $spacing_settings[ 'separator' ], $spacing_settings[ 'separator' ], '0' ), generate_padding_css( $og_defaults[ 'separator' ], $og_defaults[ 'separator' ], $og_defaults[ 'separator' ], '0' ) );
			
			// Both right sidebar - left sidebar separating space
			$css->set_selector( '.both-right.separate-containers .inside-left-sidebar' );
			$css->add_property( 'margin-right', absint( $spacing_settings[ 'separator' ] / 2 ), absint( $og_defaults[ 'separator' ] / 2 ), 'px' );
			
			// Both right sidebar - right sidebar separating space
			$css->set_selector( '.both-right.separate-containers .inside-right-sidebar' );
			$css->add_property( 'margin-left', absint( $spacing_settings[ 'separator' ] / 2 ), absint( $og_defaults[ 'separator' ] / 2 ), 'px' );
		}
		
		// Both sidebars on the left
		if ( 'both-left' == generate_get_layout() ) {
			// Both left sidebar content separating space
			$css->set_selector( '.both-left.separate-containers .site-main' );
			$css->add_property( 'margin', generate_padding_css( $spacing_settings[ 'separator' ], '0', $spacing_settings[ 'separator' ], $spacing_settings[ 'separator' ] ), generate_padding_css( $og_defaults[ 'separator' ], '0', $og_defaults[ 'separator' ], $og_defaults[ 'separator' ] ) );
			
			// Both left sidebar - left sidebar separating space
			$css->set_selector( '.both-left.separate-containers .inside-left-sidebar' );
			$css->add_property( 'margin-right', absint( $spacing_settings[ 'separator' ] / 2 ), absint( $og_defaults[ 'separator' ] / 2 ), 'px' );
			
			// Both left sidebar - right sidebar separating space
			$css->set_selector( '.both-left.separate-containers .inside-right-sidebar' );
			$css->add_property( 'margin-left', absint( $spacing_settings[ 'separator' ] / 2 ), absint( $og_defaults[ 'separator' ] / 2 ), 'px' );
		}
		
		// Site main separators
		$css->set_selector( '.separate-containers .site-main' );
		$css->add_property( 'margin-top', absint( $spacing_settings[ 'separator' ] ), absint( $og_defaults[ 'separator' ] ), 'px' );
		$css->add_property( 'margin-bottom', absint( $spacing_settings[ 'separator' ] ), absint( $og_defaults[ 'separator' ] ), 'px' );
		
		// Page header top margin
		$css->set_selector( '.separate-containers .page-header-image, .separate-containers .page-header-content, .separate-containers .page-header-image-single, .separate-containers .page-header-content-single' );
		$css->add_property( 'margin-top', absint( $spacing_settings[ 'separator' ] ), absint( $og_defaults[ 'separator' ] ), 'px' );
		
		if ( 'no-sidebar' !== generate_get_layout() ) {
			// Sidebar separator
			$css->set_selector( '.separate-containers .inside-right-sidebar, .separate-containers .inside-left-sidebar' );
			$css->add_property( 'margin-top', absint( $spacing_settings[ 'separator' ] ), absint( $og_defaults[ 'separator' ] ), 'px' );
			$css->add_property( 'margin-bottom', absint( $spacing_settings[ 'separator' ] ), absint( $og_defaults[ 'separator' ] ), 'px' );
		}
	}
	
	// Navigation spacing
	if ( '' !== generate_get_navigation_location() || is_customize_preview() ) {
		// Menu item size
		$css->set_selector( '.main-navigation .main-nav ul li a,.menu-toggle,.main-navigation .mobile-bar-items a' );
		$css->add_property( 'padding-left', absint( $spacing_settings['menu_item'] ), absint( $og_defaults['menu_item'] ), 'px' );
		$css->add_property( 'padding-right', absint( $spacing_settings['menu_item'] ), absint( $og_defaults['menu_item'] ), 'px' );
		$css->add_property( 'line-height', absint( $spacing_settings['menu_item_height'] ), absint( $og_defaults['menu_item_height'] ), 'px' );
		
		// Sub-menu item size
		$css->set_selector( '.main-navigation .main-nav ul ul li a' );
		$css->add_property( 'padding', generate_padding_css( $spacing_settings[ 'sub_menu_item_height' ], $spacing_settings[ 'menu_item' ], $spacing_settings[ 'sub_menu_item_height' ], $spacing_settings[ 'menu_item' ] ), generate_padding_css( $og_defaults[ 'sub_menu_item_height' ], $og_defaults[ 'menu_item' ], $og_defaults[ 'sub_menu_item_height' ], $og_defaults[ 'menu_item' ] ) );
		
		// Sub-menu positioning
		$css->set_selector( '.main-navigation ul ul' );
		$css->add_property( 'top', 'auto' ); // Added for compatibility purposes on 22/12/2016
		
		// Navigation search
		if ( 'enable' == generate_get_setting( 'nav_search' ) ) {
			$css->set_selector( '.navigation-search, .navigation-search input' );
			$css->add_property( 'height', absint( $spacing_settings['menu_item_height'] ), absint( $og_defaults['menu_item_height'] ), 'px' );
		}
		
		// Dropdown arrow spacing
		$css->set_selector( '.menu-item-has-children .dropdown-menu-toggle' );
		if ( is_rtl() ) {
			$css->add_property( 'padding-left', absint( $spacing_settings[ 'menu_item' ] ), false, 'px' );
		} else {
			$css->add_property( 'padding-right', absint( $spacing_settings[ 'menu_item' ] ), absint( $og_defaults[ 'menu_item' ] ), 'px' );
		}
		
		// Sub-menu dropdown arrow spacing
		$css->set_selector( '.menu-item-has-children ul .dropdown-menu-toggle' );
		$css->add_property( 'padding-top', absint( $spacing_settings[ 'sub_menu_item_height' ] ), absint( $og_defaults[ 'sub_menu_item_height' ] ), 'px' );
		$css->add_property( 'padding-bottom', absint( $spacing_settings[ 'sub_menu_item_height' ] ), absint( $og_defaults[ 'sub_menu_item_height' ] ), 'px' );
		$css->add_property( 'margin-top', '-' . absint( $spacing_settings[ 'sub_menu_item_height' ] ), '-' . absint( $og_defaults[ 'sub_menu_item_height' ] ), 'px' );
		
		// RTL menu item padding
		if ( is_rtl() ) {
			$css->set_selector( '.main-navigation .main-nav ul li.menu-item-has-children > a' );
			$css->add_property( 'padding-right', absint( $spacing_settings[ 'menu_item' ] ), false, 'px' );
		}
	}
	
	// Sidebar widgets
	if ( 'no-sidebar' !== generate_get_layout() ) {
		// Sidebar widget padding
		$css->set_selector( '.widget-area .widget' );
		$css->add_property( 'padding', generate_padding_css( $spacing_settings[ 'widget_top' ], $spacing_settings[ 'widget_right' ], $spacing_settings[ 'widget_bottom' ], $spacing_settings[ 'widget_left' ] ), generate_padding_css( $og_defaults[ 'widget_top' ], $og_defaults[ 'widget_right' ], $og_defaults[ 'widget_bottom' ], $og_defaults[ 'widget_left' ] ) );
	}
	
	// Footer widgets
	$footer_widgets = generate_get_footer_widgets();
	if ( ! empty( $footer_widgets ) && 0 !== $footer_widgets ) {
		// Footer widget padding
		$css->set_selector( '.footer-widgets' );
		$css->add_property( 'padding', generate_padding_css( $spacing_settings[ 'footer_widget_container_top' ], $spacing_settings[ 'footer_widget_container_right' ], $spacing_settings[ 'footer_widget_container_bottom' ], $spacing_settings[ 'footer_widget_container_left' ] ), generate_padding_css( $og_defaults[ 'footer_widget_container_top' ], $og_defaults[ 'footer_widget_container_right' ], $og_defaults[ 'footer_widget_container_bottom' ], $og_defaults[ 'footer_widget_container_left' ] ) );
	}
	
	// Footer padding
	$css->set_selector( '.site-info' );
	$css->add_property( 'padding', generate_padding_css( $spacing_settings[ 'footer_top' ], $spacing_settings[ 'footer_right' ], $spacing_settings[ 'footer_bottom' ], $spacing_settings[ 'footer_left' ] ), generate_padding_css( $og_defaults[ 'footer_top' ], $og_defaults[ 'footer_right' ], $og_defaults[ 'footer_bottom' ], $og_defaults[ 'footer_left' ] ) );
	
	// Add spacing back where dropdown arrow should be
	// Old versions of WP don't get nice things
	if ( version_compare( $GLOBALS['wp_version'], '4.4', '<' ) ) {
		$css->set_selector( '.main-navigation .main-nav ul li.menu-item-has-children>a, .secondary-navigation .main-nav ul li.menu-item-has-children>a' );
		$css->add_property( 'padding-right', absint( $spacing_settings[ 'menu_item' ] ), absint( $og_defaults[ 'menu_item' ] ), 'px' );
	}
	
	$output = '';
	if ( 'one-container' == generate_get_setting( 'content_layout_setting' ) || is_customize_preview() ) {
		// Get color settings
		$generate_settings = wp_parse_args( 
			get_option( 'generate_settings', array() ), 
			generate_get_color_defaults() 
		);
		
		// Find out if the content background color and sidebar widget background color is the same
		$sidebar = strtoupper( $generate_settings['sidebar_widget_background_color'] );
		$content = strtoupper( $generate_settings['content_background_color'] );
		$colors_match = ( ( $sidebar == $content ) || '' == $sidebar ) ? true : false;
		
		// Put all of our widget padding into an array
		$widget_padding = array(
			$spacing_settings[ 'widget_top' ], 
			$spacing_settings[ 'widget_right' ], 
			$spacing_settings[ 'widget_bottom' ], 
			$spacing_settings[ 'widget_left' ]
		);
		
		// If they're all 40 (default), remove the padding when one container is set
		// This way, the user can still adjust the padding and it will work (unless they want 40px padding)
		// We'll also remove the padding if there's no color difference between the widgets and content background color
		if ( count( array_unique( $widget_padding ) ) === 1 && end( $widget_padding ) === '40' && $colors_match ) {
			$output .= '.one-container .sidebar .widget{padding:0px;}';
		}
	}
	
	// Add mobile padding to the content
	$mobile = apply_filters( 'generate_mobile_breakpoint', '768px' );
	$tablet = apply_filters( 'generate_tablet_breakpoint', '1024px' );
	$mobile_content_padding = ( isset( $spacing_settings[ 'mobile_content_padding' ] ) ) ? absint( $spacing_settings[ 'mobile_content_padding' ] ) : '30';
	$output .= '@media (max-width:' . esc_attr( $mobile ) . ') {.separate-containers .inside-article, .separate-containers .comments-area, .separate-containers .page-header, .separate-containers .paging-navigation, .one-container .site-content {padding: ' . $mobile_content_padding . 'px;}}';
	
	// Allow us to hook CSS into our output
	do_action( 'generate_spacing_css', $css );
	
	return $css->css_output() . $output;
}
endif;

if ( ! function_exists( 'generate_spacing_scripts' ) ) :
/**
 * Enqueue scripts and styles
 */
add_action( 'wp_enqueue_scripts', 'generate_spacing_scripts', 50 );
function generate_spacing_scripts() {
	$name = ( wp_style_is( 'generate-defaults', 'enqueued' ) ) ? 'generate-defaults' : 'generate-style';
	wp_add_inline_style( $name, generate_spacing_css() );
}
endif;

if ( ! function_exists( 'generate_additional_spacing' ) ) :
/**
 * Add fallback CSS for our mobile search icon color
 */
function generate_additional_spacing()
{
	$spacing_settings = wp_parse_args( 
		get_option( 'generate_spacing_settings', array() ), 
		generate_spacing_get_defaults() 
	);
	
	$og_defaults = generate_spacing_get_defaults( false );

	$css = new GeneratePress_CSS;
	
	$css->set_selector( '.menu-item-has-children .dropdown-menu-toggle' );
	if ( is_rtl() ) {
		$css->add_property( 'padding-left', $spacing_settings[ 'menu_item' ], false, 'px' );
	} else {
		$css->add_property( 'padding-right', $spacing_settings[ 'menu_item' ], $og_defaults[ 'menu_item' ], 'px' );
	}
	
	// Add spacing back where dropdown arrow should be
	// Old versions of WP don't get nice things
	if ( version_compare( $GLOBALS['wp_version'], '4.4', '<' ) ) {
		$css->set_selector( '.main-navigation .main-nav ul li.menu-item-has-children>a, .secondary-navigation .main-nav ul li.menu-item-has-children>a' );
		$css->add_property( 'padding-right', $spacing_settings[ 'menu_item' ], $og_defaults[ 'menu_item' ], 'px' );
	}
	
	return $css->css_output();
}
endif;

if ( ! function_exists( 'generate_mobile_search_spacing_fallback_css' ) ) :
/**
 * Enqueue our mobile search icon color fallback CSS
 */
add_action( 'wp_enqueue_scripts', 'generate_mobile_search_spacing_fallback_css', 50 );
function generate_mobile_search_spacing_fallback_css() 
{
	wp_add_inline_style( 'generate-style', generate_additional_spacing() );
}
endif;

if ( ! function_exists( 'generate_padding_css' ) ) :
function generate_padding_css( $top, $right, $bottom, $left )
{
	$padding_top = ( isset( $top ) && '' !== $top ) ? absint( $top ) . 'px ' : '0px ';
	$padding_right = ( isset( $right ) && '' !== $right ) ? absint( $right ) . 'px ' : '0px ';
	$padding_bottom = ( isset( $bottom ) && '' !== $bottom ) ? absint( $bottom ) . 'px ' : '0px ';
	$padding_left = ( isset( $left ) && '' !== $left ) ? absint( $left ) . 'px' : '0px';
	
	// If all of our values are the same, we can return one value only
	if ( ( absint( $padding_top ) === absint( $padding_right ) ) && ( absint( $padding_right ) === absint( $padding_bottom ) ) && ( absint( $padding_bottom ) === absint( $padding_left ) ) ) {
		return $padding_left;
	}
	
	return $padding_top . $padding_right . $padding_bottom . $padding_left;
}
endif;