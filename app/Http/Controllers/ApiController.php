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
          'Authorization'=> 'Bearer ' .$accessToken,
          'x-dfs-api-plan' => 'CITYGUIDES_SANDBOX'
        ]
      ]);
      echo $res->getBody();
      }catch (GuzzleHttp\Exception\BadResponseException $e) {
          echo "Unable to retrieve access token.";
      }
    }

    public function getAllMerchants()
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


      $res = $client->get( 'https://api.discover.com/cityguides/v2/merchants?card_network=DCI&has_privileges=false&sortby=name&sortdir=asc',[
        'headers' => [
          'Accept' => ' application/json',
          'Authorization'=> 'Bearer ' .$accessToken,
          'x-dfs-api-plan' => 'CITYGUIDES_SANDBOX'
        ]
      ]);
      echo $res->getBody();
      }catch (GuzzleHttp\Exception\BadResponseException $e) {
          echo "Unable to retrieve access token.";
      }
    }

    public function getMerchantsByLocation()
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


      $res = $client->get( 'https://api.discover.com/cityguides/v2/merchants?card_network=DCI&has_privileges=false&sortby=name&sortdir=asc',[
        'headers' => [
          'Accept' => ' application/json',
          'Authorization'=> 'Bearer ' .$accessToken,
          'x-dfs-api-plan' => 'CITYGUIDES_SANDBOX'
        ]
      ]);
      echo $res->getBody();
      }catch (GuzzleHttp\Exception\BadResponseException $e) {
          echo "Unable to retrieve access token.";
      }
    }

    public function getAllATMs()
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


      $res = $client->get( 'https://api.discover.com/dci/atm/v1/locations?radius=50&longitude=-122.3321&latitude=37.7749',[
        'headers' => [
          'Accept' => ' application/json',
          'Authorization'=> 'Bearer ' .$accessToken,
          'x-dfs-api-plan' => 'DCI_ATM_SANDBOX'
        ]
      ]);
      echo $res->getBody();
      }catch (GuzzleHttp\Exception\BadResponseException $e) {
          echo "Unable to retrieve access token.";
      }
    }

    public function getATMsByLocation($latitude, $longitude)
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

      $queryParams = '?radius=50&longitude=' .$longitude .'&latitude=' .$latitude;

      $res = $client->get( 'https://api.discover.com/dci/atm/v1/locations' .$queryParams,[
        'headers' => [
          'Accept' => 'application/json',
          'Authorization'=> 'Bearer ' .$accessToken,
          'x-dfs-api-plan' => 'DCI_ATM_SANDBOX'
        ]
      ]);
      echo $res->getBody();
      }catch (GuzzleHttp\Exception\BadResponseException $e) {
          echo "Unable to retrieve access token.";
      }
    }

    public function getAllOffers()
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


      $res = $client->get( 'https://api.discover.com/dci-offers/v2/offers?radius=20&lang=en&sortdir=asc',[
        'headers' => [
          'Accept' => ' application/json',
          'Authorization'=> 'Bearer ' .$accessToken,
          'x-dfs-api-plan' => 'DCIOFFERS_SANDBOX'
        ]
      ]);
      echo $res->getBody();
      }catch (GuzzleHttp\Exception\BadResponseException $e) {
          echo "Unable to retrieve access token.";
      }
    }

    public function getOffersByLocation($latitude, $longitude)
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
      $queryParams = '?' . urlencode('lat') . '=' . urlencode($latitude) . '&' . urlencode('lng') . '=' . urlencode($longitude) . '&'
      . urlencode('radius') . '=' . urlencode('20') . '&'
      . urlencode('lang') . '=' . urlencode('en') . '&' . urlencode('sortdir') . '=' . urlencode('asc');
      $res = $client->get( 'https://api.discover.com/dci-offers/v2/offers' .$queryParams,[
        'headers' => [
          'Accept' => 'application/json',
          'Authorization'=> 'Bearer ' .$accessToken,
          'x-dfs-api-plan' => 'DCIOFFERS_SANDBOX'
        ]
      ]);
      echo $res->getBody();
      }catch (GuzzleHttp\Exception\BadResponseException $e) {
          echo "Unable to retrieve access token.";
      }
    }

}
