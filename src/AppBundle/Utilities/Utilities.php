<?php
/**
 * Created by PhpStorm.
 * User: Thjnh
 * Date: 3/28/2016
 * Time: 10:19 PM
 */

namespace AppBundle\Utilities;


class Utilities
{
    public static function generateTokenFor($user_mail,$user_pass,$user_device){
        $str = $user_mail + $user_pass + $user_device;
        return md5(uniqid($str, true));
    }
    public static function failMessage($message){
        $result = array('success' => 0, 'message' => $message);
        return json_encode($result);
    }

}