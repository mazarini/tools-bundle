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
use Doctrine\ORM\QueryBuilder;
use Mazarini\ToolsBundle\Entity\ChildInterface;
use Mazarini\ToolsBundle\Entity\EntityInterface;
use Mazarini\ToolsBundle\Entity\ParentInterface;
use Mazarini\ToolsBundle\Page\Pagination;
use Mazarini\ToolsBundle\Page\PaginationInterface;
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
    abstract protected function createNew(): EntityInterface;

    /**
     * @return T
     */
    public function getNew(ParentInterface $parent = null): EntityInterface
    {
        $entity = $this->createNew();
        if (null === $parent) {
            return $entity;
        }
        if ($entity instanceof ChildInterface) {
            $entity->setParent($parent);

            return $entity;
        }
        throw new TypeError('Only ChildInterface has ParentInterface');
    }

    /**
     * @return T
     */
    public function get(int $id): EntityInterface
    {
        $entity = $this->find($id);
        if (null === $entity) {
            throw new TypeError('NotFound');
        }

        return $entity;
    }

    public function getPage(?object $parent, int $currentPage = 1, int $pageSize = 10): PaginationInterface
    {
        $pagination = new Pagination();
        $pagination->setTotalCount($this->totalCount($parent));
        $pagination->setPageSize($pageSize);
        $pagination->setCurrentPage($currentPage);
        if ($pagination->isCurrentPageOk()) {
            $pagination->setEntities($this->getResult($parent, ($currentPage - 1) * $pageSize, $pageSize));
        }

        return $pagination;
    }

    protected function totalCount(?object $parent): int
    {
        $count = $this->getPageQueryBuilder($parent)
                ->select('count(e.id)')
                ->getQuery()
                ->getSingleScalarResult();

        if (\is_int($count)) {
            return $count;
        }

        throw new TypeError('Count(*) is not an integer!');
    }

    /**
     * getResult.
     *
     * @return array<int, mixed>
     */
    protected function getResult(?object $parent, int $start, int $pageSize): array
    {
        $query = $this->getPageQueryBuilder($parent)
//              ->orderBy($this->orderColumn, $this->orderDirection)
                ->setFirstResult($start)
                ->setMaxResults($pageSize)
                ->getQuery();

        $result = $query->getResult();
        if (\is_array($result)) {
            return $result;
        }
        throw new TypeError('Result is not an array.');
    }

    protected function getPageQueryBuilder(?object $parent): QueryBuilder
    {
        if (null === $parent) {
            return $this->createQueryBuilder('e');
        }

        return $this->createQueryBuilder('e')
            ->andWhere('e.parent = :parent')
            ->setParameter('parent', $parent)
        ;
    }
}
