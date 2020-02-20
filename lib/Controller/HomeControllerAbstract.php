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

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class HomeControllerAbstract extends AbstractController
{
    protected function getRedirectUrl(): string
    {
        return '/';
    }

    protected function getTwigFolder(): string
    {
        return '';
    }

    public function home(Request $request): Response
    {
        $currentUrl = $request->getPathInfo();
        $url = $this->getRedirectUrl();
        if ($url === $currentUrl) {
            return $this->dataRender('layout.html.twig');
        }

        return  $this->redirect($url, Response::HTTP_MOVED_PERMANENTLY);
    }
}
