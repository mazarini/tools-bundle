<?php

/*
 * This file is part of mazarini/mazarini.
 *
 * mazarini/mazarini is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * mazarini/mazarini is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
 * for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with mazarini/mazarini. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Mazarini\ToolsBundle\Entity;

use countable;

interface EntityInterface extends countable
{
    /**
     * Getter of id of entity
     *
     * Return 0 if null
     * @return integer
     */
    public function getId(): int;

    /**
     * Tell if entity is new or if exists in database
     *
     * @return boolean
     */
    public function isNew(): bool;

    /**
     * Helper to get the id of the parent. Return 0 if none
     *
     * @return integer
     */
    public function getParentId(): int;

    /**
     * Helper to get number of childs. Return 0 if none
     *
     * @return integer
     */
    public function Count(): int;
}
