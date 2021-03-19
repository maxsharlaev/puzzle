<?php namespace PuzzleCodebase\Factories;

use PuzzleCodebase\Models\Shortcode;

class ShortcodesFactory {
    private $data = null;

    function __construct($data)
    {
        $this->data = $data;
    }
    static function bake($data, $base = 'shortcodes') {
        return new Shortcode($data, $base);
    }

}