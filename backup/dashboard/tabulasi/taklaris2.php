<div class="box-footer clearfix">
    <div class="pull-left">
        Total Produk : <?= $totalRows_TakTerlaris; ?> 
    </div>
              <ul class="pagination pagination-sm no-margin pull-right">
                <li><?php if ($pageNum_TakTerlaris > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_TakTerlaris=%d%s", $currentPage, 0, $queryString_TakTerlaris); ?>">Pertama</a>
        <?php } // Show if not first page ?>    </li>
                <li><?php if ($pageNum_TakTerlaris > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_TakTerlaris=%d%s", $currentPage, max(0, $pageNum_TakTerlaris - 1), $queryString_TakTerlaris); ?>">Sebelumnya</a>
        <?php } // Show if not first page ?></li>
      
        <!-- LINK NUMBER -->
        <?php
        
        $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
        $start_number = ($pageNum_TakTerlaris > $jumlah_number)? $pageNum_TakTerlaris - $jumlah_number : 1; // Untuk awal link number
        $end_number = ($pageNum_TakTerlaris < ($totalPages_TakTerlaris - $jumlah_number))? $pageNum_TakTerlaris + $jumlah_number : $totalPages_TakTerlaris; // Untuk akhir link number
        
        for($i = $start_number; $i <= $end_number; $i++){
          $link_active = ($pageNum_TakTerlaris == $i - 1)? ' class="active"' : '';
        ?>
          <li<?php echo $link_active; ?>><a href="<?php printf("%s?pageNum_TakTerlaris=%d%s", $currentPage, $i - 1, $queryString_TakTerlaris); ?>"><?php echo $i; ?></a></li>
        <?php } ?>
       
                <li><?php if ($pageNum_TakTerlaris < $totalPages_TakTerlaris) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_TakTerlaris=%d%s", $currentPage, min($totalPages_TakTerlaris, $pageNum_TakTerlaris + 1), $queryString_TakTerlaris); ?>">Selanjutnya</a>
        <?php } // Show if not last page ?>   </li>
        		<li><?php if ($pageNum_TakTerlaris < $totalPages_TakTerlaris) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_TakTerlaris=%d%s", $currentPage, $totalPages_TakTerlaris, $queryString_TakTerlaris); ?>">Terakhir</a>
        <?php } // Show if not last page ?> </li>
              </ul>
  </div>