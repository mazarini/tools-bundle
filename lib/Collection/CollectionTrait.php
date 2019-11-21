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

trait CollectionTrait
{
    /**
     * array.
     */
    protected $__values__ = [];
    /**
     * int.
     */
    private $position = 0;
    /**
     * mixed.
     */
    private $key = null;

    public function __construct(array $values = [])
    {
        $this->__values__ = $values;
    }

    public function count(): int
    {
        return \count($this->__values__);
    }

    public function offsetSet($offset, $value): void
    {
        $this->__values__[$offset] = $value;
    }

    public function offsetExists($offset): bool
    {
        return isset($this->__values__[$offset]);
    }

    public function offsetUnset($offset): void
    {
        unset($this->__values__[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->__values__[$offset];
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function valid(): bool
    {
        if ($this->position < $this->count()) {
            $this->key = array_keys($this->__values__)[$this->position];

            return true;
        }

        return false;
    }

    public function key()
    {
        return $this->key;
    }

    public function current()
    {
        return $this->offsetGet($this->key);
    }
}
