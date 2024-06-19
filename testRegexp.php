<?php

require_once './Classes/CustomRegexp.php';

use Classes\CustomRegexp;

$testData = [
    'test.mail@mail.com',
    'abc-mail@host.ua',
    'user@site.net',
    'nomail@gmail.coma',
    '-mnk@mail.com',
    'mail@mail@mail.com',
    'mail*tt@mail.com'
];


function testRegexpDomain(string $string): void
{
    echo CustomRegexp::testMatchByAllowedDomain($string)
       ? $string . " : Match" . PHP_EOL
       : $string . " : Doesn't match" . PHP_EOL;
}

function testRegexpDomainChars(string $string): void
{
    echo CustomRegexp::testMatchByAllowedDomain($string)
        ? $string . " : Match" . PHP_EOL
        : $string . " : Doesn't match" . PHP_EOL;
}

function testRegexpDomainCompact(string $string): void
{
    echo CustomRegexp::testMatchByDomainCompact($string)
        ? $string . " : Match" . PHP_EOL
        : $string . " : Doesn't match" . PHP_EOL;
}

array_map('testRegexpDomain', $testData);

echo '---------------------------' . PHP_EOL;

array_map('testRegexpDomainChars', $testData);

echo '---------------------------' . PHP_EOL;

array_map('testRegexpDomainCompact', $testData);
