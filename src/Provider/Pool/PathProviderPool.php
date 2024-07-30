<?php

namespace Siarko\Paths\Provider\Pool;

use Siarko\Paths\Provider\AbstractPathProvider;
use Siarko\Paths\Api\Provider\Pool\PathProviderPoolInterface;
use Siarko\Paths\Api\Provider\Pool\ProviderBuilderInterface;

class PathProviderPool implements PathProviderPoolInterface
{

    private array $loadedProviders = [];

    /**
     * @param ProviderBuilderInterface[] $providerBuilders
     * @param AbstractPathProvider[][] $providers
     */
    public function __construct(
        private readonly array $providerBuilders = [],
        private readonly array $providers = []
    )
    {
    }

    /**
     * @param string $type
     * @return AbstractPathProvider[]
     */
    public function getProviders(string $type): array
    {
        if(!array_key_exists($type, $this->loadedProviders)){
            $dynamicProviders = $this->getDynamicProviders($type);
            $this->loadedProviders[$type] = array_merge(($this->providers[$type] ?? []), $dynamicProviders);
        }
        return $this->loadedProviders[$type];
    }

    /**
     * @param string $type
     * @return array
     */
    private function getDynamicProviders(string $type): array
    {
        if(!empty($this->providerBuilders)){
            $result = [];
            foreach ($this->providerBuilders as $providerBuilder) {
                $result = array_merge($result, $providerBuilder->build($type));
            }
            return $result;
        }
        return [];
    }
}