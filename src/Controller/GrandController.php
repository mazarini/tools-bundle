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
    #[Route('/{id}/index.html', name: 'app_grand_index', methods: ['GET'])]
    public function index(GrandRepository $grandRepository, int $id = 0): Response
    {
        return $this->render('grand/index.html.twig', [
            'entities' => $grandRepository->findAll(),
        ]);
    }

    #[Route('/{id}/new.html', name: 'app_grand_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GrandRepository $grandRepository, int $id = 0): Response
    {
        $grand = new Grand();
        $form = $this->createForm(GrandType::class, $grand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $grandRepository->add($grand, true);

            return $this->redirectToRoute('app_grand_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('grand/new.html.twig', [
            'entity' => $grand,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show.html', name: 'app_grand_show', methods: ['GET'])]
    public function show(Grand $grand): Response
    {
        return $this->render('grand/show.html.twig', [
            'entity' => $grand,
        ]);
    }

    #[Route('/{id}/edit.html', name: 'app_grand_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Grand $grand, GrandRepository $grandRepository): Response
    {
        $form = $this->createForm(GrandType::class, $grand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $grandRepository->add($grand, true);

            return $this->redirectToRoute('app_grand_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('grand/edit.html.twig', [
            'entity' => $grand,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete.html', name: 'app_grand_delete', methods: ['POST'])]
    public function delete(Request $request, Grand $grand, GrandRepository $grandRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$grand->getId(), $request->request->get('_token'))) {
            $grandRepository->remove($grand, true);
        }

        return $this->redirectToRoute('app_grand_index', [], Response::HTTP_SEE_OTHER);
    }
}
