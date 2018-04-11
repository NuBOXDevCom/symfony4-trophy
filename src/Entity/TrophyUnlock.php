<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrophyUnlockRepository")
 */
class TrophyUnlock
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Trophy
     * @ORM\ManyToOne(targetEntity="App\Entity\Trophy", inversedBy="unlocks")
     */
    private $badge;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param Trophy $badge
     * @return TrophyUnlock
     */
    public function setTrophy(Trophy $badge): TrophyUnlock
    {
        $this->badge = $badge;
        return $this;
    }

    /**
     * @return Trophy
     */
    public function getTrophy(): Trophy
    {
        return $this->badge;
    }

    /**
     * @param User $user
     * @return TrophyUnlock
     */
    public function setUser(User $user): TrophyUnlock
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
