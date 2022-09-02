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

use Mazarini\ToolsBundle\Entity\ChildInterface;
use Mazarini\ToolsBundle\Entity\EntityInterface;

trait ResponseTrait
{
    protected string $base = '';
    protected string $templateFormat = '%s/%s.html.twig';
    protected string $routeFormat = 'app_%s_%s';

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
        foreach ($this->getFunctions($entityId, $parentId) as $function => $parameters) {
            $urls[$function] = $this->generateUrl($this->getRoute($function), $parameters);
        }

        return $urls;
    }

    /**
     * @return array<string,array<string,int>>
     */
    protected function getFunctions(int $entityId = 0, int $parentId = 0): array
    {
        return [
            'page' => ['id' => $parentId, 'page' => 1],
            'index' => ['id' => $parentId],
            'show' => ['id' => $entityId],
            'new' => ['id' => $parentId],
            'edit' => ['id' => $entityId],
            'delete' => ['id' => $entityId],
        ];
    }

    /**
     * @param string $message
     */
    protected function addFlash(string $type, mixed $message): void
    {
        parent::addFlash('message', ['type' => $type, 'message' => $message]);
    }

    /**
     * @param array<string,mixed>$parameters
     */
    protected function renderView(string $view, array $parameters = []): string
    {
        $parentId = 0;
        if (isset($parameters['entities'])) {
            if (isset($parameters['parent'])) {
                if ($parameters['parent'] instanceof EntityInterface) {
                    $parentId = $parameters['parent']->getId();
                }
            }
        }
        $id = 0;
        if (isset($parameters['entity'])) {
            if ($parameters['entity'] instanceof EntityInterface) {
                $id = $parameters['entity']->getId();
            }
            if ($parameters['entity'] instanceof ChildInterface) {
                $parentId = $parameters['entity']->getParent()->getId();
            }
        }
        $parameters['id'] = $id;
        $parameters['parent_id'] = $parentId;
        $parameters['routes'] = $this->getRoutes();

        $urls = $this->getUrls($id, $parentId);
        switch (true) {
            case isset($urls['page']):
                $urls['list'] = $urls['page'];
                $parameter['current_url'] = $urls['list'];
                break;
            case isset($urls['index']):
                $urls['list'] = $urls['index'];
                $parameter['current_url'] = $urls['list'];
                break;
            default:
                $parameter['current_url'] = null;
        }
        $parameters['urls'] = $urls;

        return parent::renderView($view, $parameters);
    }
}
