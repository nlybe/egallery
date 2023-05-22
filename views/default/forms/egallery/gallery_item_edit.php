<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

use Egallery\EgalleryOptions;

$title = elgg_extract('title', $vars, '');
$url = elgg_extract('url', $vars, '');
$description = elgg_extract('description', $vars, '');
// $category = elgg_extract('category', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, get_default_access());
$container_guid = elgg_extract('container_guid', $vars);
$guid = elgg_extract('guid', $vars, null);

if ($description) {
    $description = str_replace('<br />','',$description);
}

echo elgg_format_element('p', [], elgg_echo('egallery:add:requiredfields'));

echo elgg_view_field([
    '#type' => 'text',
    'name' => 'title',
    'value' => $title,
    '#label' => elgg_echo('egallery:item:add:title'),
    '#help' => elgg_echo('egallery:item:add:title:help'),
    'required' => true,
]);

if (EgalleryOptions::displayImageDescription()) {
    echo elgg_view_field([
        '#type' => 'plaintext',
        'name' => 'description',
        'value' => $description,
        '#label' => elgg_echo('egallery:item:add:description'),
        '#help' => elgg_echo('egallery:item:add:description:help'),
    ]);
}

if (EgalleryOptions::displayImageURL()) {
    echo elgg_view_field([
        '#type' => 'url',
        'name' => 'url',
        'value' => $url,
        '#label' => elgg_echo('egallery:item:add:url'),
        '#help' => elgg_echo('egallery:item:add:url:help'),
    ]);
}

echo elgg_view_field([
    '#type' => 'tags',
    'name' => 'tags',
    'value' => $tags,
    '#label' => elgg_echo('egallery:add:tags'),
    '#help' => elgg_echo('egallery:add:tags:help'),
]);   

echo elgg_view_field([
    // '#type' => 'access',
    '#type' => 'hidden',
    'name' => 'access_id',
    'value' => $access_id,
    '#label' => elgg_echo('access'),
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
        'value' => elgg_echo('save')
    ]);
?>
</div>

