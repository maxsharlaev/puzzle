<?php

namespace PuzzleCodebase;

/**
 * Main Puzzle framework config file
 */
    return [
        'projectId'=> 'puzzle-codebase',
        'version'=> '0.1',
        'mode'=> 'develop',
        'textdomain'=> 'puzzle-codebase',
        'assets'=> [
            'css'=> [
                [
                    'name'=> 'styles',
                    'path'=> 'assets/css/style.css'
                ]
            ],
            'css-dash'=> [
                [
                    'name'=> 'dash-styles',
                    'path'=> 'assets/css-admin/style.css'
                ],
            ],
            'js'=> [
                [
                    'name'=> 'ui-js',
                    'path'=> 'assets/js/ui.js',
                    'object'=> 'PuzzleApp',
                    'object_data'=>  __NAMESPACE__.'\Puzzle\ApiController:jsData'
                ]
            ],
            'js-dash'=> [
                [
                    'name'=> 'ui-js',
                    'path'=> 'assets/js-admin/ui.js',
                    'object'=> 'PuzzleApp',
                    'object_data'=> __NAMESPACE__.'\Puzzle\JSApiController:jsData'
                ],
            ]
        ],
        'shortcodes'=> [
            /**
             *  'test_shortcode'=> [
             *      'attributes'=> [
             *          'id'=> null,
             *          'title'=> '',
             *      ],
             *      'load'=> 'DataController:showStats',
             *      'view'=> 'shortcodes/showstats'
             *  ],
             */
        ],
        'middleware'=> [
            /**
             * Example:
             *  'wp_loaded'=> [
             *      [
             *          'controller'=> 'PDFController:make',
             *          'load'=> 'DataController:pdfDataLoad',
             *          'view'=> 'pdf/firstReport'
             *      ],
             *  ],
             */
        ],
        'pages'=> [
            /**
             * Example main page:
             *  [
             *      'name'=> 'Test Page',
             *      'menu'=> 'Testy Page',
             *      'slug'=> 'plugin-testy-settings',
             *      'caps'=> 'manage_options',
             *      'view'=> 'settings/settings',
             *      'load'=> 'DataController:settingsLoad',
             *      'icon'=> 'dashicons-schedule',
             *      'position'=> 3
             *  ],
             *
             * Example subpage:
             *  [
             *      'name'=> 'Testy Stats',
             *      'menu'=> 'Statsy Test',
             *      'slug'=> 'testy-stats',
             *      'caps'=> 'manage_options',
             *      'view'=> 'settings/settingsSub',
             *      'load'=> 'DataController:settingsSub',
             *      'parent_slug'=> 'plugin-testy-settings'
             *  ],
             */
        ],
        'metaboxes'=> [
            /**
             * Example:
             *  [
             *      'id'=> 'metabox_test',
             *      'name'=> 'Test Metabox',
             *      'show_in'=> [
             *          'page'
             *      ],
             *      'view'=> 'metaboxes/testMeta',
             *      'load'=> 'DataController:metaboxDataGet',
             *      'save'=> 'DataController:metaboxDataSave',
             *      'save_data'=> [
             *          'test_data',
             *      ]
             *  ],
             */
        ],
        'api'=> [
                /**
                 * Example:
                 *  [
                 *      'action' => 'test',
                 *      'auth' => true,
                 *      'handler' => 'ApiController:test'
                 *  ],
             */
        ],
        'rest' => [
            /**
             *  Example:
             *  [
             *      'namespace' => 'puzzle-api/v1',
             *      'routes' => [
             *          '/route' => [
             *              'requests' => ['GET'],
             *              'callback' => 'RestController:test',
             *              'permission_callback' => '',
             *              'args' => []
             *          ],
             *      ],
             *  ],
             */
        ]
    ];
