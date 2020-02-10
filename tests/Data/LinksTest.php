<?php

/*
 * Copyright (C) 2019-2020 Mazarini <mazarini@protonmail.com>.
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
        $this->links = new Links('/active');
        $this->links->addLink(new Link('disable', '#'));
        $this->links->addLink(new Link('example', '/example'));
        $this->links->addLink(new Link('active', '/active'));
        $this->links->addLink(new Link('blank', ''));
    }

    public function testCount(): void
    {
        $this->assertSame(\count($this->links), 4);
    }

    /**
     * testLink.
     *
     * @dataProvider getLink
     */
    public function testLink(string $name, string $url, string $class, string $label): void
    {
        $link = $this->links[$name];
        $this->assertSame($name, $link->getName());
        $this->assertSame($url, $link->getUrl());
        $this->assertSame($label, $link->getLabel());
        $this->assertSame($class, $link->getClass());
    }

    /**
     * @dataProvider getLink
     */
    public function testIterator(): void
    {
        foreach ($this->links as $name => $link) {
            $this->assertSame($name, $link->getName());
            if ('active' === $name) {
                $this->assertSame('', $link->getUrl());
            }
        }
    }

    /**
     * testActive.
     */
    public function testActive(): void
    {
        $active = new Link('active', '/active', 'Active');
        $links = new Links('');
        $links['active'] = $active;
        $this->assertTrue($links['active'] === $active);
        $links->setCurrentUrl('/active');
        $this->assertFalse($links['active'] === $active);
        $this->assertSame('active', $links['active']->getName());
        $this->assertSame('', $links['active']->getUrl());
        $this->assertSame('Active', $links['active']->getLabel());
        $this->assertSame(' active', $links['active']->getClass());
    }

    /**
     * getLink.
     *
     * @return \Traversable<int,array>
     */
    public function getLink(): \Traversable
    {
        yield ['active', '', ' active', 'Active'];
        yield ['blank', '', ' active', 'Blank'];
        yield ['disable', '#', ' disabled', 'Disable'];
        yield ['unknow', '#', ' disabled', 'Unknow'];
        yield ['example', '/example', '', 'Example'];
    }
}
