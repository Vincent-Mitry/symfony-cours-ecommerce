<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {

    /**
     * @Route("/", name="homepage")
     */
    public function homepage(ProductRepository $productRepository) 
    {
        // count([])
        // find(id)
        // findBy([], [])
        // findOneBy([], [])
        // findAll()
        $count = $productRepository->count([]);

        dump($count);

        return $this->render('home.html.twig');
    }
}