<?php declare(strict_types = 1);

use Contributte\Nextras\Orm\Generator\Utils\DocBuilder;
use Contributte\Tester\Toolkit;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

Toolkit::test(function (): void {
	$b = new DocBuilder();
	Assert::equal('', (string) $b);

	$b = new DocBuilder();
	$b->append('foo');
	Assert::equal('foo', (string) $b);

	$b = new DocBuilder();
	$b->append('foo');
	$b->space();
	Assert::equal('foo', (string) $b);

	$b = new DocBuilder();
	$b->append('foo');
	$b->append('bar');
	Assert::equal('foo bar', (string) $b);

	$b = new DocBuilder();
	$b->append('foo');
	$b->space();
	$b->append('bar');
	Assert::equal('foo  bar', (string) $b);

	$b = new DocBuilder();
	$b->str('foo');
	$b->str('bar');
	Assert::equal('foobar', (string) $b);
});
