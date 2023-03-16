<?php 
$mailText ='
<!DOCTYPE html>
<html lang="'.get_cookie("dil").'">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/6ca3b19521.css">
    <title>Secondbtc.com email giriş kodu</title>
    <style>
        body
        {
            font-family: "Roboto", sans-serif;
        }

        .container
        {
            width: 100%;
            height: 100%;
            display: table;
            padding: 50px 0px;
        }

        .center
        {
            margin: auto;
            display: table;
            background: #fff;
            width: 50%;
            border-radius: 4px;
            box-shadow: 0px 2px 20px rgba(0,0,0,0.2);
        }

        .logo

        {
            width: 100%;
            text-align: center;
            padding-top: 20px;
        }

        .content

        {
            padding: 50px 0px;
        }

        .content span.name

        {
            color: #27AE60;
            font-weight: 500;
        }

        .content span.code

        {
            display: block;
            font-weight: 400;
            margin-top: 20px;
            font-size: 18px;
            margin-bottom: 10px;
            text-align : left;
        }

        .content p

        {
            font-size: 15px;
        }

        .content p > a

        {
            display: block;
            font-weight: 500;
            margin-top: 10px;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .welcomer

        {
            margin-bottom: 25px;
            display: block;
            font-size: 22px;
            font-weight: 400;
            color: #444;
        }

        .success

        {
        background-color: #27AE60;
        text-align: center;
        padding: 15px;
        font-size: 16px;
        font-weight: 400;
        color: #fff;
        display: block;
        margin: 15px auto;
        border-radius: 4px;
        }

        .login

        {
        margin-bottom: 20px;
        display: inline-block;
        width: 100%;
        }

        .login-ip
        {
            display: block;
            text-align: left;
        }

        .login-date

        {

        width: 45%;
        border: 1px solid #eee;
        display: inline-block;
        float: right;
        padding: 15px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
        box-shadow: 0px 2px 20px rgba(0,0,0,0.2);
    }
    .support
    {
        margin-top: 10px;
        text-align: left;
        font-size: 14px;
        color: #555;
    }
    .support a
    {
        display: inline-block;
        background-color: #27AE60;
        text-decoration: none;
        font-weight: 500;
        color: #fff;
        padding: 10px 30px;
        border-radius: 100px;
    }
    .support .text
    {
        display: block;
        margin-bottom: 20px;
    }
    ul
    {
        text-align: center;
        list-style: none;
        display: table;
        margin: auto;
        margin-top: 30px;
    }
    ul li
    {
        float: left;
        font-size: 22px;
        margin-right: 20px;
    }
    ul li a
    {
        color: #555;
    }
    ul li a:hover
    {
        color: #27AE60;
    }
    .copyright
    {
        text-align: center;
        display: block;
        margin-top: 20px;
        font-size: 12px;
        font-weight: 500;
        color: #555;
    }
    </style>



</head>

<body>
   <div class="container">
       <div class="center">
           <div class="logo">
           <h3><img style="padding: 5px 20%; box-shadow: 3px 3px 4px #252525;" src="'.siteSetting()["site_url"].'/assets/home/images/logo.png" width="200"></h3>
           </div>
           <div class="content">
               <span class="welcomer">
                   Hello Dear User,<span class="name"></span>
               </span>
               <p>
                   <span class="name"> </span>
                   <span class="code"> Site warning message : '.$message.' </span>
                   <span class="login-ip"> Messsage Date : '.$date.'</span>
               </p>
               <div class="support">
                   <a href="'.base_url(get_cookie("dil")).'/support" class="contant">
                       Secondbtc.com/'.get_cookie("dil").'/support
                   </a>
               </div>
               <span class="copyright">
                   @2017-'.date('Y').' Secondbtc, All rights reserved.
               </span>
           </div>
       </div>
   </div>

</body>

</html>';
?>