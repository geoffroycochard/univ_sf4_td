<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Ticket;
use App\Entity\User;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TicketFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /** @var Faker\Generator $faker */
        $faker = Faker\Factory::create('fr_FR');

        // 10 users / 10 categories
        $users = $manager->getRepository(User::class)->findAll();
        $categories = $manager->getRepository(Category::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            /** @var Ticket $ticket */
            $ticket = new Ticket();
            $ticket->setTitle($faker->text(rand(10,20)));
            $ticket->setDescription($faker->text);

            // Date
            $date = new \DateTime();
            $date->modify(sprintf('-%d day', rand(1,90)));
            $ticket->setDate($date);

            // Category
            $ticket->setCategory($categories[rand(0,9)]);

            // Users
            for ($j = 0; $j < rand(1,5); $j++) {
                $ticket->addUser($users[rand(0,9)]);
            }

            $manager->persist($ticket);
        }

        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            CategoryFixtures::class
        );
    }

}
