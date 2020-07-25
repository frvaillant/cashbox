<?php

namespace App\Controller;

use App\Entity\CashCount;
use App\Entity\Extraction;
use App\Entity\Refund;
use App\Form\CashCountType;
use App\Form\ExtractionType;
use App\Form\RefundType;
use App\Repository\PaymentModeRepository;
use App\Repository\ProductRepository;
use App\Repository\PurchaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * Class CashBoxController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class CashBoxController extends AbstractController
{

    const CASH = 'CASH';

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

        //Cash extraction
        $extraction = new Extraction();
        $form = $this->createForm(ExtractionType::class, $extraction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($extraction);
            $entityManager->flush();
            return $this->redirectToRoute('cash_box');
        }

        //Count Cash in the box
        $cashCount = new CashCount();
        $formCash = $this->createForm(CashCountType::class, $cashCount);
        $formCash->handleRequest($request);

        if ($formCash->isSubmitted() && $formCash->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cashCount);
            $entityManager->flush();
            return $this->redirectToRoute('cash_box');
        }

        //Refunds
        $refund = new Refund();
        $formRefund = $this->createForm(RefundType::class, $refund);
        $formRefund->handleRequest($request);
        if ($formRefund->isSubmitted() && $formRefund->isValid()) {
            $productId = $request->request->get('refund')['product'];
            if ($productId) {
                $product = $productRepository->findOneById($productId);
                $refund->setProduct($product);
                $refund->setProductPrice($product->getPrice());
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($refund);
            $entityManager->flush();
            return $this->redirectToRoute('cash_box');
        }


            $cashPayment = $paymentModeRepository->findOneByIdentifier(self::CASH);
            $products = $productRepository->findBy([], ['category' => 'ASC', 'name' => 'ASC']);
            $totalForDay = $purchaseRepository->getTotalByDay();
            $paymentModes = $paymentModeRepository->findAll();
            return $this->render('cash_box/index.html.twig', [
                'products' => $products,
                'total' => $totalForDay,
                'payment_modes' => $paymentModes,
                'extraction' => $extraction,
                'form' => $form->createView(),
                'cash_count' => $cashCount,
                'formcash' => $formCash->createView(),
                'form_refund' => $formRefund->createView(),
                'cashId' => $cashPayment->getId(),
            ]);


        return $response;
    }
}
