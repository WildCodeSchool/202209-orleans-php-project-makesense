<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Decision;
use App\Service\AutomatedDates;
use App\Service\TimelineManager;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DecisionFixtures extends Fixture implements DependentFixtureInterface
{
    public const DECISION_NUMBER = 100;


    public function __construct(private AutomatedDates $automatedDates, private TimelineManager $timelineManager)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i <= self::DECISION_NUMBER; $i++) {
            $decision = new Decision();
            // The Decision with index 0 will be in vote period TedyDoe is impacted therefore can vote
            // The Decision with index 1 will be in first decision phase with TedyDoe as the creator
            // The Decision with index 2 will be in final decision phase with TedyDoe as the creator
            if ($i === 0) {
                $decision->setTitle('It is voting time !');
                $decision->setDecisionStartTime($faker->dateTimeBetween('-5 week', '-5 week'));
                $decision->setCreator($this->getReference('user_' . rand(0, (UserFixtures::GENERIC_USER_ACCOUNT))));
            } elseif ($i === 1) {
                $decision->setTitle('Make your fist decision !');
                $decision->setDecisionStartTime($faker->dateTimeBetween('-1 week', '-1 week'));
                $decision->setCreator($this->getReference('user_' . (UserFixtures::GENERIC_USER_ACCOUNT + 1)));
            } elseif ($i === 2) {
                $decision->setTitle('Make your final decision !');
                $decision->setDecisionStartTime($faker->dateTimeBetween('-5 week', '-5 week'));
                $decision->setCreator($this->getReference('user_' . (UserFixtures::GENERIC_USER_ACCOUNT + 1)));
            } else {
                $decision->setTitle($faker->sentence(rand(15, 30)));
                $decision->setDecisionStartTime($faker->dateTimeBetween('-20 week', '+10 week'));
                $decision->setCreator($this->getReference('user_' . rand(0, (UserFixtures::GENERIC_USER_ACCOUNT))));
            }
            $decision->setDetails($faker->paragraph(rand(2, 10)));
            $decision->setImpact($faker->paragraph(rand(2, 10)));
            $decision->setGain($faker->paragraph(rand(2, 10)));
            $decision->setRisk($faker->paragraph(rand(2, 10)));
            $decision->setFirstDecisionEndDate($this->automatedDates->firstDecisionEndDateCalculation($decision));
            $decision->setConflictEndDate($this->automatedDates->conflictEndDateCalculation($decision));
            $decision->setFinalDecisionEndDate($this->automatedDates->finalDecisionEndDateCalculation($decision));
            $decision->setCategory($this->getReference('category_' . rand(0, 5)));
            // If the decision is in final state then it already have a first decision
            if ($this->timelineManager->checkDecisionStatus($decision) === Decision::FINAL_DECISION) {
                $decision->setFirstDecision($faker->paragraph(rand(2, 10)));
            }
            $decision->setDecisionStatus($this->timelineManager->checkDecisionStatus($decision));
            $decision->setStatusColor(Decision::STATUS_COLORS[$this->timelineManager->checkDecisionStatus($decision)]);
            $this->addReference('decision_' . $i, $decision);

            $manager->persist($decision);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [

            UserFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
