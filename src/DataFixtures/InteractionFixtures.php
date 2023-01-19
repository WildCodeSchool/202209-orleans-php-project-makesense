<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Interaction;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\DecisionFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class InteractionFixtures extends Fixture implements DependentFixtureInterface
{
    private const IMPACTED_USER_PER_DECISION = 10;
    private const EXPERT_USER_PER_DECISION = 3;
    private const USER_ROLE_IMPACTED_DECISION_NUMBER = 20;
    private const USER_ROLE_EXPERT_DECISION_NUMBER = 1;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < DecisionFixtures::DECISION_NUMBER; $i++) {
            for ($j = 0; $j < self::IMPACTED_USER_PER_DECISION; $j++) {
                $interaction = new Interaction();
                $interaction->setUser(
                    $this->getReference('user_' . $faker->numberBetween(0, UserFixtures::GENERIC_USER_ACCOUNT))
                );
                $interaction->setDecision($this->getReference('decision_' . $i));
                $interaction->setDecisionRole(Interaction::DECISION_IMPACTED);

                $manager->persist($interaction);
            }

            for ($l = 0; $l < self::EXPERT_USER_PER_DECISION; $l++) {
                $interaction = new Interaction();
                $interaction->setUser(
                    $this->getReference('user_' . $faker->numberBetween(0, UserFixtures::GENERIC_USER_ACCOUNT))
                );
                $interaction->setDecision($this->getReference('decision_' . $i));
                $interaction->setDecisionRole(Interaction::DECISION_EXPERT);

                $manager->persist($interaction);
            }
        }

        //interactions impacted for User Role tedyDoe@gmail.com
        for ($k = 0; $k < self::USER_ROLE_IMPACTED_DECISION_NUMBER; $k++) {
            $interaction = new Interaction();
            $interaction->setUser(
                $this->getReference('user_' . (UserFixtures::GENERIC_USER_ACCOUNT + 1))
            );
            $interaction->setDecision(
                $this->getReference('decision_' . $faker->unique()->numberBetween(0, DecisionFixtures::DECISION_NUMBER))
            );
            $interaction->setDecisionRole(Interaction::DECISION_IMPACTED);

            $manager->persist($interaction);
        }

        //interactions expert for User Role tedyDoe@gmail.com
        for ($m = 0; $m < self::USER_ROLE_EXPERT_DECISION_NUMBER; $m++) {
            $interaction = new Interaction();
            $interaction->setUser(
                $this->getReference('user_' . (UserFixtures::GENERIC_USER_ACCOUNT + 1))
            );
            $interaction->setDecision(
                $this->getReference('decision_' . $faker->unique()->numberBetween(0, DecisionFixtures::DECISION_NUMBER))
            );
            $interaction->setDecisionRole(Interaction::DECISION_EXPERT);

            $manager->persist($interaction);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [

            UserFixtures::class,
            DecisionFixtures::class,

        ];
    }
}
