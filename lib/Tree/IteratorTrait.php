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

namespace Mazarini\ToolsBundle\Tree;

/**
 * Iterator.
 *
 * @implements \Iterator<int,object>
 */
trait IteratorTrait
{
    /**
     * content.
     *
     * @var array<int,self>
     */
    private array $content = [];

    /**
     * current key of content.
     *
     * @var int
     */
    private $key = 1;

    /**
     * current item of content.
     *
     * @return self
     */
    public function current(): mixed
    {
        return $this->content[$this->key];
    }

    /**
     * key of current item.
     *
     * @return int
     */
    public function key(): mixed
    {
        return $this->key;
    }

    public function next(): void
    {
        ++$this->key;
    }

    public function rewind(): void
    {
        $this->key = 1;
    }

    public function valid(): bool
    {
        return !($this->key > \count($this->content));
    }

    public function count(): int
    {
        return \count($this->content);
    }

    public function add(self $item): self
    {
        $this->content[$this->count() + 1] = $item;

        return $this;
    }
}
