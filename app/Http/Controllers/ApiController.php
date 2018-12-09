<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    //
    public function authenticate()
    {
      $client = new \GuzzleHttp\Client();
      $res = $client->post('https://apis.discover.com/auth/oauth/v2/token?grant_type=client_credentials&scope=CITYGUIDES DCIOFFERS DCIOFFERS_POST DCILOUNGES DCILOUNGES_POST
      DCILOUNGES_PROVIDER_LG DCILOUNGES_PROVIDER_DCIPL DCI_ATM DCI_CURRENCYCONVERSION DCI_CUSTOMERSERVICE DCI_TIP',
      'headers' => [
      'Authorization' => 'Basic bDd4eDFjYjFkN2M0NTI0ZTQ4MmJiM2MwMjE5YmIyNjUxZTdkOmY0NmM0YjcxNTUzNjQxNGJiMzg0Mzc5MjUwZWYzYjdl',
      'Content-Type' => 'application/x-www-form-urlencoded'
    ]);
      echo $res->getStatusCode(); // 200
      echo $res->getBody();
      return $res->getBody();

    }
}
