<?php

namespace App\Controller;

use App\Entity\Extraction;
use App\Form\ExtractionType;
use App\Repository\ExtractionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/extraction")
 * @IsGranted("ROLE_ADMIN")
 */
class ExtractionController extends AbstractController
{
    /**
     * @Route("/", name="extraction_index", methods={"GET"})
     */
    public function index(ExtractionRepository $extractionRepository): Response
    {
        return $this->render('extraction/index.html.twig', [
            'extractions' => $extractionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="extraction_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $extraction = new Extraction();
        $form = $this->createForm(ExtractionType::class, $extraction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($extraction);
            $entityManager->flush();

            return $this->redirectToRoute('extraction_index');
        }

        return $this->render('extraction/new.html.twig', [
            'extraction' => $extraction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="extraction_show", methods={"GET"})
     */
    public function show(Extraction $extraction): Response
    {
        return $this->render('extraction/show.html.twig', [
            'extraction' => $extraction,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="extraction_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Extraction $extraction): Response
    {
        $form = $this->createForm(ExtractionType::class, $extraction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('extraction_index');
        }

        return $this->render('extraction/edit.html.twig', [
            'extraction' => $extraction,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="extraction_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Extraction $extraction): Response
    {
        if ($this->isCsrfTokenValid('delete'.$extraction->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($extraction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('extraction_index');
    }
}
