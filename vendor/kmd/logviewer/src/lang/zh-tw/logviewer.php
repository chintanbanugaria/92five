<?php

return array(

    'delete' => array(
        'modal' => array(
            'header' => '你確定?',
            'body' => '你確定要刪除這些日誌記錄?',
            'btn' => array(
                'no' => '否',
                'yes' => '是',
            )
        ),
        'error' => '在刪除日誌記錄檔時發生錯誤',
        'success' => '已成功刪除日誌記錄!',
        'btn' => '刪除當前的日誌記錄',
    ),
    'empty_file'  => ':date 的 :sapi 日誌記錄是空的。您是否手動刪除了這些內容?',
    'levels' => array(
        'all' => '全部',
        'emergency' => '緊急',
        'alert' => '警示',
        'critical' => '嚴重',
        'error' => '錯誤',
        'warning' => '警告',
        'notice' => '注意',
        'info' => '資訊',
        'debug' => '偵錯',
    ),
    'no_log'  => ':date 沒有 :sapi 的日誌記錄',
    // @TODO Find out what sapi nginx, IIS, etc. show up as.
    'sapi'   => array(
        'apache' => 'Apache',
        'cgi-fcgi' => 'Fast CGI',
        'fpm-fcgi' => 'Nginx',
        'cli' => 'CLI',
    ),
    'title' => 'Laravel 4 日誌檢視器',

);
