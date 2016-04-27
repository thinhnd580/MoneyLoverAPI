<?php
/**
 * Created by PhpStorm.
 * User: Thjnh
 * Date: 4/22/2016
 * Time: 9:56 PM
 */

namespace Tests\AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SignUpTest extends WebTestCase
{
    private $client;
    public function  __construct(){
        $this->client = static::createClient();
    }
    public function testStatus()
    {
        $this->client->request('POST', '/api',[
            'method' => 'signUp'
        ]);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->client->request('POST', '/api',[
            'method' => 'Signup'
        ]);
        $this->assertEquals(404,  $this->client->getResponse()->getStatusCode());

        $this->client->request('POST', '/api',[
            'method' => ''
        ]);
        $this->assertEquals(404,  $this->client->getResponse()->getStatusCode());
    }
    public function testSignUpMissingInput()
    {
        /*missing infomation */

        $this->client->request('POST', '/api',[
            'method' => 'signUp'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Some information is missing', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'signUp',
            'user_email' => 'tasd'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Some information is missing', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'signUp',
            'user_email' => 'tasd',
            'user_pass' => 'asdasdsad'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Some information is missing', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'signUp',
            'user_email' => 'tasd',
            'user_pass' => 'asdasdsad',
            'full_name' => 'dfs',
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Some information is missing', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'signUp',
            'user_email' => 'tasd',
            'phone' => '1236454'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Some information is missing', $data['message']);
    }

    public function testSignUpUnFillInput(){
        //Test For unfill information
        $this->client->request('POST', '/api',[
            'method' => 'signUp',
            'user_email' => '',
            'user_pass' => 'asdasdsad',
            'full_name' => 'dfs',
            'phone' => '1236454'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Some information is missing', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'signUp',
            'user_email' => '',
            'user_pass' => '',
            'full_name' => 'dfs',
            'phone' => '1236454'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Some information is missing', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'signUp',
            'user_email' => 'thjnh195@gmail.com',
            'user_pass' => '',
            'full_name' => 'dfs',
            'phone' => '1236454'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Some information is missing', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'signUp',
            'user_email' => 'thjnh195@gmail.com',
            'user_pass' => 'asdasdsad',
            'full_name' => '',
            'phone' => ''
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Some information is missing', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'signUp',
            'user_email' => 'thjnh195@gmail.com',
            'user_pass' => 'asdasdsad',
            'full_name' => '',
            'phone' => '16565214'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Some information is missing', $data['message']);
    }

    public function testSinupForInvaildEmail(){
        //Invaild Email
        $this->client->request('POST', '/api',[
            'method' => 'signUp',
            'user_email' => 'thjnh195',
            'user_pass' => 'asdasdsad',
            'full_name' => 'Nguynen Trong Minh Dung',
            'phone' => '16565214'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Email is not vaild', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'signUp',
            'user_email' => '...$23q',
            'user_pass' => 'asdasdsad',
            'full_name' => 'Nguynen Trong Minh Dung',
            'phone' => '16565214'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Email is not vaild', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'signUp',
            'user_email' => 'thjasd@.com',
            'user_pass' => 'asdasdsad',
            'full_name' => 'Nguynen Trong Minh Dung',
            'phone' => '16565214'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Email is not vaild', $data['message']);


    }
    public function testSinupForInvaildPassWord(){
        //Invald Password
        $this->client->request('POST', '/api',[
            'method' => 'signUp',
            'user_email' => 'thjnh195@gmail.com',
            'user_pass' => 'asdas2 ',
            'full_name' => 'Nguynen Trong Minh Dung',
            'phone' => '16565214'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Password not allow whitespace', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'signUp',
            'user_email' => 'thjnh195@gmail.com',
            'user_pass' => '$2342 &*&',
            'full_name' => 'Nguynen Trong Minh Dung',
            'phone' => '16565214'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Password not allow whitespace', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'signUp',
            'user_email' => 'thjnh195@gmail.com',
            'user_pass' => 'asd01',
            'full_name' => 'Nguynen Trong Minh Dung',
            'phone' => '16565214'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Password must contain at least 6 characters', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'signUp',
            'user_email' => 'thjnh195@gmail.com',
            'user_pass' => 'asd01',
            'full_name' => 'Nguynen Trong Minh Dung',
            'phone' => '16565214'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Password must contain at least 6 characters', $data['message']);


    }

    public function testSinupForInvaildName(){
        //Invaild Name
        $this->client->request('POST', '/api',[
            'method' => 'signUp',
            'user_email' => 'thjnh195@gmail.com',
            'user_pass' => 'asd01fdsg',
            'full_name' => 'Nguynenasd_sdas %34',
            'phone' => '16565214'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Name must only contain letters and whitespace', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'signUp',
            'user_email' => 'thjnh195@gmail.com',
            'user_pass' => 'asd01fdsg',
            'full_name' => '324234 2342 3',
            'phone' => '16565214'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Name must only contain letters and whitespace', $data['message']);

    }

    public function testSinupForInvaildPhone(){
        //Invaild Phone number
        $this->client->request('POST', '/api',[
            'method' => 'signUp',
            'user_email' => 'thjnh195@gmail.com',
            'user_pass' => 'asd01010',
            'full_name' => 'Nguynen Trong Minh Dung',
            'phone' => '165asd'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Phone must only contain number', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'signUp',
            'user_email' => 'thjnh195@gmail.com',
            'user_pass' => 'asd01010',
            'full_name' => 'Nguynen Trong Minh Dung',
            'phone' => '+69asd21d sa'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Phone must only contain number', $data['message']);
    }
}
