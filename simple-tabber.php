<?php
/*
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
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.min' : '';

		wp_register_script(
			'taboverride',
			plugins_url( "js/taboverride$suffix.js", __FILE__ ),
			array(),
			'3.2.1',
			true
		);

		wp_register_script(
			'jquery-taboverride',
			plugins_url( "js/jquery.taboverride$suffix.js", __FILE__ ),
			array( 'jquery', 'taboverride' ),
			'3.2.3',
			true
		);
	}

	public static function enqueue_script( $hook_suffix ) {
		if ( in_array( $hook_suffix, array( 'post-new.php', 'post.php' ) ) )
			wp_enqueue_script( 'jquery-taboverride' );
	}

	public static function print_script() {
		?>
		<script type="text/javascript">
		( function( $ ) {
			$(document).ready( function() {
				$( '#content' ).tabOverride();
			});
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
