<?php

defined('TYPO3') || die('🅛🅞🅒🅐🅛🅕🅞🅝🅣🅢');

call_user_func(static function () {
    \Zeroseven\FontLoader\Hooks\PageRendererHook::register();
    \Zeroseven\FontLoader\Loader\GoogleFontLoader::register();
    \Zeroseven\FontLoader\Loader\FontAwesomeLoader::register();
});
