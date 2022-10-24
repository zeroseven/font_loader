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
        return preg_replace_callback('/url\([\'|\"]?(.*)[\'|\"]?\)/U', function ($matches) use ($baseUrl) {
            $url = $matches[1];

            if (preg_match('/^\/[^\/]/', $url)) {
                $url = $baseUrl . $url;
            }

            if ($content = GeneralUtility::getUrl($url)) {
                $fileName = $this->getFilePath($url);

                if ($this->writeFile($fileName, $content)) {
                    $url = PathUtility::getAbsoluteWebPath($fileName);
                }
            }

            return sprintf('url("%s")', $url);
        }, $content);
    }

    private function getFilePath(string $url, string $extensionFallback = ''): ?string
    {
        $path = sprintf('%s/typo3temp/zeroseven/local_fonts/', Environment::getPublicPath());

        if (!is_dir($path)) {
            GeneralUtility::mkdir_deep($path);
        }

        return $path . md5($url) . (($extension = (pathinfo($url, PATHINFO_EXTENSION)) ?: $extensionFallback) ? '.' . $extension : '´');
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
