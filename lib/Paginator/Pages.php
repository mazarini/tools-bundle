<?php

/*
 * This file is part of mazarini/tools-bundles.
 *
 * mazarini/tools-bundles is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * mazarini/tools-bundles is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
 * for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with mazarini/tools-bundles. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Mazarini\ToolsBundle\Paginator;

class Pages
{
    /**
     * @var int
     */
    private $pageSize;

    /**
     * @var int
     */
    protected $currentPage;

    /**
     * @var int
     */
    protected $totalCount;

    public function setPageSize(int $pageSize): self
    {
        $this->pageSize = $pageSize;

        return $this;
    }

    public function getCurrentPage(): int
    {
        return max(1, min($this->currentPage, $this->getPagesCount()));
    }

    public function setCurrentPage(int $currentPage): self
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    public function isCurrentPageOk(): bool
    {
        return $this->currentPage === $this->getCurrentPage();
    }

    public function getFirstPage(): int
    {
        return 1;
    }

    public function getLastPage(): int
    {
        return max(1, $this->getPagesCount());
    }

    protected function getPagesCount(): int
    {
        return (int) ceil($this->totalCount / $this->pageSize);
    }
}
