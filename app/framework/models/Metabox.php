<?php

namespace PuzzleCodebase\Puzzle;

class Metabox {

    private $base = '';
    private $metabox = null;

    function __construct($base = 'metaboxes') {
        $this->base = $base;
    }

    function dataLoad($source) {
        $data = [];
        if (isset($source['load'])) {
            $data = Application::call($source['load'], [$source]);
        }
        return $data;
    }

    function init($mtb) {
        $this->metabox = $mtb;
        add_meta_box($mtb['id'], _t($mtb['name']), [$this, 'show'], $mtb['show_in']);
    }
    function save($mtb, $post_id, $post, $update) {
        $data = Application::dataGet();
        if ($mtb['save'] && in_array($post->post_type, $mtb['show_in'] ?? []) && !defined('DOING_AJAX')) {
            Application::call(
                $mtb['save'],
                [
                    'mtb' => $mtb,
                    'data' => $data,
                    'request' => Application::postData($mtb['save_data']),
                    'post_id' => $post_id
                ]);
        }
    }
    function show() {
        $data = $this->dataLoad($this->metabox);
        $app = Application::dataGet();
        extract($data);
        $viewName =  __DIR__.'/../views/'.$this->base.'/'.$this->metabox['view'].'.php';
        ob_start();
        if (file_exists($viewName)) {
            include( $viewName );
        }
        $output = ob_get_clean();
        echo $output;
    }
}