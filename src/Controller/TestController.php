<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TestController {

    public function index() {
        dd("Ca fonctionne");
    }

    public function test(Request $request, $age) // On peut ajouter $age en paramètre et supprimer la ligne du dessous (Symfony reconnaît la paramètre 'age' passé dnas les fichier de routes)
    {

        // $age = $request->attributes->get('age', 0); // On retrouve les paramètres de la route (configuré dans routes.yaml -> /{age}) dans les attributs de la request

        return new Response("Vous avez $age ans !"); // Response : Classe de HTTP Foudation
    }


}

