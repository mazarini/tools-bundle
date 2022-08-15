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

use LogicException;

/**
 * Generic entity M with parent P and childs C class.
 *
 * @template P of ParentInterface
 * @template PC of ParentChildInterface
 * @template C of ChildInterface
 *
 * @template-extends ParentEntity<P,PC,C>
 * @template-implements ParentChildInterface<P,PC,C>
 */
class ParentChild extends ParentEntity implements ParentChildInterface
{
    /**
     * @var P|PC|null
     */
    protected ?object $parent;

    /**
     * @return P|PC
     */
    public function getParent(): object
    {
        if (null === $this->parent) {
            throw new LogicException('You can\'t get parent before set it');
        }

        return $this->parent;
    }

    /**
     * Setter of Parent.
     *
     * @param P|PC|null $parent
     *
     * @return ParentChildInterface<P,PC,C>
     */
    public function setParent(object $parent = null): ChildInterface
    {
        $this->parent = $parent;

        return $this;
    }
}
