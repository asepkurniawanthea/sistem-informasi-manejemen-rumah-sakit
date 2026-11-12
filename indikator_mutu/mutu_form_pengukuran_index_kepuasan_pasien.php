<?php
$connect = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
mysql_select_db($database_5, $connect) or die(mysql_error());

$idx = '';
if(isset($_GET['idx'])) $idx = $_GET['idx'];

if(isset($_POST['simpan'])){
	$idx = $_POST['idx'];	
	if(empty($idx)){
		$qry = 'INSERT INTO mutu_pengukuran_kepuasan_pasien_dan_keluarga(TANGGAL,
				UNIT_PELAYANAN,NO_RESPONDEN,UMUR_TAHUN,UMUR_BULAN,JNS_KELAMIN,
				PENDIDIKAN,PEKERJAAN,PENGUMPUL_DATA,KETERANGAN_PENGUMPUL_DATA,
				REGISTER,';
		$x = 1;
		while($x <= 30){
			$qry .= 'PERTANYAAN_' . $x . ',';
		$x++;	
		}
		$qry = substr($qry,0,strlen($qry) - 1);
		$jns_kelamin = '';
		if(isset($_POST['jns_kelamin'])) $jns_kelamin = $_POST['jns_kelamin']; 
		$qry .= ') VALUES(STR_TO_DATE("' . $_POST['tanggal'] . '","%d/%m/%Y"),
			"' . $_POST['pelayanan'] . '","' . $_POST['no_responden'] . '",
			"' . $_POST['umur_tahun'] . '","' . $_POST['umur_bulan'] . '","' . $jns_kelamin . '",
			"' . $_POST['pendidikan'] . '","' . $_POST['pekerjaan'] . '","' . $_POST['pengumpul_data'] . '",
			"' . $_POST['keterangan'] . '","' . $user_name . '",';	
		$x = 1;
		while($x <= 30){
			$jawaban = '';
			if(isset($_POST['jawaban_' . $x])) $jawaban = $_POST['jawaban_' . $x];
			$qry .= '"' . $jawaban . '",';
		$x++;	
		}	
		$qry = substr($qry,0,strlen($qry) - 1) . ')';
		mysql_query($qry) or die(mysql_error());
		$get_idx = mysql_query('SELECT PENGUKURAN_KEPUASAN_ID 
						FROM mutu_pengukuran_kepuasan_pasien_dan_keluarga
						ORDER BY PENGUKURAN_KEPUASAN_ID DESC LIMIT 1') or die(mysql_error());
		$dat_idx = mysql_fetch_assoc($get_idx);
		$idx = $dat_idx['PENGUKURAN_KEPUASAN_ID'];	
	}else{
		$jns_kelamin = '';
		if(isset($_POST['jns_kelamin'])) $jns_kelamin = $_POST['jns_kelamin']; 
		$qry = 'UPDATE mutu_pengukuran_kepuasan_pasien_dan_keluarga
				SET TANGGAL = STR_TO_DATE("' . $_POST['tanggal'] . '","%d/%m/%"),
				UNIT_PELAYANAN = "' . $_POST['pelayanan'] . '",
				NO_RESPONDEN = "' . $_POST['no_responden'] . '",
				UMUR_TAHUN = "' . $_POST['umur_tahun'] . '",
				UMUR_BULAN = "' . $_POST['umur_bulan'] . '",
				JNS_KELAMIN = "' . $jns_kelamin . '",
				PENDIDIKAN = "' . $_POST['pendidikan'] . '",
				PEKERJAAN = "' . $_POST['pekerjaan'] . '",';
		$x = 1;
		while($x <= 30){
			$jawaban = '';
			if(isset($_POST['jawaban_' . $x])) $jawaban = $_POST['jawaban_' . $x];
			$qry .= 'PERTANYAAN_' . $x . ' = "' . $jawaban . '",';
		$x++;	
		}
		$qry = substr($qry,0,strlen($qry) - 1);	
		$qry .= ' WHERE PENGUKURAN_KEPUASAN_ID = "' . $idx . '"';
		mysql_query($qry) or die(mysql_error());
	}
	$msg_info = 'Data Berhasil Disimpan.';
}
$qry_pengukuran = 'SELECT *,DATE_FORMAT(TANGGAL,"%d/%m/%Y") AS TANGGAL_PENGUKURAN 
			FROM mutu_pengukuran_kepuasan_pasien_dan_keluarga
			WHERE PENGUKURAN_KEPUASAN_ID = "' . $idx . '"';
$get_pengukuran = mysql_query($qry_pengukuran) or die(mysql_error());
$dat_pengukuran = mysql_fetch_assoc($get_pengukuran);						
?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#pengumpul_data").autocomplete("index.php?autocomp=autocompmutu",{width: 340,
			extraParams : {
				dt_param : function(){
					return 'pengumpul';
				},
				dt_param2 : function(){
					return '1';
				}
		}});
		
		jQuery("#keterangan").autocomplete("index.php?autocomp=autocompmutu",{width: 620,
			extraParams : {
				dt_param : function(){
					return 'keterangan';
				},
				dt_param2 : function(){
					return '1';
				}
		}});
	});	
</script>		
<div style=" height:auto; padding:15px; ">
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; padding-left:35px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">   
<form name="search" method="post">
<table border="0" width="90%">
<tr>
	<td colspan="6"><strong>Data Responden</strong></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td width="120px">No Responden</td>
	<td><input type="text" name="no_responden" id="no_responden" value="<?php echo $dat_pengukuran['NO_RESPONDEN']; ?>" class="text_dt" style="width:100px;" /></td>
    <td width="120px">&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>Umur</td>
	<td><input type="text" name="umur_tahun" id="umur_tahun" value="<?php echo $dat_pengukuran['UMUR_TAHUN']; ?>" class="text_dt" style="width:40px;" />&nbsp;Tahun&nbsp;&nbsp;
		<input type="text" name="umur_bulan" id="umur_bulan" value="<?php echo $dat_pengukuran['UMUR_BULAN']; ?>" class="text_dt" style="width:40px;" />&nbsp;Bulan</td>
	<td>Jenis Kelamin</td>
	<td colspan="2"><input type="radio" name="jns_kelamin" value="L"
		<?php if($dat_pengukuran['JNS_KELAMIN'] == 'L') echo 'checked="checked"'; ?> >&nbsp;Laki-laki&nbsp;&nbsp;
		<input type="radio" name="jns_kelamin" value="P"
		<?php if($dat_pengukuran['JNS_KELAMIN'] == 'P') echo 'checked="checked"'; ?> >&nbsp;Perempuan</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>Pendidikan</td>
	<td><select name="pendidikan" class="text_dt" style="width:210px;">
				<option value=""> - </option>
				<option value="1" <?php if($dat_pengukuran['PENDIDIKAN'] == '1') echo 'selected="selected"'; ?>>SD Kebawah</option>
				<option value="2" <?php if($dat_pengukuran['PENDIDIKAN'] == '2') echo 'selected="selected"'; ?>>SLTP</option>
				<option value="3" <?php if($dat_pengukuran['PENDIDIKAN'] == '3') echo 'selected="selected"'; ?>>SLTA</option>
				<option value="4" <?php if($dat_pengukuran['PENDIDIKAN'] == '4') echo 'selected="selected"'; ?>>D1-D2-D3–D4</option>
				<option value="5" <?php if($dat_pengukuran['PENDIDIKAN'] == '5') echo 'selected="selected"'; ?>>S1</option>
				<option value="6" <?php if($dat_pengukuran['PENDIDIKAN'] == '6') echo 'selected="selected"'; ?>>S2 Keatas</option>
			</select></td>
    <td>Pekerjaan</td>
	<td colspan="2"><select name="pekerjaan" class="text_dt" style="width:210px;">
				<option value=""> - </option>
				<option value="1" <?php if($dat_pengukuran['PEKERJAAN'] == '1') echo 'selected="selected"'; ?>>PNS/ TNI/ POLRI</option>
				<option value="2" <?php if($dat_pengukuran['PEKERJAAN'] == '2') echo 'selected="selected"'; ?>>Pegawai Swasta</option>
				<option value="3" <?php if($dat_pengukuran['PEKERJAAN'] == '3') echo 'selected="selected"'; ?>>Wiraswasta/ Usahawan</option>
				<option value="4" <?php if($dat_pengukuran['PEKERJAAN'] == '4') echo 'selected="selected"'; ?>>Pelajar/ Mahasiswa</option>
				<option value="5" <?php if($dat_pengukuran['PEKERJAAN'] == '5') echo 'selected="selected"'; ?>>Lainnya</option>
			</select></td>
</tr>
<tr>
	<td colspan="6">&nbsp;</td>
</tr>
<tr>
	<td colspan="6"><strong>Pengumpulan Data</strong></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>Tanggal</td>
	<td><input type="text" name="tanggal" id="tgl_1" value="<?php echo $dat_pengukuran['TANGGAL_PENGUKURAN']; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
    <td>Pelayanan</td>
	<td colspan="2"><select name="pelayanan" class="text_dt" style="width:210px;">
				<option value=""> - </option>
				<option value="rj" <?php if($dat_pengukuran['UNIT_PELAYANAN'] == 'rj') echo 'selected="selected"'; ?>>Rawat Jalan</option>
				<option value="ri" <?php if($dat_pengukuran['UNIT_PELAYANAN'] == 'ri') echo 'selected="selected"'; ?>>Rawat Inap</option>
				<option value="gd" <?php if($dat_pengukuran['UNIT_PELAYANAN'] == 'gd') echo 'selected="selected"'; ?>>Instalasi Gawat Darurat</option>
			</select></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>Pengumpul Data</td>
	<td><input type="text" name="pengumpul_data" id="pengumpul_data" value="<?php echo $dat_pengukuran['PENGUMPUL_DATA']; ?>" class="text_dt" style="width:250px;" /></td>
    <td>Keterangan</td>
	<td colspan="2"><textarea name="keterangan" id="keterangan" class="text_dt5"><?php echo $dat_pengukuran['KETERANGAN_PENGUMPUL_DATA']; ?></textarea></td>
</tr>
<tr>
	<td colspan="6">&nbsp;</td>
</tr>
<tr>
	<td colspan="6">
	<?php
		$arr_kuisioner = array();
		$arr_kuisioner[1] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang kebersihan dan kerapian Sarana Gedung di RS?',
								'jawaban'=>array(1=>'Tidak bersih/ kotor/ jorok',
												2=>'Kurang bersih',
												3=>'Bersih',
												4=>'Sangat bersih dan rapi'));
		$arr_kuisioner[2] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang keamanan Sarana Gedung di RS termasuk potensi kehilangan/ pencurian',
								'jawaban'=>array(1=>'Tidak aman',
												2=>'Kurang aman',
												3=>'Aman',
												4=>'Sangat aman'));
		$arr_kuisioner[3] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang Kepatuhan Aturan Kawasan Bebas dari asap rokok di Area Rumah Sakit',
								'jawaban'=>array(1=>'Tidak patuh',
												2=>'Kurang patuh',
												3=>'Patuh',
												4=>'Sangat patuh'));											
		$arr_kuisioner[4] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang kelengkapan/ ketersediaan prasarana (listrik, air, fasilitas lainnya) di RS',
								'jawaban'=>array(1=>'Tidak lengkap',
												2=>'Kurang lengkap',
												3=>'Lengkap',
												4=>'Sangat lengkap'));										
		$arr_kuisioner[5] = array('pertanyaan'=>'Bagaimana menurut Saudara tentang pemeliharaan prasarana yang ada di RS',
								'jawaban'=>array(1=>'Tidak terpelihara',
												2=>'Kurang terpelihara',
												3=>'Terpelihara',
												4=>'Sangat terpelihara'));																				
		$arr_kuisioner[6] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang keamanan Prasarana di RS termasuk potensi kehilangan/ pencurian',
								'jawaban'=>array(1=>'Tidak aman',
												2=>'Kurang aman',
												3=>'Aman',
												4=>'Sangat aman'));										
		$arr_kuisioner[7] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang kelengkapan/ ketersediaan alat-alat kesehatan di RS',
								'jawaban'=>array(1=>'Tidak lengkap',
												2=>'Kurang lengkap',
												3=>'Lengkap',
												4=>'Sangat lengkap'));	
		$arr_kuisioner[8] = array('pertanyaan'=>'Bagaimana menurut Saudara tentang pemeliharaan prasarana yang ada di RS',
								'jawaban'=>array(1=>'Tidak terpelihara',
												2=>'Kurang terpelihara',
												3=>'Terpelihara',
												4=>'Sangat terpelihara'));
		$arr_kuisioner[9] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang keamanan alat-alat kesehatan di RS termasuk potensi kehilangan/ pencurian',
								'jawaban'=>array(1=>'Tidak aman',
												2=>'Kurang aman',
												3=>'Aman',
												4=>'Sangat aman'));	
		$arr_kuisioner[10] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang kecepatan pelayanan obat/ farmasi',
								'jawaban'=>array(1=>'Lambat',
												2=>'Kurang cepat',
												3=>'Cepat dan tepat',
												4=>'Sangat cepat dan tepat'));	
		$arr_kuisioner[11] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang sikap  keramahan dan kesopanan Petugas Farmasi dalam melayani pasien',
								'jawaban'=>array(1=>'Tidak ramah dan sopan',
												2=>'Kurang ramah dan sopan',
												3=>'Ramah dan sopan',
												4=>'Sangat ramah dan sopan'));										
		$arr_kuisioner[12] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang Pemberian Penjelasan Informasi Obat',
								'jawaban'=>array(1=>'Tidak jelas',
												2=>'Kurang jelas',
												3=>'Jelas',
												4=>'Sangat jelas'));										
		$arr_kuisioner[13] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang kecepatan proses pendaftaran pasien di RS',
								'jawaban'=>array(1=>'Lambat (antrean sangat panjang)',
												2=>'Kurang cepat (antrean panjang)',
												3=>'Cepat (antrean wajar)',
												4=>'Sangat cepat (tanpa antrean)'));	
		$arr_kuisioner[14] = array('pertanyaan'=>'Bagaimana menurut Saudara tentang kemudahan mendapatkan pelayanan yang ada di RS',
								'jawaban'=>array(1=>'Sangat sulit & ber belit-belit',
												2=>'Kurang mudah mendapatkan akses',
												3=>'Mudah (terhubung akses telepon, sms dll)',
												4=>'Sangat mudah (didukung teknologi)'));										
		$arr_kuisioner[15] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang kenyamanan  di Ruang Pendaftaran RS',
								'jawaban'=>array(1=>'Tidak nyaman (sempit, udara panas, berdesakan)',
												2=>'Kurang nyaman',
												3=>'Nyaman',
												4=>'Sangat nyaman'));																				
		$arr_kuisioner[16] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang sikap  keramahan dan kesopanan Dokter dalam melayani pasien',
								'jawaban'=>array(1=>'Tidak ramah dan  sopan',
												2=>'Kurang ramah dan sopan',
												3=>'Ramah dan sopan',
												4=>'Sangat ramah dan sopan'));
		$arr_kuisioner[17] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang kedisiplinan kehadiran Dokter dalam pelayanan',
								'jawaban'=>array(1=>'Tidak tepat waktu',
												2=>'Kurang tepat waktu',
												3=>'Tepat waktu',
												4=>'Sangat tepat waktu'));											
		$arr_kuisioner[18] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang kemampuan/ ketrampilan Dokter dalam melayani',
								'jawaban'=>array(1=>'Tidak trampil',
												2=>'Kurang trampil',
												3=>'Trampil',
												4=>'Sangat trampil'));	
		$arr_kuisioner[19] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang sikap  keramahan dan kesopanan Perawat dalam melayani pasien',
								'jawaban'=>array(1=>'Tidak ramah dan sopan',
												2=>'Kurang ramah dan sopan',
												3=>'Ramah dan sopan',
												4=>'Sangat ramah dan sopan'));	
		$arr_kuisioner[20] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang kedisiplinan kehadiran Perawat dalam pelayanan',
								'jawaban'=>array(1=>'Tidak tepat waktu',
												2=>'Kurang tepat waktu',
												3=>'Tepat waktu',
												4=>'Sangat tepat waktu'));	
		$arr_kuisioner[21] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang kemampuan/ ketrampilan Perawat dalam melayani',
								'jawaban'=>array(1=>'Tidak trampil',
												2=>'Kurang trampil',
												3=>'Trampil',
												4=>'Sangat trampil'));
		$arr_kuisioner[22] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang sikap  keramahan dan kesopanan Petugas lainnya dalam melayani pasien',
								'jawaban'=>array(1=>'Tidak ramah dan sopan',
												2=>'Kurang ramah dan sopan',
												3=>'Ramah dan sopan',
												4=>'Sangat ramah dan sopan'));
		$arr_kuisioner[23] = array('pertanyaan'=>'Bagaimana penndapat Saudara tentang kedisiplinan kehadiran Petugas lainnya dalam pelayanan',
								'jawaban'=>array(1=>'Tidak tepat waktu',
												2=>'Kurang tepat waktu',
												3=>'Tepat waktu',
												4=>'Sangat tepat waktu'));	
		$arr_kuisioner[24] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang kemampuan/ ketrampilan Petugas lainnya dalam melayani',
								'jawaban'=>array(1=>'Tidak trampil',
												2=>'Kurang trampil',
												3=>'Trampil',
												4=>'Sangat trampil'));	
		$arr_kuisioner[25] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang kecepatan waktu tunggu pasien di RS',
								'jawaban'=>array(1=>'Lambat (antrean sangat panjang)',
												2=>'Kurang cepat (antrean panjang)',
												3=>'Cepat (antrean wajar)',
												4=>'Sangat cepat (tanpa antrean)'));
		$arr_kuisioner[26] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang kemudahan menyampaikan keluhan Pasien',
								'jawaban'=>array(1=>'Tidak tersedia unit kerja yang menangani keluhan',
												2=>'Kurang tersedia sarana menyampaikan keluhan',
												3=>'Tersedia unit kerja/ petugas yang menerima komplain',
												4=>'Unit kerja pengelola keluman berfunsi optimal'));
		$arr_kuisioner[27] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang kenyamanan di Ruang Tunggu Pasien',
								'jawaban'=>array(1=>'Tidak nyaman (sempit, udara panas, berdesakan)',
												2=>'Kurang nyaman',
												3=>'Nyaman',
												4=>'Sangat nyaman'));
		$arr_kuisioner[28] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang kecepatan pelayanan di RS',
								'jawaban'=>array(1=>'Tidak cepat',
												2=>'Kurang cepat',
												3=>'Cepat',
												4=>'Sangat cepat'));
		$arr_kuisioner[29] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang ketepatan waktu pelayanan di RS ini',
								'jawaban'=>array(1=>'Selalu tidak tepat waktu',
												2=>'Kadang-kadang tepat waktu',
												3=>'Lebih sering tepat waktu',
												4=>'Selalu tepat waktu'));
		$arr_kuisioner[30] = array('pertanyaan'=>'Bagaimana pendapat Saudara tentang keamanan pelayanan di unit Saudara mendapatkan pelayanan',
								'jawaban'=>array(1=>'Tidak aman',
												2=>'Kurang aman',
												3=>'Aman',
												4=>'Sangat aman'));										
	?>
	<table width="100%" border="0" class="tableData" id="tfhover">
	<tr>
		<td colspan="6">PENDAPAT REPONDEN TENTANG PELAYANAN RUMAH SAKIT</td>
	</tr>
	<?php
		$no = 1;
		while($no <= 15){
		$jawaban_p1 = $arr_kuisioner[$no]['jawaban']; 	
		$jawaban_p2 = $arr_kuisioner[$no + 15]['jawaban']; 	
	?>
		  <tr>
			<td><?php echo $no; ?>.</td>
			<td colspan="2"><?php echo $arr_kuisioner[$no]['pertanyaan']; ?></td>
			<td><?php echo $no + 15; ?>.</td>
			<td colspan="2"><?php echo $arr_kuisioner[$no + 15]['pertanyaan']; ?></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><input type="radio" name="jawaban_<?php echo $no; ?>" value="1" <?php if($dat_pengukuran['PERTANYAAN_'. $no] == '1') echo 'checked="checked"'; ?> />&nbsp;a.</td>
			<td><?php echo $jawaban_p1[1]; ?></td>
			<td>&nbsp;</td>
			<td><input type="radio" name="jawaban_<?php echo $no + 15; ?>" value="1" <?php 
				$xno = $no + 15;
				if($dat_pengukuran['PERTANYAAN_'. $xno] == '1') echo 'checked="checked"'; ?> />&nbsp;a.</td>
			<td><?php echo $jawaban_p2[1]; ?></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><input type="radio" name="jawaban_<?php echo $no; ?>" value="2" <?php if($dat_pengukuran['PERTANYAAN_'. $no] == '2') echo 'checked="checked"'; ?> />&nbsp;b.</td>
			<td><?php echo $jawaban_p1[2]; ?></td>
			<td>&nbsp;</td>
			<td><input type="radio" name="jawaban_<?php echo $no + 15; ?>" value="2" <?php 
				$xno = $no + 15;
				if($dat_pengukuran['PERTANYAAN_'. $xno] == '2') echo 'checked="checked"'; ?> />&nbsp;b.</td>
			<td><?php echo $jawaban_p2[2]; ?></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><input type="radio" name="jawaban_<?php echo $no; ?>" value="3" <?php if($dat_pengukuran['PERTANYAAN_'. $no] == '3') echo 'checked="checked"'; ?> />&nbsp;c.</td>
			<td><?php echo $jawaban_p1[3]; ?></td>
			<td>&nbsp;</td>
			<td><input type="radio" name="jawaban_<?php echo $no + 15; ?>" value="3" <?php 
				$xno = $no + 15;
				if($dat_pengukuran['PERTANYAAN_'. $xno] == '3') echo 'checked="checked"'; ?> />&nbsp;c.</td>
			<td><?php echo $jawaban_p2[3]; ?></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><input type="radio" name="jawaban_<?php echo $no; ?>" value="4" <?php if($dat_pengukuran['PERTANYAAN_'. $no] == '4') echo 'checked="checked"'; ?> />&nbsp;d.</td>
			<td><?php echo $jawaban_p1[4]; ?></td>
			<td>&nbsp;</td>
			<td><input type="radio" name="jawaban_<?php echo $no + 15; ?>" value="4" <?php 
				$xno = $no + 15;
				if($dat_pengukuran['PERTANYAAN_'. $xno] == '4') echo 'checked="checked"'; ?> />&nbsp;d.</td>
			<td><?php echo $jawaban_p2[4]; ?></td>
		  </tr>
	<?php $no++;
		}
	?>	
	</table>
	</td>
</tr>
<tr>
	<td colspan="6">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
    <td colspan="4" align="right">
	<input type="submit" name="simpan" value="simpan" class="myButton" />
	<a href="index.php?link=8e2ed4ba644a6342aeddd6c030d7ad8e">
		<input type="button" value="tutup" class="myButton" />
		</a>
	<input type="hidden" name="idx" value="<?php echo $idx; ?>" />
	</td>
</tr>
</table>
</form>
</div>
</div> 