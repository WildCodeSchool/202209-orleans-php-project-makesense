<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Comment;
use App\Entity\Interaction;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < InteractionFixtures::LOOP_INTERACTION; $i++) {
            $comment = new Comment();
            $comment->setComment($faker->text());
            $comment->setCommentTimedate($faker->dateTimeBetween('-20 week', '+10 week'));
            $comment->setInteraction($this->getReference('interaction_' . $i));
            $manager->persist($comment);
        }


        $manager->flush();
    }

    public function getDependencies()
    {

        return [

            InteractionFixtures::class,

        ];
    }
}
