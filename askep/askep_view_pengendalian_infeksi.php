<?php 
$irna_id = $_GET['idx'];

$qry_askep = 'SELECT PENGENDALIAN_INFEKSI_ID,NO_FOR_SUR,CARA_DIRAWAT,SEBAB_KELUAR,DIAGNOSA_AKHIR,
				FAKTOR_RESIKO_OPERASI,AHLI_BEDAH,SCRUBE_NURSE,
				JENIS_OPERASI,TIPE_OPERASI,JENIS_LUKA,LAMA_OPERASI,ASA_SCORE,RISK_SCORE,
				DATE_FORMAT(TGL_KELUAR,"%d/%m/%Y") AS TGL_KELUAR,
				DATE_FORMAT(TGL_PASANG_CATETER_PERIFER,"%d/%m/%Y") AS TGL_PASANG_CATETER_PERIFER,
				DATE_FORMAT(TGL_PASANG_CATETER_SENTRAL,"%d/%m/%Y") AS TGL_PASANG_CATETER_SENTRAL,
				DATE_FORMAT(TGL_PASANG_CATETER_URINE,"%d/%m/%Y") AS TGL_PASANG_CATETER_URINE,
				DATE_FORMAT(TGL_PASANG_VENTILASI_MEKANIK,"%d/%m/%Y") AS TGL_PASANG_VENTILASI_MEKANIK,
				DATE_FORMAT(SD_PASANG_CATETER_PERIFER,"%d/%m/%Y") AS SD_PASANG_CATETER_PERIFER,
				DATE_FORMAT(SD_PASANG_CATETER_SENTRAL,"%d/%m/%Y") AS SD_PASANG_CATETER_SENTRAL,
				DATE_FORMAT(SD_PASANG_CATETER_URINE,"%d/%m/%Y") AS SD_PASANG_CATETER_URINE,
				DATE_FORMAT(SD_PASANG_VENTILASI_MEKANIK,"%d/%m/%Y") AS SD_PASANG_VENTILASI_MEKANIK,
				BB_LAHIR,BB_SEKARANG,KONDISI_GIZI,PEMAKAIAN_ANTIBIOTIKA,NAMA_JENIS_OBAT,
				PEMERIKSAAN_KULTUR,TEMP,HASIL_KULTUR,INFEKSI_NOSOKIMIAL,BAKTEREMIA,VAP,
				SALURAN_KEMIH,LUKA_OPERASI,DEKUBITUS,PLEBITIS,INFEKSI_LAIN,USER_ASKEP,FAKTOR_RESIKO
				FROM t_irna_askep_pengendalian_infeksi
				WHERE PENGENDALIAN_INFEKSI_ID = "' . $irna_id . '"';
$get_askep = mysql_query($qry_askep) or die(mysql_error());
$dat_askep = mysql_fetch_assoc($get_askep);
$pengendalian_infeksi_id = $dat_askep['PENGENDALIAN_INFEKSI_ID'];
$no_for_sur = $dat_askep['NO_FOR_SUR'];
$tgl_keluar = $dat_askep['TGL_KELUAR'];
$cara_dirawat = $dat_askep['CARA_DIRAWAT'];
$sebab_keluar = $dat_askep['SEBAB_KELUAR'];
$diagnosa_akhir = $dat_askep['DIAGNOSA_AKHIR'];
$faktor_resiko_operasi = $dat_askep['FAKTOR_RESIKO_OPERASI'];
$ahli_bedah = $dat_askep['AHLI_BEDAH'];
$scrube_nurse = $dat_askep['SCRUBE_NURSE'];
$jenis_operasi = $dat_askep['JENIS_OPERASI'];
$tipe_operasi = $dat_askep['TIPE_OPERASI'];
$jenis_luka = $dat_askep['JENIS_LUKA'];
$lama_operasi = $dat_askep['LAMA_OPERASI'];
$asa_score = $dat_askep['ASA_SCORE'];
$risk_score = $dat_askep['RISK_SCORE'];
$tgl_pasang_cateter_perifer = $dat_askep['TGL_PASANG_CATETER_PERIFER'];
$tgl_pasang_cateter_sentral = $dat_askep['TGL_PASANG_CATETER_SENTRAL'];
$tgl_pasang_cateter_urine = $dat_askep['TGL_PASANG_CATETER_URINE'];
$tgl_pasang_ventilasi_mekanik = $dat_askep['TGL_PASANG_VENTILASI_MEKANIK'];
$sd_pasang_cateter_perifer = $dat_askep['SD_PASANG_CATETER_PERIFER'];
$sd_pasang_cateter_sentral = $dat_askep['SD_PASANG_CATETER_SENTRAL'];
$sd_pasang_cateter_urine = $dat_askep['SD_PASANG_CATETER_URINE'];
$sd_pasang_ventilasi_mekanik = $dat_askep['SD_PASANG_VENTILASI_MEKANIK'];
$bb_lahir = $dat_askep['BB_LAHIR'];
$bb_sekarang = $dat_askep['BB_SEKARANG'];
$kondisi_gizi = $dat_askep['KONDISI_GIZI'];
$pemakaian_antibiotika = $dat_askep['PEMAKAIAN_ANTIBIOTIKA'];
$nama_jenis_obat = $dat_askep['NAMA_JENIS_OBAT'];
$pemeriksaan_kultur = $dat_askep['PEMERIKSAAN_KULTUR'];
$temp = $dat_askep['TEMP'];
$hasil_kultur = $dat_askep['HASIL_KULTUR'];
$infeksi_nosokimial = $dat_askep['INFEKSI_NOSOKIMIAL'];
$bakteremia = $dat_askep['BAKTEREMIA'];
$vap = $dat_askep['VAP'];
$saluran_kemih = $dat_askep['SALURAN_KEMIH'];
$luka_operasi = $dat_askep['LUKA_OPERASI'];
$dekubitus = $dat_askep['DEKUBITUS'];
$plebitis = $dat_askep['PLEBITIS'];
$infeksi_lain = $dat_askep['INFEKSI_LAIN'];
$faktor_resiko = $dat_askep['FAKTOR_RESIKO'];

$arr_jenis_operasi = explode('|',$jenis_operasi);
$arr_pemakaian_antibiotika = explode('|',$pemakaian_antibiotika);
$arr_pemeriksaan_kultur = explode('|',$pemeriksaan_kultur);

$infeksi_rawat_id ='';
$ruang_rawat ='';
$tanggal_dirawat ='';
$sd_dirawat ='';
?>
<form name="formedukasi" method="post" action="<?php echo currentUrl(); ?>" >
<input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
<input type="hidden" name="pengendalian_infeksi_id" id="pengendalian_infeksi_id" value="<?php echo $pengendalian_infeksi_id; ?>" />
<table border="0" width="100%">
<tr>
	<td colspan="2">Data Pasien</td>
</tr>
<tr>
    <td width="200px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No. For. Sur</td>
	<td><input type="text" name="no_for_sur" id="no_for_sur" value="<?php echo $no_for_sur; ?>" class="text_dt" /></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cara Dirawat</td>
	<td>
		<input type="radio" name="cara_dirawat" id="cara_dirawat" value="1" <?php if($cara_dirawat=='1') echo 'checked="checked"'; ?> />&nbsp;Emergency
		<input type="radio" name="cara_dirawat" id="cara_dirawat" value="2" <?php if($cara_dirawat=='2') echo 'checked="checked"'; ?> />&nbsp;Elektif
	</td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td colspan="3">Tempat Dirawat</td>
</tr>
<tr>
	<td colspan="2">
	<table width="100%" border="0">
<?php
	$sql_dirawat = 'SELECT INFEKSI_RAWAT_ID,PENGENDALIAN_INFEKSI_ID,RUANG_RAWAT,
					DATE_FORMAT(TANGGAL_DIRAWAT,"%d/%m/%Y") AS TANGGAL_DIRAWAT,
					DATE_FORMAT(SD_DIRAWAT,"%d/%m/%Y") AS SD_DIRAWAT,NAMA_RUANG
					FROM t_irna_askep_pengendalian_infeksi_rawat
					LEFT JOIN m_ruang 
					ON (t_irna_askep_pengendalian_infeksi_rawat.RUANG_RAWAT = m_ruang.RUANG_ID)
					WHERE PENGENDALIAN_INFEKSI_ID = "' . $irna_id . '"';
	$get_dirawat = mysql_query($sql_dirawat) or die(mysql_error());
	while($dat_dirawat = mysql_fetch_array($get_dirawat)){	
?>
	<tr>
	<td width="200px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ruang : </td>
	<td width="240px"><?php echo $dat_dirawat['NAMA_RUANG']; ?></td>
	<td width="240px">Tanggal : <?php echo $dat_dirawat['TANGGAL_DIRAWAT']; ?></td>
	<td width="200px">Sd : <?php echo $dat_dirawat['SD_DIRAWAT']; ?></td>
	<td>
	<a href="<?php echo currentUrl(); ?>&idce=<?php echo $dat_dirawat['INFEKSI_RAWAT_ID']; ?>&nmce=<?php echo $dat_dirawat['NAMA_RUANG']; ?>" >ubah</a>
	<a href="<?php echo currentUrl(); ?>&idc=<?php echo $dat_dirawat['INFEKSI_RAWAT_ID']; ?>&nmc=<?php echo $dat_dirawat['NAMA_RUANG']; ?>" >hapus</a>
	</td>
	</tr>	
<?php } ?>
	<tr>
	<td width="200px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ruang
	<input type="hidden" name="infeksi_rawat_id" value="<?php echo $infeksi_rawat_id; ?>" /></td>
	<td width="240px"><select name="ruang_rawat" id="ruang_rawat" class="text_dt">
	<option> - </option>
	<?php echo getRuangRawat($ruang_rawat); ?>
	</select></td>
	<td width="240px">Tanggal <input type="text" name="tanggal_dirawat" id="tgl_edu_1" value="<?php echo $tanggal_dirawat; ?>" class="text_dt" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu1')"/></td>
	<td>Sd <input type="text" name="sd_dirawat" id="tgl_edu_2" value="<?php echo $sd_dirawat; ?>" class="text_dt" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu2')"/></td>
	<td>&nbsp;</td>
	</tr>
</table>
</td>	
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td>Tanggal Keluar</td>
	<td><input type="text" name="tgl_keluar" id="tgl_edu_3" value="<?php echo $tgl_keluar; ?>" class="text_dt" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu3')"/></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sebab Keluar</td>
	<td><input type="text" name="sebab_keluar" id="sebab_keluar" value="<?php echo $sebab_keluar; ?>" class="text_dt" style="width:600px;" /></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Diagnosa Akhir</td>
	<td><input type="text" name="diagnosa_akhir" id="diagnosa_akhir" value="<?php echo $diagnosa_akhir; ?>" class="text_dt" style="width:600px;" /></td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td>Faktor Resiko</td>
	<td><input type="text" name="faktor_resiko" id="faktor_resiko" value="<?php echo $faktor_resiko; ?>" class="text_dt" style="width:280px;" /></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Operasi</td>
	<td><input type="text" name="faktor_resiko_operasi" id="faktor_resiko_operasi" value="<?php echo $faktor_resiko_operasi; ?>" class="text_dt" style="width:280px;" />
	&nbsp;&nbsp;&nbsp;Ahli Bedah <select name="ahli_bedah" id="ahli_bedah" class="text_dt" style="width:200px;" >
	<option> - </option>
	<?php echo getDokter($ahli_bedah); ?>
	</select>
	&nbsp;&nbsp;&nbsp;Scrub Nurse <select name="scrube_nurse" id="scrube_nurse" class="text_dt" style="width:200px;" >
	<option> - </option>
	<?php echo getPerawat($scrube_nurse); ?>
	</select>
	</td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jenis Operasi</td>
	<td>
	<input type="checkbox" name="jenis_operasi_1" id="jenis_operasi_1" value="1" <?php if(isset($arr_jenis_operasi[0]) and $arr_jenis_operasi[0]=='1') echo 'checked="checked"'; ?> />&nbsp;Apendik
	<input type="checkbox" name="jenis_operasi_2" id="jenis_operasi_2" value="1" <?php if(isset($arr_jenis_operasi[1]) and $arr_jenis_operasi[1]=='1') echo 'checked="checked"'; ?> />&nbsp;CABG
	<input type="checkbox" name="jenis_operasi_3" id="jenis_operasi_3" value="1" <?php if(isset($arr_jenis_operasi[2]) and $arr_jenis_operasi[2]=='1') echo 'checked="checked"'; ?> />&nbsp;Hernia
	<input type="checkbox" name="jenis_operasi_4" id="jenis_operasi_4" value="1" <?php if(isset($arr_jenis_operasi[3]) and $arr_jenis_operasi[3]=='1') echo 'checked="checked"'; ?> />&nbsp;Dll
	<input type="text" name="jenis_operasi_5" id="jenis_operasi_5" value="<?php if(isset($arr_jenis_operasi[4])) echo $arr_jenis_operasi[4]; ?>" class="text_dt" style="width:280px;" />
	</td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tipe Operasi</td>
	<td>
	<input type="radio" name="tipe_operasi" id="tipe_operasi" value="1" <?php if($tipe_operasi=='1') echo 'checked="checked"'; ?> />&nbsp;Terbuka
	<input type="radio" name="tipe_operasi" id="tipe_operasi" value="2" <?php if($tipe_operasi=='2') echo 'checked="checked"'; ?> />&nbsp;Tertutup
	</td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jenis Luka</td>
	<td>
	<input type="radio" name="jenis_luka" id="jenis_luka" value="1" <?php if($jenis_luka=='1') echo 'checked="checked"'; ?> />&nbsp;Bersih 
	<input type="radio" name="jenis_luka" id="jenis_luka" value="2" <?php if($jenis_luka=='2') echo 'checked="checked"'; ?> />&nbsp;Bersih Kontaminasi
	<input type="radio" name="jenis_luka" id="jenis_luka" value="3" <?php if($jenis_luka=='3') echo 'checked="checked"'; ?> />&nbsp;Kontaminasi
	<input type="radio" name="jenis_luka" id="jenis_luka" value="4" <?php if($jenis_luka=='4') echo 'checked="checked"'; ?> />&nbsp;Kotor
	</td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lama Operasi</td>
	<td>
	<input type="radio" name="lama_operasi" id="lama_operasi" value="1" <?php if($lama_operasi=='1') echo 'checked="checked"'; ?> />&nbsp;1 jam
	<input type="radio" name="lama_operasi" id="lama_operasi" value="2" <?php if($lama_operasi=='2') echo 'checked="checked"'; ?> />&nbsp;2 jam
	<input type="radio" name="lama_operasi" id="lama_operasi" value="3" <?php if($lama_operasi=='3') echo 'checked="checked"'; ?> />&nbsp;5 jam
	</td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ASA Score</td><td><input type="text" name="asa_score" id="asa_score" value="<?php echo $asa_score; ?>" class="text_dt" /></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Risk Score</td><td><input type="text" name="risk_score" id="risk_score" value="<?php echo $risk_score; ?>" class="text_dt" /></td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td colspan="3">Pemasangan Alat</td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Intra vena cateter perifer</td>
	<td>Tanggal <input type="text" name="tgl_pasang_cateter_perifer" id="tgl_edu_4" value="<?php echo $tgl_pasang_cateter_perifer; ?>" class="text_dt" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu4')"/>
	S.d <input type="text" name="sd_pasang_cateter_perifer" id="tgl_edu_5" value="<?php echo $sd_pasang_cateter_perifer; ?>" class="text_dt" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu5')"/></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Intra vena cateter sentral</td>
	<td>Tanggal <input type="text" name="tgl_pasang_cateter_sentral" id="tgl_edu_6" value="<?php echo $tgl_pasang_cateter_sentral; ?>" class="text_dt" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu6')"/>
	S.d <input type="text" name="sd_pasang_cateter_sentral" id="tgl_edu_7" value="<?php echo $sd_pasang_cateter_perifer; ?>" class="text_dt" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu7')"/></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kateter urine</td>
	<td>Tanggal <input type="text" name="tgl_pasang_cateter_urine" id="tgl_edu_8" value="<?php echo $tgl_pasang_cateter_urine; ?>" class="text_dt" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu8')"/>
	S.d <input type="text" name="sd_pasang_cateter_urine" id="tgl_edu_9" value="<?php echo $sd_pasang_cateter_urine; ?>" class="text_dt" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu9')"/></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ventilasi mekanik</td>
	<td>Tanggal <input type="text" name="tgl_pasang_ventilasi_mekanik" id="tgl_edu_10" value="<?php echo $tgl_pasang_ventilasi_mekanik; ?>" class="text_dt" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu10')"/>
	S.d <input type="text" name="sd_pasang_ventilasi_mekanik" id="tgl_edu_11" value="<?php echo $sd_pasang_ventilasi_mekanik; ?>" class="text_dt" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu11')"/></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BB Lahir</td>
	<td><input type="text" name="bb_lahir" id="bb_lahir" value="<?php echo $bb_lahir; ?>" class="text_dt" /></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BB Sekarang</td>
	<td><input type="text" name="bb_sekarang" id="bb_sekarang" value="<?php echo $bb_sekarang; ?>" class="text_dt" /></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kondisi Gizi</td>
	<td><input type="text" name="kondisi_gizi" id="kondisi_gizi" value="<?php echo $kondisi_gizi; ?>" class="text_dt" /></td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
    <td>Pemakaian Antibiotika</td>
	<td>
	<input type="radio" name="pemakaian_antibiotika_1" id="pemakaian_antibiotika_1" value="1" <?php if(isset($arr_pemakaian_antibiotika[0]) and $arr_pemakaian_antibiotika[0]=='1') echo 'checked="checked"'; ?> />&nbsp;Ada
	<input type="radio" name="pemakaian_antibiotika_1" id="pemakaian_antibiotika_1" value="2" <?php if(isset($arr_pemakaian_antibiotika[0]) and $arr_pemakaian_antibiotika[0]=='2') echo 'checked="checked"'; ?> />&nbsp;Tidak ada
	&nbsp;&nbsp;&nbsp;
	<input type="radio" name="pemakaian_antibiotika_2" id="pemakaian_antibiotika_2" value="1" <?php if(isset($arr_pemakaian_antibiotika[1]) and $arr_pemakaian_antibiotika[1]=='1') echo 'checked="checked"'; ?> />&nbsp;Profilaksis
	<input type="radio" name="pemakaian_antibiotika_2" id="pemakaian_antibiotika_2" value="2" <?php if(isset($arr_pemakaian_antibiotika[1]) and $arr_pemakaian_antibiotika[1]=='2') echo 'checked="checked"'; ?> />&nbsp;Pengobatan
	</td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama/ jenis obat</td>
	<td><input type="text" name="nama_jenis_obat" id="nama_jenis_obat" value="<?php echo $nama_jenis_obat; ?>" class="text_dt" style="width:200px;" /></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pemeriksaan kultur</td>
	<td>
	<input type="checkbox" name="pemeriksaan_kultur_1" id="pemeriksaan_kultur_1" value="1" <?php if(isset($arr_pemeriksaan_kultur[0]) and $arr_pemeriksaan_kultur[0]=='1') echo 'checked="checked"'; ?> />&nbsp;Darah
	<input type="checkbox" name="pemeriksaan_kultur_2" id="pemeriksaan_kultur_2" value="1" <?php if(isset($arr_pemeriksaan_kultur[1]) and $arr_pemeriksaan_kultur[1]=='1') echo 'checked="checked"'; ?> />&nbsp;Urine
	<input type="checkbox" name="pemeriksaan_kultur_3" id="pemeriksaan_kultur_3" value="1" <?php if(isset($arr_pemeriksaan_kultur[2]) and $arr_pemeriksaan_kultur[2]=='1') echo 'checked="checked"'; ?> />&nbsp;Sputum
	<input type="checkbox" name="pemeriksaan_kultur_4" id="pemeriksaan_kultur_4" value="1" <?php if(isset($arr_pemeriksaan_kultur[3]) and $arr_pemeriksaan_kultur[3]=='1') echo 'checked="checked"'; ?> />&nbsp;Pus luka
	&nbsp;&nbsp;&nbsp;Temp <input type="text" name="temp" id="temp" value="<?php echo $temp; ?>" class="text_dt" /> 
	</td>
</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasil Kultur</td><td><input type="text" name="hasil_kultur" id="hasil_kultur" value="<?php echo $hasil_kultur; ?>" class="text_dt" style="width:600px;" /></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Infeksi nosokimial yang terjadi</td><td><input type="text" name="infeksi_nosokimial" id="infeksi_nosokimial" value="<?php echo $infeksi_nosokimial; ?>" class="text_dt" style="width:600px;" /></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bakteremia/ sepsis</td><td><input type="text" name="bakteremia" id="bakteremia" value="<?php echo $bakteremia; ?>" class="text_dt" style="width:600px;" /></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VAP</td><td><input type="text" name="vap" id="vap" value="<?php echo $vap; ?>" class="text_dt" style="width:600px;" /></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Infeksi saluran kemih</td><td><input type="text" name="saluran_kemih" id="saluran_kemih" value="<?php echo $saluran_kemih; ?>" class="text_dt" style="width:600px;" /></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Infeksi luka operasi</td><td><input type="text" name="luka_operasi" id="luka_operasi" value="<?php echo $luka_operasi; ?>" class="text_dt" style="width:600px;" /></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dekubitus</td><td><input type="text" name="dekubitus" id="dekubitus" value="<?php echo $dekubitus; ?>" class="text_dt" style="width:600px;" /></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Plebitis</td><td><input type="text" name="plebitis" id="plebitis" value="<?php echo $plebitis; ?>" class="text_dt" style="width:600px;" /></td>
</tr>
<tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Infeksi lain HIV, HBV, HCV</td><td><input type="text" name="infeksi_lain" id="infeksi_lain" value="<?php echo $infeksi_lain; ?>" class="text_dt" style="width:600px;" /></td>
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
	<td align="right">&nbsp;</td>
</tr>		
</table>
</form> 