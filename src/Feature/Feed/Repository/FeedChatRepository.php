<?php

namespace App\Feature\Feed\Repository;

use App\Entity\FeedChat;
use App\Feature\Feed\ValueObject\FeedId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FeedChat>
 */
class FeedChatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FeedChat::class);
    }

    /**
     * @return FeedChat[]
     */
    public function findActiveByFeedId(FeedId $feedId): array
    {
        $qb = $this->createQueryBuilder('fc');

        return $qb->select('fc', 'feed')
            ->join('fc.feed', 'feed')
            ->where($qb->expr()->eq('feed.id', ':feedId'))
            ->andWhere($qb->expr()->eq('fc.active', ':active'))
            ->setParameter('feedId', $feedId->toInt())
            ->setParameter('active', true)
            ->getQuery()
            ->getResult();
    }
}
