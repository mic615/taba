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
      DCILOUNGES_PROVIDER_LG DCILOUNGES_PROVIDER_DCIPL DCI_ATM DCI_CURRENCYCONVERSION DCI_CUSTOMERSERVICE DCI_TIP',[
      'headers' => [
        'Authorization' => 'Basic bDd4eDFjYjFkN2M0NTI0ZTQ4MmJiM2MwMjE5YmIyNjUxZTdkOmY0NmM0YjcxNTUzNjQxNGJiMzg0Mzc5MjUwZWYzYjdl',
        'Content-Type' => 'application/x-www-form-urlencoded'
      ]
    ]);
      echo $res->getStatusCode(); // 200
      $responseBody = json_decode((string) $res->getBody());
    //   $response = $client->get('http://todos.dev/api/todos', [
    //     'headers' => [
    //         'Authorization' => 'Bearer '.$auth->access_token,
    //     ]
    // ]);
      $accessToken= $responseBody->access_token ;
      echo $accessToken;
      return $accessToken;


    }

    public function getCategories()
    {
      $client = new \GuzzleHttp\Client();
      try{
        $res = $client->post('https://apis.discover.com/auth/oauth/v2/token?grant_type=client_credentials&scope=CITYGUIDES DCIOFFERS DCIOFFERS_POST DCILOUNGES DCILOUNGES_POST
        DCILOUNGES_PROVIDER_LG DCILOUNGES_PROVIDER_DCIPL DCI_ATM DCI_CURRENCYCONVERSION DCI_CUSTOMERSERVICE DCI_TIP',[
        'headers' => [
          'Authorization' => 'Basic bDd4eDFjYjFkN2M0NTI0ZTQ4MmJiM2MwMjE5YmIyNjUxZTdkOmY0NmM0YjcxNTUzNjQxNGJiMzg0Mzc5MjUwZWYzYjdl',
          'Content-Type' => 'application/x-www-form-urlencoded'
        ]
      ]);
      $responseBody = json_decode((string) $res->getBody());
      $accessToken= $responseBody->access_token ;
      $res = $client->get( 'https://api.discover.com/cityguides/v2/categories',[
      'headers' => [
        'Accept' => ' application/json',
        'x-dfs-api-plan' => 'CITYGUIDES_SANDBOX',
        'Authorization'=> 'Bearer' .$accessToken
      ]
    ]);
    $responseBody = json_decode( (string) $res->getBody() );
    echo $responseBody;
    }catch (GuzzleHttp\Exception\BadResponseException $e) {
        echo "Unable to retrieve access token.";

    }



    }


}
