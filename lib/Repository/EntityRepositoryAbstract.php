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

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Mazarini\ToolsBundle\Entity\EntityInterface;
use TypeError;

/**
 * @template T of EntityInterface
 * @template-extends ServiceEntityRepository<T>
 * @template-implements EntityRepositoryInterface<T>
 */
abstract class EntityRepositoryAbstract extends ServiceEntityRepository implements EntityRepositoryInterface
{
    /**
     * @return T
     */
    abstract protected function createNew(): object;

    /**
     * @return T
     */
    public function getNew(int $id = 0): object
    {
        if (0 === $id) {
            return $this->createNew();
        }
        throw new TypeError('TypeError');
    }

    /**
     * @return T
     */
    public function get(int $id): object
    {
        $entity = $this->find($id);
        if (null === $entity) {
            throw new TypeError('NotFound');
        }

        return $entity;
    }

    /**
     * @param array<string,string> $order
     *
     * @return array<int,T>
     */
    public function getPage(array $order, int $page): array
    {
        if (0 === $page) {
            throw new TypeError('NotFound');
        }

        return $this->findBy([], $order);
    }
}
