<?php


function dil($dil) {
    $ci=&get_instance();
    $sor = $ci->lang->line($dil);
    if($sor){
        return $sor;
    }else{
        return "undefined";
    }				
}

function dilBul($gelen="") {
    $ci=&get_instance();
    if($gelen==""){
        if($ci->input->cookie("dil")==""){
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
            if(sup_lang($lang)==1){
                $ci->lang->load('lang', $lang);
            }else{
                $ci->lang->load('lang', siteSetting()["site_default_lang"]);
            }
        }else{
            $ci->lang->load('lang', $ci->input->cookie("dil"));
        }
    }else{
        $ci->lang->load('lang', $gelen);
        $ci->input->set_cookie('dil',$gelen,time()+(60*60*24));
    }			
}

function sup_lang($dil)
{
    $dil = strtolower($dil);
    if($dil=='tr' || $dil=='en'){return 1;}else{ return 0;}
}

function usdPrice($toShort,$fromShort,$excgange)
{   
    if($excgange=="binance"){
        $veri = vericek("https://api.binance.com/api/v3/ticker/price?symbol=".$toShort.$fromShort);
        $data = json_decode($veri,true);
        return $data["price"];
    }elseif($excgange=="bitforex"){
        $veri = vericek("https://api.bitforex.com/api/v1/market/ticker?symbol=coin-".mb_strtolower($fromShort)."-".mb_strtolower($toShort));
        $data = json_decode($veri,true);
        return $data["data"]["last"];
    } 
}

function uretken($len) {
    $karaktersizler = "abcdefghijklmnopqrstuvwxyz0123456789";
    $xx= "";
    $max = strlen($karaktersizler)-1;
    for ($i = 0; $i < $len; $i++) {
        $xx.= $karaktersizler[rand(0,$max)];
    }
    return $xx;
}

function uretkenApi($len) {
    $karaktersizler = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $xx= "";
    $max = strlen($karaktersizler)-1;
    for ($i = 0; $i < $len; $i++) {
        $xx.= $karaktersizler[rand(0,$max)];
    }
    return $xx;
}

function eskiSifrele($len) {
    $output = false;
    $key    = hash("sha256", "3&zJ-Yzm");
    $iv     = substr(hash("sha256", "bitex"), 0, 16);
    $output = openssl_encrypt($len, "AES-256-CBC", $key, 0, $iv);
    return $output = base64_encode($output);
}

function eskiSifreCoz($len) {
    $key    = hash("sha256", "3&zJ-Yzm");
    $iv     = substr(hash("sha256", "bitex"), 0, 16);
    $output = base64_decode($len);
    return $output = openssl_decrypt($output, "AES-256-CBC", $key, 0, $iv);
}

function yeniSifrele($len) {
    $cipher ="AES-256-ECB";
    $key = 'a41d8cd98f00b204e9800998fcf8427e';
    $chiperRaw = openssl_encrypt($len, $cipher, $key, OPENSSL_RAW_DATA);
    return $ciphertext = trim(base64_encode($chiperRaw));
}

function yeniSifreCoz($len) {
    $cipher ="AES-256-ECB";
    $key = 'a41d8cd98f00b204e9800998fcf8427e';
    $chiperRaw = base64_decode($len);
    return $originalPlaintext = openssl_decrypt($chiperRaw, $cipher, $key, OPENSSL_RAW_DATA);
}

function parolaSifrele($len) {
    return $sifre = sha1(md5($len));
}

function emailCode() {
    return $code = sprintf("%06d",mt_rand(1,999999));
}

function kisalt($kelime, $start = 10, $end = 0)
{
  
    if (function_exists("mb_substr")){
        $after = mb_substr($kelime, 0, $start, 'utf8');
        $repeat = str_repeat('*', $end);
        $before = mb_substr($kelime, ($start + $end), strlen($kelime), 'utf8');
        return $after.$repeat.$before;
    }else{
        $after = mb_substr($kelime, 0, $start, 'utf8');
        $repeat = str_repeat('*', $end);
        $before = substr($kelime, ($start + $end), strlen($kelime));
        return $after.$repeat.$before;
    }
}

function kisaltKelime($kelime, $str = 10)
{
	if (strlen($kelime) > $str)
	{
		if (function_exists("mb_substr")) $kelime = mb_substr($kelime, 0, $str, "UTF-8").'..';
		else $kelime = substr($kelime, 0, $str).'..';
	}
	return $kelime;
}

function browser_kisalt($u_agent){
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'Linux';
    }elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'Mac';
    }elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'Windows';
    }
    
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    {  $bname = 'Internet Explorer'; $ub = "MSIE"; 
    } elseif(preg_match('/Firefox/i',$u_agent)) 
    { $bname = 'Mozilla Firefox'; $ub = "Firefox"; 
    }elseif(preg_match('/Chrome/i',$u_agent)) 
    { $bname = 'Google Chrome'; $ub = "Chrome"; 
    }elseif(preg_match('/Safari/i',$u_agent)) 
    { $bname = 'Apple Safari';  $ub = "Safari"; 
    } elseif(preg_match('/Opera/i',$u_agent)) 
    { $bname = 'Opera'; $ub = "Opera"; 
    }elseif(preg_match('/Netscape/i',$u_agent)) 
    { $bname = 'Netscape'; $ub = "Netscape"; 
    }
    return "$platform $bname";
}
function userWalletBalance($walletID,$userID,$email) {
    $ci=&get_instance();
    $array = array(
        'wallet_id' => (int)$walletID,
        'wallet_user_email' => $email,
        'wallet_user_id' => $userID
    );
    $ci->mongo_db->where($array);
    $sor = $ci->mongo_db->get('user_wallet_datas');
    if(!empty($sor[0]["wallet_user_balance"])){
        return Number($sor[0]["wallet_user_balance"],8);
    }else{
        return Number(0,8);
    }
    
}

function userEtherSor($walletSystem,$userID,$email) {
    $ci=&get_instance();
    $array = array(
        'wallet_system' => $walletSystem,
        'wallet_user_email' => $email,
        'wallet_user_id' => $userID
    );
    $ci->mongo_db->where($array);
    $sor = $ci->mongo_db->get('user_wallet_datas');
    if(!empty($sor[0]["wallet_user_balance"])){
        return Number($sor[0]["wallet_user_balance"],8);
    }else{
        return Number(0,8);
    }
    
}

function userOpenOrdersTo($walletID,$userID,$email) {
    $ci=&get_instance();
    $array = array(
        'exchange_to_wallet_id' => (int)$walletID,
        'exchange_user_email' => $email,
        'exchange_user_id' => $userID,
        'exchange_status' => 1,
        'exchange_type' => "sell"
    );
    $ci->mongo_db->where($array);
    $sor = $ci->mongo_db->get('exchange_datas');
    if(!empty($sor)){
        $order = 0;
        foreach ($sor as $key) {
            $order = $order+$key["exchange_unit"];
        }
        return $order;
    }else{
        return Number(0,8);
    } 
}
function userOpenOrdersFrom($walletID,$userID,$email) {
    $ci=&get_instance();
    $array = array(
        'exchange_from_wallet_id' => (int)$walletID,
        'exchange_user_email' => $email,
        'exchange_user_id' => $userID,
        'exchange_status' => 1,
        'exchange_type' => "buy"
    );
    $ci->mongo_db->where($array);
    $sor = $ci->mongo_db->get('exchange_datas');
    if(!empty($sor)){
        $order = 0;
        foreach ($sor as $key) {
            $order = $order+$key["exchange_total"];
        }
        return $order;
    }else{
        return Number(0,8);
    } 
}

function Number($value,$dec){
    return number_format(($value), $dec, '.', '');
}

function UserStatus($userID,$email,$veri){
    $ci=&get_instance();
    $ci->mongo_db->where(array('user_id'=>$userID,'user_email' => $email ));
    $status = $ci->mongo_db->get('user_datas');
    return  $status[0][$veri];
}

function walletHelper($short){
    $ci=&get_instance();
    $ci->mongo_db->where(array('wallet_short'=>$short));
    $status = $ci->mongo_db->get('wallet_datas');
    return  $status[0];
}

function convert($data)
{
if(strpos($data,","))
{$chng = str_replace(",",".",$data); $data = $chng;}
return  $data;
}

function getUserMailCodeKontrol($email,$code)
{
    $ci=&get_instance();
	$email = htmlspecialchars($email);
	$md5Code = md5($code);
	$ci->mongo_db->where(array('user_email'=>$email,'user_mailcode'=>$md5Code));
    $sor = $ci->mongo_db->get('user_datas');
    if(!empty($sor)){
        return 'ok';
    }
}

function getUserGoogleCodeKontrol($key,$code)
{
    $ci=&get_instance();
	$sor = $ci->googleauthenticator->verifyCode($key, $code, 1);
	if(!empty($sor)){
        return 'ok';
    }
}

function getUserWalletKontrol($walletID,$userID,$email)
{   
    $ci=&get_instance();
    
    $ci->mongo_db->where(array('wallet_id' => (int)$walletID,'wallet_user_id' => $userID,'wallet_user_email' => $email));
    $sor = $ci->mongo_db->get('user_wallet_datas');
    if(!empty($sor)){
        return "ok";
    }else{
        $ci->mongo_db->where(array('wallet_id' => (int)$walletID));
        $sorWallet = $ci->mongo_db->get('wallet_datas');
        $veri = array(
            'wallet_id' => (int)$walletID,
            'wallet_short' => $sorWallet[0]['wallet_short'],
            'wallet_name' => $sorWallet[0]['wallet_name'],
            'wallet_user_balance'=> (double)0,
            'wallet_system' => $sorWallet[0]['wallet_system'],
            'wallet_user_id' => $userID,
            'wallet_date' => (int)time(),
            'wallet_user_email' => $email,
            'wallet_user_address' => "0",
            'wallet_user_tag' => "0",
            'wallet_withdraw_address' => "0",
            'wallet_withdraw_tag' => "0"
        );
        $insert = $ci->mongo_db->insert('user_wallet_datas',$veri);
        if(count($insert)){
            return "ok";
        }
    }
}

function curl($url,$data=array()){
    $ch  = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate, br");
    curl_setopt($ch, CURLOPT_TIMEOUT,60);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    return$kaynak = curl_exec($ch);
}

function vericek($url){
    $ch  = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip, deflate, br");
    curl_setopt($ch, CURLOPT_TIMEOUT,20);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ch, CURLOPT_URL, $url);
    return$kaynak = curl_exec($ch);
}

function serverUrl($system){
    $ci=&get_instance();
    $server = $ci->mongo_db->get('server_datas');
    return siteSetting()["site_wallet_server"].$system."/main.php";
}

function resimUpload($data){
    $ci=&get_instance();
    $filename = date("dmY_His")."_".$data;
    $config['file_name']            =  $filename;
    $config['upload_path']          = './assets/home/images/'.$data.'/';
    $config['allowed_types']        = 'gif|jpg|png';
    $config['max_size']             = 3100;
    $config['max_width']            = 2920;
    $config['max_height']           = 2080;
    $config['file_ext_tolower'] = TRUE;

    $ci->load->library('upload', $config);
    $ci->upload->initialize($config);

    if ( ! $ci->upload->do_upload('filename'))
    {
            return $error = array('error' => $ci->upload->display_errors()."Max : 3 Mb.","durum" => "hata");
    }
    else
    {
            return $data = array('data' => $ci->upload->data(),"durum" => "ok");
    } 
}

function adminMarketSetting($fromShort,$toShort) {
    $ci=&get_instance();
    $ci->mongo_db->where(array('from_wallet_short' => $fromShort,'to_wallet_short' => $toShort));
    $sor = $ci->mongo_db->get('market_datas');
    if(!empty($sor)){
        return $sor[0]["market_status"];
    }else{
        return 0;
    }
}

function siteSetting() {
    $ci=&get_instance();
    $sor = $ci->mongo_db->get('site_setting_datas');
    if(!empty($sor)){
        return $sor[0];
    }else{
        return 0;
    }
}

function createGoogleKey() {
    $ci=&get_instance();
    return $ci->googleauthenticator->createSecret();
}

function recaptcha($key) {
    $secretKey = siteSetting()["google_recaptcha_secret"];
    $ip = GetIP();
    $captcha = $key;
    $response=vericek("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
    $responseKeys = json_decode($response,true);
    return intval($responseKeys["success"]);
}

function GetIP(){
    if(getenv("HTTP_CLIENT_IP")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } elseif(getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
        if (strstr($ip, ',')) {
            $tmp = explode (',', $ip);
            $ip = trim($tmp[0]);
        }
    } else {
    $ip = getenv("REMOTE_ADDR");
    }
    return $ip;
}
function getUserFaucet($short,$period){
    $ci=&get_instance();	
    $ci->mongo_db->limit(1);
    $ci->mongo_db->where('faucet_user_email',(string)$_SESSION['user_data'][0]['user_email']);        
    $ci->mongo_db->where('faucet_user_id',(string)$_SESSION['user_data'][0]['user_id']);        
    $ci->mongo_db->where('wallet_short',(string)$short);        
    $ci->mongo_db->where_gt('faucet_time',(int)time()-$period);        
    $sor = $ci->mongo_db->get('user_faucet_datas');	
    if(!empty($sor)){
        return $sor;
    }else{
        return 1;
    }
}

function get_time($time){
    $duration = $time;
    $day = floor($duration / 86400);
    $hours = floor($duration / 3600);
    $minutes = floor(($duration / 60) % 60);
    $seconds = $duration % 60;
    if ($hours != 0)
        echo $hours ." ".lang('hour');
    else
        echo $minutes ." ".lang('minute');
}

function TCcheck($tc,$isim,$ikinciIsim,$soyisim,$dogum)
{
    $find = array('i', 'ı','ç','ş','ü','ö','ğ'); //any turkish chars
    $replace = array('İ','I','Ç','Ş','Ü','Ö','Ğ');

    $isim = strtoupper(str_replace($find,$replace, htmlspecialchars($isim)));
    $soyisim = strtoupper(str_replace($find,$replace, htmlspecialchars($soyisim)));
    if($ikinciIsim!=''){
        $ikinciIsim = strtoupper(str_replace($find,$replace, htmlspecialchars($ikinciIsim)));
        $isim = $isim." ".$ikinciIsim;
    }else{
        $isim = $isim;
    }

    $post_data = '<?xml version="1.0" encoding="utf-8"?>
    <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
            <TCKimlikNoDogrula xmlns="http://tckimlik.nvi.gov.tr/WS">
                <TCKimlikNo>'.$tc.'</TCKimlikNo>
                <Ad>'.$isim.'</Ad>
                <Soyad>'.$soyisim.'</Soyad>
                <DogumYili>'.$dogum.'</DogumYili>
            </TCKimlikNoDogrula>
        </soap:Body>
    </soap:Envelope>';
    $ch = curl_init();
    // CURL options
    $options = array(
        CURLOPT_URL             => 'https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx',
        CURLOPT_POST            => true,
        CURLOPT_POSTFIELDS      => $post_data,
        CURLOPT_RETURNTRANSFER  => true,
        CURLOPT_SSL_VERIFYPEER  => false,
        CURLOPT_HEADER          => false,
        CURLOPT_HTTPHEADER      => array(
                'POST /Service/KPSPublic.asmx HTTP/1.1',
                'Host: tckimlik.nvi.gov.tr',
                'Content-Type: text/xml; charset=utf-8',
                'SOAPAction: "http://tckimlik.nvi.gov.tr/WS/TCKimlikNoDogrula"',
                'Content-Length: '.strlen($post_data)
        ),
    );
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
    curl_close($ch);
    return (strip_tags($response) === 'true') ? true : false;
    print_r($ch);
}

function validatePass($password)
{
    if (preg_match('#[0-9]#', $password) && preg_match('#[a-zA-Z]#', $password)) {
        return "ok";
    }else{
        return "yetersiz";
    }
}

function tr_strtoupper($text)
{
    $search=array("ç","i","ı","ğ","ö","ş","ü");
    $replace=array("Ç","İ","I","Ğ","Ö","Ş","Ü");
    $text=str_replace($search,$replace,$text);
    $text=strtoupper($text);
    return $text;
}

function statusDeposit($short,$durum)
{
    $ci=&get_instance();
    $ci->mongo_db->order_by(array('dep_history_time'=>'desc'));
    $ci->mongo_db->where(array('dep_history_wallet_short' => (string)$short,'dep_history_status' => (int)$durum));
    $sor = $ci->mongo_db->get('deposit_history_datas');
    if(!empty($sor)){
        return $sor;
    }else{
        return $sor;
    }
}

function statusWithdraw($short,$durum)
{
    $ci=&get_instance();
    $ci->mongo_db->order_by(array('withdraw_time'=>'desc'));
    $ci->mongo_db->where(array('withdraw_wallet_short' => (string)$short,'withdraw_status' => (int)$durum));
    $sor = $ci->mongo_db->get('withdraw_history_datas');
    if(!empty($sor)){
        return $sor;
    }else{
        return $sor;
    }
}

function limit($lim = 1)
{
  if (isset($_SESSION['LAST_CALL'])) {
    $last = $_SESSION['LAST_CALL'];
    $curr = (double)microtime(true);
    $sec =  abs($last - $curr);
    if ($sec <= (double)$lim) {
      return $data = "Rate Limit Exceeded (Wait ".$lim." seconds)";      
    }
  }
  $_SESSION['LAST_CALL'] = (double)microtime(true);
  return "ok";
}

function exchangeLimit()
{
if (isset($_SESSION['exchange_wait'])) {
	$last = $_SESSION['exchange_wait'];
	$curr = (double)microtime(true);
	$sec =  abs($last - $curr);
	if ($sec <= (double)1) {
	return "bekle";       
	}
}
$_SESSION['exchange_wait'] = (double)microtime(true);

// normal usage
return "ok";
}



function countries()
{
	$countries = Array(
	'AF' => 'Afghanistan','AL' => 'Albania','DZ' => 'Algeria','AS' => 'American Samoa','AD' => 'Andorra','AO' => 'Angola',
    'AI' => 'Anguilla','AG' => 'Antigua And Barbuda','AR' => 'Argentina','AM' => 'Armenia','AW' => 'Aruba','AU' => 'Australia','AT' => 'Austria',
    'AZ' => 'Azerbaijan','BS' => 'Bahamas','BH' => 'Bahrain','BD' => 'Bangladesh','BB' => 'Barbados','BY' => 'Belarus','BE' => 'Belgium',
    'BZ' => 'Belize','BJ' => 'Benin','BM' => 'Bermuda','BT' => 'Bhutan','BO' => 'Bolivia','BA' => 'Bosnia And Herzegovina','BW' => 'Botswana',
    'BR' => 'Brazil','IO' => 'British Indian Ocean Territory','BN' => 'Brunei','BG' => 'Bulgaria','BF' => 'Burkina Faso','BI' => 'Burundi',
    'KH' => 'Cambodia','CM' => 'Cameroon','CA' => 'Canada','CV' => 'Cape Verde','KY' => 'Cayman Islands','CF' => 'Central African Republic',
    'TD' => 'Chad','CL' => 'Chile','CN' => 'China','CO' => 'Colombia','CG' => 'Congo','CK' => 'Cook Islands','CR' => 'Costa Rica',
    'CI' => 'Cote D\'ivoire','HR' => 'Croatia','CU' => 'Cuba','CY' => 'Cyprus','CZ' => 'Czech Republic','CD' => 'Democratic Republic of the Congo',
    'DK' => 'Denmark','DJ' => 'Djibouti','DM' => 'Dominica','DO' => 'Dominican Republic','EC' => 'Ecuador','EG' => 'Egypt','SV' => 'El Salvador',
    'GQ' => 'Equatorial Guinea','ER' => 'Eritrea','EE' => 'Estonia','ET' => 'Ethiopia','FO' => 'Faroe Islands','FM' => 'Federated States Of Micronesia',
    'FJ' => 'Fiji','FI' => 'Finland','FR' => 'France','GF' => 'French Guiana','PF' => 'French Polynesia','GA' => 'Gabon','GM' => 'Gambia','GE' => 'Georgia',
    'DE' => 'Germany','GH' => 'Ghana','GI' => 'Gibraltar','GR' => 'Greece','GL' => 'Greenland','GD' => 'Grenada','GP' => 'Guadeloupe','GU' => 'Guam',
    'GT' => 'Guatemala','GN' => 'Guinea','GW' => 'Guinea Bissau','GY' => 'Guyana','HT' => 'Haiti','HN' => 'Honduras','HK' => 'Hong Kong','HU' => 'Hungary',
    'IS' => 'Iceland','IN' => 'India','ID' => 'Indonesia','IR' => 'Iran','IE' => 'Ireland','IL' => 'Israel','IT' => 'Italy','JM' => 'Jamaica','JP' => 'Japan',
    'JO' => 'Jordan','KZ' => 'Kazakhstan','KE' => 'Kenya','KW' => 'Kuwait','KG' => 'Kyrgyzstan','LA' => 'Laos','LV' => 'Latvia','LB' => 'Lebanon',
    'LS' => 'Lesotho','LY' => 'Libyan Arab Jamahiriya','LI' => 'Liechtenstein','LT' => 'Lithuania','LU' => 'Luxembourg','MK' => 'Macedonia',
    'MG' => 'Madagascar','MW' => 'Malawi','MY' => 'Malaysia','MV' => 'Maldives','ML' => 'Mali','MT' => 'Malta','MQ' => 'Martinique','MR' => 'Mauritania',
    'MU' => 'Mauritius','MX' => 'Mexico','MC' => 'Monaco','MN' => 'Mongolia','ME' => 'Montenegro','MA' => 'Morocco','MZ' => 'Mozambique','MM' => 'Myanmar',
    'NA' => 'Namibia','NP' => 'Nepal','NL' => 'Netherlands','AN' => 'Netherlands Antilles','NC' => 'New Caledonia','NZ' => 'New Zealand','NI' => 'Nicaragua',
    'NE' => 'Niger','NG' => 'Nigeria','NF' => 'Norfolk Island','MP' => 'Northern Mariana Islands','NO' => 'Norway','OM' => 'Oman','PK' => 'Pakistan',
    'PW' => 'Palau','PA' => 'Panama','PG' => 'Papua New Guinea','PY' => 'Paraguay','PE' => 'Peru','PH' => 'Philippines','PL' => 'Poland','PT' => 'Portugal',
    'PR' => 'Puerto Rico','QA' => 'Qatar','MD' => 'Republic Of Moldova','RE' => 'Reunion','RO' => 'Romania','RU' => 'Russia','RW' => 'Rwanda',
    'KN' => 'Saint Kitts And Nevis','LC' => 'Saint Lucia','VC' => 'Saint Vincent And The Grenadines','WS' => 'Samoa','SM' => 'San Marino',
    'ST' => 'Sao Tome And Principe','SA' => 'Saudi Arabia','SN' => 'Senegal','RS' => 'Serbia','SC' => 'Seychelles','SG' => 'Singapore','SK' => 'Slovakia',
    'SI' => 'Slovenia','SB' => 'Solomon Islands','ZA' => 'South Africa','KR' => 'South Korea','ES' => 'Spain','LK' => 'Sri Lanka','SD' => 'Sudan',
    'SR' => 'Suriname','SZ' => 'Swaziland','SE' => 'Sweden','CH' => 'Switzerland','SY' => 'Syrian Arab Republic','TW' => 'Taiwan','TJ' => 'Tajikistan',
    'TZ' => 'Tanzania','TH' => 'Thailand','TG' => 'Togo','TO' => 'Tonga','TT' => 'Trinidad And Tobago','TN' => 'Tunisia','TR' => 'Türkiye',
    'TM' => 'Turkmenistan','UG' => 'Uganda','UA' => 'Ukraine','AE' => 'United Arab Emirates','GB' => 'United Kingdom','US' => 'United States',
    'UY' => 'Uruguay','UZ' => 'Uzbekistan','VU' => 'Vanuatu','VE' => 'Venezuela','VN' => 'Vietnam','VG' => 'Virgin Islands British',
    'VI' => 'Virgin Islands U.S.','YE' => 'Yemen','ZM' => 'Zambia','ZW' => 'Zimbabwe'
	);
	
    return $countries;

}



function getFormattedValue($no){
    $d = (float)($no - floor($no));
    $fv = number_format($d, 10);  
    $fvr = (string)$fv;
    $ar = str_split($fvr);
    $indexStart = false;
    $tmpAr = [];
    foreach($ar as $v){
        if($v == '.') $indexStart = true;
        if($v > 0 && $indexStart){
            break;
        }
        if($indexStart && $v == 0){
            $tmpAr[] = $v;
        }
        
    }
    $reval = '0.';
    foreach($tmpAr as $s){
        $reval .= $s;
    }
    $newV = '.0<sub>'. count($tmpAr) . '</sub>';
    return $ret = rtrim(floor($no) . str_replace($reval, $newV, $fv), '0');

}