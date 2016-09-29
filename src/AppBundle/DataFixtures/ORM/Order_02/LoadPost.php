<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadPost extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        return 2;
    }

    public function load(ObjectManager $manager)
    {
		$titles = ['Recycler ses vieilles coques de portable', 'Faire des pierres turquoises en fimo', 'Customiser les moules fait maison', 'Craft Room Tour - PtitAtelier'];
		$publishedAt = new \DateTime;
		
		$i = 1;
		foreach($titles As $title){
			$post = $this->container->get('app.post.factory')->create()
				->setTitle($title)
				->setCategory($this->getReference('category-'.rand(1,3)))
				->setPublishedAt($publishedAt);
			$manager->persist($post);
			$manager->flush();

			$this->addReference('post-' . $i, $post);
			$i++;
		}
    }
}