<?php

return array(

    'delete' => array(
        'modal' => array(
            'header' => 'Bạn chắc chắn muốn xóa?',
            'body' => 'Bạn chắc chắn muốn xóa thông tin nhật ký?',
            'btn' => array(
                'no' => 'Không',
                'yes' => 'Có',
            )
        ),
        'error' => 'Có lỗi khi xóa nhật ký',
        'success' => 'Đã xóa thông tin',
        'btn' => 'Xóa thông tin nhật ký',
    ),
    'empty_file'  => 'Nhật ký :sapi ngày :date còn trống.',
    'levels' => array(
        'all' => 'Tất cả',
        'emergency' => 'Khẩn cấp',
        'alert' => 'Cảnh báo',
        'critical' => 'Nghiêm trọng',
        'error' => 'Lỗi',
        'warning' => 'Cảnh cáo',
        'notice' => 'Chú ý',
        'info' => 'Thông tin',
        'debug' => 'Debug',
    ),
    'no_log'  => 'Không có nhật ký của :sapi ngày :date',
    // @TODO Find out what sapi nginx, IIS, etc. show up as.
    'sapi'   => array(
        'apache' => 'Apache',
        'cgi-fcgi' => 'Fast CGI',
        'fpm-fcgi' => 'Nginx',
        'cli' => 'CLI',
    ),
    'title' => 'Hệ thống nhật ký của Laravel 4',

);
