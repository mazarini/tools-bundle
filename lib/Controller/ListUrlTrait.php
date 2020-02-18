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

trait ListUrlTrait
{
    /**
     * getListAction.
     *
     * @return array<string,string>
     */
    protected function getListAction(): array
    {
        return ['_edit' => 'button.Edit', '_show' => 'button.Show'];
    }

    /**
     * setListUrl.
     */
    protected function setListUrl(Data $data): void
    {
        if ($data->isSetEntities()) {
            foreach ($data->getEntities() as $entity) {
                $parameters = ['id' => $entity->getId()];
                foreach ($this->getListAction() as $action => $label) {
                    $data->addLink(trim($action, '_').'-'.$parameters['id'], $data->generateUrl($action, $parameters), $label);
                }
            }
        }
    }
}
