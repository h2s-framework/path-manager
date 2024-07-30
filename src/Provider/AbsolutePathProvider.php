<?php

namespace Siarko\Paths\Provider;

class AbsolutePathProvider extends AbstractPathProvider
{
    /**
     * @param string|null $path
     * @param bool $normalizePath
     */
    public function __construct(
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
     */
    protected function getPaths($id = null)
    {
        return ($this->path !== null ? $this->path.DIRECTORY_SEPARATOR:'').$id;
    }
}