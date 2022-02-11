<?php

namespace PuzzleCodebase\Puzzle;

class MetaboxesFactory {
    static function bake($page)
    {
        return new Metabox($page);
    }
}