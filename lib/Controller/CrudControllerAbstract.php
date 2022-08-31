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

namespace Mazarini\ToolsBundle\Controller;

use Mazarini\ToolsBundle\Entity\EntityInterface;
use Mazarini\ToolsBundle\Repository\EntityRepositoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @template E of EntityInterface
 * @template R of EntityRepositoryInterface
 *
 * @template-extends ViewControllerAbstract<E,R>
 */
abstract class CrudControllerAbstract extends ViewControllerAbstract
{
    // ==============================================================
    // | New and edit actions                                       |
    // ==============================================================

    protected function getFunctions(int $entityId = 0, int $parentId = 0, int $page = 1): array
    {
        return [
            'page' => ['id' => $parentId, 'page' => $page],
            'index' => ['id' => $parentId],
            'show' => ['id' => $entityId],
            'new' => ['id' => $parentId],
            'edit' => ['id' => $entityId],
            'delete' => ['id' => $entityId],
        ];
    }

    /**
     * @param R<E> $repository
     */
    public function newAction(EntityRepositoryInterface $repository, EntityInterface $entity = null): Response
    {
        return $this->editAction($repository->getNew($entity));
    }

    /**
     * @param E $entity
     */
    public function editAction(EntityInterface $entity): Response
    {
        $form = $this->getForm($entity);
        $form->handleRequest($this->getRequest());

        if ($form->isSubmitted() && $form->isValid()) {
            $this->persist($entity)->flush();

            return $this->redirectToRoute($this->getRoute('show'), ['id' => $entity->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm($this->getTemplate($entity->isNew() ? 'new' : 'edit'), [
            'entity' => $entity,
            'form' => $form,
        ]);
    }

    /**
     * @param E $entity
     */
    abstract protected function getForm($entity): FormInterface;

    // ==============================================================
    // | Delete action                                              |
    // ==============================================================

    protected function deleteAction(EntityInterface $entity, string $errorUrl, string $successUrl): Response
    {
        switch (false) {
            case $this->isDeletePossible($entity):
                $this->addflash('danger', 'You sould delete childs before parent entity');
                break;
            case $this->isCsrfTokenValid('delete'.$entity->getId(), $this->getRequestStringValue('_token')):
                $this->addflash('danger', 'Technical problem, retry delete');
                break;
            default:
                $this->remove($entity)->flush();
                $this->addflash('success', 'Entity is removed');

                return $this->redirect($successUrl, Response::HTTP_SEE_OTHER);
        }

        return $this->redirect($errorUrl, Response::HTTP_SEE_OTHER);
    }

    protected function isDeletePossible(EntityInterface $entity): bool
    {
        switch (false) {
            case $entity->count() > 0:
                $this->addflash('danger', 'You should delete childs before parent entity');
                break;
            default:
                return true;
        }

        return false;
    }
}
