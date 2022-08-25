<?php

/**
 * This file adds functions to the Officer Nolan WordPress theme.
 *
 * @package Officer Nolan
 * @author  WP Engine
 * @license GNU General Public License v2 or later
 * @link    https://permanenttourist.ch/officer-nolan/
 */

$GLOBALS['content_width'] = 720;

if (!function_exists('officer_nolan_setup')) {

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since 0.8.0
	 *
	 * @return void
	 */
	function officer_nolan_setup()
	{

		// Make theme available for translation.
		load_theme_textdomain('officer_nolan', get_template_directory() . '/languages');

		// Add support for Block Styles.
		add_theme_support('wp-block-styles');

		// Enqueue editor styles and fonts.
		add_editor_style(
			array(
				'./style.css',
			)
		);

		// Remove core block patterns.
		remove_theme_support('core-block-patterns');
	}
}
add_action('after_setup_theme', 'officer_nolan_setup');

// Enqueue style sheet.
add_action('wp_enqueue_scripts', 'officer_nolan_enqueue_style_sheet');
function officer_nolan_enqueue_style_sheet()
{

	wp_enqueue_style('officer_nolan', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get('Version'));
}

/**
 * Register block styles.
 *
 * @since 0.9.2
 */
function officer_nolan_register_block_styles()
{

	$block_styles = array(
		'core/button'          => array(
			'fill-base'    => __('Fill Base', 'officer_nolan'),
			'outline-base' => __('Outline Base', 'officer_nolan'),
		),
		'core/group'           => array(
			'shadow'       => __('Shadow', 'officer_nolan'),
			'shadow-solid' => __('Shadow Solid', 'officer_nolan'),
			'full-height'  => __('Full-height', 'officer_nolan'),
		),
		'core/image'           => array(
			'shadow' => __('Shadow', 'officer_nolan'),
		),
		'core/list'            => array(
			'no-disc' => __('No Disc', 'officer_nolan'),
		),
		'core/media-text'      => array(
			'shadow-media' => __('Shadow', 'officer_nolan'),
		),
		'core/navigation-link' => array(
			'fill'         => __('Fill', 'officer_nolan'),
			'fill-base'    => __('Fill Base', 'officer_nolan'),
			'outline'      => __('Outline', 'officer_nolan'),
			'outline-base' => __('Outline Base', 'officer_nolan'),
		),
	);

	foreach ($block_styles as $block => $styles) {
		foreach ($styles as $style_name => $style_label) {
			register_block_style(
				$block,
				array(
					'name'  => $style_name,
					'label' => $style_label,
				)
			);
		}
	}
}
add_action('init', 'officer_nolan_register_block_styles');

// Allows WordPress to conditionally load the individual block CSS files
// if the block is on the page. Without this, all block CSS files will be
// loaded on every page.
add_filter('should_load_separate_core_block_assets', '__return_true');


/*
	 * This lot auto-loads a class or trait just when you need it. You don't need to
	 * use require, include or anything to get the class/trait files, as long
	 * as they are stored in the correct folder and use the correct namespaces.
	 *
	 * See http://www.php-fig.org/psr/psr-4/ for an explanation of the file structure
	 * and https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md for usage examples.
	 */
spl_autoload_register(function ($class) {

	// project-specific namespace prefix
	$prefix = 'SayHello\\Theme\\';

	// base directory for the namespace prefix
	$base_dir = __DIR__ . '/src/';

	// does the class use the namespace prefix?
	$len = strlen($prefix);
	if (strncmp($prefix, $class, $len) !== 0) {
		// no, move to the next registered autoloader
		return;
	}

	// get the relative class name
	$relative_class = substr($class, $len);

	// replace the namespace prefix with the base directory, replace namespace
	// separators with directory separators in the relative class name, append
	// with .php
	$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

	// if the file exists, require it
	if (file_exists($file)) {
		require $file;
	}
});

/**
 * Returns the Theme Instance
 *
 * @return Object Theme Object
 */
if (!function_exists('sht_theme')) {
	function sht_theme()
	{
		return SayHello\Theme\Theme::getInstance();
	}
}

sht_theme();
sht_theme()->run();
