<?php require_once('../require/lap_header.php');
$stok = 2;
if (isset($_GET['qty'])) {
    $stok = $_GET['qty'];
}

//mysqli_select_db($database_koneksi);
$query_rs_produk = sprintf("SELECT LEFT(namaproduk, 30) as namaproduk, namakategori, kodeproduk, satuan, stok FROM produk 
LEFT JOIN kategori ON produk.kategori = kategori.idkategori 
WHERE stok <= %s", GetSQLValueString($koneksi, $stok, "int"));
$rs_produk = mysqli_query($koneksi, $query_rs_produk) or die(mysqli_error());
$row_rs_produk = mysqli_fetch_assoc($rs_produk);
$totalRows_rs_produk = mysqli_num_rows($rs_produk);
?>

<style type="text/css">
    .tableku tr,
    .tableku td {
        border: 2px solid #000;
        padding-left: 5px;
        padding-right: 5px;
    }

    .tableku th {
        color: #fff;
        text-align: center;
    }

    .table-h {
        border-bottom: 2px solid #000;
    }
</style>

<body onload="window.print()">
    <h3>Daftar Produk</h3>
    <p class="pull-left">Berikut ini adalah daftar produk yang di bawah dari <?= $stok; ?> dan harus dipesan</p>
    <p class="pull-right">Tanggal Pembuatan : <?= date("d-M-Y h:m:s"); ?></p>
    <table class="table-h" width="100%">
        <thead class="tableku">
            <tr>
                <th bgcolor="#006699">
                    <div align="center" class="style1">NO.</div>
                </th>
                <th bgcolor="#006699">
                    <div align="center" class="style1">NAMA PRODUK</div>
                </th>
                <th bgcolor="#006699">
                    <div align="center" class="style1">KATEGORI</div>
                </th>
                <th bgcolor="#006699">
                    <div align="center" class="style1">STOK</div>
                </th>
                <th bgcolor="#006699">
                    <div align="center" class="style1">SATUAN</div>
                </th>
            </tr>
        </thead>
        <tbody class="tableku">
            <?php
            $no = 1;
            do { ?>
                <tr>
                    <td align="center"><?php echo $no; ?></td>
                    <td><?php echo $row_rs_produk['kodeproduk']; ?> - <?php echo $row_rs_produk['namaproduk']; ?></td>
                    <td><?php echo $row_rs_produk['namakategori']; ?></td>
                    <td>
                        <div align="center"><?php echo $row_rs_produk['stok']; ?></div>
                    </td>
                    <td>
                        <div align="center"><?php echo $row_rs_produk['satuan']; ?></div>
                    </td>
                </tr>
            <?php
                $no++;
            } while ($row_rs_produk = mysqli_fetch_assoc($rs_produk)); ?>
        </tbody>
    </table>