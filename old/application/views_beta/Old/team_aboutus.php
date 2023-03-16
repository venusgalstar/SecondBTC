<?php include "include/header.php" ; ?>
<?php ?>
    <!-- Header -->
<header class="bg-dark text-center py-5 mb-4">
  <div class="container">
    <h1 class="font-weight-light text-white"><?php echo lang('aboutus');?></h1>
    <div class="text-white">
      <?php echo siteSetting()['site_aboutus']; ?>
    </div>
  </div>
</header>
<!-- Page Content -->
<div class="container">
  <div class="row justify-content-center">
    <!-- Team Member 1 -->
    <?php foreach ($teamList as $teamList) {?>
    <div class="m-2">
      <div class="card border-0 shadow" style="width:200px;">
        <img src="<?php echo base_url(); ?>assets/home/images/team/<?php echo $teamList["team_image"]; ?>" class="card-img-top" alt="...">
        <div class="card-body text-center">
          <h5 class="card-title mb-0"><?php echo $teamList["team_name"]; ?></h5>
          <div class="card-text text-black-50"><?php echo $teamList["team_jop"]; ?></div>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
  <!-- /.row -->
</div>
<?php include "include/footer.php" ; ?>
