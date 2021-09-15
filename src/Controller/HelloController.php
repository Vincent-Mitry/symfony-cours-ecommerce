<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController {

    // On injecte notre dépendance dans le constructeur (méthode qui fonctionne pour toutes le classes)
    
    // protected $logger;

    // public function __construct(LoggerInterface $logger)
    // {
    //     $this->logger = $logger;
    // }

    // Pour le controllers (uniquement), on peut l'injecter dans les paramètres d'une méthode
     /**
     * @Route("/hello/{name}", name="hello", methods={"GET", "POST"}, host="localhost", schemes={"http", "https"})
     */
    public function hello(string $name = "World", LoggerInterface $logger)
    {
        // A chaque fois qu'on va appeler cette route, ce message de log va s'afficher dans la console
        // $this->logger->info("Mon message de log !");
        $logger->info("Mon message de log !");
        return new Response("Hello $name");
    } 
}