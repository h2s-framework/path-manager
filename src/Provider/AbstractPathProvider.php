<?php

namespace Siarko\Paths\Provider;

abstract class AbstractPathProvider
{

    /**
     * Generated path list for paths with id
     * @var array
     */
    private array $_paths = [];

    /**
     * Single path
     * @var ?string
     */
    protected ?string $path;

    /**
     * @param $id
     * @return mixed
     */
    protected abstract function getPaths($id = null);

    /**
     * @param string|null $path
     * @return void
     */
    public function setPath(?string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return string|null
     */
    public function getRawPath(): ?string
    {
        return $this->path;
    }

    /**
     *
     * @param null $id
     * @return string
     */
    public function getConstructedPath($id = null): string
    {
        if(!array_key_exists($id, $this->_paths)){
            $this->_paths[$id] = $this->constructPath($this->getPaths($id));
        }
        return $this->_paths[$id];
    }

    /**
     * Normalize path (it may contain ".." )
     * @param string $path
     * @return string
     */
    private function constructPath(string $path): string
    {
        $result = [];
        $pathParts = array_reverse(preg_split("/(\/|\\\)/", $path));
        $skip = 0;
        foreach ($pathParts as $pathPart) {
            if($pathPart == '..'){
                $skip++;
                continue;
            }
            if($skip > 0){
                $skip--;
                continue;
            }
            $result[] = $pathPart;
        }

        return implode(DIRECTORY_SEPARATOR, array_reverse($result));
    }

    /**
     * @return void
     */
    public function flushCache(): void
    {
        $this->_paths = [];
    }
}