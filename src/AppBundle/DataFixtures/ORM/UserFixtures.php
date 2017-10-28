<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $um = $this->container->get('fos_user.user_manager.default');

        $manager->persist(
            $um
                ->createUser()
                ->setUsername('admin')
                ->setEmail('admin@example.com')
                ->addRole('ROLE_ADMIN')
                ->setPlainPassword('admin')
        );

        $manager->flush();
    }
}