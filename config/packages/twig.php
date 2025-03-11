<?php

declare(strict_types=1);

use Symfony\Config\TwigConfig;

return static function (TwigConfig $twig, string $env) {
    $twig->fileNamePattern('*.twig');

    if ($env === 'test') {
        $twig->strictVariables(true);
    }
};
