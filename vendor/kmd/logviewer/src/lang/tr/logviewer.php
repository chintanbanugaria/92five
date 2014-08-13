<?php

/**
 * Laravel 4 LogViewer
 *
 * @package  Easily view and delete Laravel 4's logs.
 * @version  4.x
 * @author   Sinan Eldem <sinan@sinaneldem.com.tr>
 * @link     http://sinaneldem.com.tr
 */

return array(

    'delete' => array(
        'modal' => array(
            'header' => 'Emin misiniz?',
            'body' => 'Günlüğü boşaltmak istediğinizden emin misiniz?',
            'btn' => array(
                'no' => 'Hayır',
                'yes' => 'Evet',
            )
        ),
        'error' => 'Günlük temizlenirken bir sorun oluştu.',
        'success' => 'Günlük başarıyla temizlendi!',
        'btn' => 'Şuanki günlüğü temizle',
    ),
    'empty_file'  => ':date tarihli :sapi günlüğü boş görünüyor. İçeriği elle mi temizlediniz?',
    'levels' => array(
        'all' => 'Tümü',
        'emergency' => 'Acil',
        'alert' => 'Uyarı',
        'critical' => 'Kritik',
        'error' => 'Hata',
        'warning' => 'İkaz',
        'notice' => 'Duyuru',
        'info' => 'Bilgi',
        'debug' => 'Hata Denetimi',
    ),
    'no_log'  => ':date tarihi için :sapi kaydı bulunmamaktadır.',
    // @TODO Find out what sapi nginx, IIS, etc. show up as.
    'sapi'   => array(
        'apache' => 'Apache',
        'cgi-fcgi' => 'Fast CGI',
        'fpm-fcgi' => 'Nginx',
        'cli' => 'CLI',
    ),
    'title' => 'Laravel 4 LogViewer',

);
