<?php

namespace PuzzleCodebase\Puzzle;

trait Singleton {
    private static $instance = null;

    /**
     * Inits singleton class or returns existing instance
     * @return self
     */
    static function get_instance(): self
    {
        if (self::$instance == null) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}