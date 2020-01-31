# EBayApi
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

01 - Instantiate the object 
```php
try{
    $ebayTrading = new EBayTradingApi($token,$devId,$appId,$certName,$url);
}catch(Exception $e){
    print 'Error ' . $e->getMessage();
}
```
Respectively token , devId, appId , certId, url are required for the constructer method. Above credentials are more important to make each http hits.

02 - getTokenStatus() method.
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
            [Timestamp] => 2020-01-30T10:08:34.596Z
            [Ack] => Success
            [Version] => 1123
            [Build] => E1123_INTL_APISIGNIN_19059236_R1
            [TokenStatus] => Array
                (
                    [Status] => Active
                    [EIASToken] => nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wMk4SiCpeCoAydj6x9nY+seQ==
                    [ExpirationTime] => 2020-09-17T22:32:48.000Z
                )

        )

)
```
03 - getItem() method.
`The GetItem call returns listing data such as title, description, price information, user information, and so on, for the specified ItemID.`
