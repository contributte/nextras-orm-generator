<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Resolver;

use Contributte\Nextras\Orm\Generator\Entity\Table;

interface IEntityResolver extends IFilenameResolver
{

	public function resolveEntityName(Table $table): string;

	public function resolveEntityNamespace(Table $table): string;

	public function resolveEntityFilename(Table $table): string;

}
