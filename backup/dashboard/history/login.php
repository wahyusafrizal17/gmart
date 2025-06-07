<?php 
require_once('izin.php');
require_once('history/login1.php'); ?>
 
       
<div class="box box-default color-palette-box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tag"></i> LIST HISTORY PERUBAHAN DATA</h3>
        </div>
        <div class="box-body">
        
        <div class="row">
                                            <form method="get">
                                                <div class="col-md-10">
                                                  <input type="text" name="cari" class="form-control" placeholder="Masukkan Kata Kunci username">
                                                </div>
                                                 
                                                <div class="col-md-2">
                                                  <button type="submit" class="btn btn-primary btn-block"><span class="fa fa-search"></span> Search</button>
                                                  <input type="hidden" name="page" value="history/login">
                                                </div>
                                                
                                             </form>     
                                      </div>
                                      <br />
          <div class="row">
             <div class="col-md-12">
             <div class="table-responsive">
               <table width="100%" class="table table-striped">
                 <tr>
                   
                   <th><div align="center"><strong>NO.</strong></div></th>
                   <th><div align="center"><strong>FORM 1</strong></div></th>
                   <th><div align="center"><strong>FORM 2</strong></div></th>
                   <th><div align="center"><strong>STATUS</strong></div></th>
                   <th><div align="center"><strong>#</strong></div></th>
                 </tr>
                 <?php $no = 1; do { ?>
                 <tr>
                   
                   <td align="center"><?php echo $no; ?></td>
                   <td align="center"><?php echo $row_Produk['username_login']; ?></td>
                   <td align="center"><?php echo $row_Produk['password_login']; ?></td>
                   <td align="center"><?php echo $row_Produk['status_login']; ?></td>
                   <td align="center"><?php echo date("d M Y H:m:s", $row_Produk['added_login']); ?></td>
                 </tr>
                 <?php 
				 $no++;
				 } while ($row_Produk = mysqli_fetch_assoc($rs_Produk)); ?>
               </table>
               </div>
             </div>   
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
                   
<?php require_once('history/login2.php'); ?>

 
 
