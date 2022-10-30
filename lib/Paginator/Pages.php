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
     * Size of pages.
     *
     * @var int
     */
    protected $pageSize;

    /**
     * Selected page can be out of range.
     *
     * @var int
     */
    protected $currentPage;

    /**
     * Count of all items.
     *
     * @var int
     */
    protected $totalCount;

    public function __construct(int $totalCount, int $currentPage, int $pageSize = 10)
    {
        $this->pageSize = $pageSize;
        $this->totalCount = $totalCount;
        $this->currentPage = $currentPage;
    }

    /**
     * Compute current page between 1 and number of pages.
     *
     * Use to redirect to first or last page and to verify if current page exists
     */
    public function getCurrentPage(): int
    {
        return max(1, min($this->currentPage, $this->getPagesCount()));
    }

    /**
     * Verify if current page exists.
     */
    public function isCurrentPageOk(): bool
    {
        return $this->currentPage === $this->getCurrentPage();
    }

    /**
     * Compute count of page, return 0 if no item.
     */
    protected function getPagesCount(): int
    {
        return (int) ceil($this->totalCount / $this->pageSize);
    }
}
