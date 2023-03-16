<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['login'] = 'account/login';
$route['register'] = 'account/register';
$route['forgotpassword'] = 'account/passsendmail';
$route['alertpage'] = 'account/uyarısayfası';
$route['logincode'] = 'account/logincode';
$route['password'] = 'account/password';
$route['exchange/(:any)-(:any)'] = 'exchange';
$route['session'] = 'account/session';
$route['api/public/currencies'] = 'api/currencies';
$route['api/public/tickers'] = 'api/tickers';
$route['api/public/tickersxyzabc'] = 'api/tickersxyzabc';
$route['api/public/deneme222'] = 'api/deneme222';
$route['api/public/recentTrades'] = 'api/recentTrades';
$route['api/public/orderBook'] = 'api/orderBook';
$route['api/public/walletdetail'] = 'api/walletDetail';
$route['api/auth-request'] = 'api/authRequest';
$route['api/auth-signature'] = 'api/authSignature';
$route['api/account-monitor'] = 'api/accountmonitor';
$route['fees'] = 'home/status';
$route['privacy'] = 'home/privacy';
$route['terms'] = 'home/terms';
$route['news'] = 'home/news';
$route['faucet'] = 'home/faucet';
$route['listing'] = 'home/listing';
$route['team-about-us'] = 'home/teamAboutus';
$route['newsdetail/(:any)'] = 'home/newsdetail/$1';
$route['translate_uri_dashes'] = FALSE;
// $route['trade'] = "home/trade";
$route['trade/(:any)-(:any)'] = 'home/trade';