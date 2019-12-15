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

use Mazarini\TestBundle\Controller\StepController as baseController;
use Mazarini\TestBundle\Fake\Entity;
use Mazarini\TestBundle\Fake\Repository;
use Mazarini\TestBundle\Tool\Folder;
use Mazarini\ToolsBundle\Data\Links;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class StepController extends baseController
{
    /**
     * @Route("/{step}.html", name="step_index")
     */
    public function index(Folder $folder, string $step): Response
    {
        $steps = $folder->getSteps();
        if (!isset($steps[$step])) {
            $currentUrl = $this->generateUrl('step_index', ['step' => $step]);
            $try = array_key_first($steps);
            $tryUrl = $this->generateUrl('step_index', ['step' => $try]);
            throw $this->createNotFoundException(sprintf('The page "%s" does not exist. Try <a href="%s">%s</a>', $currentUrl, $tryUrl, $tryUrl));
        }
        $this->data->setEntity(new Entity(1));
        $repository = new Repository();
        $this->data->setPagination($repository->getPage(3, 50, 10));

        $menu = new Links('', $this->generateUrl('step_index', ['step' => $step]), 'Main menu');
        $this->parameters['steps'] = $menu;
        foreach (array_keys($steps) as $name) {
            $menu->addLink($name, $this->generateUrl('step_index', ['step' => $name]), $name);
        }
        $parameters['step'] = $step;

        return $this->dataRender('step/'.$steps[$step], $parameters);
    }
}
