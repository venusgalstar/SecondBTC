        <!-- sidebar menu area start -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="index.html"><img src="/assets/home/images/logo.png" alt="logo"></a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <li class="active"><a href="<?php echo base_url(); ?>home"><i class="ti-dashboard"></i><span>Dashboard</span></a></li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-wallet"></i><span>Wallets</span></a>
                                <ul class="collapse">
                                    <li><a href="<?php echo base_url(); ?>wallet">Wallet List</a></li>
                                    <li><a href="<?php echo base_url(); ?>wallet/addwallet">Wallet Add</a></li>
                                    <li><a href="<?php echo base_url(); ?>wallet/walletsetting">Wallet All Setting</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-exchange-vertical"></i><span>Transactions</span></a>
                                <ul class="collapse">
                                    <li><a href="<?php echo base_url(); ?>wallet/deposit">Deposit</a></li>
                                    <li><a href="<?php echo base_url(); ?>wallet/withdraw">Withdraw</a></li>
                                    <li><a href="<?php echo base_url(); ?>wallet/orderbook">Order Book</a></li>
                                    <li><a href="<?php echo base_url(); ?>wallet/tradehistory">Trade History</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-user"></i><span>Users</span></a>
                                <ul class="collapse">
                                    <li><a href="<?php echo base_url(); ?>user">User List</a></li>
                                    <li><a href="<?php echo base_url(); ?>home/addFund">Add Fund</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-money"></i><span>Fiat Setting</span></a>
                                <ul class="collapse">
                                    <li><a href="<?php echo base_url(); ?>fiat">Bank Setting</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-user"></i><span>Admin Setting</span></a>
                                <ul class="collapse">
                                    <li><a href="<?php echo base_url(); ?>admin">Admin List</a></li>
                                    <li><a href="<?php echo base_url(); ?>admin/addAdmin">Add Admin</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>home/sitesetting" aria-expanded="true"><i class="ti-settings"></i><span>WebSite Setting</span></a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-announcement"></i><span>News</span></a>
                                <ul class="collapse">
                                    <li><a href="<?php echo base_url(); ?>home/news">News List</a></li>
                                    <li><a href="<?php echo base_url(); ?>home/newsAdd">Add News</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-support"></i><span>Support</span></a>
                                <ul class="collapse">
                                    <li><a href="<?php echo base_url(); ?>home/support">Support List</a></li>
                                    <li><a href="<?php echo base_url(); ?>home/sendEmail">Send Email</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="ti-user"></i><span>Team</span></a>
                                <ul class="collapse">
                                    <li><a href="<?php echo base_url(); ?>home/team">Team List</a></li>
                                    <li><a href="<?php echo base_url(); ?>home/addTeam">Add Team</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-level-down"></i><span>Faucet</span></a>
                                <ul class="collapse">
                                    <li><a href="<?php echo base_url(); ?>home/faucet">Faucet</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-exchange"></i><span>Bot Setting</span></a>
                                <ul class="collapse">
                                    <li><a href="<?php echo base_url(); ?>bot">Add Market Bot</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-file-text-o"></i><span>Invoice Setting</span></a>
                                <ul class="collapse">
                                    <li><a href="<?php echo base_url(); ?>invoice">Invoice Setting</a></li>
                                    <li><a href="<?php echo base_url(); ?>invoice/invoiceGenerated">Generated Invoices</a></li>
                                    <li><a href="<?php echo base_url(); ?>invoice/invoiceCreate">Create Invoice</a></li>
                                </ul>
                            </li>
                            <li>
                                    <li><a href="<?php echo base_url(); ?>home/logout"><i class="fa fa-sign-out"></i><span>LogOut</span></a></li>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->