<?php

namespace App\Controller;

use App\Entity\Grand;
use App\Form\GrandType;
use App\Repository\GrandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/grand')]
class GrandController extends AbstractController
{
    #[Route('/', name: 'app_grand_index', methods: ['GET'])]
    public function index(GrandRepository $grandRepository): Response
    {
        return $this->render('grand/index.html.twig', [
            'grands' => $grandRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_grand_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GrandRepository $grandRepository): Response
    {
        $grand = new Grand();
        $form = $this->createForm(GrandType::class, $grand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $grandRepository->add($grand, true);

            return $this->redirectToRoute('app_grand_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('grand/new.html.twig', [
            'grand' => $grand,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_grand_show', methods: ['GET'])]
    public function show(Grand $grand): Response
    {
        return $this->render('grand/show.html.twig', [
            'grand' => $grand,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_grand_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Grand $grand, GrandRepository $grandRepository): Response
    {
        $form = $this->createForm(GrandType::class, $grand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $grandRepository->add($grand, true);

            return $this->redirectToRoute('app_grand_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('grand/edit.html.twig', [
            'grand' => $grand,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_grand_delete', methods: ['POST'])]
    public function delete(Request $request, Grand $grand, GrandRepository $grandRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$grand->getId(), $request->request->get('_token'))) {
            $grandRepository->remove($grand, true);
        }

        return $this->redirectToRoute('app_grand_index', [], Response::HTTP_SEE_OTHER);
    }
}
