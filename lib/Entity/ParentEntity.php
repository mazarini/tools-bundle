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

use Doctrine\Common\Collections\Collection;

/**
 * Generic entity child class.
 *
 * @template P of ParentInterface
 * @template PC of ParentChildInterface
 * @template C of ChildInterface
 *
 * @template-implements ParentInterface<P,PC,C>
 */
class ParentEntity extends Entity implements ParentInterface
{
    /**
     * @var Collection<int, C|PC>
     */
    protected Collection $childs;

    /**
     * Getter of childs.
     *
     * @return Collection<int, C|PC>
     */
    public function getChilds(): Collection
    {
        return $this->childs;
    }

    /**
     * Add a child to childs.
     *
     * @param C|PC $child
     */
    public function addChild(object $child): void
    {
        if (!$this->childs->contains($child)) {
            $this->childs->add($child);
            $child->setParent();
        }
    }

    /**
     * Remove a child from childs.
     *
     * @param C|PC $child
     */
    public function removeChild(object $child): void
    {
        if ($this->childs->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                unset($this->parent);
            }
        }
    }
}
