<?php
/**
 * Plugin Name: Simple Tab
 * Version: 1.0
 * Description: Allows you to use tabs in HTML post editor.
 * Author: Dominik Schilling
 * Author URI: http://wphelper.de/
 * Plugin URI: https://github.com/ocean90/simple-tab
 *
 * License: GPLv2 or later
 *
 *	Copyright (C) 2011-2013 Dominik Schilling
 *
 *	This program is free software; you can redistribute it and/or
 *	modify it under the terms of the GNU General Public License
 *	as published by the Free Software Foundation; either version 2
 *	of the License, or (at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program; if not, write to the Free Software
 *	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

/**
 * Don't call this file directly.
 */
if ( ! class_exists( 'WP' ) ) {
	die();
}

/**
 * The class.
 */
final class DS_WP_Simple_Tab {
	private static $class;

	/**
	 * Constructor.
	 * Hooks into admin_enqueue_scripts and registers `register_script` and `enqueue_script`
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'register_script' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_script' ) );
	}

	/**
	 * Registers the scripts taboverride.js, jquery.taboverride.js and
	 * simple-tab.js.
	 * If SCRIPT_DEBUG is true, the unminified versions will be loaded.
	 */
	public static function register_script() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

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

		wp_register_script(
			'simple-tab',
			plugins_url( "js/simple-tab$suffix.js", __FILE__ ),
			array( 'jquery-taboverride' ),
			'0.1',
			true
		);
	}

	/**
	 * Enqueues the simple-tab.js script on post-new.php and post.php.
	 *
	 * @param  string $hook_suffix The current page name.
	 */
	public static function enqueue_script( $hook_suffix ) {
		if ( in_array( $hook_suffix, array( 'post-new.php', 'post.php' ) ) )
			wp_enqueue_script( 'simple-tab' );
	}

	/**
	 * Returns the instance of this singleton class.
	 *
	 * @return object An instance of DS_WP_Simple_Tab
	 */
	public static function init() {
		if ( empty( self::$class ) )
			self::$class = new self;

		return self::$class;
	}
}

add_action( 'admin_init', array( 'DS_WP_Simple_Tab', 'init' ) );
