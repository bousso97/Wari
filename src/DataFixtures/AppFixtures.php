<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{   
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $supAdmin = new Role();
        $supAdmin->setLibelle("ROLE_SUP_ADMIN");
        $manager->persist($supAdmin);
        

        $this->addReference('role_sup_admin', $supAdmin);
       
        $rolAdmin = $this->getReference('role_sup_admin'); 
        $user = new Users();
        $user->setEmail("diarra@gmail.com");
        $user->setPassword($this->passwordEncoder->encodePassword($user, "diarra"));
        $user->setRoles(["ROLE_SUP_ADMIN"]);
        $user->setRole($rolAdmin);
        $user->setUsername("diarra");

        $manager->persist($user);
        $manager->flush();
    }
}
