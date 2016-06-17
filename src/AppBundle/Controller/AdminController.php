<?php

namespace AppBundle\Controller;

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


        try {
            $user = $redis->getUserByAuth($user);
            if ("admin" == $user->getUsername()) {
                $isLoggedIn = true;
            }
            $queue = $this->get('app_rabbitmq');

            var_dump($queue->consume());





        } catch (NotFoundResourceException $e) {

//            var_dump($e->getMessage());
        }


        return $this->render('AppBundle:Admin:index.html.twig', array(
            'user' => $user,
            'isLoggedIn' => $isLoggedIn,
            'post' => $post,
        ));
    }

    /**
     * @Route("/accept")
     */
    public function acceptAction()
    {
        return $this->render('AppBundle:Admin:accept.html.twig', array(// ...
        ));
    }

    /**
     * @Route("/cancel")
     */
    public function cancelAction()
    {
        return $this->render('AppBundle:Admin:cancel.html.twig', array(// ...
        ));
    }

}
