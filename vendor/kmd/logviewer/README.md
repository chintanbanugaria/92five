#Laravel 4 LogViewer

Easily view and delete Laravel 4's logs.

Inspiration from [Fire Log](https://github.com/dperrymorrow/Fire-Log) for CodeIgniter by [David Morrow](https://github.com/dperrymorrow) and [Larvel Log Viewer](https://github.com/ericbarnes/Laravel-Log-Viewer) for Laravel 3 by [Eric Barnes](https://github.com/ericbarnes)

Created and maintained by Micheal Mand. Copyright &copy; 2013. Licensed under the [MIT license](LICENSE.md).

[![Build Status](https://travis-ci.org/mikemand/logviewer.png?branch=master)](https://travis-ci.org/mikemand/logviewer) [![Total Downloads](https://poser.pugx.org/kmd/logviewer/downloads.png)](https://packagist.org/packages/kmd/logviewer)

---------

#A note about Laravel 4.1

As of right now (2013-11-29), fresh Laravel 4.1 applications log things differently than they used to. While this doesn't *technically* break LogViewer, LogViewer also doesn't know how to handle these changes. Here's a quick fix:

In your `app/start/global.php`, [line 34](https://github.com/laravel/laravel/blob/develop/app/start/global.php#L34) change:

```php
Log::useFiles(storage_path().'/logs/laravel.log');
```

to:

```php
$logFile = 'log-'.php_sapi_name().'.txt';

Log::useDailyFiles(storage_path().'/logs/'.$logFile);
```

This only applies to new installations of Laravel 4.1. If you've upgraded an existing 4.0 application (and did not make changes to the way logs are created and stored), everything should still work.

---------

##Demo

[View the demo here](http://logviewer.kmdwebdesigns.com/logviewer)

##Installation

Add `kmd/logviewer` as a requirement to `composer.json`:

```javascript
{
    ...
    "require": {
        ...
        "kmd/logviewer": "1.1.*"
        ...
    },
}
```

Update composer:

```
$ php composer.phar update
```

Add the provider to your `app/config/app.php`:

```php
'providers' => array(

    ...
    'Kmd\Logviewer\LogviewerServiceProvider',

),
```

Publish package assets:

```
$ php artisan asset:publish kmd/logviewer
```

(Optional) You can configure your `composer.json` to do this after each `$ composer update`:

```
"scripts":{
    "post-update-cmd":[
        "php artisan asset:publish kmd/logviewer",
        "php artisan optimize",
    ]
},
```

(Optional) Publish package config:

```
$ php artisan config:publish kmd/logviewer
```

Please note: if you have made changes in your `app/config/packages/kmd/logviewer/config.php`, DO NOT publish the package config again. It will overwrite yours without any warning.

##Usage and Configuration

###Usage

By default, LogViewer will register itself a couple of routes:

 * `logviewer` -> Redirect to today's log, showing all levels.
 * `logviewer/$app/$sapi/$date/delete` -> Delete log from `$sapi` (see: [php\_sapi\_name](http://php.net/manual/en/function.php-sapi-name.php)) on `$date` (`Y-m-d` format).
 * `logviewer/$app/$sapi/$date/$level?` -> Show log from `$sapi` on `$date` with `$level` (if not supplied, defaults to all).

LogViewer also registers a couple filters:

 * `logviewer.logs`: aggregates all the logs in your configured monitored directories and shares them with the `$logs` variable.
 * `logviewer.messages`: Checks if there are success, error, or info flash messages in the session and sets the `$has_messages` variable as true or false.

###Configuration

 * `base_url`: The URL LogViewer will be available on. You can have this nested (for example: `admin/logviewer`). Default: `logviewer`.
 * `filters`: Before and After filters to apply to the routes. We define no filters by default, as not everyone uses authentication or the same filter names.
   * `global`: Filters that affect the entirety of the logviewer. For example: `'global' => array('before' => 'auth'),` will apply the default Laravel `auth` filter to the logviewer, requiring a logged in user for all routes.
   * `view`: Filters that affect the viewing of log files.
   * `delete`: Filter that affect the deletion of log files.
 * `log_dirs`: Associative array of log directories to monitor. Array keys are the 'names' of your applications, values are the paths to their `app/storage/logs` dir (no trailing slash). Default: `array('app' => storage_path().'/logs')`.
 * `log_order`: Order log contents ascending or descending. Default: 'asc'.
 * `per_page`: The number of log messages to show per page via Pagination. Default: 10.
 * `view`: The name (and location) of the view used to display logs. For more information, check out the 'Advanced Usage' section for detailed information about the variables passed to this view. Default: 'logviewer::viewer'.
 * `p_view`: The pagination view to use. When using Bootstrap 3 as the default for an application, the pagination would be broken within LogViewer. If you create your own view, be sure to change this if you use Bootstrap 3 (or write your own pagination view) Default: 'pagination::slider'.

## Advanced Usage

Don't like the way LogViewer looks? Need to integrate it better with your application's theme? You can do so by creating your own view and changing the configuration option. Here are the variables that are sent to the view:

 * `$has_messages`: Boolean. The `logviewer.messages` filter determines if there are success, error, or info flash messages in the session. Used to hide the flash messages container.
 * `$logs`: Array. Aggregated logs, generated by the `logviewer.logs` filter, from all monitored applications. Grouped by SAPI and application. Structure:
   * SAPI as key, value is an array with keys:
     * `sapi`: Human-readable SAPI.
     * `logs`: Application 'short name' as key, value is an array of log dates.
 * `$log`: Array. Currently selected log's contents. Each message is split into an array. Structure:
   * `level`: String. The level of the log message.
   * `header`: String. The first line of the log message.
   * `stack`: String. The rest of the log message. Possibly blank, if the message did not contain a stack trace.
 * `$empty`: Boolean. Whether the current log is empty or not.
 * `$date`: String. The date of the currently selected log.
 * `$sapi`: String. The human-readable SAPI of the currently selected log.
 * `$sapi_plain`: String. The SAPI of the currently selected log. Used in the URI.
 * `$url`: String. The base URL from configuration.
 * `$levels`: Array. All possible log levels, per `psr/log`.
 * `$path`: String. The array key of the currently selected log's application.
