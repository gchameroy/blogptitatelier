<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadModel extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        return 3;
    }

    public function load(ObjectManager $manager)
    {
		for($i = 1; $i <= 3; $i++){
			$model = $this->container->get('app.model.factory')->create()
				->setColumns(array(12,6,6))
				->setOrder($i)
				->setIsVisible(true)
				->setSetting($this->getReference('setting-1'))
				->setModelType($this->getReference('modelType-'.$i));
			$manager->persist($model);
			$manager->flush();

			$this->addReference('model-' . $i, $model);
		}
    }
}