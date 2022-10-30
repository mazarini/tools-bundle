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

use App\Entity\Grand;
use App\Repository\GrandRepository;
use Mazarini\ToolsBundle\Controller\ViewControllerAbstract;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @template-extends ViewControllerAbstract<Grand>
 */
#[Route('/grand')]
class GrandController extends ViewControllerAbstract
{
    protected string $base = 'grand';

    protected function getFunctions(int $entityId = 0, int $parentId = 0): array
    {
        $function = parent::getFunctions($entityId, $parentId);
        unset($function['index']);

        return $function;
    }

    #[Route('/{id}/page-{page}.html', name: 'app_grand_page', methods: ['GET'])]
    public function page(GrandRepository $repository, int $page, int $id): Response
    {
        return $this->pageAction($repository, $page, 20, [], [], ['labelGrand' => 'ASC']);
    }

    #[Route('/{id}/show.html', name: 'app_grand_show', methods: ['GET'])]
    public function show(Grand $grand): Response
    {
        return $this->showAction($grand);
    }
}
