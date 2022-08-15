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

namespace Mazarini\ToolsBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use Mazarini\ToolsBundle\Entity\ChildInterface;
use Mazarini\ToolsBundle\Entity\ParentInterface;

/**
 * @template P of ParentInterface
 * @template T of ChildInterface
 *
 * @template-extends EntityRepository<T>
 */
abstract class ChildRepository extends EntityRepository
{
    /**
     * @var EntityRepositoryInterface<P>
     */
    protected EntityRepositoryInterface $parentRepository;

    /**
     * @param class-string<T>              $entityClass
     * @param EntityRepositoryInterface<P> $parentRepository
     */
    public function __construct(ManagerRegistry $registry, $entityClass, EntityRepositoryInterface $parentRepository)
    {
        $parentRepository = $this->parentRepository;
        parent::__construct($registry, $entityClass);
    }

    /**
     * @return T
     */
    public function getNew(int $id = 0): object
    {
        if (0 === $id) {
            return $this->createNew();
        }
        $entity = $this->createNew();
        $parent = $this->parentRepository->get($id);
        $entity->setParent($parent);

        return $entity;
    }
}
