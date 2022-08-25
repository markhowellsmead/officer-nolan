<?php

namespace SayHello\Theme\Package;

/**
 * Assets (CSS, JavaScript etc)
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class Assets
{
	public function run()
	{
		add_action('wp_enqueue_scripts', [$this, 'registerAssets']);
	}

	public function registerAssets()
	{

		if (!is_user_logged_in()) {
			wp_deregister_style('dashicons');
		}

		$min = !sht_theme()->debug;

		$deps = ['wp-block-library'];

		wp_enqueue_style('sht-style', get_template_directory_uri() . '/assets/styles/ui' . ($min ? '.min' : '') . '.css', $deps, filemtime(get_template_directory() . '/assets/styles/ui' . ($min ? '.min' : '') . '.css'));
	}
}
