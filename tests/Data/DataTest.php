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

use Mazarini\TestBundle\Fake\Entity;
use Mazarini\ToolsBundle\Data\Data;
use Mazarini\ToolsBundle\Href\Hrefs;
use Mazarini\ToolsBundle\Pagination\Pagination;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class DataTest extends KernelTestCase
{
    public function testData()
    {
        $data = new Data();
        $requestStack = new RequestStack();
        $request = new Request();
        $requestStack->push($request);
        $hrefs = new Hrefs($requestStack);
        $data->setHrefs($hrefs);
        $data->addHref('example', '/example');
        $entity = new Entity(1);
        $data->setEntity($entity);
        $pagination = new Pagination(new \ArrayIterator([$entity]), 1, 1, 10);
        $data->setPagination($pagination);
        $entities = $data->getEntities();

        $this->assertSame($data->getEntity(), $entity);
        $this->assertSame($data->getPagination(), $pagination);
        $this->assertSame($data->getHrefs()['example']->getUrl(), '/example');
        $this->assertSame($data->getHrefs()['x']->getClass(), ' disabled');
        $this->assertSame($entities->current(), $entity);
    }
}
