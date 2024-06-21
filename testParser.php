<?php

const DOMAIN = 'wikipedia.org';
const BASE_URL = 'https://en.wikipedia.org/';
const PARAM_IMG = 'src';
const PARAM_LINK = 'href';

// URL HTML-page to be parsed
$url = 'https://en.wikipedia.org/wiki/PHP';

/**
 * Parse page by incoming url and return array contains two more arrays ['href'] and ['src']
 *
 * @param $url
 *
 * @return array
 */
function pageParser($url): array {
    $filePath = './Data/raw_data_to_parse.txt';

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    // Return result as the string
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    // Don't include headers in output result
    curl_setopt($curl, CURLOPT_HEADER, false);

    $result = curl_exec($curl);

    curl_close($curl);

    if ($result === false) {
        echo "URL Error: " . curl_error($curl);
        return [];
    }

    $pattern = '/></';
    $replacement = ">" . PHP_EOL . "<";

    // Break source code of the page by tags (each tag in separate line)
    $result = preg_replace($pattern, $replacement, $result);

    // Save result to the file for debug purpose
    file_put_contents($filePath, $result);

    // Create a source array
    $arr = explode(PHP_EOL, $result);

    // Create the result array
    $parsedArray = [];
    // Subarray for founded links
    $parsedArray[PARAM_LINK] = [];
    // Subarray for founded sources for images
    $parsedArray[PARAM_IMG] = [];

    foreach($arr as $tagline) {
        $param = '';

        // Check if current line contains tag <a>
        if (str_starts_with($tagline, '<a')) {
            $param = PARAM_LINK;
        }

        // Check if current line contains tag <img>
        if (str_starts_with($tagline, '<img')) {
            $param = PARAM_IMG;
        }

        if (!$param) {
            continue;
        }

        // Get all links from current line (it can be more than one)
        $values = getParsedValue($tagline, $param);

        foreach($values as $value) {
            /** In some cases link can be in format 'en.wikipedia.org/#cite_ref-338'
             *  or 'https://upload.wikimedia.org/wikipedia...'
             *  To create proper final link the 'https://' prefix will be added
             */
            if (!str_starts_with($value, 'http') &&
                (str_contains($value, 'wikipedia.org/') ||
                    str_contains($value, 'wikimedia.org/'))
            ) {
                $value = 'https://' . $value;
            }

            /**
             * Some link can be present in full format aka 'https://en.wikipedia.org'
             * Thus leave it untouched. Otherwise, add 'https://en.wikipedia.org' as the prefix.
             */
            $value = str_starts_with($value, 'http') ? $value : BASE_URL . $value;

            // Check for duplicates
            if (!in_array($value, $parsedArray[$param], true)) {
                $parsedArray[$param][] = $value;
            }
        }
    }

    return $parsedArray;
}

/**
 * Parse incoming string & return array of links
 *
 * @param string $source
 * @param string $param // Search parameter {'href'|'src'}
 *
 * @return array
 */
function getParsedValue(string $source, string $param): array
{
    $arr = explode(' ', $source);

    // Find all parts of the string contains 'href' or 'src'
    $result = array_filter($arr, function($value) use ($param) {
        return str_starts_with($value, $param . '=');
    });

    // Result array
    $narr = [];

    foreach ($result as $line) {
        // Remove 'href=' or 'src=' from start of the string
        $res = preg_replace("/^{$param}=\"/", '', $line);
        // Remove the last '"' symbol and rest of the string
        $res = preg_replace('/".*/', '', $res);
        // Remove last '/' symbol (may present in some links)
        $res = ltrim($res, '/');

        $narr[] = $res;
    }

    return $narr;
}

$data = pageParser($url);

echo "List of links..." . PHP_EOL;
echo '____________________________________' . PHP_EOL;
foreach ($data[PARAM_LINK] as $link) {
    echo $link . PHP_EOL;
}

echo "List of image links..." . PHP_EOL;
echo '____________________________________' . PHP_EOL;
foreach ($data[PARAM_IMG] as $link) {
    echo $link . PHP_EOL;
}
