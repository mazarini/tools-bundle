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
use Mazarini\ToolsBundle\Paginator\Pagination;
use Mazarini\ToolsBundle\Paginator\PaginationInterface;
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

    /**
     * Undocumented function.
     *
     * @param array<string>        $conditions
     * @param array<string,mixed>  $parameters
     * @param array<string,string> $orderBy
     */
    public function getPage(int $currentPage = 1, array $conditions = [], array $parameters = [], array $orderBy = [], int $pageSize = 10): PaginationInterface
    {
        $totalCount = $this->totalCount($conditions, $parameters);
        $pagination = new Pagination($totalCount, $currentPage, $pageSize);
        if ($pagination->isCurrentPageOk() && $totalCount > 0) {
            $pagination->setEntities($this->getResult($conditions, $parameters, $orderBy, $pagination->getStart(), $pagination->getLimit()));
        }

        return $pagination;
    }

    /**
     * Undocumented function.
     *
     * @param array<string>       $conditions
     * @param array<string,mixed> $parameters
     */
    protected function totalCount(array $conditions = [], array $parameters = []): int
    {
        $count = $this->getPageQueryBuilder($conditions, $parameters)
                ->select('count(e.id)')
                ->getQuery()
                ->getSingleScalarResult();

        if (\is_int($count)) {
            return $count;
        }

        throw new TypeError('Count(*) is not an integer!');
    }

    /**
     * @param array<string>        $conditions
     * @param array<string,mixed>  $parameters
     * @param array<string,string> $orderBy
     *
     * @return array<int, mixed>
     */
    protected function getResult(array $conditions, array $parameters, array $orderBy, int $start, int $limit): array
    {
        $builder = $this->getPageQueryBuilder($conditions, $parameters);

        foreach ($orderBy as $column => $direction) {
            $builder->addOrderBy('e.'.$column, $direction);
        }

        $builder
            ->addOrderBy('e.id', 'asc')
            ->setFirstResult($start)
            ->setMaxResults($limit)
        ;

        $result = $builder->getQuery()->getResult();

        if (\is_array($result)) {
            return $result;
        }

        throw new TypeError('Result is not an array.');
    }

    /**
     * @param array<string>       $conditions
     * @param array<string,mixed> $parameters
     */
    protected function getPageQueryBuilder(array $conditions, array $parameters): QueryBuilder
    {
        $builder = $this->createQueryBuilder('e');

        foreach ($conditions as $condition) {
            $builder->andWhere($condition);
        }

        if (0 === \count($conditions)) {
            foreach ($parameters as $parameter => $value) {
                $builder->andWhere(sprintf('e.%s = :%s', $parameter, $parameter));
            }
        }

        foreach ($parameters as $parameter => $value) {
            $builder->setParameter($parameter, $value);
        }

        return $builder;
    }
}
