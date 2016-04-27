<?php
/**
 * Created by PhpStorm.
 * User: Thjnh
 * Date: 4/27/2016
 * Time: 10:20 AM
 */

namespace Tests\AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class CreateTransactionTest extends WebTestCase
{
    private $client;
    public function  __construct(){
        $this->client = static::createClient();
    }
    public function testStatus()
    {
        $this->client->request('POST', '/api',[
            'method' => 'createTransaction'
        ]);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->client->request('POST', '/api',[
            'method' => 'CreateTransaction'
        ]);
        $this->assertEquals(404,  $this->client->getResponse()->getStatusCode());
        $this->client->request('POST', '/api',[
            'method' => 'CREATETRANSACTION'
        ]);
        $this->assertEquals(404,  $this->client->getResponse()->getStatusCode());
        $this->client->request('POST', '/api',[
            'method' => ''
        ]);
        $this->assertEquals(404,  $this->client->getResponse()->getStatusCode());
    }
    public function testForMissingInput()
    {
        /*missing infomation */
        $this->client->request('POST', '/api',[
            'method' => 'createTransaction'
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Some information is missing', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'createTransaction',
            'user_id' => '1',
            'token' => '',
            'category_id' => '',
            'cost' => '',
            'note' => '',
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Some information is missing', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'createTransaction',
            'user_id' => '',
            'token' => '12312asf',
            'category_id' => '2',
            'cost' => '',
            'note' => '',
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Some information is missing', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'createTransaction',
            'user_id' => '2',
            'token' => '',
            'category_id' => '2',
            'cost' => '',
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Some information is missing', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'createTransaction',
            'user_id' => '1',
            'token' => '12312asf',
            'category_id' => '2',
            'cost' => '',
            'note' => 'asdas',
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Some information is missing', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'createTransaction',
            'user_id' => '',
            'token' => '12312asf',
            'category_id' => '2',
            'cost' => '123123',
            'note' => '',
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Some information is missing', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'createTransaction',
            'user_id' => '1',
            'token' => 'xxxxx',
            'category_id' => '2',
            'cost' => '123123',
            'note' => '',
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertNotEquals('Some information is missing', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'createTransaction',
            'user_id' => '1',
            'token' => 'xxxxx',
            'category_id' => '2',
            'cost' => '123123',
            'note' => 'asdadasgfa asfas ',
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertNotEquals('Some information is missing', $data['message']);
    }

    public function testInvalidInput(){
        $this->client->request('POST', '/api',[
            'method' => 'createTransaction',
            'user_id' => '1',
            'token' => '73a395f4b62a75ba12512e2d2b3b6dac',
            'category_id' => '2',
            'cost' => 'asd asdas',
            'note' => 'asdadasgfa asfas ',
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Invaild cost input', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'createTransaction',
            'user_id' => '1',
            'token' => '73a395f4b62a75ba12512e2d2b3b6dac',
            'category_id' => '2',
            'cost' => '%$324.123',
            'note' => 'asdadasgfa asfas ',
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Invaild cost input', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'createTransaction',
            'user_id' => '1as',
            'token' => '73a395f4b62a75ba12512e2d2b3b6dac',
            'category_id' => '2',
            'cost' => '12',
            'note' => 'asdadasgfa asfas ',
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Invaild User Id input', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'createTransaction',
            'user_id' => '1',
            'token' => '73a395f4b62a75ba12512e2d2b3b6dac',
            'category_id' => 'as',
            'cost' => '3215.21',
            'note' => 'asdadasgfa asfas ',
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Invaild Category Id input', $data['message']);
    }

    public function testNotFoundCategoryAndUser(){
        // User Not found
        $this->client->request('POST', '/api',[
            'method' => 'createTransaction',
            'user_id' => '0',
            'token' => '73a395f4b62a75ba12512e2d2b3b6dac',
            'category_id' => '1',
            'cost' => '3215.21',
            'note' => 'asdadasgfa asfas ',
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('User not found', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'createTransaction',
            'user_id' => '-5',
            'token' => '73a395f4b62a75ba12512e2d2b3b6dac',
            'category_id' => '1',
            'cost' => '3215.21',
            'note' => 'asdadasgfa asfas ',
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('User not found', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'createTransaction',
            'user_id' => '-100',
            'token' => '73a395f4b62a75ba12512e2d2b3b6dac',
            'category_id' => '1',
            'cost' => '3215.21',
            'note' => 'asdadasgfa asfas ',
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('User not found', $data['message']);

        //Category not found
        $this->client->request('POST', '/api',[
            'method' => 'createTransaction',
            'user_id' => '1',
            'token' => '73a395f4b62a75ba12512e2d2b3b6dac',
            'category_id' => '0',
            'cost' => '3215.21',
            'note' => 'asdadasgfa asfas ',
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Category not found', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'createTransaction',
            'user_id' => '1',
            'token' => '73a395f4b62a75ba12512e2d2b3b6dac',
            'category_id' => '-2',
            'cost' => '3215.21',
            'note' => 'asdadasgfa asfas ',
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Category not found', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'createTransaction',
            'user_id' => '1',
            'token' => '73a395f4b62a75ba12512e2d2b3b6dac',
            'category_id' => '-300',
            'cost' => '3215.21',
            'note' => 'asdadasgfa asfas ',
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Category not found', $data['message']);
    }

    public function testAuthorization(){

        //wrong infomation request(already have data in database)
        $this->client->request('POST', '/api',[
            'method' => 'createTransaction',
            'user_id' => '0',
            'token' => 'xxxxx',
            'category_id' => '2',
            'cost' => '123123',
            'note' => 'asdadasgfa asfas ',
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('User not found', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'createTransaction',
            'user_id' => '-1',
            'token' => 'xxxxx',
            'category_id' => '2',
            'cost' => '123123',
            'note' => '',
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('User not found', $data['message']);

        $this->client->request('POST', '/api',[
            'method' => 'createTransaction',
            'user_id' => '1',
            'token' => 'xxxxx',
            'category_id' => '2',
            'cost' => '123123',
            'note' => 'Test note',
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(0, $data['success']);
        $this->assertEquals('Request Fail,logout or sign in again', $data['message']);

        //Token of user already in database
        $this->client->request('POST', '/api',[
            'method' => 'createTransaction',
            'user_id' => '1',
            'token' => '73a395f4b62a75ba12512e2d2b3b6dac',
            'category_id' => '2',
            'cost' => '123123',
            'note' => 'Test note',
        ]);
        $data = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals(1, $data['success']);
    }

}
