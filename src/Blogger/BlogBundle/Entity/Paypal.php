<?php
// src/Blogger/BlogBundle/Entity/Paypal.php

namespace Blogger\BlogBundle\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;


class Paypal
{

    /**
     * @param $credentials Array of 4 ....
     * @return array
     */
    public function PPHttpPost($credentials)
    {
        $API_UserName = urlencode($credentials['API_UserName']);
        $API_Password = urlencode($credentials['API_Password']);
        $API_Signature = urlencode($credentials['API_Signature']);
        $nvpStr_ = (isset($credentials['nvpStr'])?$credentials['nvpStr']:'&RETURNALLCURRENCIES=1'); // '&RETURNALLCURRENCIES=1';
        $methodName_ = 'GetBalance';
        $API_Endpoint = 'https://api-3t.paypal.com/nvp'; // https://developer.paypal.com/docs/classic/api/gs_PayPalAPIs/#endpoint
        //   if("sandbox" === self::environment || "beta-sandbox" === self::environment) {
        //      $API_Endpoint = 'https://api-3t'.self::environment.'paypal.com/nvp';
        //   }
        $version = urlencode('51.0');

        // setting the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        // turning off the server and peer verification(TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        // NVPRequest for submitting to server
        $nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";

        // setting the nvpreq as POST FIELD to curl
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

        // getting response from server
        $httpResponse = curl_exec($ch);

        if (!$httpResponse) {
            exit("$methodName_ failed: " . curl_error($ch) . '(' . curl_errno($ch) . ')');
        }

        // Extract the RefundTransaction response details
        $httpResponseAr = explode('&', $httpResponse);

        $httpParsedResponseAr = array();
        foreach ($httpResponseAr as $i => $value) {
            $tmpAr = explode('=', $value);
            if (count($tmpAr) > 1) {
                $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
            }
        }

        if ((0 === count($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
            exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
        }

        return $httpParsedResponseAr;
    }

}