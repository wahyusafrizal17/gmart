<?php  
require_once('izin.php');
//mysqli_select_db($database_koneksi, $koneksi);
//$query_Admin = "SELECT id_admin, Login, nama_admin, gender_admin, address_admin, email_admin, hp_admin FROM tb_admin WHERE cabang_id = '".$cabang."' ORDER BY nama_admin ASC";
$query_Member = "SELECT * FROM member ORDER BY point DESC";
$Member = mysqli_query($koneksi, $query_Member) or die(errorQuery(mysqli_error($koneksi)));
$row_Member = mysqli_fetch_assoc($Member);
$totalRows_Member = mysqli_num_rows($Member);
?>
<?php if (isset($_GET['sukses'])) { 
   		sukses('Data member berhasil tersimpan');
} ?>

<?php
	titleTampil('DAFTAR MEMBER','Member');
  addNew('member/insert','users');
	echo "<br /><br />";
?> 
<?php if ($totalRows_Member > 0) { ?>
<div class="table-responsive">
<table width="100%" class="table table-striped table-hover table-bordered" id="example1">
<thead>
  <tr bgcolor="#333399">
    <th width="6%"><div align="center" class="style1 style1">Rank.</div></th>
    <th><span class="style1">NIK</span></th>
    <th><span class="style1">NAMA MEMBER</span></th>
    <th><span class="style1">NOMOR HP</span></th>
    <th><span class="style1">POINT</span></th>
    <th><span class="style1">OPSI</span></th>
  </tr>
  </thead>
 <tbody>
  <?php $no = 1; do { ?>
    <tr>
      <td><div align="center"><?= $no; ?></div></td>
      <td><?php echo $row_Member['nik']; ?></td>
      <td><?php echo $row_Member['nama_member']; ?></td>
      <td><?php echo $row_Member['nomor']; ?></td>
      <td><?php echo $row_Member['point']; ?> Point</td>
      <td><?php $fungsi($row_Member['id_member'],'member','member'); ?>
          <a href="?page=member/tukarpoint&id_member=<?php echo $row_Member['id_member']; ?>" class="btn btn-success btn-sm">Tukar Point</a>
      </td>
    </tr>
    <?php 
	$no++;
	} while ($row_Member = mysqli_fetch_assoc($Member)); ?>
</tbody>
</table>
</div>  
<?php }else{
	danger('Oops!', 'Data belum ada');
} ?>