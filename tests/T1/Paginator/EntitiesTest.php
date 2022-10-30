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

namespace App\Tests\T1;

use Mazarini\ToolsBundle\Paginator\Entities;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EntitiesTest extends KernelTestCase
{
    public function testVide(): void
    {
        $entities = new Entities(100, 1, 10);
        $this->assertSame(0, $entities->count());
        $this->assertSame(0, $entities->getStart());
        $this->assertSame(10, $entities->getLimit());

        $entities = new Entities(100, 2, 10);
        $this->assertSame(10, $entities->getStart());

        $entities = new Entities(100, 3, 10);
        $this->assertSame(20, $entities->getStart());
    }

    public function testCount(): void
    {
        $entities = new Entities(100, 1, 10);
        $entities->setEntities([1, 2, 3]);
        $this->assertSame(3, $entities->count());
    }

    public function testGetter(): void
    {
        $entities = new Entities(100, 1, 10);
        $entities->setEntities([1, 2, 3]);
        $array = $entities->getEntities();
        $this->assertSame(1, $array[0]);
        $this->assertSame(3, $array[2]);
    }
}
