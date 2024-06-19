<?php

namespace Classes;
class CustomRegexp
{
    private const string REGEXP_BY_DOMAIN = '/^[0-9a-zA-Z]+([.-][0-9a-zA-Z]+)*@[0-9a-zA-Z]+\.(ua|com|net)$/i';
    private const string REGEXP_BY_DOMAIN_CHARS_COUNT = '/^[0-9a-zA-Z]+([\.-][0-9a-zA-Z]+)*@[0-9a-zA-Z]+\.[0-9a-zA-Z]{2,3}$/i';

    public static function testMatchByAllowedDomain(string $testString): bool
    {
        return preg_match(self::REGEXP_BY_DOMAIN, $testString);
    }

    public static function testMatchByDomainCharCount(string $testString): bool
    {

        return preg_match(self::REGEXP_BY_DOMAIN_CHARS_COUNT, $testString);

    }
}


