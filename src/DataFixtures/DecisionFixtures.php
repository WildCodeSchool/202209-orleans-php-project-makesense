<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Decision;
use App\Service\AutomatedDates;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DecisionFixtures extends Fixture implements DependentFixtureInterface
{
    public const DECISION_NUMBER = 100;

    public AutomatedDates $automatedDates;

    public function __construct(AutomatedDates $automatedDates)
    {
        $this->automatedDates = $automatedDates;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::DECISION_NUMBER; $i++) {
            $decision = new Decision();
            $decision->setTitle($faker->sentence(rand(15, 45)));
            $decision->setDecisionStartTime($faker->dateTimeBetween('-20 week', '+10 week'));
            $decision->setDetails($faker->paragraph(rand(2, 10)));
            $decision->setImpact($faker->paragraph(rand(2, 10)));
            $decision->setGain($faker->paragraph(rand(2, 10)));
            $decision->setRisk($faker->paragraph(rand(2, 10)));
            $decision->setFirstDecisionEndDate($this->automatedDates->firstDecisionEndDateCalculation($decision));
            $decision->setConflictEndDate($this->automatedDates->conflictEndDateCalculation($decision));
            $decision->setFinalDecisionEndDate($this->automatedDates->finalDecisionEndDateCalculation($decision));
            $decision->setCategory($this->getReference('category_' . rand(0, 5)));
            $decision->setCreator($this->getReference('user_' . rand(0, (UserFixtures::GENERIC_USER_ACCOUNT + 2))));
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
