<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
$API_KEY = NULL;
// Complain if credentials haven't been filled out.
assert($API_KEY, env('YELP_KEY'));


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

    public function testYelp(){
      // API key placeholders that must be filled in by users.
      // You can find it on
      // https://www.yelp.com/developers/v3/manage_app
      env('YELP_KEY');
      /**
       * User input is handled here
       */
      $longopts  = array(
          "term::",
          "location::",
      );

      $options = getopt("", $longopts);
      $term = $options['term'] ?:  env('YELP_DEFAULT_TERM');
      $location = $options['location'] ?:  env('YELP_DEFAULT_LOCATION');
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
                  "authorization: Bearer " .   env('YELP_API_KEY'),
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

    public function search($term, $location) {
      $url_params = array();;
      $SEARCH_LIMIT = 3;
      $url_params['term'] = $term;
      $url_params['location'] = $location;
      $url_params['limit'] =   env('YELP_SEARCH_LIMIT');

      return request(  env('YELP_API_HOST'),  env('YELP_SEARCH_PATH'), $url_params);
    }

    public function get_business($business_id) {

      $business_path =   env('YELP_BUSINESS_PATH') . urlencode($business_id);

      return request(  env('YELP_API_HOST'), $business_path);
    }

    public function query_api($term, $location) {
      $response = json_decode(search($term, $location));
      $business_id = $response->businesses[0]->id;

      print sprintf(
          "%d businesses found, querying business info for the top result \"%s\"\n\n",
          count($response->businesses),
          $business_id
        );

        $response = get_business($business_id);

        print sprintf("Result for business \"%s\" found:\n", $business_id);
        $pretty_response = json_encode(json_decode($response), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        print "$pretty_response\n";
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
