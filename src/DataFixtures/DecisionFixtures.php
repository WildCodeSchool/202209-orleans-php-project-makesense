<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Decision;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class DecisionFixtures extends Fixture
{
    public const LOOP_INDEX = 5;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $index = 0;
        while ($index < self::LOOP_INDEX) {
            $decision = new Decision();

            $decision->setTitle($faker->sentence(rand(3, 7)));
            $decision->setDecisionStartTime($faker->dateTimeBetween('now', '+10 week'));
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
