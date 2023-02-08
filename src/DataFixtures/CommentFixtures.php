<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public const COMMENT_NUMBER_BY_INTERACTION = 3;
    public const DECISION_0_COMMENTS = [
        "<p style='color:#000000;font-family:'Raleway',
        sans-serif;font-size:1.2rem;font-weight:400;'>
        Je suis d'accord avec ça, depuis le temps que j'attends de pouvoir quitter Excel !
        </p>",
        "<p style='color:#000000;font-family:'Raleway',
        sans-serif;font-size:1.2rem;font-weight:400;'>
        Très bonne idée.
        </p>",
        "<p style='color:#000000;font-family:'Raleway',
        sans-serif;font-size:1.2rem;font-weight:400;'>
        Je ne vois pas le rapport entre la musique et l'outil internet
        </p>",
    ];
    public const DECISION_1_COMMENTS = [
        "<p style='color:#000000;font-family:'Raleway',
        sans-serif;font-size:1.2rem;font-weight:400;'>
        Je ne suis pas sûr de pouvoir m'en sortir sur de nouvelles machines mais je veux bien essayer.
        </p>",
        "<p style='color:#000000;font-family:'Raleway',
        sans-serif;font-size:1.2rem;font-weight:400;'>
        Depuis le temps, qu'il faut en changer... Belle initiative !
        </p>",
        "<p style='color:#000000;font-family:'Raleway',
        sans-serif;font-size:1.2rem;font-weight:400;'>
        J'ajouterai que ces vieux coucous nous coûtaient très cher en maintenancer tous les ans.
        </p>",
        "<p style='color:#000000;font-family:'Raleway',
        sans-serif;font-size:1.2rem;font-weight:400;'>
        Tout à fait d'accord avec ça.
        </p>",
        "<p style='color:#000000;font-family:'Raleway',
        sans-serif;font-size:1.2rem;font-weight:400;'>
        Ne vous inquiétez pas, les nouvelles machines sont très 
        facile à prendre en main. Sinon rien à redire sur cette 1ère décision
        </p>",
    ];
    public const DECISION_3_COMMENTS = [
        "<p style='color:#000000;font-family:'Raleway',
        sans-serif;font-size:1.2rem;font-weight:400;'>
        En tant qu'amateur de café, je ne peux qu'apprécier cette initiative.
        </p>",
        "<p style='color:#000000;font-family:'Raleway',
        sans-serif;font-size:1.2rem;font-weight:400;'>
        Très bonne idée.
        </p>",
        "<p style='color:#000000;font-family:'Raleway',
        sans-serif;font-size:1.2rem;font-weight:400;'>
        Il existe d'autres solutions, par exemple les dosettes 
        réutiilisables dans lesquelles on peut mettre du café moulu.
        </p>",
    ];

    public const DECISION_4_COMMENTS = [
        "<p style='color:#000000;font-family:'Raleway',
        sans-serif;font-size:1.2rem;font-weight:400;'>
        Bof bof comme idée.
        </p>",
        "<p style='color:#000000;font-family:'Raleway',
        sans-serif;font-size:1.2rem;font-weight:400;'>
        Très bonne idée.
        </p>",
        "<p style='color:#000000;font-family:'Raleway',
        sans-serif;font-size:1.2rem;font-weight:400;'>
        Je ne pense pas que ce soit essentiel.
        </p>",
    ];


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 5; $i < DecisionFixtures::DECISION_NUMBER; $i++) {
            for ($j = 0; $j < self::COMMENT_NUMBER_BY_INTERACTION; $j++) {
                $comment = new Comment();

                $comment->setComment($faker->text());

                $comment->setCommentTimedate($faker->dateTimeBetween('-20 week', '+10 week'));

                $comment->setUser($this->getReference('user_' . rand(0, (UserFixtures::GENERIC_USER_ACCOUNT))));
                $comment->setDecision($this->getReference('decision_' . $i));
                $manager->persist($comment);
            }
        }
        //comments for Decision 0
        for ($i = 0; $i < self::COMMENT_NUMBER_BY_INTERACTION; $i++) {
            $comment = new Comment();

            $comment->setComment(self::DECISION_0_COMMENTS[$i]);

            $comment->setCommentTimedate($faker->dateTimeBetween('-20 week', '+10 week'));

            $comment->setUser($this->getReference('user_' . rand(0, (UserFixtures::GENERIC_USER_ACCOUNT))));
            $comment->setDecision($this->getReference('decision_0'));
            $manager->persist($comment);

            $manager->flush();
        }

        //comments for Decision 1
        for ($i = 0; $i < (self::COMMENT_NUMBER_BY_INTERACTION + 2); $i++) {
            $comment = new Comment();

            $comment->setComment(self::DECISION_1_COMMENTS[$i]);

            $comment->setCommentTimedate($faker->dateTimeBetween('-20 week', '+10 week'));

            $comment->setUser($this->getReference('user_' . rand(0, (UserFixtures::GENERIC_USER_ACCOUNT))));
            $comment->setDecision($this->getReference('decision_1'));
            $manager->persist($comment);

            $manager->flush();
        }

        //comments for Decision 2
        for ($i = 0; $i < (self::COMMENT_NUMBER_BY_INTERACTION - 1); $i++) {
            $comment = new Comment();

            $comment->setComment(self::DECISION_1_COMMENTS[$i]);

            $comment->setCommentTimedate($faker->dateTimeBetween('-20 week', '+10 week'));

            $comment->setUser($this->getReference('user_' . rand(0, (UserFixtures::GENERIC_USER_ACCOUNT))));
            $comment->setDecision($this->getReference('decision_2'));
            $manager->persist($comment);

            $manager->flush();
        }

        //comments for Decision 3
        for ($i = 0; $i < self::COMMENT_NUMBER_BY_INTERACTION; $i++) {
            $comment = new Comment();

            $comment->setComment(self::DECISION_3_COMMENTS[$i]);

            $comment->setCommentTimedate($faker->dateTimeBetween('-20 week', '+10 week'));

            $comment->setUser($this->getReference('user_' . rand(0, (UserFixtures::GENERIC_USER_ACCOUNT))));
            $comment->setDecision($this->getReference('decision_3'));
            $manager->persist($comment);

            $manager->flush();
        }

        //comments for Decision 4
        for ($i = 0; $i < self::COMMENT_NUMBER_BY_INTERACTION; $i++) {
            $comment = new Comment();

            $comment->setComment(self::DECISION_4_COMMENTS[$i]);

            $comment->setCommentTimedate($faker->dateTimeBetween('-20 week', '+10 week'));

            $comment->setUser($this->getReference('user_' . rand(0, (UserFixtures::GENERIC_USER_ACCOUNT))));
            $comment->setDecision($this->getReference('decision_4'));
            $manager->persist($comment);

            $manager->flush();
        }
    }

    public function getDependencies()
    {

        return [

            InteractionFixtures::class,

        ];
    }
}
