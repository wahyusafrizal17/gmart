<?php 
require_once('izin.php');
require_once('history/activity1.php'); ?>
 
       
<div class="box box-default color-palette-box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tag"></i> LIST HISTORY PERUBAHAN DATA</h3>
        </div>
        <div class="box-body">
        
        <div class="row">
                                            <form method="get">
                                                <div class="col-md-10">
                                                  <input type="text" name="cari" class="form-control" placeholder="Masukkan Kata Kunci URL / Nama">
                                                </div>
                                                 
                                                <div class="col-md-2">
                                                  <button type="submit" class="btn btn-primary btn-block"><span class="fa fa-search"></span> Search</button>
                                                  <input type="hidden" name="page" value="history/activity">
                                                </div>
                                                
                                             </form>     
                                      </div>
                                      <br />
          <div class="row">
             <div class="col-md-12">
             <div class="table-responsive">
               <table width="100%" class="table table-striped">
                 <tr>
                   
                   <th><div align="center"><strong>URL</strong></div></th>
                   <th><div align="center"><strong>NAMA</strong></div></th>
                   <th><div align="center"><strong>#</strong></div></th>
                 </tr>
                 <?php $no = 1; do { ?>
                 <tr>
                   
                   <td><?php echo $row_Produk['url']; ?></td>
                   <td><?php echo $row_Produk['Nama']; ?></td>
                   <td><?php echo $row_Produk['datetime']; ?></td>
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
                   
<?php require_once('history/activity2.php'); ?>

 
 
