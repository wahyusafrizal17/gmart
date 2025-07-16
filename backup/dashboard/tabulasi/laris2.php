<div class="box-footer clearfix">
    <div class="pull-left">
        Total Produk : <?= $totalRows_Terlaris; ?> 
    </div>
              <ul class="pagination pagination-sm no-margin pull-right">
                <li><?php if ($pageNum_Terlaris > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Terlaris=%d%s", $currentPage, 0, $queryString_Terlaris); ?>">Pertama</a>
        <?php } // Show if not first page ?>    </li>
                <li><?php if ($pageNum_Terlaris > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Terlaris=%d%s", $currentPage, max(0, $pageNum_Terlaris - 1), $queryString_Terlaris); ?>">Sebelumnya</a>
        <?php } // Show if not first page ?></li>
      
        <!-- LINK NUMBER -->
        <?php
        
        $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
        $start_number = ($pageNum_Terlaris > $jumlah_number)? $pageNum_Terlaris - $jumlah_number : 1; // Untuk awal link number
        $end_number = ($pageNum_Terlaris < ($totalPages_Terlaris - $jumlah_number))? $pageNum_Terlaris + $jumlah_number : $totalPages_Terlaris; // Untuk akhir link number
        
        for($i = $start_number; $i <= $end_number; $i++){
          $link_active = ($pageNum_Terlaris == $i - 1)? ' class="active"' : '';
        ?>
          <li<?php echo $link_active; ?>><a href="<?php printf("%s?pageNum_Terlaris=%d%s", $currentPage, $i - 1, $queryString_Terlaris); ?>"><?php echo $i; ?></a></li>
        <?php } ?>
       
                <li><?php if ($pageNum_Terlaris < $totalPages_Terlaris) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Terlaris=%d%s", $currentPage, min($totalPages_Terlaris, $pageNum_Terlaris + 1), $queryString_Terlaris); ?>">Selanjutnya</a>
        <?php } // Show if not last page ?>   </li>
        		<li><?php if ($pageNum_Terlaris < $totalPages_Terlaris) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Terlaris=%d%s", $currentPage, $totalPages_Terlaris, $queryString_Terlaris); ?>">Terakhir</a>
        <?php } // Show if not last page ?> </li>
              </ul>
  </div>