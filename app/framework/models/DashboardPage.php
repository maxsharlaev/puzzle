<?php

namespace PuzzleCodebase\Puzzle;

class DashboardPage {
    private $page = null;

    function __construct($page) {
        $this->page = $page;
        if (!isset($page['parent_slug']) || !$page['parent_slug']) {
            add_menu_page(
                _t($page['name']), _t($page['menu']), $page['caps'], $page['slug'], [$this, 'pageLoad'], $page['icon'], $page['position']
            );
        } else {
            add_submenu_page(
                $page['parent_slug'], _t($page['name']), _t($page['menu']), $page['caps'], $page['slug'], [$this, 'pageLoad']
            );
        }
    }
    function dataLoad($source) {
        $data = [];
        if (isset($source['load'])) {
            $data = Application::call($source['load'], [$source]);
        }
        return $data;
    }
    function pageLoad() {
        $data = $this->dataLoad($this->page);
        $app = Application::dataGet();
        extract($data);
        $viewName =  __DIR__.'/../../views/'.$this->page['view'].'.php';
        ob_start();
        if (file_exists($viewName)) {
            include( $viewName );
        }
        $output = ob_get_clean();
        echo $output;
    }
}