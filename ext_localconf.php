<?php

defined('TYPO3') || die('🅛🅞🅒🅐🅛🅕🅞🅝🅣🅢');

call_user_func(static function () {
    \Zeroseven\LocalFonts\Loader\GoogleFontLoader::register();
    \Zeroseven\LocalFonts\Hooks\PageRendererHook::register();
});
