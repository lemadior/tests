<?php

require_once './Classes/RenameFiles.php';

use Classes\RenameFiles;

$sourcePath = './TestFList';

$renameFiles = new RenameFiles($sourcePath);

$renameFiles->renameFiles();

$renameFiles->showFilesByExtension('jpg');
