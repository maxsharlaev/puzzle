<?php
namespace PluginCodebase;

class Application {
    private static $instance = null;
    private static $data = null;
    private static $url = null;

    static function inst() {
        if (self::$instance == null) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    static function data() {
        if (self::$instance == null) {
            self::inst();
        }
        return self::$data;
    }
    function __construct()
    {
        $plugin_data = json_decode( file_get_contents(__DIR__.'/../../config.json'), true );
        self::$data = $plugin_data;

        self::$url = plugin_dir_url( __FILE__ );

        add_action('init', [$this,'init']);
    }

    function init() {
        add_action('wp_enqueue_scripts', function() {
            $styles = self::$data['assets']['css'];
            $scripts = self::$data['assets']['js'];
            foreach ($styles as $style) {
                wp_enqueue_style(
                    $style['name'], self::$url.$style['path'], $style['deps'] ?? [],
                    WP_DEBUG ? time() : (self::$data['version'] ?? false)
                );
            }
            foreach ($scripts as $script) {
                wp_enqueue_script(
                    $script['name'], self::$url.$script['path'], $script['deps'] ?? [],
                    WP_DEBUG ? time() : (self::$data['version'] ?? false)
                );
            }

        });
        add_action( 'admin_menu', function() {
            $pages = self::$data['pages'];
            foreach($pages as $page) {
                AdminPage::inst()->make($page);
            }
        } );
    }
}
