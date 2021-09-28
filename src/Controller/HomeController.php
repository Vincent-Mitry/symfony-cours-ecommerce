<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {

    /**
     * @Route("/", name="homepage")
     */
    public function homepage(EntityManagerInterface $em) 
    {
        $product = new Product;

        $product->setName('Table en métal')
                ->setPrice(3000)
                ->setSlug('table-en-metal');

        $em->persist($product);
        $em->flush();

        dd($product);

        return $this->render('home.html.twig');
    }
}