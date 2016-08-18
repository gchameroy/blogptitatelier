<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AppController extends Controller
{
    /**
     * @Route("/manager", name="app_index")
     */
    public function indexAction()
    {
        return $this->render('app/index.html.twig');
    }
	
	/**
     * @Route("/manager/settings", name="app_setting_index")
     */
    public function settingAction()
    {
		$setting = $this->getDoctrine()->getManager()
			->getRepository('AppBundle:Setting')
			->findAll()[0];
		
        return $this->render('app/setting/index.html.twig', array(
			'setting' => $setting
		));
    }

	/**
     * @Route("/manager/settings/about/avatar", name="app_setting_about_avatar")
     */
    public function settingAboutAvatarAction(Request $request)
    {
		$avatar = $request->files->get('avatar');
		$targetDir = $this->getParameter('avatar_directory');
		$fileName = $this->get('app.photo_uploader')->uploadAvatar($avatar, $targetDir);
		
		$em = $this->getDoctrine()->getManager();
		
		$setting = $em
			->getRepository('AppBundle:Setting')
			->findAll()[0];

		$about = $this->get('app.about.factory')->create()
            ->setAvatar($fileName)
            ->setLabel($setting->getAbout()->getLabel())
            ->setDescription($setting->getAbout()->getDescription());
        $em->persist($about);
		
		$setting->setAbout($about)
			->setUpdatedAt(new \DateTime());
		$em->persist($setting);
		
        $em->flush();

       return $this->redirect($this->generateUrl('app_setting_index') . '#about');
    }

	/**
     * @Route("/manager/settings/about", name="app_setting_about")
     */
    public function settingAboutAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		
		$setting = $em
			->getRepository('AppBundle:Setting')
			->findAll()[0];

		$about = $this->get('app.about.factory')->create()
            ->setAvatar($setting->getAbout()->getAvatar())
            ->setLabel($request->request->get('label'))
            ->setDescription($request->request->get('description'));
        $em->persist($about);
		
		$setting->setAbout($about)
			->setUpdatedAt(new \DateTime());
		$em->persist($setting);
		
        $em->flush();

       return $this->redirect($this->generateUrl('app_setting_index') . '#about');
    }

	/**
     * @Route("/manager/settings/header/favicon", name="app_setting_header_favicon")
     */
    public function settingHeaderFaviconAction(Request $request)
    {
		$favicon = $request->files->get('favicon');
		$targetDir = $this->getParameter('favicon_directory');
		$fileName = $this->get('app.photo_uploader')->uploadFavicon($favicon, $targetDir);
		
		$em = $this->getDoctrine()->getManager();
		
		$setting = $em
			->getRepository('AppBundle:Setting')
			->findAll()[0];

		$header = $this->get('app.header.factory')->create()
            ->setFavicon($fileName)
            ->setLogo($setting->getHeader()->getLogo())
            ->setBanner($setting->getHeader()->getBanner());
        $em->persist($header);
		
		$setting->setHeader($header)
			->setUpdatedAt(new \DateTime());
		$em->persist($setting);
		
        $em->flush();

       return $this->redirect($this->generateUrl('app_setting_index') . '#header');
    }

	/**
     * @Route("/manager/settings/header/logo", name="app_setting_header_logo")
     */
    public function settingHeaderLogoAction(Request $request)
    {
		$logo = $request->files->get('logo');
		$targetDir = $this->getParameter('logo_directory');
		$fileName = $this->get('app.photo_uploader')->uploadLogo($logo, $targetDir);
		
		$em = $this->getDoctrine()->getManager();
		
		$setting = $em
			->getRepository('AppBundle:Setting')
			->findAll()[0];

		$header = $this->get('app.header.factory')->create()
            ->setFavicon($setting->getHeader()->getFavicon())
            ->setLogo($fileName)
            ->setBanner($setting->getHeader()->getBanner());
        $em->persist($header);
		
		$setting->setHeader($header)
			->setUpdatedAt(new \DateTime());
		$em->persist($setting);
		
        $em->flush();

       return $this->redirect($this->generateUrl('app_setting_index') . '#header');
    }

	/**
     * @Route("/manager/settings/header/banner", name="app_setting_header_banner")
     */
    public function settingHeaderBannerAction(Request $request)
    {
		$banner = $request->files->get('banner');
		$targetDir = $this->getParameter('banner_directory');
		$fileName = $this->get('app.photo_uploader')->uploadBanner($banner, $targetDir);
		
		$em = $this->getDoctrine()->getManager();
		
		$setting = $em
			->getRepository('AppBundle:Setting')
			->findAll()[0];

		$header = $this->get('app.header.factory')->create()
            ->setFavicon($setting->getHeader()->getFavicon())
            ->setLogo($setting->getHeader()->getLogo())
            ->setBanner($fileName);
        $em->persist($header);
		
		$setting->setHeader($header)
			->setUpdatedAt(new \DateTime());
		$em->persist($setting);
		
        $em->flush();

       return $this->redirect($this->generateUrl('app_setting_index') . '#header');
    }
	
	/**
     * @Route("/manager/categories", name="app_category_index")
     */
    public function categoryAction()
    {
		$categories = $this->getDoctrine()->getManager()
			->getRepository('AppBundle:Category')
			->findAll();
		
        return $this->render('app/category/index.html.twig', array(
			'categories' => $categories
		));
    }
	
	/**
     * @Route("/manager/category/modal/add", name="app_category_modal_add")
     */
    public function categoryModalAddAction()
    {
        return $this->render('app/category/modal/add.html.twig');
    }

	/**
     * @Route("/manager/category/add", name="app_category_add")
     */
    public function categoryAddAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		
		$categories = $em
			->getRepository('AppBundle:Category')
			->findAll();

		$category = $this->get('app.category.factory')->create()
            ->setLabel($request->request->get('label'))
			->setOrder(count($categories) + 1);
        $em->persist($category);
        $em->flush();
		
        return $this->redirect($this->generateUrl('app_category_index'));
    }

	/**
     * @Route("/manager/category/delete", name="app_category_delete")
     */
    public function categoryDeleteAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		
		$repository = $em->getRepository('AppBundle:Category');
		$category = $repository->findOneById($request->request->get('id'));

		$em->remove($category);
		$em->flush();

        $response = new JsonResponse();
		return $response->setData(array(
			'valid' => true
		));
    }
	
	/**
     * @Route("/manager/category/modal/update", name="app_category_modal_update")
     */
    public function categoryModalUpdateAction(Request $request)
    {
		$category = $this->getDoctrine()->getManager()
			->getRepository('AppBundle:Category')
			->findOneById($request->query->get('id'));
        
		return $this->render('app/category/modal/update.html.twig', array(
			'category' => $category
		));
    }

	/**
     * @Route("/manager/category/update", name="app_category_update")
     */
    public function categoryUpdateAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		
		$repository = $em->getRepository('AppBundle:Category');
		$category = $repository
			->findOneById($request->request->get('id'))
			->setLabel($request->request->get('label'));

		$em->persist($category);
		$em->flush();

        return $this->redirect($this->generateUrl('app_category_index'));
    }

	/**
     * @Route("/manager/category/show", name="app_category_show")
     */
    public function categoryShowAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		
		$repository = $em->getRepository('AppBundle:Category');
		$category = $repository
			->findOneById($request->request->get('id'))
			->setIsHidden(false);

		$em->persist($category);
		$em->flush();

        $response = new JsonResponse();
		return $response->setData(array(
			'valid' => true
		));
    }

	/**
     * @Route("/manager/category/hide", name="app_category_hide")
     */
    public function categoryHideAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		
		$repository = $em->getRepository('AppBundle:Category');
		$category = $repository
			->findOneById($request->request->get('id'))
			->setIsHidden(true);

		$em->persist($category);
		$em->flush();

        $response = new JsonResponse();
		return $response->setData(array(
			'valid' => true
		));
    }
}
