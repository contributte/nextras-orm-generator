<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Resolver;

use Contributte\Nextras\Orm\Generator\Entity\Table;

interface IFacadeResolver extends IFilenameResolver
{

	public function resolveFacadeName(Table $table): string;

	public function resolveFacadeNamespace(Table $table): string;

	public function resolveFacadeFilename(Table $table): string;

}
