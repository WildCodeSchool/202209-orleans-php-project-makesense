<?php

namespace App\DataFixtures;

use App\Entity\Interaction;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class InteractionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {




        for ($i = 0; $i < 100; $i++) {
            $interraction = new Interaction();

            $interraction->setRole('');
            $interraction->setVote(true);
            $interraction->setUser($this->getReference('user_' . rand(0, 5)));
            $interraction->setDecision($this->getReference('decision_' . $i));

            $manager->persist($interraction);
        }


        $manager->flush();
    }

    public function getDependencies()
    {

        return [

            UserFixtures::class,

        ];
    }
}
