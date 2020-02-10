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

namespace App\Tests\Entity;

use Mazarini\TestBundle\Fake\Entity;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class EntityTest extends TestCase
{
    /**
     * testNewEntity.
     */
    public function testNewEntity(): void
    {
        $entity = new Entity();
        $this->assertSame($entity->getId(), 0);
        $this->assertTrue($entity->isNew());
    }

    /**
     * testEntity.
     */
    public function testEntity(): void
    {
        $entity = new Entity();
        $reflectionClass = new ReflectionClass(Entity::class);
        $reflectionProperty = $reflectionClass->getProperty('id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, 1);

        $this->assertSame($entity->getId(), 1);
        $this->assertFalse($entity->isNew());
    }
}
