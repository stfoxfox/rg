<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 12.11.15
 * Time: 15:56
 */

namespace common\components\MyExtensions;


class MyHelper {

    public   static function formatTextToHTML($string,$useBr=false){


        $strGlue =($useBr)?"<br>":"</p><p>";



        $pArray = preg_split('/\n|\r\n/', $string);



        $returnStr = implode($strGlue,$pArray);

        if (!$useBr){
            $returnStr = "<p>".$returnStr."</p>";
        }

        return  $returnStr;


    }



    public static function searchById($array,$id){
        $return = null;

        foreach($array as $el){

            if($el->id==$id){
                $return = $el;
                break;
            }
        }


        return $return;
    }

    /**
     * @param string $text
     * @param string $phone
     * @return array
     */
    public static function sendSms($text,$phone)
    {
        $ch = curl_init("http://sms.ru/auth/get_token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $token = curl_exec($ch);
        curl_close($ch);


        $ch = curl_init("http://sms.ru/sms/send");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            "login"		=>	"79057324605",
            "sha512"    =>	hash("sha512","pronto24".$token."D134150D-CA02-06CE-4BAA-F657F5B13A51"),
            "token"		=>	$token,
            "to"		=>	$phone,
            "text"		=>	$text
        ]);
        $body = curl_exec($ch);
        curl_close($ch);

        return ['token' => $token,'b' => $phone];
    }
}