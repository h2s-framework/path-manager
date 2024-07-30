<?php

namespace Siarko\Paths\Provider;

class ProjectPathProviderFactory extends \Siarko\Api\Factory\AbstractFactory
{
	public function create(array $data = []): \Siarko\Paths\Provider\ProjectPathProvider
	{
		return parent::_create(\Siarko\Paths\Provider\ProjectPathProvider::class, $data);
	}
}
