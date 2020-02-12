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

abstract class UrlControllerAbstract extends RequestControllerAbstract
{
    use CrudUrlTrait;
    use ListUrlTrait;
    use PageUrlTrait;

    protected function setUrl(Data $data): void
    {
        $this->setCrudUrl($data);
        $this->setListUrl($data);
        $this->setPageUrl($data);
        $this->setNewUrl($data);
    }
}
