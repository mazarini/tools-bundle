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

namespace App\Controller;

use Mazarini\TestBundle\Controller\StepController as BaseController;
use Mazarini\ToolsBundle\Data\Link;
use Symfony\Component\HttpKernel\Kernel;

class StepController extends BaseController
{
    protected function afterAction2(string $action): void
    {
        if ('System' === $this->step) {
            $this->parameters['symfony']['version'] = Kernel::VERSION;
            $this->parameters['php']['version'] = PHP_VERSION;
            $this->parameters['php']['extensions'] = get_loaded_extensions();
            asort($this->parameters['php']['extensions'], SORT_FLAG_CASE | SORT_NATURAL);
        } elseif ('Data' === $this->step) {
            /* nothings */
        } elseif ('CRUD' === $this->step) {
            $this->parameters['dataCrud'] = $this->fakeFactory->getCrudData();
        } elseif ('Pagination' === $this->step) {
            $this->parameters['dataPagination'] = $this->fakeFactory->getPaginationData();
        } else /* examples */ {
            $this->parameters['tree'] = $tree = $this->fakeFactory->getTree('Tree', 'item', 5);
            $tree['item-1'] = $item1 = $this->fakeFactory->getTree('Item-1', 'item-1', 2);
            $item1['item-1-1'] = $this->fakeFactory->getTree('Item-1-1', 'item-1-1', 3);
            $item1['item-1-2'] = $this->fakeFactory->getTree('Item-1-2', 'item-1-2', 2);
            $tree['item-2'] = $this->fakeFactory->getTree('Item-2', 'item-2', 2);
            $tree['item-4'] = $this->fakeFactory->getTree('Item-4', 'item-4', 2);

            $this->parameters['List'] = $this->fakeFactory->getLinks('item', 7);
            $this->parameters['list']['item-2'] = new Link('item-2', '#', 'Disable');
            $this->parameters['list']['item-6'] = new Link('item-6', '', 'Active');

            $this->parameters['dataLinks'] = $this->fakeFactory->getLinksData();
        }
    }
}
