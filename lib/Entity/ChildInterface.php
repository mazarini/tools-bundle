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

/**
 * Generic entity child class.
 *
 * @template P of ParentInterface|ParentChildInterface
 * @template C of ChildInterface|ParentChildInterface
 */
interface ChildInterface extends EntityInterface
{
    /**
     * Undocumented function.
     *
     * @return P
     */
    public function getParent(): ParentInterface;

    /**
     * Setter of Parent.
     *
     * @param P|null $parent
     *
     * @return ChildInterface<P,C>
     */
    public function setParent(ParentInterface $parent = null): self;
}
