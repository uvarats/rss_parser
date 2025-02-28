<?php

declare(strict_types=1);

namespace App\Feature\Reader\Service;

use App\Feature\Reader\Interface\ChainedReaderConfiguratorInterface;
use App\Feature\Reader\Interface\ReaderConfiguratorInterface;

abstract class AbstractChainedConfigurator implements ChainedReaderConfiguratorInterface
{
    private ?ReaderConfiguratorInterface $next = null;

    public function proceedToNext(): void
    {
        $this->next()?->configure();
    }

    public function next(): ?ReaderConfiguratorInterface
    {
        return $this->next;
    }

    public function setNext(?ReaderConfiguratorInterface $next = null): void
    {
        $this->next = $next;
    }
}
