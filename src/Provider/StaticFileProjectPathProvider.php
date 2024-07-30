<?php

namespace Siarko\Paths\Provider;

use Siarko\Paths\Exception\RootPathNotSet;

class StaticFileProjectPathProvider extends ProjectPathProvider
{
    /**
     * Just remove trailing DIRECTORY_SEPARATOR - path should be already pointing to file
     * @param $id
     * @return string
     * @throws RootPathNotSet
     */
    protected function getPaths($id = null): string
    {
        return rtrim(parent::getPaths($id), DIRECTORY_SEPARATOR);
    }

}