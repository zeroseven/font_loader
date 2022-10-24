<?php

declare(strict_types=1);

namespace Zeroseven\LocalFonts\Loader;

class FontAwesomeLoader extends AbstractFontLoader
{
    public function isResponsible(string $url): bool
    {
        // Example: https://use.fontawesome.com/releases/v5.12.0/css/all.css?wpfas=true
        return (bool)preg_match('/^https?:\/\/(\w+.)?fontawesome\.com\/releases\/./i', $url);
    }

    public static function register(): void
    {
        AbstractFontLoader::registerLoader(self::class);
    }
}
