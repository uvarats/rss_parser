<?php

namespace App\Entity;

use App\Feature\Feed\Enum\FeedTypeEnum;
use App\Feature\Feed\Repository\FeedRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: FeedRepository::class)]
class Feed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, options: ['default' => 'Unnamed feed'])]
    private string $name = 'Unnamed feed';

    #[ORM\Column(length: 255, unique: true)]
    private string $url;

    #[ORM\Column(enumType: FeedTypeEnum::class, options: ['default' => FeedTypeEnum::CUSTOM->value])]
    private FeedTypeEnum $type = FeedTypeEnum::CUSTOM;

    #[ORM\Column(options: ['default' => true])]
    private bool $active = true;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Gedmo\Timestampable]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public static function make(
        ?string $name,
        string $url,
        FeedTypeEnum $type = FeedTypeEnum::CUSTOM,
    ): Feed {
        $instance = new self();

        $instance->name = $name ?? $instance->name;
        $instance->url = $url;
        $instance->type = $type;

        return $instance;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getType(): FeedTypeEnum
    {
        return $this->type;
    }

    public function setType(FeedTypeEnum $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
