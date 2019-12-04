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

namespace Mazarini\ToolsBundle\Data;

use Mazarini\ToolsBundle\Entity\EntityInterface;
use Mazarini\ToolsBundle\Href\Hrefs;
use Mazarini\ToolsBundle\Pagination\PaginationInterface;

class Data
{
    protected $entity;
    protected $pagination;
    protected $hrefs;

    public function setEntity(EntityInterface $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    public function getEntity(): ?EntityInterface
    {
        return $this->entity;
    }

    public function getEntities(): \ArrayIterator
    {
        return $this->pagination->getEntities();
    }

    public function setPagination(PaginationInterface $pagination): self
    {
        $this->pagination = $pagination;

        return $this;
    }

    public function getPagination(): PaginationInterface
    {
        return $this->pagination;
    }

    public function setHrefs(Hrefs $hrefs): self
    {
        $this->hrefs = $hrefs;

        return $this;
    }

    public function getHrefs(): Hrefs
    {
        return $this->hrefs;
    }

    public function addHref(string $name, string $url): self
    {
        $this->hrefs->addLink($name, $url);

        return $this;
    }
}
