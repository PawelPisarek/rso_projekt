<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin');
    }

    public function testAccept()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/accept');
    }

    public function testCancel()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/cancel');
    }

}
