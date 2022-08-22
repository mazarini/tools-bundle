<?php

/*
 * This file is part of mazarini/tools-bundles.
 *
 * mazarini/tools-bundles is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * mazarini/tools-bundles is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
 * for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with mazarini/tools-bundles. If not, see <https://www.gnu.org/licenses/>.
 */

namespace App\Tests\T1;

use App\Entity\Grand;
use App\Repository\FatherRepository;
use App\Repository\GrandRepository;
use App\Repository\SonRepository;
use Mazarini\ToolsBundle\Test\RegistryTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EntityTest extends KernelTestCase
{
    use RegistryTrait;

    protected GrandRepository $grandRepository;
    protected FatherRepository $fatherRepository;
    protected SonRepository $sonRepository;

    protected function setUp(): void
    {
        $this->grandRepository = new GrandRepository($this->getRegistry());
        $this->fatherRepository = new FatherRepository($this->getRegistry(), $this->grandRepository);
        $this->sonRepository = new SonRepository($this->getRegistry(), $this->fatherRepository);
    }

    public function testVide(): void
    {
        $this->assertSame(0, \count($this->grandRepository->findAll()));
        $this->assertSame(0, \count($this->fatherRepository->findAll()));
        $this->assertSame(0, \count($this->sonRepository->findAll()));
    }

    public function testGrand(): void
    {
        $new = $this->grandRepository->getNew(0);
        $this->assertTrue($new->isNew());
        $new = new Grand();
        $this->grandRepository->add($new);
        $this->assertFalse($new->isNew());

        $read = $this->grandRepository->get($new->getId());
        $this->assertFalse($read->isNew());
        $this->assertSame($new->getId(), $read->getId());
        $this->assertSame(1, \count($this->grandRepository->getPage([], 1)));

        $this->grandRepository->remove($read);
        $this->assertSame(0, \count($this->grandRepository->getPage([], 1)));
    }

    public function testFather(): void
    {
        $new = $this->fatherRepository->getNew(0);
        $this->assertTrue($new->isNew());

        $this->fatherRepository->add($new);
        $this->assertFalse($new->isNew());

        $read = $this->fatherRepository->get($new->getId());
        $this->assertFalse($read->isNew());
        $this->assertSame($new->getId(), $read->getId());
        $this->assertSame(1, \count($this->fatherRepository->getPage([], 1)));

        $this->fatherRepository->remove($read);
        $this->assertSame(0, \count($this->fatherRepository->getPage([], 1)));
    }

    public function testSon(): void
    {
        $new = $this->sonRepository->getNew();
        $this->assertTrue($new->isNew());

        $this->sonRepository->add($new);
        $this->assertFalse($new->isNew());

        $read = $this->sonRepository->get($new->getId());
        $this->assertFalse($read->isNew());
        $this->assertSame($new->getId(), $read->getId());
        $this->assertSame(1, \count($this->sonRepository->getPage([], 1)));

        $this->sonRepository->remove($read);
        $this->assertSame(0, \count($this->sonRepository->getPage([], 1)));
    }

    public function testParentChild(): void
    {
        $grand = $this->grandRepository->getNew();
        $this->grandRepository->add($grand);

        $father = $this->fatherRepository->getNew(0);
        $grand->addChild($father);
        $father->setParent($grand);
        $this->fatherRepository->add($father);

        $son = $this->sonRepository->getNew();
        $father->addChild($son);
        $son->setParent($father);
        $this->sonRepository->add($son);

        $this->assertSame(1, \count($this->sonRepository->getPage([], 1)));
        $this->assertSame(1, \count($this->fatherRepository->getPage([], 1)));
        $this->assertSame(1, \count($this->grandRepository->getPage([], 1)));

        $grand = $this->grandRepository->findAll()[0];
        $father = $this->fatherRepository->findAll()[0];
        $son = $this->sonRepository->findAll()[0];

        $this->assertSame(1, \count($grand));
        $this->assertSame(1, \count($father));
        $this->assertSame(0, \count($son));

        $this->assertSame(0, $grand->getParentId());
        $this->assertSame($father->getId(), $son->getParentId());
        $this->assertSame($grand->getId(), $father->getParentId());
    }
}
