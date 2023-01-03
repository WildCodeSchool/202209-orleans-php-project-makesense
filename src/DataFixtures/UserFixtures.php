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


    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {

        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $count = 0;

        while ($count < 5) {
            $user = new User();
            $user->setEmail($faker->email());
            $user->setRoles([]);
            $user->setPassword($faker->password());
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setPoster('person.svg');
            $user->setIsApproved('0');
            $manager->persist($user);
            $count++;
        }


        $user = new User();

        $user->setEmail('tedyDoe@gmail.com');
        $user->setRoles([]);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'tedytedy'
        );
        $user->setPassword($hashedPassword);
        $user->setFirstname('Tedy');
        $user->setLastname('Doe');
        $user->setIsApproved('0');
        $user->setPoster('person.svg');
        $manager->persist($user);

        $user = new User();
        $user->setEmail('admin@make-sense.ms');
        $user->setRoles([]);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'adminadmin'
        );
        $user->setPassword($hashedPassword);
        $user->setFirstname('Admin');
        $user->setLastname('MakeSense');
        $user->setPoster('person.svg');
        $user->setIsApproved('0');
        $manager->persist($user);

        $manager->flush();
    }
}
