<?php

namespace App\Manager;

use App\Entity\Trophy;
use App\Entity\TrophyUnlock;
use App\Entity\User;
use App\Event\TrophyUnlokedEvent;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class TrophyManager
{
    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * TrophyManager constructor.
     * @param ObjectManager $entityManager
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(ObjectManager $entityManager, EventDispatcherInterface $dispatcher)
    {
        $this->em = $entityManager;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param User $user
     * @param string $action
     * @param int $action_count
     */
    public function checkAndUnlock(User $user, string $action, int $action_count): void
    {
        try {
            $trophy = $this->em->getRepository(Trophy::class)->findWithUnlockForAction($user->getId(), $action,
                $action_count);
            if ($trophy->getUnlocks()->isEmpty()) {
                $unlock = new TrophyUnlock();
                $unlock->setTrophy($trophy);
                $unlock->setUser($user);
                $this->em->persist($unlock);
                $this->em->flush();
                $this->dispatcher->dispatch(TrophyUnlokedEvent::NAME, new TrophyUnlokedEvent($unlock));
            }
        } catch (NoResultException $e) {
        } catch (NonUniqueResultException $e) {
        }
    }

    /**
     * @param User $user
     * @return array|null
     */
    public function getTrophiesFor(User $user): ?array
    {
        return $this->em->getRepository(Trophy::class)->findUnlockedFor($user->getId());
    }
}