<?php
/**
 * Elgg Entities Gallery
 * @package egallery
 *
 * Note: this view has a corresponding view in the default view type, changes should be reflected
 *
 * @uses $vars['entity']
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggUser) {
	return;
}

echo elgg_list_entities([
	'type' => 'object',
	'subtype' => 'entity_gallery',
	'owner_guids' => $entity->guid,
	'pagination' => false,
]);
