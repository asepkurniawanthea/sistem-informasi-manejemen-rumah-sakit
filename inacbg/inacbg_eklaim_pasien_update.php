<?php
if(isset($_GET['nomr']) && isset($_GET['nosep']) && isset($_GET['idx']) && isset($_GET['jnsrawat']) && isset($_GET['mh'])){
	
$idx_rawat = $_GET['idx'];
$svrmh = $_GET['mh'];
$jns_rawat = $_GET['jnsrawat'];

if($jns_rawat == '2'){
	$sql_simrs = 'SELECT t_irja.IRJA_ID,t_irja.NO_PESERTA,t_irja.NO_SEP,t_irja.NOMR,m_pasien.NAMA_PASIEN,
				CONCAT(DATE_FORMAT(m_pasien.TGL_LAHIR,"%Y-%m-%d")," 12:00:00") AS TGL_LAHIR,
				CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN "1" ELSE "2" END AS JNS_KELAMIN
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				WHERE t_irja.IRJA_ID = "' . $idx_rawat . '"';
}else{
	$sql_simrs = 'SELECT t_irna.IRNA_ID,t_irna.NO_PESERTA,t_irna.NO_SEP,t_irna.NOMR,m_pasien.NAMA_PASIEN,
				CONCAT(DATE_FORMAT(m_pasien.TGL_LAHIR,"%Y-%m-%d")," 12:00:00") AS TGL_LAHIR,
				CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN "1" ELSE "2" END AS JNS_KELAMIN
				FROM t_irna
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				WHERE t_irna.IRNA_ID = "' . $idx_rawat . '"';
}				
$get_simrs = mysql_query($sql_simrs) or die(mysql_error());
$dat_simrs = mysql_fetch_assoc($get_simrs);

$simrs_nomor_kartu = $dat_simrs['NO_PESERTA'];
$simrs_nomor_rm = $dat_simrs['NOMR'];
$simrs_nama_pasien = $dat_simrs['NAMA_PASIEN'];
$simrs_tgl_lahir = $dat_simrs['TGL_LAHIR'];
$simrs_gender = $dat_simrs['JNS_KELAMIN'];
$simrs_nomor_sep = $dat_simrs['NO_SEP'];

$sql_claim = 'SELECT RAWAT_ID,NO_PESERTA,NO_SEP,NOMR,NAMA_PASIEN,
				CONCAT(DATE_FORMAT(TGL_LAHIR,"%Y-%m-%d")," 12:00:00") AS TGL_LAHIR,JNS_KELAMIN,JNS_RAWAT
				FROM t_cbg_claim
				WHERE RAWAT_ID = "' . $idx_rawat . '" AND JNS_RAWAT = "' . $jns_rawat . '"';
$get_claim = mysql_query($sql_claim) or die(mysql_error());
$dat_claim = mysql_fetch_assoc($get_claim);

$claim_nomor_kartu = $dat_claim['NO_PESERTA'];
$claim_nomor_rm = $dat_claim['NOMR'];
$claim_nama_pasien = $dat_claim['NAMA_PASIEN'];
$claim_tgl_lahir = $dat_claim['TGL_LAHIR'];
$claim_gender = $dat_claim['JNS_KELAMIN'];
$claim_nomor_sep = $dat_claim['NO_SEP'];
?>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table width="100%" border="0">
	<!--<tr>
		<td colspan="6">DATA PASIEN PADA E-KLAIM</td>
	</tr>
	<tr>
		<td>Nomor Kartu</td><td>:</td><td><?php echo $claim_nomor_kartu; ?></td>
		<td>Nomor MR</td><td>:</td><td><?php echo $claim_nomor_rm; ?></td>
	</tr>
	<tr>
		<td>Nama Pasien</td><td>:</td><td><?php echo $claim_nama_pasien; ?></td>
		<td>Tanggal Lahir</td><td>:</td><td><?php echo $claim_tgl_lahir; ?></td>
	</tr>
	<tr>
		<td>Jenis Kelamin</td><td>:</td><td><?php echo $claim_gender; ?></td>
		<td>Nomor SEP</td><td>:</td><td><?php echo $claim_nomor_sep; ?></td>
	</tr>
	<tr>
		<td colspan="6">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="6">DATA PASIEN PADA SIMRS</td>
	</tr>-->
	<tr>
		<td>Nomor Kartu</td><td>:</td><td><input type="text" name="nomor_kartu" id="nomor_kartu" value="<?php echo $simrs_nomor_kartu; ?>" class="text_dt" size="30"/></td>
		<td>Nomor MR</td><td>:</td><td><input type="text" name="nomor_rm" id="nomor_rm" value="<?php echo $simrs_nomor_rm; ?>" class="text_dt" size="30"/></td>
	</tr>
	<tr>
		<td>Nama Pasien</td><td>:</td><td><input type="text" name="nama_pasien" id="nama_pasien" value="<?php echo $simrs_nama_pasien; ?>" class="text_dt" size="30"/></td>
		<td>Tanggal Lahir</td><td>:</td><td><input type="text" name="tgl_lahir" id="tgl_lahir" value="<?php echo $simrs_tgl_lahir; ?>" class="text_dt" size="30"/><td>
	</tr>	
	<tr>
		<td>Jenis Kelamin</td><td>:</td><td><input type="text" name="gender" id="gender" value="<?php echo $simrs_gender; ?>" class="text_dt" size="30"/></td>
		<td>Nomor SEP</td><td>:</td><td><input type="text" name="nomor_sep" id="nomor_sep" value="<?php echo $simrs_nomor_sep; ?>" class="text_dt" size="30"/><td>
	</tr>	
</table>
<input type="hidden" name="idx_rawat" id="idx_rawat" value="<?php echo $idx_rawat; ?>" />
<input type="hidden" name="jns_rawat" id="jns_rawat" value="<?php echo $jns_rawat; ?>" />
<input type="hidden" name="svrmh" id="svrmh" value="<?php echo $svrmh; ?>" />
<input type="hidden" name="nomr_claim" id="nomr_claim" value="<?php echo $claim_nomor_rm; ?>" />
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table width="100%" border="0">	
	<tr>
		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="right"><image id="loader" src="/nsimrs/sep/image/loading_circle_green.gif" height="20px" width="20px" style="display:none" /></td>
		<td align="right" width="200px"><input type="button" class="myButton" value="update data pasien" onclick="update_pasien('<?php echo $svrmh; ?>');"  />
		<input type="button" class="myButton" value="tutup" onclick="window.close();"  /></td>
	</tr>
</table>	
</div>
<?php } ?>