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

function dilBul() {
    $ci=&get_instance();
    $lang = get_cookie('dil');
    if($lang!=''){
        $ci->lang->load('lang', $lang);
        set_cookie('dil',$lang,time()+(60*60*24));
    }else{
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
        if(sup_lang($lang)==1){
            $ci->lang->load('lang', $lang);
            set_cookie('dil',$lang,time()+(60*60*24));
        }else{
            $ci->lang->load('lang', 'tr');
            set_cookie('dil',$lang,time()+(60*60*24));
        }
    }				
}

function sup_lang($dil)
{
    $dil = strtolower($dil);
    if($dil=='tr' || $dil=='en'){return 1;}else{ return 0;}
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

function createGoogleKey() {
    $ci=&get_instance();
    return $ci->googleauthenticator->createSecret();
}

function usdPrice($toShort,$fromShort)
{
    $veri = vericek("https://api.binance.com/api/v3/ticker/price?symbol=".$toShort.$fromShort);
    $data = json_decode($veri,true);
    return $data["price"];
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


function Number($value,$dec){
    return number_format(($value), $dec, '.', '');
}

function convert($data)
{
if(strpos($data,","))
{$chng = str_replace(",",".",$data); $data = $chng;}
return  $data;
}

function getUserGoogleCodeKontrol($key,$code)
{
    $ci=&get_instance();
	$sor = $ci->googleauthenticator->verifyCode($key, $code, 3);
	if(!empty($sor)){
        return 'ok';
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

function serverUrl($system){
    $ci=&get_instance();
    $server = $ci->mongo_db->get('server_datas');
    return siteSetting()["site_wallet_server"].$system."/main.php";
}

function serverUrlTwo(){
    $ci=&get_instance();
    $server = $ci->mongo_db->get('server_datas');
    return siteSetting()["site_wallet_server"];
}

function resimUpload($data){
    $ci=&get_instance();
    $filename = date("dmY_His")."_".$data;
    $config['file_name']            =  $filename;
    $config['upload_path']          = '.././assets/home/images/'.$data.'/';
    $config['allowed_types']        = 'gif|jpg|png';
    $config['max_size']             = 5120;
    $config['max_width']            = 2920;
    $config['max_height']           = 2080;
    $config['file_ext_tolower'] = TRUE;

    $ci->load->library('upload', $config);
    $ci->upload->initialize($config);

    if ( ! $ci->upload->do_upload('filename'))
    {
            return $error = array('error' => $ci->upload->display_errors(),"durum" => "hata");
    }else{   
            return $data = array('data' => $ci->upload->data(),"durum" => "ok");
    }
}

function adminMarketSetting($fromShort,$toShort) {
    $ci=&get_instance();
    $ci->mongo_db->where(array('from_wallet_short' => $fromShort,'to_wallet_short' => $toShort));
    $sor = $ci->mongo_db->get('market_datas');
    if(!empty($sor)){
        $veri = array(
        'market_status' => $sor[0]["market_status"], 
        'priceDecimal' => $sor[0]["market_priceDecimal"],
        'amountDecimal' => $sor[0]["market_amountDecimal"],
        'totalDecimal' => $sor[0]["market_totalDecimal"]
        );

        return $veri;
    }else{
        return 0;
    }
}

function adminFaucetSetting($Short) {
    $ci=&get_instance();
    $ci->mongo_db->limit(1);
    $ci->mongo_db->where(array('wallet_short' => (string)$Short));
    $sor = $ci->mongo_db->get('wallet_faucet_datas');
    if(!empty($sor)){
        return $sor[0];
    }else{
        return 0;
    }
}

function get_time($time){
    $duration = $time;
    $day = floor($duration / 86400);
    $hours = floor($duration / 3600);
    $minutes = floor(($duration / 60) % 60);
    $seconds = $duration % 60;
    if ($hours != 0)
        echo "$hours Hour";
    else
        echo "$minutes Minute";
}

function yetki($email)
{
    $ci=&get_instance();
    $ci->mongo_db->where(array('admin_email' => $email));
    $sor = $ci->mongo_db->get('admin_tables');
    return $sor[0]["admin_yetki"];
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


function replace_tr($text) {
    $text = trim($text);
    $search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü',' ');
    $replace = array('c','c','g','g','i','i','o','o','s','s','u','u','-');
    $new_text = str_replace($search,$replace,$text);
    return $new_text;
}

function getAllBotSor($from,$to){   
    $ci=&get_instance();
    $ci->mongo_db->where(array('bot_from_short'=>$from,'bot_to_short'=>$to));
    $sor = $ci->mongo_db->get('bot_datas');
    if(!empty($sor)){
        return "var";
    }else{
        return "yok";
    }
}

?>