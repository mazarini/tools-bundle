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
use Mazarini\ToolsBundle\Data\LinkTree;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyControler;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class AbstractController extends SymfonyControler
{
    /**
     * @var string
     */
    protected $twigFolder = '';

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
    protected $parameters;

    public function __construct(RequestStack $requestStack, UrlGeneratorInterface $router, string $baseRoute = '')
    {
        $request = $requestStack->getMasterRequest();
        if (null === $request) {
            $currentUrl = '';
            $currentAction = '';
        } else {
            $currentUrl = $request->getPathInfo();
            if ('' === $baseRoute) {
                $routeParts = explode('_', $request->attributes->get('_route'));
                unset($routeParts[\count($routeParts) - 1]);
                $baseRoute = implode('_', $routeParts);
            }
            $currentAction = mb_substr($request->attributes->get('_route'), mb_strlen($baseRoute));
        }

        $this->parameters['data'] = $this->data = new Data($router, $baseRoute, $currentAction, $currentUrl);
        $this->parameters['menu'] = $this->menu = new LinkTree('main', 'Menu');
    }

    /**
     * DataRender.
     *
     * @param array<string,mixed> $parameters
     */
    protected function dataRender(string $view, array $parameters = [], Response $response = null): Response
    {
        $parameters = array_merge($this->parameters, $parameters);
        $this->initUrl($this->data);
        $this->initMenu($this->menu);

        return $this->render($this->twigFolder.$view, $parameters, $response);
    }

    abstract protected function initUrl(Data $data): self;

    protected function initMenu(LinkTree $menu): self
    {
        return $this;
    }
}
