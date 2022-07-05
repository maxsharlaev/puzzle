<?php

namespace PuzzleCodebase\Puzzle;

class MiddlewareController {
    private $data = null;

    function __construct($data)
    {
        $this->data = $data;
    }

    function launch() {
        $data = [];
        if ($this->data['load'] ?? false) {
            $data = Application::call($this->data['load'], $this->data);
        }
        $args = func_get_args();
        return Application::call($this->data['controller'], ['model' => $this->data, 'data' => $data, 'args' => $args]);
    }
}