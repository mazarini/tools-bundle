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
 * Generic entity PC with parent P and childs C class.
 *
 * @template P of ParentInterface|ParentChildInterface
 * @template PC of ParentChildInterface
 * @template C of ChildInterface|ParentChildInterface
 *
 * PC (self) as child of P
 * @template-extends ChildInterface<P,PC>
 *
 *  PC (self) as parent of C
 * @template-extends ParentInterface<PC,C>
 */
interface ParentChildInterface extends ParentInterface, ChildInterface
{
}
