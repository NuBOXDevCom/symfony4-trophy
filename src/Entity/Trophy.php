<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrophyRepository")
 */
class Trophy
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $action_name;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $action_count;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\TrophyUnlock", mappedBy="badge")
     */
    private $unlocks;

    /**
     * Badge constructor.
     */
    public function __construct()
    {
        $this->unlocks = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Trophy
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getActionName(): ?string
    {
        return $this->action_name;
    }

    /**
     * @param string $action_name
     * @return Trophy
     */
    public function setActionName(string $action_name): self
    {
        $this->action_name = $action_name;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getActionCount(): ?int
    {
        return $this->action_count;
    }

    /**
     * @param int $action_count
     * @return Trophy
     */
    public function setActionCount(int $action_count): self
    {
        $this->action_count = $action_count;

        return $this;
    }

    /**
     * @param TrophyUnlock[] $unlocks
     * @return Trophy
     */
    public function setUnlocks(array $unlocks): Trophy
    {
        $this->unlocks = $unlocks;
        return $this;
    }

    /**
     * @return Collection|TrophyUnlock[]
     */
    public function getUnlocks()
    {
        return $this->unlocks;
    }
}
