<?php

namespace App\Controller;

use App\Taxes\Calculator;
use App\Taxes\Detector;
use Cocur\Slugify\Slugify;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HelloController {

    protected $calculator;

    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
    }

    // Pour le controllers (uniquement), on peut l'injecter dans les paramètres d'une méthode
     /**
     * @Route("/hello/{name}", name="hello", methods={"GET", "POST"}, host="localhost", schemes={"http", "https"})
     */
    public function hello(string $name = "World", Environment $twig)
    {
        $html = $twig->render('hello.html.twig', [
            'name' => $name,
            'formateur' => [
                'prenom' => 'Lior',
                'nom' => 'Chamla',
                'age' => 33
            ]
        ]);
        return new Response($html);
    } 
}