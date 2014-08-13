<?php namespace October\Rain\Config;

use Illuminate\Config\LoaderInterface;

class FileWriter
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The loader implementation.
     *
     * @var \Illuminate\Config\LoaderInterface
     */
    protected $loader;

    /**
     * The default configuration path.
     *
     * @var string
     */
    protected $defaultPath;

    /**
     * The config rewriter object.
     *
     * @var \October\Rain\Config\Rewriter
     */
    protected $rewriter;

    /**
     * Create a new file configuration loader.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  string  $defaultPath
     * @return void
     */
    public function __construct(LoaderInterface $loader, $defaultPath)
    {
        $this->loader = $loader;
        $this->files = $loader->getFilesystem();
        $this->defaultPath = $defaultPath;
        $this->rewriter = new Rewriter;
    }

    public function write($item, $value, $environment, $group, $namespace = null)
    {
        $path = $this->getPath($environment, $group, $namespace);
        if (!$path)
            return false;

        $contents = $this->files->get($path);
        $this->rewriter->toContent($contents, [$item => $value]);
        $this->files->put($path, $contents);
        return true;
    }

    private function getPath($environment, $group, $namespace = null)
    {
        $hints = $this->loader->getNamespaces();

        $path = null;
        if (is_null($namespace)) {
            $path = $this->defaultPath;
        }
        elseif (isset($this->hints[$namespace])) {
            $path = $this->hints[$namespace];
        }

        if (is_null($path))
            return null;

        $file = "{$path}/{$environment}/{$group}.php";
        if ($this->files->exists($file))
            return $file;

        $file = "{$path}/{$group}.php";
        if ($this->files->exists($file))
            return $file;

        return null;
    }
}
