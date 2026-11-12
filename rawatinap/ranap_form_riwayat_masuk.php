<?php

if(isset($_POST['irna_id'])){
	mysql_query('UPDATE t_irna SET PEGAWAI_ID = "' . $_POST['pegawai_id'] . '",
					PEGAWAI_RAWAT_ID = "' . $_POST['pegawai_rawat_id_1'] . '",
					PEGAWAI_RAWAT_ID_2 = "' . $_POST['pegawai_rawat_id_2'] . '",
					PEGAWAI_RAWAT_ID_3 = "' . $_POST['pegawai_rawat_id_3'] . '",
					PEGAWAI_RAWAT_ID_4 = "' . $_POST['pegawai_rawat_id_4'] . '",
					PEGAWAI_RAWAT_ID_5 = "' . $_POST['pegawai_rawat_id_5'] . '",
					PEGAWAI_RAWAT_ID_6 = "' . $_POST['pegawai_rawat_id_6'] . '"
				WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
	$link = str_replace('&opt=ed','',currentUrl());			
	?>
	<script language="JavaScript" >
		alert('Simpan Data Tim Dokter Berhasil.');
		window.location = "<?php echo $link; ?>";
    </script>
	<?php	
}
	
    $sql_kunjungan = 'SELECT t_irja.NOMR,t_irja.IRJA_ID,
					DATE_FORMAT(t_irja.PASIEN_MASUK,"%d-%m-%Y %H:%i:%s") AS PASIEN_MASUK_RS,
					m_unit.NAMA_UNIT,m_pegawai.NAMA_PEGAWAI,t_irja.UNIT_ID,
					DATE_FORMAT(t_irna.PASIEN_MASUK,"%d-%m-%Y %H:%i:%s") AS PASIEN_MASUK_RUANG,
					pg2.NAMA_PEGAWAI AS NAMA_PEGAWAI2,t_irna.P_JAWAB_NAMA,t_irna.P_JAWAB_NO_TELP,
					DATEDIFF(DATE(t_irna.PASIEN_MASUK),DATE(t_irja.PASIEN_MASUK)) + 1 AS LAMA,
					pg3.NAMA_PEGAWAI AS PEGAWAI_RAWAT_1,
					pg4.NAMA_PEGAWAI AS PEGAWAI_RAWAT_2,
					pg5.NAMA_PEGAWAI AS PEGAWAI_RAWAT_3,
					pg6.NAMA_PEGAWAI AS PEGAWAI_RAWAT_4,
					pg7.NAMA_PEGAWAI AS PEGAWAI_RAWAT_5,
					pg8.NAMA_PEGAWAI AS PEGAWAI_RAWAT_6,
					t_irna.PEGAWAI_ID,
					t_irna.PEGAWAI_RAWAT_ID,
					t_irna.PEGAWAI_RAWAT_ID_2,
					t_irna.PEGAWAI_RAWAT_ID_3,
					t_irna.PEGAWAI_RAWAT_ID_4,
					t_irna.PEGAWAI_RAWAT_ID_5,
					t_irna.PEGAWAI_RAWAT_ID_6
				FROM t_irja
				INNER JOIN t_irna ON (t_irja.IRJA_ID = t_irna.IRNA_ID)	
				LEFT JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai pg2 ON (t_irna.PEGAWAI_ID = pg2.PEGAWAI_ID)
				LEFT JOIN m_pegawai pg3 ON (t_irna.PEGAWAI_RAWAT_ID = pg3.PEGAWAI_ID)
				LEFT JOIN m_pegawai pg4 ON (t_irna.PEGAWAI_RAWAT_ID_2 = pg4.PEGAWAI_ID)
				LEFT JOIN m_pegawai pg5 ON (t_irna.PEGAWAI_RAWAT_ID_3 = pg5.PEGAWAI_ID)
				LEFT JOIN m_pegawai pg6 ON (t_irna.PEGAWAI_RAWAT_ID_4 = pg6.PEGAWAI_ID)
				LEFT JOIN m_pegawai pg7 ON (t_irna.PEGAWAI_RAWAT_ID_5 = pg7.PEGAWAI_ID)
				LEFT JOIN m_pegawai pg8 ON (t_irna.PEGAWAI_RAWAT_ID_6 = pg8.PEGAWAI_ID)
				LEFT JOIN m_asal_pasien ON (t_irja.ASAL_PASIEN_ID = m_asal_pasien.ASAL_PASIEN_ID)
				WHERE IRNA_ID = "' . $idx  . '"';
    $get_kunjungan = mysql_query($sql_kunjungan) or die(mysql_error());
    $dat_kunjungan = mysql_fetch_assoc($get_kunjungan);

    $nomr = $dat_kunjungan['NOMR'];
	$nama_unit = $dat_kunjungan['NAMA_UNIT'];
    $masuk_rs = $dat_kunjungan['PASIEN_MASUK_RS'];
	$dokter_dpjp = $dat_kunjungan['NAMA_PEGAWAI'];
	$unit_id = $dat_kunjungan['UNIT_ID'];
	$masuk_ruang = $dat_kunjungan['PASIEN_MASUK_RUANG'];
	$dokter_dpjp_ranap = $dat_kunjungan['NAMA_PEGAWAI2'];
	$penanggung_jawab = $dat_kunjungan['P_JAWAB_NAMA'];
	$penanggung_jawab_telp = $dat_kunjungan['P_JAWAB_NO_TELP'];
	$lama_rj = $dat_kunjungan['LAMA'];
	$dokter_rawat_1 = $dat_kunjungan['PEGAWAI_RAWAT_1'];
	$dokter_rawat_2 = $dat_kunjungan['PEGAWAI_RAWAT_2'];
	$dokter_rawat_3 = $dat_kunjungan['PEGAWAI_RAWAT_3'];
	$dokter_rawat_4 = $dat_kunjungan['PEGAWAI_RAWAT_4'];
	$dokter_rawat_5 = $dat_kunjungan['PEGAWAI_RAWAT_5'];
	$dokter_rawat_6 = $dat_kunjungan['PEGAWAI_RAWAT_6'];
	
	$pegawai_id = $dat_kunjungan['PEGAWAI_ID'];
	$pegawai_rawat_id_1 = $dat_kunjungan['PEGAWAI_RAWAT_ID'];
	$pegawai_rawat_id_2 = $dat_kunjungan['PEGAWAI_RAWAT_ID_2'];
	$pegawai_rawat_id_3 = $dat_kunjungan['PEGAWAI_RAWAT_ID_3'];
	$pegawai_rawat_id_4 = $dat_kunjungan['PEGAWAI_RAWAT_ID_4'];
	$pegawai_rawat_id_5 = $dat_kunjungan['PEGAWAI_RAWAT_ID_5'];
	$pegawai_rawat_id_6 = $dat_kunjungan['PEGAWAI_RAWAT_ID_6'];
    ?>
	<?php if(!isset($_GET['opt'])){ ?>
	<table width="100%" border="0">
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;">Masuk RS</td>
		<td width="15px;">:</td>
		<td width="500px;"><?php echo $masuk_rs; ?></td>
		<td width="200px;">Lama di <?php echo $nama_unit; ?></td>
		<td width="15px;">:</td>
		<td width="500px;"><?php echo $lama_rj; ?> hari</td>
		<td></td>
	</tr>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;">Poliklinik/ Unit</td>
		<td width="15px;">:</td>
		<td width="500px;"><?php echo $nama_unit; ?></td>
		<td width="200px;">Dokter DPJP</td>
		<td width="15px;">:</td>
		<td width="500px;"><?php echo $dokter_dpjp; ?></td>
		<td></td>
	</tr>
	
	<?php $qry_diagnosa = 'SELECT t_irja_diagnosa.DIAGNOSA,
				CASE WHEN TRIM(t_irja_diagnosa.DIAGNOSA) = TRIM(m_icd_x.DESKRIPSI) THEN t_irja_diagnosa.ICD_CODE
				ELSE CONCAT(t_irja_diagnosa.ICD_CODE,"--",m_icd_x.DESKRIPSI) END AS ICD
			FROM t_irja_diagnosa
			LEFT JOIN m_icd_x ON (t_irja_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
			WHERE IRJA_ID = "' . $idx . '"
			AND DIAGNOSA_ORDER <= 3
			ORDER BY DIAGNOSA_ORDER';
		$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
		if(mysql_num_rows($get_diagnosa) == 0){ ?>
			<tr>
				<td width="15px;">&nbsp;</td>
				<td width="200px;">Diagnosa</td>
				<td width="15px;">:</td>
				<td width="500px;"></td>
				<td width="200px;"></td>
				<td width="15px;"></td>
				<td width="500px;"></td>
				<td></td>
			</tr>
	<?php	}else{ 
		$d = 0;
		while($dat_diagnosa = mysql_fetch_array($get_diagnosa)){ 
			if($d == 0){ ?>
				<tr>
				<td width="15px;">&nbsp;</td>
				<td width="200px;">Diagnosa</td>
				<td width="15px;">:</td>
				<td width="500px;"><?php echo $dat_diagnosa['DIAGNOSA'] . ' ' . $dat_diagnosa['ICD']; ?></td>
				<td width="200px;"></td>
				<td width="15px;"></td>
				<td width="500px;"></td>
				<td></td>
			</tr>
			<?php }else{ ?>
				<tr>
				<td width="15px;">&nbsp;</td>
				<td width="200px;"></td>
				<td width="15px;"></td>
				<td width="500px;"><?php echo $dat_diagnosa['DIAGNOSA'] . ' ' . $dat_diagnosa['ICD']; ?></td>
				<td width="200px;"></td>
				<td width="15px;"></td>
				<td width="500px;"></td>
				<td></td>
			</tr>
			<?php }
			$d++;	
		} ?>
	<?php } ?>
	
	<?php $qry_diagnosa = 'SELECT t_irja_diagnosa.DIAGNOSA,
				CASE WHEN TRIM(t_irja_diagnosa.DIAGNOSA) = TRIM(m_icd_x.DESKRIPSI) THEN t_irja_diagnosa.ICD_CODE
				ELSE CONCAT(t_irja_diagnosa.ICD_CODE,"--",m_icd_x.DESKRIPSI) END AS ICD
			FROM t_irja_diagnosa
			LEFT JOIN m_icd_x ON (t_irja_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
			WHERE IRJA_ID = "' . $idx . '"
			AND DIAGNOSA_ORDER >= 4
			ORDER BY DIAGNOSA_ORDER';
		$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
		if(mysql_num_rows($get_diagnosa) == 0){ ?>
			<tr>
				<td width="15px;">&nbsp;</td>
				<td width="200px;">Diagnosa Banding</td>
				<td width="15px;">:</td>
				<td width="500px;"></td>
				<td width="200px;"></td>
				<td width="15px;"></td>
				<td width="500px;"></td>
				<td></td>
			</tr>	
	<?php	}else{ 
		$d = 0;
		while($dat_diagnosa = mysql_fetch_array($get_diagnosa)){ 
			if($d == 0){ ?>
				<tr>
				<td width="15px;">&nbsp;</td>
				<td width="200px;">Diagnosa Banding</td>
				<td width="15px;">:</td>
				<td width="500px;"><?php echo $dat_diagnosa['DIAGNOSA'] . ' ' . $dat_diagnosa['ICD']; ?></td>
				<td width="200px;"></td>
				<td width="15px;"></td>
				<td width="500px;"></td>
				<td></td>
			</tr>	
			<?php }else{ ?>
					<tr>
				<td width="15px;">&nbsp;</td>
				<td width="200px;"></td>
				<td width="15px;"></td>
				<td width="500px;"><?php echo $dat_diagnosa['DIAGNOSA'] . ' ' . $dat_diagnosa['ICD']; ?></td>
				<td width="200px;"></td>
				<td width="15px;"></td>
				<td width="500px;"></td>
				<td></td>
			</tr>
			<?php }
			$d++;	
		} ?>
	<?php } ?>		
	
	<?php
	$new_line = htmlspecialchars('<br>');
	$terapi = '';
	$qry_cppt = 'SELECT HASIL_ASESMEN FROM t_irja_perkembangan WHERE IRJA_ID = "' . $idx . '"';
	$get_cppt = mysql_query($qry_cppt) or die(mysql_error());
	$dat_cppt = mysql_fetch_assoc($get_cppt);
	$hasil_asesmen = str_replace('|','"',$dat_cppt['HASIL_ASESMEN']);
	$hasil_asesmen = str_replace($new_line,'<br>',$hasil_asesmen);
	$hasil_asesmen = preg_replace('/\r|\n/','<br>',trim($hasil_asesmen));
	$hasil_asesmen = json_decode($hasil_asesmen,true);	
	if(isset($hasil_asesmen['p']) and $hasil_asesmen['p'] != ''){
		$terapi = $hasil_asesmen['p'];
	}else{
		$qry_pengkajian = 'SELECT RENCANA_TATALAKSANA AS TERAPI FROM t_irja_pengkajian_awal_medis WHERE IRJA_ID = "' . $idx . '"';
		if($unit_id == '5') $qry_pengkajian = 'SELECT TERAPI FROM t_irja_pengkajian_awal_medis_gigi WHERE IRJA_ID = "' . $idx . '"';
		if($unit_id == '9') $qry_pengkajian = 'SELECT PLANNING FROM t_igd_pengkajian_medis WHERE IRJA_ID = "' . $idx . '"';
		if($unit_id == '29') $qry_pengkajian = 'SELECT RENCANA_TATALAKSANA AS TERAPI FROM t_irja_pengkajian_awal_medis_mata WHERE IRJA_ID = "' . $idx . '"';
		if($unit_id == '35') $qry_pengkajian = 'SELECT RENCANA_TATALAKSANA AS TERAPI FROM t_irja_pengkajian_awal_medis_kusta WHERE IRJA_ID = "' . $idx . '"';
	
		$get_pengkajian = mysql_query($qry_pengkajian) or die(mysql_error());
		$dat_pengkajian = mysql_fetch_assoc($get_pengkajian);
		if($unit_id == '9'){
			$planning = str_replace('|','"',$dat_pengkajian['PLANNING']);
			$planning = preg_replace('/\r|\n/','\n',trim($planning));
			$planning = json_decode($planning,true);
			$terapi = ((isset($planning['pengobatan'])) ? $planning['pengobatan'] : '');
		}else{
			$terapi = $dat_pengkajian['TERAPI'];
		}	
	}
	?>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;">Terapi</td>
		<td width="15px;">:</td>
		<td width="500px;"><?php echo $terapi; ?></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td></td>
	</tr>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td></td>
	</tr>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;">Masuk Rawat Inap</td>
		<td width="15px;">:</td>
		<td width="500px;"><?php echo $masuk_ruang; ?></td>
		<td width="200px;">Dokter DPJP</td>
		<td width="15px;">:</td>
		<td width="500px;"><?php echo $dokter_dpjp_ranap; ?></td>
		<td></td>
	</tr>
	<?php if($dokter_rawat_1 != ''){ ?>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;">Tim Dokter Yang Merawat</td>
		<td width="15px;">:</td>
		<td width="500px;">- <?php echo $dokter_rawat_1; ?></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td></td>
	</tr>
	<?php }else{ ?>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;">Tim Dokter Yang Merawat</td>
		<td width="15px;">:</td>
		<td width="500px;"></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td></td>
	</tr>
	<?php } ?>
	<?php if($dokter_rawat_2 != ''){ ?>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;">- <?php echo $dokter_rawat_2; ?></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td></td>
	</tr>
	<?php } ?>
	<?php if($dokter_rawat_3 != ''){ ?>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;">- <?php echo $dokter_rawat_3; ?></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td></td>
	</tr>
	<?php } ?>
	<?php if($dokter_rawat_4 != ''){ ?>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;">- <?php echo $dokter_rawat_4; ?></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td></td>
	</tr>
	<?php } ?>
	<?php if($dokter_rawat_5 != ''){ ?>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;">- <?php echo $dokter_rawat_5; ?></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td></td>
	</tr>
	<?php } ?>
	<?php if($dokter_rawat_6 != ''){ ?>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;">- <?php echo $dokter_rawat_6; ?></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td></td>
	</tr>
	<?php } ?>
	
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td></td>
	</tr>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;">Penanggung Jawab Pasien</td>
		<td width="15px;">:</td>
		<td width="500px;"><?php echo $penanggung_jawab; ?></td>
		<td width="200px;">Nomor Telepon</td>
		<td width="15px;">:</td>
		<td width="500px;"><?php echo $penanggung_jawab_telp; ?></td>
		<td></td>
	</tr>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td></td>
	</tr>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;" align="right"><a href="<?php echo currentUrl(); ?>&opt=ed" ><input type="button" class="myButton1" value="ubah tim dokter" /></a></td>
		<td></td>
	</tr>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td></td>
	</tr>
	</table>
	<?php }else{ ?>
	<form name="formrujukan" id="formrujukan" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
	<table width="100%" border="0">
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;">Dokter DPJP</td>
		<td width="15px;">:</td>
		<td width="500px;"><select name="pegawai_id" id="pegawai_id" style="width:328px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getDokterRanap($pegawai_id); ?>
			</select></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td></td>
	</tr>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;">Tim Dokter Yang Merawat</td>
		<td width="15px;">:</td>
		<td width="500px;"><select name="pegawai_rawat_id_1" id="pegawai_rawat_id_1" style="width:328px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getDokterRanap($pegawai_rawat_id_1); ?>
			</select></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td></td>
	</tr>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"><select name="pegawai_rawat_id_2" id="pegawai_rawat_id_2" style="width:328px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getDokterRanap($pegawai_rawat_id_2); ?>
			</select></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td></td>
	</tr>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"><select name="pegawai_rawat_id_3" id="pegawai_rawat_id_3" style="width:328px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getDokterRanap($pegawai_rawat_id_3); ?>
			</select></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td></td>
	</tr>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"><select name="pegawai_rawat_id_4" id="pegawai_rawat_id_4" style="width:328px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getDokterRanap($pegawai_rawat_id_4); ?>
			</select></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td></td>
	</tr>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"><select name="pegawai_rawat_id_5" id="pegawai_rawat_id_5" style="width:328px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getDokterRanap($pegawai_rawat_id_5); ?>
			</select></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td></td>
	</tr>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"><select name="pegawai_rawat_id_6" id="pegawai_rawat_id_6" style="width:328px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getDokterRanap($pegawai_rawat_id_6); ?>
			</select></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td></td>
	</tr>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td></td>
	</tr>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"><?php if($_SESSION['SES_SIMRS_ADMIN'] == '1'){ ?><input type="button" name="simpan" class="myButton1" value="simpan" onclick="simpan_submit();" /><?php } ?></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;" align="right"></td>
		<td></td>
	</tr>
	<tr>
		<td width="15px;">&nbsp;</td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td width="200px;"></td>
		<td width="15px;"></td>
		<td width="500px;"></td>
		<td></td>
	</tr>
	</table>
	</form>
	<script language="JavaScript" >
		function simpan_submit(){
		_haschange = false;
		$('#formrujukan').submit();
	}	
    </script>
	<?php } ?>