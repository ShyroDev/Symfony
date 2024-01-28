<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PropertyFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i < 100; $i++)
        {
            $property = new Property();

            $image = 'public/images/properties/empty.jpg';

            $property
                ->setTitle($faker->words(4, true))
                ->setDescription($faker->sentences(5, true))
                ->setSurface($faker->numberBetween(50,500))
                ->setRooms($faker->numberBetween(5,10))
                ->setBedrooms($faker->numberBetween(5,10))
                ->setFloor($faker->numberBetween(5,10))
                ->setPrice($faker->numberBetween(50000,10000000))
                ->setCity($faker->city)
                ->setAdress($faker->address)
                ->setZipcode($faker->postcode)
                ->setSold(false);

            $manager->persist($property);
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
