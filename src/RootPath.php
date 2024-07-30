<?php

namespace Siarko\Paths;

use Siarko\Paths\Exception\RootPathNotSet;

class RootPath
{

    /**
     * @param string|null $rootPath
     */
    public function __construct(
        private ?string $rootPath = null
    )
    {
    }

    /**
     * Set root path for the project
     * @param string $path
     * @return RootPath
     */
    public function set(string $path): RootPath{
        $this->rootPath = $path;
        return $this;
    }

    /**
     * Get root path of the project
     * @param bool $separator If directory separator should be added
     * @return string
     * @throws RootPathNotSet
     */
    public function get(bool $separator = true): string{
        if($this->rootPath == null){
            throw new RootPathNotSet();
        }
        return $this->rootPath.($separator ? DIRECTORY_SEPARATOR:'');
    }

}