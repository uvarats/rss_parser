<?php

declare(strict_types=1);

namespace App\Feature\Reader\Interface;

interface ChainedReaderConfiguratorInterface extends ReaderConfiguratorInterface
{
    public function next(): ?ReaderConfiguratorInterface;
    public function setNext(?ReaderConfiguratorInterface $next = null): void;
}
