<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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

		$selections = $em
			->getRepository('AppBundle:PostSelection')
			->findSelections();
		
		return $this->render('web/home/selection.html.twig', array(
			'model' => $model,
			'selections' => $selections
		));
	}
	
	public function homeRecentAction()
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
					'modelType' => 1
				)
			);

		$posts = $em
			->getRepository('AppBundle:Post')
			->findRecents();

		return $this->render('web/home/recent.html.twig', array(
			'model' => $model,
			'posts' => $posts
		));
	}

	public function faviconAction()
	{
		$setting = $this->getDoctrine()->getManager()
			->getRepository('AppBundle:Setting')
			->findAll()[0];

		return $this->render('layout/web/favicon.html.twig', array(
			'setting' => $setting
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
			
		$comments = $em
			->getRepository('AppBundle:Comment')
			->findAllValidate();

        return $this->render('web/post/view.html.twig', array(
			'post' => $post,
			'setting' => $setting,
			'comments' => $comments
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
	
	/**
     * @Route("/categories/{slug}", name="web_category_view")
     */
    public function categoryViewAction($slug)
    {
		$em = $this->getDoctrine()->getManager();

		$category = $em
			->getRepository('AppBundle:Category')
			->findOneBySlug($slug);

        return $this->render('web/category/view.html.twig', array(
			'category' => $category
		));
    }

	/**
     * @Route("/web/comment/add", name="web_comment_add")
	 * @Security("has_role('ROLE_USER')")
     */
    public function commentAddAction(Request $request)
    {
		$postId = $request->request->getInt('postId');
		$message = $request->request->get('message');
		
		$em = $this->getDoctrine()->getManager();

		$post = $em
			->getRepository('AppBundle:Post')
			->findOneById($postId);
		
		$comment = $this->get('app.comment.factory')->create()
			->setMessage($message)
			->setPost($post)
			->setUser($this->getUser());
		$em->persist($comment);
		$em->flush();

        $response = new JsonResponse();
		return $response->setData(array(
			'valid' => true
		));
    }
}
