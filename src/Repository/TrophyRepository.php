<?php

namespace App\Repository;

use App\Entity\Trophy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Trophy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trophy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trophy[]    findAll()
 * @method Trophy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrophyRepository extends ServiceEntityRepository
{
    /**
     * TrophyRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Trophy::class);
    }

    /**
     * @param int $user_id
     * @param string $action
     * @param int $action_count
     * @return Trophy
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findWithUnlockForAction(int $user_id, string $action, int $action_count): Trophy
    {
        return $this->createQueryBuilder('t')
            ->where('t.action_name = :action_name')
            ->andWhere('t.action_count = :action_count')
            ->andWhere('u.user = :user_id OR u.user IS NULL')
            ->leftJoin('t.unlocks', 'u')
            ->select('t, u')
            ->setParameters([
                'action_count' => $action_count,
                'action_name' => $action,
                'user_id' => $user_id
            ])
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * @param int $user_id
     * @return Trophy[]
     */
    public function findUnlockedFor(int $user_id): array
    {
        return $this->createQueryBuilder('t')
            ->join('t.unlocks', 'u')
            ->where('u.user = :user_id')
            ->setParameter('user_id', $user_id)
            ->getQuery()
            ->getResult();
    }
}
