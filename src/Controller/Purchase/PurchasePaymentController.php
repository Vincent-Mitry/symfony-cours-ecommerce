<?php

namespace App\Controller\Purchase;

use App\Repository\PurchaseRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchasePaymentController extends AbstractController
{
    /**
     * @Route("/purchase/pay/{id}", name="purchase_payment_form")
     */
    public function showCardForm($id, PurchaseRepository $purchaseRepository)
    {
        $purchase = $purchaseRepository->find($id);

        if(!$purchase)
        {
            return $this->redirectToRoute('cart_show');
        }
        
        \Stripe\Stripe::setApiKey('cleAPI');

        $intent = \Stripe\PaymentIntent::create([

            'amount' => $purchase->getTotal(),
    
            'currency' => 'eur',
        ]);

        dd($intent->client_secret);

        return $this->render('purchase/payment.html.twig', [
            'clientSecret' => $intent->client_secret
        ]);
    }
}