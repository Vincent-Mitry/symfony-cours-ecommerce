<?php

namespace App\Controller;

use App\Taxes\Calculator;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function hello(string $name = "World", LoggerInterface $logger)
    {
        // A chaque fois qu'on va appeler cette route, ce message de log va s'afficher dans la console
        // $this->logger->info("Mon message de log !");
        $logger->info("Mon message de log !");

        $tva = $this->calculator->calcul(100);

        dump($tva);

        return new Response("Hello $name");
    } 
}