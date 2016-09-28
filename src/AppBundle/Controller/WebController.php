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
        return $this->render('web/index.html.twig', array(
			
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
		
		return $this->render('layout/web/aside.html.twig', array(
			'setting' => $setting,
			'categories' => $categories
		));
	}
}
