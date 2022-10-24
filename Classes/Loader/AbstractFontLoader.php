<?php

declare(strict_types=1);

namespace Zeroseven\LocalFonts\Loader;

use ReflectionClass;
use ReflectionException;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

abstract class AbstractFontLoader implements FontLoaderInterface
{
    protected function cleanFileName(string $filename): string
    {
        if ($index = (strpos($filename, '?') ?: strpos($filename, '#'))) {
            return substr($filename, 0, $index);
        }

        return $filename;
    }

    protected function writeFile(string $path, string $content): bool
    {
        if (file_put_contents($path, $content) !== false) {
            GeneralUtility::fixPermissions($path);

            return true;
        }

        return false;
    }

    private function loadFontsFromCss(string $content, string $baseUrl): string
    {
        $replacedFonts = [];

        return preg_replace_callback('/url\([\'|\"]?(.*)[\'|\"]?\)/U', function ($matches) use ($baseUrl, &$replacedFonts) {
            $url = $matches[1];

            // Relative url
            if (!preg_match('/^(https?:)?\/\//', $url)) {
                $absoluteUrl = PathUtility::getCanonicalPath(PathUtility::sanitizeTrailingSeparator(pathinfo($baseUrl, PATHINFO_DIRNAME)) . $url);
            } else {
                $absoluteUrl = $url;
            }

            // Load content
            if ($content = GeneralUtility::getUrl($absoluteUrl)) {
                $fileName = $this->getFilePath($absoluteUrl);

                if ($this->writeFile($fileName, $content)) {
                    $url = PathUtility::getAbsoluteWebPath($fileName);
                    $replacedFonts[] = $absoluteUrl;
                }
            }

            return sprintf('url("%s")', $url);
        }, $content)

        // Add css file to sources
        . sprintf("\n\n/* Sources: */\n/* @see %s [styles] */", $baseUrl)

        // List fonts to sources
        . (empty($replacedFonts) ? '' : implode('', array_map(static function ($replacedFont) {
            return sprintf("\n/* @see %s [font] */", $replacedFont);
        }, $replacedFonts)));
    }

    private function getFilePath(string $url, string $extensionFallback = ''): ?string
    {
        $path = sprintf('%s/typo3temp/zeroseven/local_fonts/', Environment::getPublicPath());

        if (!is_dir($path)) {
            GeneralUtility::mkdir_deep($path);
        }

        return $path . md5($url) . (($extension = (pathinfo($this->cleanFileName($url), PATHINFO_EXTENSION)) ?: $extensionFallback) ? '.' . $extension : '');
    }

    public function load(string $url): string
    {
        $filePath = $this->getFilePath($url, 'css');

        if (!file_exists($filePath) && $content = GeneralUtility::getUrl($url)) {
            $content = $this->loadFontsFromCss($content, $url);

            $this->writeFile($filePath, $content);
        }

        return PathUtility::getAbsoluteWebPath($filePath);
    }

    public static function registerLoader(string $className): void
    {
        if (GeneralUtility::makeInstance($className) instanceof FontLoaderInterface) {
            try {
                $GLOBALS['TYPO3_CONF_VARS']['USER']['zeroseven/local-fonts'][(new ReflectionClass($className))->getShortName()] = $className;
            } catch (ReflectionException $e) {
            }
        }
    }
}
