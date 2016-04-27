<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testStatus()
    {
        $client = static::createClient();
        $client->request('POST', '/api');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());

        $client->request('POST', '/api',[
            'method' => ''

        ]);
        $this->assertEquals(404, $client->getResponse()->getStatusCode());


    }
    public function testGetMethod()
    {
        $client = static::createClient();
         $client->request('GET', '/api');
        $this->assertNotEquals(200, $client->getResponse()->getStatusCode());
    }
}
