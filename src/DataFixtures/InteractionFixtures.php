<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Status;
use App\Entity\Interaction;
use App\Service\AutomatedDates;
use App\Service\TimelineManager;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\DecisionFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/** @SuppressWarnings(PHPMD.ExcessiveMethodLength) */
class InteractionFixtures extends Fixture implements DependentFixtureInterface
{
    private const IMPACTED_USER_PER_DECISION = 10;
    private const EXPERT_USER_PER_DECISION = 14;
    private const USER_ROLE_IMPACTED_DECISION_NUMBER = 6;
    private const USER_ROLE_EXPERT_DECISION_NUMBER = 5;
    public const GENERIC_USER_IMPACTED = UserFixtures::GENERIC_USER_ACCOUNT * 0.7;


    public function __construct(private TimelineManager $timelineManager)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < DecisionFixtures::DECISION_NUMBER; $i++) {
            for ($j = 0; $j < self::IMPACTED_USER_PER_DECISION; $j++) {
                $interaction = new Interaction();
                $interaction->setUser(
                    $this->getReference('user_' . $j)
                );
                if (
                    $this->timelineManager->checkDecisionStatus($this->getReference('decision_' . $i))
                    === Status::DECISION_FINISHED
                ) {
                } else {
                    $interaction->setDecision($this->getReference('decision_' . $i));
                }
                $interaction->setDecisionRole(Interaction::DECISION_IMPACTED);

                $manager->persist($interaction);
            }

            $this->addReference('interaction_' . $i, $interaction);

            for ($l = 11; $l < self::EXPERT_USER_PER_DECISION; $l++) {
                $interaction = new Interaction();
                $interaction->setUser(
                    $this->getReference('user_' . $l)
                );
                $interaction->setDecision($this->getReference('decision_' . $i));

                $interaction->setDecisionRole(Interaction::DECISION_EXPERT);

                $manager->persist($interaction);
            }
        }

        //interactions impacted for User Role tedyDoe@gmail.com
        for ($k = 3; $k < self::USER_ROLE_IMPACTED_DECISION_NUMBER; $k++) {
            $interaction = new Interaction();
            $interaction->setUser(
                $this->getReference('user_' . (UserFixtures::GENERIC_USER_ACCOUNT + 3))
            );
            $interaction->setDecision(
                $this->getReference(
                    'decision_' . $faker->unique()->numberBetween(
                        $k,
                        DecisionFixtures::DECISION_NUMBER
                    )
                )
            );

            $interaction->setDecisionRole(Interaction::DECISION_IMPACTED);

            $manager->persist($interaction);
        }

        //interactions expert for User Role tedyDoe@gmail.com
        for ($m = 3; $m < self::USER_ROLE_EXPERT_DECISION_NUMBER; $m++) {
            $interaction = new Interaction();
            $interaction->setUser(
                $this->getReference('user_' . (UserFixtures::GENERIC_USER_ACCOUNT + 3))
            );
            $interaction->setDecision(
                $this->getReference(
                    'decision_' . $faker->unique()->numberBetween(
                        $m,
                        DecisionFixtures::DECISION_NUMBER
                    )
                )
            );

            $interaction->setDecisionRole(Interaction::DECISION_EXPERT);

            $manager->persist($interaction);
        }

        //interaction where Admin is expert and User Role is impacted
        $interaction = new Interaction();
        $interaction->setUser(
            $this->getReference('user_' . (UserFixtures::GENERIC_USER_ACCOUNT + 2))
        );
        $interaction->setDecision(
            $this->getReference('decision_' . 0)
        );
        $interaction->setDecisionRole(Interaction::DECISION_EXPERT);

        $manager->persist($interaction);

        //interaction where User Role Sophie is impacted and Admin is expert in vote period
        $interaction = new Interaction();
        $interaction->setUser(
            $this->getReference('user_' . (UserFixtures::GENERIC_USER_ACCOUNT + 3))
        );
        $interaction->setDecision(
            $this->getReference('decision_' . 0)
        );
        $interaction->setDecisionRole(Interaction::DECISION_IMPACTED);

        $manager->persist($interaction);

        //interaction where Sophie is expert in conflict period
        $interaction = new Interaction();
        $interaction->setUser(
            $this->getReference('user_' . (UserFixtures::GENERIC_USER_ACCOUNT + 3))
        );
        $interaction->setDecision(
            $this->getReference('decision_' . 3)
        );
        $interaction->setDecisionRole(Interaction::DECISION_EXPERT);

        $manager->persist($interaction);

        //interaction where User Role is impacted and Admin is expert in vote period
        $interaction = new Interaction();
        $interaction->setUser(
            $this->getReference('user_' . (UserFixtures::GENERIC_USER_ACCOUNT + 1))
        );
        $interaction->setDecision(
            $this->getReference('decision_' . 0)
        );
        $interaction->setDecisionRole(Interaction::DECISION_IMPACTED);

        $manager->persist($interaction);

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
