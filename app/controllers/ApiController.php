<?php namespace PuzzleCodebase;

class ApiController
{
    function uiJsData()
    {
        $currentPage = Application::inst()->getCurrentPage();
        return [
            'ajax_url' => admin_url('admin-ajax.php'),
            'page_id' => $currentPage,
            'auth' => is_user_logged_in(),
            'user_id' => get_current_user_id()
        ];
    }

    function savePluginSettings()
    {
    }

    function test()
    {

    }
}
