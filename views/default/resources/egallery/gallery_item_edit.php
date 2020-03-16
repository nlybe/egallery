<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

$guid = elgg_extract('guid', $vars, '');
$file = get_entity($guid);

if (!$file->canEdit()) {
    echo elgg_format_element('h3', [], elgg_echo('egallery:invalid_access'));
}
else {
    $title = elgg_format_element('div', 
        ['class' => 'elgg-head'], 
        elgg_format_element('h3', [], elgg_echo('egallery:item:default_title'))
    );

    // create form
    $form_vars = array('name' => 'egallery_item', 'enctype' => 'multipart/form-data');
    $vars = entity_gallery_item_prepare_form_vars($file);
    $content = elgg_view_form('egallery/gallery_item_edit', $form_vars, $vars);

    $content = elgg_format_element('div', ['style' => 'width:800px;height:520px;padding: 10px; overflow-y: auto'], $content);
    echo elgg_format_element('div', ['class'=>'elgg-module elgg-module-info'], $title.$content); 
}
