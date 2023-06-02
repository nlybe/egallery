<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

$container = elgg_extract('container', $vars);
if (!$container instanceof ElggGroup) {
	return;
}

echo elgg_list_entities([
	'type' => 'object',
	'subtype' => 'entity_gallery',
	'container_guids' => $container->guid,
	'no_results' => elgg_echo('entity_gallery:none'),
]);
