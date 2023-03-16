
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="config/js/jquery-3.4.1.js"></script>
	
    <script src="http://localhost:8443/socket.io/socket.io.js"></script>
    <script src="config/js/socket.js"></script>
   	<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/mode-ecb.min.js"></script>
</head>
<body>
<div id="walletList"></div>
<div id="demo1"></div>
<div id="demo3"></div>

</body>
</html>
<script type="text/javascript">
	


 //var encrypted = CryptoJS.AES.encrypt("1234", "xZqwertylkjhgx1485*/-");
//var decrypted = CryptoJS.AES.decrypt(encrypted, "xZqwertylkjhgx1485*/-");
//document.getElementById("demo1").innerHTML = encrypted;
//document.getElementById("demo3").innerHTML = decrypted.toString(CryptoJS.enc.Utf8);
 /*   var key = "a41d8cd98f00b204e9800998fcf8427e";
        var KeyObj = CryptoJS.enc.Utf8.parse(key);

var decryptedFromPHP = CryptoJS.AES.decrypt("vwzAYXIwFraCPEcHDI/lOg==", KeyObj, { 
            mode: CryptoJS.mode.ECB, 
        });

// var encrypted = CryptoJS.AES.encrypt("Halil Beydilli  aaaaa", KeyObj, { 
//             mode: CryptoJS.mode.ECB 
//         });
// console.log(encrypted.toString());

//         var decrypted = CryptoJS.AES.decrypt(encrypted, KeyObj, { 
//             mode: CryptoJS.mode.ECB, 
//         });
// console.log(decrypted.toString(CryptoJS.enc.Utf8));
        
        console.log(decryptedFromPHP.toString(CryptoJS.enc.Utf8));
        */
setInterval(() => {
    window.location.href = "http://localhost/server/server.php";
}, 60000);
</script>
