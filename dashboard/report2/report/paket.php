<?php require_once('../require/lap_header.php'); 
$tgl1 = "-1";
$tgl2 = "-1";
$status = "-1";
$totalRows_Paket = 0;
if (isset($_GET["tgl1"]) || isset($_GET["tgl2"]) || isset($_GET["status"])) {
	$tgl1 = $_GET["tgl1"];
	$tgl2 = $_GET["tgl2"];
	$status = $_GET['status'];
	//JIKA ADA
	if (empty($status)) { 
		$query_Paket = sprintf("SELECT id_paket, kode_paket, nama_paket, berat_paket, alamat_paket, ket_paket, penerima_paket, tgl_paket, jumlah_paket, telppenerima_paket, pengirim_paket, jenis_paket, kol_paket, marketing_paket, ta_paket, addby_paket, added_paket, tarif_ongkir, kotatujuan_paket, kotaasal_paket, service_paket, kodepos_paket, nama_pengirim, nama_jp, ket_jp, fullname_kurir, alamat_kurir, hp_kurir, email_kurir,nama_service, ket_service, stt_paketstatus, Nama, ID FROM tb_paket 
	INNER JOIN tb_pengirim ON pengirim_paket = id_pengirim 
	INNER JOIN tb_jenispaket ON jenis_paket = id_jp 
	INNER JOIN tb_kurir ON marketing_paket = id_kurir 
	INNER JOIN tb_service ON service_paket = id_service
	LEFT JOIN tb_paketstatus ON kode_paket = kode_paketstatus 
	LEFT JOIN vw_login ON addby_paketstatus = ID
	WHERE 
			 tgl_paket BETWEEN %s AND %s AND tb_paket.cabang_id = '".$cabang."'
			ORDER BY id_paket DESC", 
		GetSQLValueString($tgl1, "date"), 
		GetSQLValueString($tgl2, "date"));
	}else{
		$query_Paket = sprintf("SELECT id_paket, kode_paket, nama_paket, berat_paket, alamat_paket, ket_paket, penerima_paket, tgl_paket, jumlah_paket, telppenerima_paket, pengirim_paket, jenis_paket, kol_paket, marketing_paket, ta_paket, addby_paket, added_paket, tarif_ongkir, kotatujuan_paket, kotaasal_paket, service_paket, kodepos_paket, nama_pengirim, nama_jp, ket_jp, fullname_kurir, alamat_kurir, hp_kurir, email_kurir,nama_service, ket_service, stt_paketstatus, Nama, ID FROM tb_paket 
	INNER JOIN tb_pengirim ON pengirim_paket = id_pengirim 
	INNER JOIN tb_jenispaket ON jenis_paket = id_jp 
	INNER JOIN tb_kurir ON marketing_paket = id_kurir 
	INNER JOIN tb_service ON service_paket = id_service
	LEFT JOIN tb_paketstatus ON kode_paket = kode_paketstatus 
	LEFT JOIN vw_login ON addby_paketstatus = ID
	WHERE 
			 tgl_paket BETWEEN %s AND %s AND stt_paketstatus = %s AND tb_paket.cabang_id = '".$cabang."'
			ORDER BY id_paket DESC", 
		GetSQLValueString($tgl1, "date"), 
		GetSQLValueString($tgl2, "date"), 
		GetSQLValueString($status, "text"));
	}
	
	$Paket = mysql_query($query_Paket, $koneksi) or die(errorQuery(mysql_error()));
	$row_Paket = mysql_fetch_assoc($Paket);
	$totalRows_Paket = mysql_num_rows($Paket);	
}	

?>

<?php
	titlePreview('DAFTAR PAKET BERDASARKAN TANGGAL','Berikut ini adalah data paket berdasarkan tanggal');
?>
 
<?php if ($totalRows_Paket > 0) { ?>
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>

<table width="100%">
  <tr>
    <th width="16%" scope="row"><div align="left">DARI TANGGAL</div></th>
    <td>: <?= $tgl1; ?></td>
  </tr>
  <tr>
    <th scope="row"><div align="left">SAMPAI TANGGAL</div></th>
    <td>: <?= $tgl1; ?></td>
  </tr>
  <tr>
    <th scope="row"><div align="left">STATUS PAKET</div></th>
    <td>: <?php if ($status == 'Y') {
	echo "Sampai";
	}elseif ($status == 'P') {
	echo "Proses";
	}elseif ($status == 'N') {
	echo "Tunda";
	}else{
	echo "Semua";
	} ?></td>
  </tr>
</table>
<div class="table-responsive">
<table width="100%" class="table table-striped table-hover table-bordered">
<thead>
  <tr bgcolor="#333399">
    <th width="8%"><div align="center" class="style1">
       NO. 
    </div></th>
    <th width="19%"><span class="style1">PAKET</span></th>
    <th width="25%"><span class="style1">LAYANAN</span></th>
    <th width="21%"><span class="style1">DESTINASI</span></th>
    <th width="27%"><span class="style1">ONGKIR</span></th>
    </tr>
  </thead>
 <tbody>
  <?php $no = 1; do { ?>
    <tr>
      <td><div align="center"><?= $no; ?>
      <?php if ($row_Paket['stt_paketstatus'] == 'Y') { ?>
      	  <div class="btn btn-default btn-sm"><img src="../../log_asset/images/true.png" /> </div>
      <?php }elseif ($row_Paket['stt_paketstatus'] == 'P') { ?> 
	      <div class="btn btn-default btn-sm"><img src="../../log_asset/images/loading.gif" /> </div>
      <?php }else{ ?> 
	      <div class="btn btn-default btn-sm"><img src="../../log_asset/images/false.png" /> </div>
      <?php } ?>
      </div></td>
      <td><strong><?= $row_Paket['kode_paket']; ?></strong>&nbsp; <br />
        <?= $row_Paket['nama_paket']; ?><br />
        Berat : 
        <?= $row_Paket['berat_paket']; ?>
        Kg
        <br />
		
        <?php if ($row_Paket['stt_paketstatus'] != 'P') { ?>
      	 oleh : <?php echo $row_Paket['Nama']; ?>
      <?php } ?> 
        </td>
      <td>Jenis Paket :
        <?= $row_Paket['nama_jp']; ?>
        <br />
        Service : <?= $row_Paket['nama_service']; ?>&nbsp;<br />
        Marketing : 
        <?= $row_Paket['fullname_kurir']; ?></td>
      <td>Penerima : <?= $row_Paket['penerima_paket']; ?><br /> 
        <?= $row_Paket['alamat_paket']; ?>,  <?= $row_Paket['telppenerima_paket']; ?>
        <br />
        Pengirim : <?= $row_Paket['nama_pengirim']; ?></td>
      <td>Kota Asal : 
        <?= $row_Paket['kotaasal_paket']; ?>
        <br />
        Kota Tujuan : 
        <?= $row_Paket['kotatujuan_paket']; ?>
        <br />
        Ongkir : Rp. 
        <?= number_format($row_Paket['tarif_ongkir']); ?></td>
      </tr>
    <?php 
	$no++;
	} while ($row_Paket = mysql_fetch_assoc($Paket)); ?>
    </tbody>
</table> 
</div> 
<?php }else{
	danger('Oops!', 'Kami tidak menemukan data tersebut :(');
} ?> 
  
                    
<?php require_once('../require/lap_footer.php'); ?>          