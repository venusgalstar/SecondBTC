<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['mongo_db']['active'] = 'default';

$config['mongo_db']['default']['no_auth'] = false;
$config['mongo_db']['default']['hostname'] = '127.0.0.1';
$config['mongo_db']['default']['port'] = '27017';
$config['mongo_db']['default']['username'] = 'new_secondbtc_user';
$config['mongo_db']['default']['password'] = '9874aa8795tWmsadcsdfQz852XZaweBHTDExcaqxzQ';
$config['mongo_db']['default']['database'] = 'secondbtc_mongo_database';
$config['mongo_db']['default']['db_debug'] = TRUE;
$config['mongo_db']['default']['return_as'] = 'array';
$config['mongo_db']['default']['write_concerns'] = (int)1;
$config['mongo_db']['default']['journal'] = TRUE;
$config['mongo_db']['default']['read_preference'] = 'primary';
$config['mongo_db']['default']['read_concern'] = 'local'; //'local', 'majority' or 'linearizable'
$config['mongo_db']['default']['legacy_support'] = TRUE;
$config['mongo_db']['default']['atlas'] = FALSE;