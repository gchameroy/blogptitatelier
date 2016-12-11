<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use AppBundle\Form\Type\UserRegistrationType;

class SecurityController extends Controller
{
	/**
     * @Route("/inscription", name="user_registration")
     */
    public function registerAction(Request $request)
    {
		$user = $this->get('app.user.factory')->createUser();
        $form = $this->createForm(UserRegistrationType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
			$user->setSalt(md5(random_bytes(15)));
			$password = $this->get('security.password_encoder')
				->encodePassword($user, $user->getPlainPassword());
			$user->setPassword($password)
				->eraseCredentials();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('web_home');
        }

        return $this->render('security/register.html.twig', [
			'form' => $form->createView()
		]);
    }

    /**
     * @Route("/connexion", name="login")
     * @Method("GET")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/deconnexion", name="logout")
     * @Method("GET")
     */
    public function logoutAction()
    {

    }

    /**
     * @Route("/login-check", name="login_check")
     * @Method("POST")
     */
    public function loginCheckAction()
    {

    }
}
