 <div class="box-footer clearfix">
    <div class="pull-left">
        Total Produk : <?= $totalRows_Kategori; ?> 
    </div>
              <ul class="pagination pagination-sm no-margin pull-right">
                <li><?php if ($pageNum_Kategori > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Kategori=%d%s", $currentPage, 0, $queryString_Kategori); ?>">Pertama</a>
        <?php } // Show if not first page ?>    </li>
                <li><?php if ($pageNum_Kategori > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Kategori=%d%s", $currentPage, max(0, $pageNum_Kategori - 1), $queryString_Kategori); ?>">Sebelumnya</a>
        <?php } // Show if not first page ?></li>
      
        <!-- LINK NUMBER -->
        <?php
        
        $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
        $start_number = ($pageNum_Kategori > $jumlah_number)? $pageNum_Kategori - $jumlah_number : 1; // Untuk awal link number
        $end_number = ($pageNum_Kategori < ($totalPages_Kategori - $jumlah_number))? $pageNum_Kategori + $jumlah_number : $totalPages_Kategori; // Untuk akhir link number
        
        for($i = $start_number; $i <= $end_number; $i++){
          $link_active = ($pageNum_Kategori == $i - 1)? ' class="active"' : '';
        ?>
          <li<?php echo $link_active; ?>><a href="<?php printf("%s?pageNum_Kategori=%d%s", $currentPage, $i - 1, $queryString_Kategori); ?>"><?php echo $i; ?></a></li>
        <?php } ?>
       
                <li><?php if ($pageNum_Kategori < $totalPages_Kategori) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Kategori=%d%s", $currentPage, min($totalPages_Kategori, $pageNum_Kategori + 1), $queryString_Kategori); ?>">Selanjutnya</a>
        <?php } // Show if not last page ?>   </li>
        		<li><?php if ($pageNum_Kategori < $totalPages_Kategori) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Kategori=%d%s", $currentPage, $totalPages_Kategori, $queryString_Kategori); ?>">Terakhir</a>
        <?php } // Show if not last page ?> </li>
              </ul>
  </div>