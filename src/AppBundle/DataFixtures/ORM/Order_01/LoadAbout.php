<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadAbout extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getOrder()
    {
        return 1;
    }

    public function load(ObjectManager $manager)
    {
		$about = $this->container->get('app.about.factory')->create()
            ->setAvatar('default.jpg')
            ->setLabel('Lorem Smith')
            ->setDescription('Lorem ipsum dolor sit amet, consecteturs adipisicing elit, sed do eiusmod tempor incididunt labore et dolore aliqua. Ut enim ad minim veniam.');
        $manager->persist($about);
        $manager->flush();

		$this->addReference('about', $about);
    }
}