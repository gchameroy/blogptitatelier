<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadCategory extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
		$labels = ['POKEMON GO', 'HARRY POTTER', 'DISNEY'];
		$i = 1;
		foreach($labels As $label){
			$category = $this->container->get('app.category.factory')->create()
				->setLabel($label)
				->setOrderId($i);
			$manager->persist($category);
			$manager->flush();
			$this->addReference('category-'.$i, $category);
			$i++;
		}
    }
}