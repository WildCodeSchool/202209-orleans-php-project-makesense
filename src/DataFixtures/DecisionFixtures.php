<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Decision;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class DecisionFixtures extends Fixture
{
    public const DECISION_NUMBER = 100;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $index = 0;
        while ($index < self::DECISION_NUMBER) {
            $decision = new Decision();

            $decision->setTitle($faker->sentence(rand(15, 45)));
            $decision->setDecisionStartTime($faker->dateTimeBetween('-20 week', '+10 week'));
            $decision->setDetails($faker->paragraph(rand(2, 10)));
            $decision->setImpact($faker->paragraph(rand(2, 10)));
            $decision->setGain($faker->paragraph(rand(2, 10)));
            $decision->setRisk($faker->paragraph(rand(2, 10)));

            $manager->persist($decision);
            $index++;
        }
        $manager->flush();
    }
}
