<?php

namespace App\DataFixtures;

use App\Entity\Trophy;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TrophyFixtures extends Fixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $trophy = new Trophy();
        $trophy->setName('Timidly');
        $trophy->setActionName('comment');
        $trophy->setActionCount(1);
        $manager->persist($trophy);
        $this->setReference('trophy1', $trophy);

        $trophy = new Trophy();
        $trophy->setName('Talker');
        $trophy->setActionName('comment');
        $trophy->setActionCount(5);
        $manager->persist($trophy);
        $this->setReference('trophy2', $trophy);

        $trophy = new Trophy();
        $trophy->setName('Very Talker');
        $trophy->setActionName('comment');
        $trophy->setActionCount(10);
        $manager->persist($trophy);
        $this->setReference('trophy3', $trophy);

        $manager->flush();
    }
}