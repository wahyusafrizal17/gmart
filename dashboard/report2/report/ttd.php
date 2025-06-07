<style type="text/css">
 
</style>
<table width="100%">
  <tr>
    <td width="22%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td width="12%">&nbsp;</td>
    <td width="35%">&nbsp;</td>
    <td width="29%">
      <div align="left">
        <?= $kota; ?>
        , 
        <?= date("d F Y", time()) ;?>
      </div></td>
  </tr>
  <tr>
    <td height="21">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="left">Diketahui oleh,</div></td>
  </tr>
  <tr>
    <td height="50">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="left"></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="left"><strong>
      <?= $pimpinan; ?>
    </strong></div></td>
  </tr>
  <tr>
    <td colspan="4"><span class="style1">Tanggal Cetak :
      <?= date("d F Y H:i:s", time()) ;?>
      | Dicetak oleh :
        <?= $nama;?>
</span></td>
    <td><div align="left">
      <?= $jabatan; ?>
    </div></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
</table>
