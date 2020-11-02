<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;



class UserFixtures extends Fixture implements DependentFixtureInterface
{
    
    protected $faker;

    public function load(ObjectManager $manager)
    {   
        $this->manager = $manager;
        $this->faker = Factory::create();
        for ($i = 0; $i < 20; $i++) {
            
            $user = new User();
            $user->setfirstName($this->faker->firstName);
            $user->setlastName($this->faker->lastName);
            $user->setEmail($this->faker->email);
            $user->setPassword($this->faker->lastName);
            $user->setPhone($this->faker->lastName);
            $user->setAge($this->faker->lastName);
            $user->setCreatedAt( new \dateTime());
            $user->setCityId($this->getReference(CityFixtures::FIRST_CITY));

            $manager->persist($user);
        }

           $manager->flush();
    }
    public function getDependencies()
    {
        return [
            CityFixture::class,
        ];
    }
}
