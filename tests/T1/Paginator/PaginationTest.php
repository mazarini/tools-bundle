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

use Mazarini\ToolsBundle\Paginator\Pagination;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PaginationTest extends KernelTestCase
{
    public function testVide(): void
    {
        $pagination = new Pagination(0, 1, 10);
        $this->assertFalse($pagination->hasToPaginate());
        $this->assertFalse($pagination->hasPreviousPage());
        $this->assertFalse($pagination->hasNextPage());
        $this->assertSame(1, $pagination->getFirstPage());
        $this->assertSame(1, $pagination->getLastPage());
        $this->assertSame(1, $pagination->getPreviousPage());
        $this->assertSame(1, $pagination->getNextPage());
    }

    public function testOnePage(): void
    {
        $pagination = new Pagination(9, 1, 10);
        $this->assertFalse($pagination->hasToPaginate());
        $this->assertFalse($pagination->hasPreviousPage());
        $this->assertFalse($pagination->hasNextPage());
        $this->assertSame(1, $pagination->getFirstPage());
        $this->assertSame(1, $pagination->getLastPage());
        $this->assertSame(1, $pagination->getPreviousPage());
        $this->assertSame(1, $pagination->getNextPage());
    }

    public function testStart(): void
    {
        $pagination = new Pagination(99, 1, 10);
        $this->assertTrue($pagination->hasToPaginate());
        $this->assertFalse($pagination->hasPreviousPage());
        $this->assertTrue($pagination->hasNextPage());
        $this->assertSame(1, $pagination->getFirstPage());
        $this->assertSame(10, $pagination->getLastPage());
        $this->assertSame(1, $pagination->getPreviousPage());
        $this->assertSame(2, $pagination->getNextPage());
    }

    public function testMidle(): void
    {
        $pagination = new Pagination(99, 5, 10);
        $this->assertTrue($pagination->hasToPaginate());
        $this->assertTrue($pagination->hasPreviousPage());
        $this->assertTrue($pagination->hasNextPage());
        $this->assertSame(1, $pagination->getFirstPage());
        $this->assertSame(10, $pagination->getLastPage());
        $this->assertSame(4, $pagination->getPreviousPage());
        $this->assertSame(6, $pagination->getNextPage());
    }

    public function testEnd(): void
    {
        $pagination = new Pagination(99, 10, 10);
        $this->assertTrue($pagination->hasToPaginate());
        $this->assertTrue($pagination->hasPreviousPage());
        $this->assertFalse($pagination->hasNextPage());
        $this->assertSame(1, $pagination->getFirstPage());
        $this->assertSame(10, $pagination->getLastPage());
        $this->assertSame(9, $pagination->getPreviousPage());
        $this->assertSame(10, $pagination->getNextPage());
    }
}
