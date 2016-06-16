<?php

namespace AppBundle\Controller;


use AppBundle\DAO\UserWithAuth;
use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $redis = $this->get('app_redis');
        $user = new UserWithAuth('weź', 'id i user name', ' z auth', $request->cookies->get("auth"));
        $isLoggedIn = false;
        $post = new Post();
        $form = $this->createForm('AppBundle\Form\PostType', $post);

        try {
            $user = $redis->getUserByAuth($user);
            $isLoggedIn = true;

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user = $redis->getUserByAuth($user);
                $em = $this->getDoctrine()->getManager();
                $post->setUser($user->getId());
                $em->persist($post);
                $em->flush();

                return $this->redirectToRoute('post_show', array('id' => $post->getId()));
            }


        } catch (NotFoundResourceException $e) {

//            var_dump($e->getMessage());
        }


        return $this->render('default/homepage.html.twig', [
            'user' => $user,
            'isLoggedIn' => $isLoggedIn,
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }
}
