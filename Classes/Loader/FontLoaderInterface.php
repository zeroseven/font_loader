<?php

declare(strict_types=1);

namespace Zeroseven\LocalFonts\Loader;

interface FontLoaderInterface {
    public function load(string $url): string;

    public function isResponsible(string $url): bool;

    public static function register(): void;
}
