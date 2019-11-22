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

namespace App\Collection;

use Mazarini\ToolsBundle\Collection\Collection as BaseCollection;

class Collection extends BaseCollection
{
    public function __construct()
    {
        $array = [];
        for ($i = 1; $i < 9; ++$i) {
            $array['key-'.$i] = 'value-'.$i;
        }
        parent::__construct($array);
    }
}
