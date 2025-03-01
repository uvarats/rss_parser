<?php

namespace App\Feature\Feed\Repository;

use App\Entity\Feed;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Feed>
 */
class FeedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Feed::class);
    }

    /**
     * @return array<Feed>
     */
    public function findActive(): array
    {
        $qb = $this->createQueryBuilder('f');

        return $qb
            ->where($qb->expr()->eq('f.active', true))
            ->getQuery()
            ->getResult();
    }
}
