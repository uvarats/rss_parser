<?php

declare(strict_types=1);

namespace App\Feature\Feed\ValueObject;

final readonly class FeedId implements \JsonSerializable, \Stringable
{
    public function __construct(
        private int $id,
    ) {}

    /**
     * @param positive-int $id
     */
    public static function fromInt(int $id): FeedId
    {
        if ($id <= 0) {
            throw new \DomainException('Feed id must be positive int');
        }

        return new self(
            id: $id,
        );
    }

    public function toInt(): int
    {
        return $this->id;
    }

    public function toString(): string
    {
        return (string)$this->toInt();
    }

    #[\Override]
    public function __toString(): string
    {
        return $this->toString();
    }

    #[\Override]
    public function jsonSerialize(): int
    {
        return $this->id;
    }
}
