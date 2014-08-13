<?php

Route::filter('logviewer.logs', function () {
    $logs = array();
    if (!Lang::has('logviewer::logviewer.sapi')) {
        App::setLocale('en');
    }
    foreach (Lang::get('logviewer::logviewer.sapi') as $sapi => $human) {
        $logs[$sapi]['sapi'] = $human;
        $dirs = Config::get('logviewer::log_dirs');

        $files = array();

        foreach ($dirs as $app => $dir) {
            $files[$app] = glob($dir.'/log-'.$sapi.'*', GLOB_BRACE);
            if (is_array($files[$app])) {
                $files[$app] = array_reverse($files[$app]);
                foreach ($files[$app] as &$file) {
                    $file = preg_replace('/.*(\d{4}-\d{2}-\d{2}).*/', '$1', basename($file));
                }
            } else {
                $files[$app] = array();
            }
        }

        $logs[$sapi]['logs'] = $files;
    }

    View::share('logs', $logs);
});

Route::filter('logviewer.messages', function () {
    if (Session::has('success') || Session::has('error') || Session::has('info')) {
        View::share('has_messages', true);
    } else {
        View::share('has_messages', false);
    }
});
