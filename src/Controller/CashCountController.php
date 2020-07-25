<?php

namespace App\Controller;

use App\Entity\CashCount;
use App\Form\CashCountType;
use App\Repository\CashCountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/cash/count")
 * @IsGranted("ROLE_USER")
 */
class CashCountController extends AbstractController
{
    /**
     * @Route("/", name="cash_count_index", methods={"GET"})
     */
    public function index(CashCountRepository $cashCountRepository): Response
    {
        return $this->render('cash_count/index.html.twig', [
            'cash_counts' => $cashCountRepository->findAll(),
        ]);
    }

    /**
     * @Route("/check", name="cash_count_check", methods={"GET"})
     */
    public function hasBeenCountedToday(CashCountRepository $cashCountRepository): Response
    {
        $response = new JsonResponse();
        if ($cashCountRepository->getTotayCashCount()) {
            $response->setStatusCode(Response::HTTP_OK);
            $response->setData(['count' => $cashCountRepository->getTotayCashCount()]);
        } else {
            $response->setStatusCode(Response::HTTP_NO_CONTENT);
        }
        return $response;
    }

    /**
     * @Route("/new", name="cash_count_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cashCount = new CashCount();
        $form = $this->createForm(CashCountType::class, $cashCount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cashCount);
            $entityManager->flush();

            return $this->redirectToRoute('cash_count_index');
        }

        return $this->render('cash_count/new.html.twig', [
            'cash_count' => $cashCount,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cash_count_show", methods={"GET"})
     */
    public function show(CashCount $cashCount): Response
    {
        return $this->render('cash_count/show.html.twig', [
            'cash_count' => $cashCount,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cash_count_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CashCount $cashCount): Response
    {
        $form = $this->createForm(CashCountType::class, $cashCount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cash_count_index');
        }

        return $this->render('cash_count/edit.html.twig', [
            'cash_count' => $cashCount,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cash_count_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CashCount $cashCount): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cashCount->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cashCount);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cash_count_index');
    }
}
