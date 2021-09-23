<?php

namespace App\Taxes;

use Psr\Log\LoggerInterface;

class Calculator {

    protected $logger;

    public function __construct(LoggerInterface $logger, float $tva)
    {
        $this->logger = $logger;
        $this->tva = $tva;
    }

    public function calcul(float $prix) : float {
        $this->logger->info("Un calcul a lieu : $prix");
        // On veut calculer le montant de la TVA (tva = 20%) --> 100 => 20
        return $prix * 20 / 100;
    }
}