<?php

namespace ebay\ebaySimplifier;

use GuzzleHttp\Client;
use Spatie\ArrayToXml\ArrayToXml;


/**
 * Class EBayTradingApi ( Compatibility Level 1131 )
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
    public function __construct($token, $apiDevId, $apiAppId, $apiCertName, $url, $siteId)
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
        $postArray = $this->getTokenDefaultArray();
        return $this->executeSendPostRequestWithEssentials($postArray,
            'GetTokenStatusRequest', $headers);
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
        try {
            $headers = $this->headers;
            $postArray = $this->getItemPostArray($postBody);
            return $this->executeSendPostRequestWithEssentials($postArray,
                'GetItemRequest', $headers);
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * ==> GetStore Endpoint <==
     * call will be made by the function
     * while it calls.
     *
     * Empty parameter or array will be accepted
     * @param null(default) $postBody
     *
     * Gotten response xml , http_code & response status return as following associative array
     * @return array
     * @throws \Exception
     */
    public function getStore($postBody = null): array
    {
        try {
            $headers = $this->headers;
            $postArray = $this->getGetStoreArray($postBody);
            return $this->executeSendPostRequestWithEssentials($postArray,
                'GetStoreRequest', $headers);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * ==> GetOrders Endpoint <==
     * call will be made by the function
     * while it calls.
     * @param $postBody
     *
     *  Gotten response xml , http_code & response status  return as following associative array
     * @return array
     * @throws \Exception
     */
    public function getOrders($postBody){
        if (!$this->isThisType($postBody, 'array'))
            throw new \Exception('Invalid parameter: Array Expected');
        $headers = $this->headers;
        $postArray = $this->getOrdersArray($postBody);
        return $this->executeSendPostRequestWithEssentials($postArray,
            'GetOrdersRequest', $headers);
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
    public function addFixedPriceItem($postBody): array
    {
        if (!$this->isThisType($postBody, 'array'))
            throw new \Exception('Invalid parameter: Array Expected');
        $headers = $this->headers;
        $postArray = $this->getAddFixedPriceItemArray($postBody);
        return $this->executeSendPostRequestWithEssentials($postArray,
            'AddFixedPriceItemRequest', $headers);
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
    public function reviseFixedPriceItem($postBody): array
    {
        if (!$this->isThisType($postBody, 'array'))
            throw new \Exception('Invalid parameter: Array Expected');
        $headers = $this->headers;
        $postArray = $this->getReviseFixedPriceItemArray($postBody);
        return $this->executeSendPostRequestWithEssentials($postArray,
            'ReviseFixedPriceItemRequest', $headers);
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
    public function relistFixedPriceItem($postBody): array
    {
        if (!$this->isThisType($postBody, 'array'))
            throw new \Exception('Invalid parameter: Array Expected');
        $headers = $this->headers;
        $postArray = $this->getRelistFixedPriceItemArray($postBody);
        return $this->executeSendPostRequestWithEssentials($postArray,
            'RelistFixedPriceItemRequest', $headers);
    }

    /**
     * ==> ReviseInventoryStatus Endpoint <==
     * call will be made by the function
     * while it calls.
     * @param $postBody
     *
     *      Gotten response xml , http_code & response status return as following associative array
     * @return array
     * @throws \Exception
     */
    public function reviseInventoryStatus($postBody): array
    {
        $headers = $this->headers;
        if (!$this->isThisType($postBody, 'array'))
            throw new \Exception('Invalid parameter: array expected');
        $postArray = $this->getReviseInventoryStatusArray($postBody);
        return $this->executeSendPostRequestWithEssentials($postArray,
            'ReviseInventoryStatusRequest', $headers);
    }

    /**
     * ==> CompleteSale Endpoint <==
     * call will be made by the function
     * while it calls.
     * @param $postBody
     *
     *      Gotten response xml , http_code & response status return as following associative array
     * @return array
     * @throws \Exception
     */
    public function completeSale($postBody): array
    {
        if (!$this->isThisType($postBody, 'array'))
            throw new \Exception('Invalid parameter: array expected');
        $headers = $this->headers;
        $postArray = $this->getCompleteSaleArray($postBody);
        return $this->executeSendPostRequestWithEssentials($postArray,
            'CompleteSaleRequest', $headers);
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
        $previous_value = libxml_use_internal_errors(true);
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->loadXml($xml);
        libxml_use_internal_errors($previous_value);
        if (libxml_get_errors()) {
            return [];
        }

        $resultArray = $this->DOMtoArray($dom);
        return $resultArray[$dom->documentElement->tagName];
    }

    /**
     * Helper function of xmlToArray
     * @param $root
     * @return array|mixed
     */
    private function DOMtoArray($root) {
        $result = array();

        if ($root->hasAttributes()) {
            $attrs = $root->attributes;
            foreach ($attrs as $attr) {
                $result['@attributes'][$attr->name] = $attr->value;
            }
        }

        if ($root->hasChildNodes()) {
            $children = $root->childNodes;
            if ($children->length == 1) {
                $child = $children->item(0);
                if (in_array($child->nodeType,[XML_TEXT_NODE,XML_CDATA_SECTION_NODE])) {
                    $result['_value'] = $child->nodeValue;
                    return count($result) == 1
                        ? $result['_value']
                        : $result;
                }

            }
            $groups = array();
            foreach ($children as $child) {
                if (!isset($result[$child->nodeName])) {
                    $result[$child->nodeName] = $this->DOMtoArray($child);
                } else {
                    if (!isset($groups[$child->nodeName])) {
                        $result[$child->nodeName] = array($result[$child->nodeName]);
                        $groups[$child->nodeName] = 1;
                    }
                    $result[$child->nodeName][] = $this->DOMtoArray($child);
                }
            }
        }
        return $result;
    }

    /**
     * ( Side Note: Making XML From postArray, making specific full headers array for the call
     *  Sending Request , Caught Response , make an array from response xml , return http_code,
     *  http_status, response_array)
     *
     *
     * @param $postArray
     * @param $rootName(Passed by reference)
     * @param $headers
     * @return array
     */
    private function executeSendPostRequestWithEssentials($postArray,$rootName,&$headers){
        $rootName = trim($rootName);
        $postXml = $this->getXMLFromArray($postArray, $rootName);
        $this->constructFullHeader(str_replace("Request","",$rootName),
            strlen($postXml), $headers);
        //caught response as received it is
        $apiResponse = $this->sendPostRequest($postXml, $headers);
        //caught xml value castted to an array
        $apiResponse['response'] = $this->xmlToArray($apiResponse['response']);

        return $apiResponse;
    }

    /**
     * Function sends POST request
     * @param string $post
     * @param array $headers
     * @return array
     */
    private function sendPostRequest(string $post, array $headers): array
    {
        $client = new Client();
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
    private function setSiteIdAttribute($siteId)
    {
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
    private function setMandatoryPartsOnPostArray($postArray)
    {
        $postArray['RequesterCredentials'] = [
            'eBayAuthToken' => $this->token
        ];
        if (!array_key_exists('ErrorLanguage', $postArray))
            $postArray['ErrorLanguage'] = 'en_US';
        if (!array_key_exists('WarningLevel', $postArray))
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
    private function getItemDefaultArray(int $itemId)
    {
        return [
            'RequesterCredentials' => [
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
    private function getItemPostArray($postBody)
    {
        if (empty($postBody))
            throw new \Exception('Function never works with empty parameters');
        else if ($this->isThisType($postBody, 'integer')) // integer parameter set as itemID
            return $this->getItemDefaultArray($postBody);
        else if (is_string($postBody) && is_numeric($postBody)) // string type numeric value also set as itemID
            return $this->getItemDefaultArray((int)$postBody);
        else if ($this->isThisType($postBody, 'array'))
            return $this->setMandatoryPartsOnPostArray($postBody);
        else
            throw new \Exception('Invalid parameter');
    }

    /**
     * make full AddFixedPriceItem Post Data Array by including token,Warning Level and Error Language
     * @param $postBody
     * @return mixed
     */
    private function getAddFixedPriceItemArray($postBody)
    {
        $postArray = $this->setMandatoryPartsOnPostArray($postBody);
        return $postArray;
    }

    /**
     * make full ReviseFixedPriceItem Post Data Array by including token,Warning Level and Error Language
     * @param $postBody
     * @return mixed
     */
    private function getReviseFixedPriceItemArray($postBody)
    {
        $postArray = $this->setMandatoryPartsOnPostArray($postBody);
        return $postArray;
    }

    /**
     * make full RelistFixedPriceItem Post Data Array by including token,Warning Level and Error Language
     * @param $postBody
     * @return mixed
     */
    private function getRelistFixedPriceItemArray($postBody)
    {
        $postArray = $this->setMandatoryPartsOnPostArray($postBody);
        return $postArray;
    }

    /**
     * make full ReviseInventoryStatusArray Post Data Array by including token,Warning Level and Error Language
     * @param $postBody
     * @return mixed
     */
    private function getReviseInventoryStatusArray($postBody)
    {
        $postArray = $this->setMandatoryPartsOnPostArray($postBody);
        return $postArray;
    }

    /**
     * Make GetStoreArray
     * (Side note: if empty parameter is passed then default array will be construct and assigned to $postArray
     *  otherwise passed array will be assigned as $postArray)
     * Finally $postarray will be appened with token , Warning level and Error Language language value
     *
     * @param $postBody
     * @return array|mixed
     * @throws \Exception
     */
    private function getGetStoreArray($postBody)
    {
        $postArray = [];
        if (is_null($postBody))
            $postArray = [
                'CategoryStructureOnly' => 'false',
                'LevelLimit' => 1
            ];
        else if ($this->isThisType($postBody, 'array'))
            $postArray = $postBody;
        else
            throw new \Exception('Invalid Parameter: Array Expected');

        $postArray = $this->setMandatoryPartsOnPostArray($postArray);
        return $postArray;

    }

    /**
     * make full CompleteSaleArray Post Data Array by including token,Warning Level and Error Language
     * @param $postBody
     * @return mixed
     */
    private function getCompleteSaleArray($postBody){
        $postArray = $this->setMandatoryPartsOnPostArray($postBody);
        return $postArray;
    }

    /**
     * make full getOrdersArray Post Data Array by including token,Warning Level and Error Language
     * @param $postBody
     * @return mixed
     */
    private function getOrdersArray($postBody){
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
            if(strtolower($tokenResponse['response']['Ack']) != 'success')
                throw new \Exception($tokenResponse['response']['Errors']['ShortMessage'] . ' , ' .
                    $tokenResponse['response']['Errors']['LongMessage'] . 'Error Code : ' .
                    $tokenResponse['response']['Errors']['ErrorCode']);
            else if (strtolower($tokenResponse['response']['TokenStatus']['Status']) != 'active')
                throw new \Exception($tokenResponse['response']['TokenStatus']['Status']);
            return true;
        } catch (\Exception $e) {
            throw  new \Exception($e->getMessage());
        }
    }

}