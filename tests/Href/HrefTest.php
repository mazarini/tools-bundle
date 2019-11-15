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

namespace App\Tests\Href;

use Mazarini\ToolsBundle\Href\Href;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class HrefTest extends KernelTestCase
{
    public function testHref()
    {
        $requestStack = new RequestStack();
        $request = new Request();
        $requestStack->push($request);
        $href = new Href($requestStack);
        $href->setCurrentAction('current');
        $href->addHref('current-bis', '');
        $href->addHref('able', '/able');
        $this->assertSame($href->getHref('able'), '/able');
        $this->assertSame($href->getHref('x'), '#');
        $this->assertSame($href->getHref('current'), '');
        $this->assertSame(\count($href->getHrefs()), 3);
        $this->assertTrue($href->isCurrent('current'));
        $this->assertTrue($href->isCurrent('current-bis'));
        $this->assertTrue(!$href->isCurrent('able'));
        $this->assertTrue(!$href->isCurrent('disabled'));
        $this->assertTrue($href->isAble('able'));
        $this->assertTrue(!$href->isAble('disabled'));
        $this->assertSame($href->getClass('current'), ' active');
        $this->assertSame($href->getClass('able'), '');
        $this->assertSame($href->getClass('x'), ' disabled');
    }
}
