<?php

return array(

    'delete' => array(
        'modal' => array(
            'header' => '確かですか？',
            'body' => 'このログを削除してもよろしいですか？',
            'btn' => array(
                'no' => 'いいえ',
                'yes' => 'はい',
            )
        ),
        'error' => '削除中にエラーが発生しました。',
        'success' => 'ログの削除は成功しました！',
        'btn' => '現行のログを鎖錠する',
    ),
    'empty_file'  => ':dateの:sapiログは空っぽに見えますが中身を手動で削除しましたか？',
    'levels' => array(
        'all' => 'すべて',
        'emergency' => '緊急',
        'alert' => '警報',
        'critical' => '重要',
        'error' => 'エラー',
        'warning' => '警告',
        'notice' => '通告',
        'info' => '情報',
        'debug' => 'デバッグ',
    ),
    'no_log'  => ':dateに入手可能な:sapiログはありません。',
    // @TODO Find out what sapi nginx, IIS, etc. show up as.
    'sapi'   => array(
        'apache' => 'Apache',
        'cgi-fcgi' => 'Fast CGI',
        'fpm-fcgi' => 'Nginx',
        'cli' => 'CLI',
    ),
    'title' => 'Laravel 4 ログビューア',

);
