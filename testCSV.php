<?php

$filename = './Data/test.csv';

$arrayOne = [
    'name' => 'some name',
    'age' => 5,
    'city' => 'some town'
];

$arrayTwo = [
    'age' => 6,
    'country' => 'small country',
    'city' => 'mego city',
    'street' => 'cute ave.'
];

/**
 * Merge two arrays. If arrays has equal keys its values will be merged.
 * (About merge values: if one of value is a string the result will divide by space symbol.
 * Otherwise, values will convert to the string and concatenated as is, without divider.)
 *
 * NOTE: Arrays must not contain nested arrays
 *
 * @param array $array1
 * @param array $array2
 *
 * @return array
 */
function mergeTwoArrays(array $array1, array $array2): array
{
    $arr = $array1;

    foreach ($array2 as $key => $value) {
        $arr[$key] = isset($arr[$key])
            ? mergeArrayValues($array1[$key], $value)
            : $value;
    }

    return $arr;
}

/**
 * @param mixed $value1
 * @param mixed $value2
 *
 * @return string
 */
function mergeArrayValues(mixed $value1, mixed $value2): string
{
    return is_string($value1) || is_string($value2) ? $value1 . ' ' . $value2 : $value1 . $value2;
}

/**
 * @param array $array1
 * @param array $array2
 * @param string $filename
 *
 * @return bool
 */
function createCSVFromArrays(array $array1, array $array2, string $filename): bool
{
    $array = mergeTwoArrays($array1, $array2);

    try {
        $fd = fopen($filename, 'wb');

        // Create header
        fwrite($fd, implode(',', array_keys($array)) . PHP_EOL);

        // Write down the data
        fputcsv($fd, $array);

        fclose($fd);
    } catch (Exception $err) {
        echo 'ERROR: cannot create CSV file: ' . $err->getMessage();
        return false;
    }

    return true;
}

if (createCSVFromArrays($arrayOne, $arrayTwo, $filename)) {
    echo "File created successfully";
} else {
    echo "Some error has been occurred";
}
