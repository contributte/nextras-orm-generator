<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Resolver;

use Contributte\Nextras\Orm\Generator\Entity\Table;

interface IMapperResolver extends IFilenameResolver
{

	public function resolveMapperFilename(Table $table): string;

	public function resolveMapperNamespace(Table $table): string;

	public function resolveMapperName(Table $table): string;

}
