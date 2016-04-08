<?php

/**
 * Created by PhpStorm.
 * User: Thjnh
 * Date: 4/4/2016
 * Time: 1:08 AM
 */
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use AppBundle\Utilities\Utilities;
use AppBundle\Entity\Indentities;
use AppBundle\Entity\User;
use AppBundle\Entity\Category;
use AppBundle\Entity\Transaction;

class TransactionAPI extends Controller
{
    protected $em = null;
    protected $repos;
    public function __construct(EntityManager $em) {
        $this->em = $em;
        $this->repos = $em->getRepository('AppBundle:User');
    }

    public function getTransactionsForUser(Request $requestUser)
    {
        $user_id = $requestUser->request->get('user_id', null);
        //todo Check token recive
        if (!$user_id) {
            return Utilities::failMessage('User ID is missing');
        }
        $user = $this->repos->findOneBy(array('user_id' => $user_id));
        if (!$user) {

            return Utilities::failMessage('User not found');

        }
        else {
            $trans = $user->getTransactions();
            $count = count($trans);
            $data = array();

            for ($i = 0; $i < $count; $i++) {
                $date = $trans[$i]->getCreatedDate()->format('Y-m-d H:i:s');;
                $tran = array(
                    'tran_id' => $trans[$i]->getId(),
                    'cost' => $trans[$i]->getCost(),
                    'note' => $trans[$i]->getNote(),
                    'create_date' => $date,
                    'category_id' => $trans[$i]->getCategory()->getCategoryId(),
                    'category_name' => $trans[$i]->getCategory()->getCategoryName()

                );

                $data[] = $tran;
            }

            $result = array(
                'success' => 1,
                'message' => "",
                'transactions' => $count,
                'data' => $data
            );
            return json_encode($result);

        }
    }



    public function createTransactionsForRequest(Request $request){
        $user_id = $request->request->get('user_id',null);
        $token = $request->request->get('token',null);
        $category_id = $request->request->get('category_id',null);
        $cost = $request->request->get('cost',null);
        $note = $request->request->get('note',null);

        // Check info recive

        if(!$user_id || !$token || !$category_id || !$cost || !$note ){

            return Utilities::failMessage("Some information is missing");
        }

        /* Autorization */

        $accoutAPI = new AccountsAPI($this->em);
        $authoResult = $accoutAPI->authorization($user_id,$token);


        if($authoResult == 'success'){ //If autho success
            $user =  $this->repos->findOneBy(array('user_id'=>$user_id));
            $category = $this->em->getRepository('AppBundle:Category')->findOneBy(array('category_id'=>$category_id));
            return $this->processCreateTransaction($user,$category,$cost,$note);
//            return 'sssssw';
        }
        else{
            //return if autho fail
            return Utilities::failMessage($authoResult);
        }

    }

    public function processCreateTransaction($user,$category,$cost,$note){
        $tran = new Transaction();
        $tran->setUser($user);
        $tran->setCategory($category);
        $tran->setCost($cost);
        $tran->setNote($note);
        $tran->setCreatedDate(new DateTime());
        $this->em->persist($tran);
        $this->em->flush();
        $result = array('success'=>1);
        return  json_encode($result);
    }

}