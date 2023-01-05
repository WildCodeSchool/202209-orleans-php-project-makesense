<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Decision;
use App\Service\AutomatedDates;
use App\Repository\DecisionRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class DecisionFixtures extends Fixture
{
    public const LOOP_COUNT = 100;

    public AutomatedDates $automatedDates;

    public function __construct(AutomatedDates $automatedDates)
    {
        $this->automatedDates = $automatedDates;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        foreach (CategoryFixtures::CATEGORIES as $categoryName => $color) {
            for ($i = 0; $i < 10; $i++) {
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
                $decision->setCategory($this->getReference('category_' . $categoryName));


                $manager->persist($decision);
            }
        }
        $manager->flush();
    }
}
