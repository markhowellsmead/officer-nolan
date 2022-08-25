<?php

namespace SayHello\Theme\Block;

/**
 * PrimaryMedia Block
 *
 * @author Mark Howells-Mead <mark@sayhello.ch>
 */
class PrimaryMedia
{

	public function run()
	{
		add_action('init', [$this, 'registerBlocks']);
	}

	public function registerBlocks()
	{
		register_block_type('sht/primary-media', [
			'render_callback' => [$this, 'renderBlock'],
			'attributes' => [
				'align' => [
					'type'  => 'string',
				],
			],
		]);
	}

	public function renderBlock($attributes, $content, $block)
	{
		ob_start();
		get_template_part('partials/block/primary-media', null, [
			'attributes' => $attributes,
			'block' => $block
		]);
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}
