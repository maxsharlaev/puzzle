<?php namespace PuzzleCodebase\Factories;

use PuzzleCodebase\Models\DashboardPage;

class DashboardPagesFactory
{
    static function bake($page)
    {
        return new DashboardPage($page);
    }
}