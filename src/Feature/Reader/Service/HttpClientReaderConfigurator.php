<?php

declare(strict_types=1);

namespace App\Feature\Reader\Service;

use App\Feature\Reader\Service\Http\FeedHttpClient;
use App\Feature\Reader\ValueObject\ReaderConfigurator;
use Laminas\Feed\Reader\Reader;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;

#[AsTaggedItem(ReaderConfigurator::TAG, 999)]
final class HttpClientReaderConfigurator extends AbstractChainedConfigurator
{
    public function __construct(
        private readonly FeedHttpClient $feedHttpClient,
        private readonly LoggerInterface $logger,
    ) {}

    #[\Override]
    public function configure(): void
    {
        $this->logger->info('Configuring Reader HTTP client');

        Reader::setHttpClient($this->feedHttpClient);

        $this->proceedToNext();
    }
}
