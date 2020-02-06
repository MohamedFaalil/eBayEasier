<?php


namespace ebay\eBayEasier;
require dirname(__FILE__) . '/../vendor/autoload.php';

use Spatie\ArrayToXml\ArrayToXml;


/**
 * Class EBayTradingApi
 * Compatibility Level 1131
 * @package ebay\src
 */
class  EBayTradingApi
{

    /**
     *    =================> EbayTraingApi Object's Attributes <=================
     **/
    private $token, $apiDevId, $apiAppId, $apiCertName, $headers, $url, $siteId;
    private const COMPATIBILITY_LEVEL = 1131;
    private const CONTENT_TYPE = 'text/xml';

    /**
     *    =================> Ebay TradingApi Object's Main Functionalities <=================
     **/

    /**
     * ==> EBayTradingApi constructor. <==
     * Token Validation also called on constructor
     * @param $token
     * @param $apiDevId
     * @param $apiAppId
     * @param $apiCertName
     * @param $url
     * @throws \Exception
     */
    public function __construct($token, $apiDevId, $apiAppId, $apiCertName, $url,$siteId)
    {
        $this->setTokenAttribute($token);
        $this->setDevIdAttribute($apiDevId);
        $this->setAppIdAttribute($apiAppId);
        $this->setApiCertNameAttribute($apiCertName);
        $this->setUrlAttribute($url);
        $this->setSiteIdAttribute($siteId);

        $this->setPostHeaderAttribute();
        $this->tokenValidation();
    }

    /**
     * ==> GetTokenStatus Endpoint<==
     * call will be made by the function
     * while it calls.
     *
     * ( Expectation : retrieving the status of a user token,
     *   which represents permission for an application to access,
     *   on the user's behalf, eBay data using eBay APIs.)
     *
     * Gotten response xml , http_code & response status  return as following associative array
     *
     *
     * @return array
     * [
     * 'http_code' => (int)_ _ _ _
     * 'status' => (string)_ _ _ _
     * 'response' => (array)_ _ _ _ _
     * ]
     */
    public function getTokenStatus(): array
    {
        $headers = $this->headers;
        $postBodyArray = $this->getTokenDefaultArray();
        $postXml = $this->getXMLFromArray($postBodyArray,'GetTokenStatusRequest');
        $this->constructFullHeader('GetTokenStatus', strlen($postXml), $headers);
        $apiResponse = $this->sendPostRequest($postXml, $headers);
        $apiResponse['response'] = $this->xmlToArray($apiResponse['response']); //caught xml value castted to an array

        return $apiResponse;
    }

    /**
     * ==> GetItem Endpoint<==
     * call will be made by the function
     * while it calls.
     * @param $postBody
     *
     *  Gotten response xml , http_code & response status  return as following associative array
     *
     * @return array
     * [
     * 'http_code' => (int)_ _ _ _
     * 'status' => (string)_ _ _ _
     * 'response' => (array)_ _ _ _ _
     * ]
     * @throws \Exception
     */
    public function getItem($postBody): array
    {
        try{
            $headers = $this->headers;
            $postBodyArray = $this->getItemPostArray($postBody);
            $postXml = $this->getXMLFromArray($postBodyArray,'GetItemRequest');
            $this->constructFullHeader('GetItem',strlen($postXml),$headers);
            $apiResponse = $this->sendPostRequest($postXml, $headers);
            $apiResponse['response'] = $this->xmlToArray($apiResponse['response']); //caught xml value castted to an array

            return $apiResponse;
        }catch(Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * ==> AddFixedPriceItem Endpoint <==
     * call will be made by the function
     * while it calls.
     * @param $postBody
     *
     *   Gotten response xml , http_code & response status return as following associative array
     * @return array
     */
    public function addFixedPriceItem($postBody): array{
        $headers = $this->headers;
        if(!$this->isThisType($postBody,'array'))
            throw new \Exception('Invalid parameter: Array Expected');
        $postArray = $this->getAddFixedPriceItemArray($postBody);
        $postXml = $this->getXMLFromArray($postArray,'AddFixedPriceItemRequest');
        $this->constructFullHeader('AddFixedPriceItem',strlen($postXml),$headers);
        $apiResponse = $this->sendPostRequest($postXml, $headers);
        $apiResponse['response'] = $this->xmlToArray($apiResponse['response']); //caught xml value castted to an array

        return $apiResponse;
    }
    /**
     * ==> ReviseFixedPriceItem Endpoint <==
     * call will be made by the function
     * while it calls.
     * @param $postBody
     *
     *   Gotten response xml , http_code & response status return as following associative array
     * @return array
     */
    public function reviseFixedPriceItem($postBody): array{
        $headers = $this->headers;
        if(!$this->isThisType($postBody,'array'))
            throw new \Exception('Invalid parameter: Array Expected');
        $postArray = $this->getReviseFixedPriceItemArray($postBody);
        $postXml = $this->getXMLFromArray($postArray,'ReviseFixedPriceItemRequest');
        $this->constructFullHeader('ReviseFixedPriceItem',strlen($postXml),$headers);
        $apiResponse = $this->sendPostRequest($postXml, $headers);
        $apiResponse['response'] = $this->xmlToArray($apiResponse['response']);

        return $apiResponse;
    }

    /**
     * ==> RelistFixedPriceItem Endpoint <==
     * call will be made by the function
     * while it calls.
     * @param $postBody
     *
     *   Gotten response xml , http_code & response status return as following associative array
     * @return array
     * @throws \Exception
     */
    public function relistFixedPriceItem($postBody){
        $headers = $this->headers;
        if(!$this->isThisType($postBody,'array'))
            throw new \Exception('Invalid parameter: Array Expected');
        $postArray = $this->getRelistFixedPriceItem($postBody);
        $postXml = $this->getXMLFromArray($postArray,'RelistFixedPriceItemRequest');
        $this->constructFullHeader('RelistFixedPriceItem',strlen($postXml),$headers);
        $apiResponse = $this->sendPostRequest($postXml,$headers);
        $apiResponse['response'] = $this->xmlToArray($apiResponse['response']);

        return $apiResponse;
    }











    /**
     *    =================> EbayTraingApi Object's Sub/Helper Functionalities <=================
     **/

    /************* ==================> Common/Initial Sub/Helper Functionalities <================== *************/
    /**
     * Function exchange xml string to an array
     * @param string $xml
     * @return array
     */
    private function xmlToArray(string $xml): array
    {
        $xml = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        return json_decode($json, TRUE);
    }

    /**
     * Function sends POST request
     * @param string $post
     * @param array $headers
     * @return array
     */
    private function sendPostRequest(string $post, array $headers): array
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $this->url, [
            'body' => $post,
            'headers' => $headers
        ]);
        return [
            'http_code' => $response->getStatusCode(),
            'status' => $response->getReasonPhrase(),
            'response' => $response->getBody()->getContents(),
        ];
    }

    /**
     * Function sets DevId Attribute
     * @param $devId
     * @throws \Exception
     */
    private function setDevIdAttribute($devId)
    {
        if (empty($devId)) throw new \Exception('App Dev Name Not Found!');
        $this->apiDevId = $devId;
    }

    /**
     * Function sets token attribute
     * @param $token
     * @throws \Exception
     */
    private function setTokenAttribute($token)
    {
        if (empty($token)) throw new \Exception('Token Not Found!');
        $this->token = $token;
        return $this;
    }

    /**
     * Function sets AppId
     * @param $apiAppId
     * @throws \Exception
     */
    private function setAppIdAttribute($apiAppId)
    {
        if (empty($apiAppId)) throw new \Exception('Api App Name Not Found!');
        $this->apiAppId = $apiAppId;
    }

    /**
     * Function sets Cert Name
     * @param $apiCertName
     * @throws \Exception
     */
    private function setApiCertNameAttribute($apiCertName)
    {
        if (empty($apiCertName)) throw new \Exception('Api Cert Name Not Found!');
        $this->apiCertName = $apiCertName;
    }

    /**
     * Function sets api Url
     * @param $url
     * @throws \Exception
     */
    private function setUrlAttribute($url)
    {
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) throw new \Exception('Invalid url');
        $this->url = $url;
    }

    /**
     * Function sets default header array
     * with { compatibility level, dev id, app id, cert id/name , site id, content-type }
     */
    private function setPostHeaderAttribute()
    {
        $this->headers = [
            'X-EBAY-API-COMPATIBILITY-LEVEL' => self::COMPATIBILITY_LEVEL,
            'X-EBAY-API-DEV-NAME' => $this->apiDevId,
            'X-EBAY-API-APP-NAME' => $this->apiAppId,
            'X-EBAY-API-CERT-NAME' => $this->apiCertName,
            'X-EBAY-API-SITEID' => $this->siteId,
            'Content-Type' => self::CONTENT_TYPE
        ];
    }

    /**
     * Function sets site ID
     * @param $siteId
     */
    private function setSiteIdAttribute($siteId){
        $this->siteId = $siteId;
    }

    /**
     * Function sets additional header elements
     * that needed to post request to hit particular EBAY trading api endpoint
     * @param string $apiCallName
     * @param int $contentLength
     * @param $headers
     */
    private function constructFullHeader(string $apiCallName, int $contentLength, &$headers)
    {
        /* for normal curl
        array_push($headers, 'X-EBAY-API-CALL-NAME : ' . $apiCallName,
            'Content-Length : ' . $contentLength
        );
        */
        $headers['X-EBAY-API-CALL-NAME'] = $apiCallName;
        $headers['Content-Length'] = $contentLength;
    }

    /**
     * Function validates the type of value wich is parsed as $type parameter
     * (SIDE NOTE : PHP Language can return following possible types:
     *    { integer , double ,string ,array ,object, NULL, resource }
     *  Non of above mentioned types the function returns false (means unknown type)
     *  )
     * @param $value
     * @param string $type
     * @return bool
     */
    private function isThisType($value, string $type): bool
    {
        return strtolower(gettype($value)) == $type ? true : false;
    }

    /**
     * Function return XML
     * @param $postBodyArray
     * @param $rootName
     * @param array $rootAttribute
     * @return string|XML
     */
    private function getXMLFromArray($postBodyArray, $rootName,
                                     $rootAttribute = ['xmlns' => 'urn:ebay:apis:eBLBaseComponents',])
    {
        return ArrayToXml::convert($postBodyArray, [
            'rootElementName' => $rootName,
            '_attributes' => $rootAttribute,
        ], true, 'utf-8');
    }

    /**
     * Set Request Credentials with eBay Auth Token
     * warningLevel(if not exists) and error language(if not exists)
     * @param $postArray
     * @return mixed
     */
    private function setMandatoryPartsOnPostArray($postArray){
        $postArray['RequesterCredentials'] = [
            'eBayAuthToken' => $this->token
        ];
        if(!array_key_exists('ErrorLanguage', $postArray))
            $postArray['ErrorLanguage'] = 'en_US';
        if(!array_key_exists('WarningLevel',$postArray))
            $postArray['WarningLevel'] = 'High';

        return $postArray;
    }


    /************* ==================> Specific Sub/Helper Functionalities <================== *************/
    private function getTokenDefaultArray()
    {
        return [
            'RequesterCredentials' => [
                'eBayAuthToken' => $this->token
            ]
        ];
    }

    /**
     * Returns essential default array with item Id and token
     * @param int $itemId
     * @return array
     */
    private function getItemDefaultArray(int $itemId){
        return [
          'RequesterCredentials'=>[
              'eBayAuthToken' => $this->token
          ],
          'ItemID' => $itemId
      ];
    }

    /**
     * If parameter is interger then call getItemDefaultArray and returns
     * otherwise make full array by including token
     * @param $postBody
     * @return array|mixed
     * @throws \Exception
     */
    private function getItemPostArray($postBody){
        if(empty($postBody))
            throw new \Exception('Function never works with empty parameters');
        else if($this->isThisType($postBody,'integer')) // integer parameter set as itemID
            return $this->getItemDefaultArray($postBody);
        else if(is_string($postBody) && is_numeric($postBody)) // string type numeric value also set as itemID
            return  $this->getItemDefaultArray((int)$postBody);
        else if($this->isThisType($postBody,'array'))
            return  $this->setMandatoryPartsOnPostArray($postBody);
        else
            throw new \Exception('Invalid parameter');
    }

    /**
     * make full AddFixedPriceItem Post Data Array by including token,Warning Level and Error Language
     * @param $postBody
     * @return mixed
     */
    private function getAddFixedPriceItemArray($postBody){
        $postArray = $this->setMandatoryPartsOnPostArray($postBody);
        return $postArray;
    }

    /**
     * make full ReviseFixedPriceItem Post Data Array by including token,Warning Level and Error Language
     * @param $postBody
     * @return mixed
     */
    private function getReviseFixedPriceItemArray($postBody){
        $postArray = $this->setMandatoryPartsOnPostArray($postBody);
        return $postArray;
    }

    /**
     * make full RelistFixedPriceItem Post Data Array by including token,Warning Level and Error Language
     * @param $postBody
     * @return mixed
     */
    private function getRelistFixedPriceItem($postBody){
        $postArray = $this->setMandatoryPartsOnPostArray($postBody);
        return $postArray;
    }

    /**
     * If there is any errors on token status it will be thrown as exception error
     * otherwise returns true
     * @return bool
     * @throws \Exception
     */
    private function tokenValidation(): bool
    {
        try {
            $tokenResponse = $this->getTokenStatus();
            if (strtolower($tokenResponse['response']['TokenStatus']['Status']) != 'active')
                throw new \Exception($tokenResponse['response']['TokenStatus']['Status']);
            return true;
        } catch (\Exception $e) {
            throw  new \Exception($e->getMessage());
        }
    }

}