<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
$irna_id = $_GET['idx'];

$qry_pemberian_obat = 'SELECT DISTINCT TANGGAL,JAM,CATATAN,HARGA,PERAWAT,ENTRY_DATA,FARMASI
					FROM t_irna_askep_pemberian_obat
					WHERE IRNA_ID = "' . $irna_id . '"';
$get_pemberian_obat = mysql_query($qry_pemberian_obat) or die(mysql_error());					
$dat_pemberian_obat = mysql_fetch_assoc($get_pemberian_obat);
$tanggal = explode('|',$dat_pemberian_obat['TANGGAL']);
$jam = explode('|',$dat_pemberian_obat['JAM']);
$catatan = $dat_pemberian_obat['CATATAN'];
$harga = explode('|',$dat_pemberian_obat['HARGA']);
$perawat = explode('|',$dat_pemberian_obat['PERAWAT']);
$entry_data = explode('|',$dat_pemberian_obat['ENTRY_DATA']);
$farmasi = explode('|',$dat_pemberian_obat['FARMASI']);

$pemberian_obat_id = '';
$dokter = '';
$nama_obat = '';
$dosis = '';
$aturan_pakai = '';
$keterangan = '';
?>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery("#obat").autocomplete("index.php?autocomp=autocompaskepfarmasi",{width: 450});
});
</script>
<div style="width:1250px;overflow:scroll;" >
<form name="formedukasi" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
    <table width="100%" border="1" class="tableData">
  <tr>
    <th rowspan="3">No</th>
    <th rowspan="3">Dokter</th>
    <th rowspan="3">Obat/ Injeksi </th>
    <th rowspan="3">Dosis</th>
    <th rowspan="3">Aturai Pakai </th>
    <th colspan="20">Jadwal Pemberian/ Tanggal </th>
    <th rowspan="3">Keterangan</th>
	<th rowspan="3" width="190px">Option</th>
  </tr>
  <tr>
    <th colspan="4"><input type="text" name="tanggal_1" id="tgl_edu_1" value="<?php if(isset($tanggal[0])) echo $tanggal[0]; ?>" class="text_dt" style="width:80px;" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu1')"/></th>
    <th colspan="4"><input type="text" name="tanggal_2" id="tgl_edu_2" value="<?php if(isset($tanggal[1])) echo $tanggal[1]; ?>" class="text_dt" style="width:80px;" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu2')"/></th>
    <th colspan="4"><input type="text" name="tanggal_3" id="tgl_edu_3" value="<?php if(isset($tanggal[2])) echo $tanggal[2]; ?>" class="text_dt" style="width:80px;" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu3')"/></th>
    <th colspan="4"><input type="text" name="tanggal_4" id="tgl_edu_4" value="<?php if(isset($tanggal[3])) echo $tanggal[3]; ?>" class="text_dt" style="width:80px;" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu4')"/></th>
    <th colspan="4"><input type="text" name="tanggal_5" id="tgl_edu_5" value="<?php if(isset($tanggal[4])) echo $tanggal[4]; ?>" class="text_dt" style="width:80px;" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu5')"/></th>
  </tr>
  <tr>
    <?php $x = 0; 
	while($x<20){ ?>
	<th align="center"><input type="text" name="jam_<?php echo $x+1; ?>" value="<?php if(isset($jam[$x])) echo $jam[$x]; ?>" class="text_dt" style="width:25px;" /></th>
    <?php $x++; } ?>
  </tr>
  <?php
  $qry_pemberian_obat_detail = 'SELECT PEMBERIAN_OBAT_ID,JADWAL,DOKTER,PERSEDIAAN_ID,NAMA_OBAT,DOSIS,ATURAN_PAKAI,KETERANGAN,NAMA_PEGAWAI
							FROM t_irna_askep_pemberian_obat
							LEFT JOIN m_pegawai ON (DOKTER = m_pegawai.PEGAWAI_ID)
							WHERE IRNA_ID = "' . $irna_id . '"';
  $get_pemberian_obat_detail = mysql_query($qry_pemberian_obat_detail) or die(mysql_error());
  $i = 1;
  while($dat_pemberian_obat_detail = mysql_fetch_array($get_pemberian_obat_detail)){ ?>
	<tr>
	<td align="center"><?php echo $i; ?><input type="hidden" name="pemberian_obat_id_<?php echo $i; ?>" value="<?php echo $dat_pemberian_obat_detail['PEMBERIAN_OBAT_ID']; ?>" /></td>
    <td><?php echo $dat_pemberian_obat_detail['NAMA_PEGAWAI']; ?></td>
    <td><?php echo $dat_pemberian_obat_detail['NAMA_OBAT']; ?></td>
	<td><?php echo $dat_pemberian_obat_detail['DOSIS']; ?></td>
    <td><?php echo $dat_pemberian_obat_detail['ATURAN_PAKAI']; ?></td>
	<?php $jadwal = explode('|',$dat_pemberian_obat_detail['JADWAL']); 
	$x = 0; 
	while($x<20){ 
	$n = $x + 1; ?>
	<td align="center"><input type="checkbox" name="jadwal_<?php echo $i . '_' . $n; ?>" value="1" <?php if(isset($jadwal[$x]) and $jadwal[$x] == '1') echo 'checked="checked"'; ?> /></td>
    <?php $x++; } ?>
	<td><?php echo $dat_pemberian_obat_detail['KETERANGAN']; ?></td>
    <td>
	<a href="<?php echo currentUrl(); ?>&idce=<?php echo $dat_pemberian_obat_detail['PEMBERIAN_OBAT_ID']; ?>&nmce=<?php echo $dat_pemberian_obat_detail['NAMA_OBAT']; ?>" >ubah</a>
	<a href="<?php echo currentUrl(); ?>&idc=<?php echo $dat_pemberian_obat_detail['PEMBERIAN_OBAT_ID']; ?>&nmc=<?php echo $dat_pemberian_obat_detail['NAMA_OBAT']; ?>" >hapus</a>
	</td>
	</tr>
  <?php $i++; }	?>	
  <tr>
    <td align="center"><?php echo $i; ?><input type="hidden" name="cn_obat" value="<?php echo $i; ?>" />
	<input type="hidden" name="pemberian_obat_id" value="<?php echo $pemberian_obat_id; ?>" /></td>
    <td><select name="dokter" class="text_dt" style="width:160px;">
	<option> - </option>
	<?php echo getDokter($dokter); ?>
	</select></td>
    <td><input type="text" name="nama_obat" id="obat" value="<?php echo $nama_obat; ?>" class="text_dt" style="width:160px;" /></td>
    <td><input type="text" name="dosis" value="<?php echo $dosis; ?>" class="text_dt" style="width:160px;" /></td>
    <td><input type="text" name="aturan_pakai" value="<?php echo $aturan_pakai; ?>" class="text_dt" style="width:160px;" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="text" name="keterangan" value="<?php echo $keterangan; ?>" class="text_dt" style="width:160px;" /></td>
	<td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Catatan</td>
    <td colspan="2">Pengisi (Farmasi) </td>
    <td colspan="4"><input type="text" name="farmasi_1" id="farmasi_1" value="<?php if(isset($farmasi[0])) echo $farmasi[0]; ?>" class="text_dt" style="width:200px;" /></td>
    <td colspan="4"><input type="text" name="farmasi_2" id="farmasi_2" value="<?php if(isset($farmasi[1])) echo $farmasi[1]; ?>" class="text_dt" style="width:200px;" /></td>
    <td colspan="4"><input type="text" name="farmasi_3" id="farmasi_3" value="<?php if(isset($farmasi[2])) echo $farmasi[2]; ?>" class="text_dt" style="width:200px;" /></td>
    <td colspan="4"><input type="text" name="farmasi_4" id="farmasi_4" value="<?php if(isset($farmasi[3])) echo $farmasi[3]; ?>" class="text_dt" style="width:200px;" /></td>
    <td colspan="4"><input type="text" name="farmasi_5" id="farmasi_5" value="<?php if(isset($farmasi[4])) echo $farmasi[4]; ?>" class="text_dt" style="width:200px;" /></td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" rowspan="3">
	<textarea name="catatan" class="text_dt6" ><?php echo $catatan; ?></textarea>
	</td>
    <td colspan="2">Entry Data </td>
    <td colspan="4"><input type="text" name="entry_data_1" id="entry_data_1" value="<?php if(isset($entry_data[0])) echo $entry_data[0]; ?>" class="text_dt" style="width:200px;" /></td>
    <td colspan="4"><input type="text" name="entry_data_2" id="entry_data_2" value="<?php if(isset($entry_data[1])) echo $entry_data[1]; ?>" class="text_dt" style="width:200px;" /></td>
    <td colspan="4"><input type="text" name="entry_data_3" id="entry_data_3" value="<?php if(isset($entry_data[2])) echo $entry_data[2]; ?>" class="text_dt" style="width:200px;" /></td>
    <td colspan="4"><input type="text" name="entry_data_4" id="entry_data_4" value="<?php if(isset($entry_data[3])) echo $entry_data[3]; ?>" class="text_dt" style="width:200px;" /></td>
    <td colspan="4"><input type="text" name="entry_data_5" id="entry_data_5" value="<?php if(isset($entry_data[4])) echo $entry_data[4]; ?>" class="text_dt" style="width:200px;" /></td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Subtotal (Rp) </td>
    <td colspan="4"><input type="text" name="harga_1" id="harga_1" value="<?php if(isset($harga[0])) echo $harga[0]; ?>" class="text_dt" style="width:200px;" /></td>
    <td colspan="4"><input type="text" name="harga_2" id="harga_2" value="<?php if(isset($harga[1])) echo $harga[1]; ?>" class="text_dt" style="width:200px;" /></td>
    <td colspan="4"><input type="text" name="harga_3" id="harga_3" value="<?php if(isset($harga[2])) echo $harga[2]; ?>" class="text_dt" style="width:200px;" /></td>
    <td colspan="4"><input type="text" name="harga_4" id="harga_4" value="<?php if(isset($harga[3])) echo $harga[3]; ?>" class="text_dt" style="width:200px;" /></td>
    <td colspan="4"><input type="text" name="harga_5" id="harga_5" value="<?php if(isset($harga[4])) echo $harga[4]; ?>" class="text_dt" style="width:200px;" /></td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Perawat</td>
	<?php $x = 0; 
	while($x<20){ ?>
	<td>
	<select name="perawat_<?php echo $x+1; ?>" id="perawat_<?php echo $x+1; ?>" class="text_dt" style="width:40px;">
	<option> - </option>
	<?php if(isset($perawat[$x])) $xperawat = $perawat[$x]; 
	echo getPerawat($xperawat); ?>
	</select></td>
    <?php $x++; } ?>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
    <tr>
            <td colspan="27" align="right">
			&nbsp;
			</td>	
        </tr>
</table>
</form>
</div>