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

use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

abstract class RequestControllerAbstract extends AbstractController
{
    /**
     * @var ?string
     */
    private $twigFolder = null;

    /**
     * @var ?string
     */
    private $baseRoute = null;

    /**
     * @var ?string
     */
    private $action = null;

    /**
     * @var Request
     */
    private $request;

    public function __construct(RequestStack $requestStack)
    {
        $request = $requestStack->getMasterRequest();
        if (null !== $request) {
            $this->request = $request;
        } else {
            new LogicException('No Request found in RequestStack, was null');
        }
    }

    protected function getAction(): string
    {
        if (null === $this->action) {
            $this->action = mb_substr($this->request->attributes->get('_route'), mb_strlen($this->getBaseRoute()) + 1);
        }

        return $this->action;
    }

    protected function getBaseRoute(): string
    {
        if (null === $this->baseRoute) {
            $this->baseRoute = explode('_', $this->request->attributes->get('_route'))[0];
        }

        return $this->baseRoute;
    }

    protected function getTwigFolder(): string
    {
        if (null === $this->twigFolder) {
            $this->twigFolder = $this->getBaseRoute().'/';
        }

        return $this->twigFolder;
    }

    protected function getUrl(): string
    {
        return $this->request->getPathInfo();
    }
}
