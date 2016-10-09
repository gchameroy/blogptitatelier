<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadSocialType extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
		$socialType_1 = $this->container->get('app.socialType.factory')->create()
			->setId(1)
			->setLabel('Facebook')
			->setIcon('facebook');
		$manager->persist($socialType_1);
		
		$socialType_2 = $this->container->get('app.socialType.factory')->create()
			->setId(2)
			->setLabel('Twitter')
			->setIcon('twitter');
		$manager->persist($socialType_2);
		
		$socialType_3 = $this->container->get('app.socialType.factory')->create()
			->setId(3)
			->setLabel('Google Plus')
			->setIcon('google-plus');
		$manager->persist($socialType_3);
		
		$socialType_4 = $this->container->get('app.socialType.factory')->create()
			->setId(4)
			->setLabel('Pinterest')
			->setIcon('pinterest');
		$manager->persist($socialType_4);
		
		$socialType_5 = $this->container->get('app.socialType.factory')->create()
			->setId(5)
			->setLabel('Dribbble')
			->setIcon('dribbble');
		$manager->persist($socialType_5);
		
		$socialType_6 = $this->container->get('app.socialType.factory')->create()
			->setId(6)
			->setLabel('Instagram')
			->setIcon('instagram');
		$manager->persist($socialType_6);

		$manager->flush();
		$this->addReference('socialType-1', $socialType_1);
		$this->addReference('socialType-2', $socialType_2);
		$this->addReference('socialType-3', $socialType_3);
		$this->addReference('socialType-4', $socialType_4);
		$this->addReference('socialType-5', $socialType_5);
		$this->addReference('socialType-6', $socialType_6);
    }
}