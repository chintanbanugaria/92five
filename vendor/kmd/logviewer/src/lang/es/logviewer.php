<?php

return array(

    'delete' => array(
        'modal' => array(
            'header' => '¿Está seguro?',
            'body' => '¿Está seguro que desea eliminar este registro?',
            'btn' => array(
                'no' => 'No',
                'yes' => 'Sí',
            )
        ),
        'error' => 'Se ha producido un error al eliminar el registro.',
        'success' => 'Registro eliminado correctamente!',
        'btn' => 'Borrar el registro actual',
    ),
    'empty_file' => ':sapi registro de :date parece estar vacío. ¿Ha borrado manualmente el contenido?',
    'levels' => array(
        'all' => 'todo',
        'emergency' => 'emergencia',
        'alert' => 'alerta',
        'critical' => 'crítico',
        'error' => 'error',
        'warning' => 'advertencia',
        'notice' => 'aviso',
        'info' => 'información',
        'debug' => 'depuración',
    ),
    'no_log' => 'No :sapi registro disponibles para :date.',
    // @TODO Find out what sapi nginx, IIS, etc. show up as.
    'sapi' => array(
        'apache' => 'Apache',
        'cgi-fcgi' => 'Fast CGI',
        'fpm-fcgi' => 'Nginx',
        'cli' => 'CLI',
    ),
    'title' => 'Laravel 4 LogViewer',

);
