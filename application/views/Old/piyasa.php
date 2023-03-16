<?php include "include/header.php"; ?>
<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>assets/home/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>assets/home/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>assets/home/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/home/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/home/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/home/js/custom.js?v=<?php echo time(); ?>"></script>
<script src="<?php echo base_url(); ?>assets/home/js/main.js?v=1"></script>
<script src="<?php echo base_url(); ?>assets/home/js/toast.js?v=1"></script>

<!--<meta http-equiv="refresh" content="5; URL=https://bitexlive.com/piyasa" />-->
<div class="container"><?php echo "eeeeee " . $_SESSION["deneme"] . "bbbb" . $_SESSION["deneme2"] . " -- trade" . $_SESSION["fiyatvar"]; ?>
    <div class="row mt-5">
        <div class="col-12 text-center mb-2">
            <h2>Başlık</h2>
        </div>
        <div class="col-12">
            <div class="col-12">
                <?php echo 15000 * 0.05; ?>

                Açık Bot : <?= $botList["bot_from_short"] ?>_<?= $botList["bot_to_short"] ?><br>
                <script>
                    var zaman3 = Math.floor(Math.random() * 3000) + 1500;
                    var zaman4 = Math.floor(Math.random() * 3000) + 1500;
                    var tzaman = Math.floor(Math.random() * 6000);
                    console.log("buyOther : " + zaman3);
                    console.log("sellOther : " + zaman4);
                    console.log("Trade : " + tzaman);
                    var list = '';
                    setTimeout(() => {
                        $.post(customJS.serviceURL + "piyasa/piyasaBuy", {
                                fromShort: '<?= $botList["bot_from_short"] ?>',
                                toShort: '<?= $botList["bot_to_short"] ?>',
                                fromID: <?= $botList["bot_from_id"] ?>,
                                toID: <?= $botList["bot_to_id"] ?>,
                                apiSite: '<?= $botList["bot_api"] ?>',
                                userEmail: '<?= $botList["bot_userEmail"] ?>',
                                botVolume: '<?= $botList["bot_volume"] ?>',
                                userId: '<?= $botList["bot_userId"] ?>',
                                buyPrice: '<?= $botList["bot_buyPrice"] ?>',
                                refCoin1: '<?= $botList["ref_coin_1"] ?>',
                                refCoin2: '<?= $botList["ref_coin_2"] ?>',
                                botAction: '<?= $botList["bot_action_type"] ?>',

                            })
                            .done(function(data) {
                                //console.log(data);
                                $('#bottestTable').DataTable().destroy();
                                var date = new Date().getTime();
                                list += '<tr>' +
                                    '<td><?= $botList["bot_from_short"] ?>_<?= $botList["bot_to_short"] ?></td>' +
                                    '<td>piyasaBuy</td>' +
                                    '<td>' + data + '</td>' +
                                    '<td>' + date + '</td>' +
                                    '</tr>';
                                $('#testBot').html(list);
                                $('#bottestTable').dataTable({
                                    scrollY: 300,
                                    paging: false,
                                    "info": false,
                                    "lengthChange": false,
                                    "autoWidth": true,
                                    "searching": false,
                                    "order": [
                                        [3, "desc"]
                                    ],

                                });
                                if (data == "OK") {
                                    socket.emit('exchangeBuy', [<?= $botList["bot_from_id"] ?>, <?= $botList["bot_to_id"] ?>]);
                                }
                            })
                    }, 100);
                    setTimeout(() => {
                        $.post(customJS.serviceURL + "piyasa/piyasaSell", {
                                fromShort: '<?= $botList["bot_from_short"] ?>',
                                toShort: '<?= $botList["bot_to_short"] ?>',
                                fromID: <?= $botList["bot_from_id"] ?>,
                                toID: <?= $botList["bot_to_id"] ?>,
                                apiSite: '<?= $botList["bot_api"] ?>',
                                userEmail: '<?= $botList["bot_userEmail"] ?>',
                                botVolume: '<?= $botList["bot_volume"] ?>',
                                userId: '<?= $botList["bot_userId"] ?>',
                                sellPrice: '<?= $botList["bot_sellPrice"] ?>',
                                refCoin1: '<?= $botList["ref_coin_1"] ?>',
                                refCoin2: '<?= $botList["ref_coin_2"] ?>',
                                botAction: '<?= $botList["bot_action_type"] ?>',
                            })
                            .done(function(data) {
                                //console.log(data);
                                $('#bottestTable').DataTable().destroy();
                                var date = new Date().getTime();
                                list += '<tr>' +
                                    '<td><?= $botList["bot_from_short"] ?>_<?= $botList["bot_to_short"] ?></td>' +
                                    '<td>piyasaSell</td>' +
                                    '<td>' + data + '</td>' +
                                    '<td>' + date + '</td>' +
                                    '</tr>';
                                $('#testBot').html(list);
                                $('#bottestTable').dataTable({
                                    scrollY: 300,
                                    paging: false,
                                    "info": false,
                                    "lengthChange": false,
                                    "autoWidth": true,
                                    "searching": false,
                                    "order": [
                                        [3, "desc"]
                                    ],

                                });
                                if (data == "OK") {
                                    socket.emit('exchangeSell', [<?= $botList["bot_from_id"] ?>, <?= $botList["bot_to_id"] ?>]);
                                }
                            })
                    }, 100);

                    setTimeout(() => {
                        otherBuy();
                    }, zaman3);

                    setTimeout(() => {
                        otherSell();
                    }, zaman4);

                    setTimeout(() => {

                        $.post(customJS.serviceURL + "piyasa/piyasaTrade", {
                                fromShort: '<?= $botList["bot_from_short"] ?>',
                                toShort: '<?= $botList["bot_to_short"] ?>',
                                fromID: <?= $botList["bot_from_id"] ?>,
                                toID: <?= $botList["bot_to_id"] ?>,
                                apiSite: '<?= $botList["bot_api"] ?>',
                                userEmail: '<?= $botList["bot_userEmail"] ?>',
                                userId: '<?= $botList["bot_userId"] ?>',
                                botVolume: '<?= $botList["bot_volume"] ?>',
                                buyPrice: '<?= $botList["bot_buyPrice"] ?>',
                                sellPrice: '<?= $botList["bot_sellPrice"] ?>',
                                refCoin1: '<?= $botList["ref_coin_1"] ?>',
                                refCoin2: '<?= $botList["ref_coin_2"] ?>',
                                botAction: '<?= $botList["bot_action_type"] ?>',
                            })
                            .done(function(data) {
                                $('#bottestTable').DataTable().destroy();
                                var date = new Date().getTime();
                                list += '<tr>' +
                                    '<td><?= $botList["bot_from_short"] ?>_<?= $botList["bot_to_short"] ?></td>' +
                                    '<td>piyasaTrade</td>' +
                                    '<td>' + data + '</td>' +
                                    '<td>' + date + '</td>' +
                                    '</tr>';
                                $('#testBot').html(list);
                                $('#bottestTable').dataTable({
                                    scrollY: 300,
                                    paging: false,
                                    "info": false,
                                    "lengthChange": false,
                                    "autoWidth": true,
                                    "searching": false,
                                    "order": [
                                        [3, "desc"]
                                    ],

                                });
                                socket.emit('marketveridetail', [<?= $botList["bot_from_id"] ?>, <?= $botList["bot_to_id"] ?>]);
                                socket.emit('tradeData', [<?= $botList["bot_from_id"] ?>, <?= $botList["bot_to_id"] ?>]);
                            })
                    }, tzaman);

                    function otherBuy() {
                        $.post(customJS.serviceURL + "piyasa/piyasaBuyOther", {
                                fromShort: '<?= $botList["bot_from_short"] ?>',
                                toShort: '<?= $botList["bot_to_short"] ?>',
                                fromID: <?= $botList["bot_from_id"] ?>,
                                toID: <?= $botList["bot_to_id"] ?>,
                                apiSite: '<?= $botList["bot_api"] ?>',
                                userEmail: '<?= $botList["bot_userEmail"] ?>',
                                botVolume: '<?= $botList["bot_volume"] ?>',
                                userId: '<?= $botList["bot_userId"] ?>',
                                buyPrice: '<?= $botList["bot_buyPrice"] ?>',
                                refCoin1: '<?= $botList["ref_coin_1"] ?>',
                                refCoin2: '<?= $botList["ref_coin_2"] ?>',
                                botAction: '<?= $botList["bot_action_type"] ?>',
                            })
                            .done(function(data) {
                                //console.log(data);
                                $('#bottestTable').DataTable().destroy();
                                var date = new Date().getTime();
                                list += '<tr>' +
                                    '<td><?= $botList["bot_from_short"] ?>_<?= $botList["bot_to_short"] ?></td>' +
                                    '<td>piyasaBuyOther</td>' +
                                    '<td>' + data + '</td>' +
                                    '<td>' + date + '</td>' +
                                    '</tr>';
                                $('#testBot').html(list);
                                $('#bottestTable').dataTable({
                                    scrollY: 300,
                                    paging: false,
                                    "info": false,
                                    "lengthChange": false,
                                    "autoWidth": true,
                                    "searching": false,
                                    "order": [
                                        [3, "desc"]
                                    ],

                                });
                                if (data == "OK") {
                                    socket.emit('exchangeBuy', [<?= $botList["bot_from_id"] ?>, <?= $botList["bot_to_id"] ?>]);
                                }
                            })
                    }

                    function otherSell() {
                        $.post(customJS.serviceURL + "piyasa/piyasaSellOther", {
                                fromShort: '<?= $botList["bot_from_short"] ?>',
                                toShort: '<?= $botList["bot_to_short"] ?>',
                                fromID: <?= $botList["bot_from_id"] ?>,
                                toID: <?= $botList["bot_to_id"] ?>,
                                apiSite: '<?= $botList["bot_api"] ?>',
                                userEmail: '<?= $botList["bot_userEmail"] ?>',
                                botVolume: '<?= $botList["bot_volume"] ?>',
                                userId: '<?= $botList["bot_userId"] ?>',
                                sellPrice: '<?= $botList["bot_sellPrice"] ?>',
                                refCoin1: '<?= $botList["ref_coin_1"] ?>',
                                refCoin2: '<?= $botList["ref_coin_2"] ?>',
                                botAction: '<?= $botList["bot_action_type"] ?>',
                            })
                            .done(function(data) {
                                //console.log(data);
                                $('#bottestTable').DataTable().destroy();
                                var date = new Date().getTime();
                                list += '<tr>' +
                                    '<td><?= $botList["bot_from_short"] ?>_<?= $botList["bot_to_short"] ?></td>' +
                                    '<td>piyasaSellOther</td>' +
                                    '<td>' + data + '</td>' +
                                    '<td>' + date + '</td>' +
                                    '</tr>';
                                $('#testBot').html(list);
                                $('#bottestTable').dataTable({
                                    scrollY: 300,
                                    paging: false,
                                    "info": false,
                                    "lengthChange": false,
                                    "autoWidth": true,
                                    "searching": false,
                                    "order": [
                                        [3, "desc"]
                                    ],

                                });
                                if (data == "OK") {
                                    socket.emit('exchangeSell', [<?= $botList["bot_from_id"] ?>, <?= $botList["bot_to_id"] ?>]);
                                }
                            })
                    }
                </script>
                <table class="table" id="bottestTable">
                    <thead>
                        <tr>
                            <td>Market</td>
                            <td>Function</td>
                            <td>Durum</td>
                            <td>Time</td>
                        </tr>
                    </thead>
                    <tbody id="testBot">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $('#bottestTable').dataTable({
        scrollY: 300,
        paging: false,
        "info": false,
        "lengthChange": false,
        "autoWidth": true,
        "searching": false,
        "order": [
            [3, "desc"]
        ],
    });
</script>