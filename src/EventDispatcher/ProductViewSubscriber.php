<?php

namespace App\EventDispatcher;

use App\Event\ProductViewEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProductViewSubscriber implements EventSubscriberInterface
{
    private $logger;
    // On se fait injecter par autowiring un Logger interface pour l'utiliser dans notre fonction (afin d'afficher un message de log)
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
            'product.view' => 'sendAdminEmail' // A chaque fois qu'on a un événement 'product.view', on appelle notre fonction 'sendAdminEmail'
        ];
    }
    
    public function sendAdminEmail(ProductViewEvent $productViewEvent)
    {
        $this->logger->info("La page du produit " . 
        $productViewEvent->getProduct()->getName() .
        " (Id : " .
        $productViewEvent->getProduct()->getId() . 
        ") a reçu une visite.");
    }
}