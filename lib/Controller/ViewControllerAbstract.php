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
use Mazarini\ToolsBundle\Entity\ParentInterface;
use Mazarini\ToolsBundle\Repository\EntityRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @template E of EntityInterface
 */
abstract class ViewControllerAbstract extends ControllerAbstract
{
    protected string $base = '';
    protected string $templateFormat = '%s/%s.html.twig';
    protected string $routeFormat = 'app_%s_%s';

    protected function getFunctions(int $entityId = 0, int $parentId = 0): array
    {
        return [
            'page' => ['id' => $parentId, 'page' => 1],
            'index' => ['id' => $parentId],
            'show' => ['id' => $entityId],
        ];
    }

    /**
     * @param EntityRepositoryInterface<E> $repository
     */
    protected function pageAction(EntityRepositoryInterface $repository, int $currentPage, int $pageSize, ?ParentInterface $parent): Response
    {
        $pagination = $repository->getPage($parent, $currentPage, $pageSize);
        if ($pagination->isCurrentPageOk()) {
            $parameters = [];
            $parameters['pagination'] = $pagination;
            $parameters['entities'] = $pagination->getEntities();
            if (null !== $parent) {
                $parameters['parent'] = $parent;
            }

            return $this->render($this->getTemplate('page'), $parameters);
        }

        $id = null === $parent ? 0 : $parent->getId();

        return $this->redirectToRoute($this->getRoute('page'), ['id' => $id, 'page' => $pagination->getCurrentPage()], Response::HTTP_SEE_OTHER);
    }

    /**
     * @param ParentInterface|EntityRepositoryInterface<E> $object
     */
    protected function indexAction(object $object): Response
    {
        if ($object instanceof EntityRepositoryInterface) {
            return $this->render($this->getTemplate('index'), [
                'entities' => $object->findAll(),
            ]);
        }

        return $this->render($this->getTemplate('index'), [
                'parent' => $object,
                'entities' => $object->getChilds(),
        ]);
    }

    protected function showAction(EntityInterface $entity): Response
    {
        return $this->render($this->getTemplate('show'), [
            'entity' => $entity,
        ]);
    }
}
