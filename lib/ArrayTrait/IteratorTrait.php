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

trait IteratorTrait
{
    /**
     * @var int
     */
    private $_array_position_ = 0;

    /**
     * @var string[]
     */
    private $_array_var_ = [];

    /**
     * __construct.
     */
    public function __construct()
    {
        foreach (get_object_vars($this) as $key => $value) {
            if (method_exists($this, 'get'.ucfirst($key))) {
                $this->_array_var_[] = $key;
            }
        }
    }

    public function rewind()
    {
        $this->_array_position_ = 0;
    }

    public function current()
    {
        $getter = 'get'.ucfirst($this->key());

        return $this->$getter();
    }

    public function key()
    {
        return $this->_array_var_[$this->_array_position_];
    }

    public function next()
    {
        ++$this->_array_position_;
    }

    public function valid()
    {
        return isset($this->_array_var_[$this->_array_position_]);
    }
}
