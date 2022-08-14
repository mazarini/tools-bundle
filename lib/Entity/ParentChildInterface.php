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

/**
 * Generic entity M with parent P and childs C class.
 *
 * @template P of ParentInterface|ParentChildInterface
 * @template M of ParentChildInterface
 * @template C of ChildEntityInterface|ParentChildInterface
 *
 * @template-extends ParentInterface<P as M,C>
 * @template-extends ChildInterface<P,C as M>
 */
interface ParentChildInterface extends ChildInterface, ParentInterface
{
}