<?php

namespace AppBundle\Controller;

use AppBundle\DAO\PostQueue;
use AppBundle\DAO\UserWithAuth;
use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function indexAction(Request $request)
    {


        $redis = $this->get('app_redis');
        $user = new UserWithAuth('weź', 'id i user name', ' z auth', $request->cookies->get("auth"));
        $isLoggedIn = false;
        $post = new Post();
        $postQueue = new PostQueue(0, 'Nie pobrano z koleiki, lub nie ma wiadomości');

        try {
            $user = $redis->getUserByAuth($user);
            if ("admin" == $user->getUsername()) {
                $isLoggedIn = true;
            }
            $queue = $this->get('app_rabbitmq');

            $postQueue = $queue->consume();
            $em = $this->getDoctrine()->getManager();

            $post = $em->getRepository('AppBundle:Post')->findById($postQueue->getId())[0];

        } catch (NotFoundResourceException $e) {

//            var_dump($e->getMessage());
        }


        return $this->render('AppBundle:Admin:index.html.twig', array(
            'user' => $user,
            'isLoggedIn' => $isLoggedIn,
            'post' => $post,
            'postQueue' => $postQueue
        ));
    }

    /**
     * @Route("/accept/{id}",name="accept")
     */
    public function acceptAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AppBundle:Post')->findById($id)[0];
        $post->setCheckedByAdmin(1);
        $em->persist($post);
        $em->flush();
        return $this->redirectToRoute('admin');

    }

    /**
     * @Route("/cancel",name="cancel")
     */
    public function cancelAction()
    {
        return $this->redirectToRoute('admin');

    }

}
