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

namespace Mazarini\ToolsBundle\Collection;

trait PropertyTrait
{
    use  CollectionTrait;

    public function __construct()
    {
        $array = [];
        foreach (get_class_methods(\get_class($this)) as $method) {
            if (mb_strlen($method) > 3 && 'get' === mb_substr($method, 0, 3)) {
                $array[lcfirst(mb_substr($method, 3))] = mb_substr($method, 3);
            }
        }
        $this->__values__ = $array;
    }

    public function offsetSet($offset, $value): void
    {
        $setter = 'set'.$this->__values__[$offset];
        $this->$setter($value);
    }

    public function offsetGet($offset)
    {
        $getter = 'get'.$this->__values__[$offset];

        return $this->$getter();
    }
}
