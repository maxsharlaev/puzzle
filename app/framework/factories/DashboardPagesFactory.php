<?php

namespace PuzzleCodebase\Puzzle;

class DashboardPagesFactory
{
    static function bake($page)
    {
        return new DashboardPage($page);
    }
}