# Puzzle WP Plugin framework
The framework provides basic routines that simplifies plugin development. It uses **app/config.php** file to define all
basic methods, configuration and assets. 

**Key features:**
- Quick and easy assets include
- Shortcodes API support
- Admin pages
- Metaboxes
- AJAX-based API
- REST API
- Custom posts and taxonomies support ``(upcoming)``

## Installation

1. Copy the plugin folder to your staging
2. Do a basic setup (see next chapter)
3. Configure the plugin (saves lots of dev time)
4. Ready for coding!

##Setup
What should be done for a new project launch:

####1. Namespace, files, constants change

* Namespace should be changed for all files from the default ``PuzzleCodebase`` to a custom one.
* ``plugin-codebase.php`` - customize file name and plugin metadata to comply your project settings (plugin title, author, etc)

####2. Basic configuration

Following properties from the ``app/config.php`` should be set to custom ones:
* ``projectID`` - project identifier
* ``version`` - plugin version
* ``textdomain`` - a string for i18n

####3. Advanced configuration

Any other **app/config.php** modifications according to plugin purposes

####4. Methods and models

Codebase modifications according to required methods and entities

## Plugin structure

.
├── app
    ├── controllers
    ├── framework
    ├── views
    ├── autoload.php
    ├── config.php
├── .gitignore
├── plugin-codebase.php
├── readme.md

* `./app` - plugin code lives here
* `./app/controllers` - basically the code you should change
* `./app/framework` - framework files. Not to be changed unless you really want to
* `./app/views` - plugin templates
* `./assets` - where all the assets lie
* `.gitignore` - gitignore file
* `plugin-codebase.php` - base plugin file
* `readme.md` - this file (the docs)

# Config params

Params for **config.php** and project configuration:

## projectID ``string``

ID of the project. Can be used in various places. For example, in asset ids.

**Example:**

`'projectId' => 'puzzle-codebase'`

##version ``string``

Version of the plugin. Used primarily for assets    

**Example:**

`'version' => '1.0.2b'`

## mode ``string``

Plugin work mode. Used for development purposes, for example    

**Values list**

* ``develop`` - the plugin is in a development mode. All assets have version equal to current timestamp
* ``production`` - the plugin is in a production mode. All assets have version equal to ``version``  parameter value

**Example:**

`'mode' => 'develop'`

##textdomain ``string``

ID string for i18n. Used in translatable strings (``_t()`` function)

**Example:**

`'textdomain' => 'puzzle-codebase'`

## assets ``array``

Assets for plugin, CSS and JS. This item contains four sections:

* ``css`` - CSS for public part of the website
* ``css-dash`` - CSS for dashboard
* ``js`` - JS for public part of the website
* ``js-dash`` - JS for dashboard    

**Example:**

```
    'assets' => [
        'css'=> [
            [
                'name'=> 'styles',
                'path'=> 'assets/css/style.css'
            ]
        ],
        'css-dash'=> [
            [
                'name'=> 'dashstyles',
                'path'=> 'assets/css-admin/style.css'
            ],
        ],
        'js'=> [
            [
                'name'=> 'ui-js',
                'path'=> 'assets/js/ui.js',
                'object'=> 'PuzzleApp',
                'object_data'=> 'SystemApiController:uiJsData'
            ]
        ],
        'js-dash'=> [
            [
                'name'=> 'ui-js',
                'path'=> 'assets/js-admin/ui.js',
                'object'=> 'PuzzleApp',
                'object_data'=> 'ApiController:uiJsData'
            ],
        ]
```

Parameters for ```css``` and ``css-dash``:
* ``name`` - name for registering an asset 
* ``path`` - path to the asse relative to plugin root

Parameters for **js** and **js-dash**:
* ``name`` - name for registering an asset 
* ``path`` - path to the asset relative to plugin root
* ``object`` - object name for localization and data provided from back-end
* ``object_data`` - a reference to the function preparing data for object (localization or any other data) 
 
## shortcodes ``array``

Array defining shortcodes plugin uses

**Example:**
```
'shortcodes'=> [
    'shortcode_sample' => [
        'attributes' => [
            'id' => null,
            'title' => ''
        ],
        'load'=> "DataController:dataLoaded",
        'view' => "shortcodes/showData"
    ]
],
```

**Parameters:**
* ``Array key`` - shortcode name. ``shortcode_sample`` in example
* ``atributes`` - array with atributes for the shortcode. Key is the attribute name and value is the default value
* ``load`` - a reference to data loader function
* ``view`` - a reference for shortcode display template

## middleware ``array``

Hooks for any action plugin uses.

**Example:**
```
"middleware"=> [
    "wp_loaded"=> [
        [
            "controller"=> "PDFController:make",
            "load"=> "DataController:pdfDataLoad",
            "view"=> "pdf/firstReport"
        ]
    ]
]
```

**Parameters:**
* ``Array key`` - action the plugin should handle
* ``controller`` - a function handles the action 
* ``load`` - a reference to data loader function
* ``view`` - a reference to template middleware could use

## pages ``array``

Plugin settings pages

Example:
```
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
            "view"=> "settings/settings",
            "load"=> "DataController:settingsLoad",
            "parent_slug"=> "plugin-testy-settings"
        ],
    ]
```

Parameters:
* ``name`` - page name
* ``menu`` - menu name
* ``slug`` - menu slug
* ``caps`` - permissions required to access the page
* ``vuew`` - page template reference
* ``load`` - data loader function
* ``icon`` - menu icon
* ``position`` - position in dashboard menu
* ``parent_slug`` - for child menus. Parent menu slug

## metaboxes ``array``

Metaboxes list the plugin should create.

**Example:**

```
    "metaboxes"=> [
        [
            "id"=> "metabox_test",
            "name"=> "Test Metabox",
            "screen"=> "manage_options",
            "show_in"=> [
                "page"
            ],
            "view"=> "metaboxes/testMeta",
            "load"=> "DataController:metaboxDataGet",
            "save"=> "DataController:metaboxDataSave",
            "save_data"=> [
                "test_data",
            ]
        ]
    ]
```

Parameters:
* ``id`` - metabox ID
* ``name`` - metabox name
* ``show_in`` - post types array defining where the metabox should appear 
* ``view`` - a reference for metabox template
* ``load`` - data loader reference
* ``save`` - save function reference
* ``save_data`` - data that should be collected from ``$_POST`` in save function
            
## api ``array``

AJAX methods the plugin uses

**Example:**
```
"api"=> [
    [
        "action" => "track_time",
        "auth" => true,
        "handler" => "ApiController:tracker"
    ]
]
```

**Parameters:**
* ``action`` - action name the plugin handles
* ``auth`` - boolean type. ``true`` means the action is only accessible for registered users. ``false`` means it is also available for guests
* ``handler`` - a function that handles requests

## rest ``array``

REST API functons list

**Example:**
```
'rest' => [
    [
        'namespace' => 'puzzle-api/v1',
        'routes' => [
            '/route' => [
                'methods' => ['GET'],
                'callback' => 'RestController:test',
                'permission_callback' => '',
                'args' => []
            ]
        ]
    ]
]
```

**Parameters:**
* ``namespace`` - API namespace (``string``)
* ``routes`` - API methods (``array``)

**API Methods parameters:** 
* ``Array key`` - API route
* ``methods`` - request types the plugin handles
* ``callback`` - a callable the plugin uses for the API method
* ``permission_callback`` - a callback to check if user allowed to use the API method
* ``args`` - method args (see ``register_rest_route`` in WP REST API docs)

## Callables

Callables are references to classes and their methods that do some actions: loading data, handling WP actions, etc

Callables are used for defining handlers for events, apis, etc

All callables uses the same format: 

```
ClassName:classMethod
```
or:
```
Namespace\Subnamespace\ClassName:classMethod
```

If ``Namespace`` part is not specified, default (main plugin) namespace is used.
So if you have ``PuzzleCodebase`` as the default namespace and used ``DataController:loadData`` as callable, the framework will try to call
``PuzzleCodebase\DataController->loadData()`` as result 

In a specified namespace macro ``__NAMESPACE__`` can be used. It will be replaced with the default plugin namespace. So you can specify ``%NAMESPACE%\Controllers``
and it will be translated to ``PuzzleCodebase\Controlers`` if ``PuzzleCodebase`` is the default namespace

## Data API

There are a lot of ``'load'`` keys in the config array. Each value defines a callable which handles specific part of your plugin.

Each callable should return a ``key => value`` array. The framework then uses ``extract()`` function, so all items returned in data array can be used as  ``$key`` variable.

## JS API

JS API is provided by JS data object you can use by setting ``SystemApiController:jsData`` as JS asset object_data value. I.e.:

```
"assets"=> [
...
    "js"=> [
        [
            ...
            "object" => 'Any_name_you_like',
            "object_data"=> "SystemApiController:uiJsData"
        ]
    ],

```

It provides you with the object:

* ``ajax_url`` -  AJAX url for api calls, used ``admin_url('admin-ajax.php')``
* ``auth`` - whether user logged in or not, used ``is_user_logged_in()``
* ``user_id`` - user ID for logged in users, used ``get_current_user_id()``
* ``page_id`` - page ID if you're on public part of the website in single post page. Uses ``Application::inst()->getCurrentPage()``
* ``term`` - array contains ``term_id`` and `taxonomyy` if you're on taxonomy term page. Uses ``Application::inst()->getCurrentTerm()``
* ``admin_page`` - admin page ID if you're on dashboard page. Uses ``Application::inst()->getCurrentAdminPage()``

Items ``page_id``, ``term`` and ``admin_page`` are only set if they're applicable. So ``isset(key)`` can be used to check if you're on single page, term page or admin page.

It you want your own JS data object, you can use the very same functions in your data generation function.