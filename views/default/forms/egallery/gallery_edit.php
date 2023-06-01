<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

$title = elgg_extract('title', $vars, '');
$description = elgg_extract('description', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, get_default_access());
$container_guid = elgg_extract('container_guid', $vars);
if (!$container_guid) {
    $container_guid = elgg_get_page_owner_guid();
}
$guid = elgg_extract('guid', $vars, null);

if ($description) {
    $description = str_replace('<br />','',$description);
}

// get the container entity
$container = get_entity($container_guid);

echo elgg_format_element('p', [], elgg_echo('egallery:add:requiredfields'));

echo elgg_view_field([
    '#type' => 'text',
    'name' => 'title',
    'value' => $title?$title:EntityGallery::setGalleryTitle($container),
    '#label' => elgg_echo('egallery:add:title'),
    '#help' => elgg_echo('egallery:add:title:help'),
    'required' => true,
]);

echo elgg_view_field([
    '#type' => 'longtext',
    'name' => 'description',
    'value' => $description,
    'rows' => 3,
    '#label' => elgg_echo('egallery:add:description'),
    '#help' => elgg_echo('egallery:add:description:help'),
]);

echo elgg_view_field([
    '#type' => 'tags',
    'name' => 'tags',
    'value' => $tags,
    '#label' => elgg_echo('egallery:add:tags'),
    '#help' => elgg_echo('egallery:add:tags:help'),
]);   

echo elgg_view_field([
    '#type' => 'access',
    'name' => 'access_id',
    'value' => $access_id,
    '#label' => elgg_echo('access'),
]); 

echo elgg_view_field([
    '#type' => 'dropdown',
    'id' => 'entity_gallery_comments_on',
    'name' => 'comments_on',
    'value' => elgg_extract('comments_on', $vars, 'On'),
    'options_values' => ['On' => elgg_echo('on'), 'Off' => elgg_echo('off')],
    '#label' => elgg_echo('comments'),
]);

?>

<div class="elgg-foot">
<?php
    if ($guid) {
        echo elgg_view_field([
            '#type' => 'hidden',
            'name' => 'guid',
            'value' => $guid,
        ]);        
    }

    echo elgg_view_field([
        '#type' => 'hidden',
        'name' => 'container_guid',
        'value' => $container_guid,
    ]);

    echo elgg_view_field([
        '#type' => 'submit',
        'value' => elgg_echo('submit')
    ]);   
?>
</div>
