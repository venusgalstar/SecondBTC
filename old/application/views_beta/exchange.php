<?php include "include/header.php"; ?>
<link rel="stylesheet" href="<?= base_url('assets/home/css/custom.css?v=' . time()); ?>" defer />
<!-- Container başlangıç -->

<script src="<?php echo base_url(); ?>assets/home/js/chart/charting_library/charting_library.min.js?vs=<?php echo rand(100, 200); ?>"></script>

<script src="<?php echo base_url(); ?>assets/home/js/chart/datafeeds/udf/dist/polyfills.js?vs=<?php echo rand(100, 200); ?>"></script>

<script src="<?php echo base_url(); ?>assets/home/js/chart/datafeeds/udf/dist/bundle.js?vs=<?php echo rand(100, 200); ?>"></script>

<script src="<?php echo base_url(); ?>assets/home/js/amcharts/core.js?v=<?php echo time(); ?>"></script>

<script src="<?php echo base_url(); ?>assets/home/js/amcharts/charts.js?v=<?php echo time(); ?>"></script>

<script src="<?php echo base_url(); ?>assets/home/js/amcharts/animated.js?v=<?php echo time(); ?>"></script>

<script src="<?php echo base_url(); ?>assets/home/js/charts.js?v=<?php echo time(); ?>"></script>



<style>
    iframe {

        height: 540px !important;

    }
</style>



<script type="text/javascript">
    function getParameterByName(name) {

        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");

        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),

            results = regex.exec(location.search);

        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));

    }



    function initOnReady() {

        var widget = window.tvWidget = new TradingView.widget({

            // debug: true, // uncomment this line to see Library errors and warnings in the console

            fullscreen: true,

            symbol: '<?php echo $toWallet{
                            0}['wallet_short']; ?>/<?php echo $fromWallet{
                                                        0}['wallet_short']; ?>',

            interval: '60',

            container_id: "tv_chart_container",



            //  BEWARE: no trailing slash is expected in feed URL

            datafeed: new Datafeeds.UDFCompatibleDatafeed("<?php echo base_url(); ?>charts"),

            library_path: "/assets/home/js/chart/charting_library/",

            locale: getParameterByName('lang') || "<?php echo $this->input->cookie("dil"); ?>",



            disabled_features: ["use_localstorage_for_settings", "timeframes_toolbar", "header_symbol_search", "study_templates"],

            enabled_features: [""],

            charts_storage_url: 'https://saveload.tradingview.com',

            charts_storage_api_version: "1.1",

            client_id: 'tradingview.com',

            user_id: 'public_user_id',

            theme: 'dark',

            timezone: "Turkey/Istanbul",

            overrides: {

                "paneProperties.background": "#06090c",

                "paneProperties.vertGridProperties.color": "#131722",

                "paneProperties.horzGridProperties.color": "#131722",

                "symbolWatermarkProperties.transparency": 90,

                "scalesProperties.textColor": "#AAA",



            }





        });

        widget.onChartReady(function() {

            widget.chart().createStudy(

                    'Moving Average',

                    false,

                    false,

                    [7],

                    {
                        'plot.color.0': '#dc3545'
                    }



                ),

                widget.chart().createStudy(

                    'Moving Average',

                    false,

                    false,

                    [12],



                    {
                        'plot.color.0': '#01ff72'
                    }

                )





        });



    };



    window.addEventListener('DOMContentLoaded', initOnReady, false);
</script>

<style type="text/css">
    .dataTables_scrollBody {

        max-height: 535px !important;

    }

    @media (max-width: 990px) {

        .dataTables_scrollBody {

            max-height: 135px !important;

        }

    }
</style>

<div class="container-fluid pr-gen text-white pl-gen">

    <div class="row ortabolum">

        <?php include "include/sidebarR.php"; ?>



        <div class="col-xl-10 col-lg-9 col-md-12 mt-1">

            <div class="row ustgrafik">

                <div class="col-3 mt-2">

                    <table>

                        <thead>

                        </thead>

                        <tbody>

                            <tr>

                                <td rowspan="2"><img src="<?php echo base_url(); ?>assets/home/images/logo/<?php echo $toWallet{
                                                                                                                0}['wallet_logo']; ?>" alt="<?php echo $toWallet{
                                                                                                                                                0}['wallet_name']; ?>" width="30" height="30" srcset=""></td>

                                <td class="pl-2"><?php echo $toWallet{
                                                        0}['wallet_short']; ?>/<?php echo $fromWallet{
                                                                                    0}['wallet_short']; ?></td>

                                <td></td>

                            </tr>

                            <tr>

                                <td class="pl-2"><?php echo $toWallet{
                                                        0}['wallet_name']; ?></td>

                            </tr>

                        </tbody>

                    </table>

                </div>

                <div class="col-9 mt-2">

                    <table class="ust-information">

                        <thead>

                            <tr>

                                <th><?php echo lang("lastprice"); ?></th>

                                <th><?php echo lang("change"); ?></th>

                                <th><?php echo lang("24vol"); ?></th>

                                <th><span class="d-none d-xl-block"><?php echo lang("24high"); ?></span></th>

                                <th class="d-none d-xl-block"><span class="d-none d-xl-block"><?php echo lang("24low"); ?></span></th>



                            </tr>

                        </thead>

                        <tbody>

                            <tr>

                                <td id="lastPriceUst">-</td>

                                <td id="renkChange"><span id="change">-</span>%</td>

                                <td id="24hvol">-</td>

                                <td><span class="d-none d-xl-block" id="24hHigh">-</span></td>

                                <td class="d-none d-xl-block"><span class="d-none d-xl-block" id="24hLow">-</span></td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="row">



                <div class="col-xl-9 col-lg-8 col-md-12 mt-1">

                    <div class="col-md-12 bg-dark mt-2 pr-0 pl-0" style="height:540px">

                        <div id="tv_chart_container" style="height:540px !important"></div>

                    </div>

                    <div class="col-md-12 mt-2" style="height:auto">



                    </div>

                    <?php include "exchange/exchangeForm.php"; ?>

                </div>

                <?php include "include/sidebarL.php"; ?>

            </div>

        </div>

    </div>

    <div class="row pb-3">

        <div class="col-12"> <?php include "exchange/myorder.php"; ?></div>



        <div class="col-md-6 col-lg-6 col-xl-3 pt-5">

            <table class="table-responsive">

                <thead>

                    <tr>
                        <th class="d-block"><?php echo lang("name"); ?>: </th>
                        <td><?php echo $toWallet{
                                0}["wallet_name"]; ?></td>
                    </tr>

                    <tr>
                        <th class="d-block"><?php echo lang("short"); ?>: </th>
                        <td><?php echo $toWallet{
                                0}["wallet_short"]; ?></td>
                    </tr>

                    <tr>
                        <th class="d-block"><?php echo lang("website"); ?>: </th>
                        <td><a href="<?php echo $toWalletInfo{
                                            0}["wallet_info_website"]; ?>" target="_blank"><?php echo $toWalletInfo{
                                                                                                0}["wallet_info_website"]; ?></a></td>
                    </tr>

                    <tr>
                        <th class="d-block"><?php echo lang("explorer"); ?>: </th>
                        <td><a href="<?php echo $toWalletInfo{
                                            0}["wallet_info_explorer"]; ?>" target="_blank"><?php echo $toWalletInfo{
                                                                                                0}["wallet_info_explorer"]; ?></a></td>
                    </tr>

                    <tr>
                        <th class="d-block ws-100"><?php echo lang("cmclink"); ?>: </th>
                        <td><a href="<?php echo $toWalletInfo{
                                            0}["wallet_info_cmc"]; ?>" target="_blank"><?php echo $toWalletInfo{
                                                                                            0}["wallet_info_cmc"]; ?></a></td>
                    </tr>

                    <tr>
                        <th class="d-block"><?php echo lang("system"); ?>: </th>
                        <td class="text-capitalize"><?php echo $toWallet{
                                                        0}["wallet_system"]; ?></td>
                    </tr>

                    <?php if ($toWallet{
                        0}["wallet_system"] == "token") { ?>

                        <tr>
                            <th class="d-block">Token Contract: </th>
                            <td><a href="https://etherscan.io/token/<?php echo $toWallet{
                                                                        0}["wallet_cont"]; ?>" target="_blank"><?php echo $toWallet{
                                                                                                                    0}["wallet_cont"]; ?></td>
                        </tr>

                        <tr>
                            <th class="d-block">Token Decimal: </th>
                            <td><?php echo strlen($toWallet{
                                    0}["wallet_dec"]) - 1; ?></td>
                        </tr>

                    <?php } ?>

                    <tr>
                        <th class="d-block"><?php echo lang("maxsup"); ?>: </th>
                        <td><?php echo $toWalletInfo{
                                0}["wallet_info_maxsub"]; ?> <?php echo $toWallet{
                                                                    0}["wallet_short"]; ?></td>
                    </tr>

                    <tr>
                        <th class="d-block"><?php echo lang("social"); ?>: </th>
                        <td><a href="<?php echo $toWalletInfo{
                                            0}["wallet_info_social"]; ?>" target="_blank"><?php echo $toWalletInfo{
                                                                                                0}["wallet_info_social"]; ?></a></td>
                    </tr>

                    <tr>
                        <th class="d-block"><?php echo lang("chats"); ?>: </th>
                        <td><a href="<?php echo $toWalletInfo{
                                            0}["wallet_info_chat"]; ?>" target="_blank"><?php echo $toWalletInfo{
                                                                                            0}["wallet_info_chat"]; ?></a></td>
                    </tr>

                </thead>

                <tbody>



                </tbody>

            </table>

        </div>

        <div class="col-md-6 col-lg-6 col-xl-6 pt-1">

            <div class="col-12"><span class="text-uppercase">
                    <h2 class="font-size-16 text-center mt-3"><?php echo lang("whatis"); ?> <?php echo strtoupper($toWallet{
                                                                                                0}["wallet_name"]); ?>?</h2>
                </span></div>

            <span>

                <?php echo $toWalletInfo{
                    0}["wallet_info"]; ?>

            </span>

        </div>

        <div class="col-md-12 col-lg-12 col-xl-3 pt-5">

            <span class="badge badge-primary"><?php echo $toWallet{
                                                    0}["wallet_short"]; ?></span>

            <span class="badge badge-primary"><?php echo $toWallet{
                                                    0}["wallet_name"]; ?></td></span>

            <span class="badge badge-primary">BUY <?php echo $toWallet{
                                                        0}["wallet_short"]; ?></span>

            <span class="badge badge-primary">SELL <?php echo $toWallet{
                                                        0}["wallet_short"]; ?></span>

            <span class="badge badge-primary"><?php echo $toWallet{
                                                    0}["wallet_short"]; ?> AL</span>

            <span class="badge badge-primary"><?php echo $toWallet{
                                                    0}["wallet_short"]; ?> SAT</span>

            <span class="badge badge-primary"><?php echo $toWallet{
                                                    0}["wallet_short"]; ?> Nedir?</span>

            <span class="badge badge-primary"><?php echo $toWallet{
                                                    0}["wallet_short"]; ?> Türkiye</span>

            <span class="badge badge-primary"><?php echo $toWallet{
                                                    0}["wallet_name"]; ?> Al</td></span>

            <span class="badge badge-primary"><?php echo $toWallet{
                                                    0}["wallet_name"]; ?> Sat</td></span>

            <span class="badge badge-primary"><?php echo $toWallet{
                                                    0}["wallet_name"]; ?></td> Fiyat</span>

            <span class="badge badge-primary"><?php echo $toWallet{
                                                    0}["wallet_name"]; ?></td> Price</span>

            <span class="badge badge-primary"><?php echo $toWallet{
                                                    0}["wallet_name"]; ?></td> to usd</span>

            <span class="badge badge-primary">What is <?php echo $toWallet{
                                                            0}["wallet_name"]; ?>?</td></span>

        </div>

    </div>

</div>

<input type="hidden" value="<?php echo $fromWallet{
                                0}['wallet_id']; ?>" id="fromID">

<input type="hidden" value="<?php echo $toWallet{
                                0}['wallet_id']; ?>" id="toID">

<input type="hidden" value="<?php echo $fromWallet{
                                0}['wallet_short']; ?>" id="fromShort">

<input type="hidden" value="<?php echo $toWallet{
                                0}['wallet_short']; ?>" id="toShort">

<input type="hidden" value="<?php echo $fromWallet{
                                0}['wallet_buy_com']; ?>" id="buycommission">

<input type="hidden" value="<?php echo $fromWallet{
                                0}['wallet_sell_com']; ?>" id="sellcommission">

<?php include "include/footer.php"; ?>