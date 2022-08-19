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

use App\Entity\Grand;
use App\Form\GrandType;
use App\Repository\GrandRepository;
use Mazarini\ToolsBundle\Controller\ControllerAbstract;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/grand')]
class GrandController extends ControllerAbstract
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
            $grandRepository->add($grand);

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
            $grandRepository->add($grand);

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
        if ($this->isCsrfTokenValid('delete'.$grand->getId(), $this->getRequestStringValue('_token'))) {
            $grandRepository->remove($grand);
        }

        return $this->redirectToRoute('app_grand_index', [], Response::HTTP_SEE_OTHER);
    }
}
