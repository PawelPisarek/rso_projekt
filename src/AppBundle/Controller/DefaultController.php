<?php

namespace AppBundle\Controller;


use AppBundle\DAO\UserWithAuth;
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

        echo "redis";

        $redis = $this->get('app_redis');
        $redis->setToSet();


        $user = new UserWithAuth('weź', 'id i user name', ' z auth', $request->cookies->get("auth"));
        try {
            $user = $redis->getUserByAuth($user);
            var_dump($user);

        } catch (NotFoundResourceException $e) {

            var_dump($e->getMessage());
        }



        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }
}
