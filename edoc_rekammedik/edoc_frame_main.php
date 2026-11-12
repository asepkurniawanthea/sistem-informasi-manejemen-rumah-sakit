<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-top: 1px solid #000000;" >
  <tr>
    <td width="340px" style="border-bottom: 1px solid #000000;border-left: 1px solid #000000;">
	<img src="<?php echo $edoc_logo; ?>" height="77" />
	</td>
    <td rowspan="2" height="140" style="border-bottom: 1px solid #000000; border-right: 1px solid #000000; border-left: 1px solid #000000;" >
		<table width="100%" height="100%" border="0" cellpadding="1" cellspacing="1">
      <tr>
        <td width="150px">&nbsp;Nomor RM </td>
        <td>:&nbsp;<?php echo $edoc_norm; ?></td>
      </tr>
      <tr>
        <td>&nbsp;Nama</td>
        <td>:&nbsp;<?php echo strtoupper($edoc_nama_pasien); ?></td>
      </tr>
      <tr>
        <td>&nbsp;Tanggal Lahir </td>
        <td>:&nbsp;<?php echo $edoc_tanggal_lahir; ?></td>
      </tr>
      <tr>
        <td>&nbsp;Jenis Kelamin </td>
        <td>:&nbsp;<?php echo $edoc_jenis_kelamin; ?></td>
      </tr>
      <tr>
        <td>&nbsp;Klinik/ Ruang/ Kelas </td>
        <td>:&nbsp;<?php echo $edoc_unit; ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
  <td align="center" height="60" style="valign:middle; border-bottom: 1px solid #000000;border-left: 1px solid #000000;"
	><h3><?php echo $edoc_nama_documen; ?></h3></td>    
  </tr>
  <tr>
    <td colspan="2"><?php echo $edoc_content; ?></td>
  </tr>
</table>