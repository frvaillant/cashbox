<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\PurchaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CashBoxController extends AbstractController
{
    /**
     * @param ProductRepository $productRepository
     * @Route("/cashbox", name="cash_box")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function index(ProductRepository $productRepository, PurchaseRepository $purchaseRepository)
    {
        $products = $productRepository->findAllForCashBox();
        $totalForDay = $purchaseRepository->getTotalByDay();
        return $this->render('cash_box/index.html.twig', [
            'products' => $products,
            'total'    => $totalForDay,
        ]);
    }
}
