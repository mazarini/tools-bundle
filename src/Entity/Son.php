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

use App\Repository\SonRepository;
use Doctrine\ORM\Mapping as ORM;
use Mazarini\ToolsBundle\Entity\ChildAbstract;
use Mazarini\ToolsBundle\Entity\ChildInterface;
use Mazarini\ToolsBundle\Entity\ParentInterface;

/**
 * @template-extends ChildAbstract<Father,Son>
 * @template-implements ChildInterface<Father,Son>
 */
#[ORM\Entity(repositoryClass: SonRepository::class)]
class Son extends ChildAbstract implements ChildInterface
{
    #[ORM\Column(length: 31)]
    private string $labelSon = '';
    /**
     * @var Father|null
     */
    #[ORM\ManyToOne(inversedBy: 'childs')]
    protected ?ParentInterface $parent = null;

    public function getLabelSon(): string
    {
        return $this->labelSon;
    }

    public function setLabelSon(string $labelSon): self
    {
        $this->labelSon = $labelSon;

        return $this;
    }
}
