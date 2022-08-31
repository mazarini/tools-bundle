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

namespace App\DataFixtures;

use App\Entity\Father;
use App\Entity\Grand;
use App\Entity\Son;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GrandFixtures extends Fixture
{
    protected ObjectManager $manager;

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        for ($i = 1; $i < 21; ++$i) {
            $this->loadGrand($i);
        }
        $manager->flush();
    }

    protected function loadGrand(int $i): void
    {
        $grand = new Grand();
        $grand->setLabelGrand(sprintf('G-%d', $i));
        $this->manager->persist($grand);
        $this->manager->flush();
        for ($j = 1; $j < 21 + $i; ++$j) {
            $this->loadFather($grand, $i, $j);
        }
    }

    protected function loadFather(Grand $grand, int $i, int $j): void
    {
        $father = new Father();
        $father->setLabelFather(sprintf('G-%d-F-%d', $i, $j));
        $father->setParent($grand);
        $this->manager->persist($father);
        $this->manager->flush();
        for ($k = 1; $k < 21 + $j; ++$k) {
            $this->loadSon($father, $i, $j, $k);
        }
    }

    protected function loadSon(Father $father, int $i, int $j, int $k): void
    {
        $son = new Son();
        $son->setLabelSon(sprintf('G-%d-F-%d-S-%d', $i, $j, $k));
        echo $son->getLabelSon(),"\n";
        $son->setParent($father);
        $this->manager->persist($son);
        $this->manager->flush();
    }
}
