

var socket = io.connect("http://localhost:8443");
$(document).ready(function(){

        // socket.emit('walletList');
        // socket.on('walletList', function (d1){
        //     var veri='';
        //     $.each(d1.data,function(index,d){
        //         if(d1.data[0].wallet_system=="coin"){
        //        //socket.emit('walletBalanceCoin',[decrypted(d.wallet_server_port),decrypted(d.wallet_server_username),decrypted(d.wallet_server_pass),d.wallet_short]);
        //       // socket.emit('walletTransactionCoin',[decrypted(d.wallet_server_port),decrypted(d.wallet_server_username),decrypted(d.wallet_server_pass),d.wallet_short,d.wallet_conf]);
        //         veri+='<div>'+d.wallet_short+'</div>'
        //     }
        //     }); 
        //      $('#walletList').html(veri); 
        // });

      
        
        socket.emit('walletList');
        socket.on('walletList', function (d1){
            var veri='';
            $.each(d1.data,function(index,d){

                if(d.wallet_system=="token"){
                    var degis1=0 , degis2=5;
                    setInterval(function(){
                        if(index>=degis1 && index<degis2){
                            console.log(d.wallet_short);
                            socket.emit('walletBalanceToken',[d.wallet_cont,d.wallet_short,d.wallet_dec]);
                        }
                        degis1 =degis2; degis2 = degis2+5;
                    }, 2000);

                }else if(d.wallet_system=="eth"){
                    socket.emit('walletBalanceEth',[d.wallet_short,d.wallet_dec]);
                    console.log(d.wallet_dec);

                }else if(d.wallet_system=="coin"){
                    var degis7=0;
                    var degis8=1;
                    setInterval(function(){
                        if(index>=degis7 && index<degis8){
                            if(decrypted(d.wallet_server_port)!="0"){
                                socket.emit('walletBalanceCoin',[decrypted(d.wallet_server_port),decrypted(d.wallet_server_username),decrypted(d.wallet_server_pass),d.wallet_short]);
                                socket.emit('walletTransactionCoin',[decrypted(d.wallet_server_port),decrypted(d.wallet_server_username),decrypted(d.wallet_server_pass),d.wallet_short,d.wallet_conf]);
                            }
                }
                        degis7 =degis8; degis8 = degis8+1;
                    }, 2000);
                }
            }); 
        });

       socket.emit('userWalletDataToken',"token");
            socket.on('userWalletDataToken', function (token1){
                $.each(token1.data,function(index3,token){
                    if(token.wallet_system=="token"){
                    var degis5=0;
                    var degis6=1;
                    setInterval(function(){
                        if(index3>=degis5 && index3<degis6){
                            socket.emit('walletTransactionEthToken',[token.wallet_short,token.wallet_user_id,token.wallet_user_email,token.wallet_user_address,token.wallet_system]); 
                            //console.log(token.wallet_short,token.wallet_user_id,token.wallet_user_email,token.wallet_user_address);
                        }
                        degis5 =degis6; degis6 = degis6+1;
                    }, 2000);
                    var degis10=0;
                    var degis11=1;
                    setInterval(function(){
                        if(index3>=degis10 && index3<degis11){
                            socket.emit('allWalletBalanceTokenEth',[token.wallet_short,token.wallet_system,token.wallet_user_address]);
                        }
                        degis10 =degis11; degis11 = degis11+1;
                    }, 50000);
                    }
                });
        });

        socket.emit('userWalletDataToken',"eth");
            socket.on('userWalletDataToken', function (eth1){
                console.log(eth1);
                $.each(eth1.data,function(index3,eth2){
                    if(eth2.wallet_system=="eth"){
                    var degis10=0;
                    var degis11=1;
                    setInterval(function(){
                        if(index3>=degis10 && index3<degis11){
                            socket.emit('allWalletBalanceTokenEth',[eth2.wallet_short,eth2.wallet_system,eth2.wallet_user_address]);
                        }
                        degis10 =degis11; degis11 = degis11+1;
                    }, 50000);
                    }
                });
        });    

        // //socket.emit('userWalletDataToken',"token");
        //     socket.on('userWalletDataToken', function (token1){
        //         $.each(token1.data,function(index3,token){
        //             if(token.wallet_system=="token"){
        //             var degis5=0;
        //             var degis6=1;
        //             setInterval(function(){
        //                 if(index3>=degis5 && index3<degis6){
        //                     socket.emit('allWalletBalanceTokenEth',[token.wallet_short,token.wallet_system,token.wallet_user_address]);
        //                     console.log(token.wallet_short,token.wallet_user_id,token.wallet_user_email,token.wallet_user_address);
        //                 }
        //                 degis5 =degis6; degis6 = degis6+1;
        //             }, 5000);
        //             }
        //         });
        //     });

         socket.emit('userWalletDataEth',"eth");
            socket.on('userWalletDataEth', function (eth1){
                $.each(eth1.data,function(index3,eth){
                    if(eth.wallet_system=="eth"){
                    var degis5=0;
                    var degis6=1;
                    setInterval(function(){
                        if(index3>=degis5 && index3<degis6){
                            socket.emit('walletTransactionEthToken',[eth.wallet_short,eth.wallet_user_id,eth.wallet_user_email,eth.wallet_user_address,eth.wallet_system]); 
                            //console.log(eth.wallet_short,eth.wallet_user_id,eth.wallet_user_email,eth.wallet_user_address);
                        }
                        degis5 =degis6; degis6 = degis6+1;
                    }, 2000);
                    }
                });
            });

        function decrypted(data){
        var key = "a41d8cd98f00b204e9800998fcf8427e";
        var KeyObj = CryptoJS.enc.Utf8.parse(key);
        var decryptedFromPHP = CryptoJS.AES.decrypt(data, KeyObj, { 
            mode: CryptoJS.mode.ECB, 
        });
        var send = decryptedFromPHP.toString(CryptoJS.enc.Utf8);
        return send;
        }
});

  