<?php

/*
 * Copyright (C) 2019-2020 Mazarini <mazarini@protonmail.com>.
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
use Mazarini\ToolsBundle\Data\LinkTree;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class AbstractController extends UrlControllerAbstract
{
    /**
     * @var Data
     */
    protected $data;

    /**
     * @var LinkTree
     */
    protected $menu;

    /**
     * @var array<string,mixed>
     */
    protected $parameters = [];

    public function __construct(RequestStack $requestStack, UrlGeneratorInterface $router)
    {
        parent::__construct($requestStack);
        $this->parameters['data'] = $this->data = new Data($router, $this->getBaseRoute(), $this->getAction(), $this->getUrl());
        $this->parameters['menu'] = $this->menu = new LinkTree('main', 'Menu');
        $this->beforeAction($this->getAction());
    }

    /**
     * DataRender.
     *
     * @param array<string,mixed> $parameters
     */
    protected function dataRender(string $view, array $parameters = [], Response $response = null): Response
    {
        $this->afterAction($this->getAction());
        $this->parameters = array_merge($this->parameters, $parameters);
        $this->setUrl($this->data);
        $this->setMenu($this->menu);
        $this->beforeRender($this->getAction());

        return $this->render($this->getTwigFolder().$view, $this->parameters, $response);
    }

    protected function beforeAction(string $action): void
    {
    }

    protected function afterAction(string $action): void
    {
    }

    protected function beforeRender(string $action): void
    {
    }

    protected function setMenu(LinkTree $menu): void
    {
    }
}
