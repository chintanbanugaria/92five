<?php

return array(

    'base_url'   => 'logviewer',
    'filters'    => array(
        'global' => array(),
        'view'   => array(),
        'delete' => array()
    ),
    'log_dirs'   => array('app' => storage_path().'/logs'),
    'log_order'  => 'asc', // Change to 'desc' for the latest entries first
    'per_page'   => 10,
    'view'       => 'logviewer::viewer',
    'p_view'     => 'pagination::slider'

);
