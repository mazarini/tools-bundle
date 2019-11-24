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

use Mazarini\ToolsBundle\Href\Hrefs;
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
        $hrefs = new Hrefs($requestStack);
        $hrefs->setCurrentUrl('/current');
        $hrefs->addLink('current', '/current');
        $hrefs->addLink('able', '/able');
        $this->assertSame($hrefs['able']->getUrl(), '/able');
        $this->assertSame($hrefs['x']->getUrl(), '#');
        $this->assertSame($hrefs['current']->getUrl(), '');
        $this->assertSame(\count($hrefs), 3);
        $this->assertSame($hrefs['current']->getClass(), ' active');
        $this->assertSame($hrefs['able']->getClass(), '');
        $this->assertSame($hrefs['x']->getClass(), ' disabled');
    }
}
