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

namespace App\Controller;

use App\Entity\Father;
use App\Entity\Son;
use App\Repository\SonRepository;
use Mazarini\ToolsBundle\Controller\ViewControllerAbstract;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @template-extends ViewControllerAbstract<Son>
 */
#[Route('/son')]
class SonController extends ViewControllerAbstract
{
    protected string $base = 'son';

    protected function getFunctions(int $entityId = 0, int $parentId = 0): array
    {
        $function = parent::getFunctions($entityId, $parentId);
        unset($function['index']);

        return $function;
    }

    #[Route('/{id}/page-{page}.html', name: 'app_son_page', methods: ['GET'])]
    public function page(SonRepository $repository, int $page, Father $parent): Response
    {
        return $this->pageAction($repository, $page, 20, [], ['parent' => $parent], []);
    }

    #[Route('/{id}/show.html', name: 'app_son_show', methods: ['GET'])]
    public function show(Son $son): Response
    {
        return $this->showAction($son);
    }
}
