<?php

namespace App\Repository;

use App\Entity\TrophyUnlock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TrophyUnlock|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrophyUnlock|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrophyUnlock[]    findAll()
 * @method TrophyUnlock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrophyUnlockRepository extends ServiceEntityRepository
{
    /**
     * TrophyUnlockRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrophyUnlock::class);
    }
}
