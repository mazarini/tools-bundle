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

use App\Collection\Collection;
use App\Collection\Property;
use App\Entity\Entity;
use App\Pagination\Pagination;
use Mazarini\TestBundle\Controller\StepController as BaseController;
use Mazarini\TestBundle\Tool\Folder;
use Mazarini\ToolsBundle\Data\Data;
use Mazarini\ToolsBundle\Href\Href;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class StepController extends BaseController
{
    public function __construct(RequestStack $requestStack, Href $href, Data $data)
    {
        parent::__construct($requestStack, $href, $data);
        $this->parameters['collection'] = new Collection();
        $this->parameters['property'] = new Property();
    }

    /**
     * @Route("/", name="step_INDEX")
     * @Route("/{step}.html", name="step_index")
     */
    public function index(Folder $folder, $step = '')
    {
        $steps = $folder->getSteps();
        if (!isset($steps[$step])) {
            $step = array_key_first($steps);
        }

        foreach ($steps as $name => $dummy) {
            $parameters['steps'][$name] = $this->generateUrl('step_index', ['step' => $name]);
        }
        $parameters['step'] = $step;
        $parameters['steps'][$step] = '';
        $parameters['entity'] = new Entity(1);
        $parameters['pagination'] = new Pagination(3, 50, 10);

        return $this->dataRender('step/'.$steps[$step], $parameters);
    }
}
