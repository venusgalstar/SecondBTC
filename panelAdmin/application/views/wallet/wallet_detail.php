<?php if (yetki($_SESSION['user_data_admin'][0]['admin_email']) < 5) {
    $disabled = "disabled";
} else {
    $disabled = "";
} ?>
<div class="col-12 mt-5" id="walletInfoScrool">
    <div class="text-center collapse" id="loader111" style="background: #fff;"><img src="<?php echo base_url(); ?>assetsAdmin/images/loading.gif"></div>
    <div class="collapse" id="walletInfo">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Wallet Main Setting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="fiat-tab" data-toggle="tab" href="#fiat" role="tab" aria-controls="fiat" aria-selected="false">Banka Ayarları</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Wallet Info Setting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="market-tab" data-toggle="tab" href="#market" role="tab" aria-controls="market" aria-selected="false">Market Setting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="deposit-tab" data-toggle="tab" href="#deposit" onclick="customJS.wallet.walletSingleDepositWithdraw(1)" role="tab" aria-controls="deposit" aria-selected="false">Wallet Deposit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="withdraw-tab" data-toggle="tab" href="#withdraw" onclick="customJS.wallet.walletSingleDepositWithdraw(2)" role="tab" aria-controls="withdraw" aria-selected="false">Wallet Withdraw</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="result-tab" data-toggle="tab" href="#result" role="tab" aria-controls="result" aria-selected="false">Wallet Result</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="walletUser-tab" data-toggle="tab" href="#walletUser" role="tab" aria-controls="walletUser" aria-selected="false">User Balance</a>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="form-group">
                            <div class="row mt-3">
                                <div class="col-12 col-lg-3">
                                    <label for="short">Wallet Short</label>
                                    <input type="text" disabled="disabled" class="form-control form-control-sm" id="wallet_short" placeholder="Please enter data..">
                                    <input type="hidden" id="hideshort" value="">
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="name">Wallet Name</label>
                                    <div class="input-group-append">
                                        <input type="text" <?php echo $disabled; ?> class="form-control form-control-sm border-right-0" id="wallet_name">
                                        <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdate('wallet_name',1)" id="">Save</button>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="balance">Balance</label>
                                    <input type="text" disabled="disabled" class="form-control form-control-sm" id="wallet_balance" placeholder="Please enter data..">
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="system">Wallet System</label>
                                    <select <?php echo $disabled; ?> id="wallet_system" onChange="customJS.wallet.walletUpdate(this.id,1,5)" class="custom-select custom-select-sm">
                                        <option value="token">TOKEN</option>
                                        <option value="coin">COIN</option>
                                        <option value="eth">ETH</option>
                                        <option value="ark">ARK</option>
                                        <option value="tron">TRON</option>
                                        <option value="monero">MONERO</option>
                                        <option value="xrp">XRP</option>
                                        <option value="note">NOTE</option>
                                        <option value="fiat">FIAT</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 col-lg-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" <?php echo $disabled; ?> onclick="customJS.wallet.walletUpdate(this.id,3,4)" class="custom-control-input" id="wallet_dep_status">
                                        <label class="custom-control-label" for="wallet_dep_status">Deposit
                                            Status</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" <?php echo $disabled; ?> onclick="customJS.wallet.walletUpdate(this.id,3,4)" class="custom-control-input" id="wallet_with_status">
                                        <label class="custom-control-label" for="wallet_with_status">Withdraw
                                            Status</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" <?php echo $disabled; ?> onclick="customJS.wallet.walletUpdate(this.id,3,4)" class="custom-control-input" id="wallet_ex_status">
                                        <label class="custom-control-label" for="wallet_ex_status">Exchange
                                            Status</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" <?php echo $disabled; ?> onclick="customJS.wallet.walletUpdate(this.id,3,4)" class="custom-control-input" id="wallet_status">
                                        <label class="custom-control-label" for="wallet_status">Wallet Status</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 col-lg-3">
                                    <label for="wallet_buy_com">Trade Commission<small>(Only available for
                                            pairs.)</small></label>
                                    <div class="input-group-append">
                                        %<input type="text" <?php echo $disabled; ?> class="form-control form-control-sm border-right-0" id="wallet_buy_com">
                                        <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdate('wallet_buy_com',2)">Save</button>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="wallet_with_com">Withdraw Commission</label>
                                    <div class="input-group-append">
                                        <input type="text" <?php echo $disabled; ?> class="form-control form-control-sm border-right-0" id="wallet_with_com" placeholder="Please enter data..">
                                        <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdate('wallet_with_com',2)">Save</button>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="wallet_dep_com">Deposit Commission</label>
                                    <div class="input-group-append">
                                        <input type="text" <?php echo $disabled; ?> class="form-control form-control-sm border-right-0" id="wallet_dep_com" placeholder="Please enter data..">
                                        <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdate('wallet_dep_com',2)">Save</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 col-lg-3">
                                    <label for="wallet_min_dep">Minimum Deposit</label>
                                    <div class="input-group-append">
                                        <input type="text" <?php echo $disabled; ?> class="form-control form-control-sm border-right-0" id="wallet_min_dep" placeholder="Please enter data..">
                                        <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdate('wallet_min_dep',2)">Save</button>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="wallet_max_dep">Maximum Deposit</label>
                                    <div class="input-group-append">
                                        <input type="text" <?php echo $disabled; ?> class="form-control form-control-sm border-right-0" id="wallet_max_dep" placeholder="Please enter data..">
                                        <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdate('wallet_max_dep',2)">Save</button>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="wallet_min_with">Minimum Withdraw</label>
                                    <div class="input-group-append">
                                        <input type="text" <?php echo $disabled; ?> class="form-control form-control-sm border-right-0" id="wallet_min_with" placeholder="Please enter data..">
                                        <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdate('wallet_min_with',2)">Save</button>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="wallet_max_with">Maximum Withdraw</label>
                                    <div class="input-group-append">
                                        <input type="text" <?php echo $disabled; ?> class="form-control form-control-sm border-right-0" id="wallet_max_with" placeholder="Please enter data..">
                                        <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdate('wallet_max_with',2)">Save</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 col-lg-3">
                                    <label for="wallet_conf">Comfirm Number</label>
                                    <div class="input-group-append">
                                        <input type="text" <?php echo $disabled; ?> class="form-control form-control-sm border-right-0" id="wallet_conf" placeholder="Please enter data..">
                                        <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdate('wallet_conf',3)">Save</button>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="wallet_min_bid">Minimum Bid</label>
                                    <div class="input-group-append">
                                        <input type="text" <?php echo $disabled; ?> class="form-control form-control-sm border-right-0" id="wallet_min_bid" placeholder="Please enter data..">
                                        <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdate('wallet_min_bid',2)">Save</button>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="wallet_min_unit">Minimum Unit</label>
                                    <div class="input-group-append">
                                        <input type="text" <?php echo $disabled; ?> class="form-control form-control-sm border-right-0" id="wallet_min_unit" placeholder="Please enter data..">
                                        <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdate('wallet_min_unit',2)">Save</button>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="wallet_min_total">Minimum Total</label>
                                    <div class="input-group-append">
                                        <input type="text" <?php echo $disabled; ?> class="form-control form-control-sm border-right-0" id="wallet_min_total" placeholder="Please enter data..">
                                        <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdate('wallet_min_total',2)">Save</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 col-lg-3">
                                    <label for="wallet_tag_system">Wallet Tag System</label>
                                    <select <?php echo $disabled; ?> id="wallet_tag_system" onChange="customJS.wallet.walletUpdate(this.id,3,5)" class="custom-select custom-select-sm">
                                        <option value="1">YES</option>
                                        <option value="0">NO</option>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="wallet_dec">Wallet Decimal</label>
                                    <div class="input-group-append">
                                        <input type="text" <?php echo $disabled; ?> class="form-control form-control-sm border-right-0" id="wallet_dec" placeholder="Please enter data..">
                                        <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdate('wallet_dec',3)">Save</button>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="wallet_cont">Wallet Contract</label>
                                    <div class="input-group-append">
                                        <input type="text" <?php echo $disabled; ?> class="form-control form-control-sm border-right-0" id="wallet_cont" placeholder="Please enter data..">
                                        <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdate('wallet_cont',1)">Save</button>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="wallet_main_pairs">Wallet Main Pairs</label>
                                    <select <?php echo $disabled; ?> id="wallet_main_pairs" onChange="customJS.wallet.walletUpdate(this.id,3,5)" class="custom-select custom-select-sm">
                                        <option value="0">No Main Pair</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">ALTS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <?php if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 10) { ?>
                                    <div class="col-12 col-lg-3">
                                        <label for="wallet_server_username">Server Username</label>
                                        <div class="input-group-append">
                                            <input type="text" <?php echo $disabled; ?> class="form-control form-control-sm border-right-0" id="wallet_server_username" placeholder="Please enter data..">
                                            <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdate('wallet_server_username',1)">Save</button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <label for="wallet_server_pass">Server Password</label>
                                        <div class="input-group-append">
                                            <input type="password" <?php echo $disabled; ?> class="form-control form-control-sm border-right-0" id="wallet_server_pass" placeholder="Please enter data..">
                                            <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdate('wallet_server_pass',1)">Save</button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <label for="wallet_server_port">Server Port</label>
                                        <div class="input-group-append">
                                            <input type="text" <?php echo $disabled; ?> class="form-control form-control-sm border-right-0" id="wallet_server_port" placeholder="Please enter data..">
                                            <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdate('wallet_server_port',1)">Save</button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <label for="wallet_server_port">Wallet Password</label>
                                        <div class="input-group-append">
                                            <input type="password" ondblclick="customJS.wallet.walletChangeType(this.id)" <?php echo $disabled; ?> class="form-control form-control-sm border-right-0" id="wallet_password" placeholder="Please enter data..">
                                            <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdate('wallet_password',1)">Save</button>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="col-12 col-lg-3">
                                    <label for="wallet_id">Wallet ID</label>
                                    <input type="text" disabled="disabled" class="form-control form-control-sm" id="wallet_id" placeholder="Please enter data..">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 col-lg-6 mt-3">
                                    <div class="input-group">
                                        <img class="ml-5" id="walletlogo" src="" width="60" alt="">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 mt-3">
                                    <form class="form-horizontal" id="submitWallet">
                                        <input type="hidden" id="hideshort2" name="title" class="form-control" placeholder="Title">
                                        <div class="form-group">
                                            <input type="file" name="filename">
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-success" id="btn_upload" type="submit">Image
                                                Upload</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="fiat" role="tabpanel" aria-labelledby="fiat-tab">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Data Table Default</h4>
                                <div class="data-tables">
                                    <table id="walletBankaTable" class="text-center" style="width:100%">
                                        <thead class="bg-light text-capitalize">
                                            <tr>
                                                <th>#ID</th>
                                                <th>Banka Adı</th>
                                                <th>Banka Iban</th>
                                                <th>Banka Hesap</th>
                                                <th>Banka Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="walletBanka">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="form-group">
                            <div class="row mt-3">
                                <div class="col-12 col-lg-4">
                                    <label for="wallet_info_website">Wallet info Website</label>
                                    <div class="input-group-append">
                                        <input type="text" <?php echo $disabled; ?> class="form-control form-control-sm" id="wallet_info_website" placeholder="Please enter data..">
                                        <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdateInfo('wallet_info_website',1)">Save</button>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="wallet_info_chat">Wallet info chat</label>
                                    <div class="input-group-append">
                                        <input type="text" <?php echo $disabled; ?> class="form-control form-control-sm" id="wallet_info_chat" placeholder="Please enter data..">
                                        <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdateInfo('wallet_info_chat',1)">Save</button>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="wallet_info_social">Wallet info social</label>
                                    <div class="input-group-append">
                                        <input type="text" <?php echo $disabled; ?> class="form-control form-control-sm" id="wallet_info_social" placeholder="Please enter data..">
                                        <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdateInfo('wallet_info_social',1)">Save</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 col-lg-4">
                                    <label for="wallet_info_explorer">Wallet Info Explorer</label>
                                    <div class="input-group-append">
                                        <input type="text" <?php echo $disabled; ?> class="form-control form-control-sm" id="wallet_info_explorer" placeholder="Please enter data..">
                                        <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdateInfo('wallet_info_explorer',1)">Save</button>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="wallet_info_cmc">Wallet Info CMC</label>
                                    <div class="input-group-append">
                                        <input type="text" <?php echo $disabled; ?> class="form-control form-control-sm" id="wallet_info_cmc" placeholder="Please enter data..">
                                        <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdateInfo('wallet_info_cmc',1)">Save</button>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="wallet_info_maxsub">Wallet info Sub</label>
                                    <div class="input-group-append">
                                        <input type="text" <?php echo $disabled; ?> class="form-control form-control-sm" id="wallet_info_maxsub" placeholder="Please enter data..">
                                        <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.walletUpdateInfo('wallet_info_maxsub',1)">Save</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-12 col-lg-12 mt-5">
                                    <textarea name="wallet_info" id="wallet_info" rows="10" cols="80"> </textarea>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 col-lg-3">
                                    <button class="btn btn-primary" onclick="customJS.wallet.walletUpdateWalletInfo()" type="button">Save Wallet Info</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="market" role="tabpanel" aria-labelledby="market-tab">
                        <div class="row mt-3">
                            <div class="col-12 col-lg-3" id="marketsWalletPageNew">
                            </div>
                            <div class="col-12 col-lg-9" >
                                <div class="row" id="marketsWalletDecimal">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="deposit" role="tabpanel" aria-labelledby="deposit-tab">
                        <div class="row mt-3">
                            <div class="col-12">
                                <table id="walletDepositDataTableWalletPage" class="text-center">
                                    <thead class="bg-light text-capitalize">
                                        <tr>
                                            <th>Short</th>
                                            <th>Amount</th>
                                            <th>User Email</th>
                                            <th>Confirmation</th>
                                            <th>Txid</th>
                                            <th class="wb-150">Date</th>
                                            <th>System</th>
                                            <th>Address</th>
                                            <th>Tag</th>
                                            <th>UserID</th>
                                            <th>DepositID</th>
                                            <th>Delete</th>

                                        </tr>
                                    </thead>
                                    <tbody id="depositVeriWalletPage">
                                        <tr>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="withdraw" role="tabpanel" aria-labelledby="withdraw-tab">
                        <div class="row mt-3">
                            <div class="col-12">
                                <table id="walletWithdrawDataTableWalletPage" class="text-center">
                                    <thead class="bg-light text-capitalize">
                                        <tr>
                                            <th>Short</th>
                                            <th>User Email</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th class="wb-150">Date</th>
                                            <th>Address</th>
                                            <th>Tag</th>
                                            <th>Contract</th>
                                            <th>Txid</th>
                                            <th>#ID</th>
                                            <th>UserID</th>
                                            <th>System</th>
                                        </tr>
                                    </thead>
                                    <tbody id="withdrawVeriWalletPage">
                                        <tr>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                            <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right"></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="result" role="tabpanel" aria-labelledby="result-tab">
                        <div class="row mt-3">
                            <div class="col-12">
                                <table id="walletResultTable" class="table w-100">
                                    <thead>
                                        <tr>
                                            <th>Deposit Total</th>
                                            <th>Withdraw Total</th>
                                            <th>Open Orders Total</th>
                                            <th>User Balance Total</th>
                                            <th>Wallet Balance</th>
                                            <th>Result</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td id="deposit_result">0</td>
                                            <td id="withdraw_result">0</td>
                                            <td id="openorders_result">0</td>
                                            <td id="userwallet_result">0</td>
                                            <td id="wallet_balance_result">0</td>
                                            <td id="wallet_result">0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="walletUser" role="tabpanel" aria-labelledby="walletUser-tab">
                        <div class="row mt-3">
                            <div class="col-12">
                                <table id="walletUserTable" class="table w-100">
                                    <thead>
                                        <tr>
                                            <th>User Email</th>
                                            <th>User ID</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody id="walletUserBalance">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>