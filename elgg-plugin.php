<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

return [
	'entities' => [
        [
            'type' => 'object',
            'subtype' => 'entity_gallery',
            'class' => 'EntityGallery',
            'searchable' => true,
        ],
        [
            'type' => 'object',
            'subtype' => 'gallery_item',
            'class' => 'GalleryItem',
            'searchable' => false,
        ]
    ],
	'settings' => [],
    'actions' => [
        'egallery/gallery_edit' => [],
        'egallery/gallery_item_del' => [],
        'egallery/get_latest_item' => [],
        'egallery/gallery_set_cover' => [],
        'egallery/gallery_item_edit' => [],
    ],
	'routes' => [
        'edit:object:entity_gallery' => [
			'path' => '/egallery/edit/{guid}',
			'resource' => 'egallery/gallery_edit',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
        ],
        'view:object:entity_gallery' => [
			'path' => '/egallery/view/{guid}/{title?}',
			'resource' => 'egallery/gallery_view',
		],
        'view:object:gallery_item:view' => [
			'path' => '/egallery/item/{guid}/{size?}/{file?}',
			'resource' => 'egallery/gallery_item_view',
		],
        'view:object:gallery_item:edit' => [
			'path' => '/egallery/item/edit/{guid}',
			'resource' => 'egallery/gallery_item_edit',
		],
    ],
	'widgets' => [],
    'views' => [
        'default' => [
            'egallery/graphics/' => __DIR__ . '/graphics',
        ],
    ],
    'upgrades' => [],
    'settings' => [
        'show_description' => false,
        'show_url' => true,
	],
];

