<?php namespace PuzzleCodebase\Framework\Controllers;

use PuzzleCodebase\Factories\MetaboxesFactory;
use PuzzleCodebase\Factories\DashboardPagesFactory;
use PuzzleCodebase\Factories\ShortcodesFactory;
use PuzzleCodebase\Controllers;

use WP_Post;

/**
 * Application class
 */
class Application
{
    private static $instance = null;
    private static $data = [];
    private static $url = null;

    private $currentPage = null;
    private $currentTerm = null;
    private $currentTax = null;
    private $currentPageAdmin = null;

    function __construct()
    {
        $plugin_data = require_once(__DIR__ . '/../../config.php');
        self::$data = $plugin_data;

        self::$url = constant(__NAMESPACE__ . '_PLUGIN_URL');

        add_action('init', [$this, 'init']);
        add_action('template_redirect', [$this, 'initPages']);

        $this->shortcodes();
        $this->middleware();
    }

    /**
     * Inits singleton class or returns existing instance
     * @return Application
     */
    static function inst()
    {
        if (self::$instance == null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Prepares and returns items from $_POST array
     * @param $keys
     * @return array
     */
    static function postData($keys)
    {
        $postData = [];
        foreach ((array)$keys as $key) {
            $postData[$key] = $_POST[$key] ?? '';
        }
        return $postData;
    }

    /**
     * Make a function call based on passed parameters
     * @param mixed $func
     * @param array $args
     * @return mixed
     */
    static function call(mixed $func, array $args = [])
    {
        if (is_callable($func)) {
            return $func($args);
        }
        extract(self::getCallable($func));
        /**
         * @var $class - extracted class name
         * @var $function - extracted class method name
         */
        return $class->$function($args);
    }

    /**
     * Extract a class name and a function from string
     * @param string $function
     * @return array
     */
    static function getCallable(string $function)
    {
        $call = explode(':', $function);
        if (strpos($call[0], '\\')) {
            $call[0] = str_replace('%NAMESPACE%', __NAMESPACE__, $call[0]);
        } else {
            $call[0] = '\\' . __NAMESPACE__ . '\\' . $call[0];
        }
        return ['class' => new $call[0], 'function' => $call[1]];
    }

    /**
     * Shortcodes init
     */
    function shortcodes()
    {
        $shortcodes = self::$data['shortcodes'];
        foreach ($shortcodes as $shortcode => $data) {
            $shortcodeItem = ShortcodesFactory::bake($data);
            add_shortcode($shortcode, [$shortcodeItem, 'launch']);
        }
    }

    /**
     * Middleware init
     */
    function middleware()
    {
        $middleware = self::$data['middleware'];
        foreach ($middleware as $key => $section) {
            foreach ($section as $object) {
                $middlewareItem = new MiddlewareController($object);
                add_action($key, [$middlewareItem, 'launch']);
            }
        }
    }

    /**
     * Gets application data or
     * @param string $item
     * @return mixed
     */
    static function dataGet(string $item = '')
    {
        if (self::$instance == '') {
            self::inst();
        }
        if ($item && isset(self::$data[$item])) {
            return self::$data[$item];
        }
        return self::$data;
    }

    /**
     * Pages init
     */
    function initPages()
    {
        $object = get_queried_object();
        $this->currentPage = is_page() ? $object->ID : null;
        if (is_tax()) {
            $this->curentTerm = $object->term_id;
            $this->curentTax = $object->taxonomy;
        }
    }

    /**
     * Application init
     */
    function init()
    {
        /**
         * Init assets - CSS
         */
        add_action('wp_enqueue_scripts', function () {
            $data = Application::dataGet();
            $styles = $data['assets']['css'];
            $scripts = $data['assets']['js'];
            foreach ($styles as $style) {
                wp_enqueue_style(
                    $data['projectId'].'_'.$style['name'], self::$url . $style['path'], $style['deps'] ?? [],
                    (WP_DEBUG || $data['mode'] == 'develop') ? time() : (self::$data['version'] ?? false)
                );
            }
            foreach ($scripts as $script) {
                wp_enqueue_script(
                    $data['projectId'].'_'.$script['name'], self::$url . $script['path'], $script['deps'] ?? [],
                    WP_DEBUG ? time() : (self::$data['version'] ?? false)
                );
                if ($script['object']) {
                    $data = Application::call($script['object_data']);
                    wp_localize_script($script['name'], $script['object'], $data);
                }
            }
        });

        /**
         * Init assets - JS
         */
        add_action('admin_enqueue_scripts', function () {
            $data = Application::dataGet();

            $styles = $data['assets']['css-dash'];
            $scripts = $data['assets']['js-dash'];
            foreach ($styles as $style) {
                wp_enqueue_style(
                    $data['projectId'].'_'.$style['name'], self::$url . $style['path'], $style['deps'] ?? [],
                    WP_DEBUG ? time() : (self::$data['version'] ?? false)
                );
            }
            foreach ($scripts as $script) {
                wp_enqueue_script(
                    $data['projectId'].'_'.$script['name'], self::$url . $script['path'], $script['deps'] ?? [],
                    WP_DEBUG ? time() : (self::$data['version'] ?? false)
                );
                if ($script['object']) {
                    $data = Application::call($script['object_data']);
                    wp_localize_script($script['name'], $script['object'], $data);
                }
            }

        });

        /**
         * Init admin menu
         */
        add_action('admin_menu', function () {
            $pages = self::$data['pages'];
            foreach ($pages as $page) {
                $adminPage = DashboardPagesFactory::bake($page);
            }

        });

        /**
         * Register metaboxes
         */
        add_action('add_meta_boxes', [$this, 'initMetaBoxes'], 10, 2);

        /**
         * Register save post handler
         */
        add_action('save_post', [$this, 'postSave'], 10, 3);

        /**
         * Register REST API route
         */
        add_action( 'rest_api_init', [$this, 'initRest']);

        /**
         * Launch AJAX API
         */
        $this->initApi();

    }

    /**
     * AJAX API init
     */
    private function initApi()
    {
        $api = self::$data['api'];
        foreach ($api as $item) {
            $call = self::getCallable($item['handler']);

            $class = $call['class'];
            $function = $call['function'];

            // ToDo: this needs three states: authenticated, not authenticated, both
            add_action('wp_ajax_' . $item['action'], [$class, $function]);

            if ($item['auth'] === false) {
                add_action('wp_ajax_nopriv_' . $item['action'], [$class, $function]);
            }


        }
    }

    /**
     * REST API init
     */
    private function initRest() {
        $rest = self::$data['rest'];
        foreach ($rest as $item) {
            foreach ($item['routes'] as $key => $route) {
                register_rest_route($item['namespace'], $key, $route);
            }
        }
    }

    /**
     * @param int $post_id
     * @param WP_Post $post
     * @param bool $update
     */
    public function postSave(int $post_id, WP_Post $post, bool $update)
    {
        $metaboxes = self::$data['metaboxes'];
        foreach ($metaboxes as $mtb) {
            DashboardPagesFactory::bake($mtb)->save($mtb, $post_id, $post, $update);
        }
    }

    /**
     * Metaboxes init
     * @param string $post_type
     * @param WP_Post $post
     */
    public function initMetaBoxes(string $post_type, WP_Post $post)
    {
        $this->currentPageAdmin = $post;
        $metaboxes = self::$data['metaboxes'];
        foreach ($metaboxes as $mtb) {
            MetaboxesFactory::bake($mtb)->init($mtb);
        }
    }

    /**
     * Gets current admin page
     * @return int
     */
    public function getCurrentAdminPage()
    {
        return $this->currentPageAdmin->ID;
    }

    /**
     * Gets current website page
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * Gets current term page
     * @return array
     */
    public function getCurrentTerm()
    {
        $current_id = $this->currentTerm;
        $current_tax = $this->currentTax;
        return ['term_id' => $current_id, 'taxonomy' => $current_tax];
    }

    /**
     * Actions on plugin activation
     */
    function pluginActivated()
    {
        DataController::inst()->initTables();
    }

    /**
     * Actions on plugin deactivation
     */
    function pluginDeactivated() {
        DataController::inst()->deInitTables();
    }
}
