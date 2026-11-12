<?php
$irja_id = $_GET['idx'];
$final = '';
if(isset($irja_final)) $final = $irja_final;
$newtriase = false;
if($_GET['link'] == '61d85988374990d2bbb0ced59a74a7cc') $newtriase = true;

function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|','!',$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

if (isset($_POST['irja_id'])){
    $st_save = true;
	if($st_save){
		$riwayat_kunjungan = array('rujukan'=>((isset($_POST['rujukan'])) ? $_POST['rujukan'] : ''),
						'diantar_oleh'=>replace_quote($_POST['diantar_oleh']),
						'transportasi'=>replace_quote($_POST['transportasi']),
						'rujukan_dari'=>((isset($_POST['rujukan_dari'])) ? $_POST['rujukan_dari'] : ''),
						'rujukan_ket'=>replace_quote($_POST['rujukan_ket']),
						'dikirim_polisi'=>((isset($_POST['dikirim_polisi'])) ? $_POST['dikirim_polisi'] : ''),
						'dikirim_polisi_ket'=>replace_quote($_POST['dikirim_polisi_ket']),
						'visum'=>((isset($_POST['visum'])) ? $_POST['visum'] : ''),
						'kasus_trauma'=>((isset($_POST['kasus_trauma'])) ? $_POST['kasus_trauma'] : ''),
						'trauma_kll'=>((isset($_POST['trauma_kll'])) ? $_POST['trauma_kll'] : ''),
						'trauma_kdrt'=>((isset($_POST['trauma_kdrt'])) ? $_POST['trauma_kdrt'] : ''),
						'trauma_kec'=>((isset($_POST['trauma_kec'])) ? $_POST['trauma_kec'] : ''),
						'trauma_ca'=>((isset($_POST['trauma_ca'])) ? $_POST['trauma_ca'] : ''));
		$riwayat_kunjungan = json_encode($riwayat_kunjungan);
		$riwayat_kunjungan = str_replace('"','|',$riwayat_kunjungan);
		
		$subyektif = array('riwayat_alergi'=>((isset($_POST['riwayat_alergi'])) ? $_POST['riwayat_alergi'] : ''),
						'keluhan'=>replace_quote($_POST['keluhan']),
						'alergi_ket'=>replace_quote($_POST['alergi_ket']));
		$subyektif = json_encode($subyektif);
		$subyektif = str_replace('"','|',$subyektif);
		
		$obyektif = array('keadaan_umum'=>((isset($_POST['keadaan_umum'])) ? $_POST['keadaan_umum'] : ''),
						'gcs_e'=>replace_quote($_POST['gcs_e']),
						'gcs_m'=>replace_quote($_POST['gcs_m']),
						'gcs_v'=>replace_quote($_POST['gcs_v']),
						'tekanan_darah'=>replace_quote($_POST['tekanan_darah']),
						'frekuensi_nafas'=>replace_quote($_POST['frekuensi_nafas']),
						'suhu_tubuh'=>replace_quote($_POST['suhu_tubuh']),
						'frekuensi_nadi'=>replace_quote($_POST['frekuensi_nadi']),
						'berat_badan'=>replace_quote($_POST['berat_badan']),
						'tinggi_badan'=>replace_quote($_POST['tinggi_badan']),
						'skor_nyeri'=>((isset($_POST['skor_nyeri'])) ? $_POST['skor_nyeri'] : ''));
		$obyektif = json_encode($obyektif);
		$obyektif = str_replace('"','|',$obyektif);
		
		$airway = array('airway_bebas'=>((isset($_POST['airway_bebas'])) ? $_POST['airway_bebas'] : ''),
						'airway_asing'=>((isset($_POST['airway_asing'])) ? $_POST['airway_asing'] : ''),
						'airway_sputum'=>((isset($_POST['airway_sputum'])) ? $_POST['airway_sputum'] : ''),
						'airway_darah'=>((isset($_POST['airway_darah'])) ? $_POST['airway_darah'] : ''),
						'airway_lidah'=>((isset($_POST['airway_lidah'])) ? $_POST['airway_lidah'] : ''));
		$airway = json_encode($airway);
		$airway = str_replace('"','|',$airway);
		
		$breathing = array('breathing_normal'=>((isset($_POST['breathing_normal'])) ? $_POST['breathing_normal'] : ''),
						'breathing_tachipneu'=>((isset($_POST['breathing_tachipneu'])) ? $_POST['breathing_tachipneu'] : ''),
						'breathing_bradipneu'=>((isset($_POST['breathing_bradipneu'])) ? $_POST['breathing_bradipneu'] : ''),
						'breathing_hiperventilasi'=>((isset($_POST['breathing_hiperventilasi'])) ? $_POST['breathing_hiperventilasi'] : ''),
						'breathing_orthopneu'=>((isset($_POST['breathing_orthopneu'])) ? $_POST['breathing_orthopneu'] : ''),
						'breathing_apneu'=>((isset($_POST['breathing_apneu'])) ? $_POST['breathing_apneu'] : ''),
						'bunyi_nafas'=>((isset($_POST['bunyi_nafas'])) ? $_POST['bunyi_nafas'] : ''),
						'irama_nafas'=>((isset($_POST['irama_nafas'])) ? $_POST['irama_nafas'] : ''),
						'paru'=>((isset($_POST['paru'])) ? $_POST['paru'] : ''),
						'bantu_nafas'=>((isset($_POST['bantu_nafas'])) ? $_POST['bantu_nafas'] : ''));
		$breathing = json_encode($breathing);
		$breathing = str_replace('"','|',$breathing);
		
		$circulation = array('kapiler'=>((isset($_POST['kapiler'])) ? $_POST['kapiler'] : ''),
						'ekstremitas'=>((isset($_POST['ekstremitas'])) ? $_POST['ekstremitas'] : ''));
		$circulation = json_encode($circulation);
		$circulation = str_replace('"','|',$circulation);
	
		if(empty($_POST['idx_triase'])){	
			if($newtriase){	
				mysql_query('INSERT INTO t_igd_triase (NAMA_PASIEN,TGL_LAHIR,JNS_KELAMIN,WAKTU_KUNJUNGAN,RIWAYAT_KUNJUNGAN,
					SUBYEKTIF,OBYEKTIF,AIRWAY,BREATHING,CIRCULATION,ASSESMENT,TINDAK_LANJUT,TGL_ASSESMENT,PEGAWAI_ID,REGISTER) 
					VALUES ("' . replace_quote($_POST['nama_pasien']) . '",STR_TO_DATE("' . $_POST['tgl_lahir'] . '","%d/%m/%Y"),
					"' . ((isset($_POST['jns_kelamin'])) ? $_POST['jns_kelamin'] : '') . '",
					STR_TO_DATE("' . $_POST['tanggal'] . ' ' . $_POST['jam'] . ':' . $_POST['menit'] . '","%d/%m/%Y %H:%i"),
					"' . $riwayat_kunjungan . '","' . $subyektif . '","' . $obyektif . '","' . $airway . '","' . $breathing . '",
					"' . $circulation . '","' . ((isset($_POST['asesmen'])) ? $_POST['asesmen'] : '') . '",
					"' . ((isset($_POST['tindak_lanjut'])) ? $_POST['tindak_lanjut'] : '') . '",
					NOW(),"' . $_POST['pegawai_id'] . '","' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die(mysql_error());
			}else{
				mysql_query('INSERT INTO t_igd_triase (IRJA_ID,WAKTU_KUNJUNGAN,RIWAYAT_KUNJUNGAN,SUBYEKTIF,OBYEKTIF,AIRWAY,BREATHING,
					CIRCULATION,ASSESMENT,TINDAK_LANJUT,TGL_ASSESMENT,PEGAWAI_ID,REGISTER) 
					VALUES ("' . $_POST['irja_id'] . '",STR_TO_DATE("' . $_POST['tanggal'] . ' ' . $_POST['jam'] . ':' . $_POST['menit'] . '","%d/%m/%Y %H:%i"),
					"' . $riwayat_kunjungan . '","' . $subyektif . '","' . $obyektif . '","' . $airway . '","' . $breathing . '",
					"' . $circulation . '","' . ((isset($_POST['asesmen'])) ? $_POST['asesmen'] : '') . '",
					"' . ((isset($_POST['tindak_lanjut'])) ? $_POST['tindak_lanjut'] : '') . '",
					NOW(),"' . $_POST['pegawai_id'] . '","' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die(mysql_error());
			}		
		}else{
			if($newtriase){	
				mysql_query('UPDATE t_igd_triase 
					SET NAMA_PASIEN = "' . replace_quote($_POST['nama_pasien']) . '",
					TGL_LAHIR = STR_TO_DATE("' . $_POST['tgl_lahir'] . '","%d/%m/%Y"),
					JNS_KELAMIN = "' . ((isset($_POST['jns_kelamin'])) ? $_POST['jns_kelamin'] : '') . '",	
					WAKTU_KUNJUNGAN = STR_TO_DATE("' . $_POST['tanggal'] . ' ' . $_POST['jam'] . ':' . $_POST['menit'] . '","%d/%m/%Y %H:%i"),
					RIWAYAT_KUNJUNGAN = "' . $riwayat_kunjungan . '",
					SUBYEKTIF = "' . $subyektif . '",
					OBYEKTIF = "' . $obyektif . '",
					AIRWAY = "' . $airway . '",
					BREATHING = "' . $breathing . '",
					CIRCULATION = "' . $circulation . '",
					ASSESMENT = "' . ((isset($_POST['asesmen'])) ? $_POST['asesmen'] : '') . '",
					TINDAK_LANJUT = "' . ((isset($_POST['tindak_lanjut'])) ? $_POST['tindak_lanjut'] : '') . '",
					TGL_ASSESMENT = NOW(),
					PEGAWAI_ID = "' . $_POST['pegawai_id'] . '",
					REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
					ST_CREATE_ERM = NULL
					WHERE TRIASE_ID = "' . $_POST['idx_triase'] . '"') or die(mysql_error());
			}else{
				mysql_query('UPDATE t_igd_triase 
					SET WAKTU_KUNJUNGAN = STR_TO_DATE("' . $_POST['tanggal'] . ' ' . $_POST['jam'] . ':' . $_POST['menit'] . '","%d/%m/%Y %H:%i"),
					RIWAYAT_KUNJUNGAN = "' . $riwayat_kunjungan . '",
					SUBYEKTIF = "' . $subyektif . '",
					OBYEKTIF = "' . $obyektif . '",
					AIRWAY = "' . $airway . '",
					BREATHING = "' . $breathing . '",
					CIRCULATION = "' . $circulation . '",
					ASSESMENT = "' . ((isset($_POST['asesmen'])) ? $_POST['asesmen'] : '') . '",
					TINDAK_LANJUT = "' . ((isset($_POST['tindak_lanjut'])) ? $_POST['tindak_lanjut'] : '') . '",
					TGL_ASSESMENT = NOW(),
					PEGAWAI_ID = "' . $_POST['pegawai_id'] . '",
					REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
					ST_CREATE_ERM = NULL
					WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
			}		
		}
		
		mysql_query('UPDATE t_irja SET JAM_TRIAGE = STR_TO_DATE("' . $_POST['tanggal'] . ' ' . $_POST['jam'] . ':' . $_POST['menit'] . '","%d/%m/%Y %H:%i")
					WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
	
		/*
		include('lib/vendor/autoload.php');
		include('lib/html2openxml/HTMLtoOpenXML.php');
		include('edoc_rekammedik/new/erm_create_triase_pasien_gawat_darurat.php');
		erm_triase_pasien_gawat_darurat($_POST['irja_id']);
		*/
		?>
		<script language="JavaScript" >
			alert('Simpan Triase Pasien Gawat Darurat Berhasil.');
			<?php if($newtriase){ ?>
			window.location = "index.php?link=a4c05172e4a5766192428762e7c6b30a&";
			<?php }else{ ?>
			window.location = "<?php echo currentUrl(); ?>";
			<?php } ?>
		</script>
		<?php 
	}else{
		$msg_info = 'Harus Oleh Perawat.';
	}
}	

$tanggal = date('d/m/Y');
$jam = date('H');
$menit = date('i');

$qry_triase = 'SELECT TRIASE_ID,RIWAYAT_KUNJUNGAN,SUBYEKTIF,OBYEKTIF,AIRWAY,BREATHING,
			CIRCULATION,ASSESMENT,TINDAK_LANJUT,TGL_ASSESMENT,PEGAWAI_ID,REGISTER,
			DATE_FORMAT(WAKTU_KUNJUNGAN,"%d/%m/%Y") AS TANGGAL_KUNJUNGAN,
			DATE_FORMAT(WAKTU_KUNJUNGAN,"%H") AS JAM_KUNJUNGAN,
			DATE_FORMAT(WAKTU_KUNJUNGAN,"%i") AS MENIT_KUNJUNGAN,
			NAMA_PASIEN,JNS_KELAMIN,
			DATE_FORMAT(TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR
			FROM t_igd_triase';
			
if($newtriase){			
	$qry_triase .= ' WHERE TRIASE_ID = "' . $irja_id . '"';
}else{
	$qry_triase .= ' WHERE IRJA_ID = "' . $irja_id . '"';
}	
$get_triase = mysql_query($qry_triase);
$dat_triase = mysql_fetch_assoc($get_triase);

$idx_triase = $dat_triase['TRIASE_ID']; 
$tanggal_kunjungan = $dat_triase['TANGGAL_KUNJUNGAN']; 
$jam_kunjungan = $dat_triase['JAM_KUNJUNGAN']; 
$menit_kunjungan = $dat_triase['MENIT_KUNJUNGAN']; 

$riwayat_kunjungan = str_replace('|','"',$dat_triase['RIWAYAT_KUNJUNGAN']);
$riwayat_kunjungan = preg_replace('/\r|\n/','\n',trim($riwayat_kunjungan));
$riwayat_kunjungan = json_decode($riwayat_kunjungan,true);

$subyektif = str_replace('|','"',$dat_triase['SUBYEKTIF']);
$subyektif = preg_replace('/\r|\n/','\n',trim($subyektif));
$subyektif = json_decode($subyektif,true);

$obyektif = str_replace('|','"',$dat_triase['OBYEKTIF']);
$obyektif = preg_replace('/\r|\n/','\n',trim($obyektif));
$obyektif = json_decode($obyektif,true);

$airway = str_replace('|','"',$dat_triase['AIRWAY']);
$airway = preg_replace('/\r|\n/','\n',trim($airway));
$airway = json_decode($airway,true);

$breathing = str_replace('|','"',$dat_triase['BREATHING']);
$breathing = preg_replace('/\r|\n/','\n',trim($breathing));
$breathing = json_decode($breathing,true);

$circulation = str_replace('|','"',$dat_triase['CIRCULATION']);
$circulation = preg_replace('/\r|\n/','\n',trim($circulation));
$circulation = json_decode($circulation,true);

$asesmen = $dat_triase['ASSESMENT'];
$tindak_lanjut = $dat_triase['TINDAK_LANJUT'];

$nama_pasien = $dat_triase['NAMA_PASIEN'];
$tgl_lahir = $dat_triase['TGL_LAHIR'];
$jns_kelamin = $dat_triase['JNS_KELAMIN'];

$pegawai_id = $dat_triase['PEGAWAI_ID'];

if($newtriase){
?>
<div style=" height:auto; padding:15px; ">	
<div class="div_menu" style=" height:auto; width:auto; padding:15px;  border:1px solid #999; border-radius:5px; margin:5px; ">
<?php } ?>
<form name="formedit" id="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<input type="hidden" name="idx_triase" id="idx_triase" value="<?php echo $idx_triase; ?>" />	
    <table border="0">
		<?php if($newtriase){ ?>
		<tr>
			<td width="200px">Nama Pasien</td>
			<td colspan="5"><input type="text" name="nama_pasien" class="text_dt" style="width:280px;"
					value="<?php echo $nama_pasien; ?>" />&nbsp;&nbsp;
					Tanggal Lahir
					<input type="text" name="tgl_lahir" id="tgl_2" size="15" class="text_dt" value="<?php echo $tgl_lahir; ?>" />
					<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar9')"/>&nbsp;&nbsp;
					Jenis Kelamin
					<input type="radio" name="jns_kelamin" value="L" <?php if($jns_kelamin == 'L') echo 'checked'; ?> />Laki-laki
					<input type="radio" name="jns_kelamin" value="P" <?php if($jns_kelamin == 'P') echo 'checked'; ?> />Perempuan
			</td>
		</tr>	
		<?php } 
			if($newtriase == false and $idx_triase == ''){ ?>
				<tr>
				<td width="200px">Triase</td>
				<td colspan="5"><select name="triasenya" id="triasenya" class="text_dt" style="width:250px;">
                    <option value=""> - </option>
                    <?php 
						$sql_triase = 'SELECT TRIASE_ID,NAMA_PASIEN,
								DATE_FORMAT(TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
								JNS_KELAMIN,DATE_FORMAT(WAKTU_KUNJUNGAN,"%d-%m-%Y") AS WAKTU_KUNJUNGAN
								FROM t_igd_triase
								WHERE STR_TO_DATE(DATE_FORMAT(WAKTU_KUNJUNGAN,"%d-%m-%Y"),"%d-%m-%Y") >= DATE_ADD(NOW(), INTERVAL -2 DAY)
								AND IRJA_ID IS NULL
								ORDER BY NAMA_PASIEN';
						$get_triase = mysql_query($sql_triase) or die(mysql_error());	
						while($dat_triase = mysql_fetch_array($get_triase)){ ?>
							<option value="<?php echo $dat_triase['TRIASE_ID']; ?>"
							<?php if($dat_triase['TRIASE_ID'] == $idx_triase) echo 'selected'; ?> ><?php echo $dat_triase['NAMA_PASIEN'] . ' (' . $dat_triase['TGL_LAHIR'] . ') - ' . $dat_triase['WAKTU_KUNJUNGAN']; ?></option>
						<?php } ?>
                </select>
				<a href="#"><input type="button" name="load" value="ambil" class="myButton1" onclick="triase_load();" /></a></td>
				</tr>
				<tr>
					<td valign="top">&nbsp;</td>
					<td colspan="5">&nbsp;</td>
				</tr>	
		<?php	} ?>
		<tr>
			<td width="200px">Tanggal & Jam Kunjungan</td>
			<td colspan="5"><input type="text" name="tanggal" id="tgl_1" size="15" class="text_dt" value="<?php echo (($tanggal_kunjungan != '') ? $tanggal_kunjungan : $tanggal); ?>" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar8')"/>
			<select name="jam" id="jam" style="width:50px;" class="text_dt" >
			<?php echo getJam((($jam_kunjungan != '') ? $jam_kunjungan : $jam)); ?>
			</select>
			<select name="menit" id="menit" style="width:50px;" class="text_dt" >
			<?php echo getMenit((($menit_kunjungan != '') ? $menit_kunjungan : $menit)); ?>
			</select>
			</td>
		</tr>
		<tr>
            <td valign="top">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
        </tr>
		<tr>
           <td colspan="4">
                <input type="radio" name="rujukan" value="1" 
				<?php echo ((isset($riwayat_kunjungan['rujukan']) and $riwayat_kunjungan['rujukan'] == '1') ? 'checked' : ''); ?> />Datang sendiri, diantar oleh 
				<input type="text" name="diantar_oleh" class="text_dt" style="width:290px;"
				value="<?php echo ((isset($riwayat_kunjungan['diantar_oleh'])) ? $riwayat_kunjungan['diantar_oleh'] : ''); ?>" />
            </td>
			<td>Alat Transportasi</td>
			<td><input type="text" name="transportasi" class="text_dt" style="width:350px;"
			value="<?php echo ((isset($riwayat_kunjungan['transportasi'])) ? $riwayat_kunjungan['transportasi'] : ''); ?>" /></td>
        </tr>
		<tr>
           <td colspan="4">
                <input type="radio" name="rujukan" value="2"
				<?php echo ((isset($riwayat_kunjungan['rujukan']) and $riwayat_kunjungan['rujukan'] == '2') ? 'checked' : ''); ?> />Rujukan dari :
				<input type="radio" name="rujukan_dari" value="1"
				<?php echo ((isset($riwayat_kunjungan['rujukan_dari']) and $riwayat_kunjungan['rujukan_dari'] == '1') ? 'checked' : ''); ?> />Puskesmas
				<input type="radio" name="rujukan_dari" value="2"
				<?php echo ((isset($riwayat_kunjungan['rujukan_dari']) and $riwayat_kunjungan['rujukan_dari'] == '2') ? 'checked' : ''); ?> />Praktek Perorangan
				<input type="radio" name="rujukan_dari" value="3"
				<?php echo ((isset($riwayat_kunjungan['rujukan_dari']) and $riwayat_kunjungan['rujukan_dari'] == '3') ? 'checked' : ''); ?> />RB
            </td>
			<td><input type="radio" name="rujukan_dari" value="4"
			<?php echo ((isset($riwayat_kunjungan['rujukan_dari']) and $riwayat_kunjungan['rujukan_dari'] == '4') ? 'checked' : ''); ?> />RSUD/ RS Lain</td>
			<td><input type="text" name="rujukan_ket" class="text_dt" style="width:350px;"
			value="<?php echo ((isset($riwayat_kunjungan['rujukan_ket'])) ? $riwayat_kunjungan['rujukan_ket'] : ''); ?>" /></td>
        </tr>
		<tr>
           <td colspan="4">
                <input type="checkbox" name="dikirim_polisi" value="1" 
				<?php echo ((isset($riwayat_kunjungan['dikirim_polisi']) and $riwayat_kunjungan['dikirim_polisi'] == '1') ? 'checked' : ''); ?> />Dikirim oleh Polisi 
				<input type="text" name="dikirim_polisi_ket" class="text_dt" style="width:350px;"
				value="<?php echo ((isset($riwayat_kunjungan['dikirim_polisi_ket'])) ? $riwayat_kunjungan['dikirim_polisi_ket'] : ''); ?>" />
            </td>
			<td colspan="2">
				<input type="radio" name="visum" value="1"
				<?php echo ((isset($riwayat_kunjungan['visum']) and $riwayat_kunjungan['visum'] == '1') ? 'checked' : ''); ?> >dengan/
				<input type="radio" name="visum" value="2"
				<?php echo ((isset($riwayat_kunjungan['visum']) and $riwayat_kunjungan['visum'] == '2') ? 'checked' : ''); ?> >tidak
				diserta permintaan Visum et Repetum	
			</td>
        </tr>
		<tr>
			<td width="200px">Macam Kasus</td>
			<td colspan="5"><input type="radio" name="kasus_trauma" value="1" 
			<?php echo ((isset($riwayat_kunjungan['kasus_trauma']) and $riwayat_kunjungan['kasus_trauma'] == '1') ? 'checked' : ''); ?> />Trauma : 
				<input type="checkbox" name="trauma_kll" value="1" 
				<?php echo ((isset($riwayat_kunjungan['trauma_kll']) and $riwayat_kunjungan['trauma_kll'] == '1') ? 'checked' : ''); ?> />KLL
				<input type="checkbox" name="trauma_kdrt" value="1" 
				<?php echo ((isset($riwayat_kunjungan['trauma_kdrt']) and $riwayat_kunjungan['trauma_kdrt'] == '1') ? 'checked' : ''); ?> />KDRT
				<input type="checkbox" name="trauma_kec" value="1" 
				<?php echo ((isset($riwayat_kunjungan['trauma_kec']) and $riwayat_kunjungan['trauma_kec'] == '1') ? 'checked' : ''); ?> />Kecelakaan Kerja
				<input type="checkbox" name="trauma_ca" value="1" 
				<?php echo ((isset($riwayat_kunjungan['trauma_ca']) and $riwayat_kunjungan['trauma_ca'] == '1') ? 'checked' : ''); ?> />Child Abuse (Kekerasan Anak)
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="5">
				<input type="radio" name="kasus_trauma" value="2" 
				<?php echo ((isset($riwayat_kunjungan['kasus_trauma']) and $riwayat_kunjungan['kasus_trauma'] == '2') ? 'checked' : ''); ?> />Non Trauma
			</td>
		</tr>
		<tr>
            <td valign="top">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
			<td valign="top">Subyektif (Anamnesis)</td>
            <td valign="top" width="200px">Keluhan Utama</td>
            <td colspan="4">
                <textarea name="keluhan" id="keluhan" cols="80" rows="5" class="text_dt2"><?php echo ((isset($subyektif['keluhan'])) ? $subyektif['keluhan'] : ''); ?></textarea>
            </td>
        </tr>
		<tr>
			<td valign="top">&nbsp;</td>
            <td valign="top">Riwayat Alergi</td>
            <td colspan="4"><input type="radio" name="riwayat_alergi" value="1" 
					<?php echo ((isset($subyektif['riwayat_alergi']) and $subyektif['riwayat_alergi'] == '1') ? 'checked' : ''); ?> />Tidak ada
					<input type="radio" name="riwayat_alergi" value="2" 
					<?php echo ((isset($subyektif['riwayat_alergi']) and $subyektif['riwayat_alergi'] == '2') ? 'checked' : ''); ?> />Ada</td>
        </tr>
		<tr>
			<td valign="top">&nbsp;</td>
            <td valign="top" width="200px">&nbsp;</td>
            <td colspan="4">
                <textarea name="alergi_ket" id="alergi_ket" class="text_dt2"><?php echo ((isset($subyektif['alergi_ket'])) ? $subyektif['alergi_ket'] : ''); ?></textarea>
            </td>
        </tr>
		<tr>
            <td valign="top">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
        </tr>
		<tr>
            <td valign="top">Obyektif</td>
            <td colspan="5">
                <table border="0">
				<tr>	
					<td width="200px">Keadaan Umum</td>
					<td colspan="4"><input type="radio" name="keadaan_umum" value="1" 
					<?php echo ((isset($obyektif['keadaan_umum']) and $obyektif['keadaan_umum'] == '1') ? 'checked' : ''); ?> />Baik
					<input type="radio" name="keadaan_umum" value="2" 
					<?php echo ((isset($obyektif['keadaan_umum']) and $obyektif['keadaan_umum'] == '2') ? 'checked' : ''); ?> />Sedang
					<input type="radio" name="keadaan_umum" value="3" 
					<?php echo ((isset($obyektif['keadaan_umum']) and $obyektif['keadaan_umum'] == '3') ? 'checked' : ''); ?> />Buruk</td>
				</tr>
				<tr>	
					<td>Kesadaran (GCS)</td>
					<td colspan="4">E <input type="text" name="gcs_e" style="width:50px;" 
						value="<?php echo ((isset($obyektif['gcs_e'])) ? $obyektif['gcs_e'] : ''); ?>" class="text_dt" />
						V <input type="text" name="gcs_v" style="width:50px;" 
						value="<?php echo ((isset($obyektif['gcs_v'])) ? $obyektif['gcs_v'] : ''); ?>" class="text_dt" />
						M <input type="text" name="gcs_m" style="width:50px;"
						value="<?php echo ((isset($obyektif['gcs_m'])) ? $obyektif['gcs_m'] : ''); ?>" class="text_dt" /></td>
				</tr>	
				<tr>	
					<td>Tekanan Darah</td>
					<td width="200px"><input type="text" name="tekanan_darah" 
					value="<?php echo ((isset($obyektif['tekanan_darah'])) ? $obyektif['tekanan_darah'] : ''); ?>" class="text_dt" />&nbsp;mmHg</td>
					<td width="50px">&nbsp;</td>
					<td width="200px">Frekuensi Nafas</td>
					<td><input type="text" name="frekuensi_nafas" 
					value="<?php echo ((isset($obyektif['frekuensi_nafas'])) ? $obyektif['frekuensi_nafas'] : ''); ?>" class="text_dt" />&nbsp;x/menit</td>
				</tr>	
				<tr>	
					<td>Suhu Tubuh</td>
					<td><input type="text" name="suhu_tubuh" 
					value="<?php echo ((isset($obyektif['suhu_tubuh'])) ? $obyektif['suhu_tubuh'] : ''); ?>" class="text_dt" />&nbsp;oC</td>
					<td width="50px">&nbsp;</td>
					<td>Frekuensi Nadi</td>
					<td><input type="text" name="frekuensi_nadi" 
					value="<?php echo ((isset($obyektif['frekuensi_nadi'])) ? $obyektif['frekuensi_nadi'] : ''); ?>" class="text_dt" />&nbsp;x/menit</td>
				</tr>	
				<tr>	
					<td>Berat Badan</td>
					<td><input type="text" name="berat_badan" 
					value="<?php echo ((isset($obyektif['berat_badan'])) ? $obyektif['berat_badan'] : ''); ?>" class="text_dt" />&nbsp;Kg</td>
					<td width="50px">&nbsp;</td>
					<td>Tinggi Badan</td>
					<td><input type="text" name="tinggi_badan" 
					value="<?php echo ((isset($obyektif['tinggi_badan'])) ? $obyektif['tinggi_badan'] : ''); ?>" class="text_dt" />&nbsp;Cm</td>
				</tr>
				<tr>	
					<td>Skor Nyeri</td>
					<td colspan="4">
						<input type="radio" name="skor_nyeri" value="0" 
						<?php echo ((isset($obyektif['skor_nyeri']) and $obyektif['skor_nyeri'] == '0') ? 'checked' : ''); ?> />0
						<input type="radio" name="skor_nyeri" value="1" 
						<?php echo ((isset($obyektif['skor_nyeri']) and $obyektif['skor_nyeri'] == '1') ? 'checked' : ''); ?> />1
						<input type="radio" name="skor_nyeri" value="2" 
						<?php echo ((isset($obyektif['skor_nyeri']) and $obyektif['skor_nyeri'] == '2') ? 'checked' : ''); ?> />2
						<input type="radio" name="skor_nyeri" value="3" 
						<?php echo ((isset($obyektif['skor_nyeri']) and $obyektif['skor_nyeri'] == '3') ? 'checked' : ''); ?> />3
						<input type="radio" name="skor_nyeri" value="4" 
						<?php echo ((isset($obyektif['skor_nyeri']) and $obyektif['skor_nyeri'] == '4') ? 'checked' : ''); ?> />4
						<input type="radio" name="skor_nyeri" value="5" 
						<?php echo ((isset($obyektif['skor_nyeri']) and $obyektif['skor_nyeri'] == '5') ? 'checked' : ''); ?> />5
						<input type="radio" name="skor_nyeri" value="6" 
						<?php echo ((isset($obyektif['skor_nyeri']) and $obyektif['skor_nyeri'] == '6') ? 'checked' : ''); ?> />6
						<input type="radio" name="skor_nyeri" value="7" 
						<?php echo ((isset($obyektif['skor_nyeri']) and $obyektif['skor_nyeri'] == '7') ? 'checked' : ''); ?> />7
						<input type="radio" name="skor_nyeri" value="8" 
						<?php echo ((isset($obyektif['skor_nyeri']) and $obyektif['skor_nyeri'] == '8') ? 'checked' : ''); ?> />8
						<input type="radio" name="skor_nyeri" value="9" 
						<?php echo ((isset($obyektif['skor_nyeri']) and $obyektif['skor_nyeri'] == '9') ? 'checked' : ''); ?> />9
						<input type="radio" name="skor_nyeri" value="10" 
						<?php echo ((isset($obyektif['skor_nyeri']) and $obyektif['skor_nyeri'] == '10') ? 'checked' : ''); ?> />10
					</td>
				</tr>
				<tr>	
					<td>&nbsp;</td>
					<td colspan="4">
						<img src="edoc_rekammedik/new/skala_nyeri.jpg" width="550px" />
					</td>
				</tr>				
				</table>
            </td>
        </tr>
		<tr>
            <td valign="top">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
        </tr>
		<tr>
			<td valign="top">Airway</td>
            <td colspan="5"><input type="checkbox" name="airway_bebas" value="1" 
				<?php echo ((isset($airway['airway_bebas']) and $airway['airway_bebas'] == '1') ? 'checked' : ''); ?> />Bebas
				<input type="checkbox" name="airway_asing" value="1" 
				<?php echo ((isset($airway['airway_asing']) and $airway['airway_asing'] == '1') ? 'checked' : ''); ?> />Benda Asing
				<input type="checkbox" name="airway_sputum" value="1" 
				<?php echo ((isset($airway['airway_sputum']) and $airway['airway_sputum'] == '1') ? 'checked' : ''); ?> />Sputum
				<input type="checkbox" name="airway_darah" value="1" 
				<?php echo ((isset($airway['airway_darah']) and $airway['airway_darah'] == '1') ? 'checked' : ''); ?> />Darah
				<input type="checkbox" name="airway_lidah" value="1" 
				<?php echo ((isset($airway['airway_lidah']) and $airway['airway_lidah'] == '1') ? 'checked' : ''); ?> />Lidah
            </td>
        </tr>
		<tr>
			<td valign="top">Breathing</td>
            <td colspan="5"><input type="checkbox" name="breathing_normal" value="1" 
				<?php echo ((isset($breathing['breathing_normal']) and $breathing['breathing_normal'] == '1') ? 'checked' : ''); ?> />Normal
				<input type="checkbox" name="breathing_tachipneu" value="1" 
				<?php echo ((isset($breathing['breathing_tachipneu']) and $breathing['breathing_tachipneu'] == '1') ? 'checked' : ''); ?> />Tachipneu
				<input type="checkbox" name="breathing_bradipneu" value="1" 
				<?php echo ((isset($breathing['breathing_bradipneu']) and $breathing['breathing_bradipneu'] == '1') ? 'checked' : ''); ?> />Bradipneu
				<input type="checkbox" name="breathing_hiperventilasi" value="1" 
				<?php echo ((isset($breathing['breathing_hiperventilasi']) and $breathing['breathing_hiperventilasi'] == '1') ? 'checked' : ''); ?> />Hiverventilasi
				<input type="checkbox" name="breathing_orthopneu" value="1"
				<?php echo ((isset($breathing['breathing_orthopneu']) and $breathing['breathing_orthopneu'] == '1') ? 'checked' : ''); ?> />Orthopneu
				<input type="checkbox" name="breathing_apneu" value="1"
				<?php echo ((isset($breathing['breathing_apneu']) and $breathing['breathing_apneu'] == '1') ? 'checked' : ''); ?> />Apneu
            </td>
        </tr>
		<tr>
			<td valign="top">&nbsp;</td>
            <td valign="top">Bunyi Nafas</td>
            <td colspan="4"><input type="radio" name="bunyi_nafas" value="1" 
				<?php echo ((isset($breathing['bunyi_nafas']) and $breathing['bunyi_nafas'] == '1') ? 'checked' : ''); ?> />Wheezing
				<input type="radio" name="bunyi_nafas" value="2" 
				<?php echo ((isset($breathing['bunyi_nafas']) and $breathing['bunyi_nafas'] == '2') ? 'checked' : ''); ?> />Stridor
            </td>
        </tr>
		<tr>
			<td valign="top">&nbsp;</td>
            <td valign="top">Irama Pernafasan</td>
            <td colspan="4"><input type="radio" name="irama_nafas" value="1" 
				<?php echo ((isset($breathing['irama_nafas']) and $breathing['irama_nafas'] == '1') ? 'checked' : ''); ?> />Teratur
				<input type="radio" name="irama_nafas" value="2" 
				<?php echo ((isset($breathing['irama_nafas']) and $breathing['irama_nafas'] == '2') ? 'checked' : ''); ?> />Tidak Teratur
            </td>
        </tr>
		<tr>
			<td valign="top">&nbsp;</td>
            <td valign="top">Pengembangan Paru</td>
            <td colspan="4"><input type="radio" name="paru" value="1" 
				<?php echo ((isset($breathing['paru']) and $breathing['paru'] == '1') ? 'checked' : ''); ?> />Menurun
				<input type="radio" name="paru" value="2" 
				<?php echo ((isset($breathing['paru']) and $breathing['paru'] == '2') ? 'checked' : ''); ?> />Retraksi Dada
				<input type="radio" name="paru" value="3" 
				<?php echo ((isset($breathing['paru']) and $breathing['paru'] == '3') ? 'checked' : ''); ?> />Asismetris
            </td>
        </tr>
		<tr>
			<td valign="top">&nbsp;</td>
            <td valign="top">Penggunaan otot bantu nafas</td>
            <td colspan="4"><input type="radio" name="bantu_nafas" value="1" 
				<?php echo ((isset($breathing['bantu_nafas']) and $breathing['bantu_nafas'] == '1') ? 'checked' : ''); ?> />Bahu diangkat
				<input type="radio" name="bantu_nafas" value="2" 
				<?php echo ((isset($breathing['bantu_nafas']) and $breathing['bantu_nafas'] == '2') ? 'checked' : ''); ?> />Pernafasan dada
				<input type="radio" name="bantu_nafas" value="3" 
				<?php echo ((isset($breathing['bantu_nafas']) and $breathing['bantu_nafas'] == '3') ? 'checked' : ''); ?> />Cuping hidung
				<input type="radio" name="bantu_nafas" value="4" 
				<?php echo ((isset($breathing['bantu_nafas']) and $breathing['bantu_nafas'] == '4') ? 'checked' : ''); ?> />Pernafasan perut
            </td>
        </tr>
		<tr>
            <td valign="top">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
        </tr>
		<tr>
			<td valign="top">Circulation</td>
            <td valign="top">Pengisian Kapiler</td>
            <td colspan="4"><input type="radio" name="kapiler" value="1" 
				<?php echo ((isset($circulation['kapiler']) and $circulation['kapiler'] == '1') ? 'checked' : ''); ?> />Kurang dari 2 detik
				<input type="radio" name="kapiler" value="2" 
				<?php echo ((isset($circulation['kapiler']) and $circulation['kapiler'] == '2') ? 'checked' : ''); ?> />Lebih dari 2 detik
            </td>
        </tr>
		<tr>
			<td valign="top">&nbsp;</td>
            <td valign="top">Ekstremitas</td>
            <td colspan="4"><input type="radio" name="ekstremitas" value="1" 
				<?php echo ((isset($circulation['ekstremitas']) and $circulation['ekstremitas'] == '1') ? 'checked' : ''); ?> />Akral Dingin
				<input type="radio" name="ekstremitas" value="2" 
				<?php echo ((isset($circulation['ekstremitas']) and $circulation['ekstremitas'] == '2') ? 'checked' : ''); ?> />Akral Hangat
				<input type="radio" name="ekstremitas" value="3" 
				<?php echo ((isset($circulation['ekstremitas']) and $circulation['ekstremitas'] == '3') ? 'checked' : ''); ?> />Pucat
				<input type="radio" name="ekstremitas" value="4" 
				<?php echo ((isset($circulation['ekstremitas']) and $circulation['ekstremitas'] == '4') ? 'checked' : ''); ?> />Sianosis
            </td>
        </tr>
		<tr>
            <td valign="top">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
        </tr>
		<tr>
			<td valign="top">Assesmen Triase</td>
            <td valign="top">Kategori Pasien</td>
            <td colspan="4"><input type="radio" name="asesmen" value="1" 
				<?php echo (($asesmen == '1') ? 'checked' : ''); ?> />Emergent/ Gawat Darurat
				<input type="radio" name="asesmen" value="2" 
				<?php echo (($asesmen == '2') ? 'checked' : ''); ?> />Urgent/ Mendesak
				<input type="radio" name="asesmen" value="3" 
				<?php echo (($asesmen == '3') ? 'checked' : ''); ?> />Non Urgent/ Tidak Mendesak
            </td>
        </tr>
		<tr>
			<td valign="top">Tindak Lanjut</td>
            <td colspan="5"><input type="radio" name="tindak_lanjut" value="1" 
				<?php echo (($tindak_lanjut == '1') ? 'checked' : ''); ?> />Periksa ke ruang pelayanan non urgent<br/>
				<input type="radio" name="tindak_lanjut" value="2" 
				<?php echo (($tindak_lanjut == '2') ? 'checked' : ''); ?> />Perawatan ke ruang observasi pasien semi kritis (Urgent)<br/>
				<input type="radio" name="tindak_lanjut" value="3" 
				<?php echo (($tindak_lanjut == '3') ? 'checked' : ''); ?> />Perawatan ke ruang resusitasi/ kritis (Emergent)
            </td>
        </tr>
		<tr>
            <td valign="top">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
        </tr>
		<tr>
			<td valign="top">Perawat</td>
            <td colspan="5">
			<select name="pegawai_id" class="text_dt" style="width:250px" >
			<?php echo getUserRawatJalan($pegawai_id, '9','15'); ?>
			</select>
            </td>
		</tr>
		<tr>
            <td valign="top">&nbsp;</td>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr><td colspan="6" align="right">
			<?php if($newtriase and isPerawat($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
				<input type="button" name="simpan" value="simpan" class="myButton1" onclick="simpan_askep();" />
			<?php } ?>
			<?php if(isPerawat($_SESSION['SES_SIMRS_TIPE_PEGAWAI']) and $final == '' and $newtriase == false){ ?>
            <input type="button" name="simpan" value="simpan" class="myButton1" onclick="simpan_askep();" />
		    <?php if(!empty($idx_triase)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "1"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idx . '"
						AND JENIS_DOKUMEN_ID = "40"
						ORDER BY FILE_ID DESC LIMIT 1';
				$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
				$dat_view_rm = mysql_fetch_assoc($get_view_rm);
			?>
				<input type="button" value="lihat" class="myButton1" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" />
			<?php } } ?>
		   </td>
        </tr>
    </table>
</form>
<?php if($newtriase){ ?>
</div>	
</div>
<?php } ?>
<script language="javascript" type="text/javascript">
<?php if(!isPerawat($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
$(':input').attr('readonly','readonly');
<?php } ?>

function simpan_askep(){
	_haschange = false;
	$('#formedit').submit();
}

function triase_load(){
	$.ajax({
		type: 'POST',
		url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=loadtriase',
		data: { idx: '<?php echo $irja_id; ?>',
				idx_triase: $( "#triasenya" ).val()
				},
		cache: false,
		success: function(data) {
				
				if (data != ''){ 
					window.location = "<?php echo currentUrl(); ?>";
				}		
	},});
}

<?php if($_GET['link'] == '61d85988374990d2bbb0ced59a74a7cc'){ ?>
var _haschange = false;

$('form :input').change(function(){
   _haschange = true;
});

window.addEventListener('beforeunload',(event) => {
    if (_haschange) {
        event.preventDefault();
    }
});
<?php } ?>	
</script>