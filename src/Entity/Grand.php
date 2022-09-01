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

use App\Repository\GrandRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Mazarini\ToolsBundle\Entity\ParentAbstract;
use Mazarini\ToolsBundle\Entity\ParentInterface;

/**
 * @template-extends ParentAbstract<Grand,Father>
 */
#[ORM\Entity(repositoryClass: GrandRepository::class)]
class Grand extends ParentAbstract implements ParentInterface
{
    #[ORM\Column(length: 31)]
    private string $labelGrand = '';
    /**
     * Undocumented variable.
     *
     * @var Collection<int,Father>
     */
    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: Father::class)]
    #[ORM\JoinColumn(nullable: false)]
    protected Collection $childs;

    public function getLabelGrand(): string
    {
        return $this->labelGrand;
    }

    public function setLabelGrand(string $labelGrand): self
    {
        $this->labelGrand = $labelGrand;

        return $this;
    }

    public function __toString()
    {
        return sprintf('%s (%d)', $this->id, $this->labelGrand);
    }
}
