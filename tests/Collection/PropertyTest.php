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

namespace App\Tests\Collection;

use App\Collection\Property;
use PHPUnit\Framework\TestCase;

class PropertyTest extends TestCase
{
    /**
     * testArrayAccess.
     */
    public function testArrayAccess(): void
    {
        $property = new Property();
        $this->assertTrue(isset($property['var2']));
        $this->assertSame($property['var2'], 'value2');
        unset($property['var2']);
        $this->assertFalse(isset($property['var2']));
    }

    /**
     * testCountable.
     */
    public function testCountable(): void
    {
        $property = new Property();
        $this->assertSame($property->count(), 3);
        $this->assertSame(\count($property), 3);
    }

    /**
     * testIterator.
     */
    public function testIterator(): void
    {
        $property = new Property();
        $property->rewind();
        $property->next();
        $this->assertTrue($property->valid());
        $this->assertSame($property->key(), 'var2');
        $this->assertSame($property->current(), 'value2');
        $this->assertSame($property['var2'], 'value2');
    }

    /**
     * testIterator.
     */
    public function testForeach(): void
    {
        $property = new Property();
        $i = 0;
        foreach ($property as $key => $value) {
            $this->assertSame($key.$value, 'var'.++$i.'value'.$i);
        }
    }
}
