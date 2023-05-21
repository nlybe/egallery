<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

/* @var $widget \ElggWidget */
$widget = elgg_extract('entity', $vars);

$num_display = (int) $widget->num_display ?: 4;
$options = [
	'type' => 'object',
	'subtype' => 'entity_gallery',
	'limit' => $num_display,
	'pagination' => false,
	'distinct' => false,
	'no_results' => elgg_echo('entity_gallery:none'),
];

$owner = $widget->getOwnerEntity();
if ($widget->context === 'profile' && $owner instanceof \ElggUser) {
	$options['owner_guid'] = $owner->guid;
	$url = elgg_generate_url('collection:object:entity_gallery:owner', ['username' => $owner->username]);
	// $options['widget_more'] = elgg_view_url($url, elgg_echo('egallery:galleries:more'));
}
else if ($widget->context === 'dashboard') {
	$url = elgg_generate_url('collection:object:entity_gallery:all');
}

echo elgg_list_entities($options);

if ($url) {
	echo elgg_view_url($url, elgg_echo('egallery:galleries:more'));
}
