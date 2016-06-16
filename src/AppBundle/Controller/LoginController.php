<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $redis = $this->get('app_redis');
        $user = new User();
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);
        if ($form->isValid()) {

            try {

                $auth = $redis->loginUser($user);
                $response = new Response();


                $response->prepare($request);
                $response->headers->setCookie(new Cookie('auth', $auth, time() + 3600 * 24 * 365));
                $response->send();
                return $this->redirectToRoute('homepage');
            } catch (NotFoundResourceException $e) {
//                var_dump($e->getMessage());

            }


        }
        return $this->render('AppBundle:Login:login.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(Request $request)
    {
        $response = new Response();


        $response->prepare($request);
        $response->headers->clearCookie('auth');
        $response->send();
        return $this->redirectToRoute('homepage');

    }

}
