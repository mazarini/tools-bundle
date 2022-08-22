<?php

/*
 * This file is part of mazarini/tools-bundles.
 *
 * mazarini/tools-bundles is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * mazarini/tools-bundles is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
 * for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with mazarini/tools-bundles. If not, see <https://www.gnu.org/licenses/>.
 */

namespace App\Entity;

use App\Repository\FatherRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Mazarini\ToolsBundle\Entity\EntityInterface;
use Mazarini\ToolsBundle\Entity\ParentChildAbstract;
use Mazarini\ToolsBundle\Entity\ParentChildInterface;
use Mazarini\ToolsBundle\Entity\ParentInterface;

/**
 * @template-extends ParentChildAbstract<Grand,Father,Son>
 * @template-implements ParentChildInterface<Grand,Father,Son>
 */
#[ORM\Entity(repositoryClass: FatherRepository::class)]
class Father extends ParentChildAbstract implements ParentChildInterface, EntityInterface
{
    #[ORM\Column(length: 31)]
    private string $labelFather = '';
    /**
     * @var Collection<int,Son>
     */
    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: Son::class)]
    protected Collection $childs;
    /**
     * @var Grand|null
     */
    #[ORM\ManyToOne(targetEntity: Grand::class, inversedBy: 'childs')]
    protected ?ParentInterface $parent;

    public function getLabelFather(): string
    {
        return $this->labelFather;
    }

    public function setLabelFather(string $labelFather): self
    {
        $this->labelFather = $labelFather;

        return $this;
    }

    public function __toString()
    {
        return sprintf('%s (%d)', $this->id, $this->labelFather);
    }
}
