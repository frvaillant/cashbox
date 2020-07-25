<?php

namespace App\Controller;

use App\Entity\Refund;
use App\Form\RefundType;
use App\Repository\RefundRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/refund")
 */
class RefundController extends AbstractController
{
    /**
     * @Route("/", name="refund_index", methods={"GET"})
     */
    public function index(RefundRepository $refundRepository): Response
    {
        return $this->render('refund/index.html.twig', [
            'refunds' => $refundRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="refund_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $refund = new Refund();
        $form = $this->createForm(RefundType::class, $refund);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($refund);
            $entityManager->flush();
            return $this->redirectToRoute('refund_index');
        }

        return $this->render('refund/new.html.twig', [
            'refund' => $refund,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="refund_show", methods={"GET"})
     */
    public function show(Refund $refund): Response
    {
        return $this->render('refund/show.html.twig', [
            'refund' => $refund,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="refund_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Refund $refund): Response
    {
        $form = $this->createForm(RefundType::class, $refund);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('refund_index');
        }

        return $this->render('refund/edit.html.twig', [
            'refund' => $refund,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="refund_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Refund $refund): Response
    {
        if ($this->isCsrfTokenValid('delete'.$refund->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($refund);
            $entityManager->flush();
        }

        return $this->redirectToRoute('refund_index');
    }
}
