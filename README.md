#### EBayApi-Simplifier (1131) <hr/>
The Package will make easy to handle ebay api calls

#### 01. Requirement
<hr/>
<ol>
    <li>PHP > 7.1</li>
    <li>Laravel 5.x|6.x</li>
</ol>

#### 02.Installation
<hr/>
###### The SDK can be installed with [**Composer**](https://getcomposer.org/).

1. Install Composer to your local/development environment 
2. Run command
    <code>composer require ebay/ebay_easier</code>
3. Require Composer's autoloader by adding the following line to your code.
    <code>require 'vendor/autoload.php';</code> 
4. use namespace of the package 
   <code>use ebay\ebaySimplifier\EBayTradingApi;</code>  

#### 03. Developer Guide
<hr/>
Following calls are mostly expected an associative array as parameter which needs to construct according<br/>
 specific eBay API calls. Refer eBay Trading API [**Documentation**](https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/index.html) while using each specific function. <b>No need to worry about 
 XML root</b> just construct <b>inner key, values</b> correctly
<ol>
<li>
 <h5>Instantiate the object</h5><hr/> 

 ```php
try{
    $ebayTrading = new EBayTradingApi($token,$devId,$appId,$certName,$url,$siteId);
}catch(Exception $e){
    print 'Error ' . $e->getMessage();
}
 ```
Respectively token , devId, appId , certId, url, siteId are required for the constructer method. Above credentials are more important to make each http hits.
</li>
<li>
 <h5>getTokenStatus() method.</h5><hr/>
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
 <h5>getItem($postBody) method.</h5><hr/>
The GetItem call returns listing data such as title, description, price information, user information, and so on, for the specified ItemID.<br/>

Function requires a parameter. which may be<br/>
**(int/string) itemId** or **an associative array** as postBody according eBay API [**Documentation**](https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/GetItem.html#input). <br/>
**Eg :-**
```php
try{
    $ebayTrading = new EBayTradingApi($token,$devId,$appId,$certName,$url,$siteId);
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
<h5>getStore($postBody) method.</h5><hr/>
Use this call to retrieve configuration information for the eBay store owned by the user specified with UserID. If you do not specify a UserID, the store configuration information is returned for the authenticated caller.<br/>

**empty parameter** or **an associative array** as postBody according eBay API [**Documentation**](https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/GetStore.html#Input). <br/>
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
    ------------ More --------------
   ];

    $response = $ebayTrading->getItem($postBody);

    print_r($response);
}catch(Exception $e){
    print 'Error ' . $e->getMessage();
}
```
Sample Output :-

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
------------ More -----------------
```
</li>
<li>
  <h5>getOrders($postBody) method.</h5><hr/>
  
GetOrders is the recommended call to use for order (sales) management. Use this call to retrieve all orders in which the authenticated caller is either the buyer or seller. The order types that can be retrieved
with this call are discussed see eBay [**Documentation**](https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/GetOrders.html)  

Expected [**an associative array**](https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/GetOrders.html#Input)
**Eg:**
```php
try{
    $ebayTrading = new EBayTradingApi($token,$devId,$appId,$certName,$url,$siteId);
    $postBody = [
        'CreateTimeFrom' => 
        'CreateTimeTo' => 
        'OrderRole' => 
        ------------ More --------------
       ];

    $response = $ebayTrading->getOrders($postBody);   
    print_r($response);
}catch(Exception $e){
    print 'Error ' . $e->getMessage();
}
```
Sample Output :-
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
    
    ------------ More ---------------
];
``` 
</li>
<li>
 <h5>addFixedPriceItem($postBody)  method.</h5><hr/>
Use this call to define and list a new fixed-price item. This call returns the item ID for the new listing,<br/>
plus an estimation of the fees the seller will incur for posting the listing (not including the Final Value Fee,<br/>
which cannot be calculated until the listing has ended).<br/>

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
<li>
    <h5>reviseFixedPriceItem($postBody) method</h5><hr/>
    Use this call to change the properties of a currently active fixed-price listing (including multi-variation listings). 
    
   [**Documentation**](https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/ReviseFixedPriceItem.html) <br/>
   
   Please [**refer the documentation**](https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/ReviseFixedPriceItem.html#Input) before construct the associative array
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
        ------------More Variation-------------
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
    <h5>relistFixedPriceItem($postBody) method</h5><hr/>
    Use this call to relist a single fixed-price item or a single multi-item listing that has ended. The item may be relisted as it was originally defined, or the seller may change
       

   [**.....**](https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/RelistFixedPriceItem.html) <br/>
   
   **Function Requires an array by setting post data**
   Please [**refer the documentation**](https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/RelistFixedPriceItem.html#Input) before construct the associative array
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
        ------------More Variation-------------
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
	---- More --- 
];
```    
</li>
<li>
    <h5>reviseInventoryStatus() method</h5><hr/>
    his call enables a seller to change the price and/or quantity of up to four active, fixed-price listings. The fixed-price listing(s) to modify are   

   [**.....**](https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/ReviseInventoryStatus) <br/>
   
   **Function Requires an array by setting post data**
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
        ------------More Variation-------------
        		            ] //variations end
        ];
    
            $response = $ebayTrading->relistFixedPriceItem($post_data);
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
            [#comment] => Array
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

                    [4] => Array
                        (
                        )

                )

            [Fees] => Array
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
    <h5>completeSale() method</h5><hr/>
    This <a href="https://developer.ebay.com/Devzone/XML/docs/Reference/eBay/CompleteSale.html">API call</a> Use to do various tasks after the creation of a single line item or multiple line item order.
    <br/>
   
   **Function Requires an array by setting post data**
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

                            [4] => Array
                                (
                                )

                            [5] => Array
                                (
                                )

                            [6] => Array
                                (
                                )

                            [7] => Array
                                (
                                )

                        )

                    [ErrorClassification] =>  ErrorClassificationCodeType
                    [ErrorCode] =>  token
                    [ErrorParameters] => Array
                        (
                            [@attributes] => Array
                                (
                                    [ParamID] => string
                                )

                            [#text] => Array
                                (
                                    [0] => Array
                                        (
                                        )

                                    [1] => Array
                                        (
                                        )

                                )

                            [Value] =>  string
                        )

                    [#comment] => Array
                        (
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
</ol>