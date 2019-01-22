<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class DemoController extends AbstractController
{
    /**
     * @Route("/demo", name="demo")
     */
    public function index()
    {
        return $this->render('demo/index.html.twig', [
            'controller_name' => 'DemoController',
        ]);
    }

    /**
    * @Route("/demo-information", name="demo_information")
    */
    public function information() 
    {
    	$variable = [
    		'title' 	=> 'Information importante',
    		'content'	=> 'description de contenu : information importante'
    	];

    	// return new JsonResponse($variable);

    	return $this->render('demo/information.html.twig', $variable);
    }
}
