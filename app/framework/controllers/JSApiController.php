<?php

namespace PuzzleCodebase\Puzzle;

class JSApiController
{
    function jsData()
    {
        $data = [
            'ajax_url' => admin_url('admin-ajax.php'),
            'auth' => is_user_logged_in(),
            'user_id' => get_current_user_id()
        ];
        $currentPage = Application::get_instance()->getCurrentPage();
        $termPage = Application::get_instance()->getCurrentTerm();
        $adminPage = Application::get_instance()->getCurrentAdminPage();
        if ($currentPage) {
            $data['page_id'] = $currentPage;
        }
        if ($termPage) {
            $data['term'] = $termPage;
        }
        if ($adminPage) {
            $data['admin_page'] = $adminPage;
        }

        return $data;
    }

    function savePluginSettings()
    {
    }

}
