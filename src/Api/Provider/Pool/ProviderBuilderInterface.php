<?php

namespace Siarko\Paths\Api\Provider\Pool;

interface ProviderBuilderInterface
{

    /**
     * @param string $type
     * @return array
     */
    public function build(string $type): array;

}