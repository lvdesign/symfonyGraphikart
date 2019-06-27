<?php

namespace App\DataFixtures;

use App\DataFixtures\Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Property;

class PropertyFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
 //Utilisation de Faker
 // php composer.phar require fzaninotto/faker --dev
 $faker = \Faker\Factory::create('fr_FR');
        for ( $i=0; $i < 100; $i++){

            $property = new Property();
            $property
                ->setTitle($faker->words(3,true))
                ->setDescription($faker->sentences(3,true))
                ->setSurface($faker->numberBetween(20,350))
                ->setRooms($faker->numberBetween(2,7))
                ->setBedrooms($faker->numberBetween(1,4))
                ->setFloor($faker->numberBetween(0,6))
                ->setPrice($faker->numberBetween(100000,800000))
                ->setHeat($faker->numberBetween(0, count(Property::HEAT) - 1) )
                ->setCity($faker->city)
                ->setAddress($faker->address)
                ->setPostalCode($faker->postcode)
                ->setSold(false)
                ;
            $manager->persist($property);

        }

        $manager->flush();
    }
}
