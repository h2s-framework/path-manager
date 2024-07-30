<?php

namespace Siarko\Paths\Provider\Pool;

use Siarko\Paths\Provider\AbsolutePathProvider;
use Siarko\Paths\Api\Scope\AppScopeProviderInterface;
use Siarko\Paths\Api\Provider\Pool\PathProviderPoolInterface;
use Siarko\Paths\Scope\ScopeConfig;

class ScopedPathProviderPool implements PathProviderPoolInterface
{

    /**
     * @var AbsolutePathProvider[][][]
     */
    private array $scopedProviders = [];

    /**
     * @param PathProviderPool $pathProviderPool
     * @param AppScopeProviderInterface $appScopeProvider
     * @param ScopeConfig[] $typeScopeConfig
     */
    public function __construct(
        private readonly PathProviderPool          $pathProviderPool,
        private readonly AppScopeProviderInterface $appScopeProvider,
        private readonly array                     $typeScopeConfig = []
    )
    {
    }

    /**
     * @param string $type
     * @return AbsolutePathProvider[]
     */
    public function getProviders(string $type): array
    {
        $scope = $this->appScopeProvider->getScopeName();
        $providers = $this->scopedProviders[$scope][$type] ?? null;
        if ($providers === null) {
            $this->scopedProviders[$scope][$type] = $this->buildProviders($type, $scope);
        }
        return $this->scopedProviders[$scope][$type];
    }

    /**
     * @param string $type
     * @param string $scope
     * @return array
     */
    protected function buildProviders(string $type, string $scope): array
    {
        $providers = $this->pathProviderPool->getProviders($type);
        $scopedDirectory = $this->getScopedDirectory($type, $scope);
        foreach ($providers as $index => $provider) {
            $providerPath = $provider->getConstructedPath($scopedDirectory);
            if (file_exists($providerPath) && is_dir($providerPath)) {
                $provider->setPath($provider->getRawPath().DIRECTORY_SEPARATOR.$scopedDirectory);
                $provider->flushCache();
                continue;
            }
            unset($providers[$index]);
        }
        return $providers;
    }

    /**
     * @param string $type
     * @param string $scope
     * @return string
     */
    private function getScopedDirectory(string $type, string $scope): string
    {
        $scopeConfig = $this->typeScopeConfig[$type] ?? null;
        if (!$scopeConfig) {
            return $scope;
        }
        $scopeDir = $scopeConfig->getDirectory($scope) ?? $scope;
        if ($scopeConfig->isCapitalize()) {
            $scopeDir = ucfirst($scopeDir);
        }
        return $scopeDir;
    }
}