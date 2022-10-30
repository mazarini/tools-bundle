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

use Mazarini\ToolsBundle\Paginator\Pages;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PageTest extends KernelTestCase
{
    public function testVide(): void
    {
        $page = new Pages(0, 0, 10);
        $this->assertFalse($page->isCurrentPageOk());
        $this->assertSame(1, $page->getCurrentPage());

        $page = new Pages(0, 1, 10);
        $this->assertTrue($page->isCurrentPageOk());
        $this->assertSame(1, $page->getCurrentPage());

        $page = new Pages(0, 2, 10);
        $this->assertFalse($page->isCurrentPageOk());
        $this->assertSame(1, $page->getCurrentPage());
    }

    public function testOnePage(): void
    {
        $page = new Pages(1, 1, 10);
        $this->assertTrue($page->isCurrentPageOk());
        $this->assertSame(1, $page->getCurrentPage());

        $page = new Pages(10, 1, 10);
        $this->assertTrue($page->isCurrentPageOk());
        $this->assertSame(1, $page->getCurrentPage());
    }

    public function testTwoPage(): void
    {
        $page = new Pages(10, 1, 10);
        $this->assertTrue($page->isCurrentPageOk());
        $this->assertSame(1, $page->getCurrentPage());

        $page = new Pages(11, 2, 10);
        $this->assertTrue($page->isCurrentPageOk());
        $this->assertSame(2, $page->getCurrentPage());

        $page = new Pages(20, 2, 10);
        $this->assertTrue($page->isCurrentPageOk());
        $this->assertSame(2, $page->getCurrentPage());

        $page = new Pages(20, 3, 10);
        $this->assertFalse($page->isCurrentPageOk());
        $this->assertSame(2, $page->getCurrentPage());
    }
}
