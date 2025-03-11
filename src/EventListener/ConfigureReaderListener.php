<?php

namespace App\EventListener;

use App\Feature\Reader\Interface\ReaderConfiguratorInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Messenger\Event\WorkerStartedEvent;

final readonly class ConfigureReaderListener
{
    public function __construct(
        private ReaderConfiguratorInterface $readerConfigurator,
    ) {}

    #[AsEventListener(event: WorkerStartedEvent::class)]
    public function onWorkerStartedEvent(WorkerStartedEvent $event): void
    {
        $this->readerConfigurator->configure();
    }
}
