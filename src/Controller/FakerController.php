<?php

namespace App\Controller;

use Faker;
use App\Entity\User;
use App\Entity\Ticket;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FakerController extends AbstractController
{
    /**
     * @Route("/create-user", name="faker")
     */
    public function index()
    {
        $faker = Faker\Factory::create('fr_FR');

        $em = $this->getDoctrine()->getManager();

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setName($faker->name);
            $em->persist($user);
            dump($user);
        }

        $em->flush();
        
        return new Response('Categories created');
    }

    /**
     * @Route("/create-tickets", name="faker-ticket")
     */
    public function createTicket() 
    {
        /** @var Faker\Generator $faker */
        $faker = Faker\Factory::create('fr_FR');
        $em = $this->getDoctrine()->getManager();
        
        // 10 users / 10 categories
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
    
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
            
            $em->persist($ticket);
        } 

        $em->flush();

        return new Response('Tickets created');

    }

    /**
     * @Route("/test-constraint", name="faker-ticket")
     */
    public function testConstraint(ValidatorInterface $validator) 
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Ticket $ticket */
        $ticket = new Ticket();
        $ticket->setTitle('title');
        $ticket->setDate(new \DateTime());

        $category = new Category();
        $category->setName('nom');
        $ticket->setCategory($category);

        for ($i=0; $i<3; $i++) {
            $user = new User();
            $user->setName('Firstname Lastname 5');
            $errors = $validator->validate($user);
            if (count($errors) > 0) {

                echo '<pre>';
                echo dump($errors);
                echo '</pre>';
                return new Response('Erros users...?');
            }
            $em->persist($user);
            $em->flush();
            $ticket->addUser($user);
        }

        $errors = $validator->validate($ticket);

        $em->persist($ticket);
        $em->flush();

        echo '<pre>';
        echo dump($errors);
        echo '</pre>';

        return new Response('Tickets validating...?');

    }

    private function getFaker() 
    {
        return $faker = Faker\Factory::create('fr_FR');
    }
}
