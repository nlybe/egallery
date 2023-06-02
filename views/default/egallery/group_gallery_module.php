<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

$group = elgg_extract('entity', $vars);
if (!($group instanceof ElggGroup)) {
    return;
}

$all_link = elgg_view('output/url', [
    'href' => elgg_generate_url('collection:object:entity_gallery:group', [
        'guid' => $group->guid,
        'subpage' => 'all',
    ]),
    'text' => elgg_echo('link:view:all'),
    'is_trusted' => true,
]);

elgg_push_context('widgets');
$options = [
    'type' => 'object',
    'subtypes' => 'entity_gallery',
    'container_guid' => elgg_get_page_owner_guid(),
    'limit' => 4,
    'full_view' => false,
    'pagination' => false,
    'no_results' => elgg_echo('entity_gallery:none'),
];
$content = elgg_list_entities($options);
elgg_pop_context();

$add_link = elgg_view('output/url', [
    'href' => elgg_generate_url('edit:object:entity_gallery', ['guid' => $group->guid]),
    'text' => elgg_echo('egallery:add:gallery'),
    'is_trusted' => true,
]);

echo elgg_view('groups/profile/module', [
    'title' => elgg_echo('egallery:group'),
    'content' => $content,
    'all_link' => $all_link,
    'add_link' => $add_link,
]);
