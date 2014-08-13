<?php

return array(

    'delete' => array(
        'modal' => array(
            'header' => 'Are you sure?',
            'body' => 'Are you sure you want to delete this log?',
            'btn' => array(
                'no' => 'No',
                'yes' => 'Yes',
            )
        ),
        'error' => 'There was an error while deleting the log.',
        'success' => 'Log deleted successfully!',
        'btn' => 'Delete Current Log',
    ),
    'empty_file'  => ':sapi log for :date appears to be empty. Did you manually delete the contents?',
    'levels' => array(
        'all' => 'all',
        'emergency' => 'emergency',
        'alert' => 'alert',
        'critical' => 'critical',
        'error' => 'error',
        'warning' => 'warning',
        'notice' => 'notice',
        'info' => 'info',
        'debug' => 'debug',
    ),
    'no_log'  => 'No :sapi log available for :date.',
    // @TODO Find out what sapi nginx, IIS, etc. show up as.
    'sapi'   => array(
        'apache' => 'Apache',
        'cgi-fcgi' => 'Fast CGI',
        'fpm-fcgi' => 'Nginx',
        'cli' => 'CLI',
    ),
    'title' => 'Admin',

);
