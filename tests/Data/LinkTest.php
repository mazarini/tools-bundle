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
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LinkTest extends KernelTestCase
{
    /**
     * testLink.
     *
     * @dataProvider getLink
     */
    public function testLink(string $name, string $url, string $label, string $class): void
    {
        $link = new Link($name, $url, $label);
        $this->assertSame($name, $link->getName());
        $this->assertSame($url, $link->getUrl());
        $this->assertSame($label, $link->getLabel());
        $this->assertSame($class, $link->getClass());
    }

    /**
     * testLinkLabel.
     */
    public function testLinkLabel(): void
    {
        $link = new Link('name', 'url');
        $this->assertSame('Name', $link->getLabel());
    }

    /**
     * getLink.
     *
     * @return \Traversable<int,array>
     */
    public function getLink(): \Traversable
    {
        yield ['active', '', 'Active label', ' active'];
        yield ['disable', '#', 'Disable label', ' disabled'];
        yield ['example', '/example', 'Example label', ''];
    }
}
