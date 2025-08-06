<?php
require_once('../require/header.php');

$tgl1 = '2025-07-31';
$tgl2 = '2025-08-06';
$kat = 4;

echo "<h3>Test Query dengan Join Condition yang Diperbaiki</h3>";

// Test query dengan multiple join conditions
$query_test = "SELECT DISTINCT a.idfaktur, a.tglfaktur, a.kodefaktur, a.addedfaktur, a.addbyfaktur, a.periode, a.datetimefaktur, a.kembalian, a.potongan, a.totalbayar, 
(SELECT SUM(b2.harga * b2.qty) FROM transaksidetail b2 
 INNER JOIN produk c2 ON (b2.nama = c2.namaproduk OR b2.kode = c2.kodeproduk OR TRIM(b2.nama) = TRIM(c2.namaproduk)) 
 WHERE b2.faktur = a.kodefaktur AND c2.kategori = $kat) AS totalbelanja,
a.statusfaktur, a.qtyprint, a.printby, a.adminfaktur, a.namapelanggan 
FROM faktur a 
WHERE (a.tglfaktur BETWEEN '$tgl1' AND '$tgl2') AND a.statusfaktur = 'Y' 
AND EXISTS (SELECT 1 FROM transaksidetail b 
           INNER JOIN produk c ON (b.nama = c.namaproduk OR b.kode = c.kodeproduk OR TRIM(b.nama) = TRIM(c.namaproduk)) 
           WHERE b.faktur = a.kodefaktur AND c.kategori = $kat)
ORDER BY a.idfaktur DESC
LIMIT 5";

echo "<h4>Query yang diuji:</h4>";
echo "<pre>" . htmlspecialchars($query_test) . "</pre>";

$result = mysqli_query($koneksi, $query_test);
if ($result) {
    echo "<h4>Hasil Query:</h4>";
    $count = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $count++;
        echo "Data $count: Kode Faktur: " . $row['kodefaktur'] . ", Tanggal: " . $row['tglfaktur'] . ", Total: " . $row['totalbelanja'] . "<br>";
    }
    if ($count == 0) {
        echo "Tidak ada data yang ditemukan.<br>";
    }
} else {
    echo "Error: " . mysqli_error($koneksi);
}

// Test data spesifik untuk faktur 1753971822
echo "<h4>Test Data Spesifik untuk Faktur 1753971822:</h4>";
$query_specific = "SELECT td.faktur, td.nama as td_nama, td.kode as td_kode, 
                   p.namaproduk as p_nama, p.kodeproduk as p_kode, p.kategori
                   FROM transaksidetail td 
                   LEFT JOIN produk p ON (td.nama = p.namaproduk OR td.kode = p.kodeproduk OR TRIM(td.nama) = TRIM(p.namaproduk))
                   WHERE td.faktur = '1753971822'";

$result2 = mysqli_query($koneksi, $query_specific);
if ($result2) {
    while ($row = mysqli_fetch_assoc($result2)) {
        echo "Faktur: " . $row['faktur'] . "<br>";
        echo "TD Nama: '" . $row['td_nama'] . "'<br>";
        echo "TD Kode: '" . $row['td_kode'] . "'<br>";
        echo "P Nama: '" . $row['p_nama'] . "'<br>";
        echo "P Kode: '" . $row['p_kode'] . "'<br>";
        echo "Kategori: " . $row['kategori'] . "<br>";
        echo "<hr>";
    }
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?> 