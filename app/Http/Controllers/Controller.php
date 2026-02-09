<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function get_client_ip() {
            $ipaddress = '';
            if (isset($_SERVER['HTTP_CLIENT_IP']))
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if (isset($_SERVER['HTTP_X_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            else if (isset($_SERVER['HTTP_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_FORWARDED'];
            else if (isset($_SERVER['REMOTE_ADDR']))
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            else
                $ipaddress = 'UNKNOWN';
            return $ipaddress;
        }

//    public function asaas($opts) {
//            $curl = curl_init();
//
//            $opt = [
//                'CURLOPT_CUSTOMREQUEST' => $opts->method ?? 'GET',
//                'CURLOPT_POSTFIELDS' => '',
//            ];
//
//            if (isset($opts->payload)) {
//                $opt['CURLOPT_CUSTOMREQUEST'] = 'POST';
//                $opt['CURLOPT_POSTFIELDS'] = json_encode($opts->payload);
//            }
//
//            $optArray = [
//                CURLOPT_URL => $opts->path,
//                CURLOPT_SSL_VERIFYPEER => false,
//                CURLOPT_RETURNTRANSFER => true,
//                CURLOPT_ENCODING => '',
//                CURLOPT_MAXREDIRS => 10,
//                CURLOPT_TIMEOUT => 120,
//                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                CURLOPT_CUSTOMREQUEST => $opt['CURLOPT_CUSTOMREQUEST'],
//                CURLOPT_POSTFIELDS => $opt['CURLOPT_POSTFIELDS'],
//                CURLOPT_HTTPHEADER => [
//                    'Accept: */*',
//                    'Content-Type: application/json',
//                    'Accept-Encoding: gzip, deflate',
//                    'Cache-Control: no-cache',
//                    'Connection: keep-alive',
//                    'access_token: ' . $opts->access_token,
//                    'cache-control: no-cache'
//                ],
//            ];
//
//            curl_setopt_array($curl, $optArray);
//
//            $response = curl_exec($curl);
//            $err = curl_error($curl);
//            curl_close($curl);
//
//            if ($err) {
//                die($err);
//            }
//
//            return json_decode($response);
//        }

}
