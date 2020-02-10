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

use Mazarini\TestBundle\Fake\Entity;
use Mazarini\TestBundle\Fake\UrlGenerator;
use Mazarini\ToolsBundle\Data\Data;
use Mazarini\ToolsBundle\Data\Link;
use Mazarini\ToolsBundle\Pagination\Pagination;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DataTest extends KernelTestCase
{
    /**
     * @var Data
     */
    protected $data;

    /**
     * @var Entity
     */
    protected $entity;

    public function setUp(): void
    {
        $this->data = new Data(new UrlGenerator(), 'base', 'route', '/current');
        $this->data->addLink('url', '/url', 'Url');
        $this->data->addLink('relative', $this->data->generateUrl('_route', ['p1' => 'v1', 'p2' => 'v2']), 'Relative url with parameters');
        $this->data->addLink('base', $this->data->generateUrl('route', ['p1' => 'v1', 'p2' => 'v2']), 'Url with parameters');
        $this->data->addLink('current', '/current', 'Current');

        $this->entity = new Entity(1);
    }

    public function testAction(): void
    {
        $this->assertSame('route', $this->data->getCurrentAction());
        $this->data->setCurrentAction('route2');
        $this->assertSame('route2', $this->data->getCurrentAction());
    }

    public function testEntity(): void
    {
        $this->assertFalse($this->data->isSetEntity());
        $this->data->setEntity($this->entity);
        $this->assertTrue($this->data->isSetEntity());
        $this->assertSame($this->entity, $this->data->getEntity());
    }

    public function testEntities(): void
    {
        $this->assertFalse($this->data->isSetEntities());
        $pagination = new Pagination(new \ArrayIterator([$this->entity]), 1, 1, 10);
        $this->data->setPagination($pagination);
        $this->assertSame($pagination, $this->data->getPagination());
        $this->assertTrue($this->data->isSetEntities());
        $this->assertSame($this->entity, $this->data->getEntities()->current());
    }

    /**
     * testUrls.
     *
     * @dataProvider getLink
     */
    public function testLink(string $name, string $url, string $class, string $label): void
    {
        $link = $this->data->getLinks()[$name];
        $this->assertTrue(is_a($link, Link::class));
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
        yield ['url', '/url', '', 'Url'];
        yield ['relative', '#base_route-v1-v2', '', 'Relative url with parameters'];
        yield ['base', '#route-v1-v2', '', 'Url with parameters'];
        yield ['x', '#', ' disabled', 'X'];
        yield ['current', '', ' active', 'Current'];
    }
}
