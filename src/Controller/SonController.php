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
use App\Entity\Son;
use App\Form\SonType;
use App\Repository\SonRepository;
use Mazarini\ToolsBundle\Controller\CrudControllerAbstract;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @template-extends CrudControllerAbstract<Son,SonRepository>
 */
#[Route('/son')]
class SonController extends CrudControllerAbstract
{
    protected string $base = 'son';

    #[Route('/{id}/index.html', name: 'app_son_index', methods: ['GET'])]
    public function index(Father $father): Response
    {
        return $this->indexAction($father);
    }

    #[Route('/{id}/new.html', name: 'app_son_new', methods: ['GET', 'POST'])]
    public function new(SonRepository $repository, Father $entity): Response
    {
        return $this->newAction($repository, $entity);
    }

    #[Route('/{id}/show.html', name: 'app_son_show', methods: ['GET'])]
    public function show(Son $son): Response
    {
        return $this->showAction($son);
    }

    #[Route('/{id}/edit.html', name: 'app_son_edit', methods: ['GET', 'POST'])]
    public function edit(Son $son): Response
    {
        return $this->editAction($son);
    }

    #[Route('/{id}/delete.html', name: 'app_son_delete', methods: ['POST'])]
    public function delete(Son $son): Response
    {
        return $this->deleteAction(
            $son,
            $this->generateUrl('app_son_show', ['id' => $son->getId()]),
            $this->generateUrl('app_son_index', ['id' => $son->getParentId()])
        );
    }

    /**
     * @param Son $entity
     */
    protected function getForm($entity): FormInterface
    {
        return $this->createForm(SonType::class, $entity);
    }
}
