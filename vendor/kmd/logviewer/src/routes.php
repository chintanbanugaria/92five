<?php

use Carbon\Carbon;
use Kmd\Logviewer\Logviewer;
use Illuminate\Pagination\Environment;

$filters = Config::get('logviewer::filters.global');

if (isset($filters['before'])) {
    if (!is_array($filters['before'])) {
        $filters['before'] = explode('|', $filters['before']);
    }
} else {
    $filters['before'] = array();
}

$filters['before'][] = 'logviewer.messages';

if (isset($filters['after'])) {
    if (!is_array($filters['after'])) {
        $filters['after'] = explode('|', $filters['after']);
    }
} else {
    $filters['after'] = array();
}

Route::group(array('before' => $filters['before'], 'after' => $filters['after']), function () {
    Route::get(Config::get('logviewer::base_url'), function () {
        $sapi = php_sapi_name();

        if (preg_match('/apache.*/', $sapi)) {
            $sapi = 'apache';
        }

        $today = Carbon::today()->format('Y-m-d');

        $dirs = Config::get('logviewer::log_dirs');
        reset($dirs);

        $path = key($dirs);

        if (Session::has('success') || Session::has('error')) {
            Session::reflash();
        }

        return Redirect::to(Config::get('logviewer::base_url').'/'.$path.'/'.$sapi.'/'.$today.'/all');
    });

    $filters = Config::get('logviewer::filters.delete');

    if (isset($filters['before'])) {
        if (!is_array($filters['before'])) {
            $filters['before'] = explode('|', $filters['before']);
        }
    } else {
        $filters['before'] = array();
    }

    if (isset($filters['after'])) {
        if (!is_array($filters['after'])) {
            $filters['after'] = explode('|', $filters['after']);
        }
    } else {
        $filters['after'] = array();
    }

    Route::group(array('before' => $filters['before'], 'after' => $filters['after']), function () {
        Route::get(Config::get('logviewer::base_url').'/{path}/{sapi}/{date}/delete', function ($path, $sapi, $date) {
            $logviewer = new Logviewer($path, $sapi, $date);

            if ($logviewer->delete()) {
                $today = Carbon::today()->format('Y-m-d');
                return Redirect::to(Config::get('logviewer::base_url').'/'.$path.'/'.$sapi.'/'.$today.'/all')
                    ->with('success', Lang::get('logviewer::logviewer.delete.success'));
            } else {
                return Redirect::to(Config::get('logviewer::base_url').'/'.$path.'/'.$sapi.'/'.$date.'/all')
                    ->with('error', Lang::get('logviewer::logviewer.delete.error'));
            }
        });
    });

    $filters = Config::get('logviewer::filters.view');

    if (isset($filters['before'])) {
        if (!is_array($filters['before'])) {
            $filters['before'] = explode('|', $filters['before']);
        }
    } else {
        $filters['before'] = array();
    }

    $filters['before'][] = 'logviewer.logs';

    if (isset($filters['after'])) {
        if (!is_array($filters['after'])) {
            $filters['after'] = explode('|', $filters['after']);
        }
    } else {
        $filters['after'] = array();
    }

    Route::group(array('before' => $filters['before'], 'after' => $filters['after']), function () {
        Route::get(Config::get('logviewer::base_url').'/{path}/{sapi}/{date}/{level?}', function ($path, $sapi, $date, $level = null) {
            if (is_null($level) || !is_string($level)) {
                $level = 'all';
            }

            $logviewer = new Logviewer($path, $sapi, $date, $level);

            $log = $logviewer->log();

            $levels = $logviewer->getLevels();

            $paginator = new Environment(App::make('request'), App::make('view'), App::make('translator'));

            $view = Config::get('logviewer::p_view');

            if (is_null($view) || ! is_string($view)) {
                $view = Config::get('view.pagination');
            }

            $paginator->setViewName($view);

            $per_page = Config::get('logviewer::per_page');

            if (is_null($per_page) || !is_int($per_page)) {
                $per_page = 10;
            }

            $page = $paginator->make($log, count($log), $per_page);

            return View::make(Config::get('logviewer::view'))
                ->with('paginator', $page)
                ->with('log', (count($log) > $page->getPerPage() ? array_slice($log, $page->getFrom()-1, $page->getPerPage()) : $log))
                ->with('empty', $logviewer->isEmpty())
                ->with('date', $date)
                ->with('sapi', Lang::get('logviewer::logviewer.sapi.'.$sapi))
                ->with('sapi_plain', $sapi)
                ->with('url', Config::get('logviewer::base_url'))
                ->with('levels', $levels)
                ->with('path', $path);
        });
    });
});
