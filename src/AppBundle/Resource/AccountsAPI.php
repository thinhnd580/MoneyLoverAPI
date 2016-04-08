<?php
/**
 * Created by PhpStorm.
 * User: Thjnh
 * Date: 3/26/2016
 * Time: 8:09 PM
 */

//namespace AppBundle\Resource;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use AppBundle\Utilities\Utilities;
use AppBundle\Entity\Indentities;
use AppBundle\Entity\User;
class AccountsAPI extends Controller
{
    protected $em = null;
    protected $repos;

    public function __construct(EntityManager $em) {
        $this->em = $em;
        $this->repos = $em->getRepository('AppBundle:User');
    }

    public function authenticateForUser(Request $requestUser){
        $user_mail = $requestUser->request->get('user_email',null);
        $user_pass = $requestUser->request->get('user_pass',null);
        $user_device = $requestUser->request->get('user_device',null);
        //todo Check null for parameter


        $user1 = $this->repos->findOneBy(array('user_email'=>$user_mail));
        if (!$user1) {

            return Utilities::failMessage('Email not found');
        }
        else{
            if($user1->getUserPass()== $user_pass){

                $token = Utilities::generateTokenFor($user_mail, $user_pass,$user_device);
                $indentity = new Indentities();
                $indentity->setDevice($user_device);
                $indentity->setToken($token);
                $indentity->setTokenCreatedDate(new DateTime());
                $indentity->setUser($user1);
                $this->em->persist($indentity);
                $this->em->flush();

                $array = array('success'=>1,'message'=>'','token'=>$token);
                return json_encode($array);
            }
            else{
                return Utilities::failMessage('Wrong Password');
            }
        }
//        return $array;
    }

    public function signUpForUser(Request $requestUser){

        //Get information
        $user_mail = $requestUser->request->get('user_email',null);
        $user_pass = $requestUser->request->get('user_pass',null);
        $user_fullName = $requestUser->request->get('full_name',null);
        $user_phone = $requestUser->request->get('phone',null);

        // Client app must check before send parameter to api, this if just for sure
        if(!$user_mail || !$user_pass || !$user_fullName || !$user_phone){
            return Utilities::failMessage('Some information is missing');
        }


        // Find out the email is already regisered
        $array = array('user_email'=>$user_mail);
        $user_temp = $this->repos->findOneBy($array);
        if($user_temp){

            return Utilities::failMessage('The email already registered');

        }
        else{
            $user = new User();
            $user->setUserEmail($user_mail);
            $user->setUserFullName($user_fullName);
            $user->setUserPass($user_pass);
            $user->setCreateDate(new DateTime());
            $user->setUserPhone($user_phone);
            $this->em->persist($user);
            $this->em->flush();
            $result = array('success'=>1,'message'=>'');
            return json_encode($result);
        }

    }
    public function getUserInfo(Request $requestInfo){
        $user_id = $requestInfo->request->get('user_id',null);

        if(!$user_id){

            return Utilities::failMessage('Some information is missing');

        }
        $user =  $this->repos->findOneBy(array('user_id'=>$user_id));
        if(!$user){

            return Utilities::failMessage('User not found');

        }
        else{
            $date = $user->getCreateDate()->format('Y-m-d H:i:s');
            $result = array(
                'user_email' => $user->getUserEmail(),
                'user_fullName' => $user->getUserFullName(),
                'user_phone' => $user->getUserPhone(),
                'register_date' => ($date)

            );
            return json_encode($result);
        }


    }
}