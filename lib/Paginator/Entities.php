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

class Entities extends Pages
{
    /**
     * @var array<int,mixed>
     */
    private $entities = [];

    /**
     * getEntities.
     *
     * @return array<int,mixed>
     */
    public function getEntities(): array
    {
        return $this->entities;
    }

    /**
     * setEntities.
     *
     * @param array<int,mixed> $entities
     */
    public function setEntities(array $entities): self
    {
        $this->entities = $entities;

        return $this;
    }

    /**
     * Get start parameter of query.
     */
    public function getStart(): int
    {
        return ($this->getCurrentPage() - 1) * $this->pageSize;
    }

    /**
     * Get limit parameter of query.
     */
    public function getLimit(): int
    {
        return $this->pageSize;
    }

    /**
     * Count of items of available items.
     */
    public function count(): int
    {
        return \count($this->entities);
    }
}
