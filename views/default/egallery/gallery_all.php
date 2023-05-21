<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

$defaults = [
	'type' => 'object',
	'subtype' => 'entity_gallery',
	'full_view' => false,
	'no_results' => elgg_echo('entity_gallery:none'),
	'distinct' => false,
];

$options = (array) elgg_extract('options', $vars, []);
$options = array_merge($defaults, $options);
echo elgg_list_entities($options);
