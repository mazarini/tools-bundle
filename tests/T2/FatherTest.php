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

namespace App\Tests\T2;

use App\Repository\FatherRepository;
use App\Repository\GrandRepository;
use App\Repository\SonRepository;
use Mazarini\ToolsBundle\Test\DoctrineTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FatherTest extends WebTestCase
{
    use DoctrineTrait;

    protected GrandRepository $grandRepository;
    protected FatherRepository $fatherRepository;
    protected SonRepository $sonRepository;
    private KernelBrowser $client;
    protected string $path = '/admin/father/';
    protected string $parentId = '1';
    protected string $id = '2';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->grandRepository = new GrandRepository($this->getRegistry());
        $this->fatherRepository = new FatherRepository($this->getRegistry());
        $this->sonRepository = new SonRepository($this->getRegistry());
    }

    public function testVide(): void
    {
        $this->assertSame(0, \count($this->grandRepository->findAll()));
        $this->assertSame(0, \count($this->fatherRepository->findAll()));
        $this->assertSame(0, \count($this->sonRepository->findAll()));
    }

    /**
     * @dataProvider urlProvider
     */
    public function testUrl(string $url, string $id, int $response = 200): void
    {
        $this->initEntity();
        $this->client->request('GET', sprintf('%s%s%s.html', $this->path, $id, $url));
        self::assertResponseStatusCodeSame(200);
    }

    /**
     * @return array<int,array<int,string>>
     */
    public function urlProvider(): array
    {
        return [
            ['/index', $this->parentId],
            ['/new', $this->parentId],
            ['/edit', $this->id],
            ['/show', $this->id],
        ];
    }

    protected function initEntity(): void
    {
        $grand = $this->grandRepository->getNew();
        $this->persist($grand)->flush();

        $father1 = $this->fatherRepository->getNew($grand);
        $grand->addChild($father1);
        $father1->setParent($grand);
        $this->persist($father1)->flush();

        $father2 = $this->fatherRepository->getNew($grand);
        $grand->addChild($father2);
        $father2->setParent($grand);
        $this->persist($father2)->flush();

        $son1 = $this->sonRepository->getNew($father2);
        $father2->addChild($son1);
        $son1->setParent($father2);
        $this->persist($son1)->flush();

        $son2 = $this->sonRepository->getNew($father2);
        $father2->addChild($son2);
        $son2->setParent($father2);
        $this->persist($son2)->flush();

        $son3 = $this->sonRepository->getNew($father2);
        $father2->addChild($son3);
        $son3->setParent($father2);
        $this->persist($son3)->flush();
    }
}
