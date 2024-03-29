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

use App\Entity\Grand;
use App\Form\GrandType;
use App\Repository\GrandRepository;
use Mazarini\ToolsBundle\Controller\CrudControllerAbstract;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @template-extends CrudControllerAbstract<Grand>
 */
#[Route('admin/grand')]
class GrandController extends CrudControllerAbstract
{
    protected string $base = 'grand';
    protected string $templateFormat = 'admin/%s/%s.html.twig';
    protected string $routeFormat = 'app_admin_%s_%s';

    protected function getFunctions(int $entityId = 0, int $parentId = 0): array
    {
        $function = parent::getFunctions($entityId, $parentId);
        unset($function['page']);

        return $function;
    }

    #[Route('/{id}/index.html', name: 'app_admin_grand_index', methods: ['GET'])]
    public function index(GrandRepository $grandRepository, int $id = 0): Response
    {
        return $this->indexAction($grandRepository);
    }

    #[Route('/{id}/new.html', name: 'app_admin_grand_new', methods: ['GET', 'POST'])]
    public function new(GrandRepository $grandRepository, int $id): Response
    {
        return $this->newAction($grandRepository);
    }

    #[Route('/{id}/show.html', name: 'app_admin_grand_show', methods: ['GET'])]
    public function show(Grand $grand): Response
    {
        return $this->showAction($grand);
    }

    #[Route('/{id}/edit.html', name: 'app_admin_grand_edit', methods: ['GET', 'POST'])]
    public function edit(Grand $grand, GrandRepository $grandRepository): Response
    {
        return $this->editAction($grand);
    }

    #[Route('/{id}/delete.html', name: 'app_admin_grand_delete', methods: ['POST'])]
    public function delete(Grand $grand): Response
    {
        return $this->deleteAction(
            $grand,
            $this->generateUrl('app_admin_grand_show', ['id' => $grand->getId()]),
            $this->generateUrl('app_admin_grand_index', ['id' => $grand->getParentId()])
        );
    }

    /**
     * @param Grand $entity
     */
    protected function getForm($entity): FormInterface
    {
        return $this->createForm(GrandType::class, $entity);
    }
}
