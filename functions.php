<?php

/**
 * This file adds functions to the Officer Nolan WordPress theme.
 *
 * @package Officer Nolan
 * @author  WP Engine
 * @license GNU General Public License v2 or later
 * @link    https://permanenttourist.ch/officer-nolan/
 */

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

/**
 * Registers block categories, and type.
 *
 * @since 0.9.2
 */
function officer_nolan_register_block_pattern_categories()
{

	/* Functionality specific to the Block Pattern Explorer plugin. */
	if (function_exists('register_block_pattern_category_type')) {
		register_block_pattern_category_type('officer_nolan', array('label' => __('Officer Nolan', 'officer_nolan')));
	}

	$block_pattern_categories = array(
		'officer_nolan-footer'  => array(
			'label'         => __('Footer', 'officer_nolan'),
			'categoryTypes' => array('officer_nolan'),
		),
		'officer_nolan-general' => array(
			'label'         => __('General', 'officer_nolan'),
			'categoryTypes' => array('officer_nolan'),
		),
		'officer_nolan-header'  => array(
			'label'         => __('Header', 'officer_nolan'),
			'categoryTypes' => array('officer_nolan'),
		),
		'officer_nolan-page'    => array(
			'label'         => __('Page', 'officer_nolan'),
			'categoryTypes' => array('officer_nolan'),
		),
		'officer_nolan-query'   => array(
			'label'         => __('Query', 'officer_nolan'),
			'categoryTypes' => array('officer_nolan'),
		),
	);

	foreach ($block_pattern_categories as $name => $properties) {
		register_block_pattern_category($name, $properties);
	}
}
add_action('init', 'officer_nolan_register_block_pattern_categories', 9);
