<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Generator\Entity\Decorator;

use Contributte\Nextras\Orm\Generator\Entity\Column;
use Contributte\Nextras\Orm\Generator\Entity\PhpDoc;
use Contributte\Nextras\Orm\Generator\Entity\PhpRelDoc;
use Contributte\Nextras\Orm\Generator\Entity\Table;
use Contributte\Nextras\Orm\Generator\Resolver\IEntityResolver;
use Contributte\Nextras\Orm\Generator\Utils\ColumnTypes;
use Contributte\Nextras\Orm\Generator\Utils\Helpers;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Nette\Utils\Strings;

class ColumnDocumentor implements IDecorator
{

	/** @var IEntityResolver */
	private $resolver;

	public function __construct(IEntityResolver $resolver)
	{
		$this->resolver = $resolver;
	}

	public function doDecorate(Column $column, ClassType $class, PhpNamespace $namespace): void
	{
		$column->setPhpDoc($doc = new PhpDoc());

		// Annotation
		$doc->setAnnotation('@property');

		// Type
		if ($column->isNullable()) {
			$doc->setType($this->getRealType($column) . '|NULL');
		} else {
			$doc->setType($this->getRealType($column));
		}

		// Variable
		$doc->setVariable(Helpers::camelCase($column->getName()));

		// Defaults
		if ($column->getDefault() !== null) {
			$doc->setDefault($this->getRealDefault($column));
		}

		// Enum
		if (!empty($enum = $column->getEnum())) {
			$doc->setEnum(Strings::upper($column->getName()));
		}

		// Relations
		if (($key = $column->getForeignKey()) !== null) {
			// Find foreign entity table
			$ftable = $column->getTable()->getDatabase()->getForeignTable($key->getReferenceTable());

			// Update type to Entity name
			$doc->setType($this->resolver->resolveEntityName($ftable));
			$doc->setRelation($relDoc = new PhpRelDoc());

			if (($use = $this->getRealUse($ftable, $namespace))) {
				$namespace->addUse($use);
			}

			$relDoc->setType('???');
			$relDoc->setEntity($this->resolver->resolveEntityName($ftable));
			$relDoc->setVariable('???');
		}

		// Append phpDoc to class
		$class->addComment((string) $column->getPhpDoc());
	}

	/**
	 * @return mixed
	 */
	protected function getRealType(Column $column)
	{
		switch ($column->getType()) {
			case ColumnTypes::TYPE_ENUM:
				return $column->getSubtype();
			default:
				return $column->getType();
		}
	}

	/**
	 * @return mixed
	 */
	protected function getRealDefault(Column $column)
	{
		switch ($column->getType()) {
			case ColumnTypes::TYPE_ENUM:
				return 'self::' . $column->getDefault();
			default:
				return $column->getDefault();
		}
	}

	/**
	 * @return mixed
	 */
	protected function getRealUse(Table $table, PhpNamespace $namespace)
	{
		$use = $namespace->unresolveName(
			$this->resolver->resolveEntityNamespace($table) . Helpers::NS . $this->resolver->resolveEntityName($table)
		);

		if (Strings::compare($use, $table->getName())) {
			return null;
		}

		return $use;
	}

}
