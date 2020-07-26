<?php

namespace App\Controller\Admin;

use App\Repository\CashCountRepository;
use App\Repository\CashFundRepository;
use App\Repository\ExtractionRepository;
use App\Repository\PurchaseRepository;
use App\Repository\PurchaseUnityRepository;
use App\Repository\RefundRepository;
use App\Service\DateChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * Class AdminPanelController
 * @package App\Controller\Admin
 * @IsGranted("ROLE_ADMIN")
 */
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
        ExtractionRepository $extractionRepository,
        RefundRepository $refundRepository
    ) {
        $today = new DateTime('now');
        $totalAmountToday = $purchaseRepository->getTotalByDay($today);
        $purchasesToday   = $purchaseRepository->findAllByDate($today);
        $purchasesByPayment = $purchaseRepository->getTotalByPaymentModeToday($today);
        $purchasesByProduct = $purchaseUnityRepository->getTotalByProductToday($today);
        $cashFund = $cashFundRepository->getCashFundParams();
        $cashToday = $purchaseRepository->getCurrentCash();
        $totalExtractions = $extractionRepository->getTotalExtractions($today);
        $todayCashCount = $cashCountRepository->getTotayCashCount();
        $totalRefundToday = $refundRepository->getTotalRefundByDate($today);
        $totalRefundWithoutProduct = $refundRepository->findAllByDateWithoutProduct($today);
        $totalRefundWithProduct = $refundRepository->findAllByDateWithProduct($today);
        $totalCashInBox = $cashToday - $totalExtractions - $totalRefundToday;

        $isCountOk = ($totalCashInBox + $cashFundRepository->getCashFund() - $todayCashCount === 0.0);

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
            'total_refund'         => $totalRefundToday,
            'refunds_noproduct'    => $totalRefundWithoutProduct,
            'refunds_products'     => $totalRefundWithProduct,
        ]);
    }


    /**
     * @Route("/cashboard/", name="admin_panel_date", methods={"POST"})
     */
    public function cashBoardByDate(
        Request $request,
        CashFundRepository $cashFundRepository,
        PurchaseRepository $purchaseRepository,
        PurchaseUnityRepository $purchaseUnityRepository,
        CashCountRepository $cashCountRepository,
        ExtractionRepository $extractionRepository,
        RefundRepository $refundRepository,
        DateChecker $dateChecker
    ) {
        $date = $request->request->get('date');
        if($dateChecker::checkDate($date)) {
            $date = new DateTime($dateChecker::checkDate($date) . 'T00:00:00');

            $totalAmountToday = $purchaseRepository->getTotalByDay($date);
            $purchasesToday = $purchaseRepository->findAllByDate($date);
            $purchasesByPayment = $purchaseRepository->getTotalByPaymentModeToday($date);
            $purchasesByProduct = $purchaseUnityRepository->getTotalByProductToday($date);
            $cashFund = $cashFundRepository->getCashFundParams();
            $cashToday = $purchaseRepository->getCurrentCash();
            $totalExtractions = $extractionRepository->getTotalExtractions($date);
            $todayCashCount = $cashCountRepository->getTotayCashCount();
            $totalRefundToday = $refundRepository->getTotalRefundByDate($date);
            $totalRefundWithoutProduct = $refundRepository->findAllByDateWithoutProduct($date);
            $totalRefundWithProduct = $refundRepository->findAllByDateWithProduct($date);
            $totalCashInBox = $cashToday - $totalExtractions - $totalRefundToday;

            $isCountOk = ($totalCashInBox + $cashFundRepository->getCashFund() - $todayCashCount === 0.0);

            return $this->render('admin_panel/cashboard.html.twig', [
                'controller_name' => 'AdminPanelController',
                'total_today' => $totalAmountToday,
                'purchases' => $purchasesToday,
                'purchases_by_payment' => $purchasesByPayment,
                'purchases_products' => $purchasesByProduct,
                'cashfund' => $cashFund,
                'cash_today' => $cashToday,
                'extractions' => $totalExtractions,
                'cash_in_box' => $totalCashInBox + $cashFundRepository->getCashFund(),
                'today_cash_count' => $todayCashCount,
                'is_count_ok' => $isCountOk,
                'total_refund' => $totalRefundToday,
                'refunds_noproduct' => $totalRefundWithoutProduct,
                'refunds_products' => $totalRefundWithProduct,
            ]);
        } else {
            $this->addFlash('error', 'Saisissez une date au bon format jj/mm/aaaa');
            return $this->redirectToRoute('admin_panel');
        }
    }
}
