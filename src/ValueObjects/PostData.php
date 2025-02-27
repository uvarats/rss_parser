<?php

declare(strict_types=1);

namespace App\ValueObjects;

final readonly class PostData
{
    public function __construct(
        private string $id,
        private string $title,
        private string $link,
        private \DateTimeImmutable $createdAt,
        private \DateTimeImmutable $updatedAt,
        private ?string $enclosureLink,
        private string $description,
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getEnclosureLink(): string
    {
        return $this->enclosureLink;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
