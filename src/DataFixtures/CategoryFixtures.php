<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $user = new Category();
            $user->setName($faker->word);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
