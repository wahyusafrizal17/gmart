<?php  
require_once('izin.php');
//mysqli_select_db($database_koneksi, $koneksi);
//$query_Admin = "SELECT id_admin, Login, nama_admin, gender_admin, address_admin, email_admin, hp_admin FROM tb_admin WHERE cabang_id = '".$cabang."' ORDER BY nama_admin ASC";

// Handle update point (admin only)
if ((isset($_POST['MM_update'])) && $_POST['MM_update'] === 'update_point' && isset($_SESSION['MM_Level']) && $_SESSION['MM_Level'] == 1) {
  $newPoint = isset($_POST['point']) && $_POST['point'] !== '' ? $_POST['point'] : 0;
  $updatePointSQL = sprintf(
    "UPDATE member SET point=%s WHERE id_member=%s",
    GetSQLValueString($newPoint, 'double'),
    GetSQLValueString($_POST['id_member'], 'int')
  );
  mysqli_query($koneksi, $updatePointSQL) or die(errorQuery(mysqli_error($koneksi)));
  refresh('?page=member/view&sukses');
}

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
          <?php if (isset($_SESSION['MM_Level']) && $_SESSION['MM_Level'] == 2) { ?>
          <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editPoint<?= $row_Member['id_member']; ?>">Edit Point</button>

          <div class="modal fade" id="editPoint<?= $row_Member['id_member']; ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Edit Point - <?= htmlspecialchars($row_Member['nama_member']); ?></h4>
                </div>
                <form method="post" action="">
                  <div class="modal-body">
                    <div class="form-group">
                      <label>Point</label>
                      <?php $currentPoint = ($row_Member['point'] === null || $row_Member['point'] === '') ? 0 : $row_Member['point']; ?>
                      <input type="number" step="1" min="0" class="form-control" name="point" value="<?= htmlspecialchars($currentPoint); ?>" placeholder="0" style="display: flex;" />
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <input type="hidden" name="MM_update" value="update_point" />
                    <input type="hidden" name="id_member" value="<?= $row_Member['id_member']; ?>" />
                  </div>
                </form>
              </div>
            </div>
          </div>
          <?php } ?>
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