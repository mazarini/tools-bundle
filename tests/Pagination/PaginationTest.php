<?php

/*
 * Copyright (C) 2019 Mazarini <mazarini@protonmail.com>.
 * This file is part of mazarini/tools-bundle.
 *
 * mazarini/tools-bundle is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.
 *
 * mazarini/tools-bundle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License
 */

namespace App\Tests\Pagination;

use Mazarini\TestBundle\Fake\Entity;
use Mazarini\ToolsBundle\Pagination\Pagination;
use PHPUnit\Framework\TestCase;

class PaginationTest extends TestCase
{
    private $entities0;
    private $entities5;
    private $entities10;

    public function setUp(): void
    {
        $this->entities0 = new \ArrayIterator([]);
        for ($i = 1; $i <= 10; ++$i) {
            $entities[] = new Entity($i);
            if (5 === $i) {
                $this->entities5 = new \ArrayIterator($entities);
            }
            if (10 === $i) {
                $this->entities10 = new \ArrayIterator($entities);
            }
        }
    }

    public function testZeroPage(): void
    {
        $pagination = new Pagination($this->entities0, 1, 0, 10);
        $this->assertSame(\count($pagination->GetEntities()), 0);
        $this->assertSame($pagination->getCurrentPage(), 1);
        $this->assertSame($pagination->getLastPage(), 1);
        $this->assertTrue(!$pagination->HasToPaginate());
        $this->assertTrue(!$pagination->HasPreviousPage());
        $this->assertTrue(!$pagination->HasNextPage());
    }

    public function testOnePage(): void
    {
        $pagination = new Pagination($this->entities5, 0, 5, 10);
        $this->assertSame($pagination->getCurrentPage(), 1);

        $pagination = new Pagination($this->entities5, 1, 5, 10);
        $this->assertSame($pagination->getCurrentPage(), 1);

        $pagination = new Pagination($this->entities5, 2, 5, 10);
        $this->assertSame($pagination->getCurrentPage(), 1);

        $this->assertSame($pagination->getLastPage(), 1);
        $this->assertTrue(!$pagination->HasToPaginate());
        $this->assertTrue(!$pagination->HasPreviousPage());
        $this->assertTrue(!$pagination->HasNextPage());
    }

    public function testPages(): void
    {
        $pagination = new Pagination($this->entities10, 3, 20, 10);
        $this->assertSame($pagination->getLastPage(), 2);
        $this->assertSame($pagination->getCurrentPage(), 2);
        $this->assertTrue($pagination->HasToPaginate());

        $pagination = new Pagination($this->entities10, 1, 21, 10);
        $this->assertSame($pagination->getLastPage(), 3);
        $this->assertSame($pagination->getCurrentPage(), 1);
        $this->assertTrue($pagination->HasToPaginate());
    }

    public function testNavigation(): void
    {
        $pagination = new Pagination($this->entities10, 1, 50, 10);
        $this->assertTrue(!$pagination->HasPreviousPage());
        $this->assertTrue($pagination->HasNextPage());

        $pagination = new Pagination($this->entities10, 3, 50, 10);
        $this->assertTrue($pagination->HasPreviousPage());
        $this->assertTrue($pagination->HasNextPage());

        $this->assertSame($pagination->getFirstPage(), 1);
        $this->assertSame($pagination->getPreviousPage(), 2);
        $this->assertSame($pagination->getCurrentPage(), 3);
        $this->assertSame($pagination->getNextPage(), 4);
        $this->assertSame($pagination->getLastPage(), 5);

        $pagination = new Pagination($this->entities10, 5, 50, 10);
        $this->assertTrue($pagination->HasPreviousPage());
        $this->assertTrue(!$pagination->HasNextPage());
    }

    public function testEntities(): void
    {
        $pagination = new Pagination($this->entities5, 1, 5, 10);
        $this->assertSame(\count($pagination->GetEntities()), 5);
    }
}
