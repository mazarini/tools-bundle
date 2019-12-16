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

namespace App\Tests\Data;

use Mazarini\ToolsBundle\Data\Link;
use Mazarini\ToolsBundle\Data\Links;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LinksTest extends KernelTestCase
{
    /**
     * @var Links
     */
    protected $links;

    public function setUp(): void
    {
        $this->links = new Links('', '/active');
        $this->links->addLink('Disable', '#');
        $this->links->addLink('Example', '/example');
        $this->links->addLink('Active', '/active');
    }

    public function testCount(): void
    {
        $this->assertSame(\count($this->links), 3);
    }

    /**
     * testLink.
     *
     * @dataProvider getLink
     */
    public function testLink(string $name, string $url, string $class, string $label): void
    {
        $link = $this->links[$name];
        if (is_a($link, Link::class)) {
            $this->assertSame($link->getUrl(), $url);
            $this->assertSame($link->getClass(), $class);
            $this->assertSame($link->getLabel(), $label);
        }
    }

    /**
     * getLink.
     *
     * @return \Traversable<int,array>
     */
    public function getLink(): \Traversable
    {
        yield ['active', '', ' active', 'Active'];
        yield ['disable', '#', ' disabled', 'Disable'];
        yield ['unknow', '#', ' disabled', ''];
        yield ['example', '/example', '', 'Example'];
    }
}
