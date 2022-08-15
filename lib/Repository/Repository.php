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

/**
 * @template T of object
 * @template-extends ServiceEntityRepository<T>
 */
class Repository extends ServiceEntityRepository implements RepositoryInterface
{
    private static bool $autoFlush = true;
    private static int $nbToFlush = 0;

    public function add(object $entity): void
    {
        $this->getEntityManager()->persist($entity);
        ++self::$nbToFlush;

        if (self::$autoFlush) {
            $this->flush();
        }
    }

    public function remove(object $entity): void
    {
        $this->getEntityManager()->remove($entity);
        ++self::$nbToFlush;

        if (self::$autoFlush) {
            $this->flush();
        }
    }

    public function flush(): void
    {
        self::$nbToFlush = 0;
        $this->getEntityManager()->flush();
    }

    public function startAutoFlush(): void
    {
        $this->autoFlush = true;
    }

    public function stopAutoFlush(): void
    {
        $this->autoFlush = false;
    }
}
