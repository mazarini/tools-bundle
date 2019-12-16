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

/**
 * @template-extends \ArrayIterator<string, Link | Links>
 */
class Links extends \ArrayIterator
{
    /**
     * @var string
     */
    protected $label = '';

    /**
     * @var string
     */
    protected $currentUrl = '';

    /**
     * @var Link
     */
    protected $current;
    /**
     * @var Link
     */
    protected $disable;

    public function __construct(string $name, string $url, string $label = '')
    {
        parent::__construct();
        $this->currentUrl = $url;
        if ('' === $label) {
            $this->label = $name;
        } else {
            $this->label = $label;
        }
        $this->disable = new Link('#', '');
        $this->current = new Link('', $this->label);
        if ('' !== $name) {
            $this->addLink($name, $url);
        }
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * addLinks.
     *
     * @return self<string,Link | Links>
     */
    public function addLinks(string $name, self $links): self
    {
        $this[mb_strtolower($name)] = $links;

        return $this;
    }

    /**
     * addLink.
     *
     * @return self<string,Link | Links>
     */
    public function addLink(string $name, string $url, string $label = ''): self
    {
        if ('' === $label) {
            $label = $name;
        }
        $this[mb_strtolower($name)] = new Link($url, $label);

        return $this;
    }

    public function setCurrentUrl(string $url): self
    {
        $this->currentUrl = $url;

        return $this;
    }

    /**
     * offsetExists.
     *
     * @param string $offset
     */
    public function offsetExists($offset): bool
    {
        return true;
    }

    /**
     * offsetGet.
     *
     * @param string $offset
     *
     * @return Link|Links
     */
    public function offsetGet($offset)
    {
        if ('@LABEL@' === $offset) {
            return new Link('', $this->label);
        }

        if (!parent::offsetExists(mb_strtolower($offset))) {
            return $this->disable;
        }

        $link = parent::offsetGet(mb_strtolower($offset));

        if (is_a($link, self::class)) {
            return $link;
        }

        if ($link->getUrl() === $this->currentUrl) {
            return $this->current->setLabel($link->getLabel());
        }

        return $link;
    }

    /**
     * current.
     *
     * @return Link|Links
     */
    public function current()
    {
        return $this->offsetGet($this->key());
    }
}
