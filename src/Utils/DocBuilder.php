<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Utils;

class DocBuilder
{

	/** @var string[] */
	private $builder = [];

	public function append(string $str): self
	{
		$this->str($str);
		$this->space();
		return $this;
	}

	public function str(string $str): self
	{
		$this->builder[] = $str;
		return $this;
	}

	public function space(): self
	{
		$this->builder[] = ' ';
		return $this;
	}

	public function __toString(): string
	{
		$s = implode('', $this->builder);
		$s = trim($s);

		return $s;
	}

}
