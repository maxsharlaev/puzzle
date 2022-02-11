<?php

namespace PuzzleCodebase\Puzzle;

class Shortcode {
    private $base = 'shortcodes';
    private $data = null;

    function __construct($data = [], $base = 'shortcodes') {
        $this->base = $base;
        $this->data = $data;
    }
    function launch($atts, $body) {
        $viewName =  __DIR__.'/../../views/'.self::$base.'/'.$this->data['view'].'.php';

        $atts = shortcode_atts($this->data['attributes'], $atts);

        $data = [];
        if ($this->data['load']) {
            $data = Application::call($this->data['load'], $this->data);
        }
        extract($data);

        ob_start();
        if (file_exists($viewName)) {
            include( $viewName );
        }
        return ob_get_clean();
    }
}

