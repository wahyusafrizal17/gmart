<!-- Logo -->
<a href="?page=home" class="logo" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);height: 55px;">
  <!-- mini logo for sidebar mini 50x50 pixels -->
  <span class="logo-mini" style="color: white; font-weight: bold;"><b><?= $header; ?></b></span>
  <!-- logo for regular state and mobile devices -->
  <span class="logo-lg" style="color: white; font-weight: bold;"><b><?= $header; ?></b></span>
</a>

<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);border: none;box-shadow: 0 2px 10px rgba(0,0,0,0.1);height: 55px;">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" style="color: white; border: none;">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar" style="background-color: white;"></span>
    <span class="icon-bar" style="background-color: white;"></span>
    <span class="icon-bar" style="background-color: white;"></span>
  </a>

  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
    
      <li>
        <a href="?page=scan/add" style="color: white;font-weight: bold;padding: 10px 10px;border-radius: 25px;margin: 9px 10px;background: rgba(255,255,255,0.2);transition: all 0.3s ease;">
          <i class="fa fa-barcode"></i>&nbsp;&nbsp;POS Scanner
        </a>
      </li>
       
      <!-- User Account: style can be found in dropdown.less -->
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: white; padding: 15px 20px;">
          <div style="display: flex; align-items: center;">
            <?php if (empty($row_rs_profile['photo_admin']) || !file_exists("photos/".$row_rs_profile['photo_admin'])) { ?>
              <img src="photos/default.png" class="user-image" alt="User Image" style="width: 35px; height: 35px; border-radius: 50%; margin-right: 10px; border: 2px solid rgba(255,255,255,0.3);">
            <?php }else{ ?>
              <img src="photos/<?= $row_rs_profile['photo_admin']; ?>" class="user-image" alt="User Image" style="width: 35px; height: 35px; border-radius: 50%; margin-right: 10px; border: 2px solid rgba(255,255,255,0.3);">
            <?php } ?>
            <span class="hidden-xs" style="font-weight: bold;"><?= $nama; ?></span>
            <i class="fa fa-chevron-down" style="margin-left: 10px;"></i>
          </div>
        </a>
        <ul class="dropdown-menu" style="border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); border: none;">
          <!-- User image -->
          <li class="user-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px 15px 0 0; padding: 20px;">
            <?php if (empty($row_rs_profile['photo_admin']) || !file_exists("photos/".$row_rs_profile['photo_admin'])) { ?>
              <img src="photos/default.png" class="img-circle" alt="User Image" style="width: 80px; height: 80px; border: 3px solid rgba(255,255,255,0.3);">
            <?php }else{ ?>
              <img src="photos/<?= $row_rs_profile['photo_admin']; ?>" class="img-circle" alt="User Image" style="width: 80px; height: 80px; border: 3px solid rgba(255,255,255,0.3);">
            <?php } ?>
            <p style="color: white; margin-top: 10px; font-weight: bold;">
              <?= $nama; ?>
              <small style="color: rgba(255,255,255,0.8);">Administrator</small>
            </p>
          </li>
            
          <!-- Menu Footer-->
          <li class="user-footer" style="padding: 15px;">
            <div class="pull-left">
              <?php if ($level <= 2) { ?>
              <a href="?page=update/profile" class="btn btn-primary btn-flat" style="border-radius: 20px; padding: 8px 20px;">
                <i class="fa fa-user"></i> Profile
              </a>                  
              <?php } ?>
            </div>
            <div class="pull-right">
              <a href="<?php echo $logoutAction; ?>" class="btn btn-danger btn-flat" style="border-radius: 20px; padding: 8px 20px;">
                <i class="fa fa-sign-out"></i> Sign out
              </a>
            </div>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>