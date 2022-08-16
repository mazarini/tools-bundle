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

namespace Mazarini\ToolsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class EntityAbstract implements EntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    public function getId(): int
    {
        return null === $this->id ? 0 : $this->id;
    }

    public function isNew(): bool
    {
        return 0 === $this->getId();
    }

    public function getParentId(): int
    {
        if (is_subclass_of($this, ChildInterface::class)) {
            return $this->getParent()->getId();
        }

        return 0;
    }

    public function count(): int
    {
        if (is_subclass_of($this, ParentInterface::class)) {
            return \count($this->getChilds());
        }

        return 0;
    }
}
