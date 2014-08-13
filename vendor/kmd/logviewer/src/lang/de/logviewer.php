<?php

return array(

    'delete' => array(
        'modal' => array(
            'header' => 'Bist du dir sicher?',
            'body' => 'Bist du dir sicher, dass du diesen Log l&ouml;schen willst?',
            'btn' => array(
                'no' => 'Nein',
                'yes' => 'Ja',
            )
        ),
        'error' => 'Es ist ein Fehler w&auml;hrend des L&ouml;schens aufgetreten',
        'success' => 'Log erfolgreich gel&ouml;scht!',
        'btn' => 'L&ouml;sche aktuellen Log',
    ),
    'empty_file'  => ':sapi Log f&uuml;r den :date scheint leer zu sein. Hast du diesen manuell gel&ouml;scht?',
    'levels' => array(
        'all' => 'Alle',
        'emergency' => 'Notfall',
        'alert' => 'Hinweis',
        'critical' => 'Kritisch',
        'error' => 'Fehler',
        'warning' => 'Warnung',
        'notice' => 'Notiz',
        'info' => 'Info',
        'debug' => 'Debug',
    ),
    'no_log'  => 'Kein :sapi verf&uuml;gbar f&uuml;r den :date.',
    // @TODO Find out what sapi nginx, IIS, etc. show up as.
    'sapi'   => array(
        'apache' => 'Apache',
        'cgi-fcgi' => 'Fast CGI',
        'fpm-fcgi' => 'Nginx',
        'cli' => 'CLI',
    ),
    'title' => 'Laravel 4 LogViewer',

);
