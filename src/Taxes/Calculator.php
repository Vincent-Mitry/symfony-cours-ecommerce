<?php

namespace App\Taxes;

class Calculator {

    public function calcul(float $prix) : float {
        // On veut calculer le montant de la TVA (tva = 20%) --> 100 => 20
        return $prix * 20 / 100;
    }
}