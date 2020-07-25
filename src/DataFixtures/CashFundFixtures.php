<?php

namespace App\DataFixtures;

use App\Entity\CashFund;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CashFundFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $cashFund = new CashFund();
        $cashFund->setAmount(0);
        $manager->persist($cashFund);

        $manager->flush();
    }
}
