<?php

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
        //Check null for parameter
        if($user_mail == "" || $user_pass == ""  || $user_device == ""  ){
            return Utilities::failMessage("Some information is missing");
        }
        if (!filter_var($user_mail, FILTER_VALIDATE_EMAIL)) {
            return Utilities::failMessage("Email is not vaild");
        }
        $user1 = $this->repos->findOneBy(array('user_email'=>$user_mail));
        if (!$user1) {

            return Utilities::failMessage('Email not found');
        }
        else{
            if (password_verify($user_pass, $user1->getUserPass())) {
                // Success!
                $token = Utilities::generateTokenFor($user_mail, $user_pass,$user_device);
                $indentity = new Indentities();
                $indentity->setDevice($user_device);
                $indentity->setToken($token);
                $indentity->setTokenCreatedDate(new DateTime());
                $indentity->setUser($user1);
                $this->em->persist($indentity);
                $this->em->flush();

                $array = array('success'=>1,
                    'message'=>'',
                    'user_id'=>$user1->getUserId(),
                    'token'=>$token
                );
                return json_encode($array);
            }
            else {
                // Invalid credentials
                return Utilities::failMessage('Wrong Password');
            }
        }
    }

    public function signUpForUser(Request $requestUser){
        //Get information
        $user_mail = $requestUser->request->get('user_email',null);
        $user_pass = $requestUser->request->get('user_pass',null);
        $user_fullName = $requestUser->request->get('full_name',null);
        $user_phone = $requestUser->request->get('phone',null);

        // Client app must check before send parameter to api, this if just for sure
        if($user_mail == ""  || $user_pass == ""  || $user_fullName == ""  || $user_phone == "" ){
            return Utilities::failMessage('Some information is missing');
        }
        if (!filter_var($user_mail, FILTER_VALIDATE_EMAIL)) {
            return Utilities::failMessage("Email is not vaild");
        }
        if (!preg_match("/^[a-zA-Z0-9]*$/",$user_pass)) {
            return Utilities::failMessage("Password not allow whitespace");
        }
        if(strlen($user_pass)<8){
            return Utilities::failMessage("Password must contain at least 6 characters");
        }
        if (!preg_match("/^[a-zA-Z ]*$/",$user_fullName)) {
            return Utilities::failMessage("Name must only contain letters and whitespace");
        }
        if (!preg_match("/^[0-9+() ]*$/",$user_phone)) {
            return Utilities::failMessage("Phone must only contain number");
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
            $user->setUserPass(password_hash($user_pass, PASSWORD_DEFAULT));
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
        if($user_id ==""){
            return Utilities::failMessage('User ID is missing');
        }
        $user =  $this->repos->findOneBy(array('user_id'=>$user_id));
        if(!$user){
            return Utilities::failMessage('User not found');
        }
        else{
            $date = $user->getCreateDate()->format('Y-m-d H:i:s');
            $result = array(
                'success' => 1,
                'message' => "",
                'user_email' => $user->getUserEmail(),
                'user_fullName' => $user->getUserFullName(),
                'user_phone' => $user->getUserPhone(),
                'register_date' => ($date)
            );
            return json_encode($result);
        }
    }

    public function authorization($user_id,$token){
        $user =  $this->repos->findOneBy(array('user_id'=>$user_id));
        if(!$user) {
            return "User not found";
        }
        $indens = $user->getIndentities();
        for($i=0;$i<count($indens);$i++){
            if($indens[$i]->getToken() == $token){
                // start create transaction
                return "success";
            }
            if($i == (count($indens) - 1) ){
                return 'Request Fail,logout or sign in again';
            }
        }
    }
}