<?php declare(strict_types = 1);

/**
 * Test: Utils\Helpers
 */

require __DIR__ . '/../../bootstrap.php';

use Contributte\Nextras\Orm\Generator\Utils\Helpers;
use Tester\Assert;

/**
 * Helpers::camelCase
 */
test(function (): void {
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

/**
 * Helpers::stripMnDelimiters
 */
test(function (): void {
	Assert::equal('foobar', Helpers::stripMnDelimiters('foo_has_bar'));
	Assert::equal('foobar', Helpers::stripMnDelimiters('foo_x_bar'));
	Assert::equal('foobar', Helpers::stripMnDelimiters('foo_to_bar'));
});
