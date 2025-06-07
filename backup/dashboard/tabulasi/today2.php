 <div class="box-footer clearfix">
    <div class="pull-left">
        Total Faktur Penjualan : <?= $totalRows_Penjualan; ?> 
    </div>
              <ul class="pagination pagination-sm no-margin pull-right">
                <li><?php if ($pageNum_Penjualan > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Penjualan=%d%s", $currentPage, 0, $queryString_Penjualan); ?>">Pertama</a>
        <?php } // Show if not first page ?>    </li>
                <li><?php if ($pageNum_Penjualan > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Penjualan=%d%s", $currentPage, max(0, $pageNum_Penjualan - 1), $queryString_Penjualan); ?>">Sebelumnya</a>
        <?php } // Show if not first page ?></li>
      
        <!-- LINK NUMBER -->
        <?php
        
        $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
        $start_number = ($pageNum_Penjualan > $jumlah_number)? $pageNum_Penjualan - $jumlah_number : 1; // Untuk awal link number
        $end_number = ($pageNum_Penjualan < ($totalPages_Penjualan - $jumlah_number))? $pageNum_Penjualan + $jumlah_number : $totalPages_Penjualan; // Untuk akhir link number
        
        for($i = $start_number; $i <= $end_number; $i++){
          $link_active = ($pageNum_Penjualan == $i - 1)? ' class="active"' : '';
        ?>
          <li<?php echo $link_active; ?>><a href="<?php printf("%s?pageNum_Penjualan=%d%s", $currentPage, $i - 1, $queryString_Penjualan); ?>"><?php echo $i; ?></a></li>
        <?php } ?>
       
                <li><?php if ($pageNum_Penjualan < $totalPages_Penjualan) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Penjualan=%d%s", $currentPage, min($totalPages_Penjualan, $pageNum_Penjualan + 1), $queryString_Penjualan); ?>">Selanjutnya</a>
        <?php } // Show if not last page ?>   </li>
        		<li><?php if ($pageNum_Penjualan < $totalPages_Penjualan) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Penjualan=%d%s", $currentPage, $totalPages_Penjualan, $queryString_Penjualan); ?>">Terakhir</a>
        <?php } // Show if not last page ?> </li>
              </ul>
  </div>