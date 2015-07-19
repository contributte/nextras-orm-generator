<?php

/**
 * Test: Utils\Helpers
 */

use Minetro\Normgen\Utils\Helpers;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

/**
 * Helpers::camelCase
 */
test(function () {
    Assert::equal('fooBar', Helpers::camelCase('foo bar'));
    Assert::equal('fooBar', Helpers::camelCase('foo  bar'));
    Assert::equal('fooBar', Helpers::camelCase('foo BAR'));
    Assert::equal('fooBar1', Helpers::camelCase('foo bar 1'));
    Assert::equal('fooBar1', Helpers::camelCase('foo bar 1'));
    Assert::equal('fooBar1', Helpers::camelCase('foo !@#$%^&*{}[]() bar 1'));
});

/**
 * Helpers::stripMnDelimiters
 */
test(function () {
    Assert::equal('foobar', Helpers::stripMnDelimiters('foo_has_bar'));
    Assert::equal('foobar', Helpers::stripMnDelimiters('foo_x_bar'));
    Assert::equal('foobar', Helpers::stripMnDelimiters('foo_to_bar'));
});
