<?php

/*
 * Copyright (C) 2019 Mazarini <mazarini@protonmail.com>.
 * This file is part of mazarini/tools-bundle.
 *
 * mazarini/tools-bundle is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.
 *
 * mazarini/tools-bundle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License
 */

namespace Mazarini\ToolsBundle\Controller;

use Mazarini\ToolsBundle\Data\Data;
use Mazarini\ToolsBundle\Entity\EntityInterface;
use Mazarini\ToolsBundle\Href\Hrefs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

abstract class ControllerAbstract extends AbstractController
{
    /**
     * @var Data
     */
    protected $data;

    /**
     * @var array
     */
    protected $parameters = [];

    /**
     * @var string
     */
    protected $baseRoute;

    public function __construct(RequestStack $requestStack, Hrefs $hrefs, Data $data)
    {
        $this->parameters['data'] = $data;
        $data->setHrefs($hrefs);
        $request = $requestStack->getMasterRequest();
        if (null !== $request) {
            $part = explode('_', $request->attributes->get('_route'));
            $part[array_key_last($part)] = '';
            $this->baseRoute = implode('_', $part);
        }
        $this->data = $data;
    }

    abstract protected function InitUrl(Data $data): self;

    protected function InitEntityUrl(EntityInterface $entity): self
    {
        return $this;
    }

    protected function InitPaginationUrl(Data $data): self
    {
        $hrefs = $data->getHrefs();
        $pagination = $data->getPagination();
        if ($pagination->hasPreviousPage()) {
            $this->addUrl($hrefs, 'index', ['page' => 1], 'first');
            $this->addUrl($hrefs, 'index', ['page' => $pagination->getCurrentPage() - 1], 'previous');
        }
        if ($pagination->hasNextPage()) {
            $last = $pagination->getLastPage();
            $this->addUrl($hrefs, 'index', ['page' => $last - 1], 'next');
            $this->addUrl($hrefs, 'index', ['page' => $last], 'last');
        }
        if (($last = $pagination->getLastPage()) <= 20) {
            for ($i = 1; $i <= $last; ++$i) {
                $this->addUrl($hrefs, 'index', ['page' => $i], 'page_'.$i);
            }
        }

        return $this;
    }

    protected function DataRender(string $view, array $parameters = [], Response $response = null): Response
    {
        $parameters = array_merge($this->parameters, $parameters);
        if (isset($parameters['pagination'])) {
            $this->data->setPagination($parameters['pagination']);
            $this->initPaginationUrl($this->data);
            unset($parameters['pagination']);
        }
        if (isset($parameters['entity'])) {
            $this->initEntityUrl($parameters['entity']);
            $this->data->setEntity($parameters['entity']);
            unset($parameters['entity']);
        }
        $this->initUrl($this->data);

        return $this->render($view, $parameters);
    }

    protected function addUrl(Hrefs $hrefs, string $name, array $parameters = [], string $complement = null): self
    {
        if (null === $complement) {
            $complement = $name;
        }
        $hrefs->addLink($complement, $this->generateUrl($this->baseRoute.$name, $parameters));

        return $this;
    }
}
