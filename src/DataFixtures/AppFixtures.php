<?php

namespace App\DataFixtures;

use App\Entity\Food;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $f1 = new Food();
        $f1->setName("carotte")
            ->setPrice(1.80)
            ->setImage("food/carrots.png")
            ->setCalorie(36)
            ->setProtein(0.77)
            ->setCarbohydrate(6.45)
            ->setLipid(0.26);
        $manager->persist($f1);

        $f2 = new Food();
        $f2->setName("pomme de terre")
            ->setPrice(1.50)
            ->setImage("food/potatoes.png")
            ->setCalorie(80)
            ->setProtein(1.80)
            ->setCarbohydrate(16.7)
            ->setLipid(0.34);
        $manager->persist($f2);

        $f3 = new Food();
        $f3->setName("tomate")
            ->setPrice(2.30)
            ->setImage("food/tomatoes.png")
            ->setCalorie(18)
            ->setProtein(0.86)
            ->setCarbohydrate(2.26)
            ->setLipid(0.24);
        $manager->persist($f3);

        $f4 = new Food();
        $f4->setName("pomme")
            ->setPrice(2.35)
            ->setImage("food/apples.png")
            ->setCalorie(52)
            ->setProtein(0.25)
            ->setCarbohydrate(11.6)
            ->setLipid(0.25);
        $manager->persist($f4);

        $manager->flush();
    }
}
