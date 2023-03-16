<?php 
$mailText ='
<!DOCTYPE html>
<html lang="'.get_cookie("dil").'">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/6ca3b19521.css">
    <title>'.siteSetting()["site_url"].' '.lang("processconfcode").'</title>
    <style>
        body{font-family: "Roboto", sans-serif;}
        .container {width: 100%; height: 100%; display: table; padding: 50px 0px;}
        .center {margin: auto; display: table; background: #fff; width: 70%; border-radius: 4px;}
        .logo {width: 100%;text-align: center;padding-top: 20px;}
        .content{padding: 50px 0px;}
        .content span.name{ color: #27AE60; font-weight: 500;}
        .content span.code { display: block;font-weight: 400;margin-top: 20px;font-size: 16px;margin-bottom: 10px;text-align : left;}
        .content p {font-size: 14px;}
        .content p > a {display: block;font-weight: 500;margin-top: 10px;font-size: 16px;margin-bottom: 10px;}
        .welcomer {margin-bottom: 25px;display: block;font-size: 22px;font-weight: 400;color: #444;}
        .support {margin-top: 10px;text-align: center;font-size: 14px;color: #555;}
        .support a{display: inline-block;background-color: #27AE60;text-decoration: none;font-weight: 500;color: #fff;padding: 10px 30px;border-radius: 100px;}
        .support .text{display: block;margin-bottom: 20px;}
        .copyright{text-align: center;display: block;margin-top: 20px;font-size: 12px;font-weight: 500;color: #555;}
    </style>
</head>

<body>
   <div class="container">
       <div class="center">
           <div class="logo">
           <h3><img style="padding: 5px 20%; box-shadow: 3px 3px 4px #252525;" src="'.siteSetting()["site_url"].'/assets/home/images/logo_dark.png" width="200"></h3>
           </div>
           <div class="content">
               <span class="welcomer">
                   Hello '.$name.',
               </span>
               <p>
                   <span class="code"> '.$subject.'</span>
                   <span class="text"> '.$detail.'</span>
                   <div class="text"> Date : '.$date.'</div>
               </p>
               <span class="copyright">©'.date('Y').' '.siteSetting()["site_url"].'</span>
           </div>
       </div>
   </div>
</body>

</html>';
?>