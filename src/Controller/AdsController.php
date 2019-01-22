<?php

namespace App\Controller;

use App\Provider\AdsProvider;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdsController extends AbstractController
{
    /**
     * @Route("/ads", name="ads")
     */
    public function index(AdsProvider $ads)
    {
        return $this->render('ads/index.html.twig', [
            'content' => 'du contenu',
            'ads' => $ads->getAll(),
            'adsSidebar' => $ads->get()
        ]);
    }

    public function footer(AdsProvider $ads) {
        return $this->render('ads/footer.html.twig', [
            'ads' => $ads->get()
        ]);	
    }
}
