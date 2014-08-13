<?php

return array(

    'delete' => array(
        'modal' => array(
            'header' => 'Weet je het zeker?',
            'body' => 'Weet je zeker dat je deze log wilt verwijderen?',
            'btn' => array(
                'no' => 'Nee',
                'yes' => 'Ja',
            )
        ),
        'error' => 'Door een fout kon de log niet verwijderd worden.',
        'success' => 'De log is succesvol verwijderd!',
        'btn' => 'Verwijder huidige log',
    ),
    'empty_file'  => 'De :sapi log van :date lijkt leeg. ?',
    'levels' => array(
        'all' => 'Allemaal',
        'emergency' => 'emergency',
        'alert' => 'alert',
        'critical' => 'critical',
        'error' => 'error',
        'warning' => 'warning',
        'notice' => 'notice',
        'info' => 'info',
        'debug' => 'debug',
    ),
    'no_log'  => 'Geen :sapi log gevonden voor :date.',
    // @TODO Find out what sapi nginx, IIS, etc. show up as.
    'sapi'   => array(
        'apache' => 'Apache',
        'cgi-fcgi' => 'Fast CGI',
        'fpm-fcgi' => 'Nginx',
        'cli' => 'CLI',
    ),
    'title' => 'Laravel 4 LogViewer',

);
