<?php

/**
 * The limitations are not entirely clear from the task's statement, so I made several variants.
 */

namespace Classes;

class CustomRegexp
{
    private const string REGEXP_BY_DOMAIN = '/^[0-9a-zA-Z]+([\.-][0-9a-zA-Z]+)*@[0-9a-zA-Z]+\.(ua|com|net)$/i';
    private const string REGEXP_BY_DOMAIN_CHARS_COUNT = '/^[0-9a-zA-Z]+([\.-][0-9a-zA-Z]+)*@[0-9a-zA-Z]+\.[0-9a-zA-Z]{2,3}$/i';
    private const string REGEXP_BY_DOMAIN_COMPACT = '/^\w+([\.-]\w+)*@\w+\.[0-9a-zA-Z]{2,3}$/i';


    /**
     * Check if string match depends on common rule and specified domains
     *
     * @param string $testString
     *
     * @return bool
     */
    public static function testMatchByAllowedDomain(string $testString): bool
    {
        return preg_match(self::REGEXP_BY_DOMAIN, $testString);
    }

    /**
     * Check if string match depends on common rule and specified count of chars of domain
     *
     * @param string $testString
     *
     * @return bool
     */
    public static function testMatchByDomainCharCount(string $testString): bool
    {
        return preg_match(self::REGEXP_BY_DOMAIN_CHARS_COUNT, $testString);
    }

    /**
     * Check if string match depends on common rule and specified count of chars of domain
     * used shortened form
     *
     * @param string $testString
     *
     * @return bool
     */
    public static function testMatchByDomainCompact(string $testString): bool
    {
        return preg_match(self::REGEXP_BY_DOMAIN_COMPACT, $testString);
    }
}
