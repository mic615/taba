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

    public function authenticateYelp()
    {
      // API key placeholders that must be filled in by users.
      // You can find it on
      // https://www.yelp.com/developers/v3/manage_app
      $API_KEY = NULL;
      // Complain if credentials haven't been filled out.
      assert($API_KEY, env('YELP_KEY'));
      // API constants, you shouldn't have to change these.
      $API_HOST = "https://api.yelp.com";
      $SEARCH_PATH = "/v3/businesses/search";
      $BUSINESS_PATH = "/v3/businesses/";  // Business ID will come after slash.
      // Defaults for our simple example.
      $DEFAULT_TERM = "dinner";
      $DEFAULT_LOCATION = "San Francisco, CA";
      $SEARCH_LIMIT = 3;
      /**
     * Makes a request to the Yelp API and returns the response
     *
     * @param    $host    The domain host of the API
     * @param    $path    The path of the API after the domain.
     * @param    $url_params    Array of query-string parameters.
     * @return   The JSON response from the request
     */
    function request($host, $path, $url_params = array()) {
        // Send Yelp API Call
        try {
            $curl = curl_init();
            if (FALSE === $curl)
                throw new Exception('Failed to initialize');
            $url = $host . $path . "?" . http_build_query($url_params);
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,  // Capture response.
                CURLOPT_ENCODING => "",  // Accept gzip/deflate/whatever.
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "authorization: Bearer " . $GLOBALS['API_KEY'],
                    "cache-control: no-cache",
                ),
            ));
            $response = curl_exec($curl);
            if (FALSE === $response)
                throw new Exception(curl_error($curl), curl_errno($curl));
            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if (200 != $http_status)
                throw new Exception($response, $http_status);
            curl_close($curl);
        } catch(Exception $e) {
            trigger_error(sprintf(
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);
        }
        return $response;
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
