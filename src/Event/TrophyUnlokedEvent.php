<?php

namespace App\Event;

use App\Entity\Trophy;
use App\Entity\TrophyUnlock;
use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class TrophyUnlokedEvent
 * @package App\Event
 */
class TrophyUnlokedEvent extends Event
{
    public const NAME = 'trophy.unlocked';
    /**
     * @var TrophyUnlock
     */
    private $trophyUnlock;

    /**
     * TrophyUnlokedEvent constructor.
     * @param TrophyUnlock $trophyUnlock
     */
    public function __construct(TrophyUnlock $trophyUnlock)
    {
        $this->trophyUnlock = $trophyUnlock;
    }

    /**
     * @return Trophy
     */
    public function getTrophy(): Trophy
    {
        return $this->trophyUnlock->getTrophy();
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->trophyUnlock->getUser();
    }
}