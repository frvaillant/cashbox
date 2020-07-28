<?php

namespace App\Controller\Admin;

use App\Repository\CashCountRepository;
use App\Repository\CashFundRepository;
use App\Repository\ExtractionRepository;
use App\Repository\PurchaseRepository;
use App\Repository\PurchaseUnityRepository;
use App\Repository\RefundRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Form\DateBoxType;


/**
 * Class AdminPanelController
 * @package App\Controller\Admin
 * @IsGranted("ROLE_ADMIN")
 */
class AdminPanelController extends AbstractController
{
    /**
     * @Route("/admin/panel", name="admin_panel", methods={"GET", "POST"})
     */
    public function index(
        CashFundRepository $cashFundRepository,
        PurchaseRepository $purchaseRepository,
        PurchaseUnityRepository $purchaseUnityRepository,
        CashCountRepository $cashCountRepository,
        ExtractionRepository $extractionRepository,
        RefundRepository $refundRepository,
        Request $request
    ) {
        $form = $this->createForm(DateBoxType::class);
        $form->handleRequest($request);
        $date = new DateTime('now');
        if ($form->isSubmitted() && $form->isValid()) {
            $date = $form->getData('date')['date'];
        }

        $totalAmountToday          = $purchaseRepository->getTotalByDay($date);
        $purchasesToday            = $purchaseRepository->findAllByDate($date);
        $purchasesByPayment        = $purchaseRepository->getTotalByPaymentModeToday($date);
        $purchasesByProduct        = $purchaseUnityRepository->getTotalByProductToday($date);
        $cashFund                  = $cashFundRepository->getCashFundParams();
        $cashToday                 = $purchaseRepository->getCurrentCash();
        $totalExtractions          = $extractionRepository->getTotalExtractions($date);
        $todayCashCount            = $cashCountRepository->getTotayCashCount();
        $totalRefundToday          = $refundRepository->getTotalRefundByDate($date);
        $totalRefundWithoutProduct = $refundRepository->findAllByDateWithoutProduct($date);
        $totalRefundWithProduct    = $refundRepository->findAllByDateWithProduct($date);
        $totalCashInBox            = $cashToday - $totalExtractions - $totalRefundToday + $cashFundRepository->getCashFund();
        $isCountOk = (0.0 === $totalCashInBox + $cashFundRepository->getCashFund() - $todayCashCount);

        return $this->render('admin_panel/index.html.twig', [
            'dateform'             => $form->createView(),
            'date'                 => $date,
            'controller_name'      => 'AdminPanelController',
            'total_today'          => $totalAmountToday,
            'purchases'            => $purchasesToday,
            'purchases_by_payment' => $purchasesByPayment,
            'purchases_products'   => $purchasesByProduct,
            'cashfund'             => $cashFund,
            'cash_today'           => $cashToday,
            'extractions'          => $totalExtractions,
            'cash_in_box'          => $totalCashInBox,
            'today_cash_count'     => $todayCashCount,
            'is_count_ok'          => $isCountOk,
            'total_refund'         => $totalRefundToday,
            'refunds_noproduct'    => $totalRefundWithoutProduct,
            'refunds_products'     => $totalRefundWithProduct,
        ]);
    }
}
