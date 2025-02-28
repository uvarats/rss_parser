<?php

declare(strict_types=1);

namespace App\Feature\Reader\Service;

use App\Feature\Reader\Interface\ReaderConfiguratorInterface;

class NullReaderConfigurator implements ReaderConfiguratorInterface
{
    #[\Override]
    public function configure(): void {}
}
