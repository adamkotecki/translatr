<?php

namespace SourceBroker\Translatr\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

/**
 * Class FileUtility
 *
 * @package SourceBroker\Translatr\Utility
 */
class FileUtility
{

    /**
     * Returns relative path to the $filePath
     *
     * @param $path
     *
     * @return string
     */
    public static function getRelativePathFromAbsolute($path)
    {
        if (GeneralUtility::isAbsPath($path)) {
            $replacements = [
                PATH_site.'typo3conf'.DIRECTORY_SEPARATOR.'ext'
                .DIRECTORY_SEPARATOR => 'EXT:',
                PATH_site.'typo3conf'.DIRECTORY_SEPARATOR => 'typo3conf',
                PATH_site => '',
            ];

            foreach ($replacements as $replaceFrom => $replaceTo) {
                if (GeneralUtility::isFirstPartOfStr($path, $replaceFrom)) {
                    $path = str_replace($replaceFrom, $replaceTo, $path);
                }
            }
        }

        return $path;
    }

    /**
     * @return string
     */
    public static function getTempFolderPath()
    {
        if (VersionNumberUtility::convertVersionNumberToInteger(TYPO3_branch) >
            VersionNumberUtility::convertVersionNumberToInteger('8.0.0')
        ) {
            $cachePath = 'var/Cache/Data/TxTranslatr';

        } else {
            $cachePath = 'Cache/Data/TxTranslatr';
        }
        $tempFolderPath = PATH_site . 'typo3temp/' . $cachePath;
        if (!is_dir($tempFolderPath)) {
            GeneralUtility::mkdir_deep($tempFolderPath);
        }
        return $tempFolderPath;
    }

}