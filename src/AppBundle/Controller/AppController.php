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
}
