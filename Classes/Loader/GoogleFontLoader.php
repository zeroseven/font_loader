<?php

declare(strict_types=1);

namespace Zeroseven\LocalFonts\Loader;

class GoogleFontLoader extends AbstractFontLoader
{
    public function isResponsible(string $url): bool
    {
        // Example: https://fonts.googleapis.com/css?family=Hammersmith+One
        return (bool)preg_match('/^https?:\/\/fonts\.googleapis\.com\/css\?/i', $url);
    }

    public static function register(): void
    {
        AbstractFontLoader::registerLoader(self::class);
    }
}
