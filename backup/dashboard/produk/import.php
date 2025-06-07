<?php
$jumlah = 0; // jumlah data yang diisi dari variabel $objPHPExcel
if ((isset($_POST['MM_insert'])) && ($_POST['MM_insert'] == 'form1')) {
    $Result1 = false;
    //start transaction
    $start = 'START TRANSACTION';
    mysqli_select_db($koneksi, $database_koneksi);
    $ResultStart = mysqli_query($koneksi, $start) or die(mysqli_error($koneksi));
    //---------
    $kosongkan = 'TRUNCATE tb_import';
    mysqli_select_db($koneksi, $database_koneksi);
    $Result2 = mysqli_query($koneksi, $kosongkan) or die(mysqli_error($koneksi));

    $file = $_FILES['file']['name'];
    $ekstensi = explode('.', $file);
    $file_name = 'file-' . round(microtime(true)) . '.' . end($ekstensi);
    $sumber = $_FILES['file']['tmp_name'];
    if (is_uploaded_file($sumber)) {
        $upload = move_uploaded_file($sumber, 'produk/_file/' . $file);
    }

    if ($upload) {
        //$koneksi = mysqli_koneksi('localhost', 'root', '', 'as');
        include('produk/PHPExcel/IOFactory.php');
        $html = "
        <p><a href='?page=produk/import' class='btn btn-warning'>Import Ulang</a>
        </p>
        <table class='table table-striped'>
        <thead>
        <tr bgcolor='#F0F0F0'>
            <td>NO.</td>
            <td>KODE</td>
            <td>NAMA</td>
            <td>HARGA MODAL</td>
            <td>HARGA JUAL</td>
            <td>SATUAN</td>
            <td>STOK</td>
            <td>KATEGORI</td>
            <td>KET</td>
            <td>MIN. STOK</td>
        </tr>
    </thead>
    <tbody>";

        $objPHPExcel = PHPExcel_IOFactory::load('produk/_file/' . $file);
        $no = 1;

        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestRow();
            for ($row = 2; $row <= $highestRow; $row++) {
                $kode = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $nama = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $hargamodal = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $hargajual = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $satuan = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                $stok = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                $kategori = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                $ket = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                $min = $worksheet->getCellByColumnAndRow(8, $row)->getValue();

                $html .= '<tr>';
                $html .= '<td>' . $no . '</td>';
                $html .= '<td>' . $kode . '</td>';
                $html .= '<td>' . $nama . '</td>';
                $html .= '<td>' . $hargamodal . '</td>';
                $html .= '<td>' . $hargajual . '</td>';
                $html .= '<td>' . $satuan . '</td>';
                $html .= '<td>' . $stok . '</td>';
                $html .= '<td>' . $kategori . '</td>';
                $html .= '<td>' . $ket . '</td>';
                $html .= '<td>' . $min . '</td>';
                $html .= '</tr>';
?>
        <?php

                $sql = sprintf(
                    "INSERT INTO `tb_import` (`kodeproduk`, `namaproduk`, `hargamodal`, `hargajual`, `satuan`, `stok`, `kategori`, `deskripsi`, `minstok`,`addat`,`addby`) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
                    GetSQLValueString($koneksi, $kode, "text"),
                    GetSQLValueString($koneksi, $nama, "text"),
                    GetSQLValueString($koneksi, $hargamodal, "text"),
                    GetSQLValueString($koneksi, $hargajual, "text"),
                    GetSQLValueString($koneksi, $satuan, "text"),
                    GetSQLValueString($koneksi, $stok, "text"),
                    GetSQLValueString($koneksi, $kategori, "text"),
                    GetSQLValueString($koneksi, $ket, "text"),
                    GetSQLValueString($koneksi, $min, "text"),
                    GetSQLValueString($koneksi, time(), "text"),
                    GetSQLValueString($koneksi, 2, "int")
                );

                mysqli_select_db($koneksi, $database_koneksi);
                $Result1 = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));
                $no++;
            }
        }
        $html .= '</tbody></table>';
        ?>
        <div class='row'>
            <div class='col-md-12'>
                <div class='alert alert-success animated fadeIn'>Data Berhasil di import!</div>
                <div class='table-responsive'>
                    <?= $html ?>
                    Jumlah data : <?= $jumlah = --$no; ?>
                </div>
            </div>
        </div>

        <?php
        if ($Result1) {
            $commit = "COMMIT";
            mysqli_select_db($koneksi, $database_koneksi);
            $Result1 = mysqli_query($koneksi, $commit) or die(mysqli_error($koneksi));
        }
        ?>

        <div class="btn btn-primary btn-lg" onclick="window.location.href='?page=produk/cek_import';">
            Click here to Continue Import
        </div>
    <?php
    } else { ?>
        <div class='alert alert-danger animated fadeIn'>Data Gagal di import!</div>
    <?php } ?>
<?php } ?>

<?php if ($jumlah == 0) { ?>
    <div class='panel panel-default'>
        <div class='panel-heading'>
            <h3 class='panel-title'>Import Data produk</h3>
        </div>
        <div class='panel-body'>
            <form action='' method='post' enctype='multipart/form-data' name='form1' id='form1'>
                <label>Choose your file :
                    <input type='file' name='file' id='file' required />
                </label>
                <br />
                <br />
                <em>*)Pastikan Anda sudah memasukkan data kategori. ID Kategori bisa dilihat <a href="produk/_file/lihat-idkategori.JPG" target="_blank">di sini</a></em><br>
                <em>**)Pastikan data yang diimport sesuai template yang disediakan. <a href='produk/_file/produk.xlsx' target="_blank">Download Template</a></em>
                <p>
                    <input type='hidden' name='MM_insert' value='form1' />
                    <input type='submit' name='button' id='button' value='Import' class='btn btn-primary' />
                </p>
            </form>

        </div>
    <?php } ?>