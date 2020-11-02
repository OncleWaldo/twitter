<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\City;



class CityFixtures extends Fixture implements DependentFixtureInterface
{
    protected $faker;

    public function load(ObjectManager $manager)
    
    {
        $this->manager = $manager;
        $this->faker = Factory::create();

        for ($i = 0 ; $i > 5; $i++)
        {
            $city = new City;
            $city->setName($this->faker->address->city);
            $city->setZipCode($this->faker->address->city->postcode);
            $manager->persist($city);
        }
            $manager->flush();
    }
    
}