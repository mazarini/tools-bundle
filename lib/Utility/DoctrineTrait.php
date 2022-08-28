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

namespace Mazarini\ToolsBundle\Utility;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Persistence\ObjectManager;
use UnexpectedValueException;

trait DoctrineTrait
{
    private ObjectManager $objectManager;

    protected function persist(object $object): ObjectManager
    {
        $this->getObjectManager()->persist($object);

        return $this->getRegistry()->getManager();
    }

    protected function remove(object $object): ObjectManager
    {
        $this->getObjectManager()->remove($object);

        return $this->getRegistry()->getManager();
    }

    /**
     * @return void
     */
    protected function flush()
    {
        $this->getObjectManager()->flush();
    }

    protected function getObjectManager(): ObjectManager
    {
        if (!isset($this->objectManager)) {
            $this->objectManager = $this->getRegistry()->getManager();
        }

        return $this->objectManager;
    }

    protected function getRegistry(): Registry
    {
        $registry = $this->container->get('doctrine');
        if ($registry instanceof Registry) {
            return $registry;
        }

        throw new UnexpectedValueException('Doctrine is not in container.');
    }
}
