<?php

/**
 * Test: Utils\DocBuilder
 */

use Minetro\Normgen\Utils\DocBuilder;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

test(function () {
    $b = new DocBuilder();
    Assert::equal('', (string)$b);

    $b = new DocBuilder();
    $b->append('foo');
    Assert::equal('foo', (string)$b);

    $b = new DocBuilder();
    $b->append('foo');
    $b->space();
    Assert::equal('foo', (string)$b);

    $b = new DocBuilder();
    $b->append('foo');
    $b->append('bar');
    Assert::equal('foo bar', (string)$b);

    $b = new DocBuilder();
    $b->append('foo');
    $b->space();
    $b->append('bar');
    Assert::equal('foo  bar', (string)$b);

    $b = new DocBuilder();
    $b->str('foo');
    $b->str('bar');
    Assert::equal('foobar', (string)$b);
});
