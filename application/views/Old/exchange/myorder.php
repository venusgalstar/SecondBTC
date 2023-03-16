<?php if(!empty($_SESSION['user_data'][0]['user_email']) && !empty($_SESSION['user_data'][0]['user_id'])){ ?>
<div class="row  mt-4 mb-5">    
    <div class="col-12">
        <ul class="nav nav-tabs" id="myTab2" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#home2" role="tab" aria-controls="home2" aria-selected="true"><?php echo lang("myopenorders");?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="myTradeHistory()" id="profile-tab2" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile2" aria-selected="false"><?php echo lang("mytradehistory");?></a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent2">
            <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab2">
                <table class="table table-hover table-sm" id="myOpenOrders">
                    <thead>
                        <tr>
                        <th class="text-right" scope="col"><?php echo lang("market");?></th>
                        <th class="text-right" scope="col"><?php echo lang("price");?></th>
                        <th class="text-right" scope="col"><?php echo lang("amount");?></th>
                        <th class="text-right" scope="col"><?php echo lang("total");?></th>
                        <th class="text-right" scope="col"><?php echo lang("type");?></th>
                        <th class="text-right" scope="col"><?php echo lang("date");?></th>
                        <th class="d-none"></th>
                        <th class="text-center" scope="col"><?php echo lang("cancel");?></th>
                        </tr>
                    </thead>
                    <tbody id="myOrderBook">
                        
                        
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab2">
                <table class="table table-hover table-sm" id="MYTradingHistory">
                    <thead>
                        <tr>
                        <th class="text-right" scope="col"><?php echo lang("market");?></th>
                        <th class="text-right" scope="col"><?php echo lang("price");?></th>
                        <th class="text-right" scope="col"><?php echo lang("amount");?></th>
                        <th class="text-right" scope="col"><?php echo lang("total");?></th>
                        <th class="text-right" scope="col"><?php echo lang("date");?></th>
                        <th class="d-none"></th>
                        </tr>
                    </thead>
                    <tbody id="mytradeHistory">
                        <tr>
                            <td class="text-right">-</td>
                            <td class="text-right text-danger">-</td>
                            <td class="text-right">-</td>
                            <td class="text-right">-</td>
                            <td class="text-right">-</td>
                            <td class="d-none">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php } ?>