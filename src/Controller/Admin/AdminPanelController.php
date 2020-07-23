<?php

namespace App\Controller\Admin;

use App\Repository\CashFundRepository;
use App\Repository\ExtractionRepository;
use App\Repository\PurchaseRepository;
use App\Repository\PurchaseUnityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \DateTime;
class AdminPanelController extends AbstractController
{
    /**
     * @Route("/admin/panel", name="admin_panel")
     */
    public function index(
        CashFundRepository $cashFundRepository,
        PurchaseRepository $purchaseRepository,
        PurchaseUnityRepository $purchaseUnityRepository,
        ExtractionRepository $extractionRepository
    ) {
        $today = new DateTime('now');
        $totalAmountToday = $purchaseRepository->getTotalByDay($today);
        $purchasesToday   = $purchaseRepository->findAllByDate($today);
        $purchasesByPayment = $purchaseRepository->getTotalByPaymentModeToday();
        $purchasesByProduct = $purchaseUnityRepository->getTotalByProductToday();
        $cashFund = $cashFundRepository->findOneById(1);
        $cashToday = $purchaseRepository->getCurrentCash();
        $totalExtractions = $extractionRepository->getTotalExtractions();
        $totalCashInBox = $cashToday - $totalExtractions;

        return $this->render('admin_panel/index.html.twig', [
            'controller_name'      => 'AdminPanelController',
            'total_today'          => $totalAmountToday,
            'purchases'            => $purchasesToday,
            'purchases_by_payment' => $purchasesByPayment,
            'purchases_products'   => $purchasesByProduct,
            'cashfund'             => $cashFund,
            'cash_today'           => $cashToday,
            'extractions'          => $totalExtractions,
            'cash_in_box'          => $totalCashInBox,
        ]);
    }
}
