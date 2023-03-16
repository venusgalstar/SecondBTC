</div>
<footer class="bg-dark card-footer mt-5 pb-5">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-3">
        <div class="footer-contact-list">
          <ul class="nav mt-5">
            <li class="bg-dark border-0"><img class="alt-link" alt="logo" src="<?php echo base_url(); ?>assets/home/images/logo.png" width="200" height="50">
            <li>
            <li class="font-size-15 text-white nav-item mt-2">Â©<?php echo siteSetting()["site_name"]; ?> <?php echo lang('hak'); ?>
            <li>
          </ul>
        </div>
      </div>
      <div class="col-6 col-lg-2">
        <div class="footer-heading mt-3">
          <h3 class="font-size-23 text-white alt-link"><?php echo lang('aboutus'); ?></h3>
          <ul class="nav flex-column">
            <!--     <li class="nav-item mb-1 font-size-14"><a class="text-white" title="<?php echo lang('aboutus'); ?>" name="<?php echo lang('aboutus'); ?>" alt="<?php echo lang('aboutus'); ?>" href="/team-about-us"><?php echo lang('aboutus'); ?></a></li>-->
            <li class="nav-item mb-1 font-size-14"><a class="text-white" title="<?php echo lang('terms'); ?>" name="<?php echo lang('terms'); ?>" alt="<?php echo lang('terms'); ?>" href="/terms"><?php echo lang('terms'); ?></a></li>
            <li class="nav-item mb-1 font-size-14"><a class="text-white" title="<?php echo lang('privacy'); ?>" name="<?php echo lang('privacy'); ?>" alt="<?php echo lang('privacy'); ?>" href="/privacy"><?php echo lang('privacy'); ?></a></li>
            <li class="nav-item mb-1 font-size-14"><a class="text-white" title="<?php echo lang('announcement'); ?>" name="<?php echo lang('announcement'); ?>" alt="<?php echo lang('announcement'); ?>" href="/news"><?php echo lang('announcement'); ?></a></li>
            <li class="nav-item mb-1 font-size-14"><a class="text-white" title="<?php echo lang('listing'); ?>" name="<?php echo lang('listing'); ?>" alt="<?php echo lang('listing'); ?>" target="_blank" href="<?php echo base_url('listing'); ?>"><?php echo lang('listing'); ?></a></li>
          </ul>
        </div>
      </div>
      <div class="col-6 col-lg-2">
        <div class="footer-heading mt-3">
          <h3 class="font-size-23 text-white alt-link"><?php echo lang('support'); ?></h3>
          <ul class="nav flex-column">
            <li class="nav-item mb-1 font-size-14"><a class="text-white" title="<?php echo lang('supportpanel'); ?>" name="<?php echo lang('supportpanel'); ?>" alt="<?php echo lang('supportpanel'); ?>" href="/support"><?php echo lang('supportpanel'); ?></a></li>
            <li class="nav-item mb-1 font-size-14"><a class="text-white" title="<?php echo lang('status'); ?>" name="<?php echo lang('status'); ?>" alt="<?php echo lang('status'); ?>" href="/fees"><?php echo lang('status'); ?>/<?php echo lang('fees'); ?></a></li>
            <li class="nav-item mb-1 font-size-14"><a class="text-white" title="<?php echo lang('api'); ?>" name="<?php echo lang('api'); ?>" alt="<?php echo lang('api'); ?>" target="blank" href="<?php echo base_url(); ?>api"><?php echo lang('api'); ?></a></li>
            <!--<li class="nav-item mb-1 font-size-14"><a class="text-white" title="<?php echo lang('faucets'); ?>" name="<?php echo lang('faucets'); ?>" alt="<?php echo lang('faucets'); ?>" target="blank" href="<?php echo base_url(); ?>faucet"><?php echo lang('faucets'); ?></a></li>-->
          </ul>
        </div>
      </div>
      <div class="col-12 col-lg-4">
        <ul class="nav mt-3">
          <li class="nav-item font-size-26"> <a class="nav-link alt-link" target="_blank" title="Facebook" href=<?php echo siteSetting()["site_facebook"]; ?>> <i class="fab fa-facebook-square"> </i> </a>
          <li class="nav-item font-size-26"> <a class="nav-link alt-link" target="_blank" title="Twitter" href=<?php echo siteSetting()["site_twitter"]; ?>> <i class="fab fa-twitter-square"> </i> </a>
          <li class="nav-item font-size-26"> <a class="nav-link alt-link" target="_blank" title="Instagram" href=<?php echo siteSetting()["site_instagram"]; ?>> <i class="fab fa-instagram"> </i> </a>
          <li class="nav-item font-size-26"> <a class="nav-link alt-link" target="_blank" title="Telegram" href=<?php echo siteSetting()["site_telegram"]; ?>> <i class="fab fa-telegram"> </i> </a>
          <li class="nav-item font-size-26"> <a class="nav-link alt-link pt-1" target="_blank" title="Coinmarketcap" href=<?php echo siteSetting()["site_coinmarketcap"]; ?>><img src="<?php echo base_url(); ?>assets/home/images/cmc2.png" alt="Coinmarketcap" width="28" height="28"></a>
          <li class="nav-item font-size-26"> <a class="nav-link alt-link pt-1" target="_blank" title="Coingecko" href=<?php echo siteSetting()["site_coingecko"]; ?>><img src="<?php echo base_url(); ?>assets/home/images/coingecko.webp" alt="Coingecko" width="30" height="30"></a>
          <li class="nav-item font-size-26"> <a class="nav-link alt-link pt-1" target="_blank" title="Coincodex" href="https://coincodex.com/exchange/secondbtc/"><img src="<?php echo base_url(); ?>assets/home/images/coincodex.png" alt="Coincodex" width="27" height="27"></a>
          <li class="nav-item font-size-26"> <a class="nav-link alt-link pt-1" target="_blank" title="Coinpaprika" href="https://coinpaprika.com/exchanges/secondbtc"><img src="<?php echo base_url(); ?>assets/home/images/coinpaprika.png" alt="Coinpaprika" width="26" height="26"></a>
          <li class="nav-item font-size-26"> <a class="nav-link alt-link pt-1" target="_blank" title="Cryptowiser" href="https://www.cryptowisser.com/exchange/secondbtc"><img src="<?php echo base_url(); ?>assets/home/images/cryptowiser.png" alt="Cryptowiser" width="29" height="28"></a>
          <li class="nav-item font-size-26"> <a class="nav-link alt-link pt-1" target="_blank" title="Coincost" href="http://coincost.net/tr/exchange/secondbtc"><img src="<?php echo base_url(); ?>assets/home/images/coincost.png" alt="Coincost" width="27" height="27"></a>
          <li class="nav-item font-size-26"> <a class="nav-link alt-link pt-1" target="_blank" title="Cmc.io" href="https://cmc.io/exchanges/secondbtc"><img src="<?php echo base_url(); ?>assets/home/images/cmcio.png" alt="Cmc.io" width="27" height="27"></a>
        </ul>
      </div>
    </div>
  </div>
</footer>
<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>assets/home/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>assets/home/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>assets/home/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/home/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/home/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/home/js/custom.js?v=<?php echo time(); ?>"></script>
<script src="<?php echo base_url(); ?>assets/home/js/main.js?v=1"></script>
<script src="<?php echo base_url(); ?>assets/home/js/toast.js?v=1"></script>

</body>

</html>