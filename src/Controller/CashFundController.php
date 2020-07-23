<?php

namespace App\Controller;

use App\Entity\CashFund;
use App\Form\CashFundType;
use App\Repository\CashFundRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cash/fund")
 */
class CashFundController extends AbstractController
{
    /**
     * @Route("/", name="cash_fund_index", methods={"GET"})
     */
    public function index(CashFundRepository $cashFundRepository): Response
    {
        return $this->render('cash_fund/index.html.twig', [
            'cash_funds' => $cashFundRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="cash_fund_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cashFund = new CashFund();
        $form = $this->createForm(CashFundType::class, $cashFund);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cashFund);
            $entityManager->flush();

            return $this->redirectToRoute('admin_panel');
        }

        return $this->render('cash_fund/new.html.twig', [
            'cash_fund' => $cashFund,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cash_fund_show", methods={"GET"})
     */
    public function show(CashFund $cashFund): Response
    {
        return $this->render('cash_fund/show.html.twig', [
            'cash_fund' => $cashFund,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cash_fund_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CashFund $cashFund): Response
    {
        $form = $this->createForm(CashFundType::class, $cashFund);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cash_fund_index');
        }

        return $this->render('cash_fund/edit.html.twig', [
            'cash_fund' => $cashFund,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cash_fund_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CashFund $cashFund): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cashFund->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cashFund);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cash_fund_index');
    }
}
