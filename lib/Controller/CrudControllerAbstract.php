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
use Mazarini\ToolsBundle\Repository\RepositoryInterface;
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
    /**
     * @return array<string,int>
     */
    protected function getFunctions(int $entityId = 0, int $parentId = 0): array
    {
        $urls = parent::getFunctions($entityId, $parentId);
        $urls['new'] = $parentId;
        $urls['edit'] = $entityId;
        $urls['delete'] = $entityId;

        return $urls;
    }

    // ==============================================================
    // | New and edit actions                                       |
    // ==============================================================

    /**
     * @param E    $entity
     * @param R<E> $repository
     */
    public function editAction(EntityInterface $entity, EntityRepositoryInterface $repository): Response
    {
        $form = $this->getForm($entity);
        $form->handleRequest($this->getRequest());

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->add($entity);

            return $this->redirectToRoute($this->getRoute('show'), ['id' => $entity->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm($this->getTemplate($entity->isNew() ? 'new' : 'edit'), [
            'entity' => $entity,
            'form' => $form,
            'parent_id' => $entity->getParentId(),
            'routes' => $this->getRoutes(),
            'urls' => $this->getUrls($entity->getId(), $entity->getParentId()),
        ]);
    }

    /**
     * @param E $entity
     */
    abstract protected function getForm(EntityInterface $entity): FormInterface;

    // ==============================================================
    // | Delete action                                              |
    // ==============================================================

    protected function deleteAction(RepositoryInterface $repository, EntityInterface $entity, string $errorUrl, string $successUrl): Response
    {
        switch (false) {
            case $this->isDeletePossible($entity):
                $this->addflash('danger', 'You sould delete childs before parent entity');
                break;
            case $this->isCsrfTokenValid('delete'.$entity->getId(), $this->getRequestStringValue('_token')):
                $this->addflash('danger', 'Technical problem, retry delete');
                break;
            default:
                $repository->remove($entity);
                $this->addflash('success', 'Entity is removed');

                return $this->redirect($successUrl, Response::HTTP_SEE_OTHER);
        }

        return $this->redirect($errorUrl, Response::HTTP_SEE_OTHER);
    }

    protected function isDeletePossible(EntityInterface $entity): bool
    {
        switch (false) {
            case $entity->count() > 0:
                $this->addflash('danger', 'You sould delete childs before parent entity');
                break;
            default:
                return true;
        }

        return false;
    }
}
