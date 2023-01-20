<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const CATEGORIES = [
        'RH' => '#9B084F',
        'Administratif' => '#24673A',
        'Finance' => '#E36164',
        'R&D' => '#474136',
        'Juridique' => '#70AF90',
        'Marketing' => '#C1E94E',
    ];

    public function load(ObjectManager $manager): void
    {
        $categoryNumber = 0;
        foreach (self::CATEGORIES as $categoryName => $color) {
            $category = new Category();
            $category->setName($categoryName);
            $category->setColor($color);
            $this->addReference('category_' . $categoryNumber, $category);
            $categoryNumber++;

            $manager->persist($category);
        }

        $manager->flush();
    }
}
