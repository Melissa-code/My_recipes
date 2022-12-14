<?php

namespace App\DataFixtures;

use App\Entity\Food;
use App\Entity\Type;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $t1 = new Type();
        $t1->setName("fruits")
            ->setImage("fruit.png");
        $manager->persist($t1);

        $t2 = new Type();
        $t2->setName("légumes")
            ->setImage("vegetable.png");
        $manager->persist($t2);


        $foodRepository = $manager->getRepository(Food::class);
        $f1 = $foodRepository->findOneBy(["name" => "banane"]);
        $f1->setType($t1);
        $manager->persist($f1);

        $foodRepository = $manager->getRepository(Food::class);
        $f2 = $foodRepository->findOneBy(["name" => "tomate"]);
        $f2->setType($t1);
        $manager->persist($f2);

        $foodRepository = $manager->getRepository(Food::class);
        $f3 = $foodRepository->findOneBy(["name" => "pomme"]);
        $f3->setType($t1);
        $manager->persist($f3);

        $foodRepository = $manager->getRepository(Food::class);
        $f4 = $foodRepository->findOneBy(["name" => "pomme de terre"]);
        $f4->setType($t2);
        $manager->persist($f4);

        $manager->flush();
    }
}
