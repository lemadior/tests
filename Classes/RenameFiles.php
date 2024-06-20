<?php

namespace Classes;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;
use UnexpectedValueException;

class RenameFiles
{
    /**
     * @var string $targetPath
     */
    protected string $targetPath;

    public function __construct(string $targetPath = '')
    {
        $this->targetPath = $targetPath;
    }

    /**
     * @param string $path
     *
     * @return void
     */
    public function setTargetDir(string $path): void
    {
        $this->targetPath = $path;
    }

    /**
     * @return string
     */
    public function getTargetDir(): string
    {
        return $this->targetPath;
    }

    /**
     * Get Directory Iterator if $this->targetPath has been specified and not empty string
     *
     * @return RecursiveIteratorIterator|null
     */
    public function getDirIterator(): RecursiveIteratorIterator|null
    {
        $path = $this->getTargetDir();

        // Check if $path equal to empty string. If so its means that targetPath doesn't specify.
        if (!$path) {
            return null;
        }

        $rootDir = new RecursiveDirectoryIterator($path);

        return new RecursiveIteratorIterator($rootDir, RecursiveIteratorIterator::SELF_FIRST);
    }

    /**
     * Recursively rename files (only!) as specified in the task's description.
     *
     * @return void
     */
    public function renameFiles(): void
    {
        $dirIterator = $this->getDirIterator();

        if (!$dirIterator) {
            return;
        }

        try {
            foreach ($dirIterator as $currentElem) {

                // Skip directories
                if ($currentElem->isDir()) {
                    continue;
                }

                // Get relative path to the file without filename
                $path = $currentElem->getPath();

                $ext = $currentElem->getExtension();

                // Get filename without extension
                $name = rtrim($currentElem->getBasename(), $ext);
                $name = rtrim($name, '.');

                // Change all present digit in the name to the '0' (zero)
                $newNameChangeDigitsToZero = preg_replace('/\d/', '0', $name);
                $newName = mb_strtolower($newNameChangeDigitsToZero);

                // Get fullpath (relative) to the current file
                $oldPath = $currentElem->getPathname();
                // Create fullpath (relative) to the new file (renamed)
                $newPath = $path . DIRECTORY_SEPARATOR . $newName . '.' . $ext;

                rename($oldPath, $newPath);
            }
        } catch (UnexpectedValueException $err) {
            throw new RuntimeException('ERROR while renaming: ' . $err->getMessage());
        }
    }

    /**
     * Show (print to stdout) all founded files by specified extension.
     * Example: {'jpg' | 'txt' | 'doc'}
     *
     * @param string $extension
     *
     * @return void
     */
    public function showFilesByExtension(string $extension): void
    {
        $files = $this->getFilesByExtension($extension);

        foreach ($files as $file) {
            echo $file;
        }
    }

    /**
     * Get array of all founded files by specified extension
     *
     * @param string $extension
     *
     * @return array
     */
    protected function getFilesByExtension(string $extension): array
    {
        $dirIterator = $this->getDirIterator();

        if (!$dirIterator) {
            return [];
        }

        $foundedFiles = [];

        try {
            foreach ($dirIterator as $currentElem) {
                // Skip directories
                if ($currentElem->isDir()) {
                    continue;
                }

                if ($currentElem->getExtension() === $extension) {
                    $foundedFiles[] = $currentElem->getPathname() . PHP_EOL;
                }

            }
        } catch (UnexpectedValueException $err) {
            throw new RuntimeException('ERROR while renaming: ' . $err->getMessage());
        }

        return $foundedFiles;
    }
}
