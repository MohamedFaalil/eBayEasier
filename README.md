<h1>EBayApi-simplifier package(1139)</h1> 
The Package will make easy to handle ebay api calls

# My Table of content
01. [Requirement](#requirement) 
02. [Installation](#installation)
03. [Developer Guide](#guide) <br/>
    i.    [Instantiate the eBay Trading API object](#1) <br/>
    ii.   [getTokenStatus() method.](#2) <br/>
    iii.  [getItem() method.](#3) <br/>
    iv.   [getStore() method.](#4) <br/>
    v.    [getOrders() method.](#5) <br/>
    vi.   [addFixedPriceItem() method.](#6) <br/>
    vii.  [reviseFixedPriceItem() method](#7) <br/>
    viii. [relistFixedPriceItem() method](#8) <br/>
    ix.   [reviseInventoryStatus() method](#9) <br/>
    x.    [completeSale() method](#10) <br/>
    xi.   [getEbayCategories() method](#11) <br/>
    xii.  [endFixedPriceItemRequest() method](#12) <br/>

#### <span id="requirement">01. Requirement</span>
<hr/>
<ol>
    <li><b>PHP > 7.1</b></li>
    <li>Laravel 5.x | 6.x</li>
</ol>

#### 02.<span id="installation">Installation</span>
<hr/>
<b>Library can be installed with <a href="https://getcomposer.org/">Composer</a></b>.

1. Install Composer to your local/development environment 
2. Run command
    <code>composer require ebay/ebay-simplifier</code>
3. Import/Require Composer's autoloader by adding the following line on your code.
    <code>require 'vendor/autoload.php';</code> 
4. use namespace of the package 
   <code>use ebay\ebaySimplifier\EBayTradingApi;</code>  

#### 03. <span id="guide">Developer Guide</span>
<hr/>
<p>Following calls are mostly expected an associative array as parameter which needs to construct according
 specific eBay API calls. Refer the eBay Trading API <a href="https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/index.html">Documentation</a> while using each specific function.</p>
<p><b>No need to worry about 
 XML root</b> just construct <b>inner key, value</b> pairs correctly</p>
Eg: Consider the Following Request XML

```xml
<?xml version="1.0" encoding="utf-8"?>
<GetStoreRequest xmlns="urn:ebay:apis:eBLBaseComponents">
  <RequesterCredentials>
    <eBayAuthToken>ABC...123</eBayAuthToken>
  </RequesterCredentials>
  <!-- Call-specific Input Fields -->
  <CategoryStructureOnly> boolean </CategoryStructureOnly>
  <LevelLimit> int </LevelLimit>
  <RootCategoryID> long </RootCategoryID>
  <UserID> UserIDType (string) </UserID>
  <!-- Standard Input Fields -->
  <ErrorLanguage> string </ErrorLanguage>
  <MessageID> string </MessageID>
  <Version> string </Version>
  <WarningLevel> WarningLevelCodeType </WarningLevel>
</GetStoreRequest>
```
Make an array simply as following

```php
$post_data = [
    'CategoryStructureOnly' => 'bool',
    'LevelLimit' => 'int',
    'RootCategoryID' =>'long',
    'UserID' => 'string',
    'MessageID' => 'string',
    'Version' => 'string',
];
```
ErrorLanguage and WarningLevel fields are set by default respectively <b>en_US , High</b> If wants to change default values can simply over ride by setting the those key, value pair on the array.
<br/><b>Note : RequesterCredentials with token will be set by constructer parameter. So just ignore it.</b>

<ol>
<li>
 <h5 id="1">Instantiate the eBay Trading API object</h5><hr/> 

 ```php
try{
    $ebayTrading = new EBayTradingApi($token,$devId,$appId,$certName,$url,$siteId);
}catch(Exception $e){
    print 'Error ' . $e->getMessage();
}
 ```
<b>Note: Respectively token , devId, appId , certId, url, siteId are required for the constructor method.</b>
</li>
<li>
 <h5 id="2">getTokenStatus() method.</h5><hr/>
 Method <b>No Required</b> any parameters.
 Method returns an array with respective key,value pair as an array.

```php
      [
               'http_code' => (int)_ _ _ _
               'status' => (string)_ _ _ _
               'response' => (array)_ _ _ _ _
      ]
```

```php
try{
    $ebayTrading = new EBayTradingApi($token,$devId,$appId,$certName,$url,$siteId);
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
 <h5 id="3">getItem() method.</h5><hr/>
The GetItem call returns listing data such as title, description, price information, user information, and so on, for the specified ItemID.<br/>

Function requires a parameter. which may be<br/>
**(int/string) itemId** or **an associative array** as postBody according eBay API [**Requirements**](https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/GetItem.html#input). <br/>
**Eg :-**
```php
try{
    $ebayTrading = new EBayTradingApi($token,$devId,$appId,$certName,$url,$siteId);
    $postBody = 178218224608;
    // --- OR ---
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
<a href="https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/GetItem.html#Output">Sample Output :-</a>

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
 // --------------------------- MORE --------------
)
```
</li>
<li>
<h5 id="4">getStore() method.</h5><hr/>
Use this call to retrieve configuration information for the eBay store owned by the user specified with UserID. If you do not specify a UserID, the store configuration information is returned for the authenticated caller <a href="https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/GetItem.html">( API DOCUMENTATION) </a><br/>

**Empty parameter** or **An Associative array** as postBody according eBay API [**Requirement**](https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/GetStore.html#Input). <br/>
**Eg:**
```php
try{
    $ebayTrading = new EBayTradingApi($token,$devId,$appId,$certName,$url,$siteId);

    $response = $ebayTrading->getItem();
    /** --- OR --- **/
   $postBody = [
   	'CategoryStructureOnly' => 
   	'LevelLimit' => 
   	'RootCategoryID' => 
   	'UserID' => 
    // ------------ More --------------
   ];

    $response = $ebayTrading->getStore();

    print_r($response);
}catch(Exception $e){
    print 'Error ' . $e->getMessage();
}
```
<a href="https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/GetItem.html#Output">Sample Output :-</a>

```php
array (
  'Store' => 
  array (
    'CustomCategories' => 
    array (
      'CustomCategory' => 
      array (
        'CategoryID' => 'long',
        'ChildCategory' => 
        array (
          'CategoryID' => 'long',
          'ChildCategory' => 
          array (
            'CategoryID' => 'long',
            'ChildCategory' => 'StoreCustomCategoryType',
            'Name' => 'string',
            'Order' => 'int',
            '__text' => 'StoreCustomCategoryType',
          ),
          'Name' => 'string',
          'Order' => 'int',
          '__text' => 'StoreCustomCategoryType',
        ),
        'Name' => 'string',
        'Order' => 'int',
        '__text' => 'StoreCustomCategoryType',
      ),
      '__text' => 'StoreCustomCategoryArrayType',
    ),
// ------------ More -----------------
```
</li>
<li>
  <h5 id="5">getOrders() method.</h5><hr/>
  
GetOrders is the recommended call to use for order (sales) management. Use this call to retrieve all orders in which the authenticated caller is either the buyer or seller. The order types that can be retrieved
with this call are discussed on eBay [**Documentation**](https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/GetOrders.html)  

Expected [**an associative array**](https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/GetOrders.html#Input) as parameter for the function calling.
**Eg:**
```php
try{
    $ebayTrading = new EBayTradingApi($token,$devId,$appId,$certName,$url,$siteId);
    $postBody = [
        'CreateTimeFrom' => 
        'CreateTimeTo' => 
        'OrderRole' => 
        // ------------ More --------------
       ];

    $response = $ebayTrading->getOrders($postBody);   
    print_r($response);
}catch(Exception $e){
    print 'Error ' . $e->getMessage();
}
```
<a href="https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/GetOrders.html#Output">Sample Output :-</a>
```php
[
    'HasMoreOrders' => ,
    'OrderArray' => [
                'Order' =>[ 
                    'AdjustmentAmount' => [ 
                                '@attributes' =>[
                                        'currencyID' => CurrencyCodeType,
                                                ],
                                '_value' =>  'Amount (double)'
                    ],
                    'AmountPaid' => [
                                      '@attributes' =>[
                                                      'currencyID' => CurrencyCodeType
                                                      ],
                                      '_value' => 'AmountType (double)'
                                    ],
                        ]
                     ],
    
    // ------------ More ---------------
];
``` 
</li>
<li>
 <h5 id="6">addFixedPriceItem()  method.</h5><hr/>
Use this call to define and list a new fixed-price item. This call returns the item ID for the new listing,<br/>
plus an estimation of the fees the seller will incur for posting the listing (not including the Final Value Fee,<br/>
which cannot be calculated until the listing has ended) (Detail From <a href="https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/AddFixedPriceItem.html">Documentation</a>).<br/>

Function requires a parameter as [**an associative array**](https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/AddFixedPriceItem.html#Input) . 
```php
try{
    $ebayTrading = new EBayTradingApi($token,$devId,$appId,$certName,$url,$siteId);

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
                ----------------------------more------------------
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
<a href="https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/AddFixedPriceItem.html#Output">Sample Output:</a>
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
// -----------More ------
```
</li>
<li>
    <h5 id="7">reviseFixedPriceItem() method</h5><hr/>
    Use this call to change the properties of a currently active fixed-price listing (including multi-variation listings). 
    <a href="https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/ReviseFixedPriceItem.html">Documentation</a> <br/>
   
   Please [**refer the documentation**](https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/ReviseFixedPriceItem.html#Input) before construct the parameter array
```php
$ebayTrading = new EBayTradingApi($token,$devId,$appId,$certName,$url,$siteId);

        $postBody = [
        	'Item' => [
        	    'ItemID'=>110038081632	      
        		],
        	'Variations' => [
        	     'Variation'=>[
        		     'SKU'=>'RLauren_Wom_TShirt_Pnk_S',
        		     'StartPrice' => 14.99,
        		     'Quantity'=> 4,
        		     'VariationSpecifics' => [
        				'NameValueList' => [
        					[
        					'Name'=>'Color',
        					'Value' => Pink
        					],
        					[
        					'Name' => 'Size',
        					'Value' => 'S'
        					]
        				                   ],
        			                         ]
        		                ],
        // ------------More Variation-------------
        		            ] //variations end
        ];
    
            $response = $ebayTrading->reviseFixedPriceItem($postBody);
        
            print_r($response);
        }catch(Exception $e){
            print 'Error ' . $e->getMessage();
        }
```
<a href="https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/ReviseFixedPriceItem.html#Output">Sample Output:</a>
```php
[
	'Timestamp' => '2019-11-06T18:40:55.049Z',
	'Ack'=>'Success',
	'Version' => 1131,
	'Build' => 'E1131_UNI_API5_19098188_R1',
	'ItemID'=>110038081632,
	'StartTime'=>'2019-11-06T18:40:55.049Z',
	'Fees'=> [
		 	'Fee'=>[
				 [
				  'Name' => 'AuctionLengthFee',
				  'Fee'=>0.0
				 ],
				 [
				  'Name' => 'BoldFee',
				  'Fee'=>0.0
				 ],
                                 [
				  'Name' => 'BuyItNowFee',
				  'Fee'=>0.0
				 ],
			       ]
		 ]
];
``` 
   
     
</li>
<li>
    <h5 id="8">relistFixedPriceItem() method</h5><hr/>
    Use this call to relist a single fixed-price item or a single multi-item listing that has ended. The item may be relisted as it was originally defined, or the seller may change
       <a href="https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/RelistFixedPriceItem.html">(Details Source)</a><br/>
   
   **Function Requires an array as parameter**
   Please [**refer the documentation**](https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/RelistFixedPriceItem.html#Input) before construct the  array
```php
$ebayTrading = new EBayTradingApi($token,$devId,$appId,$certName,$url,$siteId);

        $post_data = [
        	'Item' => [
        	    'ItemID'=>110038081632	      
        		],
        	'Variations' => [
        	     'Variation'=>[
        		     'SKU'=>'RLauren_Wom_TShirt_Pnk_S',
        		     'StartPrice' => 14.99,
        		     'Quantity'=> 4,
        		     'VariationSpecifics' => [
        				'NameValueList' => [
        					[
        					'Name'=>'Color',
        					'Value' => Pink
        					],
        					[
        					'Name' => 'Size',
        					'Value' => 'S'
        					]
        				                   ],
        			                         ]
        		                ],
        // ------------More Variation-------------
        		            ] //variations end
        ];
    
            $response = $ebayTrading->relistFixedPriceItem($post_data);
        
            print_r($response);
        }catch(Exception $e){
            print 'Error ' . $e->getMessage();
        }
```
<a href="#">Sample Output:</a>
```php
[
	'Category2ID' => '',
	'CategoryID'=>'',
	'DiscountReason' => '',
	'EndTime' => '',
	'Fees'=>[
        'Fee' => [
            
         ]       
    ],
	// ---- More --- 
];
```    
</li>
<li>
    <h5 id="9">reviseInventoryStatus() method</h5><hr/>
    This call enables a seller to change the price and/or quantity of up to four active, fixed-price listings. The fixed-price listing(s) to modify are  <a href="https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/ReviseInventoryStatus.html">................... (Visit documentation page for more details)</a> <br/>
   
   **Function Requires an array as parameter**.
   Please [**refer the documentation**](https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/ReviseInventoryStatus.html#Input) before construct the associative array
```php
$ebayTrading = new EBayTradingApi($token,$devId,$appId,$certName,$url,$siteId);

        $post_data = [
        	'InventoryStatus' => [
                    [
                        'ItemID'=>'',
                        'Quantity'=> '',
                    ],
                    [ 
                        'SKU'=>'',
                        'ItemID'=>'',
                        'Quantity'=>''
                    ]       
        	          
        		],
        // ------------More Variation-------------
        		            ] //variations end
        ];
    
            $response = $ebayTrading->reviseInventoryStatus($post_data);
            print_r($response);
        }catch(Exception $e){
            print 'Error ' . $e->getMessage();
        }
```
<a href="https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/ReviseInventoryStatus.html#Output">Sample Output:</a>
```php
Array
(
    [ReviseInventoryStatusResponse] => Array
        (
     
            [Fees] => Array
                (
           
                    [Fee] => Array
                        (
                            [#text] => Array
                                (
                                    [0] => Array
                                        (
                                        )

                                    [1] => Array
                                        (
                                        )

                                    [2] => Array
                                        (
                                        )

                                    [3] => Array
                                        (
                                        )

                                )

                            [Fee] => Array
                                (
                                    [@attributes] => Array
                                        (
                                            [currencyID] => CurrencyCodeType
                                        )

                                    [_value] =>  AmountType (double)
                                )

                            [Name] =>  string
                            [PromotionalDiscount] => Array
                                (
                                    [@attributes] => Array
                                        (
                                            [currencyID] => CurrencyCodeType
                                        )

                                    [_value] =>  AmountType (double)
                                )

                        )

                    [#comment] => Array
                        (
                        )

                    [ItemID] =>  ItemIDType (string)
                )

            [InventoryStatus] => Array
                (
                    [#text] => Array
                        (
                            [0] => Array
                                (
                                )

                            [1] => Array
                                (
 //-------------------- More -----------------------
```    
</li>
<li>
    <h5 id="10">completeSale() method</h5><hr/>
    This <a href="https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/CompleteSale.html">API call</a> Use to do various tasks after the creation of a single line item or multiple line item order.
    <br/>
   
   **Function Requires an array. **
   Please <a href="https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/CompleteSale.html#Input">refer the documentation</a> before construct the associative array
```php
        $ebayTrading = new EBayTradingApi($token,$devId,$appId,$certName,$url,$siteId);
        $post_data = [  
                     'FeedbackInfo' => [
                                        'CommentText'=> 'Wonderful buyer!',
                                        'CommentType' => 'Positive',
                                        'TargetUse' => 'bestbuyerever',
                                        ],
                    
                     'ItemID' => 123438071240,
                     'TransactionID' => 0,
        // ---------- More ---------------
                    ];
    
            $response = $ebayTrading->completeSale($post_data);
            print_r($response);
        }catch(Exception $e){
            print 'Error ' . $e->getMessage();
        }
```
<a href="https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/CompleteSale.html#Output">Sample Output:</a>
```php
Array
(
            [Ack] =>  AckCodeType
            [Build] =>  string
            [CorrelationID] =>  string
            [Errors] => Array
                (
                    

                    [ErrorClassification] =>  ErrorClassificationCodeType
                    [ErrorCode] =>  token
                    [ErrorParameters] => Array
                        (
                            [@attributes] => Array
                                (
                                    [ParamID] => string
                                )

                    
                            [Value] =>  string
                        )

                    [LongMessage] =>  string
                    [SeverityCode] =>  SeverityCodeType
                    [ShortMessage] =>  string
                )

            [HardExpirationWarning] =>  string
            [Timestamp] =>  dateTime
            [Version] =>  string
        

)
```
</li>
<li>
    <h5 id="11">getEbayCategories() method</h5><hr/>
    Use this call to retrieve the latest category hierarchy for the eBay site specified in the CategorySiteID property. By default, this is the site to which you submit the request. You can retrieve all categories on the site, or you can use CategoryParent to retrieve one particular category and its subcategories. The returned category list is contained in the CategoryArray property.
    <br/>
   
   **Function can be contain empty or  an array as parameter. **
   Please <a href="https://developer.ebay.com/devzone/xml/docs/reference/ebay/GetCategories.html#Input">refer the documentation</a> before construct the associative array
```php
        $ebayTrading = new EBayTradingApi($token,$devId,$appId,$certName,$url,$siteId);
        $post_data = [  
                     'FeedbackInfo' => '',
                    
                     'ViewAllNodes' => (bool){default true},
                  
        // ---------- More ---------------
                    ];
    
            $response = $ebayTrading->getEbayCategories($post_data);
                //OR
             $response = $ebayTrading->getEbayCategories();
                print_r($response);
        }catch(Exception $e){
            print 'Error ' . $e->getMessage();
        }
```
<a href="https://developer.ebay.com/devzone/xml/docs/reference/ebay/GetCategories.html#Output">Sample Output:</a>
```php
Array
(
            ['CategoryArray'] => [
                'Category' => [
                    'AutoPayEnabled' => '',
                     'B2BVATEnabled' => '',
                     'BestOfferEnabled' => ''
                ]
            ]

        //  `````   More   ````

)
```
</li>
<li>
	#### <span id="12">12. endFixedPriceItemRequest() method</span>
	Function require ItemID and optional params.
	
```php

	try{
	     $ebayTrading = new EBayTradingApi($token,$devId,$appId,$certName,$url,$siteId);
             $post_data = [  
			     'EndingReason' => 'OtherListingError',

			    ];
    
            $response = $ebayTrading->getEbayCategories($itemId ,$post_data);
            print_r($response);
        }catch(Exception $e){
            print 'Error ' . $e->getMessage();
        }
```
	
</li>
</ol>
