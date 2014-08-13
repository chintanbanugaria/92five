<?php

// Inspired by: http://forums.laravel.io/viewtopic.php?id=827
HTML::macro('nav_item', function ($url, $text, $a_attr = array(), $active_class = 'active', $li_attrs = array()) {
    $href = HTML::link($url, $text, $a_attr);
    $response = '';

    if (Request::is($url) || Request::is($url.'/*')) {
        if (isset($li_attrs['class'])) {
            $li_attrs['class'] .= ' '.$active_class;
        } else {
            $li_attrs['class'] = $active_class;
        }
    }

    return '<li '.HTML::attributes($li_attrs).'>'.$href.'</li>';
});
