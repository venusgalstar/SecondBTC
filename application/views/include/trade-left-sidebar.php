<?php
$market = $this->uri->segment(2);
$veri = explode("-", $market);
if (count($veri) != 2) {
    $pairActive = 1;
} else {
    $pairActive = 1;
}
?>
<ul class="nav nav-tabs nav-pills" id="myTab" role="tablist">
    <?php
    foreach ($getMarketPairs as $pairs) {
        if ($pairs['wallet_main_pairs'] == $pairActive) {
            $active = 'active';
        } else {
            $active = '';
        }
        $marketTab = $pairs['wallet_short'];
        if ($pairs['wallet_main_pairs'] <= 5) {
    ?>
            <li class="nav-item">
                <a class="d-none" id="<?php echo $active; ?>"><?php echo $pairs['wallet_id']; ?></a>
                <a class="nav-link <?php echo $active; ?>" onclick="myFunction('<?php echo $pairs['wallet_id']; ?>')" data-toggle="tab" href="#<?php echo $pairs['wallet_short']; ?>" role="tab" aria-controls="<?php echo $pairs['wallet_short']; ?>" aria-selected="true"><?php echo $pairs['wallet_short']; ?></a>
            </li>
    <?php
        }
    } ?>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="BTC" role="tabpanel" aria-labelledby="BTC-tab">
        <table class="table table-hover table-sm display marketTable" id="marketEx">
            <thead>
                <tr>
                    <th scope="col"><?php echo lang('pair'); ?></a></th>
                    <th class="text-right" scope="col"><?php echo lang('price'); ?></a></th>
                    <th class="text-right" scope="col"><?php echo lang('change'); ?></a></th>
                    <th class="d-none" scope="col"><?php echo lang('volume'); ?></a></th>
                </tr>
            </thead>
            <tbody id="market"></tbody>
        </table>
    </div>
</div>
<?php include __DIR__ . "/../exchange/tradingHistory.php"; ?>