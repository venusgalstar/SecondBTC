<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="pills-1-tab" data-toggle="pill" href="#pills-1" role="tab" aria-controls="pills-1" aria-selected="true">Open Orders</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pills-2-tab" data-toggle="pill" href="#pills-2" role="tab" aria-controls="pills-2" aria-selected="false">Trading History</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="pills-3-tab" data-toggle="pill" href="#pills-3" role="tab" aria-controls="pills-3" aria-selected="false">All Trades</a>
    </li>
</ul>
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
        <div class="row" id="myTabContent">
            <div class="col-12 table-responsive">
                <table class="table table-hover text-white table-sm display" id="order-page1">
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
        </div>
    </div>
    <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">
        <div class="row" id="myTabContent">
            <div class="col-12 table-responsive">
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
    <div class="tab-pane fade" id="pills-3" role="tabpanel" aria-labelledby="pills-3-tab">
        <div class="tradingTable ml-2">
            <table class="table table-sm table-hover table-dark table-responsive">
                <thead>
                    <tr>
                        <th class="text-right pr-2" scope="col"><?php echo lang("price"); ?></th>
                        <th class="text-right " scope="col"><?php echo lang("amount"); ?></th>
                        <th class="text-right pr-2" scope="col"><?php echo lang("date"); ?></th>
                    </tr>
                </thead>
                <tbody id="tradeHistory">
                    <tr>
                        <td class="text-right text-danger pr-2">-</td>
                        <td class="text-right ">-</td>
                        <td class="text-right pr-2">-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>