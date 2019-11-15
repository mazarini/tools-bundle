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

namespace App\Controller;

use Mazarini\TestBundle\Fake\Entity;
use Mazarini\TestBundle\Fake\Pagination;
use Mazarini\ToolsBundle\Controller\ControllerAbstract;
use Mazarini\ToolsBundle\Data\Data;
use Mazarini\ToolsBundle\Href\Href;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends ControllerAbstract
{
    public function __construct(RequestStack $requestStack, Href $href, Data $data)
    {
        parent::__construct($requestStack, $href, $data);
        $this->parameters['symfony']['version'] = Kernel::VERSION;
    }

    /**
     * @Route("/", name="default_INDEX")
     * @Route("/page-{page}.html", name="default_index")
     */
    public function index($page = 1)
    {
        $parameters['controller_name'] = 'DefaultController';
        $parameters['entity'] = new Entity(1);
        $parameters['pagination'] = new Pagination(2, 31, 10);

        return $this->dataRender('default/index.html.twig', $parameters);
    }

    protected function InitUrl(): ControllerAbstract
    {
        return $this;
    }
}
