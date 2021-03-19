<?php namespace PuzzleCodebase\Factories;

use PuzzleCodebase\Models\Metabox;

class MetaboxesFactory {
    static function bake($page)
    {
        return new Metabox($page);
    }
}