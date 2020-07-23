<?php

namespace App\Controller;

use App\Entity\PurchaseUnity;
use App\Service\CartAmoutCalculator;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseController extends AbstractController
{
    /**
     * @Route("/purchase/add", name="add_purchase", methods={"POST"})
     */
    public function addPurchase(Request $request, CartAmoutCalculator $amoutCalculator)
    {
        $data = $request->getContent();
        $cart = json_decode($data, true);
        dd($amoutCalculator::calculateCartAmount($cart));
        foreach ($cart as $purchase) {
            $purchaseUnity = new PurchaseUnity();

        }

    }
}
