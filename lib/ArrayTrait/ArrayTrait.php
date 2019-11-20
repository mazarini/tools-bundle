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

trait ArrayTrait
{
    /**
     * @var string[]
     */
    protected $_array_var_ = [];

    /**
     * __construct.
     */
    public function __construct()
    {
        if (0 === \count($this->_array_var_)) {
            foreach (get_object_vars($this) as $key => $value) {
                if (method_exists($this, 'get'.ucfirst($key))) {
                    $this->_array_var_[] = $key;
                }
            }
        }
    }

    /**
     * getVarValue.
     *
     * @param int|string $key
     */
    protected function getVarValue($key): mixed
    {
        if (\is_int($key)) {
            $key = $this->_array_var_[$key];
        }
        $getter = 'get'.ucfirst($key);

        return $this->$getter();
    }
}
