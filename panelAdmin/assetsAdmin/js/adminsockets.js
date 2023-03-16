var pathname = window.location.pathname.split( '/' );
var pagename = pathname[1]+'/'+pathname[2];
var socketUrl = "https://secondbtc.com:8443";
var socket = io.connect(socketUrl);
let wallets = [];


$(document).ready(function(){
    //pending withdraw
if(pathname[1]=='panelAdmin' && $("#adminmail").html()!=""){

    socket.emit('faucetAllTotal');
    socket.on('faucetAllTotal', function (d1){
            var faucetveri =0;
        $.each(d1.data,function(index,faucetttt){
            //console.log(faucetttt._id);
            faucetveri+= '<tr><td>'+faucetttt._id+'</td><td>'+faucetttt.unit.toFixed(8)+'</td></tr>'
        });
        $('#faucetBody').html(faucetveri);
    });

    setInterval(() => {     
    socket.emit('userVeriOnline');
    socket.on('userVeriOnline', function (userOnline){$("#onlineUser").html(userOnline); });
    }, 2000); 

    setInterval(() => { 
        pendinWithdraw();
        supportDatas();
    }, 5000); 
    async function pendinWithdraw() {
        socket.emit('userAdminWithdrawPending');
        socket.on('userAdminWithdrawPending', function (pwithdraw1){
                var pendingveri='';
                var sayi = pwithdraw1.data.length;
                if(pwithdraw1.data==''){sayi = 0;}
                $("#pwithSayi1").html(sayi);
                $("#pwithSayi2").html(sayi);
                $.each(pwithdraw1.data,function(index,pwithdraw){
                pendingveri+= '<a href="javascript:void(0);" onclick="singleUser(\'#userInfoScrool\',\''+pwithdraw.withdraw_user_id+'\',\''+pwithdraw.withdraw_user_email+'\');" class="notify-item border-bottom" data-toggle="collapse">'
                                +'<div class="notify-thumb"><i class="btn-primary">'+pwithdraw.withdraw_wallet_short+'</i></div>'
                                +'<div class="notify-text text-right">'
                                +'<p>'+pwithdraw.withdraw_user_email+' <span class="font-size-12"> Time : '+new Date(pwithdraw.withdraw_time*1000).toLocaleTimeString()+'<span></p>'
                                +'<span>'+(pwithdraw.withdraw_amount).toFixed(8)+' '+pwithdraw.withdraw_wallet_short+'</span>'
                                +'</div>'
                                +'</a>'
            });
            $('#pendingWithdrawVeri').html(pendingveri);
        });

    };
    function supportDatas() {
        socket.emit('userAdminSupport');
        socket.on('userAdminSupport', function (supportv1){
                var supportveri='';
                var sayi = supportv1.data.length;
                if(supportv1.data==''){sayi = 0;}
                $("#psupSayi1").html(sayi);
                $("#psupSayi2").html(sayi);
                $.each(supportv1.data,function(index,supportv){
                    supportveri+= '<div class="notify-text mb-3 ml-3">'
                                        +'<p>'+supportv.sup_email+'</p>'
                                        +'<span>'+supportv.sup_subject+'</span>'
                                    +'</div>'
            });
            $('#supportVeri').html(supportveri);
        });
    }
}

    if(pathname[1]+'/'+pathname[2]=='panelAdmin/wallet'){
    socket.emit('walletVeri');
    socket.on('walletVeri', function (d1){

      wallets = d1.data;
        veri='';
        $.each(d1.data,function(index,d){
            var now = new Date();
            var time = now.getTime()-1800000;
            if(d.wallet_status_time){var servertime = d.wallet_status_time;}else{var servertime =0;}
            if(servertime<time){var durum_ss ="OFF", color_ss = "danger";}else{var durum_ss ="ON", color_ss = "success";}
            if(d.wallet_status=="0"){var durum_ws ="OFF", color_ws = "danger";}else{var durum_ws ="ON", color_ws = "success";}
            if(d.wallet_ex_status=="0"){var durum_ex ="OFF", color_ex = "danger";}else{var durum_ex ="ON", color_ex = "success";}
            if(d.wallet_dep_status=="0"){var durum_dep ="OFF", color_dep = "danger";}else{var durum_dep ="ON", color_dep = "success";}
            if(d.wallet_with_status=="0"){var durum_with ="OFF", color_with = "danger";}else{var durum_with ="ON", color_with = "success";}
            if(d.wallet_main_pairs=="0"){var res="NO"}else{ var res=d.wallet_main_pairs;}
            veri+=  '<tr>'
                    +'<td>'+d.wallet_id+'</td>'
                    +'<td>'+d.wallet_short+'</td>'
                    +'<td><a data-toggle="collapse" href="javascript:void(0);" onclick="customJS.wallet.singleWallet(\'#walletInfoScrool\',\''+d.wallet_short+'\')" >'+d.wallet_name+'</a></td>'
                    +'<td><i class=" text-'+color_ss+' font-size-12">'+durum_ss+'</i></td>'
                    +'<td><i class=" text-'+color_ws+' font-size-12">'+durum_ws+'</i></td>'
                    +'<td><i class=" text-'+color_ex+' font-size-12">'+durum_ex+'</i></td>'
                    +'<td><i class=" text-'+color_dep+' font-size-12">'+durum_dep+'</i></td>'
                    +'<td><i class=" text-'+color_with+' font-size-12">'+durum_with+'</i></td>'
                    +'<td>'+d.wallet_balance.toFixed(8)+'</td>'
                    +'<td>'+d.wallet_system+'</td>'
                    +'<td>'+d.wallet_conf+'</td>'
                    +'<td>'+res+'</td>'
                    +'<td>'+d.wallet_dep_com.toFixed(8)+'</td>'
                    +'<td>'+d.wallet_with_com.toFixed(8)+'</td>'
                    +'<td>'+d.wallet_min_dep.toFixed(8)+'</td>'
                    +'<td>'+d.wallet_max_dep.toFixed(8)+'</td>'
                    +'<td>'+d.wallet_min_with.toFixed(8)+'</td>'
                    +'<td>'+d.wallet_max_with.toFixed(8)+'</td>'
                    +'<td>'+d.wallet_min_bid.toFixed(8)+'</td>'
                    +'<td>'+d.wallet_min_unit.toFixed(8)+'</td>'
                    +'<td>'+d.wallet_min_total.toFixed(8)+'</td>'
                    +'<td>'+d.wallet_tag_system+'</td>'
                    +'<td>'+d.wallet_dec+'</td>'
                    +'<td>'+d.wallet_cont+'</td>'
                    +'</tr>';
        });
    
    $('#walletVeri').html(veri);
    $('#walletDataTable').DataTable().destroy();
        $('#walletDataTable').DataTable({
            responsive: {
                details: {
                    renderer: function ( api, rowIdx, columns ) {
                        var data = $.map( columns, function ( col, i ) {
                            return col.hidden ?
                                '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                    '<td>'+col.title+':'+'</td> '+
                                    '<td>'+col.data+'</td>'+
                                '</tr>' :
                                '';
                        } ).join('');
     
                        return data ?
                            $('<table/>').append( data ) :
                            false;
                    }
                }
            }
        });  
    });
    }
});

//deposit page
$(document).ready(function(){
    if(pathname[1]+'/'+pathname[2]+'/'+pathname[3]=='panelAdmin/wallet/deposit'){
            socket.emit('depositVeri',{pageNo:1,size:100});
            socket.on('depositVeri', function (dep1){
                // console.log('dep1',dep1);
                $('#walletDepositDataTable').DataTable().destroy();
                var veri2 =''
                $.each(dep1.data.veri,function(index,dep){
                    var odelete = '<span class="badge badge-info cursor-pointer" onclick="customJS.wallet.depositDelete(\''+dep.dep_history_id+'\')">Delete</span>';
                    if(dep.dep_history_system=="fiat" && dep.dep_history_status!=1){
                        var onayFiat =  '<span class="badge badge-warning cursor-pointer" data-toggle="modal" data-target="#sendModal" onclick="customJS.wallet.fiatDepositOnayla(\''+dep.dep_history_user_email+'\',\''+dep.dep_history_txid+'\',\''+dep.dep_history_user_id+'\',\''+dep.dep_history_id+'\',\''+dep.dep_history_wallet_short+'\')"> Confirm</span>';
                    }else{onayFiat = '';}
                    if(dep.dep_history_status!=1){var durum = ' <i class="spinner-border text-success spinner-border-sm text-warning"><span class="d-none">0</span></i>('+dep.dep_history_comfirmation+')';
                    }else{var durum = '<i class="fa fa-check-circle text-success"><span class="d-none">1</span></i>';}

                  const wallet = wallets.find(w => w.wallet_short === dep.dep_history_wallet_short);
                 const url =  wallet ? (wallet.wallet_network === 1 || wallet.wallet_network === 4) ? `https://etherscan.io/tx/${dep.dep_history_txid}` : `https://bscan.io/tx/${dep.dep_history_txid}` : '';
                  const link = `<a target='_blank' href="${url}">${dep.dep_history_txid}</a>`;

                    veri2+=  '<tr id="'+dep.dep_history_id+'">'
                    +'<td>'+dep.dep_history_wallet_short+'</td>'
                    +'<td ondblclick="customJS.wallet.addInputWallet(this,\''+dep.dep_history_id+'\',3,\'dep_history_amount\',\''+dep.dep_history_user_id+'\')">'+dep.dep_history_amount.toFixed(8)+'</td>'
                    +'<td>'+dep.dep_history_user_email+'</td>'
                    +'<td>'+durum+onayFiat+'</td>'
                    +'<td>'+link+'</td>'
                    +'<td><span class="d-none">'+dep.dep_history_time+'</span>'+new Date(dep.dep_history_time*1000).toLocaleString()+'</td>'
                    +'<td>'+dep.dep_history_system+'</td>'
                    +'<td>'+dep.dep_history_address+'</td>'
                    +'<td>'+dep.dep_history_tag+'</td>'
                    +'<td>'+dep.dep_history_user_id+'</td>'
                    +'<td>'+dep.dep_history_id+'</td>'
                    +'<td>'+odelete+'</td>'
                    +'</tr>';
                });
                $('#depositVeri').html(veri2);
                $('#walletDepositDataTable').DataTable({
                    "bLengthChange": false,
                    "info": false,
                    "order": [[ 3, "asc" ],[ 4, "desc" ]],
                    responsive: {
                        details: {
                            renderer: function ( api, rowIdx, columns ) {
                                var data = $.map( columns, function ( col, i ) {
                                    return col.hidden ?
                                        '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                            '<td>'+col.title+':'+'</td> '+
                                            '<td>'+col.data+'</td>'+
                                        '</tr>' :
                                        '';
                                } ).join('');
            
                                return data ?
                                    $('<table/>').append( data ) :
                                    false;
                            }
                        }
                    }
                });
                
            });
    }


//withdraw page
    if(pathname[1]+'/'+pathname[2]+'/'+pathname[3]=='panelAdmin/wallet/withdraw'){
        // socket.emit('withdrawVeri',{pageNo:1,size:100});
            socket.on('withdrawVeri', function (with1){
                $('#walletWithdrawDataTable').DataTable().destroy();
                var veri2 ='';
                $.each(with1.data,function(index,with2){
                    $("body").tooltip({ selector: '[data-toggle=tooltip]' });
                    if(with2.withdraw_status=="0"){
                        var durum = '<span class="d-none">0</span><span class="badge badge-warning cursor-pointer" data-toggle="modal" data-target="#sendModal" onclick="customJS.wallet.walletSendModal(\''+with2.withdraw_id+'\',\''+with2.withdraw_user_email+'\',\''+with2.withdraw_user_id+'\',\''+with2.withdraw_address+'\',\''+with2.withdraw_cont+'\',\''+with2.withdraw_tag+'\',\''+with2.withdraw_wallet_short+'\','+with2.withdraw_amount+',\''+with2.withdraw_txid+'\',1)">Send</span>';
                        var again = '';
                        var sil = '<span class="badge badge-danger cursor-pointer" data-toggle="modal" data-target="#deleteModal" onclick="customJS.wallet.walletDeleteModal(\''+with2.withdraw_id+'\',\''+with2.withdraw_user_email+'\',\''+with2.withdraw_user_id+'\',\''+with2.withdraw_address+'\',\''+with2.withdraw_cont+'\',\''+with2.withdraw_tag+'\',\''+with2.withdraw_wallet_short+'\','+with2.withdraw_amount+',2)">Delete</span>';
                        var iade = '<span class="badge badge-info cursor-pointer" data-toggle="modal" data-target="#cancelModal" onclick="customJS.wallet.walletCancelModal(\''+with2.withdraw_id+'\',\''+with2.withdraw_user_email+'\',\''+with2.withdraw_user_id+'\',\''+with2.withdraw_address+'\',\''+with2.withdraw_cont+'\',\''+with2.withdraw_tag+'\',\''+with2.withdraw_wallet_short+'\','+with2.withdraw_amount+',2)">Cancel</span>';
                    }else if(with2.withdraw_status=="2"){
                        var durum = '<i class="fa fa-times-circle text-warning" data-toggle="tooltip" data-placement="left" title="The withdrawal was cancelled."><span class="d-none">2</span></i>';
                        var again = '';
                        var sil = '';
                        var iade = '';
                    }else if(with2.withdraw_status=="3"){
                        var durum = '<i class="fa fa-times-circle text-danger" data-toggle="tooltip" data-placement="left" title="The withdrawal was deleted."><span class="d-none">2</span></i>';
                        var again = '';
                        var sil = '';
                        var iade = '';
                    }else if(with2.withdraw_status=="1"){
                        var durum = '<i class="fa fa-check-circle text-success" data-toggle="tooltip" data-placement="left" title="Withdrawal completed."><span class="d-none">1</span></i>';
                        if($("#say123").val()<10){
                        var again =''; 
                        }else{
                        var again = '<span class="badge badge-info cursor-pointer" data-toggle="modal" data-target="#sendModal" id="sendagain" onclick="customJS.wallet.walletSendModal(\''+with2.withdraw_id+'\',\''+with2.withdraw_user_email+'\',\''+with2.withdraw_user_id+'\',\''+with2.withdraw_address+'\',\''+with2.withdraw_cont+'\',\''+with2.withdraw_tag+'\',\''+with2.withdraw_wallet_short+'\','+with2.withdraw_amount+',\''+with2.withdraw_txid+'\',2)">Send Again</span>';
                        }
                        var sil = '';
                        var iade = '';
                    }
                    veri2+=  '<tr>'
                    +'<td>'+with2.withdraw_wallet_short+'</td>'
                    +'<td>'+with2.withdraw_user_email+'</td>'
                    +'<td>'+with2.withdraw_amount.toFixed(8)+'</td>'
                    +'<td>'+durum+'</td>'
                    +'<td><span class="d-none">'+with2.withdraw_time+'</span>'+new Date(with2.withdraw_time*1000).toLocaleString()+'</td>'
                    +'<td>'+iade+' '+again+' '+sil+'</td>'
                    +'<td>'+with2.withdraw_address+'</td>'
                    +'<td>'+with2.withdraw_tag+'</td>'
                    +'<td>'+with2.withdraw_cont+'</td>'
                    +'<td>'+with2.withdraw_txid+'</td>'
                    +'<td>'+with2.withdraw_id+'</td>'
                    +'<td>'+with2.withdraw_user_id+'</td>'
                    +'<td>'+with2.withdraw_system+'</td>'
                    +'</tr>';
                });
                
                $('#withdrawVeri').html(veri2);
                $('#walletWithdrawDataTable').DataTable({
                    "bLengthChange": false,
                    "info": false,
                    "order": [[ 3, "asc" ],[ 4, "desc" ]],
                    responsive: {
                        details: {
                            renderer: function ( api, rowIdx, columns ) {
                                var data = $.map( columns, function ( col, i ) {
                                    return col.hidden ?
                                        '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                            '<td>'+col.title+':'+'</td> '+
                                            '<td>'+col.data+'</td>'+
                                        '</tr>' :
                                        '';
                                } ).join('');
            
                                return data ?
                                    $('<table/>').append( data ) :
                                    false;
                            }
                        }
                    }
                });
            });
        }
        if(pathname[1]+'/'+pathname[2]+'/'+pathname[3]=='panelAdmin/wallet/orderbook'){
            socket.emit('orderBookAll',selectWallet);
                socket.on('orderBookAll', function (orderBook1){
                    $('#openOrdersDataTable').DataTable().destroy();
                    var orderBookList ='';
                    $.each(orderBook1.data,function(index,orderBook){
                        $("body").tooltip({ selector: '[data-toggle=tooltip]' });
                        var oiade = '<span class="badge badge-info cursor-pointer" onclick="customJS.wallet.cancelOpenOrder(\''+orderBook.exchange_user_email+'\',\''+orderBook.exchange_user_id+'\',\''+orderBook.exchange_id+'\','+orderBook.exchange_created+')">Cancel</span>';
                        var ocancelled = '<span class="text-danger" data-placement="left" title="The order has been canceled.">Cancelled</span>';
                        var osuccess = '<span class="text-success" data-placement="left" title="The order has been canceled.">Success</span>';
                        if(orderBook.exchange_status==1){cancel=oiade;
                        }else if(orderBook.exchange_status==0 && orderBook.exchange_unit.toFixed(8)>0){cancel=ocancelled;
                        }else if(orderBook.exchange_status==0 && orderBook.exchange_unit.toFixed(8)<=0){cancel=osuccess;}
                        if(orderBook.exchange_completed==null || orderBook.exchange_completed==0){var closedDate = "open";
                        }else{var closedDate = new Date(orderBook.exchange_completed*1000).toLocaleString();}
                        if(orderBook.exchange_type=="buy"){var commission = (orderBook.exchange_comission-1).toFixed(5)*100;}
                        if(orderBook.exchange_type=="sell"){var commission = (1-orderBook.exchange_comission).toFixed(5)*100;}
                        orderBookList+=  '<tr id="'+orderBook.exchange_id+'">'
                        +'<td>'+orderBook.exchange_from_short+'</td>'
                        +'<td>'+orderBook.exchange_to_short+'</td>'
                        +'<td>'+orderBook.exchange_type+'</td>'
                        +'<td>'+orderBook.exchange_bid.toFixed(8)+'</td>'
                        +'<td>'+orderBook.exchange_unit.toFixed(8)+'</td>'
                        +'<td>'+orderBook.exchange_total.toFixed(8)+'</td>'
                        +'<td>'+orderBook.exchange_first_unit.toFixed(8)+'</td>'
                        +'<td>'+((orderBook.exchange_bid*orderBook.exchange_first_unit)*orderBook.exchange_comission).toFixed(8)+'</td>'
                        +'<td>'+commission+'%</td>'
                        +'<td><span class="d-none">'+orderBook.exchange_created+'</span>'+new Date(orderBook.exchange_created*1000).toLocaleString()+'</td>'
                        +'<td><span class="d-none">'+closedDate+'</span>'+closedDate+'</td>'
                        +'<td>'+orderBook.exchange_user_email+'</td>'
                        +'<td>'+orderBook.exchange_id+'</td>'
                        +'<td>'+cancel+'</td>'
                        +'</tr>';
                    });
                    
                    $('#orderbookVeri').html(orderBookList);
                    $('#openOrdersDataTable').DataTable({
                        "order": [[ 10, "desc" ]],
                        responsive: {
                            details: {
                                renderer: function ( api, rowIdx, columns ) {
                                    var data = $.map( columns, function ( col, i ) {
                                        return col.hidden ?
                                            '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                                '<td>'+col.title+':'+'</td> '+
                                                '<td>'+col.data+'</td>'+
                                            '</tr>' :
                                            '';
                                    } ).join('');
                
                                    return data ?
                                        $('<table/>').append( data ) :
                                        false;
                                }
                            }
                        }
                    });
                });
        } 

        if(pathname[1]+'/'+pathname[2]+'/'+pathname[3]=='panelAdmin/wallet/tradehistory'){
            socket.emit('tradehistoryAll',selectWallet);
                socket.on('tradehistoryAll', function (tradeHistory1){
                    $('#tradeHistoryDataTable').DataTable().destroy();
                    var tradeList ='';
                    $.each(tradeHistory1.data,function(index,tradeHistory){
                        if(tradeHistory.trade_type=="buy"){
                          var commission = (tradeHistory.trade_commission-1).toFixed(5)*100;
                        }else{
                            var commission = (1-tradeHistory.trade_commission).toFixed(5)*100;
                        }
                        $("body").tooltip({ selector: '[data-toggle=tooltip]' });
                        tradeList+=  '<tr id="'+tradeHistory.trade_id+'">'
                        +'<td>'+tradeHistory.trade_from_wallet_short+'</td>'
                        +'<td>'+tradeHistory.trade_to_wallet_short+'</td>'
                        +'<td>'+tradeHistory.trade_type+'</td>'
                        +'<td>'+tradeHistory.trade_bid.toFixed(8)+'</td>'
                        +'<td>'+tradeHistory.trade_unit.toFixed(8)+'</td>'
                        +'<td>'+tradeHistory.trade_total.toFixed(8)+'</td>'
                        +'<td>'+commission+' %</td>'
                        +'<td><span class="d-none">'+tradeHistory.trade_created+'</span>'+new Date(tradeHistory.trade_created*1000).toLocaleString()+'</td>'
                        +'<td>'+tradeHistory.trade_user_email+'</td>'
                        +'<td>'+tradeHistory.trade_exchange_rol+'</td>'
                        +'<td>'+tradeHistory.trade_id+'</td>'
                        +'</tr>';
                    });
                    
                    $('#tradeHistoryVeri').html(tradeList);
                    $('#tradeHistoryDataTable').DataTable({
                        "order": [[ 7, "desc" ]],
                        responsive: {
                            details: {
                                renderer: function ( api, rowIdx, columns ) {
                                    var data = $.map( columns, function ( col, i ) {
                                        return col.hidden ?
                                            '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                                '<td>'+col.title+':'+'</td> '+
                                                '<td>'+col.data+'</td>'+
                                            '</tr>' :
                                            '';
                                    } ).join('');
                
                                    return data ?
                                        $('<table/>').append( data ) :
                                        false;
                                }
                            }
                        }
                    });
                });
    }
    if(pathname[1]+'/'+pathname[2]+'/'+pathname[3]=='panelAdmin/invoice/invoiceCreate'){
        socket.emit('tradeVolTopla');
        socket.on('tradeVolTopla', function (invoice1){
            var tradeTotalList ='';
            $.each(invoice1.data,function(index,invoice){
                if(invoice.type=="buy"){var commission = (invoice.commission-1).toFixed(5)*100;}
                if(invoice.type=="sell"){var commission = (1-invoice.commission).toFixed(5)*100;}
                var commissionHesap = commission/100+1;
                var totalval = (invoice.total*commissionHesap)-invoice.total;
                $.post( customJS.serviceURL + "invoice/userDetail", {
                    email: invoice._id
                }) 
                .done(function(data) {
                    data = jQuery.parseJSON( data );
                    if(data[0].user_middle_name!=''){var middlename =data[0].user_middle_name+' '; }else{var middlename='';}
                    var firstname = data[0].user_first_name;
                    var lastname = data[0].user_last_name;
                    var idnumber = data[0].user_id_number;
                    var city = data[0].user_city;
                    var ggga = JSON.stringify(invoice.tradeid);
                    tradeTotalList+=  '<tr>'
                    +'<td>'+firstname+' '+middlename+lastname+'</td>'
                    +'<td>'+invoice._id+'</td>'
                    +'<td>'+idnumber+'</td>'
                    +'<td>'+city+'</td>'
                    +'<td>'+invoice.total.toFixed(2)+'</td>'
                    +'<td>'+totalval.toFixed(2)+'</td>'
                    +'<td>'+((totalval*1.18)-totalval).toFixed(2)+'</td>'
                    +'<td><a data-toggle="collapse" href="javascript:void(0);" onclick="customJS.tax.createInvoise(\''+invoice._id+'\',\''+invoice.userid+'\','+totalval.toFixed(2)+',\''+ggga+'\')" ><i class="fa fa-file-text-o"></i></a></td>'
                    +'</tr>';

                $('#tradeTotalVeri').html(tradeTotalList);
                });
            });
            $('#invoiceDataTable').DataTable().destroy();
                $('#invoiceDataTable').DataTable({
                    "order": [[ 1, "desc" ]],
                    responsive: {
                        details: {
                            renderer: function ( api, rowIdx, columns ) {
                                var data = $.map( columns, function ( col, i ) {
                                    return col.hidden ?
                                        '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                            '<td>'+col.title+':'+'</td> '+
                                            '<td>'+col.data+'</td>'+
                                        '</tr>' :
                                        '';
                                } ).join('');
            
                                return data ?
                                    $('<table/>').append( data ) :
                                    false;
                            }
                        }
                    }
                });
        });
    }
});

//user page
if(pathname[1]+'/'+pathname[2]=='panelAdmin/user'){
    $(document).ready(function(){
        socket.emit('userVeri',{pageNo:1,size:100});
        socket.on('userVeri', function (user1){
            //console.log(user1);
            userveri='';
            $('.page-item').on('click', function() {
                var $this = $(this);
                var loadingText = '<a class="page-link"><i class="spinner-border spinner-border-sm"></i></a>';
                if ($(this).html() !== loadingText) {
                  $this.data('original-text', $(this).html());
                  $this.html(loadingText);
                }
                setTimeout(function() {
                  $this.html($this.data('original-text'));
                }, 5000);
              });
        $('#userDataTable').DataTable().destroy();
        $.each(user1.data,function(index,user){
                if(user.user_ex_status==0){var durum_ex ="OFF", color_ex = "danger";}else{var durum_ex ="ON", color_ex = "success";}
                if(user.user_wallet_status==0){var durum_wallet ="OFF", color_wallet = "danger";}else{var durum_wallet ="ON", color_wallet = "success";}
                if(user.user_login_status==0){var durum_login ="OFF", color_login = "danger";}else{var durum_login ="ON", color_login = "success";}
                if(user.user_free_trade==0){var durum_trade ="OFF", color_trade = "danger";}else{var durum_trade ="ON", color_trade = "success";}
                if(user.user_email_conf==0){
                    var durum = '<i class="fa fa-times-circle text-warning" data-toggle="tooltip" data-placement="left" title="No mail confirmation."></i>';
                }else{
                    var durum = '<i class="fa fa-check-circle text-success" data-toggle="tooltip" data-placement="left" title="Mail confirmation."></i>';
                }
                userveri+=  '<tr>'
                        +'<td class="text-left"><a data-toggle="collapse" href="javascript:void(0);" onclick="singleUser(\'#userInfoScrool\',\''+user.user_id+'\',\''+user.user_email+'\');" >'+user.user_email+'</a></td>'
                        +'<td><i class=" text-'+color_ex+' font-size-12">'+durum_ex+'</i></td>'
                        +'<td><i class=" text-'+color_wallet+' font-size-12">'+durum_wallet+'</i></td>'
                        +'<td><i class=" text-'+color_login+' font-size-12">'+durum_login+'</i></td>'
                        +'<td>'+durum+'</td>'
                        +'<td>'+user.user_ip+'</td>'
                        +'<td><span class="d-none">'+user.user_create+'</span>'+new Date(user.user_create*1000).toLocaleString()+'</td>'
                        +'<td><i class=" text-'+color_trade+' font-size-12">'+durum_trade+'</i></td>'
                        +'<td>'+user.user_id+'</td>'
                        +'</tr>';
            });
        
        $('#userVeri').html(userveri);
            $('#userDataTable').DataTable({
            "order": [[ 5, "desc" ]],
            "bLengthChange": false,
            "info": false,
            responsive: {
                    details: {
                        renderer: function ( api, rowIdx, columns ) {
                            var data = $.map( columns, function ( col, i ) {
                                return col.hidden ?
                                    '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                        '<td>'+col.title+':'+'</td> '+
                                        '<td>'+col.data+'</td>'+
                                    '</tr>' :
                                    '';
                            } ).join('');
         
                            return data ?
                                $('<table/>').append( data ) :
                                false;
                        }
                    }
                }
            });  
        });
});

    function singleUser(id,userid,useremail){
        $("#loader111").show();
        $('#myTab a[href="#home"]').trigger('click');
        $("body").tooltip({ selector: '[data-toggle=tooltip]' });
        var data = [userid,useremail];
        socket.emit('userVeriSingle',data);
        socket.on('userVeriSingle', function (user2){
         if(user2.data[0].user_email_conf==0){
                var durum = '<i class="fa fa-times-circle text-warning" data-toggle="tooltip" data-placement="left" title="No mail confirmation."> Unapproved</i>';
            }else{
                var durum = '<i class="fa fa-check-circle text-success" data-toggle="tooltip" data-placement="left" title="Mail confirmation."> Approved</i>';
            }
            $("#user_id").html(user2.data[0].user_id);
            $("#user_email").html(user2.data[0].user_email);
            $("#user_wallet_status").prop("checked", parseInt(user2.data[0].user_wallet_status));
            $("#user_login_status").prop("checked", parseInt(user2.data[0].user_login_status));
            $("#user_ex_status").prop("checked", parseInt(user2.data[0].user_ex_status));
            $("#user_free_trade").prop("checked", parseInt(user2.data[0].user_free_trade));
            $("#user_with_conf").val(user2.data[0].user_with_conf);
            $("#user_login_conf").val(user2.data[0].user_login_conf);
            $("#user_google_conf").val(user2.data[0].user_google_conf);
            $("#user_email_conf").html(durum);
            $("#user_referans_code").html(user2.data[0].user_referans_code);
            $("#user_ip").html(user2.data[0].user_ip);
            $("#user_create").html(new Date(user2.data[0].user_create*1000).toLocaleString());
            
            $("#userInfo").show('slow'); $("#loader111").hide();
            $('html, body').animate({'scrollTop':$(id).offset().top}, 1000);
        });
setTimeout(() => {
        //user wallet
        socket.emit('userDetailData',data);
        socket.on('userDetailData', function (uDetail1){
            if(uDetail1.data[0]){
            $("#user_id_detail").html(uDetail1.data[0].user_id);
            $("#user_email_detail").html(uDetail1.data[0].user_email);
            $("#user_first_name").html(uDetail1.data[0].user_first_name);
            $("#user_middle_name").html(uDetail1.data[0].user_middle_name);
            $("#user_last_name").html(uDetail1.data[0].user_last_name);
            $("#user_country").html(uDetail1.data[0].user_country);
            $("#user_city").html(uDetail1.data[0].user_city);
            $("#user_id_number").html(uDetail1.data[0].user_id_number);
            $("#user_tel").html(uDetail1.data[0].user_tel);
            $("#user_dogum").html(uDetail1.data[0].user_dogum);
            $("#user_address").html(uDetail1.data[0].user_address);
        }
        });
}, 1000);
setTimeout(() => {
    //user wallet
    socket.emit('userWalletData',data);
    socket.on('userWalletData', function (uWallet1){
            $('#userWalletTable').DataTable().destroy();
            var userwalletveri='';
            $.each(uWallet1.data,function(index,uWallet){
                if(uWallet.addressCheckDtatus==0){var check='<i class="text-success cursor-pointer" id="depCheck" title="Check users deposit." onclick="customJS.users.userAddDepositCheck(\''+uWallet.wallet_user_email+'\',\''+uWallet.wallet_user_id+'\',\''+uWallet.wallet_short+'\')">Check</i>';}else if(uWallet.addressCheckDtatus==1){var check="Active";}
            userwalletveri+=  '<tr>'
                    +'<td>'+uWallet.wallet_id+'</td>'
                    +'<td>'+uWallet.wallet_short+'</td>'
                    +'<td>'+uWallet.wallet_name+'</td>'
                    +'<td  ondblclick="customJS.users.addInput(this,\''+uWallet.wallet_short+'\')">'+uWallet.wallet_user_balance.toFixed(8)+'</td>'
                    +'<td>'+uWallet.wallet_system+'</td>'
                    +'<td>'+uWallet.wallet_user_address+'</td>'
                    +'<td>'+uWallet.wallet_user_tag+'</td>'
                    +'<td>'+uWallet.wallet_withdraw_address+'</td>'
                    +'<td>'+uWallet.wallet_withdraw_tag+'</td>'
                    +'<td>'+check+'</td>'
                    +'<td><i class="text-success ti-pencil-alt cursor-pointer" data-toggle="modal" data-target="#addDeposit" onclick="customJS.users.userAddDepositModal(\''+uWallet.wallet_user_email+'\',\''+uWallet.wallet_user_id+'\',\''+uWallet.wallet_user_address+'\',\''+uWallet.wallet_short+'\',\''+uWallet.wallet_system+'\')"></i></td>'
                    +'<td><i class="text-danger ti-pencil-alt cursor-pointer" data-toggle="modal" data-target="#addWithdraw" onclick="customJS.users.userAddWithdrawModal(\''+uWallet.wallet_user_email+'\',\''+uWallet.wallet_user_id+'\',\''+uWallet.wallet_user_address+'\',\''+uWallet.wallet_short+'\','+uWallet.wallet_id+',\''+uWallet.wallet_system+'\')"></i></td>'
                    +'<td><i class="text-danger ti-trash cursor-pointer" onclick="customJS.users.userDeleteAddress(\''+uWallet.wallet_user_email+'\',\''+uWallet.wallet_user_id+'\',\''+uWallet.wallet_user_address+'\',\''+uWallet.wallet_short+'\')"></i></td>'
                    +'</tr>';
        });
        $('#userWalletVeri').html(userwalletveri);
        $('#userWalletTable').DataTable({
            "order": [[ 3, "desc" ]],
            responsive: {
                details: {
                    renderer: function ( api, rowIdx, columns ) {
                        var data = $.map( columns, function ( col, i ) {
                            return col.hidden ?
                                '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                    '<td>'+col.title+':'+'</td> '+
                                    '<td>'+col.data+'</td>'+
                                '</tr>' :
                                '';
                        } ).join('');
                    
                        return data ?
                            $('<table/>').append( data ) :
                            false;
                    }
                }
            }
        });
    });
}, 1000);
setTimeout(() => {
    //user open order
    socket.emit('orderPageBookAdmin',data);
    socket.on('orderPageBookAdmin', function (orders1){
            $('#OrdersTable').DataTable().destroy();
            var ordersveri='';
            $.each(orders1.data,function(index,orders){
            if(orders.exchange_type=="buy"){
                var color_type = "success";
                if(orders.exchange_status==1){
                }
            }else{
                var color_type = "danger";
                if(orders.exchange_status==1){
                }
            }
            ordersveri+=  '<tr>'
                    +'<td>'+orders.exchange_from_short+'</td>'
                    +'<td>'+orders.exchange_to_short+'</td>'
                    +'<td><i class=" text-'+color_type+' font-size-12">'+orders.exchange_type+'</i></td>'
                    +'<td>'+orders.exchange_bid.toFixed(8)+'</td>'
                    +'<td>'+orders.exchange_unit.toFixed(8)+'</td>'
                    +'<td>'+orders.exchange_total.toFixed(8)+'</td>'
                    +'<td>'+orders.exchange_first_unit.toFixed(8)+'</td>'
                    +'<td>'+((orders.exchange_bid*orders.exchange_first_unit)*orders.exchange_comission).toFixed(8)+'</td>'
                    +'<td>'+((orders.exchange_comission-1)*100).toFixed(5)+' %</td>'
                    +'<td>'+new Date(orders.exchange_created*1000).toLocaleString()+'</td>'
                    +'<td>'+orders.exchange_id+'</td>'
                    +'<td>'+orders.exchange_user_email+'</td>'
                    +'</tr>';
        });
        $('#openOrdersVeri').html(ordersveri);
        $('#OrdersTable').DataTable({
            "order": [[ 9, "desc" ]],
            responsive: {
                details: {
                    renderer: function ( api, rowIdx, columns ) {
                        var data = $.map( columns, function ( col, i ) {
                            return col.hidden ?
                                '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                    '<td>'+col.title+':'+'</td> '+
                                    '<td>'+col.data+'</td>'+
                                '</tr>' :
                                '';
                        } ).join('');
                    
                        return data ?
                            $('<table/>').append( data ) :
                            false;
                    }
                }
            }
        });
    });
}, 1000);
setTimeout(() => {
        //user trade History
        socket.emit('orderPageTradeDataAdmin',data);
        socket.on('orderPageTradeDataAdmin', function (trades1){
                $('#tradeHistory').DataTable().destroy();
                var tradesveri='';
                $.each(trades1.data,function(index,trades){
                if(trades.trade_type=="buy"){
                    var color_type = "success";;
                }else{
                    var color_type = "danger";
                }
                tradesveri+=  '<tr>'
                        +'<td>'+trades.trade_from_wallet_short+'</td>'
                        +'<td>'+trades.trade_to_wallet_short+'</td>'
                        +'<td><i class=" text-'+color_type+' font-size-12">'+trades.trade_type+'</i></td>'
                        +'<td>'+trades.trade_bid.toFixed(8)+'</td>'
                        +'<td>'+trades.trade_unit.toFixed(8)+'</td>'
                        +'<td>'+trades.trade_total.toFixed(8)+'</td>'
                        +'<td>'+trades.trade_exchange_rol+'</td>'
                        +'<td>'+new Date(trades.trade_created*1000).toLocaleString()+'</td>'
                        +'<td>'+trades.trade_id+'</td>'
                        +'<td>'+trades.trade_user_email+'</td>'
                        +'<td>'+trades.trade_to_user_email+'</td>'
                        +'</tr>';
            });
            $('#tradeHistoryVeri').html(tradesveri);
            $('#tradeHistory').DataTable({
                "order": [[ 8, "desc" ]],
                responsive: {
                    details: {
                        renderer: function ( api, rowIdx, columns ) {
                            var data = $.map( columns, function ( col, i ) {
                                return col.hidden ?
                                    '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                        '<td>'+col.title+':'+'</td> '+
                                        '<td>'+col.data+'</td>'+
                                    '</tr>' :
                                    '';
                            } ).join('');
                        
                            return data ?
                                $('<table/>').append( data ) :
                                false;
                        }
                    }
                }
            });
        });
    }, 1000);
    setTimeout(() => {
        //user Deposit
        socket.emit('userAdminDeposit',data);
        socket.on('userAdminDeposit', function (uDeposit1){
                $('#userDepositTable').DataTable().destroy();
                var depositveri='';
                $.each(uDeposit1.data,function(index,uDeposit){
                if(uDeposit.dep_history_status!=1){var durum = ' <i class="spinner-border text-success spinner-border-sm text-warning" data-toggle="tooltip" data-placement="left" title="Pending deposit"><span class="d-none">0</span></i>';
                }else{var durum = '<i class="fa fa-check-circle text-success" data-toggle="tooltip" data-placement="left" title="Deposit completed."><span class="d-none">1</span></i>';
                }
                depositveri+=  '<tr>'
                        +'<td>'+uDeposit.dep_history_wallet_short+'</td>'
                        +'<td>'+uDeposit.dep_history_amount.toFixed(8)+'</td>'
                        +'<td>'+uDeposit.dep_history_comfirmation+'</td>'
                        +'<td>'+durum+'</td>'
                        +'<td>'+uDeposit.dep_history_address+'</td>'
                        +'<td>'+uDeposit.dep_history_tag+'</td>'
                        +'<td>'+uDeposit.dep_history_txid+'</td>'
                        +'<td><span class="d-none">'+uDeposit.dep_history_time+'</span>'+new Date(uDeposit.dep_history_time*1000).toLocaleString()+'</td>'
                        +'</tr>';
            });
            $('#userDepositVeri').html(depositveri);
            $('#userDepositTable').DataTable({
                "order": [[ 3, "asc" ],[ 7, "desc" ]],
                responsive: {
                    details: {
                        renderer: function ( api, rowIdx, columns ) {
                            var data = $.map( columns, function ( col, i ) {
                                return col.hidden ?
                                    '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                        '<td>'+col.title+':'+'</td> '+
                                        '<td>'+col.data+'</td>'+
                                    '</tr>' :
                                    '';
                            } ).join('');
                        
                            return data ?
                                $('<table/>').append( data ) :
                                false;
                        }
                    }
                }
            });
        });
    }, 2000);
    setTimeout(() => {
        //user Withdraw
        socket.emit('userAdminWithdraw',data);
        socket.on('userAdminWithdraw', function (uWithdraw1){
                $('#userWithdrawTable').DataTable().destroy();
                var withdrawveri='';
                $.each(uWithdraw1.data,function(index,uWithdraw){
                if(uWithdraw.withdraw_status==0){
                    var durum = '<i class="spinner-border text-success spinner-border-sm text-warning" data-toggle="tooltip" data-placement="left" title="Pending withdrawal"><span class="d-none">0</span></i>';
                }else if(uWithdraw.withdraw_status==2){
                    var durum = '<i class="fa fa-times-circle text-warning" data-toggle="tooltip" data-placement="left" title="The withdrawal was cancelled."><span class="d-none">2</span></i>';
                }else if(uWithdraw.withdraw_status==3){
                    var durum = '<i class="fa fa-times-circle text-danger" data-toggle="tooltip" data-placement="left" title="The withdrawal was deleted."><span class="d-none">2</span></i>';
                }else if(uWithdraw.withdraw_status==1){
                    var durum = '<i class="fa fa-check-circle text-success" data-toggle="tooltip" data-placement="left" title="Withdrawal completed."><span class="d-none">1</span></i>';
                }
                withdrawveri+=  '<tr>'
                        +'<td>'+uWithdraw.withdraw_wallet_short+'</td>'
                        +'<td>'+uWithdraw.withdraw_amount.toFixed(8)+'</td>'
                        +'<td>'+uWithdraw.withdraw_commission.toFixed(8)+'</td>'
                        +'<td>'+durum+'</td>'
                        +'<td>'+uWithdraw.withdraw_address+'</td>'
                        +'<td>'+uWithdraw.withdraw_tag+'</td>'
                        +'<td>'+uWithdraw.withdraw_txid+'</td>'
                        +'<td><span class="d-none">'+uWithdraw.withdraw_time+'</span>'+new Date(uWithdraw.withdraw_time*1000).toLocaleString()+'</td>'
                        +'</tr>';
            });
            $('#userWithdrawVeri').html(withdrawveri);
            $('#userWithdrawTable').DataTable({
                "order": [[ 3, "asc" ],[ 7, "desc" ]],

                responsive: {
                    details: {
                        renderer: function ( api, rowIdx, columns ) {
                            var data = $.map( columns, function ( col, i ) {
                                return col.hidden ?
                                    '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                        '<td>'+col.title+':'+'</td> '+
                                        '<td>'+col.data+'</td>'+
                                    '</tr>' :
                                    '';
                            } ).join('');
                        
                            return data ?
                                $('<table/>').append( data ) :
                                false;
                        }
                    }
                }
            });
        });
    }, 2000);

    setTimeout(() => {
        //user Activity
        socket.emit('userAdminActivity',data);
        socket.on('userAdminActivity', function (uActivity1){
                $('#userActivityTable').DataTable().destroy();
                var activityveri='';
                $.each(uActivity1.data,function(index,uActivity){
                activityveri+=  '<tr>'
                        +'<td>'+uActivity.act_email+'</td>'
                        +'<td>'+uActivity.act_ip+'</td>'
                        +'<td>'+uActivity.act_title+'</td>'
                        +'<td><span class="d-none">'+uActivity.act_date+'</span>'+new Date(uActivity.act_date*1000).toLocaleString()+'</td>'
                        +'<td>'+uActivity.act_browser+'</td>'
                        +'</tr>';
            });
            $('#userActivityVeri').html(activityveri);
            $('#userActivityTable').DataTable({
                "order": [[ 3, "desc" ]],
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    { "width": "40%" },
                  ],
                responsive: {
                    details: {
                        renderer: function ( api, rowIdx, columns ) {
                            var data = $.map( columns, function ( col, i ) {
                                return col.hidden ?
                                    '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                        '<td>'+col.title+':'+'</td> '+
                                        '<td>'+col.data+'</td>'+
                                    '</tr>' :
                                    '';
                            } ).join('');
                        
                            return data ?
                                $('<table/>').append( data ) :
                                false;
                        }
                    }
                }
            });
        });
    }, 2000);

    setTimeout(() => {
        //user Result
        $.post( customJS.serviceURL + "user/userStatusKontrol", {
            email:useremail,userid:userid
        }) 
        .done(function(data) {
            data = jQuery.parseJSON( data );
            var tradeAlisVeri = 0;
            var tradeSatisVeri = 0;
            var tradeAlisKVeri = 0;
            var tradeSatisKVeri = 0;
            var userWalletVeri2 = 0;
            var depositVeri = 0;
            var withdrawVeri = 0;
            var alisVeri = 0;
            var satisVeri = 0;
            var faucetVeri = 0;
            $.each(data,function(index,userStatus){
                //console.log(userStatus);
                
                $.each(userStatus.tradeAlis,function(index,userStatus1){tradeAlisVeri+='<tr><td>'+userStatus1._id+'</td><td>'+userStatus1.amount.toFixed(8)+'</td></tr>';});
                $('#tradeAlisVeri').html(tradeAlisVeri);
                $.each(userStatus.tradeSatis,function(index,userStatus2){tradeSatisVeri+='<tr><td>'+userStatus2._id+'</td><td>'+userStatus2.amount.toFixed(8)+'</td></tr>';});
                $('#tradeSatisVeri').html(tradeSatisVeri);

                $.each(userStatus.tradeAlisK,function(index,userStatus15){tradeAlisKVeri+='<tr><td>'+userStatus15._id+'</td><td>'+userStatus15.amount.toFixed(8)+'</td></tr>';});
                $('#tradeAlisKVeri').html(tradeAlisKVeri);
                $.each(userStatus.tradeSatisK,function(index,userStatus16){tradeSatisKVeri+='<tr><td>'+userStatus16._id+'</td><td>'+userStatus16.amount.toFixed(8)+'</td></tr>';});
                $('#tradeSatisKVeri').html(tradeSatisKVeri);

                $.each(userStatus.userWallet,function(index,userStatus3){userWalletVeri2+='<tr><td>'+userStatus3._id+'</td><td>'+userStatus3.amount.toFixed(8)+'</td><td id="'+userStatus3._id+'">0</td></tr>';});
                $('#userWalletVeri2').html(userWalletVeri2);
                $.each(userStatus.userDep,function(index,userStatus4){depositVeri+='<tr><td>'+userStatus4._id+'</td><td>'+userStatus4.amount.toFixed(8)+'</td></tr>';});
                $('#depositVeri').html(depositVeri);
                $.each(userStatus.userWith,function(index,userStatus5){withdrawVeri+='<tr><td>'+userStatus5._id+'</td><td>'+userStatus5.amount.toFixed(8)+'</td></tr>';});
                $('#withdrawVeri').html(withdrawVeri);
                $.each(userStatus.userAlis,function(index,userStatus6){alisVeri+='<tr><td>'+userStatus6._id+'</td><td>'+userStatus6.amount.toFixed(8)+'</td></tr>';});
                $('#alisVeri').html(alisVeri);
                $.each(userStatus.userSatis,function(index,userStatus7){satisVeri+='<tr><td>'+userStatus7._id+'</td><td>'+userStatus7.amount.toFixed(8)+'</td></tr>';});
                $('#satisVeri').html(satisVeri);
                $.each(userStatus.userFaucet,function(index,userStatus20){faucetVeri+='<tr><td>'+userStatus20._id+'</td><td>'+userStatus20.amount.toFixed(8)+'</td></tr>';});
                $('#userFaucet').html(faucetVeri);
                $.each(userStatus.userWallet,function(index,userStatus8){
                        //bu kullanıcının cüzdanındaki bakiye. Sonuçtan çıkarılacak
                    $.each(userStatus.userWallet,function(index,userStatus17){
                        if(userStatus8._id==userStatus17._id){$("#"+userStatus8._id).html((parseFloat($("#"+userStatus8._id).html())-userStatus17.amount).toFixed(8));}                    
                    });
                        //bu miktar kullanıcının alış işlemi yaptığında ödediği from coin. Sonuçtan çıkarılacak
                    $.each(userStatus.tradeAlis,function(index,userStatus9){
                        if(userStatus8._id==userStatus9._id){$("#"+userStatus8._id).html((parseFloat($("#"+userStatus8._id).html())-userStatus9.amount).toFixed(8));}                    
                    });
                        //bu kullanıcının sattığı miktar. Sonuçtan çıkarılacak
                    $.each(userStatus.tradeSatis,function(index,userStatus10){
                        if(userStatus8._id==userStatus10._id){$("#"+userStatus8._id).html((parseFloat($("#"+userStatus8._id).html())-userStatus10.amount).toFixed(8));}                    
                    });
                        //bu kullanıcının aldığı miktar. Sonuca eklenecek
                    $.each(userStatus.tradeAlisK,function(index,userStatus18){
                        if(userStatus8._id==userStatus18._id){$("#"+userStatus8._id).html((parseFloat($("#"+userStatus8._id).html())+userStatus18.amount).toFixed(8));}                    
                    });
                        //bu kullanıcının satış işleminde kazandığı from coin. Sonuca eklenecek
                    $.each(userStatus.tradeSatisK,function(index,userStatus19){
                        if(userStatus8._id==userStatus19._id){$("#"+userStatus8._id).html((parseFloat($("#"+userStatus8._id).html())+userStatus19.amount).toFixed(8));}                    
                    });
                        //bu kullanıcının açık alış emri. Sonuçtan çıkarılacak
                    $.each(userStatus.userAlis,function(index,userStatus11){
                        if(userStatus8._id==userStatus11._id){$("#"+userStatus8._id).html((parseFloat($("#"+userStatus8._id).html())-userStatus11.amount).toFixed(8));}                    
                    });
                        //bu kullanıcının açık satış emri. Sonuçtan çıkarılacak.
                    $.each(userStatus.userSatis,function(index,userStatus12){
                        if(userStatus8._id==userStatus12._id){$("#"+userStatus8._id).html((parseFloat($("#"+userStatus8._id).html())-userStatus12.amount).toFixed(8));}                    
                    });
                        //bu kullanıcının depozitosu. Sonuca eklenecek
                    $.each(userStatus.userDep,function(index,userStatus13){
                        if(userStatus8._id==userStatus13._id){$("#"+userStatus8._id).html((parseFloat($("#"+userStatus8._id).html())+userStatus13.amount).toFixed(8));}                    
                    });
                        //bu kullanıcının faucet. Sonuca eklenecek
                    $.each(userStatus.userFaucet,function(index,userStatus15){
                        if(userStatus8._id==userStatus15._id){$("#"+userStatus8._id).html((parseFloat($("#"+userStatus8._id).html())+userStatus15.amount).toFixed(8));}                    
                    });
                        //bu kullanıcının withdraw işlemi. Sonuçtan çıkarılacak
                    $.each(userStatus.userWith,function(index,userStatus14){
                        if(userStatus8._id==userStatus14._id){$("#"+userStatus8._id).html((parseFloat($("#"+userStatus8._id).html())-(userStatus14.amount+userStatus14.withCom)).toFixed(8));}                    
                    });
                });
            });
        });
    }, 3000);
    };
}
