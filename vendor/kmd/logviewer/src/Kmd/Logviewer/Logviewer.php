<?php 

namespace Kmd\Logviewer;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Psr\Log\LogLevel;
use ReflectionClass;

class Logviewer
{
    public $path;
    public $sapi;
    public $date;
    public $level;
    public $empty;

    /**
     * Create a new Logviewer.
     *
     * @access public
     * @param string
     * @param string
     * @param string
     * @param string
     */
    public function __construct($app, $sapi, $date, $level = 'all')
    {
        $log_dirs = Config::get('logviewer::log_dirs');
        $this->path = $log_dirs[$app];
        $this->sapi = $sapi;
        $this->date = $date;
        $this->level = $level;
    }

    /**
     * Check if the log is empty.
     *
     * @access public
     * @return boolean
     */
    public function isEmpty()
    {
        return $this->empty;
    }

    /**
     * Open and parse the log.
     *
     * @access public
     * @return array
     */
    public function log()
    {
        $this->empty = true;
        $log = array();

        $pattern = "/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\].*/";

        $log_levels = $this->getLevels();

        $log_file = glob($this->path.'/log-'.$this->sapi.'*-'.$this->date.'.txt');

        if (!empty($log_file)) {
            $this->empty = false;
            $file = File::get($log_file[0]);

            // There has GOT to be a better way of doing this...
            preg_match_all($pattern, $file, $headings);
            $log_data = preg_split($pattern, $file);

            if ($log_data[0] < 1) {
                $trash = array_shift($log_data);
                unset($trash);
            }

            foreach ($headings as $h) {
                for ($i=0, $j = count($h); $i < $j; $i++) {
                    foreach ($log_levels as $ll) {
                        if ($this->level == $ll || $this->level == 'all') {
                            if (strpos(strtolower($h[$i]), strtolower('.'.$ll))) {
                                $log[] = array('level' => $ll, 'header' => $h[$i], 'stack' => $log_data[$i]);
                            }
                        }
                    }
                }
            }
        }

        unset($headings);
        unset($log_data);

        if (strtolower(Config::get('logviewer::log_order')) == 'desc') {
            $log = array_reverse($log);
        }

        return $log;
    }

    /**
     * Delete the log.
     *
     * @access public
     * @return boolean
     */
    public function delete()
    {
        $log_file = glob($this->path.'/log-'.$this->sapi.'*-'.$this->date.'.txt');

        if (!empty($log_file)) {
            return File::delete($log_file[0]);
        }
    }

    /**
     * Get the log levels from psr/log.
     *
     * @access public
     * @return array
     */
    public function getLevels()
    {
        $class = new ReflectionClass(new LogLevel);
        return $class->getConstants();
    }
}
