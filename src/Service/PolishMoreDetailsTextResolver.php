<?php

declare(strict_types=1);

namespace App\Service;

use App\Interface\TextResolverInterface;

class PolishMoreDetailsTextResolver implements TextResolverInterface
{
    #[\Override]
    public function getMoreDetailsText(): string
    {
        return 'Więcej szczegółów';
    }
}
