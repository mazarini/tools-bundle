<?php

namespace Mazarini\ToolsBundle\Entity;

use Doctrine\Common\Collections\Collection;

/**
 * Generic entity child class.
 *
 * @template C of ChildInterface|ParentChildInterface
 * @template P of ParentInterface|ParentChildInterface
 */
interface ParentInterface extends EntityInterface
{
    /**
     * Getter of childs
     * @return Collection<int, C>
     */
    public function getChilds(): Collection;

    /**
     * Add a child to childs
     * @param C $child
     */
    public function addChild(object $child): void;

    /**
     * Remove a child from childs
     * @param C $child
     */
    public function removeChild(object $child): void;
}
