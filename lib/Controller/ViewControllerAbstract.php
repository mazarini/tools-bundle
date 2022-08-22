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
use Symfony\Component\HttpFoundation\Response;

/**
 * @template E of EntityInterface
 * @template R of EntityRepositoryInterface
 */
abstract class ViewControllerAbstract extends ControllerAbstract
{
    protected string $base = '';
    protected string $templateFormat = '%s/%s.html.twig';
    protected string $routeFormat = 'app_%s_%s';

    /**
     * @param R<E> $repository
     */
    protected function indexEntityAction(int $id, EntityRepositoryInterface $repository): Response
    {
        return $this->render($this->getTemplate('index'), [
            'entities' => $repository->getPage([], 1),
            'parent' => ['id' => 0],
            'parent_id' => 0,
            'routes' => $this->getRoutes(),
            'urls' => $this->getUrls(0, 0),
        ]);
    }

    protected function indexParentAction(EntityInterface $parent): Response
    {
        $entities = null;
        if (method_exists($parent, 'getChilds')) {
            $entities = $parent->getChilds();
        }

        return $this->render($this->getTemplate('index'), [
            'entities' => $entities,
            'parent' => $parent,
            'parent_id' => $parent->getId(),
            'routes' => $this->getRoutes(),
            'urls' => $this->getUrls(0, $parent->getId()),
        ]);
    }

    protected function showAction(EntityInterface $entity): Response
    {
        return $this->render($this->getTemplate('show'), [
            'entity' => $entity,
            'parent_id' => $entity->getParentId(),
            'routes' => $this->getRoutes(),
            'urls' => $this->getUrls($entity->getid(), $entity->getParentId()),
        ]);
    }

    protected function getTemplate(string $function): string
    {
        $method = __METHOD__.ucfirst($function);
        if (method_exists($this, $method)) {
            return $this->$method();
        }

        return sprintf($this->templateFormat, $this->base, $function);
    }

    protected function getRoute(string $function): string
    {
        $method = __METHOD__.ucfirst($function);
        if (method_exists($this, $method)) {
            return $this->$method();
        }

        return sprintf($this->routeFormat, $this->base, $function);
    }

    /**
     * @return array<string,string>
     */
    protected function getRoutes(): array
    {
        $routes = [];
        foreach ($this->getFunctions() as $function => $id) {
            $routes[$function] = $this->getRoute($function);
        }

        return $routes;
    }

    /**
     * @return array<string,string>
     */
    protected function getUrls(int $entityId, int $parentId): array
    {
        $urls = [];
        foreach ($this->getFunctions($entityId, $parentId) as $function => $id) {
            $urls[$function] = $this->generateUrl($this->getRoute($function), ['id' => $id]);
        }

        return $urls;
    }

    /**
     * @return array<string,int>
     */
    protected function getFunctions(int $entityId = 0, int $parentId = 0): array
    {
        return ['index' => $parentId, 'show' => $entityId];
    }
}
