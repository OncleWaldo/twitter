<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\City;




class CityFixtures extends Fixture 
{


    public function load(ObjectManager $manager)

    {

        $city = new City;
        $city->setName("Paris");
        $city->setZipCode(75000);
        $this->addReference("Paris", $city);
        $manager->persist($city);


        $city = new City;
        $city->setName("Périgueux");
        $city->setZipCode(24000);
        $this->addReference("Périgueux", $city);
        $manager->persist($city);
        
        $manager->flush();
        
    }
    
}