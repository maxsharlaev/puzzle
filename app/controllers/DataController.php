<?php

namespace PuzzleCodebase\Puzzle;

class DataController
{
    private static $instance = null;

    static function inst()
    {
        if (self::$instance == null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    function initTables()
    {
        global $wpdb;
        // Add database migration code here: create tables
    }
    function deInitTables() {
        global $wpdb;
        // Add database rollback code here: remove data on plugin deactivation
    }
    function courseMetaboxDataGet()
    {
        $post_id = Application::get_instance()->getCurrentAdminPage();
        $courseEnabled = get_post_meta($post_id, 'is_course_page', true);
        $courseTotalTime = get_post_meta($post_id, 'course_total_time', true);
        $course_term = get_post_meta($post_id, 'course_term', true);
        $sort_num = get_post_meta($post_id, 'sort_num', true);
        $trackingTotals = json_decode(get_post_meta($post_id, 'course_tracking_totals', true), true);

        $course_terms = get_terms('courses', [
            'hide_empty' => false,
        ]);


        return compact('sort_num', 'course_term', 'course_terms', 'post_id', 'courseEnabled', 'courseTotalTime', 'trackingTotals');
    }

    function courseMetaboxDataSave($item)
    {
        extract($item['request']);
        update_post_meta($item['post_id'], 'is_course_page', $course_enabled);
        update_post_meta($item['post_id'], 'course_total_time', $total_time);

        update_post_meta($item['post_id'], 'course_term', $course_term);
        update_post_meta($item['post_id'], 'sort_num', $sort_num);
    }

    function settingsLoad()
    {
        return [];
    }

    function settingsSub() {
        return [];
    }
    function pdfDataLoad()
    {
    }

}
