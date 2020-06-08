<?php

function loadFiles($dir, $excl = []) {
    $files = scandir($dir);
    foreach( $files as $file ) {
        if ($file == '.' || $file == '..' || in_array($file, $excl)) {
            continue;
        }

        if( is_dir($dir.'/'.$file) ) {
            loadFiles($dir.'/'.$file );
        }

        $slugs = explode('.', $file);
        if (end($slugs) != 'php') {
            continue;
        }

        require_once($dir.'/'.$file);
    }
}

loadFiles(__DIR__, ['views']);

