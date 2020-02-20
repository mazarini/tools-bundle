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

namespace App\Controller;

use Mazarini\ToolsBundle\Controller\HomeControllerAbstract;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends HomeControllerAbstract
{
    /*
     * getRedirectUrl.
     *
     * Choose the url when route "homepage" is not define
     */
    protected function getRedirectUrl(): string
    {
        /*
        Example 1 : depending connected or not
        if (null === $this->getUser()) {
            return $this->generateUrl('security_login');
        }

        return $this->generateUrl('profile_show');

        Example 2 : Always root
        return '/';
    */

        return parent::getRedirectUrl();
    }
}
