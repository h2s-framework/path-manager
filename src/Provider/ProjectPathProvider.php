<?php

namespace Siarko\Paths\Provider;

use Siarko\Paths\Exception\RootPathNotSet;
use Siarko\Paths\RootPath;

class ProjectPathProvider extends AbstractPathProvider
{

    /**
     * @param RootPath $rootPath
     * @param string|null $path
     * @param bool $normalizePath
     */
    public function __construct(
        private readonly RootPath $rootPath,
        protected ?string $path = null,
        bool $normalizePath = true
    ){
        if($normalizePath && $this->path != null){
            $this->path = str_replace('/', DIRECTORY_SEPARATOR, $this->path);
        }
    }

    /**
     * @param $id
     * @return string
     * @throws RootPathNotSet
     */
    protected function getPaths($id = null): string
    {
        if($id){
            $id = ltrim($id, DIRECTORY_SEPARATOR);
        }
        return $this->rootPath->get() . ($this->path !== null ? $this->path . DIRECTORY_SEPARATOR : '') .$id;
    }
}