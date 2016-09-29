<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class WebController extends Controller
{
    /**
     * @Route("/", name="web_index")
     */
    public function indexAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		
		$setting = $em
			->getRepository('AppBundle:Setting')
			->findAll()[0];
		
		$modelRecent = $em
			->getRepository('AppBundle:Model')
			->findOneBy(
				array(
					'setting' => $setting,
					'modelType' => 1
				)
			);

		$posts = new \stdClass;
		$posts->recent = $em
			->getRepository('AppBundle:Post')
			->findRecents();

        return $this->render('web/index.html.twig', array(
			'modelRecent' => $modelRecent,
			'posts' => $posts
		));
    }
	
	public function asideAction()
	{
		$setting = $this->getDoctrine()->getManager()
			->getRepository('AppBundle:Setting')
			->findAll()[0];

		$categories = $this->getDoctrine()->getManager()
			->getRepository('AppBundle:Category')
			->findAll();
		
		$socials = $this->getDoctrine()->getManager()
			->getRepository('AppBundle:Social')
			->findBySetting($setting);
		
		return $this->render('layout/web/aside.html.twig', array(
			'setting' => $setting,
			'categories' => $categories,
			'socials' => $socials
		));
	}
	
	public function headerAction()
	{
		$setting = $this->getDoctrine()->getManager()
			->getRepository('AppBundle:Setting')
			->findAll()[0];

		$socials = $this->getDoctrine()->getManager()
			->getRepository('AppBundle:Social')
			->findBySetting($setting);

		return $this->render('layout/web/header.html.twig', array(
			'setting' => $setting,
			'socials' => $socials
		));
	}
	
	public function sliderAction()
	{
		$setting = $this->getDoctrine()->getManager()
			->getRepository('AppBundle:Setting')
			->findAll()[0];

		return $this->render('layout/web/slider.html.twig', array(
			'setting' => $setting
		));
	}
	
	public function footerAction()
	{
		$setting = $this->getDoctrine()->getManager()
			->getRepository('AppBundle:Setting')
			->findAll()[0];

		return $this->render('layout/web/footer.html.twig', array(
			'setting' => $setting
		));
	}
}
