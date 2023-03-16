<?php include "include/header.php"; ?>
<div class="main-content-inner-2" >
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Data Table Default</h4>
                    <nav class="float-left" aria-label="...">
                        <ul class="pagination pg-color-border" id="depositSayfalama">
                            <li class="page-item active" ><a class="page-link" href="#" onclick="customJS.wallet.tabloLimit(100,'userVeri')">100</a></li>
                            <li class="page-item" ><a class="page-link" href="#" onclick="customJS.wallet.tabloLimit(500,'userVeri')">500</a></li>
                            <li class="page-item" ><a class="page-link" href="#" onclick="customJS.wallet.tabloLimit(2000,'userVeri')">2000</a></li>
                            <li class="page-item" ><a class="page-link" href="#" onclick="customJS.wallet.tabloLimit(5000,'userVeri')">5000</a></li>
                            <li class="page-item" ><a class="page-link" href="#" onclick="customJS.wallet.tabloLimit('','userVeri')">All</a></li>
                        </ul>
                    </nav>
                    <div class="input-group mb-3 mt-1 col-12 col-lg-3 float-left">                        
                        <input type="text" class="form-control font-size-13" id="userSearch"  placeholder="Single Search">
                        <div class="input-group-append">
                            <span class="input-group-text bg-light font-size-13" id="basic-addon2"><a href="#" onclick="customJS.users.userSearch()">Search</a></span>
                        </div>
                    </div>
                    <div class="data-tables">
                        <table id="userDataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th>User Email</th>
                                    <th>Exchange Status</th>
                                    <th>Wallet Status</th>
                                    <th>Login Status</th>
                                    <th>Mail Confirm</th>
                                    <th>Ip Whitelist</th>
                                    <th class="wb-150">Created Date</th>
                                    <th>Free Trade</th>
                                    <th>#ID</th>
                                </tr>
                            </thead>
                            <tbody id="userVeri">
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
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
        <?php include "user/user_detail.php"; ?>
    </div>
</div>     
<?php include "include/footer.php"; ?>