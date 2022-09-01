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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Generic entity child class.
 *
 * @template P of ParentInterface
 * @template C of ChildInterface
 */
class ParentAbstract extends EntityAbstract implements ParentInterface
{
    /**
     * @var Collection<int, C>
     */
    protected Collection $childs;

    public function __construct()
    {
        $this->childs = new ArrayCollection();
    }

    /**
     * Getter of childs.
     *
     * @return Collection<int, C>
     */
    public function getChilds(): Collection
    {
        return $this->childs;
    }

    /**
     * Add a child to childs.
     *
     * @param C $child
     *
     * @return self<P,C>
     */
    public function addChild(ChildInterface $child): ParentInterface
    {
        if (!$this->childs->contains($child)) {
            $this->childs->add($child);
            $child->setParent();
        }

        return $this;
    }

    /**
     * Undocumented function.
     *
     * @param C $child
     *
     * @return self<P,C>
     */
    public function removeChild(ChildInterface $child): ParentInterface
    {
        if ($this->childs->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                unset($this->parent);
            }
        }

        return $this;
    }
}
