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

use Mazarini\PaginationBundle\Tool\Pagination;
use Mazarini\TestBundle\Fake\Entity;
use Mazarini\ToolsBundle\Data\Data;
use Mazarini\ToolsBundle\Entity\EntityInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DataTest extends KernelTestCase
{
    /**
     * @var Data
     */
    protected $data;

    /**
     * @var EntityInterface
     */
    protected $entity;

    public function setUp(): void
    {
        $this->data = new Data();
        $this->data->setCurrentAction('route');
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
}
