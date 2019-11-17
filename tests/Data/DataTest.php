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
use Mazarini\TestBundle\Fake\Pagination;
use Mazarini\ToolsBundle\Data\Data;
use Mazarini\ToolsBundle\Href\Href;
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
        $href = new Href($requestStack);
        $data->setHref($href);
        $data->addHref('example', '/example');
        $pagination = new Pagination(2, 11, 10);
        $data->setPagination($pagination);
        $entity = new Entity();
        $data->setEntity($entity);
        $entities = $data->getEntities();

        $this->assertSame($data->getEntity(), $entity);
        $this->assertSame($data->getPagination(), $pagination);
        $this->assertSame($data->getHref('example'), '/example');
        $this->assertSame($data->getClass('x'), ' disabled');
        $this->assertSame($entities[11]->getId(), 11);
    }
}
