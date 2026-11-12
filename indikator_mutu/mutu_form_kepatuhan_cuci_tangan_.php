<?php
$connect = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
mysql_select_db($database_5, $connect) or die(mysql_error());

$idx = '';
if(isset($_GET['idx'])) $idx = $_GET['idx'];

if(isset($_POST['simpan'])){
	$idx = $_POST['idx'];	
	if(empty($idx)){
		mysql_query('INSERT INTO mutu_kepatuhan_cuci_tangan(FASILITAS,PELAYANAN,RUANGAN,
					UNIT_PELAYANAN,PERIODE,TANGGAL,JAM_MULAI,JAM_SELESAI,
					NOMOR_SESI,NAMA_OBSERVER,LEMBAR_KE,NOMOR,PELUANG,
					INDIKASI_SEBELUM_KONTAK_PASIEN,INDIKASI_SEBELUM_TINDAKAN_ASEPTIK,
					INDIKASI_SETELAH_KONTAK_CAIRAN_TUBUH,INDIKASI_SETELAH_KONTAK_PASIEN,
					INDIKASI_SETELAH_KONTAK_LINGKUNGAN,CUCI_TANGAN_HR,CUCI_TANGAN_HW,
					REGISTER) VALUES(
					"' . $_POST['fasilitas'] . '","' . $_POST['pelayanan'] . '",
					"' . $_POST['ruangan'] . '","' . $_POST['unit_pelayanan'] . '",
					' . ((isset($_POST['periode'])) ? $_POST['periode'] : '""') . ',
					STR_TO_DATE("' . $_POST['tanggal'] . '","%d/%m/%Y"),
					"' . $_POST['jam_mulai'] . ':' . $_POST['menit_mulai'] . ':00' . '",
					"' . $_POST['jam_selesai'] . ':' . $_POST['menit_selesai'] . ':00' . '",
					"' . $_POST['nomor_sesi'] . '","' . $_POST['nama_observer'] . '",
					"' . $_POST['lembar_ke'] . '","' . $_POST['nomor'] . '",
					"' . $_POST['peluang'] . '",
					"' . $_POST['sebelum_kontak_pasien'] . '",
					"' . $_POST['sebelum_tindakan_aseptik'] . '",
					"' . $_POST['sebelum_kontak_cairan_tubuh'] . '",
					"' . $_POST['setelah_kontak_pasien'] . '",
					"' . $_POST['setelah_kontak_lingkungan'] . '",
					"' . ((isset($_POST['cuci_tangan_hr'])) ? $_POST['cuci_tangan_hr'] : '') . '",
					"' . ((isset($_POST['cuci_tangan_hw'])) ? $_POST['cuci_tangan_hw'] : '') . '",
					"' . currentUser() . '")') or die(mysql_error());
		$get_idx = mysql_query('SELECT KEPATUHAN_CUCI_TANGAN_ID FROM mutu_kepatuhan_cuci_tangan
						ORDER BY KEPATUHAN_CUCI_TANGAN_ID DESC LIMIT 1') or die(mysql_error());
		$dat_idx = mysql_fetch_assoc($get_idx);
		$idx = $dat_idx['KEPATUHAN_CUCI_TANGAN_ID'];	
	}else{
		mysql_query('UPDATE mutu_kepatuhan_cuci_tangan
				SET FASILITAS = "' . $_POST['fasilitas'] . '",
				PELAYANAN = "' . $_POST['pelayanan'] . '",
				RUANGAN = "' . $_POST['ruangan'] . '",
				UNIT_PELAYANAN = "' . $_POST['unit_pelayanan'] . '",
				PERIODE = ' . ((isset($_POST['periode'])) ? $_POST['periode'] : '""') . ',
				TANGGAL = STR_TO_DATE("' . $_POST['tanggal'] . '","%d/%m/%Y"),
				JAM_MULAI = "' . $_POST['jam_mulai'] . ':' . $_POST['menit_mulai'] . ':00' . '",
				JAM_SELESAI = "' . $_POST['jam_selesai'] . ':' . $_POST['menit_selesai'] . ':00' . '",
				NOMOR_SESI = "' . $_POST['nomor_sesi'] . '",
				NAMA_OBSERVER = "' . $_POST['nama_observer'] . '",
				LEMBAR_KE = "' . $_POST['lembar_ke'] . '",
				NOMOR = "' . $_POST['nomor'] . '",
				PELUANG = "' . $_POST['peluang'] . '",
				INDIKASI_SEBELUM_KONTAK_PASIEN = "' . $_POST['sebelum_kontak_pasien'] . '",
				INDIKASI_SEBELUM_TINDAKAN_ASEPTIK = "' . $_POST['sebelum_tindakan_aseptik'] . '",
				INDIKASI_SETELAH_KONTAK_CAIRAN_TUBUH = "' . $_POST['sebelum_kontak_cairan_tubuh'] . '",
				INDIKASI_SETELAH_KONTAK_PASIEN = "' . $_POST['setelah_kontak_pasien'] . '",
				INDIKASI_SETELAH_KONTAK_LINGKUNGAN = "' . $_POST['setelah_kontak_lingkungan'] . '",
				CUCI_TANGAN_HR = "' . ((isset($_POST['cuci_tangan_hr'])) ? $_POST['cuci_tangan_hr'] : '') . '",
				CUCI_TANGAN_HW = "' . ((isset($_POST['cuci_tangan_hw'])) ? $_POST['cuci_tangan_hw'] : '') . '",
				REGISTER = "' . currentUser() . '"
				WHERE KEPATUHAN_CUCI_TANGAN_ID = "' . $idx . '"') or die(mysql_error());
	}
	
	mysql_query('DELETE FROM mutu_kepatuhan_cuci_tangan_profesi 
				WHERE KEPATUHAN_CUCI_TANGAN_ID = "' . $idx . '"');
	$c = 1;
	while($c <= 15){
		if(isset($_POST['profesi'. $c])){
			mysql_query('INSERT INTO mutu_kepatuhan_cuci_tangan_profesi(KEPATUHAN_CUCI_TANGAN_ID,KATEGORI_PROFESI)
						VALUES("' . $idx . '","' . $_POST['profesi'. $c] . '")');
		}
	$c++;
	}
	$msg_info = 'Data Berhasil Disimpan.';
}
$qry_pemantauan = 'SELECT kct.KEPATUHAN_CUCI_TANGAN_ID,
			  kct.FASILITAS,kct.PELAYANAN,kct.RUANGAN,
			  kct.UNIT_PELAYANAN,kct.PERIODE,
			  DATE_FORMAT(kct.TANGGAL,"%d/%m/%Y") AS TANGGAL,
			  DATE_FORMAT(kct.JAM_MULAI,"%H") AS JAM_MULAI,
			  DATE_FORMAT(kct.JAM_MULAI,"%i") AS MENIT_MULAI,
			  DATE_FORMAT(kct.JAM_SELESAI,"%H") AS JAM_SELESAI,
			  DATE_FORMAT(kct.JAM_SELESAI,"%i") AS MENIT_SELESAI,
			  TIMEDIFF(kct.JAM_SELESAI,kct.JAM_MULAI) AS DURASI,
			  kct.NOMOR_SESI,kct.NAMA_OBSERVER,kct.LEMBAR_KE,
			  kct.NOMOR,kct.PELUANG,kct.INDIKASI_SEBELUM_KONTAK_PASIEN,
			  kct.INDIKASI_SEBELUM_TINDAKAN_ASEPTIK,
			  kct.INDIKASI_SETELAH_KONTAK_CAIRAN_TUBUH,
			  kct.INDIKASI_SETELAH_KONTAK_PASIEN,
			  kct.INDIKASI_SETELAH_KONTAK_LINGKUNGAN,
			  kct.CUCI_TANGAN_HR,kct.CUCI_TANGAN_HW,
			  kct.REGISTER
			  FROM mutu_kepatuhan_cuci_tangan kct
			  WHERE kct.KEPATUHAN_CUCI_TANGAN_ID = "' . $idx . '"';
$get_pemantauan = mysql_query($qry_pemantauan) or die(mysql_error());
$dat_pemantauan = mysql_fetch_assoc($get_pemantauan);

$arr_profesi = array();
$get_profesi = mysql_query('SELECT mutu_kepatuhan_cuci_tangan_profesi.KEPATUHAN_CUCI_TANGAN_ID,
						mutu_kepatuhan_cuci_tangan_profesi.KATEGORI_PROFESI
						FROM mutu_kepatuhan_cuci_tangan_profesi
						WHERE KEPATUHAN_CUCI_TANGAN_ID = "' . $idx . '"') or die(mysql_error());
while($dat_profesi = mysql_fetch_array($get_profesi)){
	$arr_profesi[$dat_profesi['KATEGORI_PROFESI']] = '1';	
}						
?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#fasilitas").autocomplete("index.php?autocomp=autocompmutu",{width: 380,
			extraParams : {
				dt_param : function(){
					return 'fasilitas';
				}
		}});
		jQuery("#pelayanan").autocomplete("index.php?autocomp=autocompmutu",{width: 380,
			extraParams : {
				dt_param : function(){
					return 'pelayanan';
				}
		}});
		jQuery("#ruangan").autocomplete("index.php?autocomp=autocompmutu",{width: 380,
			extraParams : {
				dt_param : function(){
					return 'ruangan';
				}
		}});
		jQuery("#unit_pelayanan").autocomplete("index.php?autocomp=autocompmutu",{width: 380,
			extraParams : {
				dt_param : function(){
					return 'unit_pelayanan';
				}
		}});
		jQuery("#nama_observer").autocomplete("index.php?autocomp=autocompmutu",{width: 380,
			extraParams : {
				dt_param : function(){
					return 'nama_observer';
				}
		}});
	});	
</script>		
<div style=" height:auto; padding:15px; ">
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; padding-left:35px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">   
<form name="search" method="post">
<table border="0" width="90%">
<tr>
	<td colspan="6"><strong>Formulir Pemantauan Kepatuhan Cuci Tangan</strong></td>
</tr>
<tr>
	<td colspan="6">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Fasilitas</td>
	<td><input type="text" name="fasilitas" id="fasilitas" value="<?php echo $dat_pemantauan['FASILITAS']; ?>" class="text_dt" style="width:300px;" /></td>
    <td>&nbsp;</td>
	<td width="200px">Pelayanan</td>
	<td><input type="text" name="pelayanan" id="pelayanan" value="<?php echo $dat_pemantauan['PELAYANAN']; ?>" class="text_dt" style="width:300px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Ruangan</td>
	<td><input type="text" name="ruangan" id="ruangan" value="<?php echo $dat_pemantauan['RUANGAN']; ?>" class="text_dt" style="width:300px;" /></td>
    <td>&nbsp;</td>
	<td width="200px">Unit Pelayanan</td>
	<td><input type="text" name="unit_pelayanan" id="unit_pelayanan" value="<?php echo $dat_pemantauan['UNIT_PELAYANAN']; ?>" class="text_dt" style="width:300px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Periode</td>
	<td><input type="radio" name="periode" value="1"
		<?php if($dat_pemantauan['PERIODE'] == '1') echo 'checked="checked"'; ?> >&nbsp;Sebelum Intervensi&nbsp;&nbsp;
		<input type="radio" name="periode" value="2"
		<?php if($dat_pemantauan['PERIODE'] == '2') echo 'checked="checked"'; ?> >&nbsp;Setelah Intervensi</td>
    <td>&nbsp;</td>
	<td width="200px">Tanggal</td>
	<td><input type="text" name="tanggal" id="tgl_1" value="<?php echo $dat_pemantauan['TANGGAL']; ?>" class="text_dt" size="15" />
	<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Jam Mulai</td>
	<td><select name="jam_mulai" id="jam_mulai" class="text_dt" >
		<?php echo getJam($dat_pemantauan['JAM_MULAI']); ?>
		</select><select name="menit_mulai" id="menit_mulai" class="text_dt" >
		<?php echo getMenit($dat_pemantauan['MENIT_MULAI']); ?>
		</select></td>
    <td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Jam Selesai</td>
	<td><select name="jam_selesai" id="jam_selesai" class="text_dt" >
		<?php echo getJam($dat_pemantauan['JAM_SELESAI']); ?>
		</select><select name="menit_selesai" id="menit_selesai" class="text_dt" >
		<?php echo getMenit($dat_pemantauan['MENIT_SELESAI']); ?>
		</select></td>
    <td>&nbsp;</td>
	<td width="200px">Durasi</td>
	<td>: <?php echo $dat_pemantauan['DURASI']; ?></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Nomor Sesi</td>
	<td><input type="text" name="nomor_sesi" id="nomor_sesi" value="<?php echo $dat_pemantauan['NOMOR_SESI']; ?>" class="text_dt" size="11" /></td>
    <td>&nbsp;</td>
	<td width="200px">Nama Observer</td>
	<td><input type="text" name="nama_observer" id="nama_observer" value="<?php echo $dat_pemantauan['NAMA_OBSERVER']; ?>" class="text_dt" style="width:300px;" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Lembar Ke</td>
	<td><input type="text" name="lembar_ke" id="lembar_ke" value="<?php echo $dat_pemantauan['LEMBAR_KE']; ?>" class="text_dt" size="11" /></td>
    <td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Kategori Profesi</td>
    <td colspan="4">1. Perawat/ Bidan&nbsp;&nbsp;&nbsp;<input type="checkbox" name="profesi1" value="1.1" <?php if(isset($arr_profesi['1.1'])) echo 'checked="checked"'; ?> />&nbsp;Perawat
	&nbsp;&nbsp;<input type="checkbox" name="profesi2" value="1.2" <?php if(isset($arr_profesi['1.2'])) echo 'checked="checked"'; ?> />&nbsp;Bidan
	&nbsp;&nbsp;<input type="checkbox" name="profesi3" value="1.3" <?php if(isset($arr_profesi['1.3'])) echo 'checked="checked"'; ?> />&nbsp;Perawat</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
    <td colspan="4">2. Dokter&nbsp;&nbsp;&nbsp;<input type="checkbox" name="profesi4" value="2.1" <?php if(isset($arr_profesi['2.1'])) echo 'checked="checked"'; ?> />&nbsp;Penyakit Dalam
	&nbsp;&nbsp;<input type="checkbox" name="profesi5" value="2.2" <?php if(isset($arr_profesi['2.2'])) echo 'checked="checked"'; ?> />&nbsp;Bedah
	&nbsp;&nbsp;<input type="checkbox" name="profesi6" value="2.3" <?php if(isset($arr_profesi['2.3'])) echo 'checked="checked"'; ?> />&nbsp;Anestesi
	&nbsp;&nbsp;<input type="checkbox" name="profesi7" value="2.4" <?php if(isset($arr_profesi['2.4'])) echo 'checked="checked"'; ?> />&nbsp;Anak
	&nbsp;&nbsp;<input type="checkbox" name="profesi8" value="2.5" <?php if(isset($arr_profesi['2.5'])) echo 'checked="checked"'; ?> />&nbsp;Obsgin
	&nbsp;&nbsp;<input type="checkbox" name="profesi9" value="2.6" <?php if(isset($arr_profesi['2.6'])) echo 'checked="checked"'; ?> />&nbsp;Residen
	&nbsp;&nbsp;<input type="checkbox" name="profesi10" value="2.7" <?php if(isset($arr_profesi['2.7'])) echo 'checked="checked"'; ?> />&nbsp;Siswa/Co Ass</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
    <td colspan="4">3. Tenaga Kesehatan Lain&nbsp;&nbsp;&nbsp;<input type="checkbox" name="profesi11" value="3.1" <?php if(isset($arr_profesi['3.1'])) echo 'checked="checked"'; ?> />&nbsp;Fisioterapis
	&nbsp;&nbsp;<input type="checkbox" name="profesi12" value="3.2" <?php if(isset($arr_profesi['3.2'])) echo 'checked="checked"'; ?> />&nbsp;Teknisi
	&nbsp;&nbsp;<input type="checkbox" name="profesi13" value="3.3" <?php if(isset($arr_profesi['3.3'])) echo 'checked="checked"'; ?> />&nbsp;Nakes Lain
	&nbsp;&nbsp;<input type="checkbox" name="profesi14" value="3.4" <?php if(isset($arr_profesi['3.4'])) echo 'checked="checked"'; ?> />&nbsp;Siswa</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
    <td colspan="4">4. Penunjang&nbsp;&nbsp;&nbsp;<input type="checkbox" name="profesi15" value="4.1" <?php if(isset($arr_profesi['4.1'])) echo 'checked="checked"'; ?> />&nbsp;Petugas Kebersihan</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Nomor</td>
	<td><input type="text" name="nomor" id="nomor" value="<?php echo $dat_pemantauan['NOMOR']; ?>" class="text_dt" size="11" /></td>
    <td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Peluang</td>
	<td><input type="text" name="peluang" id="peluang" value="<?php echo $dat_pemantauan['PELUANG']; ?>" class="text_dt" size="11" /></td>
    <td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Indikasi</td>
	<td>Sebelum Kontak pasien</td>
    <td colspan="3"><input type="text" name="sebelum_kontak_pasien" value="<?php echo $dat_pemantauan['INDIKASI_SEBELUM_KONTAK_PASIEN']; ?>" class="text_dt" size="11" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
	<td>Sebelum Tindakan Aseptik</td>
    <td colspan="3"><input type="text" name="sebelum_tindakan_aseptik" value="<?php echo $dat_pemantauan['INDIKASI_SEBELUM_TINDAKAN_ASEPTIK']; ?>" class="text_dt" size="11" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
	<td>Sebelum Kontak Cairan Tubuh</td>
    <td colspan="4"><input type="text" name="sebelum_kontak_cairan_tubuh" value="<?php echo $dat_pemantauan['INDIKASI_SETELAH_KONTAK_CAIRAN_TUBUH']; ?>" class="text_dt" size="11" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
	<td>Setelah Kontak Pasien</td>
    <td colspan="4"><input type="text" name="setelah_kontak_pasien" value="<?php echo $dat_pemantauan['INDIKASI_SETELAH_KONTAK_PASIEN']; ?>" class="text_dt" size="11" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
	<td>Setelah Kontak Lingkungan</td>
    <td colspan="4"><input type="text" name="setelah_kontak_lingkungan" value="<?php echo $dat_pemantauan['INDIKASI_SETELAH_KONTAK_LINGKUNGAN']; ?>" class="text_dt" size="11" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">Cuci Tangan</td>
    <td colspan="4"><input type="checkbox" name="cuci_tangan_hr" value="1" <?php if($dat_pemantauan['CUCI_TANGAN_HR']) echo 'checked="checked"'; ?> />&nbsp;Dengan Handrub (HR)
	&nbsp;&nbsp;<input type="checkbox" name="cuci_tangan_hw" value="1" <?php if($dat_pemantauan['CUCI_TANGAN_HW']) echo 'checked="checked"'; ?> />&nbsp;Dengan HandWash (HW)</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="200px">&nbsp;</td>
    <td colspan="4" align="right">
	<input type="submit" name="simpan" value="simpan" class="myButton" />
	<a href="index.php?link=ebfc65b519855cfdb2395e4336e54114">
		<input type="button" value="tutup" class="myButton" />
		</a>
	<input type="hidden" name="idx" value="<?php echo $idx; ?>" />
	</td>
</tr>
</table>
</form>
</div>
</div> 