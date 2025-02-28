<?php

declare(strict_types=1);

namespace App\Feature\Reader\Service\Http;

use Laminas\Feed\Reader\Http\ClientInterface as FeedClientInterface;
use Laminas\Feed\Reader\Http\Psr7ResponseDecorator;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

class FeedHttpClient implements FeedClientInterface
{
    public function __construct(
        private readonly ClientInterface $client,
        private readonly RequestFactoryInterface $requestFactory,
    ) {}

    public function get($uri)
    {
        $request = $this->requestFactory->createRequest('GET', $uri);

        return new Psr7ResponseDecorator(
            $this->client->sendRequest($request),
        );
    }
}
