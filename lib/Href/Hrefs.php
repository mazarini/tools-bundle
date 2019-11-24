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

use Mazarini\ToolsBundle\Collection\Collection;
use Symfony\Component\HttpFoundation\RequestStack;

class Hrefs extends Collection
{
    /**
     * @var string
     */
    protected $currentUrl = '';

    /**
     * @var Link
     */
    protected $disable;

    public function __construct(RequestStack $requestStack)
    {
        parent::__construct();
        $this->disable = new Link();
        $request = $requestStack->getMasterRequest();
        if (null !== $request) {
            $this->currentUrl = $request->getPathInfo();
            $part = explode('_', $request->attributes->get('_route'));
            $this->addLink($part[array_key_last($part)]);
        }
    }

    /**
     * addLink.
     *
     * @param string|Link $urlOrLink
     */
    public function addLink(string $name, $urlOrLink = ''): self
    {
        if (is_a($urlOrLink, Link::class)) {
            $link = $urlOrLink;
        } else {
            $link = new Link($urlOrLink);
        }
        if ($this->currentUrl === $link->getUrl()) {
            $link->setCurrent();
        }
        $this[mb_strtolower($name)] = $link;

        return $this;
    }

    public function removeLink(string $name): self
    {
        unset($this[mb_strtolower($name)]);

        return $this;
    }

    public function setCurrentUrl(string $currentUrl): self
    {
        $this->currentUrl = $currentUrl;

        return $this;
    }

    public function offsetExists($offset): bool
    {
        return true;
    }

    public function offsetGet($offset)
    {
        if (parent::offsetExists(mb_strtolower($offset))) {
            $link = parent::offsetGet(mb_strtolower($offset));
            if ($link->getUrl() === $this->currentUrl) {
                $link->setCurrent();
            }

            return $link;
        }

        return $this->disable;
    }
}
