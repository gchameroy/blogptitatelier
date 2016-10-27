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
        return $this->render('app/home/index.html.twig');
    }
	
	/**
     * @Route("/manager/settings", name="app_setting_index")
     */
    public function settingAction()
    {
		return $this->redirect($this->generateUrl('app_setting_header_index'));
    }
	
	/**
     * @Route("/manager/settings/header", name="app_setting_header_index")
     */
    public function settingHeaderAction()
    {
		$setting = $this->getDoctrine()->getManager()
			->getRepository('AppBundle:Setting')
			->findAll()[0];

        return $this->render('app/setting/header.html.twig', array(
			'setting' => $setting
		));
    }
	
	/**
     * @Route("/manager/settings/about", name="app_setting_about_index")
     */
    public function settingAboutAction()
    {
		$setting = $this->getDoctrine()->getManager()
			->getRepository('AppBundle:Setting')
			->findAll()[0];

        return $this->render('app/setting/about.html.twig', array(
			'setting' => $setting
		));
    }
	
	/**
     * @Route("/manager/settings/model", name="app_setting_model_index")
     */
    public function settingModelAction()
    {
		$setting = $this->getDoctrine()->getManager()
			->getRepository('AppBundle:Setting')
			->findAll()[0];

        return $this->render('app/setting/model.html.twig', array(
			'setting' => $setting
		));
    }
	
	/**
     * @Route("/manager/settings/social", name="app_setting_social_index")
     */
    public function settingSocialAction()
    {
		$setting = $this->getDoctrine()->getManager()
			->getRepository('AppBundle:Setting')
			->findAll()[0];
		
		$socials = $this->getDoctrine()->getManager()
			->getRepository('AppBundle:Social')
			->findBySetting($setting);
		
		$ids = array();
		foreach($socials As $social){
			$ids[] = $social->getSocialType()->getId();
		}

		$socialTypes = $this->getDoctrine()->getManager()
			->getRepository('AppBundle:SocialType')
			->findAllWithoutIds($ids);

        return $this->render('app/setting/social.html.twig', array(
			'socials' => $socials,
			'socialTypes' => $socialTypes
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

       return $this->redirect($this->generateUrl('app_setting_about_index'));
    }

	/**
     * @Route("/manager/settings/about/edit", name="app_setting_about_edit")
     */
    public function settingAboutEditAction(Request $request)
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

       return $this->redirect($this->generateUrl('app_setting_about_index'));
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

       return $this->redirect($this->generateUrl('app_setting_header_index'));
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

       return $this->redirect($this->generateUrl('app_setting_header_index'));
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

       return $this->redirect($this->generateUrl('app_setting_header_index'));
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
	
	/**
     * @Route("/manager/posts", name="app_post_index")
     */
    public function postAction()
    {
		$posts = $this->getDoctrine()->getManager()
			->getRepository('AppBundle:Post')
			->findAll();
		
        return $this->render('app/post/index.html.twig', array(
			'posts' => $posts
		));
    }

	/**
     * @Route("/manager/posts/add", name="app_post_add")
     */
    public function postAddAction()
    {
		$post = $this->get('app.post.factory')->create();
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($post);
		$em->flush();
		
		return $this->redirect($this->generateUrl('app_post_view', array('id' => $post->getId())));
    }

	/**
     * @Route("/manager/posts/{id}/image", name="app_post_image")
     */
    public function postImageAction($id, Request $request)
    {
		

        $image = $request->files->get('image');
		$targetDir = $this->getParameter('post_directory');
		$fileName = $this->get('app.photo_uploader')->uploadPostImage($image, $targetDir);
		
		$em = $this->getDoctrine()->getManager();
		
		$post = $this->getDoctrine()->getManager()
			->getRepository('AppBundle:Post')
			->findOneById($id)
			->setImage($fileName);

		$em->persist($post);
        $em->flush();

		return $this->redirect($this->generateUrl('app_post_view', array('id' => $post->getId())));
    }
	
	/**
     * @Route("/manager/posts/{id}/category", name="app_post_category")
     */
    public function postCategoryAction($id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();

		$category = $em
			->getRepository('AppBundle:Category')
			->findOneById($request->request->get('category'));
		
		$post = $em
			->getRepository('AppBundle:Post')
			->findOneById($id)
			->setCategory($category);

		$em->persist($post);
		$em->flush();

        $response = new JsonResponse();
		return $response->setData(array(
			'valid' => true
		));
    }
	
	/**
     * @Route("/manager/posts/title", name="app_post_title")
     */
    public function postTitleAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();

		$post = $em
			->getRepository('AppBundle:Post')
			->findOneById($request->request->get('pk'))
			->setTitle($request->request->get('value'));

		$em->persist($post);
		$em->flush();

        $response = new JsonResponse();
		return $response->setData(array(
			'valid' => true
		));
    }
	
	/**
     * @Route("/manager/posts/description", name="app_post_description")
     */
    public function postDescriptionAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();

		$post = $em
			->getRepository('AppBundle:Post')
			->findOneById($request->request->get('pk'))
			->setDescription($request->request->get('value'));

		$em->persist($post);
		$em->flush();

        $response = new JsonResponse();
		return $response->setData(array(
			'valid' => true
		));
    }
	
	/**
     * @Route("/manager/posts/{id}", name="app_post_view")
     */
    public function postViewAction($id)
    {
		$em = $this->getDoctrine()->getManager();
		
		$post = $em
			->getRepository('AppBundle:Post')
			->findOneById($id);
		
		$categories = $this->getDoctrine()->getManager()
			->getRepository('AppBundle:Category')
			->findAll();
		
        return $this->render('app/post/edit.html.twig', array(
			'post' => $post,
			'categories' => $categories
		));
    }
	
	/**
     * @Route("/manager/posts/{id}/content", name="app_post_content")
     */
    public function postContentAction($id, Request $request)
    {
		$em = $this->getDoctrine()->getManager();

		$post = $em
			->getRepository('AppBundle:Post')
			->findOneById($id)
			->setContent($request->request->get('content'));
		$em->persist($post);
		$em->flush();

        $response = new JsonResponse();
		return $response->setData(array(
			'valid' => true
		));
    }
	
	/**
     * @Route("/manager/settings/model/edit", name="app_setting_model_edit")
     */
    public function postSettingModelEditAction(Request $request)
    {
		$columns = explode('-', $request->request->get('columns'));

		$em = $this->getDoctrine()->getManager();
		
		$setting = $em
			->getRepository('AppBundle:Setting')
			->findAll()[0];

		$modelType = $em
			->getRepository('AppBundle:ModelType')
			->findOneById($request->request->get('id_modelType'));

		$model = $em
			->getRepository('AppBundle:Model')
			->findOneBy(array(
				'setting' => $setting,
				'modelType' => $modelType
			))
			->setColumns($columns);
		$em->persist($model);
        $em->flush();

        $response = new JsonResponse();
		return $response->setData(array(
			'valid' => true
		));
    }
	
	/**
     * @Route("/manager/post/modal/publish", name="app_post_modal_publish")
     */
    public function postModalPublishAction(Request $request)
    {
        $post = $this->getDoctrine()->getManager()
			->getRepository('AppBundle:Post')
			->findOneById($request->query->get('id'));
		
		$publishedAt = new \DateTime();
		$publishedAt->add(new \DateInterval('P1D'));
        $post->setPublishedAt($publishedAt);
		
		return $this->render('app/post/modal/publish.html.twig', array(
			'post' => $post
		));
    }
	
	/**
     * @Route("/manager/post/publish", name="app_post_publish")
     */
    public function postPublishAction(Request $request)
    {
		$publishedAt = new \DateTime($request->request->get('publishedAt'));
		$em = $this->getDoctrine()->getManager();
		$post = $em
			->getRepository('AppBundle:Post')
			->findOneById($request->request->get('id'))
			->setPublishedAt($publishedAt);

		$em->persist($post);
		$em->flush();

        return $this->redirect($this->generateUrl('app_post_index'));
    }
	
	/**
     * @Route("/manager/post/publish/stop", name="app_post_publish_stop")
     */
    public function postPublishStopAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$post = $em
			->getRepository('AppBundle:Post')
			->findOneById($request->request->get('id'))
			->setPublishedAt(null);

		$em->persist($post);
		$em->flush();

        $response = new JsonResponse();
		return $response->setData(array(
			'valid' => true
		));
    }
	
	/**
     * @Route("/manager/settings/social/edit", name="app_setting_social_edit")
     */
    public function postSettingsSocialEditAction(Request $request)
    {
		$url = $request->request->get('url');
		$em = $this->getDoctrine()->getManager();
		
		$setting = $em
			->getRepository('AppBundle:Setting')
			->findAll()[0];

		$socialType = $em
			->getRepository('AppBundle:SocialType')
			->findOneById($request->request->get('id_socialType'));
		
		$social = $em
			->getRepository('AppBundle:Social')
			->findOneBy(
				array(
					'setting' => $setting,
					'socialType' => $socialType
				)
			);
		
		if(!$social){
			$social = $this->get('app.social.factory')->create()
				->setSetting($setting)
				->setSocialType($socialType);
		}

		if($url == ''){
			$em->remove($social);
		}
		else{
			$social->setUrl($url);
			$em->persist($social);
		}
		
		$em->flush();

        $response = new JsonResponse();
		return $response->setData(array(
			'valid' => true
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

		return $this->render('app/home/selection.html.twig', array(
			'selections' => $selections,
			'model' => $model
		));
	}
	
	/**
     * @Route("/manager/home/modal/selection", name="app_home_modal_selection")
     */
    public function homeModalSelectionAction(Request $request)
    {
		$orderId = $request->query->get('orderId');
		$em = $this->getDoctrine()->getManager();
		
		$posts = $em
			->getRepository('AppBundle:Post')
			->findByPage();

		return $this->render('app/home/modal/selection.html.twig', array(
			'orderId' => $orderId,
			'posts' => $posts
		));
    }
	
	/**
     * @Route("/manager/home/selection/add", name="app_home_selection_add")
     */
    public function homeSelectionAddAction(Request $request)
    {
		$orderId = $request->request->get('orderId');
		
		$em = $this->getDoctrine()->getManager();
		$postSelection = $em
			->getRepository('AppBundle:PostSelection')
			->findOneActiveByOrderId($request->request->get('orderId'));
		
		if($postSelection){
			$postSelection->setIsActive(false);
			$em->persist($postSelection);
		}
		
		$post = $em
			->getRepository('AppBundle:Post')
			->findOneById($request->request->get('postId'));

		$postSelection = $this->get('app.postSelection.factory')->create()
			->setOrderId($request->request->get('orderId'))
			->setPost($post);
		$em->persist($postSelection);
		
		$em->flush();

        return $this->redirect($this->generateUrl('app_index'));
    }
	
	/**
     * @Route("/manager/comments", name="app_comment_index")
     */
    public function commentAction()
    {
		$em = $this->getDoctrine()->getManager();
		
		$comments = $em
			->getRepository('AppBundle:Comment')
			->findAllNotValidate();

		return $this->render('app/comment/index.html.twig', array(
			'comments' => $comments
		));
    }
	
	/**
     * @Route("/manager/comments/refuse", name="app_comment_refuse")
     */
    public function commentRefuseAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		
		$comment = $em
			->getRepository('AppBundle:Comment')
			->findOneById($request->request->getInt('commentId'))
			->setIsDeleted(true);
		$em->persist($comment);
		$em->flush();

		$response = new JsonResponse();
		return $response->setData(array(
			'valid' => true
		));
    }
	
	/**
     * @Route("/manager/comments/accept", name="app_comment_accept")
     */
    public function commentAcceptAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		
		$comment = $em
			->getRepository('AppBundle:Comment')
			->findOneById($request->request->getInt('commentId'))
			->setIsValidate(true);
		$em->persist($comment);
		$em->flush();

		$response = new JsonResponse();
		return $response->setData(array(
			'valid' => true
		));
    }
}
