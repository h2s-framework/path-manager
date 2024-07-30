<?php

namespace Siarko\Paths\Api\Provider\Pool;

use Siarko\Paths\Provider\AbstractPathProvider;

interface PathProviderPoolInterface
{

    /**
     * @param string $type
     * @return AbstractPathProvider[]
     */
    public function getProviders(string $type): array;
}