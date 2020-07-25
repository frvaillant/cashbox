<?php

namespace App\Controller;

use App\Entity\PaymentMode;
use App\Form\PaymentModeType;
use App\Repository\PaymentModeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/payment/mode")
 */
class PaymentModeController extends AbstractController
{
    /**
     * @Route("/", name="payment_mode_index", methods={"GET"})
     */
    public function index(PaymentModeRepository $paymentModeRepository): Response
    {
        return $this->render('payment_mode/index.html.twig', [
            'payment_modes' => $paymentModeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="payment_mode_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $paymentMode = new PaymentMode();
        $form = $this->createForm(PaymentModeType::class, $paymentMode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($paymentMode);
            $entityManager->flush();

            return $this->redirectToRoute('payment_mode_index');
        }

        return $this->render('payment_mode/new.html.twig', [
            'payment_mode' => $paymentMode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="payment_mode_show", methods={"GET"})
     */
    public function show(PaymentMode $paymentMode): Response
    {
        return $this->render('payment_mode/show.html.twig', [
            'payment_mode' => $paymentMode,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="payment_mode_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PaymentMode $paymentMode): Response
    {
        $form = $this->createForm(PaymentModeType::class, $paymentMode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('payment_mode_index');
        }

        return $this->render('payment_mode/edit.html.twig', [
            'payment_mode' => $paymentMode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="payment_mode_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PaymentMode $paymentMode): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paymentMode->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($paymentMode);
            $entityManager->flush();
        }

        return $this->redirectToRoute('payment_mode_index');
    }
}
