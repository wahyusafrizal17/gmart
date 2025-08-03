<?php
require_once 'izin.php';
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= '?' . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_POST['MM_insert']) && $_POST['MM_insert'] == 'form1') {
    // Pastikan semua input tidak kosong
    $tanggal = date('Y-m-d');
    $idmember = $_POST['idmember'];
    $idproduk = $_POST['idproduk'];
    $point = $_POST['point'];
    $qty = $_POST['qty'];
    if (!empty($_POST['idmember']) && !empty($_POST['idproduk']) && !empty($_POST['qty'])) {
        $riwayatpenukaran = sprintf(
            'INSERT INTO riwayatpenukaran (`idmember`, `idproduk`, `qty`, `tanggal`) VALUES (%s, %s, %s, %s)',
            GetSQLValueString($_POST['idmember'], 'text'),
            GetSQLValueString($_POST['idproduk'], 'text'),
            GetSQLValueString($_POST['qty'], 'text'),
            GetSQLValueString($tanggal, 'text')
        );

        mysqli_select_db($database_koneksi, $koneksi);
        $Result1 = mysqli_query($riwayatpenukaran, $koneksi);

        if($Result1){
          $getMember = sprintf("SELECT * FROM member WHERE id_member='$idmember'");
          $Member = mysqli_query($getMember, $koneksi) or die(errorQuery(mysqli_error()));
          $row_member = mysqli_fetch_assoc($Member);
          $point_akhir = $row_member['point'] - $point;

          $updateMember = sprintf("UPDATE member SET `point`=%s WHERE `id_member`=%s",
					   GetSQLValueString($point_akhir, "int"),
					   GetSQLValueString($_POST['idmember'], "int"));

            mysqli_select_db($database_koneksi, $koneksi);
            $Result1 = mysqli_query($updateMember, $koneksi) or die(errorQuery(mysqli_error()));

            $getProduk = sprintf("SELECT * FROM produk WHERE idproduk='$idproduk'");
            $Produk = mysqli_query($getProduk, $koneksi) or die(errorQuery(mysqli_error()));
            $row_produk = mysqli_fetch_assoc($Produk);

            $stok_akhir = $row_produk['stok'] - $qty;
            $updateProduk = sprintf("UPDATE produk SET `stok`=%s WHERE `idproduk`=%s",
					   GetSQLValueString($stok_akhir, "int"),
					   GetSQLValueString($_POST['idproduk'], "int"));

            mysqli_select_db($database_koneksi, $koneksi);
            $Result1 = mysqli_query($updateProduk, $koneksi) or die(errorQuery(mysqli_error()));
        }
        
        if (!$Result1) {
            die('Error: ' . mysqli_error());
        } else {
            refresh('?page=member/view&sukses');
        }
    } else {
        die('Error: Input tidak boleh kosong.');
    }
}

?>
<?php if (isset($_GET['sukses'])) {
    sukses('Penukaran point berhasil');
} ?>

<?php
//require_once('izin.php');
//mysqli_select_db($database_koneksi, $koneksi);
$query_tukarproduk = "SELECT * FROM tukarproduk a,produk b WHERE a.produk=b.idproduk";
$tukarproduk = mysqli_query($query_tukarproduk, $koneksi) or die(errorQuery(mysqli_error()));
$row_tukarproduk = mysqli_fetch_assoc($tukarproduk);
$totalRows_tukarproduk = mysqli_num_rows($tukarproduk);

$colname_Mem  = "-1";
if (isset($_GET['id_member'])) {
  $colname_Mem  = $_GET['id_member'];
}
mysqli_select_db($database_koneksi, $koneksi);
$query_Member = sprintf("SELECT * FROM member WHERE id_member = %s", GetSQLValueString($colname_Mem, "int"));
$Member = mysqli_query($query_Member, $koneksi) or die(errorQuery(mysqli_error()));
$row_Member = mysqli_fetch_assoc($Member);
$totalRows_Member = mysqli_num_rows($Member);
?>


<?php if ($totalRows_tukarproduk > 0) { ?>

<?php $no = 0; do { ?>
    
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h2 class="text-uppercase"><strong><?php echo $row_tukarproduk['namaproduk']; ?></strong></h2>
              <h4><?php echo $row_tukarproduk['point']; ?>pts</h4> 
            </div>
            <div class="icon">
              <i class="fa fa-cube"></i>
            </div>
            <button type="button" class="btn btn-success" <?php if($row_Member['point'] < $row_tukarproduk['point']) { ?> disabled <?php } ?> data-toggle="modal" data-target="#exampleModal<?= $row_tukarproduk['id'] ?>">Tukarkan Point</button>


            <div class="modal fade" id="exampleModal<?= $row_tukarproduk['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
      <div class="modal-body">
        <h2 style="color: #444;">Tukarkan <?= $row_tukarproduk['point'] ?>pts milik <b><?= $row_Member['nama_member'] ?></b> dengan <?= $row_tukarproduk['namaproduk'] ?> ?</h2>
        <input type="hidden" name="idmember" value="<?= $row_Member['id_member'] ?>" id="">
        <input type="hidden" name="idproduk" value="<?= $row_tukarproduk['idproduk'] ?>" id="">
        <input type="hidden" name="qty" value="1" id="">
        <input type="hidden" name="point" value="<?= $row_tukarproduk['point'] ?>" id="">
        <input type="hidden" name="MM_insert" value="form1" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Tukarkan</button>
      </div>
      </form>
    </div>
  </div>
</div>
          </div>
        </div>
   
<?php $no++;
	} while ($row_tukarproduk = mysqli_fetch_assoc($tukarproduk)); 
?>
<?php }else{
	danger('Oops!', 'Data belum ada');
} ?>