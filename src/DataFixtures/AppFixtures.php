<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 35; $i++)
        {
            $user = new User();
            $user->setUsername(sprintf('user_%d', $i + 1));

            $password = $this->hasher->hashPassword($user, 'test123');
            $user->setPassword($password);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
