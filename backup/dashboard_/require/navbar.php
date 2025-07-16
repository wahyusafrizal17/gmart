 <!-- Logo -->
    <a href="?page=home" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b><?=  $header; ?></b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?=  $header;  ?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        
          <li><a href="?page=scan/add"><i class="fa fa-barcode"></i>&nbsp;&nbsp;Kasir</a> </li>
           
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            		  <?php if (empty($row_rs_profile['photo_admin']) || !file_exists("photos/".$row_rs_profile['photo_admin'])) { ?>
                           <img src="photos/default.png" class="user-image" alt="User Image">
					  <?php }else{ ?>
                      	   <img src="photos/<?= $row_rs_profile['photo_admin']; ?>" class="user-image" alt="User Image">
                      <?php } ?>
               
            
              <span class="hidden-xs"><?= $nama; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
              
                	  <?php if (empty($row_rs_profile['photo_admin']) || !file_exists("photos/".$row_rs_profile['photo_admin'])) { ?>
                           <img src="photos/default.png" class="img-circle" alt="User Image">
					  <?php }else{ ?>
                      	   <img src="photos/<?= $row_rs_profile['photo_admin']; ?>" class="img-circle" alt="User Image">
                      <?php } ?>

                <p>
                  <?= $nama; ?>
                  <small></small>
                </p>
              </li>
                
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <?php if ($level <= 2) { ?>
                  <a href="?page=update/profile" class="btn btn-default btn-flat">Profile</a>                  
                  <?php } ?>
                </div>
                <div class="pull-right">
                  <a href="<?php echo $logoutAction; ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button 
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
          -->
        </ul>
      </div>
    </nav>