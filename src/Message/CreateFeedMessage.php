<?php

namespace App\Message;

use App\Feature\Feed\Enum\FeedTypeEnum;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateFeedMessage
{
     public function __construct(
         #[Assert\NotBlank]
         public string $name,
         #[Assert\Url]
         public string $url,
         public FeedTypeEnum $type = FeedTypeEnum::CUSTOM,
     ) {}
}
