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

namespace Mazarini\ToolsBundle\Page;

interface PaginationInterface
{
    /**
     * getEntities.
     *
     * @return array<int,mixed>
     */
    public function getEntities(): array;

    public function hasToPaginate(): bool;

    public function hasPreviousPage(): bool;

    public function getFirstPage(): int;

    public function getPreviousPage(): int;

    public function getCurrentPage(): int;

    public function isCurrentPageOk(): bool;

    public function hasNextPage(): bool;

    public function getNextPage(): int;

    public function getLastPage(): int;

    public function count(): int;
}
