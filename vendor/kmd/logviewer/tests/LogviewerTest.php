<?php

use Kmd\Logviewer\Logviewer;
use Mockery as m;

class LogviewerTest extends PHPUnit_Framework_TestCase
{
    public $logviewer;

    public function setUp()
    {
        parent::setUp();

        $app = m::mock('AppMock');
        $app->shouldReceive('instance')->once()->andReturn($app);

        Illuminate\Support\Facades\Facade::setFacadeApplication($app);
        Illuminate\Support\Facades\Config::swap($config = m::mock('ConfigMock'));

        $config->shouldReceive('get')->once()->with('logviewer::log_dirs')
            ->andReturn(array('app' => 'app/storage/logs'));

        $this->logviewer = new Logviewer('app', 'cgi-fcgi', '2013-06-01');
    }

    public function tearDown()
    {
        $this->logviewer = null;
        m::close();
    }

    public function testLogLevels()
    {
        $levels = array(
            'EMERGENCY' => 'emergency',
            'ALERT' => 'alert',
            'CRITICAL' => 'critical',
            'ERROR' => 'error',
            'WARNING' => 'warning',
            'NOTICE' => 'notice',
            'INFO' => 'info',
            'DEBUG' => 'debug',
        );

        $psr = $this->logviewer->getLevels();

        $this->assertEquals(count($levels), count($psr));

        $this->assertEquals($levels, $psr);
    }

    public function testLogAggregationRegex()
    {
        $date = '2013-06-01';

        $pattern = '/.*(\d{4}-\d{2}-\d{2}).*/';

        $files = array(
            '/path/to/laravel/app/storage/logs/log-cli-2013-06-01.txt',
            '/path/to/laravel/app/storage/logs/log-apache2handler-2013-06-01.txt',
            '/path/to/laravel/app/storage/logs/log-apache2filter-2013-06-01.txt',
            '/path/to/laravel/app/storage/logs/log-apache-2013-06-01.txt',
            '/path/to/laravel/app/storage/logs/log-cgi-fcgi-2013-06-01.txt',
        );

        foreach ($files as &$file) {
            $file = preg_replace($pattern, '$1', basename($file));
            $this->assertEquals($file, $date);
        }
    }
}
