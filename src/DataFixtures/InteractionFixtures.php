<?php

namespace App\DataFixtures;

use App\Entity\Interaction;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class InteractionFixtures extends Fixture implements DependentFixtureInterface
{
    public const LOOP_INTERACTION = 100;

    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < self::LOOP_INTERACTION; $i++) {
            $interraction = new Interaction();

            $interraction->setRole('');
            $interraction->setVote(true);
            $interraction->setUser($this->getReference('user_' . rand(0, 5)));
            $interraction->setDecision($this->getReference('decision_' . $i));
            $this->addReference('interaction_' . $i, $interraction);
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
