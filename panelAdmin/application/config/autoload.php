<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$autoload['packages'] = array();

$autoload['libraries'] = array('session','mongo_db','form_validation','email','GoogleAuthenticator','Logger','upload','Mylibraries');

$autoload['drivers'] = array();

$autoload['helper'] = array('url','adminmy','language','cookie','text','form');

$autoload['config'] = array();

$autoload['language'] = array();

$autoload['model'] = array('admin_wallet_model','admin_router_model','admin_user_model','admin_home_model','admin_admin_model','admin_fiat_model','email_model',"admin_invoice_model","Admin_bot_model");
