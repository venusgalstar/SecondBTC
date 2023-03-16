<?php   if(yetki($_SESSION['user_data_admin']{0}['admin_email'])<4){$disabled ="disabled";}else{$disabled ="";} ?>
<div class="col-12 mt-5" id="userInfoScrool">
<div class="text-center collapse" id="loader111" style="background: #fff;"><img src="<?php echo base_url(); ?>assetsAdmin/images/loading.gif"></div>
    <div class="collapse" id="userInfo">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">User Main Setting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="userDetailTab-tab" data-toggle="tab" href="#userDetailTab" role="tab" aria-controls="userDetailTab" aria-selected="false">User Detail</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="userWalletTab-tab" data-toggle="tab" href="#userWalletTab" role="tab" aria-controls="userWalletTab" aria-selected="false">User Wallet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="openorders-tab" data-toggle="tab" href="#openorders" role="tab" aria-controls="openorders" aria-selected="false">Open Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tradehistory-tab" data-toggle="tab" href="#tradehistory" role="tab" aria-controls="tradehistory" aria-selected="false">Trade History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="userdeposit-tab" data-toggle="tab" href="#userdeposittab" role="tab" aria-controls="userdeposittab" aria-selected="false">User Deposit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="userwithdraw-tab" data-toggle="tab" href="#userwithdrawtab" role="tab" aria-controls="userwithdrawtab" aria-selected="false">User Withdraw</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="useractivitytab-tab" data-toggle="tab" href="#useractivitytab" role="tab" aria-controls="useractivitytab" aria-selected="false">User Activity</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="userresulttab-tab" data-toggle="tab" href="#userresulttab" role="tab" aria-controls="userresulttab" aria-selected="false">User Result</a>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="form-group">
                            <div class="row mt-3">
                                <div class="col-12 col-lg-4">
                                    <label for="user_id">UserID</label>
                                    <div class="" id="user_id" ></div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="name">User Email</label>
                                    <div class="" id="user_email" ></div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="user_create">Create Date</label>
                                    <div class="" id="user_create" ></div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 col-lg-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" <?php echo $disabled; ?> onclick="customJS.users.userUpdate(this.id,3,4)" class="custom-control-input" id="user_wallet_status">
                                        <label class="custom-control-label" for="user_wallet_status">Wallet Status</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" <?php echo $disabled; ?> onclick="customJS.users.userUpdate(this.id,3,4)" class="custom-control-input" id="user_login_status">
                                        <label class="custom-control-label" for="user_login_status">Login Status</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" <?php echo $disabled; ?> onclick="customJS.users.userUpdate(this.id,3,4)" class="custom-control-input" id="user_ex_status">
                                        <label class="custom-control-label" for="user_ex_status">Exchange Status</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" <?php echo $disabled; ?> onclick="customJS.users.userUpdate(this.id,3,4)" class="custom-control-input" id="user_free_trade">
                                        <label class="custom-control-label" for="user_free_trade">Free Trade</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 col-lg-4">
                                    <label for="user_with_conf">Withdraw Confirm</label>
                                    <select <?php echo $disabled; ?> id="user_with_conf" onChange="customJS.users.userUpdate(this.id,1,5)" class="custom-select custom-select-sm">
                                        <option value="G">GOOGLE</option>
                                        <option value="M">MAIL</option>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="user_login_conf">Login Confirm</label>
                                    <select <?php echo $disabled; ?> id="user_login_conf" onChange="customJS.users.userUpdate(this.id,1,5)" class="custom-select custom-select-sm">
                                        <option value="G">GOOGLE</option>
                                        <option value="M">MAIL</option>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="user_google_conf">Google 2FA</label>
                                    <select <?php echo $disabled; ?> id="user_google_conf" onChange="customJS.users.userUpdate(this.id,3,5)" class="custom-select custom-select-sm">
                                        <option value="0">OFF</option>
                                        <option value="1">ON</option>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 col-lg-4">
                                    <label for="user_ip">IP Whitelist</label>
                                    <div class="" id="user_ip" ></div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="user_referans_code">Reference Code</label>
                                    <div class="" id="user_referans_code" ></div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="user_email_conf">Mail Confirm</label>
                                    <div class="" id="user_email_conf" ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="userDetailTab" role="tabpanel" aria-labelledby="userDetailTab-tab">
                        <div class="form-group">
                            <div class="row mt-3">
                                <div class="col-12 col-lg-3">
                                    <label for="user_email_detail" class="font-weight-bold">User Email : </label>
                                    <div class="" id="user_email_detail" ></div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="user_first_name" class="font-weight-bold">First Name : </label>
                                    <div class="" id="user_first_name" ></div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="user_middle_name" class="font-weight-bold">Middle Name : </label>
                                    <div class="" id="user_middle_name" ></div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="user_last_name" class="font-weight-bold">Last Name : </label>
                                    <div class="" id="user_last_name" ></div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 col-lg-3">
                                    <label for="user_country" class="font-weight-bold">Country : </label>
                                    <div class="" id="user_country" ></div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="user_city" class="font-weight-bold">City : </label>
                                    <div class="" id="user_city" ></div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="user_id_number" class="font-weight-bold">Identification Number : </label>
                                    <div class="" id="user_id_number" ></div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="user_tel" class="font-weight-bold">Phone Number : </label>
                                    <div class="" id="user_tel" ></div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 col-lg-3">
                                    <label for="user_id_detail" class="font-weight-bold">UserID : </label>
                                    <div class="" id="user_id_detail" ></div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="user_dogum" class="font-weight-bold">Date of birth : </label>
                                    <div class="" id="user_dogum" ></div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="user_address" class="font-weight-bold">Address : </label>
                                    <div class="" id="user_address" ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="userWalletTab" role="tabpanel" aria-labelledby="userWalletTab-tab">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Wallet Table</h4>
                                <div class="data-tables">
                                    <table id="userWalletTable" class="text-center" style="width:100%">
                                        <thead class="bg-light text-capitalize">
                                            <tr>
                                                <th>Wallet ID</th>
                                                <th>Wallet Short</th>
                                                <th>Wallet Name</th>
                                                <th>Wallet Balance</th>
                                                <th>Wallet System</th>
                                                <th>Deposit Address</th>
                                                <th>Deposit Tag</th>
                                                <th>Withdraw Address</th>
                                                <th>Withdraw Tag</th>
                                                <th>Deposit Check</th>
                                                <th>Add Deposit</th>
                                                <th>Add Withdraw</th>
                                                <th>Delete Address</th>
                                            </tr>
                                        </thead>
                                        <tbody id="userWalletVeri">
                                            <tr>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="openorders" role="tabpanel" aria-labelledby="openorders-tab">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Orders Table</h4>
                                <div class="data-tables">
                                    <table id="OrdersTable" class="text-center" style="width:100%">
                                        <thead class="bg-light text-capitalize">
                                            <tr>
                                                <th>From Wallet</th>
                                                <th>To Wallet</th>
                                                <th>Type</th>
                                                <th>Bid</th>
                                                <th>Unit</th>
                                                <th>Total</th>
                                                <th>First Unit</th>
                                                <th>First Total</th>
                                                <th>Commission</th>
                                                <th class="wb-150">Created Date</th>
                                                <th>Order ID</th>
                                                <th>User Email</th>
                                            </tr>
                                        </thead>
                                        <tbody id="openOrdersVeri">
                                            <tr>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tradehistory" role="tabpanel" aria-labelledby="tradehistory-tab">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Trade History Table</h4>
                                <div class="data-tables">
                                    <table id="tradeHistory" class="text-center" style="width:100%">
                                        <thead class="bg-light text-capitalize">
                                            <tr>
                                                <th>From Wallet</th>
                                                <th>To Wallet</th>
                                                <th>Type</th>
                                                <th>Bid</th>
                                                <th>Unit</th>
                                                <th>Total</th>
                                                <th>Rol</th>
                                                <th class="wb-150">Trade Date</th>
                                                <th>Trade ID</th>
                                                <th>User Email</th>
                                                <th>To User Email</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tradeHistoryVeri">
                                            <tr>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="userdeposittab" role="tabpanel" aria-labelledby="userdeposit-tab">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Deposit Table</h4>
                                <div class="data-tables">
                                    <table id="userDepositTable" class="text-center" style="width:100%">
                                        <thead class="bg-light text-capitalize">
                                            <tr>
                                                <th>Wallet Short</th>
                                                <th>Amount</th>
                                                <th>Conf</th>
                                                <th>Status</th>
                                                <th>Address</th>
                                                <th>Tag</th>
                                                <th>TxID</th>
                                                <th class="wb-150">Deposit Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="userDepositVeri">
                                            <tr>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="userwithdrawtab" role="tabpanel" aria-labelledby="userwithdraw-tab">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Withdraw Table</h4>
                                <div class="data-tables">
                                    <table id="userWithdrawTable" class="text-center" style="width:100%">
                                        <thead class="bg-light text-capitalize">
                                            <tr>
                                                <th>Wallet Short</th>
                                                <th>Amount</th>
                                                <th>Commission</th>
                                                <th>Status</th>
                                                <th>Address</th>
                                                <th>Tag</th>
                                                <th>TxID</th>
                                                <th class="wb-150">Withdraw Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="userWithdrawVeri">
                                            <tr>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="useractivitytab" role="tabpanel" aria-labelledby="useractivity-tab">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Activity Table Default</h4>
                                <div class="data-tables">
                                    <table id="userActivityTable" class="text-center" style="width:100%">
                                        <thead class="bg-light text-capitalize">
                                            <tr>
                                                <th>User Email</th>
                                                <th>Ip Address</th>
                                                <th>Activity</th>
                                                <th class="wb-150">Date</th>
                                                <th>Browser</th>
                                            </tr>
                                        </thead>
                                        <tbody id="userActivityVeri">
                                            <tr>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="userresulttab" role="tabpanel" aria-labelledby="userresulttab-tab">
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="font-size-15 text-center mb-3">User Wallet & Result</h4>
                                        <div class="data-tables">
                                            <table id="userResultTable" class="text-center table table-sm" style="width:100%">
                                                <thead class="bg-light text-capitalize">
                                                    <tr> <th>Short</th> <th>Amount</th><th>Result</th></tr>
                                                </thead>
                                                <tbody id="userWalletVeri2">
                                                    <tr>
                                                        <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                        <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                        <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="font-size-15 text-center mb-3">User Deposit</h4>
                                        <div class="data-tables">
                                            <table id="userResultTable" class="text-center table table-sm" style="width:100%">
                                                <thead class="bg-light text-capitalize">
                                                    <tr> <th>Short</th> <th>Amount</th></tr>
                                                </thead>
                                                <tbody id="depositVeri">
                                                    <tr>
                                                        <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                        <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="font-size-15 text-center mb-3">User Withdraw</h4>
                                        <div class="data-tables">
                                            <table id="userResultTable" class="text-center table table-sm" style="width:100%">
                                                <thead class="bg-light text-capitalize">
                                                    <tr> <th>Short</th> <th>Amount</th></tr>
                                                </thead>
                                                <tbody id="withdrawVeri">
                                                    <tr>
                                                        <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                        <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="font-size-15 text-center mb-3">Buy Order Payable</h4>
                                        <div class="data-tables">
                                            <table id="userResultTable" class="text-center table table-sm" style="width:100%">
                                                <thead class="bg-light text-capitalize">
                                                    <tr> <th>Short</th> <th>Amount</th></tr>
                                                </thead>
                                                <tbody id="alisVeri">
                                                    <tr>
                                                        <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                        <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="font-size-15 text-center mb-3">Sell Order Payable</h4>
                                        <div class="data-tables">
                                            <table id="userResultTable" class="text-center table table-sm" style="width:100%">
                                                <thead class="bg-light text-capitalize">
                                                    <tr> <th>Short</th> <th>Amount</th></tr>
                                                </thead>
                                                <tbody id="satisVeri">
                                                    <tr>
                                                        <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                        <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="font-size-15 text-center mb-3">Buy Trade Paid</h4>
                                        <div class="data-tables">
                                            <table id="userResultTable" class="text-center table table-sm" style="width:100%">
                                                <thead class="bg-light text-capitalize">
                                                    <tr>
                                                        <th>Short</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tradeAlisVeri">
                                                    <tr>
                                                        <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                        <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="font-size-15 text-center mb-3">Buy Trade Earned</h4>
                                        <div class="data-tables">
                                            <table id="userResultTable" class="text-center table table-sm" style="width:100%">
                                                <thead class="bg-light text-capitalize">
                                                    <tr> <th>Short</th> <th>Amount</th></tr>
                                                </thead>
                                                <tbody id="tradeAlisKVeri">
                                                    <tr>
                                                        <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                        <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="font-size-15 text-center mb-3">Sell Trade Paid</h4>
                                        <div class="data-tables">
                                            <table id="userResultTable" class="text-center table table-sm" style="width:100%">
                                                <thead class="bg-light text-capitalize">
                                                    <tr> <th>Short</th> <th>Amount</th></tr>
                                                </thead>
                                                <tbody id="tradeSatisVeri">
                                                    <tr>
                                                        <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                        <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="font-size-15 text-center mb-3">Sell Trade Earned</h4>
                                        <div class="data-tables">
                                            <table id="userResultTable" class="text-center table table-sm" style="width:100%">
                                                <thead class="bg-light text-capitalize">
                                                    <tr> <th>Short</th> <th>Amount</th></tr>
                                                </thead>
                                                <tbody id="tradeSatisKVeri">
                                                    <tr>
                                                        <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                        <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="font-size-15 text-center mb-3">Faucet Earned</h4>
                                        <div class="data-tables">
                                            <table id="userResultTable" class="text-center table table-sm" style="width:100%">
                                                <thead class="bg-light text-capitalize">
                                                    <tr> <th>Short</th> <th>Amount</th></tr>
                                                </thead>
                                                <tbody id="userFaucet">
                                                    <tr>
                                                        <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                        <td class="text-center"> <div class="spinner-border spinner-border-sm" role="status"></div></td>
                                                    </tr>
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
        </div>
    </div>
</div>

<div class="modal fade" id="addDeposit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Deposit</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body"> 
                <form id="submitFormData"> 
                    Google Key : 
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" autofocus="autofocus" id="depKey"  class="form-control" placeholder="Google Key">
                    </div>
                        <input type="hidden" name="depuserid" id="depuserid" class="form-control">
                        <input type="hidden" name="depuseremail" id="depuseremail" class="form-control">
                        <input type="hidden" name="depaddress" id="depaddress" class="form-control">
                        <input type="hidden" name="depwalletsystem" id="depwalletsystem" class="form-control">
                     Amount : 
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="depamount" id="depamount" class="form-control" placeholder="Amount">
                        <div class="input-group-append">
                            <span class="input-group-text" name="depshort" id="depshort"></span>
                        </div>
                    </div> TxID : 
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="deptxid" id="deptxid" class="form-control" placeholder="TxID">
                    </div>
                    <small class="text-secondary">
                    You can type Txid or description in the Txid section.
                    </small>
                </form>
            </div>
            <div class="modal-footer mt-3">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="sendButton" onclick="customJS.users.userTransactionsInsert(1)" class="btn btn-primary">Send</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addWithdraw">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Withdraw</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body"> 
                <form id="submitFormData"> 
                    Google Key : 
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" autofocus="autofocus" id="withKey"  class="form-control" placeholder="Google Key">
                    </div>
                        <input type="hidden" name="withuserid" id="withuserid" class="form-control">
                        <input type="hidden" name="withuseremail" id="withuseremail" class="form-control">
                        <input type="hidden" name="withwalletid" id="withwalletid" class="form-control">
                        <input type="hidden" name="withwalletsystem" id="withwalletsystem" class="form-control">
                     Amount : 
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="withamount" id="withamount" class="form-control" placeholder="Amount">
                        <div class="input-group-append">
                            <span class="input-group-text" name="withshort" id="withshort"></span>
                        </div>
                    </div>Address : 
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="withaddress" id="withaddress" class="form-control" placeholder="Address">
                    </div> TxID : 
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" name="withtxid" id="withtxid" class="form-control" placeholder="TxID">
                    </div>
                    <small class="text-secondary">
                    You can type Txid or description in the Txid section.
                    </small>
                </form>
            </div>
            <div class="modal-footer mt-3">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="sendButton" onclick="customJS.users.userTransactionsInsert(2)" class="btn btn-primary">Send</button>
            </div>
        </div>
    </div>
</div>
