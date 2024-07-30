<?php

namespace Siarko\Paths\Api\Scope;

interface AppScopeProviderInterface
{

    /**
     * @return string
     */
    public function getScopeName(): string;

}