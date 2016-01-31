<?php

namespace Application\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Application\Entity\User;

class LoadUser implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /** @var $user1 \Application\Entity\User */
        $user1 = new User();
        $user1->setUsername('Ila Best')
             ->setEmail('feugiat.nec@Lorem.org')
             ->setPassword(rand());
        $manager->persist($user1);

        $user2 = new User();
        $user2->setUsername('Honorato Navarro')
            ->setEmail('nunc.interdum@adipiscing.org')
            ->setPassword(rand());
        $manager->persist($user2);

        $user3 = new User();
        $user3->setUsername('Reuben Ross')
            ->setEmail('nunc.interdum@adipiscing.org')
            ->setPassword(rand());
        $manager->persist($user3);

        $user4 = new User();
        $user4->setUsername('Buckminster Patel')
            ->setEmail('lobortis@euultricessit.com')
            ->setPassword(rand());
        $manager->persist($user4);

        $user5 = new User();
        $user5->setUsername('Kaitlin Pearson')
            ->setEmail('pede.sagittis@orciPhasellusdapibus.edu')
            ->setPassword(rand());
        $manager->persist($user5);

        $user6 = new User();
        $user6->setUsername('Devin Carson')
            ->setEmail('enim.nec@fringilla.co.uk')
            ->setPassword(rand());
        $manager->persist($user6);

        $user7 = new User();
        $user7->setUsername('Peter James')
            ->setEmail('non.nisi.Aenean@egestas.ca')
            ->setPassword(rand());
        $manager->persist($user7);

        $user8 = new User();
        $user8->setUsername('Carol Burgess')
            ->setEmail('ornare.tortor@idante.co.uk')
            ->setPassword(rand());
        $manager->persist($user8);

        $user9 = new User();
        $user9->setUsername('Walter Mccormick')
            ->setEmail('urna@urnaNuncquis.net')
            ->setPassword(rand());
        $manager->persist($user9);

        $user10 = new User();
        $user10->setUsername('Stuart Grant')
            ->setEmail('velit.Cras.lorem@habitantmorbi.com')
            ->setPassword(rand());
        $manager->persist($user10);

        $manager->flush();
    }
}