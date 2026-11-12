<?php if(isset($_GET['idx'])){
$idx = $_GET['idx'];
if (strpos($idx, 'p') !== false){
	$qry_tracer = 'SELECT t_rm_tracer.*,m_pasien.PASIEN_ID,m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TMP_LAHIR,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,
		m_pasien.ALAMAT,m_pasien.NAMA_IBU,m_pasien.NIK,m_jaminan.NAMA_JAMINAN,"" AS NAMA_RUANG
		FROM t_rm_tracer 
		INNER JOIN t_ipenunjang ON (t_rm_tracer.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
		INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)	
		INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)  
		WHERE t_rm_tracer.RM_TRACER_ID = "' . str_replace('p','',$idx) . '"';
}else{	
	$qry_tracer = 'SELECT t_rm_tracer.*,m_pasien.PASIEN_ID,m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TMP_LAHIR,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,
		m_pasien.ALAMAT,m_pasien.NAMA_IBU,m_pasien.NIK,m_jaminan.NAMA_JAMINAN,m_ruang.NAMA_RUANG
		FROM t_rm_tracer 
		INNER JOIN t_irja ON (t_rm_tracer.IRJA_ID = t_irja.IRJA_ID)
		INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)	
		INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)  
		LEFT JOIN m_ruang ON (t_rm_tracer.ADMS_TERIMA_RUANG_ID = m_ruang.RUANG_ID)
		WHERE t_rm_tracer.RM_TRACER_ID = "' . $idx . '"';
}		
$get_tracer = mysql_query($qry_tracer);
$dat_tracer = mysql_fetch_assoc($get_tracer);
$nomr = $dat_tracer['NOMR'];
$nama_pasien = $dat_tracer['NAMA_PASIEN'];
$tmp_lahir = $dat_tracer['TMP_LAHIR'];
$tgl_lahir = changeDateFormat($dat_tracer['TGL_LAHIR']);
$jns_kelamin = $dat_tracer['JNS_KELAMIN'];
$nama_ibu = $dat_tracer['NAMA_IBU'];
$nik = $dat_tracer['NIK'];
$alamat = $dat_tracer['ALAMAT'];
$jns_pembayaran = $dat_tracer['NAMA_JAMINAN'];
?>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table class="tableform" >
    <?php
    include('pasien/pasien_view_short.php');
    ?>
</table>
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table width="90%" border="0">
	<tr>
		<td width="200">Tanggal RM Kirim</td>
		<td>:&nbsp;<?php echo $dat_tracer['RM_KIRIM']; ?></td>
		<td width="200">Pengirim</td>
		<td>:&nbsp;<?php $rm_user_kirim_arr = explode('|',$dat_tracer['RM_USER_KIRIM']);
			if(count($rm_user_kirim_arr) > 1 ) echo $rm_user_kirim_arr[1]; ?></td>
	</tr>
	<tr>
		<td>Keterangan</td>
		<td colspan="3">:&nbsp;<?php echo $dat_tracer['RM_KETERANGAN_KIRIM']; ?></td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td>Tanggal Klinik Terima</td>
		<td>:&nbsp;<?php echo $dat_tracer['IRJA_TERIMA']; ?></td>
		<td>Penerima</td>
		<td>:&nbsp;<?php 
			$irja_user_terima_arr = explode('|',$dat_tracer['IRJA_USER_TERIMA']);
			if(count($irja_user_terima_arr) > 1 ) echo $irja_user_terima_arr[1]; ?></td>
	</tr>
	<tr>
		<td>Keterangan</td>
		<td colspan="3">:&nbsp;<?php echo $dat_tracer['IRJA_KETERANGAN_TERIMA']; ?></td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td>Tanggal Rawat Inap Terima</td>
		<td>:&nbsp;<?php echo $dat_tracer['ADMS_TERIMA']; 
		if(!empty($dat_tracer['NAMA_RUANG'])) echo ' (' . $dat_tracer['NAMA_RUANG'] . ')';  
		?></td>
		<td>Penerima</td>
		<td>:&nbsp;<?php 
			$adms_user_terima_arr = explode('|',$dat_tracer['ADMS_USER_TERIMA']);
			if(count($adms_user_terima_arr) > 1 ) echo $adms_user_terima_arr[1]; ?></td>
	</tr>
	<tr>
		<td>Keterangan</td>
		<td colspan="3">:&nbsp;<?php echo $dat_tracer['ADMS_KETERANGAN_TERIMA']; ?></td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td>Tanggal RM Terima</td>
		<td>:&nbsp;<?php echo $dat_tracer['RM_TERIMA']; ?></td>
		<td>Penerima</td>
		<td>:&nbsp;<?php 
			$rm_user_terima_arr = explode('|',$dat_tracer['RM_USER_TERIMA']);
			if(count($rm_user_terima_arr) > 1 ) echo $rm_user_terima_arr[1]; ?></td>
	</tr>
	<tr>
		<td>Keterangan</td>
		<td colspan="3">:&nbsp;<?php echo $dat_tracer['RM_KETERANGAN_TERIMA']; ?></td>
	</tr>
</table>
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table width="95%" border="0">
<tr><td align="right"><a href="index.php?link=<?php echo md5('rmtracer'); ?>" ><input type="button" value="tutup" class="myButton" /></a></td></tr>
</table>
</div>
<?php } ?>