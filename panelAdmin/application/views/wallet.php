<?php include "include/header.php"; ?>
<div class="main-content-inner-2" >
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Data Table Default</h4>
                    <div class="data-tables">
                        <table id="walletDataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th>#ID</th>
                                    <th>Short</th>
                                    <th>Name</th>
                                    <th>Server</th>
                                    <th>Status</th>
                                    <th>Exchange</th>
                                    <th>Deposit</th>
                                    <th>Withdraw</th>
                                    <th>Balance</th>
                                    <th>System</th>
                                    <th>Comfirm Number</th>
                                    <th>Main Pairs</th>
                                    <th>Deposit Commission</th>
                                    <th>Withdraw Commission</th>
                                    <th>Minimum Deposit</th>
                                    <th>Maximum Deposit</th>
                                    <th>Minimum Withdraw</th>
                                    <th>Maximum Withdraw</th>
                                    <th>Minimum Bid</th>
                                    <th>Minimum Unit</th>
                                    <th>Minimum Total</th>
                                    <th>Wallet Tag System</th>
                                    <th>Wallet Decimal</th>
                                    <th>Wallet Contract</th>
                                    <!--<th>Action</th>-->
                                </tr>
                            </thead>
                            <tbody id="walletVeri">
                                <tr>
                                    <td colspan="20"  class="text-center">
                                            <div class="spinner-border mt-5" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                    </td>                                
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
        <?php include "wallet/wallet_detail.php"; ?>
    </div>
</div>     
<?php include "include/footer.php"; ?>