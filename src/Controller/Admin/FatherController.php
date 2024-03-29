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

namespace App\Controller\Admin;

use App\Entity\Father;
use App\Entity\Grand;
use App\Form\FatherType;
use App\Repository\FatherRepository;
use Mazarini\ToolsBundle\Controller\CrudControllerAbstract;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @template-extends CrudControllerAbstract<Father>
 */
#[Route('admin/father')]
class FatherController extends CrudControllerAbstract
{
    protected string $base = 'father';
    protected string $templateFormat = 'admin/%s/%s.html.twig';
    protected string $routeFormat = 'app_admin_%s_%s';

    protected function getFunctions(int $entityId = 0, int $parentId = 0): array
    {
        $function = parent::getFunctions($entityId, $parentId);
        unset($function['page']);

        return $function;
    }

    #[Route('/{id}/index.html', name: 'app_admin_father_index', methods: ['GET'])]
    public function index(Grand $grand): Response
    {
        return $this->indexAction($grand);
    }

    #[Route('/{id}/show.html', name: 'app_admin_father_show', methods: ['GET'])]
    public function show(Father $father): Response
    {
        return $this->showAction($father);
    }

    #[Route('/{id}/new.html', name: 'app_admin_father_new', methods: ['GET', 'POST'])]
    public function new(FatherRepository $fatherRepository, Grand $entity): Response
    {
        return $this->newAction($fatherRepository, $entity);
    }

    #[Route('/{id}/edit.html', name: 'app_admin_father_edit', methods: ['GET', 'POST'])]
    public function edit(Father $father, FatherRepository $fatherRepository): Response
    {
        return $this->editAction($father);
    }

    /**
     * @param Father $entity
     */
    protected function getForm($entity): FormInterface
    {
        return $this->createForm(FatherType::class, $entity);
    }

    #[Route('/{id}/delete.html', name: 'app_admin_father_delete', methods: ['POST'])]
    public function delete(Father $entity): Response
    {
        return $this->deleteAction(
            $entity,
            $this->generateUrl('app_admin_father_show', ['id' => $entity->getId()]),
            $this->generateUrl('app_admin_father_index', ['id' => $entity->getParentId()])
        );
    }
}
