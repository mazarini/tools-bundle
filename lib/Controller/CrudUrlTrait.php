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

trait CrudUrlTrait
{
    /**
     * getCrudAction.
     *
     * @return array<string,string>
     */
    protected function getCrudAction(): array
    {
        return ['_edit' => 'Edit', '_show' => 'Show', '_delete' => 'Delete'];
    }

    /**
     * setCrudUrl.
     */
    protected function setCrudUrl(Data $data): void
    {
        if ($data->isSetEntity()) {
            $entity = $data->getEntity();
            if (!$entity->Isnew()) {
                foreach ($this->getCrudAction() as $action => $label) {
                    $data->addLink(trim($action, '_'), $data->generateUrl($action, ['id' => $entity->getId()]), $label);
                }
            }
        }
    }
}
