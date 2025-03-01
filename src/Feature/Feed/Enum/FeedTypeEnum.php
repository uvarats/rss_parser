<?php

declare(strict_types=1);

namespace App\Feature\Feed\Enum;

enum FeedTypeEnum: string
{
    case ONET = 'onet';
    case POLSAT_NEWS = 'polsat_news';
    case CUSTOM = 'custom';
}

