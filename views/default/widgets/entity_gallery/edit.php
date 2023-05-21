<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 *
 * User gallery widget edit view
 */

$widget = elgg_extract('entity', $vars);

echo elgg_view('object/widget/edit/num_display', [
	'entity' => $widget,
	'label' => elgg_echo('egallery:numbertodisplay'),
	'default' => 4,
]);
