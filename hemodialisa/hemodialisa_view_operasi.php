<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
$sql_operasi = 'SELECT t_operasi.OPERASI_ID,t_operasi.TANGGAL_ORDER,t_operasi.NO_ORDER,
				DATE_FORMAT(t_operasi.TANGGAL_RENCANA_OPERASI,"%d/%m/%Y") AS TANGGAL_RENCANA_OPERASI,
				DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
				DATE_FORMAT(t_operasi.JAM_OPERASI,"%H:%i") AS JAM_OPERASI,
				t_operasi.PEGAWAI_PELAKSANA_ID,t_operasi.PEGAWAI_ID,t_operasi.ST_APPROVE,
				t_operasi.KETERANGAN
				FROM t_operasi
				WHERE t_operasi.RAWAT_ID = "' . $irja_id . '"
				AND t_operasi.JNS_ORDER = "IRJ"';
$get_operasi = mysql_query($sql_operasi) or die(mysql_error());
$dat_operasi = mysql_fetch_assoc($get_operasi);
$tgl_rencana = $dat_operasi['TANGGAL_RENCANA_OPERASI']; 
$tgl_operasi = $dat_operasi['TANGGAL_OPERASI']; 
$jam_operasi = $dat_operasi['JAM_OPERASI'];
$dokter_operasi = $dat_operasi['PEGAWAI_PELAKSANA_ID'];
$st_approve = $dat_operasi['ST_APPROVE'];
$keterangan = $dat_operasi['KETERANGAN'];
$operasi_id = $dat_operasi['OPERASI_ID'];
$dokter_pengirim = $dat_operasi['PEGAWAI_ID'];
if(empty($dokter_pengirim)) $dokter_pengirim = $_SESSION['SES_SIMRS_PEGAWAI_ID'];
?>
    <table border="0" width="100%">
	<tr><td>
	<table border="0" width="100%">
	<tr>
    <td>&nbsp;</td>
    <td width="180">Dokter Pelaksana Operasi</td>
    <td width="200"><select name="dokter_operasi" id="dokter_operasi" style="width:228px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getDokter($dokter_operasi); ?>
                </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Tanggal Rencana Operasi</td>
    <td><input type="text" name="tgl_rencana" id="tgl_1" size="15" class="text_dt" value="<?php echo $tgl_rencana; ?>" />
	  </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="180">Dokter Pengirim</td>
    <td width="200"><select name="dokter_pengirim" id="dokter_pengirim" style="width:228px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getDokter($dokter_pengirim); ?>
                </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Status Permintaan Operasi</td>
    <td><input type="checkbox" name="st_operasi" value="1" size="60" class="text_dt" 
	<?php if($st_approve == '1') echo 'checked="checked"'; ?> />&nbsp;Diterima</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Tanggal Operasi</td>
    <td><input type="text" name="tgl_operasi" size="15" class="text_dt" value="<?php echo $tgl_operasi; ?>" readonly="readonly" /></td>
	<td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Jam Operasi</td>
    <td><input type="text" name="jam_operasi" size="15" class="text_dt" value="<?php echo $jam_operasi; ?>" readonly="readonly" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Keterangan</td>
    <td><textarea name="keterangan" rows="5" class="text_dt3" readonly="readonly"><?php echo $keterangan; ?></textarea></td>
    <td>&nbsp;</td>
  </tr>
  </table>
	</td>
	<td>
	</td></tr></table>