<?php

namespace AppBundle\Controller\api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AccountsAPI;
use TransactionAPI;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/api", name="apiv1")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $body = $request->getContent();
        $method = $request->request->get('method',null);
        $response = new Response();
        switch($method){
            case 'login':
                $accounts = new AccountsAPI($this->getDoctrine()->getManager());
                $response->setContent( $accounts ->  authenticateForUser($request));
                break;
            case 'signUp':
                $accounts = new AccountsAPI($this->getDoctrine()->getManager());
                $response->setContent( $accounts ->  signUpForUser($request));
                break;
            case 'getUserInfo':
                $accounts = new AccountsAPI($this->getDoctrine()->getManager());
                $response->setContent( $accounts ->  getUserInfo($request));
                break;
            case 'createTransaction':
                break;
            case 'getAllTransaction':
                $transactionAPI = new TransactionAPI($this->getDoctrine()->getManager());
                $response->setContent($transactionAPI->getTransactionsForUser($request));
                break;
            default
            ;
        }

        return $response;
//        return new Response($method);
    }
}
