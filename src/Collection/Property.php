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

use Mazarini\ToolsBundle\Collection\Property as BaseProperty;

class Property extends BaseProperty
{
    protected $var1 = 'value1';
    protected $var2 = 'value2';
    protected $var3 = 'value3';

    /**
     * Get the value of var1.
     */
    public function getVar1()
    {
        return $this->var1;
    }

    /**
     * Set the value of var1.
     *
     * @return self
     */
    public function setVar1($var1)
    {
        $this->var1 = $var1;

        return $this;
    }

    /**
     * Get the value of var2.
     */
    public function getVar2()
    {
        return $this->var2;
    }

    /**
     * Set the value of var2.
     *
     * @return self
     */
    public function setVar2($var2)
    {
        $this->var2 = $var2;

        return $this;
    }

    /**
     * Get the value of var3.
     */
    public function getVar3()
    {
        return $this->var3;
    }

    /**
     * Set the value of var3.
     *
     * @return self
     */
    public function setVar3($var3)
    {
        $this->var3 = $var3;

        return $this;
    }
}
