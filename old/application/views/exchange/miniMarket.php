<?php 
$market = $this->uri->segment(2);
$veri = explode("-", $market); 

if(count($veri) != 2){$pairActive = 1; }else{$pairActive = 1;} 
?>

<nav>
    <div class="nav nav-tabs" id="nav-tab-exchange" role="tablist">
            <?php foreach ($getMarketPairs as $pairs) {
                if($pairs['wallet_main_pairs']==$pairActive){$active = 'active';}else{$active = '';}
                $marketTab = $pairs['wallet_short'];
                if($pairs['wallet_main_pairs']<=3){
            ?>
            <a class="d-none" id="<?php echo $active; ?>"><?php echo $pairs['wallet_main_pairs']; ?></a>
            <a class="nav-item nav-link <?php echo $active; ?>" onclick="myFunction('<?php echo $pairs['wallet_main_pairs']; ?>')" id="nav-btc-tab-exchange" data-toggle="tab" href="<?php echo $pairs['wallet_short']; ?>" role="tab"
            aria-controls="<?php echo $pairs['wallet_short']; ?>" aria-selected="true"><?php echo $pairs['wallet_short']; ?></a>
            <?php }} ?>
    </div>
    <div>
        <div class="input-group">
            <input type="text" class="form-control" id="miniMarketSearch" placeholder="Search..." aria-label="Search" aria-describedby="">
            <div class="input-group-append">
                <span class="input-group-text"><img class="loupe"
                        src="<?php echo base_url();?>assets/home/newtheme/img/loupe.svg"></span>
            </div>
        </div>
    </div>
    <div class="header d-flex marketTable">
        <div class="pair medium">Pair</div>
        <div class="price medium">Price</div>
        <div class="change medium">Change</div>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent-exchange">
    <div class="tab-pane fade show active" id="btc-exchange" role="tabpanel" aria-labelledby="nav-btc-tab-exchange">
        <div class="table-responsive over-y">
            <table id="miniMarket" class="table borderless" style="width:100%">
                <tbody id="market">
                    

                </tbody>
            </table>
        </div>
    </div>
</div>