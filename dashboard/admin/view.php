<?php  
require_once('izin.php');
//$query_Admin = "SELECT id_admin, Login, nama_admin, gender_admin, address_admin, email_admin, hp_admin FROM tb_admin WHERE cabang_id = '".$cabang."' ORDER BY nama_admin ASC";
$query_Admin = "SELECT id_admin, Login, nama_admin, gender_admin, address_admin, email_admin, hp_admin FROM tb_admin ORDER BY nama_admin ASC";
$Admin = mysqli_query($koneksi, $query_Admin) or die(errorQuery(mysqli_error($koneksi)));
$row_Admin = mysqli_fetch_assoc($Admin);
$totalRows_Admin = mysqli_num_rows($Admin);
?>
<?php if (isset($_GET['sukses'])) { 
   		sukses('Data jenis paket berhasil tersimpan');
} ?>

<?php
titleTampil('DAFTAR ADMINISTRATOR','Administrator');
?> 
<?php if ($totalRows_Admin > 0) { ?>
<div class="table-responsive">
<table width="100%" class="table table-striped table-hover table-bordered" id="example1">
<thead>
  <tr bgcolor="#333399">
    <th width="6%"><div align="center" class="style1 style1">NO.</div></th>
    <th><span class="style1">USERNAME</span></th>
    <th><span class="style1">NAMA LENGKAP</span></th>
    <th><span class="style1">ALAMAT</span></th>
    <th><span class="style1"></span></th>
  </tr>
  </thead>
 <tbody>
  <?php $no = 1; do { ?>
    <tr>
      <td><div align="center"><?= $no; ?></div></td>
      <td><?php echo $row_Admin['Login']; ?></td>
      <td><?php echo $row_Admin['nama_admin']; ?><br>
        Gender : <?php echo $row_Admin['gender_admin']; ?></td>
      <td><?php echo $row_Admin['address_admin']; ?>, <?php echo $row_Admin['hp_admin']; ?><br>
        Email : <?php echo $row_Admin['email_admin']; ?></td>
      <td><?php $fungsiUpdate($row_Admin['id_admin'],'admin','id_admin'); ?></td>
    </tr>
    <?php 
	$no++;
	} while ($row_Admin = mysqli_fetch_assoc($Admin)); ?>
</tbody>
</table>
</div>  
<?php }else{
	danger('Oops!', 'Data belum ada');
} ?>