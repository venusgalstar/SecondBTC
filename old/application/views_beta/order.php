<?php include "include/header.php"; ?>

<div class="container">

    <div class="row mt-5">

        <div class="col-6">
            <h2 class="font-size-17"><?php echo lang("openorders"); ?></h2>
        </div>

    </div>

    <div class="col-12">

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

                    <tbody id="myOrderBook">

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="row mt-5">

        <div class="col-6">
            <h2 class="font-size-17"><?php echo lang("mytradehistory"); ?></h2>
        </div>

    </div>

    <div class="col-12">

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

                    <tbody id="MYTradingHistory">

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<?php include "include/footer.php"; ?>



<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>