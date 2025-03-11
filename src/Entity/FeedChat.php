<?php

namespace App\Entity;

use App\Repository\FeedChatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: FeedChatRepository::class)]
class FeedChat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $chatId = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Feed $feed = null;

    #[ORM\Column(nullable: true)]
    private ?int $refreshInterval = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $lastCheckAt = null;

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
        ?int $refreshInterval,
    ): FeedChat {
        $instance = new self();

        $instance->chatId = $chatId;
        $instance->feed = $feed;
        $instance->refreshInterval = $refreshInterval;

        return $instance;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChatId(): ?string
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

    public function setFeed(?Feed $feed): static
    {
        $this->feed = $feed;

        return $this;
    }

    public function getRefreshInterval(): ?int
    {
        return $this->refreshInterval;
    }

    public function setRefreshInterval(?int $refreshInterval): static
    {
        $this->refreshInterval = $refreshInterval;

        return $this;
    }

    public function getLastCheckAt(): ?\DateTimeImmutable
    {
        return $this->lastCheckAt;
    }

    public function setLastCheckAt(?\DateTimeImmutable $lastCheckAt): static
    {
        $this->lastCheckAt = $lastCheckAt;

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
