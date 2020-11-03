<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;



class UserFixtures extends Fixture implements DependentFixtureInterface
{
    
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
         $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {   
        $user = new User();
        $user->setfirstName("tony");
        $user->setlastName("dupond");
        $user->setEmail("admin@email.fr");
        $user->setPassword($this->passwordEncoder->encodePassword($user,'admin'));
        $user->setPhone("0505050505");
        $user->setAge(18);
        $user->setRoles(["ROLE_ADMIN"]); 
        $user->setCreatedAt( new \DateTime("2020-11-01 08:00"));
        $user->setCityId($this->getReference("Paris"));
        $this->addReference("admin@email.fr", $user);

        $manager->persist($user);

        $user2 = new User();
        $user2->setfirstName("jean");
        $user2->setlastName("PETITPIED");
        $user2->setEmail("user@email.fr");
        $user2->setPassword($this->passwordEncoder->encodePassword($user2,'user'));
        $user2->setPhone("0606060606");
        $user2->setAge(25);
        $user2->setRoles(["ROLE_USER"]); 
        $user2->setCreatedAt( new \DateTime("2020-11-01 08:00"));
        $user2->setCityId($this->getReference("Périgueux"));
        $this->addReference("user@email.fr", $user2);

        $manager->persist($user2);
    

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CityFixtures::class,
        ];
    }
}
