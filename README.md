# EBayApi (1131)
The Package will make easy handling ebay api calls

#### 01.Installation
###### The SDK can be installed with [**Composer**](https://getcomposer.org/).

1. Install Composer to your local/development environment 
2. Run command
    `composer require ebay/ebay_easier`
3. Require Composer's autoloader by adding the following line to your code.
    ```php
    require 'vendor/autoload.php';
   ```
4. use namespace of the package `ebay\eBayEasier\EBayTradingApi`  
    ```php
   use ebay\eBayEasier\EBayTradingApi;
   ``` 
###### Othewise you may just clone / download the package library File.

01. Install [**GIT**](https://git-scm.com/downloads) on your local/developemnt environment
02. Run command 
    `git clone https://github.com/MohamedFaalil/eBayEasier.git`
03. Import Package 
04. use namespace of the package `ebay\eBayEasier\EBayTradingApi`  
     ```php
    use ebay\eBayEasier\EBayTradingApi;
    ```    

#### 02. Developer Guide
Following calls are mostly expected an associative array as parameter which needs to construct according<br/>
 specific eBay API calls. Refer eBay Trading API [**Documentation**](https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/index.html) while using each specific function. <b>No need to worry about 
 XML root</b> just construct <b>inner key, values</b> correctly
<ol>
<li>
 <h5>Instantiate the object</h5> 

 ```php
try{
    $ebayTrading = new EBayTradingApi($token,$devId,$appId,$certName,$url);
}catch(Exception $e){
    print 'Error ' . $e->getMessage();
}
 ```
Respectively token , devId, appId , certId, url are required for the constructer method. Above credentials are more important to make each http hits.
</li>
<li>
 <h5>getTokenStatus() method.</h5>
 Method **no required** any parameters.
 Method returns an array with respective value such following

```php
      [
               'http_code' => (int)_ _ _ _
               'status' => (string)_ _ _ _
               'response' => (array)_ _ _ _ _
      ]
```

```php
try{
    $ebayTrading = new EBayTradingApi($token,$devId,$appId,$certName,$url);
    $tokenStatusResponse = $ebayTrading->getTokenStatus();
    print_r($tokenStatusResponse);
}catch(Exception $e){
    print 'Error ' . $e->getMessage();
}
``` 

Sample Output :-
```php
Array(
    [http_code] => 200
    [status] => OK
    [response] => Array
        (
            [Timestamp] => 
            [Ack] => Success
            [Version] => 1123
            [Build] => 
            [TokenStatus] => Array
                (
                    [Status] => Active
                    [EIASToken] => 
                    [ExpirationTime] => 
                )

        )

)
```
</li>

<li>
 <h5>getItem($postBody) method.</h5><br/>
The GetItem call returns listing data such as title, description, price information, user information, and so on, for the specified ItemID.<br/>

Function requires a parameter. which may be<br/>
**(int/string) itemId** or **an associative array** of postBody as an associative array according eBay API [**Documentation**](https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/GetItem.html). <br/>
**Eg :-**
```php
try{
    $ebayTrading = new EBayTradingApi($token,$devId,$appId,$certName,$url);
    $postBody = 178218224608;
    // --- or ---
    $postBody = [
        'IncludeItemCompatibilityList' => (bool),
        'IncludeItemSpecifics' => (bool),
        'IncludeTaxTable' => (bool),
        'IncludeWatchCount' =>(bool),
        'ItemID' => (string),
        'VariationSpecifics' => [
            'NameValueList'=>[
    
                ['Name' => (string),'Value' => (string)],
                ['Name' => (string),'Value' => (string)]
                ---------------------------------------more
            ]
            
        ],
        'MessageID' => (string)
    ];

    $response = $ebayTrading->getItem($postBody);

    print_r($response);
}catch(Exception $e){
    print 'Error ' . $e->getMessage();
}
```
Sample Output :-

```php
Array
(
    [http_code] => 200
    [status] => OK
    [response] => Array
        (
            [Timestamp] => 
            [Ack] => Success
            [Version] => 
            [Build] => 
            [Item] => Array
                (
                    [AutoPay] => true
                    [BuyerProtection] => 
                    [BuyItNowPrice] => 0.0
                    [Country] => 
                    [Currency] => 
                    [GiftIcon] => 0
                    [HitCounter] => 
                    [ItemID] => 
                    [ListingDetails] => Array
                        (
                        )

                    [ListingDuration] => 
                    [ListingType] => FixedPriceItem
                    [Location] => 
                    [PaymentMethods] => PayPal
                    [PayPalEmailAddress] => example@gmail.com
                    [PrimaryCategory] => Array
                        (
                            [CategoryID] => 
                            [CategoryName] => 
                        )

                    [PrivateListing] => false
 --------------------------- more
)
```
</li>
<li>
 <h5>addFixedPriceItem($postBody)  method.</h5><br/>
Use this call to define and list a new fixed-price item. This call returns the item ID for the new listing,<br/>
plus an estimation of the fees the seller will incur for posting the listing (not including the Final Value Fee,<br/>
which cannot be calculated until the listing has ended).<br/>

Function requires a parameter as [**an associative array**](https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/AddFixedPriceItem.html#Input) . 
```php
try{
    $ebayTrading = new EBayTradingApi($token,$devId,$appId,$certName,$url);

    $postBody = [
        'IncludeItemCompatibilityList' => (bool),
        'IncludeItemSpecifics' => (bool),
        'IncludeTaxTable' => (bool),
        'IncludeWatchCount' =>(bool),
        'ItemID' => (string),
        'VariationSpecifics' => [
            'NameValueList'=>[
    
                ['Name' => (string),'Value' => (string)],
                ['Name' => (string),'Value' => (string)]
                ---------------------------------------more
            ]
            
        ],
        'MessageID' => (string)
    ];

    $response = $ebayTrading->addFixedPriceItem($postBody);

    print_r($response);
}catch(Exception $e){
    print 'Error ' . $e->getMessage();
}
``` 
Sample Output:
```php
array (
  'name' => 'AddFixedPriceItemResponse',
  'value' => '',
  'attr' => 
      array (
      ),
      'children' => 
          array (
            0 => 
            array (
              'name' => 'Timestamp',
              'value' => '2019-10-31T20:39:16.515Z',
              'attr' => 
              array (
              ),
              'children' => 
              array (
              ),
            ),
-----------More ------
```
</li>
</ol>