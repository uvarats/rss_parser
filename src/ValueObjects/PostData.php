<?php

declare(strict_types=1);

namespace App\ValueObjects;

use App\Feature\Feed\ValueObject\FeedId;

final readonly class PostData
{
    public function __construct(
        public string $id,
        public string $title,
        public string $link,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
        public ?string $enclosureLink,
        public string $description,
        public ?FeedId $sourceFeedId = null,
    ) {}

    /**
     * @deprecated
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @deprecated
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @deprecated
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @deprecated
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @deprecated
     */
    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @deprecated
     */
    public function getEnclosureLink(): string
    {
        return $this->enclosureLink;
    }

    /**
     * @deprecated
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
