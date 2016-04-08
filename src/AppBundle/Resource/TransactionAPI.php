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
            return Utilities::failMessage('Some information is missing');
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
        $user =  $this->repos->findOneBy(array('user_id'=>$user_id));

        if(!$user) {

            return Utilities::failMessage("User not found");
        }
        $indens = $user->getIndentities();
        for($i=0;$i<count($indens);$i++){
            if($indens[$i] == $token){
                // start create transaction
                return $this->responeForCreateTransaction($user,$category_id,$cost,$note);
            }
            if($i == (count($indens) - 1) ){
                return Utilities::failRequsestWithMessage('Request Fail,logout or sign in again');
            }
        }


        $trans = $user->getTransactions();
        $count = count($trans) ;
        $data = array();

        for($i=0;$i<$count;$i++){
            $date = $trans[$i]->getCreatedDate()->format('Y-m-d H:i:s');;
            $tran = array(
                'tran_id'=>$trans[$i]->getId(),
                'cost'=>$trans[$i]->getCost(),
                'note'=>$trans[$i]->getNote(),
                'create_date'=>$date,
                'category_id'=>$trans[$i]->getCategory()->getCategoryId(),
                'category_name'=>$trans[$i]->getCategory()->getCategoryName()

            );

            $data[] = $tran;
        }

        $result = array('success'=>1,'transactions'=>$count,'data'=>$data);
        return json_encode($result);

    }

    public function responeForCreateTransaction($user,$category,$cost,$note){
        $tran = new Transaction();
        $tran->setUser($user);
        $tran->setCategory()
    }

}