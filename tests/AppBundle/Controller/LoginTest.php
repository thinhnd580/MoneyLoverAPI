<?php
/**
 * Created by PhpStorm.
 * User: Thjnh
 * Date: 4/21/2016
 * Time: 9:03 PM
 */

namespace Tests\AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    private $client;
    public function  __construct(){
        $this->client = static::createClient();
    }
    public function testStatus()
    {
        $this->client->request('POST', '/api',[
            'method' => 'login'
        ]);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->client->request('POST', '/api',[
        'method' => ''
        ]);
        $this->assertEquals(404,  $this->client->getResponse()->getStatusCode());
    }
    public function testLoginForMissingInput()
    {
        /*missing infomation */
        $this->client->request('POST', '/api',[
            'method' => 'login'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Some information is missing', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'login',
            'user_email' => 'tasd'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Some information is missing', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'login',
            'user_pass' => 'tasd'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Some information is missing', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'login',
            'user_device' => 'tasd'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Some information is missing', $data['message']);
    }

    public function testLoginForUserInDatabase(){
        //wrong infomation request(already have data in database)
        $this->client->request('POST', '/api',[
            'method' => 'login',
            'user_email' => 'thjnh195@gmail.com',
            'user_pass' => '1234567',
            'user_device' => 'random'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Wrong Password', $data['message']);
        $this->assertFalse(array_key_exists ( "user_id" , $data ));
        $this->assertFalse(array_key_exists ( "token" , $data ));

        //Correct user name and password
        $this->client->request('POST', '/api',[
            'method' => 'login',
            'user_email' => 'thjnh195@gmail.com',
            'user_pass' => '123456',
            'user_device' => 'random'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(1, $data['success']);
        $this->assertEquals(4,count($data));
        $this->assertNotEquals(0,count($data['user_id']));
        $this->assertTrue(array_key_exists ( "user_id" , $data ));
        $this->assertTrue(array_key_exists ( "token" , $data ));
    }
    public function testLoginForVaildInfo(){

        //wrong infomation request for email
        $this->client->request('POST', '/api',[
            'method' => 'login',
            'user_email' => 'saDsD..',
            'user_pass' => 'tasd',
            'user_device' => 'random'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Email is not vaild', $data['message']);


        $this->client->request('POST', '/api',[
            'method' => 'login',
            'user_email' => 'thjnh195@',
            'user_pass' => '1234567',
            'user_device' => 'random'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Email is not vaild', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'login',
            'user_email' => 'thjnh195@.com',
            'user_pass' => '1234567',
            'user_device' => 'random'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Email is not vaild', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'login',
            'user_email' => '',
            'user_pass' => '1234567',
            'user_device' => 'random'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Some information is missing', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'login',
            'user_email' => 'thjnh195@gmail.com',
            'user_pass' => '',
            'user_device' => 'random'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Some information is missing', $data['message']);
    }
}
