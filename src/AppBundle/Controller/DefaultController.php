<?php

namespace AppBundle\Controller;

use AppBundle\DAO\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

        $user = new User('6','asd1','asd');
        $redis->registerUser($user);
        exit;

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }
}
