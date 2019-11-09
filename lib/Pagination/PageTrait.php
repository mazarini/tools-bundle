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

trait PageTrait
{
    /**
     * @var int
     */
    protected $currentPage = 0;
    /**
     * @var int
     */
    protected $lastPage = 0;
    /**
     * @var int
     */
    protected $pageSize = -1;

    abstract public function count(): int;

    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    public function hasToPaginate(): bool
    {
        return $this->lastPage > 1;
    }

    public function hasPreviousPage(): bool
    {
        return $this->currentPage > 1;
    }

    public function getFirstPage(): int
    {
        return 1;
    }

    public function getPreviousPage(): int
    {
        return $this->currentPage - 1;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getNextPage(): int
    {
        return $this->currentPage + 1;
    }

    public function hasNextPage(): bool
    {
        return $this->currentPage < $this->getLastPage();
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    protected function initPage(): PaginationInterface
    {
        $this->setLastPage();
        $this->currentPage = min(max(1, $this->currentPage), $this->lastPage);

        return $this;
    }

    protected function setLastPage(): PaginationInterface
    {
        $this->lastPage = (int) ceil($this->count() / $this->getPageSize());

        return $this;
    }
}
