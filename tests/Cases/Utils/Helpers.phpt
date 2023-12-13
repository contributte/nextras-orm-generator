<?php declare(strict_types = 1);

use Contributte\Nextras\Orm\Generator\Utils\Helpers;
use Contributte\Tester\Toolkit;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

Toolkit::test(function (): void {
	Assert::equal('foo', Helpers::camelCase('foo'));
	Assert::equal('fooBar', Helpers::camelCase('fooBar'));
	Assert::equal('fooBar', Helpers::camelCase('foo bar'));
	Assert::equal('fooBar', Helpers::camelCase('foo  bar'));
	Assert::equal('fooFooFooFoo', Helpers::camelCase('foo foo foo foo'));
	Assert::equal('fooBar', Helpers::camelCase(' foo bar '));
	Assert::equal('fooBar1', Helpers::camelCase('foo bar 1'));
	Assert::equal('fooBar1', Helpers::camelCase('foo bar 1'));
	Assert::equal('1FooBar1', Helpers::camelCase('1 foo bar 1'));
	Assert::equal('fooBar1', Helpers::camelCase('foo !@#$%^&*{}[]() bar 1'));
});

Toolkit::test(function (): void {
	Assert::equal('foobar', Helpers::stripMnDelimiters('foo_has_bar'));
	Assert::equal('foobar', Helpers::stripMnDelimiters('foo_x_bar'));
	Assert::equal('foobar', Helpers::stripMnDelimiters('foo_to_bar'));
});
