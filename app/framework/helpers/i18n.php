<?php

namespace PuzzleCodebase\Puzzle;

use PuzzleCodebase\Puzzle;

function _t($string) {
    $textdomain = Application::dataGet('textdomain');
    return __($string, $textdomain);
}