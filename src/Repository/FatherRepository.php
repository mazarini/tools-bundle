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
use Doctrine\Persistence\ManagerRegistry;
use Mazarini\ToolsBundle\Entity\EntityInterface;
use Mazarini\ToolsBundle\Repository\EntityRepositoryAbstract;

/**
 * @template-extends  EntityRepositoryAbstract<Father>
 *
 * @method Father      getNew($id)
 * @method Father|null find($id, $lockMode = null, $lockVersion = null)
 * @method Father|null findOneBy(array $criteria, array $orderBy = null)
 * @method Father[]    findAll()
 * @method Father[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FatherRepository extends EntityRepositoryAbstract
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Father::class);
    }

    /**
     * @return Father
     */
    protected function createNew(): EntityInterface
    {
        return new Father();
    }
}
