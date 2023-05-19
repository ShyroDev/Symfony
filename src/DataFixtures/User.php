<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class User extends Fixture
{
    private UserPasswordHasherInterface $passwordHasches;

    public function __construct(UserPasswordHasherInterface $passwordHashes)
    {
        $this->passwordHasches = $passwordHashes;
    }


    public function load(ObjectManager $manager): void
    {
        $user = new \App\Entity\User();

        $user->setUsername("test");
        $user->setPassword($this->passwordHasches->hashPassword($user, 'test'));


        $manager->persist($user);
        $manager->flush();
    }




}
