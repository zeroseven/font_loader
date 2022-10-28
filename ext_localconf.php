<?php

defined('TYPO3') || defined('TYPO3_MODE') || die('🅕🅞🅝🅣 🅛🅞🅐🅓🅔🅡');

call_user_func(static function () {
    \Zeroseven\FontLoader\Hooks\PageRendererHook::register();
    \Zeroseven\FontLoader\Loader\GoogleFontLoader::register();
    \Zeroseven\FontLoader\Loader\FontAwesomeLoader::register();
});
