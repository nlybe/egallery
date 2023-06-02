<?php
/**
 * Elgg Entities Gallery
 * @package egallery 
 */

use Egallery\Elgg\Bootstrap;

require_once(dirname(__FILE__) . '/lib/hooks.php');
require_once(dirname(__FILE__) . '/lib/functions.php');

return [
    'plugin' => [
        'name' => 'Entities Gallery',
		'version' => '4.3',
		'dependencies' => [
			'dropzonejs_api' => [
				'must_be_active' => true,
                'version' => '>4'
			]
		],
	],	
    'bootstrap' => Bootstrap::class,
	'entities' => [
        [
            'type' => 'object',
            'subtype' => 'entity_gallery',
            'class' => 'EntityGallery',
            'capabilities' => [
				'commentable' => true,
				'searchable' => true,
				'likable' => true,
			],
        ],
        [
            'type' => 'object',
            'subtype' => 'gallery_item',
            'class' => 'GalleryItem',
            'searchable' => false,
            'capabilities' => [
				'commentable' => true,
				'searchable' => true,
				'likable' => true,
			],
        ]
    ],
	'actions' => [
        'egallery/gallery_edit' => [],
		'egallery/gallery_import' => [],
        'egallery/gallery_delete' => [],
		'egallery/gallery_item_delete' => [],
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
        'import:object:entity_gallery' => [
			'path' => '/egallery/import/{guid}',
			'resource' => 'egallery/gallery_import',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],
        'view:object:entity_gallery' => [
			'path' => '/egallery/view/{guid}/{title?}',
			'resource' => 'egallery/gallery_view',
		],
        'view:object:gallery_item' => [
			'path' => '/egallery/photo/{guid}/{title?}',
			'resource' => 'egallery/gallery_item_display',
		],
        'view:object:gallery_item:view' => [
			'path' => '/egallery/item/{guid}/{size?}/{file?}',
			'resource' => 'egallery/gallery_item_view',
		],
        'view:object:gallery_item:edit' => [
			'path' => '/egallery/item/edit/{guid}',
			'resource' => 'egallery/gallery_item_edit',
			'middleware' => [
				\Elgg\Router\Middleware\Gatekeeper::class,
			],
		],
		'collection:object:entity_gallery:owner' => [
			'path' => '/egallery/owner/{username}',
			'resource' => 'egallery/gallery_owner',
		],
		'collection:object:entity_gallery:all' => [
			'path' => '/egallery',
			'resource' => 'egallery/gallery_all',
		],
		'collection:object:entity_gallery:friends' => [
			'path' => '/egallery/friends/{username}',
			'resource' => 'egallery/gallery_friends',
		],
        'collection:object:entity_gallery:group' => [
            'path' => '/egallery/group/{guid}/{subpage?}',
			'resource' => 'egallery/gallery_group',
            'defaults' => [
                'subpage' => 'all',
            ],
        ],
    ],
	'hooks' => [
		'entity:url' => [
			'object' => [
				'egallery_object_set_url' => [ 'priority' => 400],
				'egallery_item_object_set_url' => [ 'priority' => 450],
			],
		],
		'register' => [
			'menu:entity' => [
				'egallery_entity_menu_setup' => [],
			],
			'menu:owner_block' => [
				'egallery_gallery_owner_menu' => [],
			],
		],
		'upload:after' => [
			'dropzonejs_api' => [
				'egallery_item_upload' => [],
			],
		],
		'view_vars' => [
			'object/elements/full' => [
				'egallery_filter_full_view_vars' => [],
			],
		],
		'prepare' => [
			'menu:title:object:entity_gallery' => [
				'egallery_title_menu_setup' => [],
			],
		],
	],
    'settings' => [
        'show_description' => 'no',
        'show_url' => 'yes',
		'gallery_url_include_title' => 'yes',
		'gallery_site_menu_item' => 'yes',
		'enable_tidypics_import' => 'no',
		'tidypics_import_admin_only' => 'no',
	],
	'widgets' => [
		'entity_gallery' => [
			'context' => ['profile', 'dashboard', 'groups'],
		],
	],
	'view_extensions' => [
		'elgg.css' => [
			'egallery/egallery.css' => [],
		],
		'css/admin' => [
			'egallery/egallery_admin.css' => [],
		],
	],
];

