<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Resolver;

use Contributte\Nextras\Orm\Generator\Entity\Table;

interface IRepositoryResolver extends IFilenameResolver
{

	public function resolveRepositoryName(Table $table): string;

	public function resolveRepositoryNamespace(Table $table): string;

	public function resolveRepositoryFilename(Table $table): string;

}
