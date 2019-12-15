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

namespace App\Tests\Links;

use Mazarini\ToolsBundle\Data\Links;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LinksTest extends KernelTestCase
{
    public function testLink(): void
    {
        $links = new Links('', '/active');
        $links->addLink('Disable', '#');
        $links->addLink('Example', '/example');
        $links->addLink('Active', '/active');

        $this->assertSame(\count($links), 3);

        $this->assertSame($links['active']->getUrl(), '');
        $this->assertSame($links['disable']->getUrl(), '#');
        $this->assertSame($links['unknow']->getUrl(), '#');
        $this->assertSame($links['example']->getUrl(), '/example');

        $this->assertSame($links['active']->getClass(), ' active');
        $this->assertSame($links['disable']->getClass(), ' disabled');
        $this->assertSame($links['unknow']->getClass(), ' disabled');
        $this->assertSame($links['example']->getClass(), '');

        $this->assertSame($links['active']->getLabel(), 'Active');
        $this->assertSame($links['disable']->getLabel(), 'Disable');
        $this->assertSame($links['unknow']->getLabel(), '');
        $this->assertSame($links['example']->getLabel(), 'Example');
    }
}
