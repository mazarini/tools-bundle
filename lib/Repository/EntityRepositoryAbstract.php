<?php

/*
 * Copyright (C) 2019-2020 Mazarini <mazarini@protonmail.com>.
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

namespace Mazarini\ToolsBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Mazarini\ToolsBundle\Entity\EntityInterface;
use Mazarini\ToolsBundle\Pagination\Pagination;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
abstract class EntityRepositoryAbstract extends ServiceEntityRepository
{
    public function getPage(int $currentPage = 1, int $pageSize = 10): Pagination
    {
        $totalCount = $this->totalCount();
        $result = [];
        $current = Pagination::CURRENT_PAGE($currentPage, $pageSize, $totalCount);
        if ((0 < $totalCount) && ($current === $currentPage)) {
            $result = $this->getResult(($currentPage - 1) * $pageSize, $pageSize);
        }

        return new Pagination(new \ArrayIterator($result), $current, $totalCount, $pageSize);
    }

    /**
     * totalCount.
     */
    abstract protected function totalCount(): int;

    /**
     * getResult.
     *
     * @return array<int, EntityInterface>
     */
    abstract protected function getResult(int $start, int $pageSize): array;
}
