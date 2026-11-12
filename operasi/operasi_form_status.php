<?php 
$operasi_id = $_GET['idx'];
if (isset($_POST['simpan'])){
	$sql_cek_st_operasi = 'SELECT NO_OPERASI,RAWAT_ID,JNS_ORDER FROM t_operasi WHERE OPERASI_ID = "' . $operasi_id . '"';
	$get_cek_st_operasi = mysql_query($sql_cek_st_operasi) or die(mysql_error());
	$dat_cek_st_operasi = mysql_fetch_assoc($get_cek_st_operasi);
	if (empty($dat_cek_st_operasi['NO_OPERASI'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {	
		$st_operasi = '';
		if(isset($_POST['st_operasi'])) $st_operasi = getNomorBulanan('Operasi');
			$jenis_operasi = $_POST['jenis_operasi'];
			$ket_jenis_operasi = $_POST['ket_jenis_operasi'];
			$tipe_operasi = '';
			if(isset($_POST['tipe_operasi'])) $tipe_operasi = $_POST['tipe_operasi'];
			$jenis_luka = '';
			if(isset($_POST['jenis_luka'])) $jenis_luka = $_POST['jenis_luka'];
			$lama_operasi = '';
			if(isset($_POST['lama_operasi'])) $lama_operasi = $_POST['lama_operasi'];
			$asa_score = $_POST['asa_score'];
			$risk_score = $_POST['risk_score'];
			$cara_dirawat = $_POST['cara_dirawat'];
			$perubahan_jadwal = '';
			if(isset($_POST['perubahan_jadwal'])) $perubahan_jadwal = '1';
			$keterangan_perubahan = $_POST['keterangan_perubahan'];
			$plks_tanggal_operasi = $_POST['plks_tanggal_operasi'];
			$plks_jam_operasi = $_POST['plks_jam_operasi'];
			$plks_menit_operasi = $_POST['plks_menit_operasi'];
			
			mysql_query('UPDATE t_operasi SET NO_OPERASI = "' . $st_operasi . '",
					JENIS_OPERASI = "' . $jenis_operasi . '",
					KET_JENIS_OPERASI = "' . $ket_jenis_operasi . '",
					TIPE_OPERASI = "' . $tipe_operasi . '",
					JENIS_LUKA = "' . $jenis_luka . '",
					LAMA_OPERASI = "' . $lama_operasi . '",
					ASA_SCORE = "' . $asa_score . '",
					RISK_SCORE = "' . $risk_score . '",
					CARA_DIRAWAT = "' . $cara_dirawat . '",
					PERUBAHAN_JADWAL = "' . $perubahan_jadwal . '",
					KETERANGAN_PERUBAHAN_JADWAL = "' . $keterangan_perubahan . '",
					TANGGAL_PELAKSANAAN_OPERASI = STR_TO_DATE("' . $plks_tanggal_operasi . ' ' . $plks_jam_operasi . ':' . $plks_menit_operasi . ':01","%d/%m/%Y %H:%i:%s")
					WHERE OPERASI_ID = "' . $operasi_id . '"') or die(mysql_error());
		//edoc rekam medic
		include('edoc_rekammedik/edoc_main.php');
		create_pdf_operasi($operasi_id);
		//	

		$msg_info = 'Simpan Data Status Berhasil.';	
	}	
}

$qry_operasi = 'SELECT *,DATE_FORMAT(TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
				DATE_FORMAT(JAM_OPERASI,"%H") AS JAM_OPERASI,
				DATE_FORMAT(JAM_OPERASI,"%i") AS MENIT_OPERASI,
				DATE_FORMAT(TANGGAL_PELAKSANAAN_OPERASI,"%d/%m/%Y") AS TANGGAL_PELAKSANAAN_OPERASI,
				DATE_FORMAT(TANGGAL_PELAKSANAAN_OPERASI,"%H") AS JAM_PELAKSANAAN_OPERASI,
				DATE_FORMAT(TANGGAL_PELAKSANAAN_OPERASI,"%i") AS MENIT_PELAKSANAAN_OPERASI
				FROM t_operasi WHERE OPERASI_ID = "' . $operasi_id . '"';
$get_operasi = mysql_query($qry_operasi) or die(mysql_error());
$dat_operasi = mysql_fetch_assoc($get_operasi);
$st_operasi = $dat_operasi['NO_OPERASI']; 
$jenis_operasi = $dat_operasi['JENIS_OPERASI'];
$ket_jenis_operasi = $dat_operasi['KET_JENIS_OPERASI'];
$tipe_operasi = $dat_operasi['TIPE_OPERASI'];
$jenis_luka = $dat_operasi['JENIS_LUKA'];
$lama_operasi = $dat_operasi['LAMA_OPERASI'];
$asa_score = $dat_operasi['ASA_SCORE'];
$risk_score = $dat_operasi['RISK_SCORE'];

$plks_tanggal_operasi = $dat_operasi['TANGGAL_PELAKSANAAN_OPERASI'];
$plks_jam_operasi = $dat_operasi['JAM_PELAKSANAAN_OPERASI'];
$plks_menit_operasi = $dat_operasi['MENIT_PELAKSANAAN_OPERASI'];
if($plks_tanggal_operasi == '' or $plks_tanggal_operasi == '00/00/0000'){
	$plks_tanggal_operasi = $dat_operasi['TANGGAL_OPERASI'];
	$plks_jam_operasi = $dat_operasi['JAM_OPERASI'];
	$plks_menit_operasi = $dat_operasi['MENIT_OPERASI'];
}	

$perubahan_jadwal = $dat_operasi['PERUBAHAN_JADWAL'];
$keterangan_perubahan = $dat_operasi['KETERANGAN_PERUBAHAN_JADWAL'];
$cara_dirawat = $dat_operasi['CARA_DIRAWAT'];
?>
<form name="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="operasi_id" id="operasi_id" value="<?php echo $operasi_id; ?>" />
		<table width="100%" border="0" >
		<tr>
			<td width="15%">&nbsp;</td>
			<td width="15%">Cara Dirawat</td>
			<td><select name="cara_dirawat" id="cara_dirawat" class="text_dt" style="width:200px;">
                    <option value="">-</option>
					<option value="1" <?php if($cara_dirawat == '1') echo 'selected="selected"'; ?>>Elektif</option>
					<option value="2" <?php if($cara_dirawat == '2') echo 'selected="selected"'; ?>>Emergency</option>
                </select></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td width="15%">&nbsp;</td>
			<td width="15%">Jenis Operasi</td>
			<td><select name="jenis_operasi" id="jenis_operasi" class="text_dt" style="width:200px;">
                    <?php foreach(getJenisOperasi() as $id => $val){
						echo '<option value="' . $id . '" ' . (($jenis_operasi == $id) ? 'selected="selected"' : '') . ' >' . $val . '</option>';
					} ?>
                </select></td>
			<td>Keterangan</td>
			<td><input type="text" name="ket_jenis_operasi" class="text_dt" style="width:300px;" value="<?php echo $ket_jenis_operasi; ?>" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Tipe Operasi</td>
			<td colspan="3"><input type="radio" name="tipe_operasi" <?php if($tipe_operasi == '1') echo 'checked="checked"'; ?> value="1" />&nbsp;Terbuka&nbsp;&nbsp;
			<input type="radio" name="tipe_operasi" <?php if($tipe_operasi == '2') echo 'checked="checked"'; ?> value="2" />&nbsp;Tertutup</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Jenis Luka</td>
			<td colspan="3"><?php foreach(getJenisLuka() as $id => $val){
						echo '<input type="radio" name="jenis_luka" ' . (($jenis_luka == $id) ? 'checked="checked"' : '') . ' value="' . $id . '" />&nbsp;' . $val . '&nbsp;&nbsp;';
					} ?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Lama Operasi</td>
			<td colspan="3"><?php foreach(getLamaOperasi() as $id => $val){
						echo '<input type="radio" name="lama_operasi" ' . (($lama_operasi == $id) ? 'checked="checked"' : '') . ' value="' . $id . '" />&nbsp;' . $val . '&nbsp;&nbsp;';
					} ?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>ASA Score</td>
			<td colspan="3"><input type="text" name="asa_score" size="15" class="text_dt" value="<?php echo $asa_score; ?>" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Risk Score</td>
			<td colspan="3"><input type="text" name="risk_score" size="15" class="text_dt" value="<?php echo $risk_score; ?>" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Perubahan Jadwal</td>
			<td><input type="checkbox" name="perubahan_jadwal" value="1" <?php if($perubahan_jadwal == '1') echo 'checked="checked"'; ?> /></td>
			<td>Keterangan</td>
			<td><input type="text" name="keterangan_perubahan" class="text_dt" style="width:300px;" value="<?php echo $keterangan_perubahan; ?>" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Tanggal Pelaksanaan</td>
			<td><input type="text" name="plks_tanggal_operasi" id="tgl_1" size="15" class="text_dt" value="<?php echo $plks_tanggal_operasi; ?>" />
				<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar8')"/>
				&nbsp;&nbsp;Jam&nbsp;
				<select name="plks_jam_operasi" id="plks_jam_operasi" style="width:50px;" class="text_dt" >
					<?php echo getJam($plks_jam_operasi); ?>
				</select>
				<select name="plks_menit_operasi" id="plks_menit_operasi" style="width:50px;" class="text_dt" >
					<?php echo getMenit($plks_menit_operasi); ?>
				</select></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="3">&nbsp;</td>
		</tr>
        <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
            <td colspan="3">	
			<input type="checkbox" name="st_operasi" value="1" <?php if(!empty($st_operasi)) echo 'checked="checked"'; ?> />&nbsp;Selesai&nbsp;&nbsp;
			<input type="submit" name="simpan" value="simpan" class="myButton1" /></td>	
        </tr>
		</table>
</form>