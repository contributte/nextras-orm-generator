<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Resolver;

interface IFilenameResolver
{

	/**
	 * Constants
	 */
	public const PHP_EXT = 'php';

	/**
	 * @param string $folder [optional]
	 */
	public function resolveFilename(string $name, ?string $folder = null): string;

}
