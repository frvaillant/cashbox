<?php

namespace App\Controller\Admin;

use App\Repository\CashCountRepository;
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
        CashCountRepository $cashCountRepository,
        ExtractionRepository $extractionRepository
    ) {
        $today = new DateTime('now');
        $totalAmountToday = $purchaseRepository->getTotalByDay($today);
        $purchasesToday   = $purchaseRepository->findAllByDate($today);
        $purchasesByPayment = $purchaseRepository->getTotalByPaymentModeToday();
        $purchasesByProduct = $purchaseUnityRepository->getTotalByProductToday();
        $cashFund = $cashFundRepository->getCashFundParams();
        $cashToday = $purchaseRepository->getCurrentCash();
        $totalExtractions = $extractionRepository->getTotalExtractions();
        $totalCashInBox = $cashToday - $totalExtractions;
        $todayCashCount = $cashCountRepository->getTotayCashCount();
        $isCountOk = ($totalCashInBox + $cashFundRepository->getCashFund() - $todayCashCount === 0);

        return $this->render('admin_panel/index.html.twig', [
            'controller_name'      => 'AdminPanelController',
            'total_today'          => $totalAmountToday,
            'purchases'            => $purchasesToday,
            'purchases_by_payment' => $purchasesByPayment,
            'purchases_products'   => $purchasesByProduct,
            'cashfund'             => $cashFund,
            'cash_today'           => $cashToday,
            'extractions'          => $totalExtractions,
            'cash_in_box'          => $totalCashInBox + $cashFundRepository->getCashFund(),
            'today_cash_count'     => $todayCashCount,
            'is_count_ok'          => $isCountOk,
        ]);
    }
}
