<?php
namespace PluginCodebase;

class AdminPage {

    private static $instance = null;
    private $page = null;

    static function inst() {
        if (self::$instance == null) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    function make($page) {
        $this->page = $page;
        $data = Application::data();

        if (!isset($page['parent_slug']) || !$page['parent_slug']) {
            add_menu_page(
                __($page['name'], $data['textdomain']), __($page['menu'], $data['textdomain']),
                $page['caps'], $page['slug'], [$this, 'pageLoad'], $page['icon'], $page['position']
            );
        } else {
            add_submenu_page(
                $page['parent_slug'], __($page['name'], $data['textdomain']), __($page['menu'], $data['textdomain']),
                $page['caps'], $page['slug'], [$this, 'pageLoad']
            );
        }
    }
    function pageLoad() {
        $data = [];
        if (isset($this->page['load'])) {
            $call = explode(':', $this->page['load']);
            $call[0] = '\PluginCodebase\\'.$call[0];
            $class = new $call[0];
            $function = $call[1];
            $data = $class->$function($this->page);
        }
        extract($data);
        $viewName =  __DIR__.'/../views/'.$this->page['view'].'.php';
        ob_start();
        if (file_exists($viewName)) {
            include( $viewName );
        }
        $output = ob_get_clean();
        echo $output;
    }
}