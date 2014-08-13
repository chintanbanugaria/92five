<?php namespace October\Rain\Config;

use Illuminate\Config\LoaderInterface;
use Illuminate\Config\Repository as RepositoryBase;

class Repository extends RepositoryBase
{
    /**
     * The config rewriter object.
     *
     * @var string
     */
    protected $writer;

    /**
     * Create a new configuration repository.
     *
     * @param  \Illuminate\Config\LoaderInterface  $loader
     * @param  string  $environment
     * @return void
     */
    public function __construct(LoaderInterface $loader, $writer, $environment)
    {
        $this->writer = $writer;
        parent::__construct($loader, $environment);
    }

    /**
     * Write a given configuration value to file.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function write($key, $value)
    {
        list($namespace, $group, $item) = $this->parseKey($key);
        $this->writer->write($item, $value, $this->environment, $group, $namespace);
        $this->set($key, $value);
    }
}