<?php include "include/header.php" ; ?>
<div class="container-frud ml-5 mr-5">
    <div class="row ">
    <div class="col-6"><h2 class="font-size-16 mt-3"><?php echo lang('faucets'); ?> <?php echo lang('list'); ?> </h2><br>To make a donation, please contact us.</div>
        <div class="col-12">
            <table class="table table-striped" id="faucetpage">
                <thead class="bg-light text-capitalize">
                    <tr>
                    <th scope="col"></th>
                    <th scope="col" class="min-width-120"><?php echo lang('currency'); ?></th>
                    <th scope="col" class="min-width-120 text-center"><?php echo lang(''); ?><?php echo lang('amount'); ?></th>
                    <th scope="col" class="min-width-120 text-center"><?php echo lang(''); ?><?php echo lang('period'); ?></th>
                    <th scope="col" class="min-width-120 text-center"><?php echo lang('status'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($faucetList as $faucetList) {
                        $userLastTime = getUserFaucet($faucetList["wallet_short"],$faucetList["faucet_period"]){0}["faucet_time"]-(time()-$faucetList["faucet_period"]);?>
                    <tr> 
                    <script>
                        startTimer(<?=$userLastTime?>);
                        function startTimer(duration) {
                        var timer = duration, minutes, seconds,hour;
                            setInterval(function () {
                                hour = parseInt(timer / 3600);
                                minutes = parseInt((timer / 60)% 60);
                                seconds = parseInt(timer % 60);
                                var pp = hour+":"+ minutes + ":" + seconds;
                                //console.log(pp);
                                $("#periodTime-<?=$faucetList["wallet_short"]?>").html(pp)

                                if (--timer < 0) {
                                    timer = duration;
                                }
                            }, 1000);
                        }
                    </script>
                        <td></td>
                        <td class=""><?php echo $faucetList["wallet_short"]; ?></td>
                        <td class="text-center"><?php echo Number($faucetList["faucet_amount"],8); echo " ".$faucetList["wallet_short"];?></td>
                        <td class="text-center"><?php echo get_time($faucetList["faucet_period"]); ?></td>
                        <td class="text-center">
                        <?php if(!empty($_SESSION['user_data'][0]['user_id']) && !empty($_SESSION['user_data'][0]['user_email'])){
                            if(getUserFaucet($faucetList["wallet_short"],$faucetList["faucet_period"])==1){ ?>
                            <button class="btn btn-primary btn-sm" onclick="customJS.home.userFaucetConfirm('<?php echo $faucetList['wallet_short'];?>')"><?php echo lang('getfree'); ?> </button>
                            <?php }else{ ?>
                            
                            <span id="periodTime-<?=$faucetList["wallet_short"]?>"></span>
                            <?php }}else{ ?>
                            <a class="btn btn-primary btn-sm" href="/login"><?php echo lang('login'); ?></a>
                            <a class="btn btn-primary btn-sm" href="/register"><?php echo lang('register'); ?></a>
                        </td>
                    </tr>
                    <?php }} ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include "include/footer.php" ; ?>


