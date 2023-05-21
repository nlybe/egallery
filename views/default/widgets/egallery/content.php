<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

/* @var $widget \ElggWidget */
$widget = elgg_extract('entity', $vars);

$num_display = (int) $widget->num_display ?: 4;

$owner = $widget->getOwnerEntity();
$options = [
	'type' => 'object',
	'subtype' => 'entity_gallery',
	'owner_guids' => $entity->owner,
	'limit' => $num_display,
	'pagination' => false,
	'distinct' => false,
	'no_results' => elgg_echo('entity_gallery:none'),
];

if ($owner instanceof \ElggUser) {
	$options['owner_guid'] = $owner->guid;
	$url = elgg_generate_url('collection:object:entity_gallery:owner', ['username' => $owner->name]);

	$options['widget_more'] = elgg_view_url($url, elgg_echo('egallery:galleries:more'));
} 

echo elgg_list_entities($options);
