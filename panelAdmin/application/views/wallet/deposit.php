<?php include __DIR__ ."/../include/header.php"; ?>

<div class="main-content-inner-2" >
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Deposit Table</h4>
                    <nav class="float-left" aria-label="...">
                        <ul class="pagination pg-color-border" id="depositSayfalama">
                            <li class="page-item active" ><a class="page-link" href="#" onclick="customJS.wallet.tabloLimit(100,'depositVeri')">100</a></li>
                            <li class="page-item" ><a class="page-link" href="#" onclick="customJS.wallet.tabloLimit(500,'depositVeri')">500</a></li>
                            <li class="page-item" ><a class="page-link" href="#" onclick="customJS.wallet.tabloLimit(1000,'depositVeri')">1000</a></li>
                            <li class="page-item" ><a class="page-link" href="#" onclick="customJS.wallet.tabloLimit(5000,'depositVeri')">5000</a></li>
                            <li class="page-item" ><a class="page-link" href="#" onclick="customJS.wallet.tabloLimit(' ','depositVeri')">All</a></li>
                        </ul>
                    </nav>
                    <div class="data-tables">
                        <table id="walletDepositDataTable" class="text-center">
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
                            <tbody id="depositVeri">
                                <tr>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>     
<?php include __DIR__ ."/../include/footer.php"; ?>