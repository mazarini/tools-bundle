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

namespace Mazarini\ToolsBundle\Href;

use Symfony\Component\HttpFoundation\RequestStack;

class Href implements HrefInterface
{
    /**
     * @var string
     */
    protected $currentAction = '';

    /**
     * @var string
     */
    protected $currentUrl = '';

    /**
     * @var string[]
     */
    protected $hrefs = [];

    public function __construct(RequestStack $requestStack)
    {
        $request = $requestStack->getMasterRequest();
        if (null !== $request) {
            $this->currentAction = $request->getPathInfo();
        }
    }

    public function addHref(string $name, string $href): HrefInterface
    {
        $this->hrefs[$name] = $href;

        return $this;
    }

    public function getHref(string $name): string
    {
        if (!isset($this->hrefs[$name])) {
            return '#';
        }

        return $this->hrefs[$name];
    }

    public function getHrefs(): array
    {
        return $this->hrefs;
    }

    public function setCurrentAction(string $currentAction): HrefInterface
    {
        $this->currentAction = $currentAction;
        $this->hrefs[$currentAction] = '';

        return $this;
    }

    public function isCurrent(string $name): bool
    {
        if (!isset($this->hrefs[$name])) {
            return false;
        }

        return $this->hrefs[$name] === $this->currentAction || '' === $this->hrefs[$name];
    }

    public function getClass(string $name): string
    {
        if ($this->isCurrent($name)) {
            return ' active';
        }
        if ($this->isAble($name)) {
            return '';
        }

        return ' disabled';
    }

    public function isAble(string $name): bool
    {
        return isset($this->hrefs[$name]);
    }
}
