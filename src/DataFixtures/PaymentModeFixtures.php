<?php

namespace App\DataFixtures;

use App\Entity\PaymentMode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PaymentModeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $paymentMode = new PaymentMode();
        $paymentMode->setName('Espèces');
        $paymentMode->setIdentifier('CASH');
        $manager->persist($paymentMode);
        $manager->flush();
    }
}
