<?php
$irna_id = $_GET['idx'];

$qry_rencana_pulang = 'SELECT IRNA_ID,RENCANA_PULANG
			FROM t_irna_rencana_pulang
			WHERE IRNA_ID = "' . $irna_id . '"';
$get_rencana_pulang = mysql_query($qry_rencana_pulang) or die(mysql_error());
$dat_rencana_pulang = mysql_fetch_assoc($get_rencana_pulang);

$irna_rencana_pulang_id = $dat_rencana_pulang['irna_id'];
$rencana_pulang = str_replace('|','"',$dat_rencana_pulang['RENCANA_PULANG']);
$rencana_pulang = preg_replace('/\r|\n/','\n',trim($rencana_pulang));
$rencana_pulang = json_decode($rencana_pulang,true);

if (isset($_POST['irna_id']))
    include('rawatinap/ranap_save_rencana_pulang.php');
?>
<form name="formrujukan" id="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
	<input type="hidden" name="irna_rencana_pulang_id" id="irna_rencana_pulang_id" value="<?php echo $irna_rencana_pulang_id; ?>" />
    <input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
<table border="0" width="80%" class="formData">
<tr>
    <td colspan="4">&nbsp;</td>
	<td align="center" width="75px">Ya</td>
	<td align="center" width="75px">Tidak</td>
</tr>
<tr>
	<td colspan="6">Bagaimana pasien dan keluarga mengetahui tentang obat yang harus dilanjutkan di rumah ?</td>
</tr>
<tr>
	<td width="80px">&nbsp;</td>
    <td colspan="3">a. Nama obatnya</td>
	<td align="center"><input type="radio" name="1_a" id="1_a" value="1" <?php echo ((isset($rencana_pulang['1_a']) and $rencana_pulang['1_a'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="1_a" id="1_a2" value="2" <?php echo ((isset($rencana_pulang['1_a']) and $rencana_pulang['1_a'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3">b. Jumlahnya</td>
	<td align="center"><input type="radio" name="1_b" id="1_b" value="1" <?php echo ((isset($rencana_pulang['1_b']) and $rencana_pulang['1_b'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="1_b" id="1_b2" value="2" <?php echo ((isset($rencana_pulang['1_b']) and $rencana_pulang['1_b'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3">c. Waktu pemberiannya</td>
	<td align="center"><input type="radio" name="1_c" id="1_c" value="1" <?php echo ((isset($rencana_pulang['1_c']) and $rencana_pulang['1_c'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="1_c" id="1_c2" value="2" <?php echo ((isset($rencana_pulang['1_c']) and $rencana_pulang['1_c'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3">d. Cara pemberiannya</td>
	<td align="center"><input type="radio" name="1_d" id="1_d" value="1" <?php echo ((isset($rencana_pulang['1_d']) and $rencana_pulang['1_d'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="1_d" id="1_d2" value="2" <?php echo ((isset($rencana_pulang['1_d']) and $rencana_pulang['1_d'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
	<td colspan="6">Bagaimana pasien mengetahui tentang lingkungan yang aman dan nyaman di rumah setelah keluar dari rumah sakit ?</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3">a. Air bersih</td>
	<td align="center"><input type="radio" name="2_a" id="2_a" value="1" <?php echo ((isset($rencana_pulang['2_a']) and $rencana_pulang['2_a'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="2_a" id="2_a2" value="2" <?php echo ((isset($rencana_pulang['2_a']) and $rencana_pulang['2_a'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3">b. Ventilasi udara yang cukup</td>
	<td align="center"><input type="radio" name="2_b" id="2_b" value="1" <?php echo ((isset($rencana_pulang['2_b']) and $rencana_pulang['2_b'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="2_b" id="2_b2" value="2" <?php echo ((isset($rencana_pulang['2_b']) and $rencana_pulang['2_b'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3">c. Fasilitas dan peralatan yang dibutuhkan sesuai dengan kondisi pasien</td>
	<td align="center"><input type="radio" name="2_c" id="2_c" value="1" <?php echo ((isset($rencana_pulang['2_c']) and $rencana_pulang['2_c'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="2_c" id="2_c2" value="2" <?php echo ((isset($rencana_pulang['2_c']) and $rencana_pulang['2_c'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="5">d. Keterampilan Khusus</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="80px">&nbsp;</td>
    <td colspan="2">1. Perawatan Luka</td>
	<td align="center"><input type="radio" name="2_d1" id="2_d1" value="1" <?php echo ((isset($rencana_pulang['2_d1']) and $rencana_pulang['2_d1'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="2_d1" id="2_d12" value="2" <?php echo ((isset($rencana_pulang['2_d1']) and $rencana_pulang['2_d1'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="80px">&nbsp;</td>
    <td colspan="2">2. Injeksi</td>
	<td align="center"><input type="radio" name="2_d2" id="2_d2" value="1" <?php echo ((isset($rencana_pulang['2_d2']) and $rencana_pulang['2_d2'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="2_d2" id="2_d22" value="2" <?php echo ((isset($rencana_pulang['2_d2']) and $rencana_pulang['2_d2'] == '2') ? 'checked' : ''); ?> /></td>
<tr>
	<td>&nbsp;</td>
	<td width="80px">&nbsp;</td>
    <td colspan="2">3. Perawatan bayi</td>
	<td align="center"><input type="radio" name="2_d3" id="2_d3" value="1" <?php echo ((isset($rencana_pulang['2_d3']) and $rencana_pulang['2_d3'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="2_d3" id="2_d32" value="2" <?php echo ((isset($rencana_pulang['2_d3']) and $rencana_pulang['2_d3'] == '2') ? 'checked' : ''); ?> /></td></tr>
<tr>
	<td>&nbsp;</td>
	<td width="80px">&nbsp;</td>
    <td colspan="2">4. Lainnya <input type="text" name="2_d4_ket" id="2_d4_ket" value="<?php echo ((isset($rencana_pulang['2_d4_ket'])) ? $rencana_pulang['2_d4_ket'] : ''); ?>" class="text_dt" size="40" /></td>
	<td align="center"><input type="radio" name="2_d4" id="2_d4" value="1" <?php echo ((isset($rencana_pulang['2_d4']) and $rencana_pulang['2_d4'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="2_d4" id="2_d42" value="2" <?php echo ((isset($rencana_pulang['2_d4']) and $rencana_pulang['2_d4'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3">e. Fasilitas kesehatan yang dekat dari rumah</td>
	<td align="center"><input type="radio" name="2_e" id="2_e" value="1" <?php echo ((isset($rencana_pulang['2_e']) and $rencana_pulang['2_e'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="2_e" id="2_e2" value="2" <?php echo ((isset($rencana_pulang['2_e']) and $rencana_pulang['2_e'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
	<td colspan="6">Bagaimana pasien dan keluarga memerlukan bantuan/ perawatn khusus di rumah setelah keluar<br />dari rumah sakit (home care/ home visite) ?</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="3">a. Makan</td>
	<td align="center"><input type="radio" name="3_a" id="3_a" value="1" <?php echo ((isset($rencana_pulang['3_a']) and $rencana_pulang['3_a'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="3_a" id="3_a2" value="2" <?php echo ((isset($rencana_pulang['3_a']) and $rencana_pulang['3_a'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="3">b. Minum</td>
	<td align="center"><input type="radio" name="3_b" id="3_b" value="1" <?php echo ((isset($rencana_pulang['3_b']) and $rencana_pulang['3_b'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="3_b" id="3_b2" value="2" <?php echo ((isset($rencana_pulang['3_b']) and $rencana_pulang['3_b'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="3">c. Mandi</td>
	<td align="center"><input type="radio" name="3_c" id="3_c" value="1" <?php echo ((isset($rencana_pulang['3_c']) and $rencana_pulang['3_c'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="3_c" id="3_c2" value="2" <?php echo ((isset($rencana_pulang['3_c']) and $rencana_pulang['3_c'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="3">d. BAK</td>
	<td align="center"><input type="radio" name="3_d" id="3_d" value="1" <?php echo ((isset($rencana_pulang['3_d']) and $rencana_pulang['3_d'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="3_d" id="3_d2" value="2" <?php echo ((isset($rencana_pulang['3_d']) and $rencana_pulang['3_d'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="3">e. BAB</td>
	<td align="center"><input type="radio" name="3_e" id="3_e" value="1" <?php echo ((isset($rencana_pulang['3_e']) and $rencana_pulang['3_e'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="3_e" id="3_e2" value="2" <?php echo ((isset($rencana_pulang['3_e']) and $rencana_pulang['3_e'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="3">f. Berpakaian</td>
	<td align="center"><input type="radio" name="3_f" id="3_f" value="1" <?php echo ((isset($rencana_pulang['3_f']) and $rencana_pulang['3_f'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="3_f" id="3_f2" value="2" <?php echo ((isset($rencana_pulang['3_f']) and $rencana_pulang['3_f'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="5">g. Alat Bantu</td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td width="80px">&nbsp;</td>
    <td colspan="2">1. Tongkat</td>
	<td align="center"><input type="radio" name="3_g1" id="3_g1" value="1" <?php echo ((isset($rencana_pulang['3_g1']) and $rencana_pulang['3_g1'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="3_g1" id="3_g12" value="2" <?php echo ((isset($rencana_pulang['3_g1']) and $rencana_pulang['3_g1'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td width="80px">&nbsp;</td>
    <td colspan="2">2. Kursi</td>
	<td align="center"><input type="radio" name="3_g2" id="3_g2" value="1" <?php echo ((isset($rencana_pulang['3_g2']) and $rencana_pulang['3_g2'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="3_g2" id="3_g22" value="2" <?php echo ((isset($rencana_pulang['3_g2']) and $rencana_pulang['3_g2'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td width="80px">&nbsp;</td>
    <td colspan="2">3. Walker</td>
	<td align="center"><input type="radio" name="3_g3" id="3_g3" value="1" <?php echo ((isset($rencana_pulang['3_g3']) and $rencana_pulang['3_g3'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="3_g3" id="3_g32" value="2" <?php echo ((isset($rencana_pulang['3_g3']) and $rencana_pulang['3_g3'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="5">h. Peralatan Medis</td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td width="80px">&nbsp;</td>
    <td colspan="2">1. Kateter Urine</td>
	<td align="center"><input type="radio" name="3_h1" id="3_h1" value="1" <?php echo ((isset($rencana_pulang['3_h1']) and $rencana_pulang['3_h1'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="3_h1" id="3_h12" value="2" <?php echo ((isset($rencana_pulang['3_h1']) and $rencana_pulang['3_h1'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
     <td>&nbsp;</td>
	<td width="80px">&nbsp;</td>
    <td colspan="2">2. NGT</td>
	<td align="center"><input type="radio" name="3_h2" id="3_h2" value="1" <?php echo ((isset($rencana_pulang['3_h2']) and $rencana_pulang['3_h2'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="3_h2" id="3_h22" value="2" <?php echo ((isset($rencana_pulang['3_h2']) and $rencana_pulang['3_h2'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
     <td>&nbsp;</td>
	<td width="80px">&nbsp;</td>
    <td colspan="2">3. Oksigen</td>
	<td align="center"><input type="radio" name="3_h3" id="3_h3" value="1" <?php echo ((isset($rencana_pulang['3_h3']) and $rencana_pulang['3_h3'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="3_h3" id="3_h32" value="2" <?php echo ((isset($rencana_pulang['3_h3']) and $rencana_pulang['3_h3'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
     <td>&nbsp;</td>
	<td width="80px">&nbsp;</td>
    <td colspan="2">4. Lainnya <input type="text" name="3_h4_ket" id="3_h4_ket" value="<?php echo ((isset($rencana_pulang['3_h4_ket'])) ? $rencana_pulang['3_h4_ket'] : ''); ?>" class="text_dt" size="40" /></td>
	<td align="center"><input type="radio" name="3_h4" id="3_h4" value="1" <?php echo ((isset($rencana_pulang['3_h4']) and $rencana_pulang['3_h4'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="3_h4" id="3_h42" value="2" <?php echo ((isset($rencana_pulang['3_h4']) and $rencana_pulang['3_h4'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
	<td colspan="6">Bagaimana pasien dan keluarga memerlukan edukasi kesehatan setelah keluar dari rumah sakit dalam hal :</td>
</tr>
<tr>
     <td>&nbsp;</td>
    <td colspan="3">a. Obat-obatan</td>
	<td align="center"><input type="radio" name="4_a" id="4_a" value="1" <?php echo ((isset($rencana_pulang['4_a']) and $rencana_pulang['4_a'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="4_a" id="4_a2" value="2" <?php echo ((isset($rencana_pulang['4_a']) and $rencana_pulang['4_a'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
     <td>&nbsp;</td>
    <td colspan="3">b. Nyeri</td>
	<td align="center"><input type="radio" name="4_b" id="4_b" value="1" <?php echo ((isset($rencana_pulang['4_b']) and $rencana_pulang['4_b'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="4_b" id="4_b2" value="2" <?php echo ((isset($rencana_pulang['4_b']) and $rencana_pulang['4_b'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
</tr>
<tr>
     <td>&nbsp;</td>
    <td colspan="3">c. Diet</td>
	<td align="center"><input type="radio" name="4_c" id="4_c" value="1" <?php echo ((isset($rencana_pulang['4_c']) and $rencana_pulang['4_c'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="4_c" id="4_c2" value="2" <?php echo ((isset($rencana_pulang['4_c']) and $rencana_pulang['4_c'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="3">d. Mencari Pertolongan</td>
	<td align="center"><input type="radio" name="4_d" id="4_d" value="1" <?php echo ((isset($rencana_pulang['4_d']) and $rencana_pulang['4_d'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="4_d" id="4_d2" value="2" <?php echo ((isset($rencana_pulang['4_d']) and $rencana_pulang['4_d'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="3">e. Tindak lanjut pengobatan/ perawatan</td>
	<td align="center"><input type="radio" name="4_e" id="4_e" value="1" <?php echo ((isset($rencana_pulang['4_e']) and $rencana_pulang['4_e'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="4_e" id="4_e2" value="2" <?php echo ((isset($rencana_pulang['4_e']) and $rencana_pulang['4_e'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="3">f. Lainnya <input type="text" name="4_f_ket" id="4_f_ket" value="<?php echo ((isset($rencana_pulang['4_f_ket'])) ? $rencana_pulang['4_f_ket'] : ''); ?>" class="text_dt" size="40" /></td>
	<td align="center"><input type="radio" name="4_f" id="4_f" value="1" <?php echo ((isset($rencana_pulang['4_f']) and $rencana_pulang['4_f'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="4_f" id="4_f2" value="2" <?php echo ((isset($rencana_pulang['4_f']) and $rencana_pulang['4_f'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
</tr>
<tr>
	<td colspan="6">Bagaimana pasien dan keluarga mengetahui fasilitas pelayanan kesehatan yang dapat digunakan :</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3">a. Puskesmas</td>
	<td align="center"><input type="radio" name="5_a" id="5_a" value="1" <?php echo ((isset($rencana_pulang['5_a']) and $rencana_pulang['5_a'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="5_a" id="5_a2" value="2" <?php echo ((isset($rencana_pulang['5_a']) and $rencana_pulang['5_a'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="3">b. Rumah Sakit</td>
	<td align="center"><input type="radio" name="5_b" id="5_b" value="1" <?php echo ((isset($rencana_pulang['5_b']) and $rencana_pulang['5_b'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="5_b" id="5_b2" value="2" <?php echo ((isset($rencana_pulang['5_b']) and $rencana_pulang['5_b'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3">c. Klinik</td>
	<td align="center"><input type="radio" name="5_c" id="5_c" value="1" <?php echo ((isset($rencana_pulang['5_c']) and $rencana_pulang['5_c'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="5_c" id="5_c2" value="2" <?php echo ((isset($rencana_pulang['5_c']) and $rencana_pulang['5_c'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3">d. Dokter keluarga</td>
	<td align="center"><input type="radio" name="5_d" id="5_d" value="1" <?php echo ((isset($rencana_pulang['5_d']) and $rencana_pulang['5_d'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="5_d" id="5_d2" value="2" <?php echo ((isset($rencana_pulang['5_d']) and $rencana_pulang['5_d'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="3">e. Rumah perawatan</td>
	<td align="center"><input type="radio" name="5_e" id="5_e" value="1" <?php echo ((isset($rencana_pulang['5_e']) and $rencana_pulang['5_e'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="5_e" id="5_e2" value="2" <?php echo ((isset($rencana_pulang['5_e']) and $rencana_pulang['5_e'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3">f. Bidan praktek</td>
	<td align="center"><input type="radio" name="5_f" id="5_f" value="1" <?php echo ((isset($rencana_pulang['5_f']) and $rencana_pulang['5_f'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="5_f" id="5_f2" value="2" <?php echo ((isset($rencana_pulang['5_f']) and $rencana_pulang['5_f'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3">g. Lainnya <input type="text" name="5_g_ket" id="5_g_ket" value="<?php echo ((isset($rencana_pulang['5_g_ket'])) ? $rencana_pulang['5_g_ket'] : ''); ?>" class="text_dt" size="40" /></td>
	<td align="center"><input type="radio" name="5_g" id="5_g" value="1" <?php echo ((isset($rencana_pulang['5_g']) and $rencana_pulang['5_g'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="5_g" id="5_g2" value="2" <?php echo ((isset($rencana_pulang['5_g']) and $rencana_pulang['5_g'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
	<td colspan="6">Bagaimana pasien dan keluarga mengetahui tentang diet yang diperbolehkan untuk pasien ?</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="3">a. Jenisnya</td>
	<td align="center"><input type="radio" name="6_a" id="6_a" value="1" <?php echo ((isset($rencana_pulang['6_a']) and $rencana_pulang['6_a'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="6_a" id="6_a2" value="2" <?php echo ((isset($rencana_pulang['6_a']) and $rencana_pulang['6_a'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="3">b. Jumlahnya</td>
	<td align="center"><input type="radio" name="6_b" id="6_b" value="1" <?php echo ((isset($rencana_pulang['6_b']) and $rencana_pulang['6_b'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="6_b" id="6_b2" value="2" <?php echo ((isset($rencana_pulang['6_b']) and $rencana_pulang['6_b'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="3">c. Waktunya</td>
	<td align="center"><input type="radio" name="6_c" id="6_c" value="1" <?php echo ((isset($rencana_pulang['6_c']) and $rencana_pulang['6_c'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="6_c" id="6_c2" value="2" <?php echo ((isset($rencana_pulang['6_c']) and $rencana_pulang['6_c'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
	<td colspan="6">Bagaimana pasien dan keluarga mengetahui tentang transportasi yang dapat digunakan ?</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="3">a. Ambulance</td>
	<td align="center"><input type="radio" name="7_a" id="7_a" value="1" <?php echo ((isset($rencana_pulang['7_a']) and $rencana_pulang['7_a'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="7_a" id="7_a2" value="2" <?php echo ((isset($rencana_pulang['7_a']) and $rencana_pulang['7_a'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="3">b. Kendaraan pribadi</td>
	<td align="center"><input type="radio" name="7_b" id="7_b" value="1" <?php echo ((isset($rencana_pulang['7_b']) and $rencana_pulang['7_b'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="7_b" id="7_b2" value="2" <?php echo ((isset($rencana_pulang['7_b']) and $rencana_pulang['7_b'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="3">c. Kendaraan umum</td>
	<td align="center"><input type="radio" name="7_c" id="7_c" value="1" <?php echo ((isset($rencana_pulang['7_c']) and $rencana_pulang['7_c'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="7_c" id="7_c2" value="2" <?php echo ((isset($rencana_pulang['7_c']) and $rencana_pulang['7_c'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
	<td colspan="6">Bagaimana pasien dan keluarga mengetahui tentang yayasan penyakit sejenis yang ada di lingkungannya ?</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3">a. Yayasan jantung sehat</td>
	<td align="center"><input type="radio" name="8_a" id="8_a" value="1" <?php echo ((isset($rencana_pulang['8_a']) and $rencana_pulang['8_a'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="8_a" id="8_a2" value="2" <?php echo ((isset($rencana_pulang['8_a']) and $rencana_pulang['8_a'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="3">b. Yayasan stroke</td>
	<td align="center"><input type="radio" name="8_b" id="8_b" value="1" <?php echo ((isset($rencana_pulang['8_b']) and $rencana_pulang['8_b'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="8_b" id="8_b2" value="2" <?php echo ((isset($rencana_pulang['8_b']) and $rencana_pulang['8_b'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="3">c. Lainnya <input type="text" name="8_c_ket" id="8_c_ket" value="<?php echo ((isset($rencana_pulang['8_c_ket'])) ? $rencana_pulang['8_c_ket'] : ''); ?>" class="text_dt" size="40" /></td>
	<td align="center"><input type="radio" name="8_c" id="8_c" value="1" <?php echo ((isset($rencana_pulang['8_c']) and $rencana_pulang['8_c'] == '1') ? 'checked' : ''); ?> /></td>
	<td align="center"><input type="radio" name="8_c" id="8_c2" value="2" <?php echo ((isset($rencana_pulang['8_c']) and $rencana_pulang['8_c'] == '2') ? 'checked' : ''); ?> /></td>
</tr>
<tr>
	<td colspan="6">Rencana tindak lanjut setelah perawatan di Rumah Sakit :</td>
</tr>
<tr>
    <td>&nbsp;</td><td colspan="5"><textarea name="tl" id="tl" class="text_dt11" ><?php echo ((isset($rencana_pulang['tl'])) ? $rencana_pulang['tl'] : ''); ?></textarea></td>
</tr>
<tr>
	<td colspan="6" align="right">
	<?php if($irna_final == ''){ ?>
		<input type="button" value="simpan" class="myButton" onclick="simpan();" />
	<?php if(!empty($irna_rencana_pulang_id)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "2"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idx . '"
						AND JENIS_DOKUMEN_ID = "11"
						ORDER BY FILE_ID DESC LIMIT 1';
				$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
				$dat_view_rm = mysql_fetch_assoc($get_view_rm);
			?>
				<input type="button" value="lihat" class="myButton1" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" />
			<?php } } ?>
</tr>
</table>
</form>
<script>
function simpan(){
	_haschange = false;
	$('#formedit').submit();
}	
</script>