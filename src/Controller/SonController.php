<?php

namespace App\Controller;

use App\Entity\Father;
use App\Entity\Son;
use App\Form\SonType;
use App\Repository\SonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/son')]
class SonController extends AbstractController
{
    #[Route('/{id}/index.htmf', name: 'app_son_index', methods: ['GET'])]
    public function index(SonRepository $sonRepository, Father $father): Response
    {
        return $this->render('son/index.html.twig', [
            'father' => $father,
        ]);
    }

    #[Route('/{id}/new.html', name: 'app_son_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SonRepository $sonRepository, Father $father): Response
    {
        $son = new Son();
        $son->setParent($father);
        $form = $this->createForm(SonType::class, $son);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sonRepository->add($son, true);

            return $this->redirectToRoute('app_son_index', ['id' => $son->getParentId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('son/new.html.twig', [
            'son' => $son,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show.html', name: 'app_son_show', methods: ['GET'])]
    public function show(Son $son): Response
    {
        return $this->render('son/show.html.twig', [
            'son' => $son,
        ]);
    }

    #[Route('/{id}/edit.html', name: 'app_son_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Son $son, SonRepository $sonRepository): Response
    {
        $form = $this->createForm(SonType::class, $son);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sonRepository->add($son, true);

            return $this->redirectToRoute('app_son_index', ['id' => $son->getParentId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('son/edit.html.twig', [
            'son' => $son,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete.html', name: 'app_son_delete', methods: ['POST'])]
    public function delete(Request $request, Son $son, SonRepository $sonRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$son->getId(), $request->request->get('_token'))) {
            $sonRepository->remove($son, true);
        }

        return $this->redirectToRoute('app_son_index', [], Response::HTTP_SEE_OTHER);
    }
}
