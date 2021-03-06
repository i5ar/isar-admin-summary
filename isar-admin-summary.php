<?php
/**
 * Plugin Name: iSar Admin Summary
 * Plugin URI: https://github.com/i5ar/isar-admin-summary
 * Description: iSar Admin Summary also known as iSummary shows the latest posts from one or more sites of your interest in the iSummary pages of your admin panel. You can manage feeds to show within images or not, the number of posts to show and even a supplementary menu in your admin menu bar.
 * Version: 1.0.4
 * Author: Pierpaolo Rasicci
 * Author URI: https://github.com/i5ar/
 * Text Domain: isar-admin-summary
 * Domain Path: /languages/
 * License: GPL
 */
 
/*  Copyright 2014 iSar

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.
	
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
	
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	
	Contributions:
	
	Thanks:
	Piet Bos		https://profiles.wordpress.org/senlin/
	David Gwyer		https://profiles.wordpress.org/dgwyer/

	Sven Hofmann	http://wordpress.stackexchange.com/users/32946/sven/
*/
/**
 * Prevent direct access to files
 */
if ( ! defined( 'ABSPATH' )) exit;	// Exit if accessed directly

/**
 * Rewrite of the plugin
 */
class iSarAdminSummary {
	// For easier overriding we declared the iSummary keys here as well as our tabs array which is populated when registering settings
	private $general_settings_key = 'ias_general_settings';
	private $general_img_settings_key = 'ias_images_tab';
	private $advanced_settings_key = 'ias_clipboard_tab';
	private $plugin_options_key = 'ias_general_tab';
	private $plugin_settings_tabs = array();
	
	function __construct() {
		// @link	http://krisjordan.com/dynamic-properties-in-php-with-stdclass
		global $isar_as;
		// Set up an empty class for the global $isar_as object.
		$isar_as = new stdClass;
		
		add_action( 'admin_init', array( &$this, 'init' ), 1 );							// Set the init
		add_action( 'admin_init', array( &$this, 'load_settings' ));					// Load iSummary tabs settings 
		add_action( 'admin_init', array( &$this, 'register_general_settings' ));		// Register general iSummary tabs settings
		add_action( 'admin_init', array( &$this, 'register_general_img_settings' ));	// Register advanced iSummary tabs settings
		add_action( 'admin_init', array( &$this, 'register_advanced_settings' ));		// Register advanced iSummary tabs settings
		add_action( 'admin_menu', array( &$this, 'add_admin_menus' ));					// Add iSummary menus
		add_action( 'admin_init', array( &$this, 'add_iris_color_picker' ));			// Iris Color Picker
		add_action( 'plugins_loaded', array( &$this, 'ias_constants' ), 2 );				// Set the constants needed by the plugin
		add_action( 'plugins_loaded', array( &$this, 'ias_languages' ), 3 );				// Internationalize the text strings used
		add_action( 'plugins_loaded', array( &$this, 'ias_includes' ), 4 );					// Load the functions files
		add_action( 'plugins_loaded', array( &$this, 'ias_admin' ), 5 );					// Load the admin files
	}
	/**
	 * Create the default field in database option table
	 * The option name ias_options is registred inside the class and is hooked by many functions out of this class
	 */
	function init() {
	// @link	http://codex.wordpress.org/Function_Reference/register_setting
		register_setting(
			'ias_general_tab',		// $option_group
			'ias_options', 			// Create the default field $option_name in database option table
			'ias_validate_options'	// $sanitize_callback (optional)
		);	
	}
	
	/**
	 * Defines constants used by the plugin
	 */
	function ias_constants() {
		define( 'IAS_VERSION', '2014.07.27' );									// Set the version number of the plugin
		define( 'IAS_DIR', trailingslashit( plugin_dir_path( __FILE__ )));		// Set constant path to the plugin directory
		define( 'IAS_URI', trailingslashit( plugin_dir_url( __FILE__ )));		// Set constant path to the plugin URL
		define( 'IAS_INCLUDES', IAS_DIR . trailingslashit( 'inc' ));		// Set the constant path to the inc directory
		define( 'IAS_ADMIN', IAS_DIR . trailingslashit( 'admin' ));		// Set the constant path to the admin directory
	}
	// Loads the translation file
	function ias_languages() {
		load_plugin_textdomain( 'isar-admin-summary', false, basename( dirname( __FILE__ )) . '/languages/' );
	}
	// Loads the initial files needed by the plugin
	function ias_includes() {
		require_once( IAS_INCLUDES . 'functions.php' );	// Load the plugin functions file
	}
	// Loads the admin functions and files only if in the WordPress admin
	function ias_admin() {
		if ( is_admin()) {
			require_once( IAS_ADMIN . 'settings.php' );	// Load the main admin file
		}
	}
	
	/**
	 * The iSummary tab setting functions
	 */
	// Loads both the general and advanced settings from the database into their respective arrays. Uses array_merge to merge with default values if they're missing.
	function load_settings() {
		$this->advanced_settings = (array) get_option( $this->advanced_settings_key );
		$this->advanced_settings = array_merge( array(
			'advanced_option' => ''
		), $this->advanced_settings );
	}
	// Registers the general settings via the Settings API, appends the setting to the tabs array of the object.
	function register_general_settings() {
		$this->plugin_settings_tabs[$this->general_settings_key] = 'General';
		// @link	http://codex.wordpress.org/Function_Reference/register_setting
		register_setting(
			$this->general_settings_key,		// $option_group
			$this->general_settings_key			// $option_name
		);
		add_settings_section( 'section_general', 'iSummary General Tab', array( &$this, 'section_general_desc'), $this->general_settings_key );
	}
	// Registers the general settings via the Settings API, appends the setting to the tabs array of the object.
	function register_general_img_settings() {
		$this->plugin_settings_tabs[$this->general_img_settings_key] = 'Images';
		// @link	http://codex.wordpress.org/Function_Reference/register_setting
		register_setting(
			$this->general_img_settings_key,	// $option_group
			$this->general_img_settings_key		// $option_name
		);
		add_settings_section( 'section_general_img', 'iSummary Images Tab', array( &$this, 'section_general_img_desc'), $this->general_img_settings_key );
	}
	// Registers the advanced settings and appends the key to the plugin settings tabs array.
	function register_advanced_settings() {
		$this->plugin_settings_tabs[$this->advanced_settings_key] = 'Clipboard ';
		register_setting( $this->advanced_settings_key, $this->advanced_settings_key );
		add_settings_section( 'section_advanced', 'iSummary Clipboard Tab', array( &$this, 'section_advanced_desc' ), $this->advanced_settings_key );
		add_settings_field( 'advanced_option', 'Big ideas:', array( &$this, 'field_advanced_option' ), $this->advanced_settings_key, 'section_advanced', array( 'label_for' => 'big_ideas' ));
		add_settings_section( 'section_advanced_submit', '', array( &$this, 'section_advanced_submit' ), $this->advanced_settings_key );
	}
	function add_admin_menus() {
		$page = add_menu_page(
			__( 'iSar Admin Summary' ),				// $page_title
			__( 'iSummary' ),						// $menu_title
			'manage_options',						// $capability
			$this->plugin_options_key,				// $menu_slug
			array( &$this, 'plugin_options_page' ),	// $function
			'dashicons-rss'							// $icon_url
		);
		add_action( 'admin_print_styles-' . $page , 'ias_plugin_settings_bis_style' );
	}
	
	// Iris Color Picker
	function add_iris_color_picker() {
		wp_register_script( 'iris-color-picker', plugins_url( 'js/iris.min.js', __FILE__ ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );
	}
	
	/**
	 * The following iSummary methods provide descriptions
	 * for their respective sections, used as callbacks
	 * with add_settings_section
	 */
	 // General tab
	function section_general_desc() { ?>
		<div id="col-container" class="ias-container">
			<div id="col-right">
				<div class="col-wrap">
					<div class="form-wrap">					
						<h3>
							<span><?php _e( 'Minor Feed Headlines', 'isar-admin-summary' ); ?></span>
						</h3>
						<?php // All the feeds titles			
							$options = get_option( 'ias_options' ); 
							$feed = array($options['feed_url_1'],$options['feed_url_2'],$options['feed_url_3']);
							$host = True;
							$content = False;
							$images = False;
							echo ias_panel_function( $feed, $host, $content, $images, $column );
							echo '<blockquote><i>';
							echo __('Found something inspiring?') .'<br />';
							echo __('Raise your voice!') .'</i></blockquote><br />';
							echo '</i></blockquote>';
						?>
						<a href="<?php bloginfo( 'wpurl' ); ?>/wp-admin/post-new.php" class="ias-button add-new-h2"><?php echo __( 'New Post', 'isar-admin-summary' ); ?></a>
					</div>
				</div>
			</div>
			<div id="col-left">
				<div class="col-wrap">
					<div class="form-wrap">
						<h3 class="">
							<span><?php _e( 'Main Feed Contents', 'isar-admin-summary' ); ?></span>
						</h3>
						<?php
							$options = get_option( 'ias_options' ); 
							$feed = $options['feed_url'];
							$host = True;
							$content = True;
							$images = $options['feed_images'];
							if( $images == 'yes' ){ $images = True; }
							elseif( $images == 'no' ) { $images = False; }
							echo ias_panel_function( $feed, $host, $content, $images, $column );
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	// Images tab
	function section_general_img_desc() { ?>
		<div id="dashboard-widgets" class="metabox-holder ias-container">
 			<div id="postbox-container-1" class="postbox-container">
				<div id="normal-sortables" class="meta-box-sortables ui-sortable">
				<?php
					$options = get_option( 'ias_options' ); 
					$feed = $options['feed_url_images'];
					$host = False;
					$content = True;
					$images = True;
					$column = 'first';
					echo ias_panel_function( $feed, $host, $content, $images, $column ); ?>
				</div>		
			</div>		
			<div id="postbox-container-1" class="postbox-container">
				<div id="normal-sortables" class="meta-box-sortables ui-sortable">
				<?php
					$options = get_option( 'ias_options' ); 
					$feed = $options['feed_url_images'];
					$host = False;
					$content = True;
					$images = True;
					$column = 'second';
					echo ias_panel_function( $feed, $host, $content, $images, $column ); ?>
				</div>
			</div>
			<div id="postbox-container-1" class="postbox-container">
				<div id="normal-sortables" class="meta-box-sortables ui-sortable">
				<?php
					$options = get_option( 'ias_options' ); 
					$feed = $options['feed_url_images'];
					$host = False;
					$content = True;
					$images = True;
					$column = 'third';
					echo ias_panel_function( $feed, $host, $content, $images, $column );
				?>
				</div>		
			</div>
		</div>		
		
		<?php
	}
	// Clipboard tab
	function section_advanced_desc() {
		echo $this->advanced_settings['advanced_option'];
		echo '<div class="clearfix"><br /></div><hr />';
	}
	// Advanced Option field callback, same as above.
	function field_advanced_option() { ?>
		<!-- <input type="text" name="<?php //echo $this->advanced_settings_key; ?>[advanced_option]" value="<?php //echo esc_attr( $this->advanced_settings['advanced_option'] ); ?>" /> -->
		<textarea rows="8" cols="80" placeholder="Ideas that will change the world..." name="<?php echo $this->advanced_settings_key; ?>[advanced_option]"><?php echo esc_attr( $this->advanced_settings['advanced_option'] ); ?></textarea>
	<br/><p>You can always use <code>&lt;ol&gt;&lt;li&gt;&lt;/li&gt;&lt;/ol&gt;</code></p>
	<?php
	}
	// Advanced Option section callback.
	function section_advanced_submit() {
		echo '<i>'.__( 'I do not mean to destroy your big dreams but the text area above is just a placeholder and may not be available in future releases.', 'isar-admin-summary' ).'</i><br />';
		echo '<i>'.__('I reserved this tab for handy tools and future improvements. Reversing your <span title="Rich Site Summary">RSS</span> reading into a ready post publishing with social features will be done in a minute. Plaese, keep this plugin updated, I will definitly do something cool here!', 'isar-admin-summary' ).'</i>';
		submit_button();
	}
	// Plugin Options page rendering goes here, checks for active tab and replaces key with the related settings key. Uses the plugin_options_tabs method to render the tabs.
	function plugin_options_page() {
		$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->general_settings_key;?>
		<div class="wrap">
			<?php // Display Plugin Header, and Description
				$this->plugin_options_tabs(); ?>
			<form method="post" action="options.php">
				<?php wp_nonce_field( 'update-options' ); ?>
				<?php settings_fields( $tab ); ?>
				<?php do_settings_sections( $tab );	// This will output the section titles wrapped in h3 tags and the settings fields wrapped in tables. ?>
			</form>
		</div>
	<?php }
	
	/**
	 * Renders our iSummary tabs in the plugin options page,
	 * walks through the object's tabs array and prints
	 * them one by one. Provides the heading for the
	 * plugin_options_page method.
	 */
	function plugin_options_tabs() {
		$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->general_settings_key;
		screen_icon();
		echo '<h2 class="nav-tab-wrapper">';
		foreach ( $this->plugin_settings_tabs as $tab_key => $tab_caption ) {
			$active = $current_tab == $tab_key ? 'nav-tab-active' : '';
			echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->plugin_options_key . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';	
		}
		echo '</h2>';
	}
}
$isar_admin_summary = new iSarAdminSummary();

// Register activation/deactivation hooks
register_activation_hook( __FILE__, 'ias_add_defaults' ); 
register_uninstall_hook( __FILE__, 'ias_delete_plugin_options' );

add_action( 'admin_menu', 'ias_add_options_page' );
function ias_add_options_page() {
	// @link	http://codex.wordpress.org/Function_Reference/wp_enqueue_style
	$page = add_options_page(
		__( 'iSar Admin Summary Settings' ),	// $page_title
		__( 'iSummary Settings' ),				// $menu_title
		'manage_options',						// $capability
		__FILE__,								// $menu_slug
		'ias_render_form'						// $function
	);
	// Use the page suffix to compose the page and register an action executed when plugin's options page is loaded
	add_action( 'admin_print_styles-' . $page , 'ias_plugin_settings_style' );
}

/**
 * Define default option settings
 */
function ias_add_defaults() {
	// @link	https://developer.wordpress.org/reference/functions/admin_color_scheme_picker/
	global $_wp_admin_css_colors;
	$user_admin_color = get_user_meta(get_current_user_id(), 'admin_color', True);
	$color = $_wp_admin_css_colors[$user_admin_color]->colors;
	// @link	http://codex.wordpress.org/Function_Reference/get_option
	$tmp = get_option( 'ias_options' );
	if ( ( $tmp['chk_def_options'] == '1' ) || ( ! is_array( $tmp ))) {
		$defaults = array(
			'feed_url'			=> 'http://isarch.it/en/feed/',
			'feed_url_1'		=> 'http://isarch.it/en/feed/',
			'feed_url_2'		=> 'http://isarch.it/en/news/feed/',
			'feed_url_3'		=> 'http://isarch.it/en/freebies/feed/',
			'feed_url_images'	=> 'http://isarch.it/category/picture/feed/',
			'feed_images'		=> 'no',
			'feed_menu'			=> 'yes',		// Feed menu in admin bar
			'feed_menu_colour'	=> $color[3],	// Feed menu in admin bar colour
			'num_content_items'	=> '3',			// Number of posts per feed
			'chk_def_options'	=> ''			// Check default option database
		);
		// @link	http://codex.wordpress.org/Function_Reference/update_option
		update_option( 'ias_options', $defaults );
	}
}

/**
 * Delete options table entries only when the plugin is deleted
 */
function ias_delete_plugin_options() {
	delete_option( 'ias_options' );
}

/**
 * Register and enqueue the settings stylesheet
 */
function ias_plugin_settings_style() {
	// @link	http://codex.wordpress.org/Function_Reference/wp_register_style
	wp_register_style(
		'custom_ias_settings_css',			// $handle
		IAS_URI . 'css/settings.css',		// $src
		false,								// $deps
		IAS_VERSION							// $ver
	);
	wp_enqueue_style( 'custom_ias_settings_css' );
	// Iris Color Picker
	wp_enqueue_script( 'iris-color-picker' );
	//wp_enqueue_style( 'wp-color-picker' );	
}

/**
 * Register and enqueue the settings stylesheet
 */
function ias_plugin_settings_bis_style() {
	// @link	http://codex.wordpress.org/Function_Reference/wp_register_style
	wp_register_style(
		'custom_ias_css',			//	$handle
		IAS_URI . 'css/style.css',	//	$src
		false,						//	$deps
		IAS_VERSION					//	$ver
	);
	wp_enqueue_style( 'custom_ias_css' );
}

/**
 * Set-up Action and Filter Hooks
 */
add_filter( 'plugin_action_links', 'ias_plugin_action_links', 10, 2 );
add_action( 'wp_dashboard_setup', 'ias_setup_function' );	// Register the new dashboard widget
/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 * @link	http://codex.wordpress.org/Function_Reference/wp_filter_nohtml_kses
 */
function ias_validate_options( $input ) {
	$input['feed_url'] =  wp_filter_nohtml_kses( $input['feed_url'] );
	$input['feed_url_1'] =  wp_filter_nohtml_kses( $input['feed_url_1'] );
	$input['feed_url_2'] =  wp_filter_nohtml_kses( $input['feed_url_2'] );
	$input['feed_url_3'] =  wp_filter_nohtml_kses( $input['feed_url_3'] );
	$input['feed_url_images'] =  wp_filter_nohtml_kses( $input['feed_url_images'] );
	$input['feed_menu_colour'] =  wp_filter_nohtml_kses( $input['feed_menu_colour'] );
	return $input;
}

/**
 * Display a Settings link on the Plugins page
 */
function ias_plugin_action_links( $links, $file ) {
	if ( $file == plugin_basename( __FILE__ )) {
		$ias_links = '<a href="' . get_admin_url() . 'options-general.php?page=isar-admin-summary/isar-admin-summary.php">' . __( 'Settings', 'isar-admin-summary' ) . '</a>';
		array_unshift( $links, $ias_links );	// Make Settings link appear first
	}
	return $links;
}
?>
