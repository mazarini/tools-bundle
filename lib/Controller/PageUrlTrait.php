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

namespace Mazarini\ToolsBundle\Controller;

use Mazarini\ToolsBundle\Data\Data;

trait PageUrlTrait
{
    /**
     * getPageParameters.
     *
     * @return array<string,string>
     */
    protected function getPageParameters(): array
    {
        return [];
    }

    /**
     * AddPageUrl.
     */
    protected function AddPageUrl(Data $data, string $key, bool $active, int $page, string $label): void
    {
        $url = '#';
        if ($active) {
            $parameters = $this->getPageParameters();
            $parameters['page'] = $page;
            $url = $data->generateUrl('_page', $parameters);
        }
        $data->addLink($key, $url, $label);
    }

    protected function setNewUrl(Data $data): void
    {
        if ($data->isCrud()) {
            $data->addLink('new', $data->generateUrl('_new', $this->getPageParameters()), 'Create');
        }
    }

    protected function setPageUrl(Data $data): void
    {
        if ($data->isCrud()) {
            $this->AddPageUrl($data, 'index', true, 1, 'List');
        }
        if ($data->isSetEntities()) {
            $pagination = $data->getPagination();
            $this->AddPageUrl($data, 'first', $pagination->hasPreviousPage(), $pagination->getFirstPage(), '1');
            $this->AddPageUrl($data, 'previous', $pagination->hasPreviousPage(), $pagination->getPreviousPage(), 'Previous');
            $this->AddPageUrl($data, 'previous', $pagination->hasNextPage(), $pagination->getNextPage(), 'Next');
            $this->AddPageUrl($data, 'last', $pagination->hasNextPage(), $pagination->getLastPage(), (string) $pagination->getLastPage());

            for ($i = 1; $i <= $pagination->getLastPage(); ++$i) {
                $this->AddPageUrl($data, 'page-'.$i, true, $i, (string) $i);
            }
        }
    }
}
