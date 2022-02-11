<?php

namespace PuzzleCodebase\Puzzle;

use PuzzleCodebase\Puzzle;

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