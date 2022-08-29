<?php

namespace SayHello\Theme\Block;

use DOMDocument;
use DOMXPath;

/**
 * Comment Author Name block
 *
 * @author Say Hello GmbH <hello@sayhello.ch>
 */
class CommentAuthorName
{

	public function run()
	{
		add_action('render_block', [$this, 'renderBlock'], 10, 2);
	}

	/**
	 * Remove empty link attribute
	 *
	 * @param string $html
	 * @param array $block
	 * @return string
	 */
	public function renderBlock(string $html, array $block)
	{

		if ($block['blockName'] !== 'core/comment-author-name') {
			return $html;
		}

		libxml_use_internal_errors(true);
		$document = new DOMDocument();
		$document->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

		$className = $document->documentElement->childNodes[0]->childNodes[0]->getAttribute('href');

		$xpath = new DOMXPath($document);
		$links = $xpath->query('//a');

		if (!$links->length) {
			return $html;
		}

		foreach ($links as $link) {
			if (empty(trim($link->getAttribute('href')))) {
				$text = $document->createTextNode($link->textContent);
				$link->parentNode->replaceChild($text, $link);
			}
		}

		$body = $document->saveHtml($document->getElementsByTagName('body')->item(0));
		return str_replace(['<body>', '</body>'], '', $body);
	}
}
