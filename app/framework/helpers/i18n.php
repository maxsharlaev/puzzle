<?php namespace PuzzleCodebase\Helpers;

use PuzzleCodebase\Application;

function _t($string) {
    $textdomain = Application::dataGet('textdomain');
    return __($string, $textdomain);
}