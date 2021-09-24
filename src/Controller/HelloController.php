<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{

     /**
     * @Route("/hello/{name}", name="hello", methods={"GET", "POST"}, host="localhost", schemes={"http", "https"})
     */
    public function hello(string $name = "World")
    {
        return $this->render('hello.html.twig', ['name' => $name]);
    }
    /**
     * @Route("/example", name="example")
     */
    public function example()
    {
        return $this->render('example.html.twig', ['age' => 33]);
    }
}