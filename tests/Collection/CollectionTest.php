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

use Mazarini\ToolsBundle\Collection\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    /**
     * testArrayAccess.
     */
    public function testArrayAccess(): void
    {
        $collection = new Collection();
        $collection['key1'] = 'value1';
        $collection['key2'] = 'value2';
        $collection['key3'] = 'value3';
        $this->assertTrue(isset($collection['key2']));
        $this->assertSame($collection['key2'], 'value2');
        unset($collection['key2']);
        $this->assertFalse(isset($collection['key2']));
    }

    /**
     * testCountable.
     */
    public function testCountable(): void
    {
        $collection = new Collection([1, 2]);
        $this->assertSame($collection->count(), 2);
        $this->assertSame(\count($collection), 2);
    }

    /**
     * testIterator.
     */
    public function testIterator(): void
    {
        $collection = new Collection(['key1' => 'value1', 'key2' => 'value2', 'key3' => 'value3']);
        $collection->rewind();
        $collection->next();
        $this->assertTrue($collection->valid());
        $this->assertSame($collection->key(), 'key2');
        $this->assertSame($collection->current(), 'value2');
        $this->assertSame($collection['key2'], 'value2');
    }

    /**
     * testIterator.
     */
    public function testForeach(): void
    {
        $collection = new Collection(['key1' => 'value1', 'key2' => 'value2', 'key3' => 'value3']);
        $i = 0;
        foreach ($collection as $key => $value) {
            $this->assertSame($key.$value, 'key'.++$i.'value'.$i);
        }
    }
}
