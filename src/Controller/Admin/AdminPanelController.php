<?php

namespace App\Controller\Admin;

use App\Repository\CashFundRepository;
use App\Repository\PurchaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \DateTime;
class AdminPanelController extends AbstractController
{
    /**
     * @Route("/admin/panel", name="admin_panel")
     */
    public function index(CashFundRepository $cashFundRepository, PurchaseRepository $purchaseRepository)
    {
        $totalAmountToday = $purchaseRepository->getTotalByDay(new DateTime('2020-07-22T00:00:00'));
        dd($totalAmountToday);
        return $this->render('admin_panel/index.html.twig', [
            'controller_name' => 'AdminPanelController',
        ]);
    }
}
