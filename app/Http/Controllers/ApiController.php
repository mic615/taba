<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    //
    public function authenticate()
    {
      $client = new GuzzleHttp\Client();
      $res = $client->get('https://apis.discover.com/auth/oauth/v2/token?grant_type=client_credentials&scope=CITYGUIDES DCIOFFERS DCIOFFERS_POST DCILOUNGES DCILOUNGES_POST
      DCILOUNGES_PROVIDER_LG DCILOUNGES_PROVIDER_DCIPL DCI_ATM DCI_CURRENCYCONVERSION DCI_CUSTOMERSERVICE DCI_TIP', ['auth' =>  ['l7xx1cb1d7c4524e482bb3c0219bb2651e7d', 'f46c4b715536414bb384379250ef3b7e']]);
      echo $res->getStatusCode(); // 200
      echo $res->getBody();
      return $res->getBody();

    }
}
