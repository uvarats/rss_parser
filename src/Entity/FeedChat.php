<?php

namespace App\Entity;

use App\Feature\Feed\Repository\FeedChatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: FeedChatRepository::class)]
#[ORM\UniqueConstraint(name: 'feed_chat_unique', fields: ['chatId', 'feed'])]
class FeedChat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT)]
    private string $chatId;

    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => true])]
    private bool $active = true;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Feed $feed = null;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column]
    #[Gedmo\Timestampable]
    private \DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public static function make(
        int $chatId,
        Feed $feed,
    ): FeedChat {
        $instance = new self();

        $instance->chatId = $chatId;
        $instance->feed = $feed;

        return $instance;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChatId(): string
    {
        return $this->chatId;
    }

    public function setChatId(string $chatId): static
    {
        $this->chatId = $chatId;

        return $this;
    }

    public function getFeed(): ?Feed
    {
        return $this->feed;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function setFeed(?Feed $feed): static
    {
        $this->feed = $feed;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
