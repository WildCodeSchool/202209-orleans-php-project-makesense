<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public const GENERIC_USER_ACCOUNT = 100;


    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {

        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i <= self::GENERIC_USER_ACCOUNT; $i++) {
            $user = new User();
            $user->setEmail($faker->email());
            $user->setRoles([]);
            $user->setPassword($faker->password());
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $this->addReference('user_' . $i, $user);

            $manager->persist($user);
        }


        //Role User
        $user = new User();
        $user->setEmail('tedyDoe@gmail.com');
        $user->setRoles(['ROLE_MEMBER']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'tedytedy'
        );
        $user->setPassword($hashedPassword);
        $user->setFirstname('Tedy');
        $user->setLastname('Doe');
        $this->addReference('user_' . (self::GENERIC_USER_ACCOUNT + 1), $user);
        $manager->persist($user);


        //Role Admin
        $user = new User();
        $user->setEmail('admin@make-sense.ms');
        $user->setRoles([]);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'adminadmin'
        );
        $user->setPassword($hashedPassword);
        $user->setFirstname('Admin');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setLastname('MakeSense');
        $this->addReference('user_' . (self::GENERIC_USER_ACCOUNT + 2), $user);
        $manager->persist($user);

        $manager->flush();
    }
}
