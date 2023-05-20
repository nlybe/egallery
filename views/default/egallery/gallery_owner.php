<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggUser) {
	return;
}

echo elgg_list_entities([
	'type' => 'object',
	'subtype' => 'entity_gallery',
	'owner_guids' => $entity->guid,
	'no_results' => elgg_echo('entity_gallery:none'),
]);
