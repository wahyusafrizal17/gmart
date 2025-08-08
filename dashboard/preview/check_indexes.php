<?php
// Include koneksi.php
if (file_exists('../../Connections/koneksi.php')) {
    require_once('../../Connections/koneksi.php');
} elseif (file_exists('../Connections/koneksi.php')) {
    require_once('../Connections/koneksi.php');
} elseif (file_exists('Connections/koneksi.php')) {
    require_once('Connections/koneksi.php');
}

// Fungsi untuk mengecek index yang sudah ada
function checkIndexes($koneksi, $table) {
    $query = "SHOW INDEX FROM $table";
    $result = mysqli_query($koneksi, $query);
    
    if (!$result) {
        return array();
    }
    
    $indexes = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $indexes[] = $row;
    }
    
    return $indexes;
}

// Fungsi untuk mengecek performance query
function checkQueryPerformance($koneksi, $query) {
    $explain_query = "EXPLAIN $query";
    $result = mysqli_query($koneksi, $explain_query);
    
    if (!$result) {
        return "Error: " . mysqli_error($koneksi);
    }
    
    $performance = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $performance[] = $row;
    }
    
    return $performance;
}

// Tabel yang perlu dicek
$tables = array('faktur', 'transaksidetail', 'produk', 'kategori', 'pengeluaran', 'kassa', 'tb_ta');

echo "<h2>🔍 ANALISIS INDEX DATABASE</h2>";
echo "<p>File ini untuk mengecek index yang sudah ada dan memberikan rekomendasi optimasi.</p>";

// Cek index untuk setiap tabel
foreach ($tables as $table) {
    echo "<h3>📋 Tabel: $table</h3>";
    
    $indexes = checkIndexes($koneksi, $table);
    
    if (empty($indexes)) {
        echo "<p style='color: red;'>❌ Tidak ada index yang ditemukan!</p>";
    } else {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background-color: #f0f0f0;'>";
        echo "<th>Index Name</th>";
        echo "<th>Column Name</th>";
        echo "<th>Non Unique</th>";
        echo "<th>Seq In Index</th>";
        echo "<th>Cardinality</th>";
        echo "</tr>";
        
        foreach ($indexes as $index) {
            echo "<tr>";
            echo "<td>" . $index['Key_name'] . "</td>";
            echo "<td>" . $index['Column_name'] . "</td>";
            echo "<td>" . $index['Non_unique'] . "</td>";
            echo "<td>" . $index['Seq_in_index'] . "</td>";
            echo "<td>" . $index['Cardinality'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    echo "<br>";
}

// Rekomendasi index berdasarkan query yang digunakan
echo "<h2>🚀 REKOMENDASI INDEX</h2>";

echo "<h3>1. Index untuk Tabel FAKTUR</h3>";
echo "<ul>";
echo "<li><strong>idx_faktur_tglfaktur</strong> - Untuk filter tanggal (BETWEEN)</li>";
echo "<li><strong>idx_faktur_statusfaktur</strong> - Untuk filter status faktur</li>";
echo "<li><strong>idx_faktur_addbyfaktur</strong> - Untuk filter kasir</li>";
echo "<li><strong>idx_faktur_jenisbayar</strong> - Untuk filter jenis bayar</li>";
echo "<li><strong>idx_faktur_periode</strong> - Untuk filter periode</li>";
echo "<li><strong>idx_faktur_status_kasir_tgl_periode</strong> - Composite index untuk kombinasi yang sering digunakan</li>";
echo "<li><strong>idx_faktur_status_jenis_kasir_tgl_periode</strong> - Composite index untuk semua filter</li>";
echo "<li><strong>idx_faktur_idfaktur_desc</strong> - Untuk sorting ORDER BY idfaktur DESC</li>";
echo "</ul>";

echo "<h3>2. Index untuk Tabel TRANSAKSIDETAIL</h3>";
echo "<ul>";
echo "<li><strong>idx_transaksidetail_nama</strong> - Untuk JOIN dengan produk</li>";
echo "<li><strong>idx_transaksidetail_tanggal</strong> - Untuk filter tanggal</li>";
echo "<li><strong>idx_transaksidetail_periode</strong> - Untuk filter periode</li>";
echo "<li><strong>idx_transaksidetail_faktur_nama</strong> - Composite index untuk faktur + nama (sangat penting)</li>";
echo "</ul>";

echo "<h3>3. Index untuk Tabel PRODUK</h3>";
echo "<ul>";
echo "<li><strong>idx_produk_namaproduk</strong> - Untuk JOIN dengan transaksidetail</li>";
echo "<li><strong>idx_produk_kategori_namaproduk</strong> - Composite index untuk kategori + namaproduk</li>";
echo "</ul>";

echo "<h3>4. Index untuk Tabel Lainnya</h3>";
echo "<ul>";
echo "<li><strong>idx_pengeluaran_tgl</strong> - Untuk filter tanggal pengeluaran</li>";
echo "<li><strong>idx_kassa_id</strong> - Untuk JOIN dengan faktur.addbyfaktur</li>";
echo "<li><strong>idx_tb_ta_kode_ta</strong> - Untuk JOIN dengan faktur.periode</li>";
echo "</ul>";

// Query untuk testing performance
echo "<h2>🧪 TESTING PERFORMANCE</h2>";

// Contoh query yang sering digunakan
$test_queries = array(
    "Query dengan filter kategori" => "
        SELECT idfaktur, tglfaktur, kodefaktur, addbyfaktur, periode, datetimefaktur, 
               kembalian, potongan, totalbayar, (totalbayar - kembalian) AS totalbelanja, 
               statusfaktur, adminfaktur, namapelanggan 
        FROM faktur 
        WHERE statusfaktur = 'Y' AND addbyfaktur = 1 AND (tglfaktur BETWEEN '2025-07-01' AND '2025-08-07') 
              AND periode = '2025' 
              AND kodefaktur IN (
                  SELECT DISTINCT faktur 
                  FROM transaksidetail td 
                  INNER JOIN produk p ON td.nama = p.namaproduk 
                  WHERE p.kategori = 4
              )
        ORDER BY idfaktur DESC 
        LIMIT 0, 10
    ",
    
    "Query laba dengan JOIN" => "
        SELECT SUM(((td.harga * td.qty) - (td.hargadasar * td.qty)) - td.diskon) AS laba 
        FROM transaksidetail td
        INNER JOIN faktur f ON td.faktur = f.kodefaktur
        INNER JOIN produk p ON td.nama = p.namaproduk
        WHERE f.statusfaktur = 'Y' AND f.addbyfaktur = 1 
              AND (f.tglfaktur BETWEEN '2025-07-01' AND '2025-08-07') 
              AND f.periode = '2025' AND p.kategori = 4
    "
);

foreach ($test_queries as $title => $query) {
    echo "<h4>$title</h4>";
    echo "<pre style='background-color: #f5f5f5; padding: 10px; border-radius: 5px;'>";
    echo htmlspecialchars($query);
    echo "</pre>";
    
    // Cek performance (jika ada data)
    $performance = checkQueryPerformance($koneksi, $query);
    if (is_array($performance)) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%; margin-top: 10px;'>";
        echo "<tr style='background-color: #e0e0e0;'>";
        echo "<th>id</th>";
        echo "<th>select_type</th>";
        echo "<th>table</th>";
        echo "<th>type</th>";
        echo "<th>possible_keys</th>";
        echo "<th>key</th>";
        echo "<th>key_len</th>";
        echo "<th>ref</th>";
        echo "<th>rows</th>";
        echo "<th>Extra</th>";
        echo "</tr>";
        
        foreach ($performance as $row) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['select_type'] . "</td>";
            echo "<td>" . $row['table'] . "</td>";
            echo "<td>" . $row['type'] . "</td>";
            echo "<td>" . $row['possible_keys'] . "</td>";
            echo "<td>" . $row['key'] . "</td>";
            echo "<td>" . $row['key_len'] . "</td>";
            echo "<td>" . $row['ref'] . "</td>";
            echo "<td>" . $row['rows'] . "</td>";
            echo "<td>" . $row['Extra'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: red;'>$performance</p>";
    }
    
    echo "<br><br>";
}

echo "<h2>📝 LANGKAH SELANJUTNYA</h2>";
echo "<ol>";
echo "<li>Jalankan file <strong>optimize_indexes.sql</strong> di database MySQL</li>";
echo "<li>Test performance query sebelum dan sesudah menambah index</li>";
echo "<li>Monitor penggunaan index dengan <code>EXPLAIN</code></li>";
echo "<li>Backup database sebelum menambah index</li>";
echo "<li>Jalankan pada waktu low traffic</li>";
echo "</ol>";

echo "<h2>⚠️ PERINGATAN</h2>";
echo "<ul>";
echo "<li>Index akan mempercepat SELECT tapi memperlambat INSERT/UPDATE/DELETE</li>";
echo "<li>Index memakan ruang disk tambahan</li>";
echo "<li>Index harus di-maintain oleh MySQL</li>";
echo "<li>Test di environment development dulu</li>";
echo "</ul>";

echo "<h2>🔗 LINK PENTING</h2>";
echo "<ul>";
echo "<li><a href='optimize_indexes.sql' target='_blank'>Download SQL Index Optimization</a></li>";
echo "<li><a href='?page=preview/penjualan' target='_blank'>Test Query Performance</a></li>";
echo "</ul>";
?>
