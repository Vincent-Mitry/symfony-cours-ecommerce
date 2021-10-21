<?php

namespace App\Controller;

use App\Cart\CartService;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart/add/{id}", name="cart_add", requirements={"id":"\d+"})
     */
    public function add($id, ProductRepository $productRepository, CartService $cartService): Response
    {
        // 0. Sécurisation: est-ce que le produit existe ?
        $product = $productRepository->find($id);

        if(!$product) {
            throw $this->createNotFoundException("Le produit $id n'existe pas!");
        }
        
        $cartService->add($id);

        $this->addFlash('success', "Le produit a bien été ajouté au panier");
        // $flashBag->add('success', "Le produit a bien été ajouté au panier");

        return $this->redirectToRoute('product_show', [
            'slug' => $product->getSlug(),
            'category_slug' => $product->getCategory()->getSlug()
        ]);
    }

    /**
     * @Route("/cart", name="cart_show")
     */
    public function show(CartService $cartService)
    {   
        $detailedCart = $cartService->getDetailedCartItems();

        $total = $cartService->getTotal();

        return $this->render('cart/index.html.twig', [
            'items' => $detailedCart,
            'total' => $total
        ]);
    }
}
