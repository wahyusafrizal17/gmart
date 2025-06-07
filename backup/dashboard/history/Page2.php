 <div class="box-footer clearfix">
    <div class="pull-left">
        Total Perubahan : <?= $totalRows_Produk; ?> 
    </div>
              <ul class="pagination pagination-sm no-margin pull-right">
                <li><?php if ($pageNum_Produk > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Produk=%d%s", $currentPage, 0, $queryString_Produk); ?>">Pertama</a>
        <?php } // Show if not first page ?>    </li>
                <li><?php if ($pageNum_Produk > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Produk=%d%s", $currentPage, max(0, $pageNum_Produk - 1), $queryString_Produk); ?>">Sebelumnya</a>
        <?php } // Show if not first page ?></li>
      
        <!-- LINK NUMBER -->
        <?php
        
        $jumlah_number = 3; // Tentukan jumlah link number sebelum dan sesudah page yang aktif
        $start_number = ($pageNum_Produk > $jumlah_number)? $pageNum_Produk - $jumlah_number : 1; // Untuk awal link number
        $end_number = ($pageNum_Produk < ($totalPages_Produk - $jumlah_number))? $pageNum_Produk + $jumlah_number : $totalPages_Produk; // Untuk akhir link number
        
        for($i = $start_number; $i <= $end_number; $i++){
          $link_active = ($pageNum_Produk == $i - 1)? ' class="active"' : '';
        ?>
          <li<?php echo $link_active; ?>><a href="<?php printf("%s?pageNum_Produk=%d%s", $currentPage, $i - 1, $queryString_Produk); ?>"><?php echo $i; ?></a></li>
        <?php } ?>
       
                <li><?php if ($pageNum_Produk < $totalPages_Produk) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Produk=%d%s", $currentPage, min($totalPages_Produk, $pageNum_Produk + 1), $queryString_Produk); ?>">Selanjutnya</a>
        <?php } // Show if not last page ?>   </li>
        		<li><?php if ($pageNum_Produk < $totalPages_Produk) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Produk=%d%s", $currentPage, $totalPages_Produk, $queryString_Produk); ?>">Terakhir</a>
        <?php } // Show if not last page ?> </li>
              </ul>
  </div>