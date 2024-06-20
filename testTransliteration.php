<?php

require_once './Classes/Translit.php';

use Classes\Transliteration;

$testData = 'певна стрічка';

$translit = new Transliteration();

echo $translit->transliterate($testData);

