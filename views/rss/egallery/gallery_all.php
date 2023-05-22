<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 *
 * Note: this view has a corresponding view in the default view type, changes should be reflected
 */

echo elgg_list_entities([
	'type' => 'object',
	'subtype' => 'entity_gallery',
	'distinct' => false,
	'pagination' => false,
]);
