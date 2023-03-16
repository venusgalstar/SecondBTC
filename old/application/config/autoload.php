<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$autoload['packages'] = array();

$autoload['libraries'] = array('session','mongo_db','form_validation','email','GoogleAuthenticator','Logger','upload','Mylibraries');

$autoload['drivers'] = array();

$autoload['helper'] = array('url','my','language','cookie','text','form');

$autoload['config'] = array();

$autoload['language'] = array();

$autoload['model'] = array('account_model','email_model','wallet_model','exchange_model','market_model','index_model','api_model','carts_model','bot_model');
