<?php

namespace App\Controller;

use App\Entity\Father;
use App\Form\FatherType;
use App\Repository\FatherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/father')]
class FatherController extends AbstractController
{
    #[Route('/', name: 'app_father_index', methods: ['GET'])]
    public function index(FatherRepository $fatherRepository): Response
    {
        return $this->render('father/index.html.twig', [
            'fathers' => $fatherRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_father_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FatherRepository $fatherRepository): Response
    {
        $father = new Father();
        $form = $this->createForm(FatherType::class, $father);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fatherRepository->add($father, true);

            return $this->redirectToRoute('app_father_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('father/new.html.twig', [
            'father' => $father,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_father_show', methods: ['GET'])]
    public function show(Father $father): Response
    {
        return $this->render('father/show.html.twig', [
            'father' => $father,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_father_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Father $father, FatherRepository $fatherRepository): Response
    {
        $form = $this->createForm(FatherType::class, $father);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fatherRepository->add($father, true);

            return $this->redirectToRoute('app_father_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('father/edit.html.twig', [
            'father' => $father,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_father_delete', methods: ['POST'])]
    public function delete(Request $request, Father $father, FatherRepository $fatherRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$father->getId(), $request->request->get('_token'))) {
            $fatherRepository->remove($father, true);
        }

        return $this->redirectToRoute('app_father_index', [], Response::HTTP_SEE_OTHER);
    }
}
