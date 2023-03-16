<?php include('include/header.php')  ?>
<link rel="stylesheet" href="<?= base_url('assets/home/css/custom.css?v=' . time()); ?>" defer />
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

    .dataTables_filter {
        display: none;
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
            symbol: '<?php echo $toWallet[0]['wallet_short']; ?>/<?php echo $fromWallet[0]['wallet_short']; ?>',
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

            overrides: {

                "paneProperties.background": "#171c24",

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

    @media(max-width: 768px) {
        .ust-information {
            display: block;
            width: 100%;
            overflow-x: auto;
        }
    }

    @media (max-width: 990px) {

        .dataTables_scrollBody {

            max-height: 135px !important;

        }

    }
</style>
<div class="container-fluid h-100 ">
    <div class="row ustgrafik mb-2">
        <div class="col-3 mt-2">
            <table>
                <thead></thead>
                <tbody>
                    <tr>
                        <td rowspan="2"><img src="<?php echo base_url(); ?>assets/home/images/logo/<?php echo $toWallet[0]['wallet_logo']; ?>" alt="<?php echo $toWallet[0]['wallet_name']; ?>" width="30" height="30" srcset=""></td>
                        <td class="pl-2"><?php echo $toWallet[0]['wallet_short']; ?>/<?php echo $fromWallet[0]['wallet_short']; ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="pl-2"><?php echo $toWallet[0]['wallet_name']; ?></td>
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
                        <th><?php echo lang("24high"); ?></th>
                        <th><?php echo lang("24low"); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="lastPriceUst">-</td>
                        <td id="renkChange"><span id="change">-</span>%</td>
                        <td id="24hvol">-</td>
                        <td><span id="24hHigh">-</span></td>
                        <td><span id="24hLow">-</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- <div class="pair-info mb-4 d-flex">
        <div class="pair-image">
            <img class="img-fluid mr-4" src="<?= base_url('assets/home/img/rari.png') ?>">
        </div>
        <div class="pair mr-4">
            <p class="small">Pair</p>
            <h4>RARI/ETH</h4>
        </div>
        <div class="last-price mr-4">
            <p class="small">Last price</p>
            <h5 class="price-down">0.003 ETH</h5>
        </div>
        <div class="price-change mr-4">
            <p class="small">24h change</p>
            <h5 class="price-down">-4.09%</h5>
        </div>
        <div class="volume mr-4">
            <p class="small">Volume</p>
            <h5>924.7031 ETH</h5>
        </div>
    </div> -->
    <div class="row mb-4">
        <div class="col-sm-12 col-md-12 col-lg-6 mb-2">
            <div id="tv_chart_container" style="height:540px !important"></div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-3 mb-2">
            <div class="card" style="height: 100%;">
                <div class="card-body p-1">
                    <?php include('exchange/openOrders.php')  ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-3 mb-2">
            <div class="card" style="height: 100%;">
                <div class="card-body">
                    <?php include "exchange/buy-sell.php"; ?>
                </div>
            </div>
        </div>

    </div>

    <div class="row mb-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <?php include('include/open-orders.php')  ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- <div class="card">
                <div class="card-body">
                </div>
            </div> -->
        </div>
    </div>
    <div class="py-2"></div>
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
<input type="hidden" value="<?php echo $fromWallet{0}['wallet_sell_com']; ?>" id="sellcommission">

<input type="hidden" value="8" id="pdec">
<input type="hidden" value="8" id="adec">
<input type="hidden" value="8" id="tdec">

<?php include('include/footer.php')  ?>