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
		$socials = array(
			['You Tube', 'youtube'],
			['Facebook', 'facebook'],
			['Twitter', 'twitter'],
			['Google Plus', 'google-plus'],
			['Pinterest', 'pinterest'],
			['Dribbble', 'dribbble'],
			['Instagram', 'instagram']
		);
		
		$i = 1;
		foreach($socials As $social){
			$socialType = $this->container->get('app.socialType.factory')->create()
				->setId($id)
			->setLabel($social[0])
			->setIcon($social[1]);
			$manager->persist($social);
			$this->addReference('socialType-' . $i, $socialType);
		}
		
		$manager->flush();
    }
}