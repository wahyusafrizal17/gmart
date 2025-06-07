<?php 
require_once('izin.php');
require_once('history/Page1.php'); ?>
 
       
<div class="box box-default color-palette-box">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-tag"></i> LIST HISTORY PRODUK</h3>
        </div>
        <div class="box-body">
        
        <div class="row">
                                            <form method="get">
                                                <div class="col-md-10">
                                                  <input type="text" name="cari" class="form-control" placeholder="Cari Kode Produk / Nama Produk / Kategori">
                                                </div>
                                                 
                                                <div class="col-md-2">
                                                  <button type="submit" class="btn btn-primary btn-block"><span class="fa fa-search"></span> Search</button>
                                                  <input type="hidden" name="page" value="history/stok">
                                                </div>
                                                
                                             </form>     
                                      </div>
                                      <br />
          <div class="row">
             <div class="col-md-12">
             <?php if ($totalRows_Produk > 0) { ?>
             <div class="table-responsive">
               <table width="100%" class="table table-striped">
                 <tr>
                   
                   <th><div align="center"><strong>NAMA PRODUK</strong></div></th>
                   <th><div align="center"><strong>DETAIL</strong></div></th>
                 </tr>
                 <?php $no = 1; do { ?>
                 <tr>
                   
                   <td><a href="?page=history/produk&kode=<?= $row_Produk['kodeproduk']; ?>" title="<?php echo $row_Produk['deskproduk']; ?>"><h4><strong><?php echo $row_Produk['namaproduk']; ?> ( <?php echo $row_Produk['kodeproduk']; ?> )</strong> </h4></a>
                     Category : <a href="?page=produk/viewcategori" target="_blank"><?php echo $row_Produk['namakategori']; ?></a><br />
                     HD : Rp. <?php echo $row_Produk['hargadasar']; ?> - 
                     HJ : Rp. <?php echo $row_Produk['hargajual']; ?></td>
                   <td><p>Stok Terkini : <?php echo $row_Produk['stok']; ?> <?php echo $row_Produk['satuan']; ?><br />
                     <?php if ($row_Produk['status'] == 'T') {
					echo "<div class='btn btn-success'>Penambahan Stok <strong>(+".$row_Produk['qty'].")</strong></div>";
				}else{
					echo "<div class='btn btn-danger'>Pengurangan Stok <strong>(-".$row_Produk['qty'].")</strong></div>";
				} ?>
                <div class="btn btn-primary">Old Stok : <strong><?php echo $row_Produk['oldStok']; ?></strong></div>
                	
                    <br />
                     oleh : <?php echo $row_Produk['Nama']; ?> ::
                   #<?php echo $row_Produk['tercatat']; ?></p>
                   </td>
                 </tr>
                 <?php 
				 $no++;
				 } while ($row_Produk = mysqli_fetch_assoc($rs_Produk)); ?>
               </table>
               </div>
             </div>   
          </div>
          <?php }else{
		  		danger('Oops','Belum ada perubahan stok produk');
			}
		  ?>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>
                   
<?php require_once('history/Page2.php'); ?>

 
 
