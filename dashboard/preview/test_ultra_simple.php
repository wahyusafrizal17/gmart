<?php
// Include koneksi.php terlebih dahulu untuk mendapatkan fungsi GetSQLValueString
if (file_exists('../../Connections/koneksi.php')) {
    require_once('../../Connections/koneksi.php');
} elseif (file_exists('../Connections/koneksi.php')) {
    require_once('../Connections/koneksi.php');
} elseif (file_exists('Connections/koneksi.php')) {
    require_once('Connections/koneksi.php');
}

echo "<h2>Test Query Ultra Sederhana</h2>";

// Parameter test
$tgl1 = '2025-07-31';
$tgl2 = '2025-08-06';
$kat = 4;

echo "<p>Parameter: tgl1=$tgl1, tgl2=$tgl2, kategori=$kat</p>";

// Test query ultra sederhana
echo "<h3>Test Query Ultra Sederhana:</h3>";
$query_test = "SELECT DISTINCT f.idfaktur, f.tglfaktur, f.kodefaktur, f.addedfaktur, f.addbyfaktur, f.periode, f.datetimefaktur, f.kembalian, f.potongan, f.totalbayar, 
(f.totalbayar - f.kembalian) AS totalbelanja, f.statusfaktur, f.qtyprint, f.printby, f.adminfaktur, f.namapelanggan 
FROM faktur f 
INNER JOIN transaksidetail td ON f.kodefaktur = td.faktur
INNER JOIN produk p ON td.nama = p.namaproduk
WHERE (f.tglfaktur BETWEEN '$tgl1' AND '$tgl2') AND f.statusfaktur = 'Y' AND p.kategori = $kat
ORDER BY f.idfaktur DESC
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

// Test query pendapatan
echo "<h3>Test Query Pendapatan:</h3>";
$query_pendapatan = "SELECT SUM(f.totalbayar - f.kembalian) AS pendapatan 
FROM faktur f 
INNER JOIN transaksidetail td ON f.kodefaktur = td.faktur
INNER JOIN produk p ON td.nama = p.namaproduk
WHERE (f.tglfaktur BETWEEN '$tgl1' AND '$tgl2') AND f.statusfaktur = 'Y' AND p.kategori = $kat";

$result2 = mysqli_query($koneksi, $query_pendapatan);
if ($result2) {
    $row = mysqli_fetch_assoc($result2);
    echo "Total Pendapatan: " . number_format($row['pendapatan']) . "<br>";
} else {
    echo "Error: " . mysqli_error($koneksi);
}

// Test query laba
echo "<h3>Test Query Laba:</h3>";
$query_laba = "SELECT SUM(((td.harga * td.qty) - (td.hargadasar * td.qty)) - td.diskon) AS laba
FROM transaksidetail td
INNER JOIN faktur f ON td.faktur = f.kodefaktur
INNER JOIN produk p ON td.nama = p.namaproduk
WHERE (f.tglfaktur BETWEEN '$tgl1' AND '$tgl2') AND f.statusfaktur = 'Y' AND p.kategori = $kat";

$result3 = mysqli_query($koneksi, $query_laba);
if ($result3) {
    $row = mysqli_fetch_assoc($result3);
    echo "Total Laba: " . number_format($row['laba']) . "<br>";
} else {
    echo "Error: " . mysqli_error($koneksi);
}

echo "<hr>";
echo "<h3>Kesimpulan</h3>";
echo "Jika query ini berhasil, maka versi ultra sederhana akan bekerja dengan baik.<br>";
echo "Query ini menggunakan INNER JOIN langsung tanpa subquery yang kompleks.<br>";
echo "Ini akan menghindari masalah website ngeblank karena query yang terlalu kompleks.<br>";
?> 