<?php 
$idx = $_GET['idx'];
$qry_pasien = 'SELECT t_rawat.RAWAT_ID,t_rawat.NOMR,m_pasien.NAMA_PASIEN,
				DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
				DATE_FORMAT(t_rawat.TANGGAL_DAFTAR,"%d/%m/%Y") AS TGL_MASUK,
				DATE_FORMAT(t_rawat.PASIEN_KELUAR,"%d/%m/%Y") AS TGL_KELUAR,
				m_pasien.JNS_KELAMIN,m_unit.NAMA_UNIT,m_ruang.NAMA_RUANG,
				pi.NO_FOR_SUR,pi.CARA_DIRAWAT,pi.SEBAB_KELUAR,pi.DIAGNOSA_AKHIR,
				pi.FAKTOR_RESIKO_OPERASI,pi.AHLI_BEDAH,pi.SCRUBE_NURSE,pi.JENIS_OPERASI,
				pi.TIPE_OPERASI,pi.JENIS_LUKA,pi.LAMA_OPERASI,pi.ASA_SCORE,pi.RISK_SCORE,
				DATE_FORMAT(pi.TGL_KELUAR,"%d/%m/%Y") AS TGL_KELUAR,
				DATE_FORMAT(pi.TGL_PASANG_CATETER_PERIFER,"%d/%m/%Y") AS TGL_PASANG_CATETER_PERIFER,
				DATE_FORMAT(pi.TGL_PASANG_CATETER_SENTRAL,"%d/%m/%Y") AS TGL_PASANG_CATETER_SENTRAL,
				DATE_FORMAT(pi.TGL_PASANG_CATETER_URINE,"%d/%m/%Y") AS TGL_PASANG_CATETER_URINE,
				DATE_FORMAT(pi.TGL_PASANG_VENTILASI_MEKANIK,"%d/%m/%Y") AS TGL_PASANG_VENTILASI_MEKANIK,
				DATE_FORMAT(pi.SD_PASANG_CATETER_PERIFER,"%d/%m/%Y") AS SD_PASANG_CATETER_PERIFER,
				DATE_FORMAT(pi.SD_PASANG_CATETER_SENTRAL,"%d/%m/%Y") AS SD_PASANG_CATETER_SENTRAL,
				DATE_FORMAT(pi.SD_PASANG_CATETER_URINE,"%d/%m/%Y") AS SD_PASANG_CATETER_URINE,
				DATE_FORMAT(pi.SD_PASANG_VENTILASI_MEKANIK,"%d/%m/%Y") AS SD_PASANG_VENTILASI_MEKANIK,
				BB_LAHIR,pi.BB_SEKARANG,pi.KONDISI_GIZI,pi.PEMAKAIAN_ANTIBIOTIKA,pi.NAMA_JENIS_OBAT,
				pi.PEMERIKSAAN_KULTUR,pi.TEMP,pi.HASIL_KULTUR,pi.INFEKSI_NOSOKIMIAL,pi.BAKTEREMIA,pi.VAP,
				pi.SALURAN_KEMIH,pi.LUKA_OPERASI,pi.DEKUBITUS,pi.PLEBITIS,pi.INFEKSI_LAIN,pi.FAKTOR_RESIKO,
				m_pegawai.NAMA_PEGAWAI AS NAMA_AHLI_BEDAH,m_pegawai2.NAMA_PEGAWAI AS NAMA_SCRUB_NURSE
				FROM (
					SELECT t_irja.IRJA_ID AS RAWAT_ID,t_irja.NOMR,
					t_irja.TANGGAL_DAFTAR,t_irja.PASIEN_KELUAR,
					t_irja.UNIT_ID,NULL AS RUANG_ID
					FROM t_irja
					WHERE t_irja.IRJA_ID NOT IN (SELECT t_irna.IRNA_ID FROM t_irna WHERE t_irna.NOMR = t_irja.NOMR
					AND t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL)
					AND t_irja.IRJA_ID = "' . $idx . '"	
					UNION ALL
					SELECT t_irja.IRJA_ID AS RAWAT_ID,t_irja.NOMR,
					t_irja.TANGGAL_DAFTAR,t_irna.PASIEN_KELUAR,
					t_irja.UNIT_ID,t_irna.RUANG_ID
					FROM t_irja
					INNER JOIN t_irna ON (t_irja.IRJA_ID = t_irna.IRNA_ID)
					WHERE t_irja.IRJA_ID = "' . $idx . '"	
				) t_rawat
				INNER JOIN m_pasien ON (t_rawat.NOMR = m_pasien.NOMR)
				LEFT JOIN m_unit ON (t_rawat.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_ruang ON (t_rawat.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN t_irna_askep_pengendalian_infeksi pi 
				ON (t_rawat.RAWAT_ID = pi.PENGENDALIAN_INFEKSI_ID)
				LEFT JOIN m_pegawai ON (pi.AHLI_BEDAH = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (pi.SCRUBE_NURSE = m_pegawai2.PEGAWAI_ID)';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$nomr = $dat_pasien['NOMR'];
$tgl_lahir = $dat_pasien['TGL_LAHIR'];
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$no_for_sur = $dat_pasien['NO_FOR_SUR'];
$cara_dirawat = $dat_pasien['CARA_DIRAWAT'];
$tgl_keluar = $dat_pasien['TGL_KELUAR'];
$sebab_keluar = $dat_pasien['SEBAB_KELUAR'];
$diagnosa_akhir = $dat_pasien['DIAGNOSA_AKHIR'];
$faktor_resiko_operasi = $dat_pasien['FAKTOR_RESIKO_OPERASI'];
$ahli_bedah = $dat_pasien['NAMA_AHLI_BEDAH'];
$scrube_nurse = $dat_pasien['NAMA_SCRUB_NURSE'];
$jenis_operasi = $dat_pasien['JENIS_OPERASI'];
$tipe_operasi = $dat_pasien['TIPE_OPERASI'];
$jenis_luka = $dat_pasien['JENIS_LUKA'];
$lama_operasi = $dat_pasien['LAMA_OPERASI'];
$asa_score = $dat_pasien['ASA_SCORE'];
$risk_score = $dat_pasien['RISK_SCORE'];
$tgl_pasang_cateter_perifer = $dat_pasien['TGL_PASANG_CATETER_PERIFER'];
$tgl_pasang_cateter_sentral = $dat_pasien['TGL_PASANG_CATETER_SENTRAL'];
$tgl_pasang_cateter_urine = $dat_pasien['TGL_PASANG_CATETER_URINE'];
$tgl_pasang_ventilasi_mekanik = $dat_pasien['TGL_PASANG_VENTILASI_MEKANIK'];
$sd_pasang_cateter_perifer = $dat_pasien['SD_PASANG_CATETER_PERIFER'];
$sd_pasang_cateter_sentral = $dat_pasien['SD_PASANG_CATETER_SENTRAL'];
$sd_pasang_cateter_urine = $dat_pasien['SD_PASANG_CATETER_URINE'];
$sd_pasang_ventilasi_mekanik = $dat_pasien['SD_PASANG_VENTILASI_MEKANIK'];
$bb_lahir = $dat_pasien['BB_LAHIR'];
$bb_sekarang = $dat_pasien['BB_SEKARANG'];
$kondisi_gizi = $dat_pasien['KONDISI_GIZI'];
$pemakaian_antibiotika = $dat_pasien['PEMAKAIAN_ANTIBIOTIKA'];
$nama_jenis_obat = $dat_pasien['NAMA_JENIS_OBAT'];
$pemeriksaan_kultur = $dat_pasien['PEMERIKSAAN_KULTUR'];
$temp = $dat_pasien['TEMP'];
$hasil_kultur = $dat_pasien['HASIL_KULTUR'];
$infeksi_nosokimial = $dat_pasien['INFEKSI_NOSOKIMIAL'];
$bakteremia = $dat_pasien['BAKTEREMIA'];
$vap = $dat_pasien['VAP'];
$saluran_kemih = $dat_pasien['SALURAN_KEMIH'];
$luka_operasi = $dat_pasien['LUKA_OPERASI'];
$dekubitus = $dat_pasien['DEKUBITUS'];
$plebitis = $dat_pasien['PLEBITIS'];
$infeksi_lain = $dat_pasien['INFEKSI_LAIN'];
$faktor_resiko = $dat_pasien['FAKTOR_RESIKO'];

$arr_jenis_operasi = explode('|',$jenis_operasi);
$arr_pemakaian_antibiotika = explode('|',$pemakaian_antibiotika);
$arr_pemeriksaan_kultur = explode('|',$pemeriksaan_kultur);
?>
<div style=" height:auto; padding:15px; ">
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; padding-left:35px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">   
		<table border="0" width="80%">
<tr>
	<td colspan="5"><strong>DATA PASIEN</strong></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Nama Pasien</td>
	<td><input type="text" name="nama_pasien" id="nama_pasien" value="<?php echo $nama_pasien; ?>" class="text_dt" style="width:300px;" /></td>
    <td width="200px">No. Rekam Medik</td>
	<td><input type="text" name="nomr" id="nomr" value="<?php echo $nomr; ?>" class="text_dt" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Tanggal Lahir</td>
	<td><input type="text" name="tgl_lahir" id="tgl_lahir" value="<?php echo $tgl_lahir; ?>" class="text_dt" /></td>
    <td width="200px">No. For. Sur</td>
	<td><input type="text" name="no_for_sur" id="no_for_sur" value="<?php echo $no_for_sur; ?>" class="text_dt" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Jenis Kelamin</td>
	<td><input type="radio" name="jns_kelamin" id="jns_kelamin" value="L" <?php if($jns_kelamin=='L') echo 'checked="checked"'; ?> />&nbsp;Laki-laki
		<input type="radio" name="jns_kelamin" id="jns_kelamin" value="P" <?php if($jns_kelamin=='P') echo 'checked="checked"'; ?> />&nbsp;Perempuan</td>
    <td>Cara Dirawat</td>
	<td>
		<input type="radio" name="cara_dirawat" id="cara_dirawat" value="1" <?php if($cara_dirawat=='1') echo 'checked="checked"'; ?> />&nbsp;Emergency
		<input type="radio" name="cara_dirawat" id="cara_dirawat" value="2" <?php if($cara_dirawat=='2') echo 'checked="checked"'; ?> />&nbsp;Elektif
	</td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
	<td colspan="5"><strong>TEMPAT DIRAWAT</strong></td>
</tr>
<tr>
	<td colspan="5">
		<table width="100%" border="0">
			<?php
			$sql_dirawat = 'SELECT INFEKSI_RAWAT_ID,PENGENDALIAN_INFEKSI_ID,RUANG_RAWAT,
					DATE_FORMAT(TANGGAL_DIRAWAT,"%d/%m/%Y") AS TANGGAL_DIRAWAT,
					DATE_FORMAT(SD_DIRAWAT,"%d/%m/%Y") AS SD_DIRAWAT,NAMA_RUANG
					FROM t_irna_askep_pengendalian_infeksi_rawat
					LEFT JOIN m_ruang 
					ON (t_irna_askep_pengendalian_infeksi_rawat.RUANG_RAWAT = m_ruang.RUANG_ID)
					WHERE PENGENDALIAN_INFEKSI_ID = "' . $idx . '"';
			$get_dirawat = mysql_query($sql_dirawat) or die(mysql_error());
			if(mysql_num_rows($get_dirawat) > 0){
			while($dat_dirawat = mysql_fetch_array($get_dirawat)){	
			?>
			<tr>
				<td width="200px">&nbsp;Ruang</td>
				<td width="240px"><input type="text" name="ruang_rawat" id="ruang_rawat" class="text_dt" style="width:300px;" value="<?php echo $dat_dirawat['NAMA_RUANG']; ?>" /></td>
				<td width="200px">Tanggal <input type="text" name="tanggal_dirawat" id="tgl_edu_1" class="text_dt" value="<?php echo $dat_dirawat['TANGGAL_DIRAWAT']; ?>" /></td>
				<td width="200px">Sd <input type="text" name="tanggal_dirawat" id="tgl_edu_1" class="text_dt" value="<?php echo $dat_dirawat['SD_DIRAWAT']; ?>" /></td>
			</tr>	
			<?php } 
			}else{ ?>
			<tr>
			<td width="200px">&nbsp;Ruang</td>
			<td width="240px"><input type="text" name="ruang_rawat" id="ruang_rawat" class="text_dt" style="width:300px;"/></td>
			<td width="200px">Tanggal <input type="text" name="tanggal_dirawat" id="tgl_edu_1" class="text_dt" /></td>
			<td width="200px">Sd <input type="text" name="sd_dirawat" id="tgl_edu_2" class="text_dt" /></td>
			</tr>
			<?php } ?>
		</table>
	</td>	
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>Tanggal Keluar</td>
	<td colspan="3"><input type="text" name="tgl_keluar" id="tgl_edu_3" value="<?php echo $tgl_keluar; ?>" class="text_dt" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Sebab Keluar</td>
	<td colspan="3"><input type="text" name="sebab_keluar" id="sebab_keluar" value="<?php echo $sebab_keluar; ?>" class="text_dt" style="width:600px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Diagnosa Akhir</td>
	<td colspan="3"><input type="text" name="diagnosa_akhir" id="diagnosa_akhir" value="<?php echo $diagnosa_akhir; ?>" class="text_dt" style="width:600px;" /></td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
	<td colspan="2"><strong>FAKTOR RESIKO</strong></td>
	<td colspan="3"><input type="text" name="faktor_resiko" id="faktor_resiko" value="<?php echo $faktor_resiko; ?>" class="text_dt" style="width:600px;" /></td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
	<td colspan="5"><strong>OPERASI</strong></td>
</tr>
<tr>	
	<td>&nbsp;</td>
	<td>Ahli Bedah</td>
	<td><input type="text" name="ahli_bedah" id="ahli_bedah" class="text_dt" style="width:200px;" value="<?php echo $ahli_bedah; ?>" /></td>
	<td>Scrub Nurse</td>
	<td><input type="text" name="scrube_nurse" id="scrube_nurse" class="text_dt" style="width:200px;" value="<?php echo $scrube_nurse; ?>" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Jenis Operasi</td>
	<td colspan="3">
	<input type="checkbox" name="jenis_operasi_1" id="jenis_operasi_1" value="1" <?php if(isset($arr_jenis_operasi[0]) and $arr_jenis_operasi[0]=='1') echo 'checked="checked"'; ?> />&nbsp;Apendik
	<input type="checkbox" name="jenis_operasi_2" id="jenis_operasi_2" value="1" <?php if(isset($arr_jenis_operasi[1]) and $arr_jenis_operasi[1]=='1') echo 'checked="checked"'; ?> />&nbsp;CABG
	<input type="checkbox" name="jenis_operasi_3" id="jenis_operasi_3" value="1" <?php if(isset($arr_jenis_operasi[2]) and $arr_jenis_operasi[2]=='1') echo 'checked="checked"'; ?> />&nbsp;Hernia
	<input type="checkbox" name="jenis_operasi_4" id="jenis_operasi_4" value="1" <?php if(isset($arr_jenis_operasi[3]) and $arr_jenis_operasi[3]=='1') echo 'checked="checked"'; ?> />&nbsp;Dll
	<input type="text" name="jenis_operasi_5" id="jenis_operasi_5" value="<?php if(isset($arr_jenis_operasi[4])) echo $arr_jenis_operasi[4]; ?>" class="text_dt" style="width:280px;" />
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Tipe Operasi</td>
	<td colspan="3">
	<input type="radio" name="tipe_operasi" id="tipe_operasi" value="1" <?php if($tipe_operasi=='1') echo 'checked="checked"'; ?> />&nbsp;Terbuka
	<input type="radio" name="tipe_operasi" id="tipe_operasi" value="2" <?php if($tipe_operasi=='2') echo 'checked="checked"'; ?> />&nbsp;Tertutup
	</td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td>Jenis Luka</td>
	<td colspan="3">
	<input type="radio" name="jenis_luka" id="jenis_luka" value="1" <?php if($jenis_luka=='1') echo 'checked="checked"'; ?> />&nbsp;Bersih 
	<input type="radio" name="jenis_luka" id="jenis_luka" value="2" <?php if($jenis_luka=='2') echo 'checked="checked"'; ?> />&nbsp;Bersih Kontaminasi
	<input type="radio" name="jenis_luka" id="jenis_luka" value="3" <?php if($jenis_luka=='3') echo 'checked="checked"'; ?> />&nbsp;Kontaminasi
	<input type="radio" name="jenis_luka" id="jenis_luka" value="4" <?php if($jenis_luka=='4') echo 'checked="checked"'; ?> />&nbsp;Kotor
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Lama Operasi</td>
	<td colspan="3">
	<input type="radio" name="lama_operasi" id="lama_operasi" value="1" <?php if($lama_operasi=='1') echo 'checked="checked"'; ?> />&nbsp;1 jam
	<input type="radio" name="lama_operasi" id="lama_operasi" value="2" <?php if($lama_operasi=='2') echo 'checked="checked"'; ?> />&nbsp;2 jam
	<input type="radio" name="lama_operasi" id="lama_operasi" value="3" <?php if($lama_operasi=='3') echo 'checked="checked"'; ?> />&nbsp;5 jam
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>ASA Score</td>
	<td colspan="3"><input type="text" name="asa_score" id="asa_score" value="<?php echo $asa_score; ?>" class="text_dt" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Risk Score</td>
	<td colspan="3"><input type="text" name="risk_score" id="risk_score" value="<?php echo $risk_score; ?>" class="text_dt" /></td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
	<td colspan="5"><strong>PEMASANGAN ALAT</strong></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Intra vena cateter perifer</td>
	<td colspan="3">Tanggal <input type="text" name="tgl_pasang_cateter_perifer" id="tgl_edu_4" value="<?php echo $tgl_pasang_cateter_perifer; ?>" class="text_dt" />
	S.d <input type="text" name="sd_pasang_cateter_perifer" id="tgl_edu_5" value="<?php echo $sd_pasang_cateter_perifer; ?>" class="text_dt" />
	</td>
</tr>
<tr>	
	<td>&nbsp;</td>
    <td>Intra vena cateter sentral</td>
	<td colspan="3">Tanggal <input type="text" name="tgl_pasang_cateter_sentral" id="tgl_edu_6" value="<?php echo $tgl_pasang_cateter_sentral; ?>" class="text_dt" />
	S.d <input type="text" name="sd_pasang_cateter_sentral" id="tgl_edu_7" value="<?php echo $sd_pasang_cateter_perifer; ?>" class="text_dt" />
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Kateter urine</td>
	<td colspan="3">Tanggal <input type="text" name="tgl_pasang_cateter_urine" id="tgl_edu_8" value="<?php echo $tgl_pasang_cateter_urine; ?>" class="text_dt" />
	S.d <input type="text" name="sd_pasang_cateter_urine" id="tgl_edu_9" value="<?php echo $sd_pasang_cateter_urine; ?>" class="text_dt" />
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Ventilasi mekanik</td>
	<td colspan="3">Tanggal <input type="text" name="tgl_pasang_ventilasi_mekanik" id="tgl_edu_10" value="<?php echo $tgl_pasang_ventilasi_mekanik; ?>" class="text_dt" />
	S.d <input type="text" name="sd_pasang_ventilasi_mekanik" id="tgl_edu_11" value="<?php echo $sd_pasang_ventilasi_mekanik; ?>" class="text_dt" />
	</td>
</tr>
<tr>
	<td colspan="5">&nbsp;</td>
</tr>
<tr>
    <td colspan="2"><strong>PEMAKAIAN ANTIBIOTIKA</strong></td>
	<td colspan="3"><input type="radio" name="pemakaian_antibiotika_1" id="pemakaian_antibiotika_1" value="1" <?php if(isset($arr_pemakaian_antibiotika[0]) and $arr_pemakaian_antibiotika[0]=='1') echo 'checked="checked"'; ?> />&nbsp;Ada
	<input type="radio" name="pemakaian_antibiotika_1" id="pemakaian_antibiotika_1" value="2" <?php if(isset($arr_pemakaian_antibiotika[0]) and $arr_pemakaian_antibiotika[0]=='2') echo 'checked="checked"'; ?> />&nbsp;Tidak ada
	&nbsp;&nbsp;&nbsp;
	<input type="radio" name="pemakaian_antibiotika_2" id="pemakaian_antibiotika_2" value="1" <?php if(isset($arr_pemakaian_antibiotika[1]) and $arr_pemakaian_antibiotika[1]=='1') echo 'checked="checked"'; ?> />&nbsp;Profilaksis
	<input type="radio" name="pemakaian_antibiotika_2" id="pemakaian_antibiotika_2" value="2" <?php if(isset($arr_pemakaian_antibiotika[1]) and $arr_pemakaian_antibiotika[1]=='2') echo 'checked="checked"'; ?> />&nbsp;Pengobatan
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Nama/ jenis obat</td>
	<td><input type="text" name="nama_jenis_obat" id="nama_jenis_obat" value="<?php echo $nama_jenis_obat; ?>" class="text_dt" style="width:300px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Pemeriksaan kultur</td>
	<td colspan="3">
	<input type="checkbox" name="pemeriksaan_kultur_1" id="pemeriksaan_kultur_1" value="1" <?php if(isset($arr_pemeriksaan_kultur[0]) and $arr_pemeriksaan_kultur[0]=='1') echo 'checked="checked"'; ?> />&nbsp;Darah
	<input type="checkbox" name="pemeriksaan_kultur_2" id="pemeriksaan_kultur_2" value="1" <?php if(isset($arr_pemeriksaan_kultur[1]) and $arr_pemeriksaan_kultur[1]=='1') echo 'checked="checked"'; ?> />&nbsp;Urine
	<input type="checkbox" name="pemeriksaan_kultur_3" id="pemeriksaan_kultur_3" value="1" <?php if(isset($arr_pemeriksaan_kultur[2]) and $arr_pemeriksaan_kultur[2]=='1') echo 'checked="checked"'; ?> />&nbsp;Sputum
	<input type="checkbox" name="pemeriksaan_kultur_4" id="pemeriksaan_kultur_4" value="1" <?php if(isset($arr_pemeriksaan_kultur[3]) and $arr_pemeriksaan_kultur[3]=='1') echo 'checked="checked"'; ?> />&nbsp;Pus luka
	&nbsp;&nbsp;&nbsp;Temp <input type="text" name="temp" id="temp" value="<?php echo $temp; ?>" class="text_dt" /> 
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Hasil Kultur</td>
	<td colspan="3"><input type="text" name="hasil_kultur" id="hasil_kultur" value="<?php echo $hasil_kultur; ?>" class="text_dt" style="width:600px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Infeksi nosokimial yang terjadi</td>
	<td colspan="3"><input type="text" name="infeksi_nosokimial" id="infeksi_nosokimial" value="<?php echo $infeksi_nosokimial; ?>" class="text_dt" style="width:600px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Bakteremia/ sepsis</td>
	<td colspan="3"><input type="text" name="bakteremia" id="bakteremia" value="<?php echo $bakteremia; ?>" class="text_dt" style="width:600px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>VAP</td>
	<td colspan="3"><input type="text" name="vap" id="vap" value="<?php echo $vap; ?>" class="text_dt" style="width:600px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Infeksi saluran kemih</td>
	<td colspan="3"><input type="text" name="saluran_kemih" id="saluran_kemih" value="<?php echo $saluran_kemih; ?>" class="text_dt" style="width:600px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Infeksi luka operasi</td>
	<td colspan="3"><input type="text" name="luka_operasi" id="luka_operasi" value="<?php echo $luka_operasi; ?>" class="text_dt" style="width:600px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Dekubitus</td>
	<td colspan="3"><input type="text" name="dekubitus" id="dekubitus" value="<?php echo $dekubitus; ?>" class="text_dt" style="width:600px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Plebitis</td>
	<td colspan="3"><input type="text" name="plebitis" id="plebitis" value="<?php echo $plebitis; ?>" class="text_dt" style="width:600px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Infeksi lain HIV, HBV, HCV</td>
	<td colspan="3"><input type="text" name="infeksi_lain" id="infeksi_lain" value="<?php echo $infeksi_lain; ?>" class="text_dt" style="width:600px;" /></td>
</tr>
</table>
<table border="0" width="100%">
<tr>
	<td>&nbsp;</td>
    <td width="260px">&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
	<td align="right">
		<a href="index.php?link=55c4f9eaad96d3329b6203ce8fe6d478">
		<input type="button" value="tutup" class="myButton" />
		</a></td>
</tr>		
</table>
</div>
</div> 