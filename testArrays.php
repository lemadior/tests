<?php

$arrayFirst = ['el', 'ab', 'cd'];
$arraySecond = ['y5', 'y6', 'y7'];

function proceedArrays(array $arrOne, array $arrTwo): array
{
    $lenOne = count($arrOne);
    $lenTwo = count($arrTwo);

    if ($lenOne !== $lenTwo) {
        return [];
    }

    $result = [];

    $reverseLen = $lenTwo - 1;

    foreach ($arrOne as $i => $valueOne) {
        $result[] = $valueOne . '-' . $arrTwo[$reverseLen - $i];
    }

    return $result;
}

// Show results
foreach (proceedArrays($arrayFirst, $arraySecond) as $value) {
    echo  $value . PHP_EOL;
}
