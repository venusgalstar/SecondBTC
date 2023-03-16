<?php include "include/header.php"; ?>
<link href="<?php echo base_url();?>assets/home/css/prism.css" rel="stylesheet" />

<style>
.min-vh-30{
    min-height: 0 !important;
}
.codediv{
    min-height: 600px;
}
</style>
    <div class="container-fluid">
      <div class="row">
        <nav class="col-2 bg-info sidebar">
          <div class="sidebar-sticky mt-5">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active font-size-15 text-light" id="v-pills-market-tab" data-toggle="pill" href="#v-pills-market" role="tab" aria-controls="v-pills-market" aria-selected="true">Market Data</a>
                <a class="nav-link font-size-15 text-light" id="v-pills-account-tab" data-toggle="pill" href="#v-pills-account" role="tab" aria-controls="v-pills-account" aria-selected="false">Account(Soon)</a>
              </li>
            </ul>
          </div>
        </nav>
        <div class="col-10">
            <div class="tab-content border-0" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-market" role="tabpanel" aria-labelledby="v-pills-market-tab">
                    <div class="row">
                        <div class="col-6 bg-light">
                            <h2 class="mt-3">Market data</h2>
                            <!-- Currencies -->
                            <h3 class="font-weight-bold mt-4 font-size-17">Currencies</h3>
                            <code>GET <?php echo base_url();?>api/public/currencies</code>
                            <div class="mt-3">Returns the list of available currencies (including coins, tokens, etc.) with detailed information.</div>
                            <div class="font-weight-bold mt-4">Parameters</div>
                            <div class="mt-2">The parameters should be passed in the query component of the URL of GET request.</div>
                            <table class="table table-striped table-sm mt-3">
                                <thead>
                                    <tr>
                                    <th scope="col">Field</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>symbol</td><td>string</td><td>Unique identifier of the currency, e.g. "BTC"</td></tr>
                                    <tr><td>name</td><td>string</td><td>Currency name, e.g. "Bitcoin"</td></tr>
                                    <tr><td>isFiat</td><td>boolean</td><td>Reports whether the currency is fiat</td></tr>
                                    <tr><td>canDeposit</td><td>boolean</td><td>Contains the value false if deposits for the currency are not accepted at the moment</td></tr>
                                    <tr><td>depositConfirmationCount</td><td>int</td><td>The number of blockchain confirmations the deposit is required to receive before the funds are credited to the account (for cryptocurrencies only; in case of fiat currency, the field contains the value null)</td></tr>
                                    <tr><td>minDeposit</td><td>decimal</td><td>Minimum deposit threshold (for cryptocurrencies only; in case of fiat currency, the field contains the value null)</td></tr>
                                    <tr><td>canWithdraw</td><td>boolean</td><td>Contains the value false if withdrawals are not currently available for the currency</td></tr>
                                    <tr><td>minWithdrawal</td><td>decimal</td><td>Minimum withdrawal amount (for cryptocurrencies only; in case of fiat currency, the field contains the value null)</td></tr>
                                    <tr><td>maxWithdrawal</td><td>decimal</td><td>Maximum withdrawal amount (for cryptocurrencies only; in case of fiat currency, the field contains the value null). If a currency doesn’t have an upper withdrawal limit, the field contains the value null</td></tr>
                                    <tr><td>lastUpdateTimestamp</td><td>datetime</td><td>The currency was last updated.</td></tr>
                                </tbody>
                            </table>
                            <div class="mt-2 border-bottom">The data returned is in JSON format.</div>
                            <div style="margin-bottom:110px"></div>
                            <!-- Tickers -->
                            <h3 class="font-weight-bold mt-4 font-size-17">Tickers</h3>
                            <code>GET <?php echo base_url();?>api/public/tickers</code>
                            <div class="mt-3">Returns the list of tickers with detailed information.</div>
                            <div class="font-weight-bold mt-4">Parameters</div>
                            <div class="mt-2">The parameters should be passed in the query component of the URL of GET request.</div>
                            <table class="table table-striped table-sm mt-3">
                                <thead>
                                    <tr>
                                    <th scope="col">Field</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>tradingPairs</td><td>string</td><td>Unique ticker identifier, e.g. "LTC_BTC"</td></tr>
                                    <tr><td>LastPrice</td><td>decimal</td><td>Last price. If this information is not available, the field contains the value null</td></tr>
                                    <tr><td>percentChange</td><td>decimal</td><td>Percentage change of the price over the last 24 hours. If this information is not available, the field contains the value null</td></tr>
                                    <tr><td>low24h</td><td>decimal</td><td>Lowest price over the last 24 hours. If this information is not available, the field contains the value null</td></tr>
                                    <tr><td>high24h</td><td>decimal</td><td>Highest price over the last 24 hours. If this information is not available, the field contains the value null</td></tr>
                                    <tr><td>baseVolume24h</td><td>decimal</td><td>Total trading volume of the instrument over the last 24 hours, expressed in base currency</td></tr>
                                    <tr><td>quoteVolume24h</td><td>decimal</td><td>Total trading volume of the instrument over the last 24 hours, expressed in quote currency</td></tr>
                                    <tr><td>lowestAsk</td><td>decimal</td><td>Best ask price. If there are no active selling orders, the field contains the value null</td></tr>
                                    <tr><td>highestBid</td><td>decimal</td><td>Best bid price. If there are no active buying orders at the moment, the field contains the value null</td></tr>
                                    <tr><td>lastUpdateTimestamp</td><td>datetime</td><td>Date and time when the ticker was updated</td></tr>
                                    <tr><td>tradesEnabled</td><td>boolean</td><td>Indicates whether the status is active or passive.  true - working in a normal mode; false - trading is passive;</td></tr>
                                </tbody>
                            </table>
                            <div class="mt-2 border-bottom">The data returned is in JSON format.</div>
                            <div style="margin-bottom:80px"></div>
                            <!-- Recent Trades -->
                            <h3 class="font-weight-bold mt-4 font-size-17">Recent Trades</h3>
                            <code>GET <?php echo base_url();?>api/public/recentTrades</code>
                            <div class="mt-3">Returns the list of recent trades made with the specified instrument, sorted from newest to oldest.</div>
                            <div class="mt-3">Default limit is 5. Max limit is 50.</div>
                            <div class="font-weight-bold mt-4">Parameters</div>
                            <div class="mt-2">The parameters should be passed in the query component of the URL of GET request.</div>
                            <table class="table table-striped table-sm mt-3">
                                <thead>
                                    <tr>
                                    <th scope="col">Field</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>tradeID </td><td>int</td><td>The ID unique only to this currency pair associated with this trade.</td></tr>
                                    <tr><td>price</td><td>decimal</td><td>Price for which the base currency was bought or sold</td></tr>
                                    <tr><td>baseVolume</td><td>decimal</td><td>Total trading volume of the instrument over the expressed in base currency</td></tr>
                                    <tr><td>quoteVolume </td><td>decimal</td><td>Total trading volume of the instrument over the expressed in quote currency</td></tr>
                                    <tr><td>type</td><td>string</td><td>Trade direction, can have either of the two values: "buy" or "sell"</td></tr>
                                    <tr><td>time</td><td>datetime</td><td>Date and time when the trade took place</td></tr>
                                    <tr><td>isBuyerMaker</td><td>boolean</td><td>If isBuyerMaker is true then that means a seller fulfilled a buy order. </td></tr>
                                </tbody>
                            </table>
                            <div class="mt-2">The data returned is in JSON format.</div>
                            <div class="border-bottom" style="margin-top:220px; margin-bottom:100px;"></div>
                             <!-- Order Book -->
                             <h3 class="font-weight-bold mt-4 font-size-17">Order Book</h3>
                            <code>GET <?php echo base_url();?>api/public/orderBook</code>
                            <div class="mt-3">Returns information about bids and asks for the specified instrument, organized by price level.</div>
                            <div class="mt-3">Default limit is 5. Max limit is 50.</div>
                            <div class="font-weight-bold mt-4">Parameters</div>
                            <div class="mt-2">The parameters should be passed in the query component of the URL of GET request.</div>
                            <div class="mt-3">Returns an object with the following structure:</div>
                            <table class="table table-striped table-sm mt-3">
                                <thead>
                                    <tr>
                                    <th scope="col">Field</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>bids</td><td colspan="2">An array of price levels for buying orders, sorted by price from highest to lowest</td></tr>
                                    <tr><td>asks</td><td colspan="2">An array of price levels for selling orders, sorted by price from lowest to highest</td></tr>
                                    <tr><td>LastUpdateTimestamp</td><td>datetime</td><td>The UTC date and time of the trade execution.</td></tr>
                                </tbody>
                            </table>
                            <div class="mt-2">The data returned is in JSON format.</div>
                            <div class="border-bottom" style="margin-top:340px;"></div>
                        </div>
<div class="col-6 bg-dark codediv">
<!-- currencies -->
<pre>
    <code class="language-json">




GET <?php echo base_url();?>api/public/currencies
The above request returns JSON structured like

[
{
    "symbol": "$PAC",
    "name": "PACCoin",
    "isFiat": false,
    "canDeposit": true,
    "depositConfirmationCount": 8,
    "minDeposit": 0.0,
    "canWithdraw": true,
    "minWithdrawal": 4.0,
    "maxWithdrawal": null,
    "lastUpdateTimestamp": 2018-06-01T14:01:52Z
},
...
]

GET <?php echo base_url();?>api/public/currencies?filter=ETH
The above request returns JSON structured like

[
{
    "symbol": "ETH",
    "name": "Ethereum",
    "isFiat": false,
    "canDeposit": true,
    "depositConfirmationCount": 12,
    "minDeposit": 0.01,
    "canWithdraw": true,
    "minWithdrawal": 0.01,
    "maxWithdrawal": 5000.0,
    "lastUpdateTimestamp": 2018-06-01T14:01:52Z
}
]
    </code>
</pre>
<!-- tickers -->
<pre>
    <code class="language-json">
GET <?php echo base_url();?>api/public/tickers
The above request returns JSON structured like this:

[
{
    "tradingPairs": "$PAC_BTC",
    "LastPrice": 0.0000005,
    "percentChange": 8.6957,
    "low24h": 0.00000046,
    "high24h": 0.0000005,
    "baseVolume24h": 144.855144855145,
    "quoteVolume24h": 0.0000724275724275725,
    "lowestAsk": 0.0000005,
    "highestBid": 0.00000046,
    "lastUpdateTimestamp": "2018-05-31T12:48:56Z"
    "tradesEnabled": true
},
...
]

GET <?php echo base_url();?>api/public/tickers?filter=ETH_BTC
The above request returns JSON structured like this:

[
{
    "tradingPairs": "ETH_BTC",
    "LastPrice": 0.07699474,
    "percentChange": 8.4433,
    "lowh": 0.07099998,
    "highh": 0.07787616,
    "baseVolume24h": 34.0474,
    "quoteVolume24h": 2.5673,
    "lowestAsk": 0.0771,
    "highestBid": 0.07699474,
    "lastUpdateTimestamp": "2018-06-01T14:01:52Z",
    "tradesEnabled": true
}
]




    </code>
</pre>
<!-- recentTrades -->
<pre>
    <code class="language-json">
GET <?php echo base_url();?>api/public/recentTrades?filter=LTC_BTC
The above request returns JSON structured like this:

[
{
    "tradeID ": 58144,
    "price": 0.0159019,
    "baseVolume": 0.043717,
    "quoteVolume ": 2.043717,
    "type": "buy",
    "time": "2018-05-31T10:08:53Z"
    "isBuyerMaker": true
},
{
    "tradeID ": 58145,
    "price": 0.0159019,
    "baseVolume": 0.043717,
    "quoteVolume ": 2.043717,
    "type": "buy",
    "time": "2018-05-31T10:08:53Z"
    "isBuyerMaker": true
},
...
]

GET <?php echo base_url();?>api/public/recentTrades?filter=LTC_BTC&limit=1
The above request returns JSON structured like this:

[
    {
    "tradeID ": 58146,
    "price": 0.0159019,
    "baseVolume": 0.043717,
    "quoteVolume ": 2.043717,
    "type": "buy",
    "time": "2018-05-31T10:08:53Z"
    "isBuyerMaker": true
},
]
    </code>
</pre>
<!-- orderBook -->
<pre>
    <code class="language-json">
GET <?php echo base_url();?>api/public/orderBook?filter=LTC_BTC
The above request returns JSON structured like this:

{
  "LastUpdateTimestamp": 1568085495
  "bids": [
    [
      "0.01573481",
      0.032,
    ]
  ],
  "asks": [
    [
      "0.01593",
      0.059355644356,
    ]
  ]
}

GET <?php echo base_url();?>api/public/orderBook?filter=LTC_BTC&limit=2
The above request returns JSON structured like this:

{
  "LastUpdateTimestamp": 1568085495
  "bids": [
    [
      "0.01573481",
      0.032,
    ],
    [
      "0.01500001",
      0.75,
    ]
  ],
  "asks": [
    [
      "0.01593000",
      0.059355644356,
    ],
    [
      "0.01594994",
      0.3,
    ]
  ]
}

    </code>
</pre>
</div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-account" role="tabpanel" aria-labelledby="v-pills-account-tab">
                    <div class="row">
                        <div class="col-6 bg-light">
                        ...
                        </div>
                        <div class="col-6 bg-dark codediv">
                        <pre>
                            <code class="language-js">
{
    [
    ]
}
                            </code>
                        </pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>








<?php include "include/footer.php"; ?>
<script src="<?php echo base_url();?>assets/home/js/prism.js"></script>


