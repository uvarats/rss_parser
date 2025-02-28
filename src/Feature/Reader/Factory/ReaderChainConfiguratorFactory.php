<?php

declare(strict_types=1);

namespace App\Feature\Reader\Factory;

use App\Feature\Reader\Interface\ChainedReaderConfiguratorInterface;
use App\Feature\Reader\Interface\ReaderConfiguratorInterface;
use App\Feature\Reader\Service\NullReaderConfigurator;
use App\Feature\Reader\ValueObject\ReaderConfigurator;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

class ReaderChainConfiguratorFactory
{
    public function __construct(
        /**
         * @var iterable<ChainedReaderConfiguratorInterface> $configurators,
         */
        #[AutowireIterator(ReaderConfigurator::TAG)]
        private readonly iterable $configurators,
    ) {}

    public function make(): ReaderConfiguratorInterface
    {
        $firstConfigurator = null;
        $currentConfigurator = null;
        foreach ($this->configurators as $nextConfigurator) {
            if ($firstConfigurator === null) {
                $firstConfigurator = $currentConfigurator = $nextConfigurator;

                continue;
            }

            $currentConfigurator->setNext($nextConfigurator);
            $currentConfigurator = $nextConfigurator;
        }

        return $firstConfigurator ?? new NullReaderConfigurator();
    }
}
