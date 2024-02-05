<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

$item = elgg_extract('item', $vars);
if (!$item instanceof ElggRiverItem) {
	return;
}

$object = $item->getObjectEntity();
$container = $object->getContainerEntity();
$vars['message'] = elgg_echo("river:object:entity_gallery:container", [
	elgg_view('output/url', [
		'href' => $container->getURL(),
		'title' => elgg_echo('egallery:add:value', [$container->getDisplayName()]),
		'text' => $container->getDisplayName(),
	])
]);
$vars['message'] .= $entity->description?elgg_get_excerpt($entity->description):'';

echo elgg_view('river/elements/layout', $vars);
