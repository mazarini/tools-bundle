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
use Mazarini\ToolsBundle\Href\HrefInterface;
use Mazarini\ToolsBundle\Pagination\PaginationInterface;

class Data
{
    protected $entity;
    protected $pagination;
    protected $href;

    public function setEntity(EntityInterface $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    public function getEntity(): ?EntityInterface
    {
        return $this->entity;
    }

    public function getEntities(): \Traversable
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

    public function setHref(HrefInterface $href): self
    {
        $this->href = $href;

        return $this;
    }

    public function addHref(string $name, string $href): self
    {
        $this->href->addHref($name, $href);

        return $this;
    }

    public function getHref(string $name): string
    {
        return $this->href->getHref($name);
    }

    public function getClass(string $name): string
    {
        return $this->href->getClass($name);
    }
}
