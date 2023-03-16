<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>SecondBtc</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Custom font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="vendors/bootstrap-4.5.0/css/bootstrap.min.css">
    <!-- Custom styling -->
    <link id="theme" rel="stylesheet" href="css/dark-theme.css">
    <!-- Favicon -->

  </head>
  <body>
    <?php include('include/navbar.php')  ?>

    <div class="container-fluid">
      <h1>Markets</h1>

      <div class="sub-header d-flex justify-content-between">
        <div class="market-pairs">
          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <!-- <li class="nav-item">
              <a class="nav-link active" id="pills-eth-tab" data-toggle="pill" href="#pills-eth" role="tab" aria-controls="pills-eth" aria-selected="true">ETH</a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" id="pills-usdt-tab" data-toggle="pill" href="#pills-usdt" role="tab" aria-controls="pills-usdt" aria-selected="false">USDT</a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" id="pills-btc-tab" data-toggle="pill" href="#pills-btc" role="tab" aria-controls="pills-btc" aria-selected="false">BTC</a>
            </li> -->
            <!-- <li class="nav-item">
              <a class="nav-link" id="pills-bnb-tab" data-toggle="pill" href="#pills-bnb" role="tab" aria-controls="pills-bnb" aria-selected="false">BNB</a>
            </li> -->
          </ul>

        </div>

        <div>
          <form>
            <div class="form-group">
              <input type="search" class="form-control searchbar" placeholder="Search">
            </div>
          </form>
        </div>
      </div>

      <div class="tab-content" id="pills-tabContent">
        <!-- <div class="tab-pane fade show active" id="pills-eth" role="tabpanel" aria-labelledby="pills-eth-tab">
          <?php include('include/market-table.php')  ?>
        </div> -->
        <div class="tab-pane fade" id="pills-usdt" role="tabpanel" aria-labelledby="pills-usdt-tab">
          <?php include('include/market-table.php')  ?>
        </div>
        <!-- <div class="tab-pane fade" id="pills-btc" role="tabpanel" aria-labelledby="pills-btc-tab">
          <?php include('include/market-table.php')  ?>
        </div> -->
        <!-- <div class="tab-pane fade" id="pills-bnb" role="tabpanel" aria-labelledby="pills-bnb-tab">
          <?php include('include/market-table.php')  ?>
        </div> -->
      </div>

    </div>


    <script src="vendors/bootstrap-4.5.0/js/jquery-3.5.1.min.js"></script>
    <script src="vendors/bootstrap-4.5.0/js/popper.min.js"></script>
    <script src="vendors/bootstrap-4.5.0/js/bootstrap.min.js"></script>
    <script src="js/toggleTheme.js"></script>

  </body>
  </html>
