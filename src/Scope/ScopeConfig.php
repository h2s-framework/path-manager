<?php

namespace Siarko\Paths\Scope;

/**
 * This class represents the scope configuration.
 * It can be used to assign scope to directory
 */
class ScopeConfig
{

    /**
     * @param array $directories
     * @param bool $capitalize
     */
    public function __construct(
        private readonly array $directories = [],
        private readonly bool $capitalize = false
    )
    {
    }

    /**
     * @param string $scope
     * @return string|null
     */
    public function getDirectory(string $scope): ?string
    {
        return $this->directories[$scope] ?? null;
    }

    /**
     * @return bool
     */
    public function isCapitalize(): bool
    {
        return $this->capitalize;
    }


}