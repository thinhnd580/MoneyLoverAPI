<?php
/**
 * Created by PhpStorm.
 * User: Thjnh
 * Date: 4/27/2016
 * Time: 11:44 AM
 */

namespace Tests\AppBundle\Controller;


class GetAllTransaction extends WebTestCase
{
    private $client;
    public function  __construct(){
        $this->client = static::createClient();
    }
    public function testStatus()
    {
        $this->client->request('POST', '/api',[
            'method' => 'getAllTransaction'
        ]);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->client->request('POST', '/api',[
            'method' => 'GetAllTransaction'
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
            'method' => 'getAllTransaction'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('User ID is missing', $data['message']);

        //WARING : this test only pass because already have data in database
        $this->client->request('POST', '/api',[
            'method' => 'getAllTransaction',
            'user_id' => ''
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('User ID is missing', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'getAllTransaction',
            'user_id' => '1'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Token is missing', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'getAllTransaction',
            'user_id' => '1',
            'token' => ''
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Token is missing', $data['message']);

    }

    public function testAuthorization(){

        //wrong infomation request(already have data in database)
        $this->client->request('POST', '/api',[
            'method' => 'getAllTransaction',
            'user_id' => '0',
            'token' => 'xxxxx'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('User not found', $data['message']);
        $this->assertFalse(array_key_exists ( "data" , $data ));

        $this->client->request('POST', '/api',[
            'method' => 'getAllTransaction',
            'user_id' => '-1',
            'token' => 'xxxxx'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('User not found', $data['message']);
        $this->assertFalse(array_key_exists ( "data" , $data ));

        $this->client->request('POST', '/api',[
            'method' => 'getAllTransaction',
            'user_id' => '1',
            'token' => 'xxxxx'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Request Fail,logout or sign in again', $data['message']);
        $this->assertFalse(array_key_exists ( "data" , $data ));

        //Token of user already in database
        $this->client->request('POST', '/api',[
            'method' => 'getAllTransaction',
            'user_id' => '1',
            'token' => '73a395f4b62a75ba12512e2d2b3b6dac'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(1, $data['success']);
        $this->assertTrue(array_key_exists ( "data" , $data ));

    }

}
