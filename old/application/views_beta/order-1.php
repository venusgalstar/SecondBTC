<?php include "include/header.php"; ?>

<div class="container text-white">
    <h1>Orders</h1>
    <div class="sub-header d-flex justify-content-between">
        <div class="market-pairs">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-open-orders-tab" data-toggle="pill" href="#tab1" role="tab" aria-controls="pills-open-orders" aria-selected="true"><?php echo lang("openorders"); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-deposit-history-tab" data-toggle="pill" href="#tab2" role="tab" aria-controls="pills-deposit-history" aria-selected="false"><?php echo lang("mytradehistory"); ?></a>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Export
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Excel</a>
                            <a class="dropdown-item" href="#">CSV</a>
                            <a class="dropdown-item" href="#">PDF</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="tab1">
            <table class="table table-hover table-sm display" id="order-page1">
                <thead>
                    <tr>
                        <th class="text-right" scope="col"><?php echo lang("market"); ?></th>
                        <th class="text-center" scope="col"><?php echo lang("type"); ?></th>
                        <th class="text-right" scope="col"><?php echo lang("price"); ?></th>
                        <th class="text-right" scope="col"><?php echo lang("amount"); ?></th>
                        <th class="text-right" scope="col"><?php echo lang("total"); ?></th>
                        <th class="text-right" scope="col"><?php echo lang("opendate"); ?></th>
                        <th class="text-center" scope="col"><?php echo lang("cancel"); ?></th>
                    </tr>
                </thead>
                <tbody id="myOrderBook"></tbody>
            </table>
        </div>
        <div class="tab-pane fade show" id="tab2">
            <table class="table table-hover table-sm display" id="order-page2">
                <thead>
                    <tr>
                        <th class="text-right" scope="col"><?php echo lang("market"); ?></th>
                        <th class="text-center" scope="col"><?php echo lang("type"); ?></th>
                        <th class="text-right" scope="col"><?php echo lang("price"); ?></th>
                        <th class="text-right" scope="col"><?php echo lang("amount"); ?></th>
                        <th class="text-right" scope="col"><?php echo lang("total"); ?></th>
                        <th class="text-right" scope="col"><?php echo lang("closedate"); ?></th>
                    </tr>
                </thead>
                <tbody id="MYTradingHistory"></tbody>
            </table>
        </div>
    </div>
</div>

<?php include "include/footer.php"; ?>

<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>