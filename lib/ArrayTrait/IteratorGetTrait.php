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

namespace Mazarini\ToolsBundle\ArrayTrait;

trait IteratorGetTrait
{
    use IteratorTrait;

    public function __construct()
    {
        $this->array_data = [];
        foreach (get_object_vars($this) as $key => $value) {
            $get = 'get'.ucfirst($key);
            if (exist_method($this, $get)) {
                $this->array_data[] = [$key, $this->$get()];
            }
        }
    }
}
