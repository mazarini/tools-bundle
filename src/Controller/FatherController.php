<?php

/*
 * This file is part of mazarini/tools-bundles.
 *
 * mazarini/tools-bundles is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * mazarini/tools-bundles is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
 * for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with mazarini/tools-bundles. If not, see <https://www.gnu.org/licenses/>.
 */

namespace App\Controller;

use App\Entity\Father;
use App\Entity\Grand;
use App\Form\FatherType;
use App\Repository\FatherRepository;
use Mazarini\ToolsBundle\Controller\ControllerAbstract;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/father')]
class FatherController extends ControllerAbstract
{
    #[Route('/{id}/index.html', name: 'app_father_index', methods: ['GET'])]
    public function index(FatherRepository $fatherRepository, Grand $entity): Response
    {
        return $this->render('father/index.html.twig', [
            'grand' => $entity,
        ]);
    }

    #[Route('/{id}/new.html', name: 'app_father_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FatherRepository $fatherRepository, Grand $entity): Response
    {
        $father = new Father();
        $entity->addChild($father);
        $father->setParent($entity);
        $form = $this->createForm(FatherType::class, $father);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fatherRepository->add($father);

            return $this->redirectToRoute('app_father_index', ['id' => $father->getParentId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('father/new.html.twig', [
            'father' => $father,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show.html', name: 'app_father_show', methods: ['GET'])]
    public function show(Father $father): Response
    {
        return $this->render('father/show.html.twig', [
            'father' => $father,
        ]);
    }

    #[Route('/{id}/edit.html', name: 'app_father_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Father $father, FatherRepository $fatherRepository): Response
    {
        $form = $this->createForm(FatherType::class, $father);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fatherRepository->add($father);

            return $this->redirectToRoute('app_father_index', ['id' => $father->getParentId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('father/edit.html.twig', [
            'father' => $father,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete.html', name: 'app_father_delete', methods: ['POST'])]
    public function delete(Request $request, Father $father, FatherRepository $fatherRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$father->getId(), $this->getRequestStringValue('_token'))) {
            $fatherRepository->remove($father);
        }

        return $this->redirectToRoute('app_father_index', [], Response::HTTP_SEE_OTHER);
    }
}
