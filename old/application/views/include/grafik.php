        <script type="text/javascript" src="<?php echo base_url(); ?>assets/home/js/grafik/charting_library/charting_library.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/home/js/grafik/datafeeds/udf/dist/polyfills.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/home/js/grafik/datafeeds/udf/dist/bundle.js"></script>

		<script type="text/javascript">

            function getParameterByName(name) {
                name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                        results = regex.exec(location.search);
                return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
            }

			TradingView.onready(function()
			{
				var widget = window.tvWidget = new TradingView.widget({
					// debug: true, // uncomment this line to see Library errors and warnings in the console
					fullscreen: true,
					symbol: 'AAPL',
					interval: 'D',
					container_id: "tv_chart_container",
					//	BEWARE: no trailing slash is expected in feed URL
					datafeed: new Datafeeds.UDFCompatibleDatafeed("https://demo_feed.tradingview.com"),
					library_path: "<?php echo base_url(); ?>assets/home/js/grafik/charting_library/",
					locale: getParameterByName('lang') || "en",
					//	Regression Trend-related functionality is not implemented yet, so it's hidden for a while
					drawings_access: { type: 'black', tools: [ { name: "Regression Trend" } ] },
					disabled_features: ["use_localstorage_for_settings"],
					enabled_features: ["study_templates"],
					charts_storage_url: 'http://saveload.tradingview.com',
                    charts_storage_api_version: "1.1",
					client_id: 'tradingview.com',
					user_id: 'public_user_id'
				});
			});

			

		</script>
		