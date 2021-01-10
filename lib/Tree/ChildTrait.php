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

namespace Mazarini\ToolsBundle\Tree;

trait ChildTrait
{
    protected ?self $parent;
    private string $name = '';

    public function getId(): string
    {
        if (null === $this->parent) {
            return $this->name;
        }

        return $this->parent->getId().'-'.$this->name;
    }

    public function hasChild(): bool
    {
        return 0 === $this->count();
    }

    public function count(): int
    {
        return 0;
    }

    public function getCurrent(): NodeInterface
    {
        return $this->getParent()->getCurrent();
    }

    public function isCurrent(?NodeInterface $current): bool
    {
        if (null === $current) {
            return $this->isCurrent($this->getCurrent());
        }

        return $current === $this;
    }

    /**
     * Get the value of parent.
     */
    public function getParent(): self
    {
        if (null !== $this->parent) {
            return $this->parent;
        }
        throw new \Exception('Parent is not set');
    }

    /**
     * Set the value of parent.
     */
    public function setParent(self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get the value of name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name.
     *
     * @param string|int $name
     */
    public function setName(mixed $name): self
    {
        $this->name = (string) $name;

        return $this;
    }
}
