<?php


namespace ebay\eBayEasier;
require dirname(__FILE__) . '/../vendor/autoload.php';

use Spatie\ArrayToXml\ArrayToXml;


/**
 * Class EBayTradingApi
 * @package ebay\src
 */
class  EBayTradingApi
{

    /**
     *    =================> EbayTraingApi Object's Attributes <=================
     **/
    private $token, $apiDevId, $apiAppId, $apiCertName, $header, $url;
    private const COMPATIBILITY_LEVEL = 1131;
    private const SITE_ID = 15;
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
    public function __construct($token, $apiDevId, $apiAppId, $apiCertName, $url)
    {
        $this->setTokenAttribute($token);
        $this->setDevIdAttribute($apiDevId);
        $this->setAppIdAttribute($apiAppId);
        $this->setApiCertNameAttribute($apiCertName);
        $this->setUrlAttribute($url);

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
     * Gotten response xml , http_code & response status will be return as following associative array
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
        $headers = $this->header;
        $postBodyArray = $this->getTokenDefaultArray();
        $postXml = $this->getXMLFromArray($postBodyArray,'GetTokenStatusRequest');
        $this->constructFullHeader('GetTokenStatus', strlen($postXml), $headers);
        $apiResponse = $this->sendPostRequest($postXml, $headers);
        $apiResponse['response'] = $this->xmlToArray($apiResponse['response']); //caught xml value castted to an array

        return $apiResponse;
    }

    public function getItem($postBody): array
    {
        if($this->isThisType($postBody,'integer'))
            print 'int';
        else
            print 'other';
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
        $this->header = [
            'X-EBAY-API-COMPATIBILITY-LEVEL' => self::COMPATIBILITY_LEVEL,
            'X-EBAY-API-DEV-NAME' => $this->apiDevId,
            'X-EBAY-API-APP-NAME' => $this->apiAppId,
            'X-EBAY-API-CERT-NAME' => $this->apiCertName,
            'X-EBAY-API-SITEID' => self::SITE_ID,
            'Content-Type' => self::CONTENT_TYPE
        ];
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
     * Function returns response
     * If only if there have no http errors(unless 200 http code)
     * Or Response Ack failure state
     * otherwise particular error state will be thrown as exception
     * @param array $response
     * @return mixed
     * @throws \Exception
     */
    private function responseWithValidation(array $response)
    {
        if ($response['http_code'] != 200)
            throw new \Exception('http code : ' . $response['http_code'] . PHP_EOL . ' status : ' . $response['status']);
        elseif (strtolower($response['response']['Ack']) == 'failure')
            throw new \Exception($response['response']['Errors']['ShortMessage'] . PHP_EOL . $response['response']['Errors']['LongMessage'] . PHP_EOL . 'Error Code : ' . $response['response']['Errors']['ErrorCode']);
        else
            return $response['response'];
    }

    private function getXMLFromArray($postBodyArray, $callName,
                                     $rootAttribute = ['xmlns' => 'urn:ebay:apis:eBLBaseComponents',])
    {
        return ArrayToXml::convert($postBodyArray, [
            'rootElementName' => $callName,
            '_attributes' => $rootAttribute,
        ], true, 'utf-8');
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
     * If there is any errors on token status it will be thrown as exception error
     * otherwise returns true
     * @return bool
     * @throws \Exception
     */
    private function tokenValidation(): bool
    {
        try {
            $tokenResponse = $this->responseWithValidation($this->getTokenStatus());
            if (strtolower($tokenResponse['TokenStatus']['Status']) != 'active')
                throw new \Exception($tokenResponse['TokenStatus']['Status']);
            return true;
        } catch (\Exception $e) {
            throw  new \Exception($e->getMessage());
        }
    }

}