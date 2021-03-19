<?php namespace PuzzleCodebase\Controllers;

class MiddlewareController {
    private $data = null;

    function __construct($data)
    {
        $this->data = $data;
    }

    function launch() {
        $data = [];
        if ($this->data['load']) {
            $data = Application::call($this->data['load'], $this->data);
        }

        Application::call($this->data['controller'], ['model' => $this->data, 'data' => $data]);
    }
}