<?php include __DIR__ . "/../include/header.php"; ?>
<div class="main-content-inner-2">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Withdraw Table</h4>
                    <nav class="float-left" aria-label="...">
                        <ul class="pagination pg-color-border" id="depositSayfalama">
                            <li class="page-item active"><a class="page-link" href="#" onclick="customJS.wallet.tabloLimit(50,'withdrawVeri')">50</a></li>
                            <li class="page-item"><a class="page-link" href="#" onclick="customJS.wallet.tabloLimit(100,'withdrawVeri')">100</a></li>
                            <li class="page-item"><a class="page-link" href="#" onclick="customJS.wallet.tabloLimit(500,'withdrawVeri')">500</a></li>
                            <li class="page-item"><a class="page-link" href="#" onclick="customJS.wallet.tabloLimit(1000,'withdrawVeri')">1000</a></li>
                            <li class="page-item"><a class="page-link" href="#" onclick="customJS.wallet.tabloLimit('','withdrawVeri')">All</a></li>
                        </ul>
                    </nav>
                    <div class="data-tables">
                      <hr />
                            <table id="mainWithdrawDataTable" class="text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>Short</th>
                                        <th>User Email</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th>Txid</th>
                                        <th class="wb-150">Date</th>
                                        <th>Address</th>
                                        <th>Tag</th>
                                        <th>Contract</th>
                                        <th>#ID</th>
                                        <th>UserID</th>
                                        <th>System</th>
                                    </tr>

                                </thead>
                                <tbody>
<!-- <?=json_encode(array_filter($withdraw, function($with) { 
        return true;//$with['wallet_short'] == 'SBTC';
      })) ?> -->
                                    <?php foreach ($withdraw as $withdraw) {?>
                                    <tr>
                                        <td><?php echo $withdraw["withdraw_wallet_short"]; ?></td>
                                        <td><?php echo str_replace("@secondbtc.com", "", $withdraw["withdraw_user_email"]); ?></td>
                                        <td class="text-right"><?php echo Number($withdraw["withdraw_amount"],8); ?></td>
                                        <td><?php if($withdraw["withdraw_status"]==0){ echo("<span class='badge btn-warning cursor-pointer btn-xs' data-toggle='modal' data-target='#sendModal' onclick='customJS.wallet.walletSendModal(\"$withdraw[withdraw_id]\",\"$withdraw[withdraw_user_email]\",\"$withdraw[withdraw_user_id]\",\"$withdraw[withdraw_address]\",\"$withdraw[withdraw_cont]\",$withdraw[withdraw_tag],\"$withdraw[withdraw_wallet_short]\",$withdraw[withdraw_amount],\"$withdraw[withdraw_txid]\",\"$withdraw[wallet_name]\",\"$withdraw[wallet_dec]\",\"$withdraw[wallet_network]\",$withdraw[wallet_with_com],1)'>Send</span>"); }else{ ?>
<span class="d-none">1</span></i><i class="fa fa-check-circle text-success"></i>
<?php } ?></td>
                                        <td><?php if($withdraw["withdraw_status"] == 0){ echo (
										"<span class='badge btn-danger cursor-pointer btn-xs' data-toggle='modal' data-target='#deleteModal' onclick='customJS.wallet.walletDeleteModal(\"$withdraw[withdraw_id]\",\"$withdraw[withdraw_user_email]\",\"$withdraw[withdraw_user_id]\",\"$withdraw[withdraw_address]\",\"$withdraw[withdraw_cont]\",$withdraw[withdraw_tag],\"$withdraw[withdraw_wallet_short]\",$withdraw[withdraw_amount],2)'>Delete</span>".
                        "<span class='badge btn-info cursor-pointer btn-xs' data-toggle='modal' data-target='#cancelModal' onclick='customJS.wallet.walletCancelModal(\"$withdraw[withdraw_id]\",\"$withdraw[withdraw_user_email]\",\"$withdraw[withdraw_user_id]\",\"$withdraw[withdraw_address]\",\"$withdraw[withdraw_cont]\",$withdraw[withdraw_tag],\"$withdraw[withdraw_wallet_short]\",$withdraw[withdraw_amount],2)'>Cancel</span>"); ?>
<?php }?>
</td>
<td><?=$withdraw['withdraw_txid_link']?></td>
                                        <td class="wb-150"><span class="d-none"><?php echo $withdraw["withdraw_time"]; ?></span><?php echo date("Y-m-d H:i:s",$withdraw["withdraw_time"]); ?></td>
                                        <td><?php echo $withdraw["withdraw_address"]; ?></td>
                                        <td><?php echo $withdraw["withdraw_tag"]; ?></td>
                                        <td><?php echo $withdraw["withdraw_cont"]; ?></td>
                                        <td><?php echo $withdraw["withdraw_id"]; ?></td>
                                        <td><?php echo $withdraw["withdraw_user_id"]; ?></td>
                                        <td><?php echo $withdraw["withdraw_system"]; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="sendModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send Modal</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="alert alert-danger alert-dismissible collapse mb-0" id="againAlert" role="alert">
                <strong>Important!</strong> This withdrawal is complete! It will be sent again. Do you confirm?
            </div>
            <div class="modal-body">
                <form id="submitFormData">
                    <!--Google Key :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" autofocus="autofocus" id="sendKey" class="form-control" placeholder="Google Key">
                    </div>
                    -->User ID :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="senduserid" id="senduserid" readonly="readonly" ondblclick="customJS.wallet.doubleClick(this.id)" class="form-control" placeholder="Address">
                    </div>User Email :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="senduseremail" id="senduseremail" readonly="readonly" ondblclick="customJS.wallet.doubleClick(this.id)" class="form-control" placeholder="Address">
                    </div>Address :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="sendaddress" id="sendaddress" readonly="readonly" ondblclick="customJS.wallet.doubleClick(this.id)" class="form-control" placeholder="Address">
                    </div> Contract :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="sendcont" id="sendcont" readonly="readonly" ondblclick="customJS.wallet.doubleClick(this.id)" class="form-control" placeholder="Contract">
                    </div> Tag :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="sendtag" id="sendtag" readonly="readonly" ondblclick="customJS.wallet.doubleClick(this.id)" class="form-control" placeholder="Tag">
                    </div> Amount :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="sendamount" id="sendamount" readonly="readonly" onclick="customJS.wallet.doubleClick(this.id)" class="form-control" placeholder="Amount">
                        <div class="input-group-append">
                            <span class="input-group-text" name="sendshort" id="sendshort"></span>
                        </div>
                    </div> Fee :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="sendfee" id="sendfee" readonly="readonly" onclick="customJS.wallet.doubleClick(this.id)" class="form-control" placeholder="Fee">
                        <div class="input-group-append">
                            <span class="input-group-text" name="sendfee" id="sendfee"></span>
                        </div>
                    </div> Total :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="sendtotal" id="sendtotal" readonly="readonly" onclick="customJS.wallet.doubleClick(this.id)" class="form-control" placeholder="Total">
                        <div class="input-group-append">
                            <span class="input-group-text" name="sendtotal" id="sendtotal"></span>
                        </div>
                    </div> TxID :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="sendtxid" id="sendtxid" readonly="readonly" onclick="customJS.wallet.doubleClick(this.id)" class="form-control" placeholder="TxID">
                        <input type="hidden" name="sendid" id="sendid">
                        <input type="hidden" name="sendoption" id="sendoption">
                        <input type="hidden" name="sendwallet" id="sendWallet">
                        <input type="hidden" name="senddecimals" id="sendDecimals">
                        <input type="hidden" name="sendNetwork" id="sendNetwork">
                        <input type="hidden" id="say123" value="<?php echo yetki($_SESSION['user_data_admin'][0]['admin_email']); ?>">
                    </div>
                    <small class="text-secondary">
                        If you leave it blank, it will be sent from the wallet. If you sent it manually, type TxID.
                    </small>
                </form>
            </div>
            <div class="modal-footer mt-3">
                <span id="balanceMetamask"></span>

                <button type="button" class="btn btn-warning" data-metamask="modal" onclick="customJS.wallet.depositMetamask()" type="button" id="depositButton">send funds with metamask</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="sendButton" onclick="customJS.wallet.registerWithdraw()" class="btn btn-primary">Send</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="cancelModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancel Modal</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="alert alert-danger alert-dismissible collapse mb-0" id="cancelAlert" role="alert">
                <strong>Important!</strong> Withdraw operation will be canceled! The balance will be refunded! Do you confirm?
            </div>
            <div class="modal-body">
                <form id="submitFormData">
                    Google Key :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" autofocus="autofocus" id="cancelKey" class="form-control" placeholder="Google Key">
                    </div>User ID :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="canceluserid" id="canceluserid" readonly="readonly" ondblclick="customJS.wallet.doubleClick(this.id)" class="form-control" placeholder="Address">
                    </div>User Email :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="canceluseremail" id="canceluseremail" readonly="readonly" ondblclick="customJS.wallet.doubleClick(this.id)" class="form-control" placeholder="Address">
                    </div>Address :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="canceladdress" id="canceladdress" readonly="readonly" ondblclick="customJS.wallet.doubleClick(this.id)" class="form-control" placeholder="Address">
                    </div> Contract :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="cancelcont" id="cancelcont" readonly="readonly" ondblclick="customJS.wallet.doubleClick(this.id)" class="form-control" placeholder="Contract">
                    </div> Tag :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="canceltag" id="canceltag" readonly="readonly" ondblclick="customJS.wallet.doubleClick(this.id)" class="form-control" placeholder="Tag">
                    </div> Amount :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="cancelamount" id="cancelamount" readonly="readonly" ondblclick="customJS.wallet.doubleClick(this.id)" class="form-control" placeholder="Amount">
                        <div class="input-group-append">
                            <span class="input-group-text" name="cancelshort" id="cancelshort"></span>
                        </div>
                    </div> Explanation :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="canceltxid" id="canceltxid" class="form-control" placeholder="Explanation">
                        <input type="hidden" name="cancelid" id="cancelid">
                        <input type="hidden" name="canceloption" id="canceloption">
                    </div>
                    <small class="text-secondary">
                        Enter a description for the cancellation.
                    </small>
                </form>
            </div>
            <div class="modal-footer mt-3">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="cancelButton" onclick="customJS.wallet.withdrawCancelTransactions()" class="btn btn-primary">Cancel</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Modal</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="alert alert-danger alert-dismissible collapse mb-0" id="deleteAlert" role="alert">
                <strong>Important!</strong> This withdraw will be deleted! The balance will not be refunded! Do you confirm?
            </div>
            <div class="modal-body">
                <form id="submitFormData">
                    Google Key :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" autofocus="autofocus" id="deleteKey" class="form-control" placeholder="Google Key">
                    </div>User Email :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="deleteuseremail" id="deleteuseremail" readonly="readonly" ondblclick="customJS.wallet.doubleClick(this.id)" class="form-control" placeholder="Address">
                    </div>UserID :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="deleteuserid" id="deleteuserid" readonly="readonly" ondblclick="customJS.wallet.doubleClick(this.id)" class="form-control" placeholder="Address">
                    </div>Amount :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="deleteamount" id="deleteamount" readonly="readonly" ondblclick="customJS.wallet.doubleClick(this.id)" class="form-control" placeholder="Amount">
                        <div class="input-group-append">
                            <span class="input-group-text" name="deleteshort" id="deleteshort"></span>
                        </div>
                    </div> Explanation :
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="deletetxid" id="deletetxid" class="form-control" placeholder="Explanation">
                        <input type="hidden" name="deleteid" id="deleteid">
                    </div>
                    <small class="text-secondary">
                        Enter a description to delete.
                    </small>
                </form>
            </div>
            <div class="modal-footer mt-3">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="deleteButton" onclick="customJS.wallet.withdrawDeleteTransactions()" class="btn btn-primary">Delete</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="resultModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Result Modal</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-2 input-group-sm" id="resultTxid"></div>
                <div class="input-group mb-2 input-group-sm" id="resultError"></div>
            </div>
            <div class="modal-footer mt-3">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="window.location.reload();" >Close</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="urlw" value="<?php echo siteSetting()["site_wallet_server"]; ?>">
<?php include __DIR__ . "/../include/footer.php"; ?>
