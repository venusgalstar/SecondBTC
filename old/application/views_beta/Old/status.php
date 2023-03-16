<?php include "include/header.php" ; ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/home/css/responsive.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/home/css/responsive.jqueryui.min.css">
<style>
    table.dataTable tbody th, table.dataTable tbody td {
        padding: 8px 10px !important;
    }
</style>
<div class="container">
    <div class="row mt-5">
        <div class="col-12"><h2 class="font-size-16 buyukharf"><?php echo lang('tradecom'); ?></h2></div>
        <div class="col-12">
            <table class="table table-striped" id="">
                <thead class="bg-dark text-capitalize">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col" class="min-width-120"><?php echo lang('currency'); ?></th>
                        <th scope="col" class="min-width-120 text-center"><?php echo lang('tradecom'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($walletListCom as $walletListCom) {
                        if($walletListCom['wallet_main_pairs']<=3){ ?>
                            <tr>
                                <td></td>
                                <td class=""><?php echo $walletListCom["wallet_short"]; ?></td>
                                <td class="text-center"><?php echo Number($walletListCom["wallet_buy_com"]-1,5)*100; ?>%</td>
                            </tr>
                        <?php }} ?>
                        <tr>
                            <td></td>
                            <td class="">ALTS</td>
                            <td class="text-center"><?php echo Number($walletListCom["wallet_buy_com"]-1,5)*100; ?>%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="container-frud ml-5 mr-5">
        <div class="row ">
            <div class="col-6"><h2 class="font-size-16"><?php echo lang('wallet'); ?> <?php echo lang('status'); ?> & <?php echo lang('health'); ?></h2></div>
            <div class="col-12">
                <table class="table table-striped" id="statuspage">
                    <thead class="bg-dark text-capitalize">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col" class="min-width-120"><?php echo lang('currency'); ?></th>
                            <th scope="col" class="min-width-120 text-center"><?php echo lang('lastblockdate'); ?></th>
                            <th scope="col" class="min-width-120 text-center"><?php echo lang('lastdeposit'); ?></th>
                            <th scope="col" class="min-width-120 text-center"><?php echo lang('lastwithdrawal'); ?></th>
                            <th scope="col" class="min-width-120 text-center"><?php echo lang('confcount'); ?></th>
                            <th scope="col" class="min-width-120 text-center"><?php echo lang('trading'); ?> <?php echo lang('status'); ?></th>
                            <th scope="col" class="min-width-120 text-center"><?php echo lang('deposit'); ?> <?php echo lang('status'); ?></th>
                            <th scope="col" class="min-width-120 text-center"><?php echo lang('withdraw'); ?> <?php echo lang('status'); ?></th>
                            <th scope="col" class="min-width-120 text-center"><?php echo lang('deposit'); ?> <?php echo lang('commission'); ?></th>
                            <th scope="col" class="min-width-120 text-center"><?php echo lang('withdraw'); ?> <?php echo lang('commission'); ?></th>
                            <th scope="col" class="min-width-120 text-center"><?php echo lang('minimum'); ?> <?php echo lang('deposit'); ?></th>
                            <th scope="col" class="min-width-120 text-center"><?php echo lang('maximum'); ?> <?php echo lang('deposit'); ?></th>
                            <th scope="col" class="min-width-120 text-center"><?php echo lang('minimum'); ?> <?php echo lang('withdraw'); ?></th>
                            <th scope="col" class="min-width-120 text-center"><?php echo lang('maximum'); ?> <?php echo lang('withdraw'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($walletList as $walletList) { 
                         if($walletList["wallet_ex_status"]==1){$durum = '<span class="text-success font-size-13">Online</span>'; }else{$durum = '<span class="text-danger font-size-13">Ofline</span>';}
                         if($walletList["wallet_dep_status"]==1){$durum2 = '<span class="text-success font-size-13">Online</span>'; }else{$durum2 = '<span class="text-danger font-size-13">Ofline</span>';}
                         if($walletList["wallet_with_status"]==1){$durum3 = '<span class="text-success font-size-13">Online</span>'; }else{$durum3 = '<span class="text-danger font-size-13">Ofline</span>';}
                         ?>
                         <tr>
                            <td></td>
                            <td class=""><?php echo $walletList["wallet_short"]; ?></td>
                            <td class="text-center"><?php echo @date("Y-m-d H:i:s",$walletList["wallet_status_time"]/1000); ?></td>
                            <td class="text-center"><?php echo @date("Y-m-d H:i:s",statusDeposit($walletList["wallet_short"],1){0}["dep_history_time"]); ?></td>
                            <td class="text-center"><?php echo @date("Y-m-d H:i:s",statusWithdraw($walletList["wallet_short"],1){0}["withdraw_time"]); ?></td>
                            <td class="text-center"><?php echo $walletList["wallet_conf"]; ?></td>
                            <td class="text-center"><?php echo $durum;?></td>
                            <td class="text-center"><?php echo $durum2;?></td>
                            <td class="text-center"><?php echo $durum3;?></td>
                            <td class="text-center"><?php echo $walletList["wallet_dep_com"];?></td>
                            <td class="text-center"><?php echo $walletList["wallet_with_com"];?></td>
                            <td class="text-center"><?php echo $walletList["wallet_min_dep"];?></td>
                            <td class="text-center"><?php if($walletList["wallet_max_dep"]==0){echo "∞";}else{echo $walletList["wallet_max_dep"];};?></td>
                            <td class="text-center"><?php echo $walletList["wallet_min_with"];?></td>
                            <td class="text-center"><?php echo $walletList["wallet_max_with"];?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include "include/footer.php" ; ?>
<script src="<?php echo base_url();?>assets/home/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url();?>assets/home/js/responsive.bootstrap.min.js?v=1"></script>

