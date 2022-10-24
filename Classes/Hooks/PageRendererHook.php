<?php

declare(strict_types=1);

namespace Zeroseven\FontLoader\Hooks;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Zeroseven\FontLoader\Loader\FontLoaderInterface;

class PageRendererHook
{
    public function loadCssFiles(array &$params, PageRenderer $pageRenderer): void
    {
        if (is_array($GLOBALS['TYPO3_CONF_VARS']['USER']['zeroseven/font-loader'] ?? null)) {
            $fontLoaderList = array_filter(array_map(static function ($l) {
                return ($fontLoader = GeneralUtility::makeInstance($l)) instanceof FontLoaderInterface ? $fontLoader : null;
            }, $GLOBALS['TYPO3_CONF_VARS']['USER']['zeroseven/font-loader']));

            foreach ($params['cssFiles'] ?? [] as $key => $cssFile) {
                foreach ($fontLoaderList as $fontLoader) {
                    if (
                        ($url = $cssFile['file'] ?? null)
                        && $fontLoader->isResponsible($url)
                        && ($path = $fontLoader->load($url))
                    ) {
                        $pageRenderer->addCssFile($path, $cssFile['rel'] ?? 'stylesheet', $cssFile['media'] ?? 'all', $cssFile['title'] ?? '', $cssFile['compress'] ?? true, $cssFile['forceOnTop'] ?? false, $cssFile['allWrap'] ?? '', $cssFile['excludeFromConcatenation'] ?? false, $cssFile['splitChar'] ?? '|', $cssFile['inline'] ?? false);

                        unset($params['cssFiles'][$key]);
                    }
                }
            }
        }
    }

    public static function register(): void
    {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][self::class] = self::class . '->loadCssFiles';
    }
}
