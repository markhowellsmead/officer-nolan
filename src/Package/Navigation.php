<?php

namespace SayHello\Theme\Package;

use WP_REST_Response;

/**
 * Everything to do with menus and site navigation
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Navigation
{

	private $menus;

	public function __construct()
	{
		$this->menus = [
			'primary' => _x('Primary', 'Menu navigation label', 'sha'),
			'mobile' => _x('Mobile', 'Menu navigation label', 'sha'),
		];
	}

	public function run()
	{
		add_action('rest_api_init', [$this, 'endpoints']);
		add_filter('wp_nav_menu_args', [$this, 'navMenuArgs'], 1, 1);
		add_filter('nav_menu_css_class', [$this, 'menuItemClasses'], 10, 3);
		add_filter('nav_menu_link_attributes', [$this, 'menuLinkAttributes']);

		if (count($this->menus)) {
			add_action('after_setup_theme', [$this, 'themeSupport']);
		}
	}

	public function themeSupport()
	{
		add_theme_support('menu');
		register_nav_menus($this->menus);
	}

	public function navMenuArgs($args)
	{
		$slug = !empty($args['theme_location']) ? $args['theme_location'] : $args['menu'];
		$args['fallback_cb'] = false;
		$args['menu_class'] = "c-menu__entries c-menu__entries--{$slug}";
		return $args;
	}

	public function menuItemClasses($classes, $item, $args)
	{
		$slug = !empty($args->theme_location) ? $args->theme_location : $args->menu;
		$classes[] = "c-menu__entry c-menu__entry--{$slug}";

		if ($item->current) {
			$classes[] = 'c-menu__entry--current';
		}

		if ($item->current_item_ancestor) {
			$classes[] = 'c-menu__entry--current_item_ancestor';
		}

		if ($item->current_item_parent) {
			$classes[] = 'c-menu__entry--current_item_parent';
		}

		return $classes;
	}

	public function menuLinkAttributes($atts)
	{
		if (!isset($atts['class'])) {
			$atts['class'] = '';
		}
		$atts['class'] = (!empty($atts['class']) ? ' ' : '') . 'c-menu__entrylink';
		return $atts;
	}

	public function endpoints()
	{
		register_rest_route('sht', '/menus', array(
			'methods' => 'GET',
			'permission_callback' => '__return_true',
			'callback' => function () {
				if (empty($nav_menus = wp_get_nav_menus())) {
					return new WP_REST_Response($nav_menus);
				}

				$response_data = [];

				foreach (array_values($nav_menus) as $values) {
					$response_data[] = [
						'slug' => $values->slug,
						'id' => $values->term_id,
						'title' => $values->name
					];
				}

				return new WP_REST_Response($response_data);
			},
		));

		register_rest_route('sht', '/menu-positions', array(
			'methods' => 'GET',
			'permission_callback' => '__return_true',
			'callback' => function () {
				if (empty($nav_menus = get_registered_nav_menus())) {
					return new WP_REST_Response($nav_menus);
				}

				$response_data = [];

				foreach ($nav_menus as $key => $label) {
					$response_data[] = [
						'id' => $key,
						'title' => $label
					];
				}

				return new WP_REST_Response($response_data);
			},
		));
	}
}
