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

namespace Mazarini\ToolsBundle\Pagination;

 /*
  * manage data :
  *     - entities
  *     - counters :
  *         . total entities avalaible
  *         . total pages avalaible
  *         . total entities of page.
  */

class Entities
{
    /**
     * @var \ArrayIterator
     */
    private $entities;

    /**
     * @var int
     */
    private $totalCount;

    /**
     * @var int
     */
    private $pageSize;

    public function __construct(\ArrayIterator $entities, int $totalCount, int $pageSize)
    {
        $this->entities = $entities;
        $this->totalCount = $totalCount;
        $this->pageSize = $pageSize;
    }

    public function getEntities(): \ArrayIterator
    {
        return $this->entities;
    }

    /**
     * count.
     */
    public function count(): int
    {
        return \count($this->entities);
    }

    /**
     *  pagesCount.
     */
    protected static function PAGES_COUNT(int $pageSize, int $totalCount): int
    {
        return (int) ceil($totalCount / $pageSize);
    }

    protected function pagesCount(): int
    {
        return self::PAGES_COUNT($this->pageSize, $this->totalCount);
    }
}
