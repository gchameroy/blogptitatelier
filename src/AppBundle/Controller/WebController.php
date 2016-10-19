<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WebController extends Controller
{
    /**
     * @Route("/", name="web_home")
     */
    public function homeAction()
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
		

        return $this->render('web/home/index.html.twig', array(
			'modelRecent' => $modelRecent,
			'posts' => $posts
		));
    }
	
	public function homeSelectionAction()
	{
		$em = $this->getDoctrine()->getManager();
		
		$setting = $em
			->getRepository('AppBundle:Setting')
			->findAll()[0];
		
		$model = $em
			->getRepository('AppBundle:Model')
			->findOneBy(
				array(
					'setting' => $setting,
					'modelType' => 3
				)
			);
			
		dump($model);
		
		$selections = $em
			->getRepository('AppBundle:PostSelection')
			->findSelections();
		
		return $this->render('web/home/selection.html.twig', array(
			'model' => $model,
			'selections' => $selections
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

    /**
     * @Route("/articles/{slug}", name="web_post_view")
     */
    public function postViewAction($slug)
    {
		$em = $this->getDoctrine()->getManager();

		$setting = $em
			->getRepository('AppBundle:Setting')
			->findAll()[0];

		$post = $em
			->getRepository('AppBundle:Post')
			->findOneBySlug($slug);

        return $this->render('web/post/view.html.twig', array(
			'post' => $post,
			'setting' => $setting
		));
    }
	
	/**
     * @Route("/articles/{page}", name="web_post_index", requirements={"page": "\d+"})
     */
    public function postIndexAction($page = 1)
    {
		$em = $this->getDoctrine()->getManager();

		$posts = $em
			->getRepository('AppBundle:Post')
			->findByPage($page);

        return $this->render('web/post/index.html.twig', array(
			'posts' => $posts,
			'page' => $page
		));
    }
}
