<?php declare (strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Resolver;

interface IModelResolver
{

	public function resolveModelName(): string;

	public function resolveModelNamespace(): string;

	public function resolveModelFilename(): string;

}
