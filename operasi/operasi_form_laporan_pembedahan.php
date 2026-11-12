<?php
if(isset($_POST['idx'])){
	$lap_id = $_POST['lap_id'];
	$operasi_id = $_POST['operasi_id'];
	$tgl_operasi = $_POST['tgl_operasi'];
	$jam_operasi = $_POST['jam_operasi'] . ':' . $_POST['menit_operasi'];
	$lama_operasi = $_POST['lama_operasi'];
	$dpjp_operasi = $_POST['dpjp_operasi'];
	$dpjp_anestesi = $_POST['dpjp_anestesi'];
	$asisten_anestesi = $_POST['asisten_anestesi'];
	$operator = $_POST['operator'];
	$asisten_operator = $_POST['asisten_operator'];
	$diagnosa_pro_bedah_1 = $_POST['diagnosa_pro_bedah_1'];
	$diagnosa_pro_bedah_2 = $_POST['diagnosa_pro_bedah_2'];
	$diagnosa_pro_bedah_3 = $_POST['diagnosa_pro_bedah_3'];
	$diagnosa_pro_bedah_4 = $_POST['diagnosa_pro_bedah_4'];
	$diagnosa_pasca_bedah_1 = $_POST['diagnosa_pasca_bedah_1'];
	$diagnosa_pasca_bedah_2 = $_POST['diagnosa_pasca_bedah_2'];
	$diagnosa_pasca_bedah_3 = $_POST['diagnosa_pasca_bedah_3'];
	$diagnosa_pasca_bedah_4 = $_POST['diagnosa_pasca_bedah_4'];
	$tindakan_bedah_1 = $_POST['tindakan_bedah_1'];
	$tindakan_bedah_2 = $_POST['tindakan_bedah_2'];
	$tindakan_bedah_3 = $_POST['tindakan_bedah_3'];
	$tindakan_bedah_4 = $_POST['tindakan_bedah_4'];
	$st_emergency = ((isset($_POST['st_emergency'])) ? $_POST['st_emergency'] : '');
	$st_bedah = ((isset($_POST['st_bedah'])) ? $_POST['st_bedah'] : '');
	$jns_pembedahan = ((isset($_POST['jns_pembedahan'])) ? $_POST['jns_pembedahan'] : '');
	$operasi_ke = ((isset($_POST['operasi_ke'])) ? $_POST['operasi_ke'] : '');
	$proteksis = ((isset($_POST['proteksis'])) ? $_POST['proteksis'] : '');
	$jns_antibiotik = $_POST['jns_antibiotik'];
	$waktu_pem_antibiotik = $_POST['waktu_pem_antibiotik'];
	$uraian_pembedahan = $_POST['uraian_pembedahan'];
	$komplikasi = $_POST['komplikasi'];
	$jml_pendarahan = $_POST['jml_pendarahan'];
	$jml_transfusi = $_POST['jml_transfusi'];
	$konsultasi = $_POST['konsultasi'];
	$noreg_alat_implant = $_POST['noreg_alat_implant'];
	$jaringan_patologi = ((isset($_POST['jaringan_patologi'])) ? $_POST['jaringan_patologi'] : '');
	$tgl_jaringan_ke_patologi = $_POST['tgl_jaringan_ke_patologi'];
	$macam_jaringan = $_POST['macam_jaringan'];
	$label_pasien = ((isset($_POST['label_pasien'])) ? $_POST['label_pasien'] : '');
	$final = ((isset($_POST['final'])) ? $_POST['final'] : '');
	
	if($lap_id == ''){
		mysql_query('INSERT INTO t_operasi_laporan_pembedahan (OPERASI_ID,TANGGAL_OPERASI,
			JAM_MULAI_OPERASI,LAMA_OPERASI,DPJP_OPERASI,DPJP_ANASTESI,ASISTEN_ANASTESI,
			OPERATOR,ASISTEN_OPERATOR,DIAGNOSA_PRO_BEDAH_1,DIAGNOSA_PRO_BEDAH_2,
			DIAGNOSA_PRO_BEDAH_3,DIAGNOSA_PRO_BEDAH_4,
			DIAGNOSA_PASCA_BEDAH_1,DIAGNOSA_PASCA_BEDAH_2,DIAGNOSA_PASCA_BEDAH_3,
			DIAGNOSA_PASCA_BEDAH_4,TINDAKAN_BEDAH_1,
			TINDAKAN_BEDAH_2,TINDAKAN_BEDAH_3,TINDAKAN_BEDAH_4,ST_EMERGENCY,ST_BEDAH,
			JNS_PEMBEDAHAN,OPERASI_KE,PROTEKSIS,JNS_ANTIBIOTIK,WAKTU_PEMBERIAN_ANTIBIOTIK,
			URAIAN_PEMBEDAHAN,KOMPLIKASI,JML_PENDARAHAN,JML_TRANSFUSI,KONSULTASI_INTRA_OPERASI,
			NO_REGISTRASI_ALAT_IMPLANT,JARINGAN_KE_PATOLOGI,TGL_JARINGAN_KE_PATOLOGI,
			MACAM_JARINGAN_YG_DIKIRIM,LABEL_PASIEN,REGISTER,
			TGL_REGISTER,FINAL,VERSI_DOKUMEN) VALUES ("' . $operasi_id . '",
			STR_TO_DATE("' . $tgl_operasi . '","%d/%m/%Y"),"' . $jam_operasi . '",
			"' . $lama_operasi . '","' . $dpjp_operasi . '","' . $dpjp_anestesi . '",
			"' . $asisten_anestesi . '","' . $operator . '","' . $asisten_operator . '",
			"' . $diagnosa_pro_bedah_1 . '","' . $diagnosa_pro_bedah_2 . '",
			"' . $diagnosa_pro_bedah_3 . '","' . $diagnosa_pro_bedah_4 . '",
			"' . $diagnosa_pasca_bedah_1 . '","' . $diagnosa_pasca_bedah_2 . '",
			"' . $diagnosa_pasca_bedah_3 . '","' . $diagnosa_pasca_bedah_4 . '",
			"' . $tindakan_bedah_1 . '","' . $tindakan_bedah_2 . '","' . $tindakan_bedah_3 . '",
			"' . $tindakan_bedah_4 . '","' . $st_emergency . '","' . $st_bedah . '",
			"' . $jns_pembedahan . '","' . $operasi_ke . '","' . $proteksis . '",
			"' . $jns_antibiotik . '","' . $waktu_pem_antibiotik . '","' . $uraian_pembedahan . '",
			"' . $komplikasi . '","' . $jml_pendarahan . '","' . $jml_transfusi . '",
			"' . $konsultasi . '","' . $noreg_alat_implant . '","' . $jaringan_patologi . '",
			STR_TO_DATE("' . $tgl_jaringan_ke_patologi . '","%d/%m/%Y"),"' . $macam_jaringan . '",
			"' . $label_pasien . '","' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",NOW(),
			"' . $final . '","")') or die(mysql_error());
	}else{
		mysql_query('UPDATE t_operasi_laporan_pembedahan
			SET TANGGAL_OPERASI = STR_TO_DATE("' . $tgl_operasi . '","%d/%m/%Y"),
			JAM_MULAI_OPERASI = "' . $jam_operasi . '",
			LAMA_OPERASI = "' . $lama_operasi . '",
			DPJP_OPERASI = "' . $dpjp_operasi . '",
			DPJP_ANASTESI = "' . $dpjp_anestesi . '",
			ASISTEN_ANASTESI = "' . $asisten_anestesi . '",
			OPERATOR = "' . $operator . '",
			ASISTEN_OPERATOR = "' . $asisten_operator . '",
			DIAGNOSA_PRO_BEDAH_1 = "' . $diagnosa_pro_bedah_1 . '",
			DIAGNOSA_PRO_BEDAH_2 = "' . $diagnosa_pro_bedah_2 . '",
			DIAGNOSA_PRO_BEDAH_3 = "' . $diagnosa_pro_bedah_3 . '",
			DIAGNOSA_PRO_BEDAH_4 = "' . $diagnosa_pro_bedah_4 . '",
			DIAGNOSA_PASCA_BEDAH_1 = "' . $diagnosa_pasca_bedah_1 . '",
			DIAGNOSA_PASCA_BEDAH_2 = "' . $diagnosa_pasca_bedah_2 . '",
			DIAGNOSA_PASCA_BEDAH_3 = "' . $diagnosa_pasca_bedah_3 . '",
			DIAGNOSA_PASCA_BEDAH_4 = "' . $diagnosa_pasca_bedah_4 . '",
			TINDAKAN_BEDAH_1 = "' . $tindakan_bedah_1 . '",
			TINDAKAN_BEDAH_2 = "' . $tindakan_bedah_2 . '",
			TINDAKAN_BEDAH_3 = "' . $tindakan_bedah_3 . '",
			TINDAKAN_BEDAH_4 = "' . $tindakan_bedah_4 . '",
			ST_EMERGENCY = "' . $st_emergency . '",
			ST_BEDAH = "' . $st_bedah . '",
			JNS_PEMBEDAHAN = "' . $jns_pembedahan . '",
			OPERASI_KE = "' . $operasi_ke . '",
			PROTEKSIS = "' . $proteksis . '",
			JNS_ANTIBIOTIK = "' . $jns_antibiotik . '",
			WAKTU_PEMBERIAN_ANTIBIOTIK = "' . $waktu_pem_antibiotik . '",
			URAIAN_PEMBEDAHAN = "' . $uraian_pembedahan . '",
			KOMPLIKASI = "' . $komplikasi . '",
			JML_PENDARAHAN = "' . $jml_pendarahan . '",
			JML_TRANSFUSI = "' . $jml_transfusi . '",
			KONSULTASI_INTRA_OPERASI = "' . $konsultasi . '",
			NO_REGISTRASI_ALAT_IMPLANT = "' . $noreg_alat_implant . '",
			JARINGAN_KE_PATOLOGI = "' . $jaringan_patologi . '",
			TGL_JARINGAN_KE_PATOLOGI = "' . $tgl_jaringan_ke_patologi . '",
			MACAM_JARINGAN_YG_DIKIRIM = "' . $macam_jaringan . '",
			LABEL_PASIEN = "' . $label_pasien . '",
			REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
			TGL_REGISTER = NOW(),
			FINAL = "' . $final . '"
			WHERE LAPORAN_ID = "' . $lap_id . '"
			AND OPERASI_ID = "' . $operasi_id .'"') or die(mysql_error());
	}
}

$sql_lap_pembedahan = 'SELECT b.LAPORAN_ID,o.OPERASI_ID,
	DATE_FORMAT(o.TANGGAL_OPERASI,"%d-%m-%Y") AS TANGGAL_OPERASI,
	DATE_FORMAT(o.JAM_OPERASI,"%H:%i") AS JAM_OPERASI,
	p.NAMA_PEGAWAI,
	p2.NAMA_PEGAWAI AS DOKTER_OPERASI,
	p3.NAMA_PEGAWAI AS OPERATOR,
	b.REGISTER,DATE_FORMAT(b.TGL_REGISTER,"%d-%m-%Y %H:%i") AS TGL_REGISTER,
	b.FINAL,b.VERSI_DOKUMEN
	FROM t_operasi o
	LEFT JOIN m_pegawai p ON (o.PEGAWAI_ID = p.PEGAWAI_ID)
	LEFT JOIN m_pegawai p2 ON (o.PEGAWAI_PELAKSANA_ID = p2.PEGAWAI_ID)
	LEFT JOIN t_operasi_laporan_pembedahan b ON (o.OPERASI_ID = b.OPERASI_ID)
	LEFT JOIN m_pegawai p3 ON (b.OPERATOR = p3.PEGAWAI_ID)
	WHERE o.RAWAT_ID = "' . $idx . '" 
	AND o.ST_APPROVE = "1"  
	AND o.JNS_ORDER = "IRN"
	AND o.NO_PENDAFTARAN IS NOT NULL
	ORDER BY o.OPERASI_ID,b.LAPORAN_ID';
$get_lap_pembedahan = mysql_query($sql_lap_pembedahan) or die(mysql_error());
?>
<table class="tableData" id="tfhover" >
<tr>
	<th>No</th>
	<th>Tanggal Operasi</th>
	<th>DPJP</th>
	<th>Operator</th>
	<th>Register</th>
	<th width="100px;">Option</th>
</tr>
<?php 	
$i = 1;
while($dat_lap_pembedahan = mysql_fetch_array($get_lap_pembedahan)){ 
?>
	<tr>
		<td align="center"><?php echo $i; ?></td>	
		<td><?php echo $dat_lap_pembedahan['TANGGAL_OPERASI'] . ' ' . $dat_lap_pembedahan['JAM_OPERASI']; ?></td>
		<td><?php echo $dat_lap_pembedahan['DOKTER_OPERASI']; ?></td>
		<td><?php echo $dat_lap_pembedahan['OPERATOR']; ?></td>
		<td><?php echo $dat_lap_pembedahan['REGISTER'] . ' ' . $dat_lap_pembedahan['TGL_REGISTER'] . (($dat_lap_pembedahan['FINAL'] == '1') ? '&nbsp;(Final)' : ''); ?></td>
		<td align="center"><a href="<?php echo currentUrl(); ?>&lp=<?php echo $dat_lap_pembedahan['LAPORAN_ID']; ?>&op=<?php echo $dat_lap_pembedahan['OPERASI_ID']; ?>">laporan</a></td>
	</tr>
<?php $i++;
} ?>
</table>
<br />
<?php
$lap_id = '';
$operasi_id = '';
if(isset($_GET['lp'])) $lap_id = $_GET['lp'];
if(isset($_GET['op'])) $operasi_id = $_GET['op']; 
$qry_laporan = 'SELECT l.LAPORAN_ID,o.OPERASI_ID,
	DATE_FORMAT(o.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
	DATE_FORMAT(o.JAM_OPERASI,"%H:%i") AS JAM_OPERASI,
	o.PEGAWAI_PELAKSANA_ID AS DPJP_OPERASI,
	DATE_FORMAT(l.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI_LAP,
	l.JAM_MULAI_OPERASI AS JAM_OPERASI_LAP,l.LAMA_OPERASI,l.DPJP_OPERASI AS DPJP_OPERASI_LAP,
	l.DPJP_ANASTESI,l.ASISTEN_ANASTESI,l.OPERATOR,l.ASISTEN_OPERATOR,l.
	DIAGNOSA_PRO_BEDAH_1,l.DIAGNOSA_PRO_BEDAH_2,l.DIAGNOSA_PRO_BEDAH_3,l.DIAGNOSA_PRO_BEDAH_4,l.
	DIAGNOSA_PRO_BEDAH_1_ICD,l.DIAGNOSA_PRO_BEDAH_2_ICD,l.DIAGNOSA_PRO_BEDAH_3_ICD,l.
	DIAGNOSA_PRO_BEDAH_4_ICD,l.DIAGNOSA_PASCA_BEDAH_1,l.DIAGNOSA_PASCA_BEDAH_2,l.
	DIAGNOSA_PASCA_BEDAH_3,l.DIAGNOSA_PASCA_BEDAH_4,l.DIAGNOSA_PASCA_BEDAH_1_ICD,l.
	DIAGNOSA_PASCA_BEDAH_2_ICD,l.DIAGNOSA_PASCA_BEDAH_3_ICD,l.DIAGNOSA_PASCA_BEDAH_4_ICD,l.
	ST_EMERGENCY,l.ST_BEDAH,l.JNS_PEMBEDAHAN,l.OPERASI_KE,l.PROTEKSIS,l.JNS_ANTIBIOTIK,l.
	WAKTU_PEMBERIAN_ANTIBIOTIK,l.URAIAN_PEMBEDAHAN,l.KOMPLIKASI,l.JML_PENDARAHAN,l.
	JML_TRANSFUSI,l.KONSULTASI_INTRA_OPERASI,l.NO_REGISTRASI_ALAT_IMPLANT,l.JARINGAN_KE_PATOLOGI,l.
	TGL_JARINGAN_KE_PATOLOGI,l.MACAM_JARINGAN_YG_DIKIRIM,l.LABEL_PASIEN,l.SIGNATURE_OPERATOR,l.
	REGISTER,l.TGL_REGISTER,l.FINAL,l.ST_CREATE_ERM,l.VERSI_DOKUMEN,l.
	TINDAKAN_BEDAH_1,l.TINDAKAN_BEDAH_2,l.TINDAKAN_BEDAH_3,l.TINDAKAN_BEDAH_4
	FROM t_operasi o
	LEFT JOIN t_operasi_laporan_pembedahan l 
	ON (o.OPERASI_ID = l.OPERASI_ID)
	WHERE o.OPERASI_ID = "' . $operasi_id . '"';
if($lap_id != '') $qry_laporan .= ' AND l.LAPORAN_ID = "' . $lap_id . '"';	
$get_laporan = mysql_query($qry_laporan) or die(mysql_error());
$dat_laporan = mysql_fetch_assoc($get_laporan);
$lap_id = $dat_laporan['LAPORAN_ID'];
$operasi_id = $dat_laporan['OPERASI_ID'];
$tgl_operasi = ((empty($dat_laporan['TANGGAL_OPERASI_LAP']))? $dat_laporan['TANGGAL_OPERASI'] : $dat_laporan['TANGGAL_OPERASI_LAP']);
$xjam_operasi = ((empty($dat_laporan['JAM_OPERASI_LAP'])) ? $dat_laporan['JAM_OPERASI'] : $dat_laporan['JAM_OPERASI_LAP']);
$arr_jam_operasi = explode(':',$xjam_operasi);
$jam_operasi = ((isset($arr_jam_operasi[0])) ? $arr_jam_operasi[0] : ''); 
$menit_operasi = ((isset($arr_jam_operasi[1])) ? $arr_jam_operasi[1] : '');
$lama_operasi = $dat_laporan['LAMA_OPERASI'];
$dpjp_operasi = $dat_laporan['DPJP_OPERASI'];
$dpjp_anestesi = $dat_laporan['DPJP_ANASTESI'];
$asisten_anestesi = $dat_laporan['ASISTEN_ANASTESI'];
$operator = $dat_laporan['OPERATOR'];
$asisten_operator = $dat_laporan['ASISTEN_OPERATOR'];
$diagnosa_pro_bedah_1 = $dat_laporan['DIAGNOSA_PRO_BEDAH_1'];
$diagnosa_pro_bedah_2 = $dat_laporan['DIAGNOSA_PRO_BEDAH_2'];
$diagnosa_pro_bedah_3 = $dat_laporan['DIAGNOSA_PRO_BEDAH_3'];
$diagnosa_pro_bedah_4 = $dat_laporan['DIAGNOSA_PRO_BEDAH_4'];
$diagnosa_pasca_bedah_1 = $dat_laporan['DIAGNOSA_PASCA_BEDAH_1'];
$diagnosa_pasca_bedah_2 = $dat_laporan['DIAGNOSA_PASCA_BEDAH_2'];
$diagnosa_pasca_bedah_3 = $dat_laporan['DIAGNOSA_PASCA_BEDAH_3'];
$diagnosa_pasca_bedah_4 = $dat_laporan['DIAGNOSA_PASCA_BEDAH_4'];
$tindakan_bedah_1 = $dat_laporan['TINDAKAN_BEDAH_1'];
$tindakan_bedah_2 = $dat_laporan['TINDAKAN_BEDAH_2'];
$tindakan_bedah_3 = $dat_laporan['TINDAKAN_BEDAH_3'];
$tindakan_bedah_4 = $dat_laporan['TINDAKAN_BEDAH_4'];
$st_emergency = $dat_laporan['ST_EMERGENCY'];
$st_bedah = $dat_laporan['ST_BEDAH'];
$jns_pembedahan = $dat_laporan['JNS_PEMBEDAHAN'];
$operasi_ke = $dat_laporan['OPERASI_KE'];
$proteksis = $dat_laporan['PROTEKSIS'];
$jns_antibiotik = $dat_laporan['JNS_ANTIBIOTIK'];
$waktu_pem_antibiotik = $dat_laporan['WAKTU_PEMBERIAN_ANTIBIOTIK'];
$uraian_pembedahan = $dat_laporan['URAIAN_PEMBEDAHAN'];
$komplikasi = $dat_laporan['KOMPLIKASI'];
$jml_pendarahan = $dat_laporan['JML_PENDARAHAN'];
$jml_transfusi = $dat_laporan['JML_TRANSFUSI'];
$konsultasi = $dat_laporan['KONSULTASI_INTRA_OPERASI'];
$noreg_alat_implant = $dat_laporan['NO_REGISTRASI_ALAT_IMPLANT'];
$jaringan_patologi = $dat_laporan['JARINGAN_KE_PATOLOGI'];
$tgl_jaringan_ke_patologi = $dat_laporan['TGL_JARINGAN_KE_PATOLOGI'];
$macam_jaringan = $dat_laporan['MACAM_JARINGAN_YG_DIKIRIM'];
$label_pasien = $dat_laporan['LABEL_PASIEN'];
$final = $dat_laporan['FINAL'];
?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#diagnosa_pro_bedah_1").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 570});
		jQuery("#diagnosa_pro_bedah_2").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 570});
		jQuery("#diagnosa_pro_bedah_3").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 570});
		jQuery("#diagnosa_pro_bedah_4").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 570});
		jQuery("#diagnosa_pasca_bedah_1").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 570});
		jQuery("#diagnosa_pasca_bedah_2").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 570});
		jQuery("#diagnosa_pasca_bedah_3").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 570});
		jQuery("#diagnosa_pasca_bedah_4").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 570});
    });
</script>
<form name="formedit" id="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />	
	<input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />	
	<input type="hidden" name="operasi_id" id="operasi_id" value="<?php echo $operasi_id; ?>" />
	<input type="hidden" name="lap_id" id="lap_id" value="<?php echo $lap_id; ?>" />	
	<table border="0" align="center" style="position:static; " width="90%">
		<tr>
            <td>DPJP Bedah</td>
			<td>:</td>
			<td><select name="dpjp_operasi" id="dpjp_operasi" style="width:228px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getDokter($dpjp_operasi); ?>
                </select></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
            <td>Operator</td>
			<td>:</td>
			<td><select name="operator" id="operator" style="width:228px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getPelaksanaRanap($operator,''); ?>
                </select></td>
			<td></td>
			<td>Asisten Operator</td>
			<td>:</td>
			<td><select name="asisten_operator" id="asisten_operator" style="width:228px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getPelaksanaRanap($asisten_operator,''); ?>
                </select></td>
		</tr>
		<tr>
            <td>DPJP Anestesiologi</td>
			<td>:</td>
			<td><select name="dpjp_anestesi" id="dpjp_anestesi" style="width:228px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getDokter($dpjp_anestesi); ?>
                </select></td>
			<td></td>
			<td>Asisten Anestesiologi</td>
			<td>:</td>
			<td><select name="asisten_anestesi" id="asisten_anestesi" style="width:228px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getPelaksanaRanap($asisten_anestesi,''); ?>
                </select></td>
		</tr>
		<tr>
            <td>Tanggal Pembedahan</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="tgl_operasi" id="tgl_2" size="15" class="text_dt" value="<?php echo $tgl_operasi; ?>" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar9')"/>&nbsp;&nbsp;
			Jam Mulai&nbsp;&nbsp;<select name="jam_operasi" id="jam_operasi" style="width:50px;" class="text_dt" >
                    <option value="" > - </option>
					<?php echo getJam($jam_operasi); ?>
					</select> <select name="menit_operasi" id="menit_operasi" style="width:50px;" class="text_dt" >
                    <option value="" > - </option>
					<?php echo getMenit($menit_operasi); ?>
					</select>
			&nbsp;&nbsp;Lama Pembedahan&nbsp;&nbsp;<input type="text" name="lama_operasi" id="lama_operasi" value="<?php echo $lama_operasi; ?>" class="text_dt"/></td>
		</tr>
		<tr>
            <td>Diagnosa Pro Bedah</td>
			<td>: 1</td>
			<td colspan="5"><input type="text" name="diagnosa_pro_bedah_1" id="diagnosa_pro_bedah_1" class="text_dt" value="<?php echo $diagnosa_pro_bedah_1; ?>" style="width:560px;"></td>
		</tr>
		<tr>
            <td>&nbsp;</td>
			<td>&nbsp;&nbsp;2</td>
			<td colspan="5"><input type="text" name="diagnosa_pro_bedah_2" id="diagnosa_pro_bedah_2" class="text_dt" value="<?php echo $diagnosa_pro_bedah_2; ?>" style="width:560px;"></td>
		</tr>
		<tr>
            <td>&nbsp;</td>
			<td>&nbsp;&nbsp;3</td>
			<td colspan="5"><input type="text" name="diagnosa_pro_bedah_3" id="diagnosa_pro_bedah_3" class="text_dt" value="<?php echo $diagnosa_pro_bedah_3; ?>" style="width:560px;"></td>
		</tr>
		<tr>
            <td>&nbsp;</td>
			<td>&nbsp;&nbsp;4</td>
			<td colspan="5"><input type="text" name="diagnosa_pro_bedah_4" id="diagnosa_pro_bedah_4" class="text_dt" value="<?php echo $diagnosa_pro_bedah_4; ?>" style="width:560px;"></td>
		</tr>
		<tr>
            <td>Diagnosa Pasca Bedah</td>
			<td>: 1</td>
			<td colspan="5"><input type="text" name="diagnosa_pasca_bedah_1" id="diagnosa_pasca_bedah_1" class="text_dt" value="<?php echo $diagnosa_pasca_bedah_1; ?>" style="width:560px;"></td>
		</tr>
		<tr>
            <td>&nbsp;</td>
			<td>&nbsp;&nbsp;2</td>
			<td colspan="5"><input type="text" name="diagnosa_pasca_bedah_2" id="diagnosa_pasca_bedah_2" class="text_dt" value="<?php echo $diagnosa_pasca_bedah_2; ?>" style="width:560px;"></td>
		</tr>
		<tr>
            <td>&nbsp;</td>
			<td>&nbsp;&nbsp;3</td>
			<td colspan="5"><input type="text" name="diagnosa_pasca_bedah_3" id="diagnosa_pasca_bedah_3" class="text_dt" value="<?php echo $diagnosa_pasca_bedah_3; ?>" style="width:560px;"></td>
		</tr>
		<tr>
            <td>&nbsp;</td>
			<td>&nbsp;&nbsp;4</td>
			<td colspan="5"><input type="text" name="diagnosa_pasca_bedah_4" id="diagnosa_pasca_bedah_4" class="text_dt" value="<?php echo $diagnosa_pasca_bedah_4; ?>" style="width:560px;"></td>
		</tr>
		<tr>
            <td>Tindakan Pembedahan</td>
			<td>: 1</td>
			<td colspan="5"><input type="text" name="tindakan_bedah_1" id="tindakan_bedah_1" class="text_dt" value="<?php echo $tindakan_bedah_1; ?>" style="width:560px;"></td>
		</tr>
		<tr>
            <td>&nbsp;</td>
			<td>&nbsp;&nbsp;2</td>
			<td colspan="5"><input type="text" name="tindakan_bedah_2" id="tindakan_bedah_2" class="text_dt" value="<?php echo $tindakan_bedah_2; ?>" style="width:560px;"></td>
		</tr>
		<tr>
            <td>&nbsp;</td>
			<td>&nbsp;&nbsp;3</td>
			<td colspan="5"><input type="text" name="tindakan_bedah_3" id="tindakan_bedah_3" class="text_dt" value="<?php echo $tindakan_bedah_3; ?>" style="width:560px;"></td>
		</tr>
		<tr>
            <td>&nbsp;</td>
			<td>&nbsp;&nbsp;4</td>
			<td colspan="5"><input type="text" name="tindakan_bedah_4" id="tindakan_bedah_4" class="text_dt" value="<?php echo $tindakan_bedah_4; ?>" style="width:560px;"></td>
		</tr>
		<tr>
            <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="5"><input type="checkbox" name="st_emergency" value="1" <?php if($st_emergency == '1') echo 'checked'; ?> />&nbsp;Emergency
			<input type="checkbox" name="st_bedah" value="1" <?php if($st_bedah == '1') echo 'checked'; ?> />&nbsp;Bedah</td>
		</tr>
		<tr>
            <td>Jenis Pembedahan</td>
			<td>:</td>
			<td colspan="5"><input type="radio" name="jns_pembedahan" value="1" <?php if($jns_pembedahan == '1') echo 'checked'; ?> />&nbsp;Bersih
			<input type="radio" name="jns_pembedahan" value="2" <?php if($jns_pembedahan == '2') echo 'checked'; ?> />&nbsp;Bersih Tercemar
			<input type="radio" name="jns_pembedahan" value="3" <?php if($jns_pembedahan == '3') echo 'checked'; ?> />&nbsp;Tercemar
			<input type="radio" name="jns_pembedahan" value="4" <?php if($jns_pembedahan == '4') echo 'checked'; ?> />&nbsp;Kotor</td>
		</tr>
		<tr>
            <td>Operasi Ke</td>
			<td>:</td>
			<td colspan="5"><input type="radio" name="operasi_ke" value="1" <?php if($operasi_ke == '1') echo 'checked'; ?> />&nbsp;1
			<input type="radio" name="operasi_ke" value="2" <?php if($operasi_ke == '2') echo 'checked'; ?> />&nbsp;Re-Co</td>
		</tr>
		<tr>
            <td>Proteksis</td>
			<td>:</td>
			<td colspan="5"><input type="radio" name="proteksis" value="1" <?php if($proteksis == '1') echo 'checked'; ?> />&nbsp;Ya
			<input type="radio" name="proteksis" value="2" <?php if($proteksis == '2') echo 'checked'; ?> />&nbsp;Tidak</td>
		</tr>
		<tr>
            <td>Jenis Antibiotik</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="jns_antibiotik" id="jns_antibiotik" class="text_dt" value="<?php echo $jns_antibiotik; ?>" style="width:560px;"></td>
		</tr>
		<tr>
            <td>Waktu Pemberian</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="waktu_pem_antibiotik" id="waktu_pem_antibiotik" class="text_dt" value="<?php echo $waktu_pem_antibiotik; ?>" >&nbsp; Jam Sebelum Operasi</td>
		</tr>
		<tr>
            <td valign="top">Uraian Pembedahan</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="uraian_pembedahan" id="uraian_pembedahan" class="text_dt4" style="height:300px;"><?php echo $uraian_pembedahan; ?></textarea></td>
		</tr>
		<tr>
            <td valign="top">Komplikasi Selama Pembedahan</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="komplikasi" id="komplikasi" class="text_dt4" style="height:120px;"><?php echo $komplikasi; ?></textarea></td>
		</tr>
		<tr>
            <td>Jumlah Pendarahan</td>
			<td>:</td>
			<td><input type="text" name="jml_pendarahan" id="jml_pendarahan" class="text_dt" value="<?php echo $jml_pendarahan; ?>" >&nbsp; cc</td>
			<td></td>
			<td>Jumlah Transfusi</td>
			<td>:</td>
			<td><input type="text" name="jml_transfusi" id="jml_transfusi" class="text_dt" value="<?php echo $jml_transfusi; ?>" >&nbsp; cc</td>
		</tr>
		<tr>
            <td valign="top">Konsultasi Intra Operasi</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="konsultasi" id="konsultasi" class="text_dt4" style="height:120px;"><?php echo $konsultasi; ?></textarea></td>
		</tr>
		<tr>
            <td>No Register Alat Implant</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="noreg_alat_implant" id="noreg_alat_implant" class="text_dt" value="<?php echo $noreg_alat_implant; ?>" style="width:560px;"></td>
		</tr>
		<tr>
            <td>Jaringan Ke Patologi</td>
			<td>:</td>
			<td colspan="5"><input type="radio" name="jaringan_patologi" value="1" />&nbsp;Ya, Tanggal <input type="text" name="tgl_jaringan_ke_patologi" id="tgl_1" size="15" class="text_dt" value="<?php echo $tgl_jaringan_ke_patologi; ?>" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar12')"/>&nbsp;&nbsp;
			<input type="radio" name="jaringan_patologi" value="2" />&nbsp;Tidak</td>
		</tr>
		<tr>
            <td>Macam Jaringan Yang Dikirim</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="macam_jaringan" id="macam_jaringan" class="text_dt" value="<?php echo $macam_jaringan; ?>" style="width:560px;"></td>
		</tr>
		<tr>
            <td>Label Pasien Sudah Ditempel</td>
			<td>:</td>
			<td colspan="5"><input type="radio" name="label_pasien" value="1" />&nbsp;Ya
			<input type="radio" name="label_pasien" value="2" />&nbsp;Tidak</td>
		</tr>
		<tr>
            <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
            <td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="5" align="right">
			<input type="checkbox" name="final" value="1" 
			<?php if($final == '1') {
				echo 'checked'; 
				if($_SESSION['SES_SIMRS_ADMIN'] != '1') echo ' disabled';
			}	?> />&nbsp;Final&nbsp;&nbsp; 
			<?php if($operasi_id != ''){ ?>
			<input type="button" value="simpan" class="myButton" onclick="simpan();" />
			<?php } ?></td>
		</tr>
    </table>
</form>
<script>
function simpan(){
	_haschange = false;
	$('#formedit').submit();
}	
</script>