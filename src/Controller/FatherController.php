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
use Mazarini\ToolsBundle\Controller\CrudControllerAbstract;
use Mazarini\ToolsBundle\Entity\EntityInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @template-extends CrudControllerAbstract<Father,FatherRepository>
 */
#[Route('/father')]
class FatherController extends CrudControllerAbstract
{
    protected string $base = 'father';

    #[Route('/{id}/index.html', name: 'app_father_index', methods: ['GET'])]
    public function index(Grand $grand): Response
    {
        return $this->indexParentAction($grand);
    }

    #[Route('/{id}/show.html', name: 'app_father_show', methods: ['GET'])]
    public function show(Father $father): Response
    {
        return $this->showAction($father);
    }

    #[Route('/{id}/new.html', name: 'app_father_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FatherRepository $fatherRepository, Grand $entity): Response
    {
        $father = new Father();
        $father->setParent($entity);

        return $this->editAction($father, $fatherRepository);
    }

    #[Route('/{id}/edit.html', name: 'app_father_edit', methods: ['GET', 'POST'])]
    public function edit(Father $father, FatherRepository $fatherRepository): Response
    {
        return $this->editAction($father, $fatherRepository);
    }

    protected function getForm(EntityInterface $entity): FormInterface
    {
        return $this->createForm(FatherType::class, $entity);
    }

    #[Route('/{id}/delete.html', name: 'app_father_delete', methods: ['POST'])]
    public function delete(FatherRepository $repository, Father $entity): Response
    {
        return $this->deleteAction(
            $repository,
            $entity,
            $this->generateUrl('app_father_show', ['id' => $entity->getId()]),
            $this->generateUrl('app_father_index', ['id' => $entity->getParentId()])
        );
    }
}
