<?php
/**
 * Created by PhpStorm.
 * User: Thjnh
 * Date: 4/25/2016
 * Time: 11:13 AM
 */

namespace Tests\AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetUserInfoTest extends WebTestCase
{
    private $client;
    public function  __construct(){
        $this->client = static::createClient();
    }
    public function testStatus()
    {
        $this->client->request('POST', '/api',[
            'method' => 'getUserInfo'
        ]);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->client->request('POST', '/api',[
            'method' => 'GETUSERINFO'
        ]);
        $this->assertEquals(404,  $this->client->getResponse()->getStatusCode());
        $this->client->request('POST', '/api',[
            'method' => ''
        ]);
        $this->assertEquals(404,  $this->client->getResponse()->getStatusCode());
    }
    public function testLoginForMissingInput()
    {
        /*missing infomation */
        $this->client->request('POST', '/api',[
            'method' => 'getUserInfo'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('User ID is missing', $data['message']);

        //WARING : this test only pass because already have data in database
        $this->client->request('POST', '/api',[
            'method' => 'getUserInfo',
            'user_id' => ''
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('User ID is missing', $data['message']);
    }

    public function testGetInfoForUserInDatabase(){
        //wrong infomation request(already have data in database)
        $this->client->request('POST', '/api',[
            'method' => 'getUserInfo',
            'user_id' => '0'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('User not found', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'getUserInfo',
            'user_id' => '1'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(1, $data['success']);
        $this->assertEquals(6,count($data));
        $this->assertTrue(array_key_exists ( "user_email" , $data ));
        $this->assertTrue(array_key_exists ( "user_fullName" , $data ));
        $this->assertTrue(array_key_exists ( "user_phone" , $data ));
        $this->assertTrue(array_key_exists ( "register_date" , $data ));
    }
}
