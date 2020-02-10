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
use Mazarini\ToolsBundle\Data\LinkTree;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LinkTreeTest extends KernelTestCase
{
    /**
     * @var LinkTree
     */
    protected $linkTree;

    public function setUp(): void
    {
        $this->linkTree = new LinkTree('tree', 'Tree Label');
        $this->linkTree->addLink(new Link('example', '/example'));
        $active = new LinkTree('active');
        $active->disable();
        $active->active();
        $this->linkTree->addLink($active);
        $disable = new LinkTree('disable');
        $disable->active();
        $disable->disable();
        $this->linkTree->addLink($disable);
        $standard = new LinkTree('standard');
        $this->linkTree->addLink($standard);
    }

    public function testCount(): void
    {
        $this->assertSame(4, \count($this->linkTree));
    }

    /**
     * testLink.
     *
     * @dataProvider getLink
     */
    public function testLink(string $name, string $url, string $class, string $label): void
    {
        $link = $this->linkTree[$name];
        if ($link instanceof LinkTree) {
            $this->assertSame($name, $link->getName());
            $this->assertSame($url, $link->getUrl());
            $this->assertSame($label, $link->getLabel());
            $this->assertSame($class, $link->getClass());
        } else {
            $this->assertFalse(null === $link, sprintf('Name "%s" is not a LinkTree (null)', $name));
        }
    }

    /**
     * @dataProvider getLink
     */
    public function testIterator(): void
    {
        foreach ($this->linkTree as $name => $link) {
            $this->assertSame($name, $link->getName());
        }
    }

    /**
     * getLink.
     *
     * @return \Traversable<int,array>
     */
    public function getLink(): \Traversable
    {
        yield ['active', '#', ' active', 'Active'];
        yield ['disable', '#', ' disabled', 'Disable'];
        yield ['standard', '#', '', 'Standard'];
        yield ['example', '/example', '', 'Example'];
    }
}
