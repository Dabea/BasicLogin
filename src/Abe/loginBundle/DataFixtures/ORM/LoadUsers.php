<?php

namespace Abe\loginBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Abe\loginBundle\Entity\user2;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUsers implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function load(ObjectManager $manager)
    {
        $user = new user2();
        $user->setUsername('darth');
        $user->setPassword($this->encodePassword($user, 'darthpass'));
        #$user->setEmail('darth@deathstar.com');
        $manager->persist($user);

        $admin = new user2();
        $admin->setUsername('wayne');
        $admin->setPassword($this->encodePassword($admin, 'waynepass'));
        
        #$admin->setEmail('wayne@deathstar.com');
        $manager->persist($admin);

        // the queries aren't done until now
        $manager->flush();
    }

    private function encodePassword(user2 $user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user)
        ;

        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
