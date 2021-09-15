<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController {

    /**
     * @Route("/", name="index")
     */
    public function index() {
        dd("Ca fonctionne");
    }

    /**
     * @Route("/test/{age<\d+>?0}", name="test", methods={"GET", "POST"}, host="localhost", schemes={"http", "https"})
     */
    public function test(Request $request, $age) // On peut ajouter $age en paramètre et supprimer la ligne du dessous (Symfony reconnaît la paramètre 'age' passé dnas les fichier de routes)
    {

        // $age = $request->attributes->get('age', 0); // On retrouve les paramètres de la route (configuré dans routes.yaml -> /{age}) dans les attributs de la request

        return new Response("Vous avez $age ans !"); // Response : Classe de HTTP Foudation
    }


}

