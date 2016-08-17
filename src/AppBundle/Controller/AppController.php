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
}
