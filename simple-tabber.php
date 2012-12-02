<?php
/*
Test
Plugin Name: Simple Tab
Plugin URI: http://wpgrafie.de/
Description: Allows you to use tabs in HTML post editor.
Version: 0.1
Author: ocean90
Author URI: http://wpgrafie.de/
License: GPLv2 or later
*/

class DS_WP_Simple_Tab {
	private static $class;
	
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'register_script' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_script' ) );
		add_action( 'admin_footer-post.php', array( __CLASS__, 'print_script' ) );
		add_action( 'admin_footer-post-new.php', array( __CLASS__, 'print_script' ) );
	}
	
	public static function register_script() {
		$js = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/js/jquery.taboverride.js' : '/js/jquery.taboverride.min.js';

		wp_register_script(
			'jquery-tab-override',
			plugins_url( $js, __FILE__ ),
			array( 'jquery' ),
			'1.1',
			true
		);
	}
	
	public static function enqueue_script( $hook_suffix ) {
		if ( in_array( $hook_suffix, array( 'post-new.php', 'post.php' ) ) )
			wp_enqueue_script( 'jquery-tab-override' );
	}
	
	public static function print_script() {
		?>
		<script type="text/javascript">
		( function( $ ) {
			$( '#content' ).tabOverride();
		} )( jQuery );
		</script>
		<?php
	}

	public static function init() {
		if ( empty( self::$class ) )
			self::$class = new self;

		return self::$class;
	}
}

add_action( 'plugins_loaded', array( 'DS_WP_Simple_Tab', 'init' ) );
?>