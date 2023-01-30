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
    public const COMMENT_NUMBER_BY_INTERACTION = 3;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < DecisionFixtures::DECISION_NUMBER; $i++) {
            for ($j = 0; $j < self::COMMENT_NUMBER_BY_INTERACTION; $j++) {
                $comment = new Comment();

                $comment->setComment($faker->text());

                $comment->setCommentTimedate($faker->dateTimeBetween('-20 week', '+10 week'));

                $comment->setUser($this->getReference('user_' . UserFixtures::GENERIC_USER_ACCOUNT));
                $comment->setDecision($this->getReference('decision_' . $i));
                $manager->persist($comment);
            }
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
