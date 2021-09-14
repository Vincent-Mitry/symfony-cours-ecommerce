<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TestController {

    public function index() {
        dd("Ca fonctionne");
    }

    public function test(Request $request) // La ligne entre parenthèses équivaut à la ligne en dessous
    {
        // $request = Request::createFromGlobals(); // Request: Objet dont on se sert pour analyser les requêtes HTTP

        // dump($request);

        $age = $request->query->get('age', 0); // Méthode qui nous permet de récupérer des infos avec des paramètres par défaut

        return new Response("Vous avez $age ans !"); // Response : Classe de HTTP Foudation

    }


}

