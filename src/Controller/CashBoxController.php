<?php

namespace App\Controller;

use App\Entity\Extraction;
use App\Form\ExtractionType;
use App\Repository\PaymentModeRepository;
use App\Repository\ProductRepository;
use App\Repository\PurchaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CashBoxController extends AbstractController
{
    /**
     * @param ProductRepository $productRepository
     * @Route("/cashbox", name="cash_box")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function index(
        ProductRepository $productRepository,
        PurchaseRepository $purchaseRepository,
        PaymentModeRepository $paymentModeRepository,
        Request $request
    ) {

        $extraction = new Extraction();
        $form = $this->createForm(ExtractionType::class, $extraction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($extraction);
            $entityManager->flush();
            $response = $this->redirectToRoute('cash_box');
        } else {
            $products = $productRepository->findAllForCashBox();
            $totalForDay = $purchaseRepository->getTotalByDay();
            $paymentModes = $paymentModeRepository->findAll();
            $response = $this->render('cash_box/index.html.twig', [
                'products' => $products,
                'total' => $totalForDay,
                'payment_modes' => $paymentModes,
                'extraction' => $extraction,
                'form' => $form->createView(),
            ]);
        }

        return $response;
    }
}
