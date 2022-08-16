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

namespace App\Repository;

use App\Entity\Father;
use App\Entity\Son;
use Doctrine\Persistence\ManagerRegistry;
use Mazarini\ToolsBundle\Repository\ChildRepositoryAbstract;

/**
 * @extends ChildRepositoryAbstract<Son,Father>
 *
 * @method Son|null find($id, $lockMode = null, $lockVersion = null)
 * @method Son|null findOneBy(array $criteria, array $orderBy = null)
 * @method Son[]    findAll()
 * @method Son[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SonRepository extends ChildRepositoryAbstract
{
    public function __construct(ManagerRegistry $registry, FatherRepository $fatherRepository)
    {
        parent::__construct($registry, $fatherRepository, Son::class);
    }

    protected function createNew(): Son
    {
        return new Son();
    }
}
