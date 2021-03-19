<?php 
    return [
        "projectId"=> "puzzle-codebase",
        "version"=> "0.1",
        "mode"=> "develop",
        "textdomain"=> "puzzle-codebase",
        "assets"=> [
            "css"=> [
                [
                    "name"=> "styles",
                    "path"=> "assets/css/style.css"
                ]
            ],
            "css-dash"=> [
                [
                    "name"=> "dash-styles",
                    "path"=> "assets/css-admin/style.css"
                ],
            ],
            "js"=> [
                [
                    "name"=> "ui-js",
                    "path"=> "assets/js/ui.js",
                    "object"=> "PuzzleApp",
                    "object_data"=> "ApiController:uiJsData"
                ]
            ],
            "js-dash"=> [
                [
                    "name"=> "ui-js",
                    "path"=> "assets/js-admin/ui.js",
                    "object"=> "PuzzleApp",
                    "object_data"=> "ApiController:uiJsData"
                ],
            ]
        ],
        "shortcodes"=> [
            "test_shortcode"=> [
                "attributes"=> [
                    "id"=> null,
                    "title"=> ""
                ],
                "load"=> "DataController:showStats",
                "view"=> "shortcodes/showstats"
            ]
        ],
        "middleware"=> [
            /*"wp_loaded"=> [
                [
                    "controller"=> "PDFController:make",
                    "load"=> "DataController:pdfDataLoad",
                    "view"=> "pdf/firstReport"
                ]
            ]*/
        ],
        "pages"=> [
            [
                "name"=> "Test Page",
                "menu"=> "Testy Page",
                "slug"=> "plugin-testy-settings",
                "caps"=> "manage_options",
                "view"=> "settings/settings",
                "load"=> "DataController:settingsLoad",
                "icon"=> "dashicons-schedule",
                "position"=> 3
            ],
            [
                "name"=> "Testy Stats",
                "menu"=> "Statsy Test",
                "slug"=> "testy-stats",
                "caps"=> "manage_options",
                "view"=> "settings/settingsSub",
                "load"=> "DataController:settingsSub",
                "parent_slug"=> "plugin-testy-settings"
            ],
        ],
        "metaboxes"=> [
            /*[
                "id"=> "metabox_test",
                "name"=> "Test Metabox",
                "show_in"=> [
                    "page"
                ],
                "view"=> "metaboxes/testMeta",
                "load"=> "DataController:metaboxDataGet",
                "save"=> "DataController:metaboxDataSave",
                "save_data"=> [
                    "test_data",
                ]
            ]*/
        ],
        "api"=> [
            [
                "action" => "time-tracker",
                "auth" => true,
                "handler" => "ApiController:track"
            ],
        ],
        'rest' => [
            [
                'namespace' => 'puzzle-api/v1',
                'routes' => [
                    '/route' => [
                        'requests' => ['GET'],
                        'callback' => 'RestController:test',
                        'permission_callback' => '',
                        'args' => []
                    ]
                ]
            ]
        ]
    ];
