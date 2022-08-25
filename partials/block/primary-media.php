<?php

$post_id = get_the_ID();
$classNameBase = wp_get_block_default_classname($args['block']->name);
$align = $args['attributes']['align'] ?? '';

$media_size = 'medium';
switch ($align) {
	case 'wide':
		$media_size = 'gutenberg_wide';
		break;
	case 'full':
		$media_size = 'full';
		break;
}

$content = '';

if (has_post_thumbnail($post_id)) {

	$image = wp_get_attachment_image(get_post_thumbnail_id($post_id), $media_size, false, ['class' => "{$classNameBase}__image"]);

	if (!empty($image)) {
		ob_start();
		printf('<figure class="%1$s__figure %1$s__figure--%2$s">%3$s</figure>', $classNameBase, $media_size, $image);
		$content = ob_get_contents();
		ob_end_clean();
	}
}

if (empty($content)) {
	return;
}

if (!empty($align)) {
	$align = " align{$align}";
}

?>

<div class="<?php echo $classNameBase . $align; ?>">
	<?php echo $content; ?>
</div>
