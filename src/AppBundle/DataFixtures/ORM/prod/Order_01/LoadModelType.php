<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadModelType extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
		$labels = ['Recent', 'Popular', 'Week choice'];
		$i = 1;
		foreach($labels As $label){
			$modelType = $this->container->get('app.modelType.factory')->create()
				->setId($i)
				->setLabel($label);
			$manager->persist($modelType);
			$manager->flush();
			$this->addReference('modelType-'.$i, $modelType);
			$i++;
		}
    }
}