<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|','!',$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

$irja_id = $_GET['idx'];
if (isset($_POST['irja_id'])){
	$st_save = true;
	if(!isPerawat($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])) $st_save = false;
	if($st_save){
		$st_final = 'NULL';
		if(isset($_POST['selesai'])) $st_final = '"1"';

		$keluhan_utama = $_POST['keluhan_utama'];
		$alergi = $_POST['alergi'];
		
		$tanda_vital = array('td'=>replace_quote($_POST['tekanan_darah']),
						'nadi'=>replace_quote($_POST['frekuensi_nadi']),
						'suhu'=>replace_quote($_POST['suhu_tubuh']),
						'rr'=>replace_quote($_POST['frekuensi_nafas']));
		$tanda_vital = json_encode($tanda_vital);
		$tanda_vital = str_replace('"','|',$tanda_vital);
		
		$antropometri = array('bb'=>replace_quote($_POST['berat_badan']),
						'tb'=>replace_quote($_POST['tinggi_badan']));
		$antropometri = json_encode($antropometri);
		$antropometri = str_replace('"','|',$antropometri);
		
		$status_fungsional = array('alat_bantu'=>replace_quote($_POST['alat_bantu']),
						'prothesa'=>replace_quote($_POST['prothesa']),
						'cacat'=>replace_quote($_POST['cacat']),
						'adl'=>((isset($_POST['adl'])) ? $_POST['adl'] : ''),
						'jatuh'=>((isset($_POST['jatuh'])) ? $_POST['jatuh'] : ''),
						'score'=>((isset($_POST['score'])) ? $_POST['score'] : ''),
						'tindakan_edukasi'=>((isset($_POST['tindakan_edukasi'])) ? $_POST['tindakan_edukasi'] : ''),
						'pita_kuning'=>((isset($_POST['pita_kuning'])) ? $_POST['pita_kuning'] : ''));
		$status_fungsional = json_encode($status_fungsional);
		$status_fungsional = str_replace('"','|',$status_fungsional);
		
		$nyeri = array('rasa'=>((isset($_POST['rasa_nyeri'])) ? $_POST['rasa_nyeri'] : ''),
						'skor'=>replace_quote($_POST['skor']),
						'durasi'=>replace_quote($_POST['durasi']),
						'frekuensi'=>replace_quote($_POST['frekuensi']),
						'berdenyut'=>((isset($_POST['berdenyut'])) ? $_POST['berdenyut'] : ''),
						'ngilu'=>((isset($_POST['ngilu'])) ? $_POST['ngilu'] : ''),
						'tertusuk'=>((isset($_POST['tertusuk'])) ? $_POST['tertusuk'] : ''),
						'tertekan'=>((isset($_POST['tertekan'])) ? $_POST['tertekan'] : ''),
						'tajam'=>((isset($_POST['tajam'])) ? $_POST['tajam'] : ''));
		$nyeri = json_encode($nyeri);
		$nyeri = str_replace('"','|',$nyeri);
		
		$kesehatan_umum = array('sistemik'=>replace_quote($_POST['sistemik']),
						'sistemik_r'=>((isset($_POST['sistemik_r'])) ? $_POST['sistemik_r'] : ''),
						'khusus'=>replace_quote($_POST['khusus']),
						'khusus_r'=>((isset($_POST['khusus_r'])) ? $_POST['khusus_r'] : ''),
						'obat'=>replace_quote($_POST['obat']),
						'obat_r'=>((isset($_POST['obat_r'])) ? $_POST['obat_r'] : ''),
						'alkohol'=>replace_quote($_POST['alkohol']),
						'alkohol_r'=>((isset($_POST['alkohol_r'])) ? $_POST['alkohol_r'] : ''),
						'alergi_r'=>((isset($_POST['alergi_r'])) ? $_POST['alergi_r'] : ''),
						'hormonal'=>replace_quote($_POST['hormonal']),
						'hormonal_r'=>((isset($_POST['hormonal_r'])) ? $_POST['hormonal_r'] : ''),
						'berat_r'=>((isset($_POST['berat_r'])) ? $_POST['berat_r'] : ''),
						'makan_r'=>((isset($_POST['makan_r'])) ? $_POST['makan_r'] : ''),
						'sistemik_hipertensi'=>((isset($_POST['sistemik_hipertensi'])) ? $_POST['sistemik_hipertensi'] : ''),
						'sistemik_kardiovaskular'=>((isset($_POST['sistemik_kardiovaskular'])) ? $_POST['sistemik_kardiovaskular'] : ''),
						'sistemik_diabetes'=>((isset($_POST['sistemik_diabetes'])) ? $_POST['sistemik_diabetes'] : ''),
						'sistemik_keldarah'=>((isset($_POST['sistemik_keldarah'])) ? $_POST['sistemik_keldarah'] : ''),
						'khusus_cp'=>((isset($_POST['khusus_cp'])) ? $_POST['khusus_cp'] : ''),
						'khusus_dsindrome'=>((isset($_POST['khusus_dsindrome'])) ? $_POST['khusus_dsindrome'] : ''),
						'khusus_gds'=>((isset($_POST['khusus_gds'])) ? $_POST['khusus_gds'] : ''),
						'obat_rutin'=>((isset($_POST['obat_rutin'])) ? $_POST['obat_rutin'] : ''),
						'obat_kemoterapi'=>((isset($_POST['obat_kemoterapi'])) ? $_POST['obat_kemoterapi'] : ''),
						'obat_radiasi'=>((isset($_POST['obat_radiasi'])) ? $_POST['obat_radiasi'] : ''),
						'obat_medika'=>((isset($_POST['obat_medika'])) ? $_POST['obat_medika'] : ''),
						'alkohol_a'=>((isset($_POST['alkohol_a'])) ? $_POST['alkohol_a'] : ''),
						'alkohol_merokok'=>((isset($_POST['alkohol_merokok'])) ? $_POST['alkohol_merokok'] : ''),
						'alkohol_narkoba'=>((isset($_POST['alkohol_narkoba'])) ? $_POST['alkohol_narkoba'] : ''),
						'hormonal_kehamilan'=>((isset($_POST['hormonal_kehamilan'])) ? $_POST['hormonal_kehamilan'] : ''),
						'hormonal_menopouse'=>((isset($_POST['hormonal_menopouse'])) ? $_POST['hormonal_menopouse'] : ''),
						'hormonal_puberty'=>((isset($_POST['hormonal_puberty'])) ? $_POST['hormonal_puberty'] : ''));
		$kesehatan_umum = json_encode($kesehatan_umum);
		$kesehatan_umum = str_replace('"','|',$kesehatan_umum);
		
		$kesehatan_mulut = array('manis'=>((isset($_POST['manis'])) ? $_POST['manis'] : ''),
						'berserat'=>((isset($_POST['berserat'])) ? $_POST['berserat'] : ''),
						'sikat'=>((isset($_POST['sikat'])) ? $_POST['sikat'] : ''),
						'buruk'=>((isset($_POST['buruk'])) ? $_POST['buruk'] : ''),
						'periksa'=>((isset($_POST['periksa'])) ? $_POST['periksa'] : ''),
						'risiko'=>((isset($_POST['risiko'])) ? $_POST['risiko'] : ''));
		$kesehatan_mulut = json_encode($kesehatan_mulut);
		$kesehatan_mulut = str_replace('"','|',$kesehatan_mulut);
		
		$diagnosa = array('diag_1'=>((isset($_POST['diag_1'])) ? $_POST['diag_1'] : ''),
						'diag_2'=>((isset($_POST['diag_2'])) ? $_POST['diag_2'] : ''),
						'diag_3'=>((isset($_POST['diag_3'])) ? $_POST['diag_3'] : ''),
						'diag_4'=>((isset($_POST['diag_4'])) ? $_POST['diag_4'] : ''),
						'diag_5'=>((isset($_POST['diag_5'])) ? $_POST['diag_5'] : ''),
						'diag_6'=>((isset($_POST['diag_6'])) ? $_POST['diag_6'] : ''),
						'diag_7'=>((isset($_POST['diag_7'])) ? $_POST['diag_7'] : ''),
						'diag_8'=>((isset($_POST['diag_8'])) ? $_POST['diag_8'] : ''));
		$diagnosa = json_encode($diagnosa);
		$diagnosa = str_replace('"','|',$diagnosa);
		
		$implementasi = array('impl_1'=>((isset($_POST['impl_1'])) ? $_POST['impl_1'] : ''),
						'impl_2'=>((isset($_POST['impl_2'])) ? $_POST['impl_2'] : ''),
						'impl_3'=>((isset($_POST['impl_3'])) ? $_POST['impl_3'] : ''),
						'impl_4'=>((isset($_POST['impl_4'])) ? $_POST['impl_4'] : ''),
						'impl_5'=>((isset($_POST['impl_5'])) ? $_POST['impl_5'] : ''),
						'impl_6'=>((isset($_POST['impl_6'])) ? $_POST['impl_6'] : ''),
						'impl_7'=>((isset($_POST['impl_7'])) ? $_POST['impl_7'] : ''));
		$implementasi = json_encode($implementasi);
		$implementasi = str_replace('"','|',$implementasi);
		
		$evaluasi = array('eval_1'=>((isset($_POST['eval_1'])) ? $_POST['eval_1'] : ''),
						'eval_2'=>((isset($_POST['eval_2'])) ? $_POST['eval_2'] : ''),
						'eval_3'=>((isset($_POST['eval_3'])) ? $_POST['eval_3'] : ''),
						'eval_4'=>((isset($_POST['eval_4'])) ? $_POST['eval_4'] : ''),
						'eval_5'=>((isset($_POST['eval_5'])) ? $_POST['eval_5'] : ''),
						'eval_6'=>((isset($_POST['eval_6'])) ? $_POST['eval_6'] : ''),
						'eval_7'=>((isset($_POST['eval_7'])) ? $_POST['eval_7'] : ''));
		$evaluasi = json_encode($evaluasi);
		$evaluasi = str_replace('"','|',$evaluasi);
	
		if(empty($_POST['idx_askep'])){				
			mysql_query('INSERT INTO t_irja_pengkajian_awal_kesehatan_mulut (IRJA_ASKEP_ID,KELUHAN_UTAMA,TANDA_VITAL,
			ANTROPOMETRI,STATUS_FUNGSIONAL,NYERI,RIWAYAT_KESEHATAN_UMUM,RIWAYAT_KESEHATAN_GIGI_MULUT,RIWAYAT_ALERGI,
			DIAGNOSA,IMPELEMENTASI,EVALUASI,TGL_ASSESMENT,PEGAWAI_ID,ST_SELESAI,USER_KLINIK) 
			VALUES ("' . $_POST['irja_id'] . '","' . $keluhan_utama . '","' . $tanda_vital . '",
			"' . $antropometri . '","' . $status_fungsional . '","' . $nyeri . '","' . $kesehatan_umum . '",
			"' . $kesehatan_mulut . '","' . $alergi . '","' . $diagnosa . '",
			"' . $implementasi . '","' . $evaluasi . '",NOW(),"' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '","' . $st_final . '",
			"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irja_pengkajian_awal_kesehatan_mulut 
				SET KELUHAN_UTAMA = "' . $keluhan_utama . '" ,
				TANDA_VITAL = "' . $tanda_vital . '",
				ANTROPOMETRI = "' . $antropometri . '",
				STATUS_FUNGSIONAL = "' . $status_fungsional . '",
				NYERI = "' . $nyeri . '",
				RIWAYAT_KESEHATAN_UMUM = "' . $kesehatan_umum . '",
				RIWAYAT_KESEHATAN_GIGI_MULUT = "' . $kesehatan_mulut . '",
				RIWAYAT_ALERGI = "' . $alergi . '",
				DIAGNOSA = "' . $diagnosa . '",
				IMPELEMENTASI = "' . $implementasi . '",
				EVALUASI = "' . $evaluasi . '",
				ST_SELESAI = ' . $st_final . ',
				USER_KLINIK = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				TGL_ASSESMENT = NOW(),
				PEGAWAI_ID = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '",
				ST_CREATE_ERM = NULL
				WHERE IRJA_ASKEP_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
		}
	
		/*
		include('lib/vendor/autoload.php');
		include('lib/html2openxml/HTMLtoOpenXML.php');
		include('edoc_rekammedik/new/erm_create_pengkajian_awal_kesehatan_gigi_d_mulut.php');
		erm_pengkajian_awal_kesehatan_gigi_d_mulut($_POST['irja_id'],$_POST['ls_assesment'],$_POST['tgl_skr'],$_POST['ls_final']);
		*/
		?>
		<script language="JavaScript" >
			alert('Simpan Pengkajian Awal Kesehatan Gigi dan Mulut Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 
	}else{
		$msg_info = 'Harus Oleh Perawat/ Bidan.';
	}	
}	

$qry_askep = 'SELECT IRJA_ASKEP_ID,KELUHAN_UTAMA,TANDA_VITAL,ANTROPOMETRI,STATUS_FUNGSIONAL,NYERI,RIWAYAT_KESEHATAN_UMUM,
				RIWAYAT_KESEHATAN_GIGI_MULUT,RIWAYAT_ALERGI,DIAGNOSA,IMPELEMENTASI,EVALUASI,
				ST_SELESAI,DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT,
				DATE_FORMAT(NOW(),"%d/%m/%Y") AS TGL_SKR
				FROM t_irja_pengkajian_awal_kesehatan_mulut
				WHERE IRJA_ASKEP_ID = "' . $irja_id . '"';
$get_askep = mysql_query($qry_askep);
$dat_askep = mysql_fetch_assoc($get_askep);

$idx_askep = $dat_askep['IRJA_ASKEP_ID']; 
$keluhan_utama = $dat_askep['KELUHAN_UTAMA'];
$alergi = $dat_askep['RIWAYAT_ALERGI'];
 
$tanda_vital = str_replace('|','"',$dat_askep['TANDA_VITAL']);
$tanda_vital = preg_replace('/\r|\n/','\n',trim($tanda_vital));
$tanda_vital = json_decode($tanda_vital,true);

$antropometri = str_replace('|','"',$dat_askep['ANTROPOMETRI']);
$antropometri = preg_replace('/\r|\n/','\n',trim($antropometri));
$antropometri = json_decode($antropometri,true);

$status_fungsional = str_replace('|','"',$dat_askep['STATUS_FUNGSIONAL']);
$status_fungsional = preg_replace('/\r|\n/','\n',trim($status_fungsional));
$status_fungsional = json_decode($status_fungsional,true);

$nyeri = str_replace('|','"',$dat_askep['NYERI']);
$nyeri = preg_replace('/\r|\n/','\n',trim($nyeri));
$nyeri = json_decode($nyeri,true);

$kesehatan_umum = str_replace('|','"',$dat_askep['RIWAYAT_KESEHATAN_UMUM']);
$kesehatan_umum = preg_replace('/\r|\n/','\n',trim($kesehatan_umum));
$kesehatan_umum = json_decode($kesehatan_umum,true);

$kesehatan_mulut = str_replace('|','"',$dat_askep['RIWAYAT_KESEHATAN_GIGI_MULUT']);
$kesehatan_mulut = preg_replace('/\r|\n/','\n',trim($kesehatan_mulut));
$kesehatan_mulut = json_decode($kesehatan_mulut,true);

$diagnosa = str_replace('|','"',$dat_askep['DIAGNOSA']);
$diagnosa = preg_replace('/\r|\n/','\n',trim($diagnosa));
$diagnosa = json_decode($diagnosa,true);

$implementasi = str_replace('|','"',$dat_askep['IMPELEMENTASI']);
$implementasi = preg_replace('/\r|\n/','\n',trim($implementasi));
$implementasi = json_decode($implementasi,true);

$evaluasi = str_replace('|','"',$dat_askep['EVALUASI']);
$evaluasi = preg_replace('/\r|\n/','\n',trim($evaluasi));
$evaluasi = json_decode($evaluasi,true);

$selesai = $dat_askep['ST_SELESAI'];
$tgl_assesment = $dat_askep['TGL_ASSESMENT'];
$tgl_skr = $dat_askep['TGL_SKR'];
?>
<form name="formrujukan" id="formrujukan" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
    <input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
	<input type="hidden" name="idx_askep" id="idx_askep" value="<?php echo $idx_askep; ?>" />	
	<input type="hidden" name="ls_assesment" id="ls_assesment" value="<?php echo $tgl_assesment; ?>" />	
	<input type="hidden" name="ls_final" id="ls_final" value="<?php echo $selesai; ?>" />	
	<input type="hidden" name="tgl_skr" id="tgl_skr" value="<?php echo $tgl_skr; ?>" />
    <table border="0">
        <tr>
            <td valign="top">Keluhan Utama</td>
            <td colspan="3">
                <textarea name="keluhan_utama" id="keluhan_utama" cols="80" rows="5" class="text_dt2"><?php echo $keluhan_utama; ?></textarea>
            </td>
        </tr>
		<tr>
		<tr>
            <td valign="top">Tanda Vital</td>
            <td colspan="3">&nbsp;</td>
		</tr>	
		<tr>
            <td valign="top">&nbsp;</td>
            <td colspan="3">
                <table border="0" width="100%">
				<tr>	
					<td width="150px">Tekanan Darah</td>
					<td><input type="text" name="tekanan_darah" value="<?php echo ((isset($tanda_vital['td'])) ? $tanda_vital['td'] : ''); ?>" class="text_dt" />&nbsp;mmHg</td>
					<td width="50px">&nbsp;</td>
					<td width="150px">Frekuensi Nadi</td>
					<td><input type="text" name="frekuensi_nadi" value="<?php echo ((isset($tanda_vital['nadi'])) ? $tanda_vital['nadi'] : ''); ?>" class="text_dt" />&nbsp;x/menit</td>
				</tr>	
				<tr>	
					<td>Suhu Tubuh</td>
					<td><input type="text" name="suhu_tubuh" value="<?php echo ((isset($tanda_vital['suhu'])) ? $tanda_vital['suhu'] : ''); ?>" class="text_dt" />&nbsp;oC</td>
					<td width="50px">&nbsp;</td>
					<td>Respirasi</td>
					<td><input type="text" name="frekuensi_nafas" value="<?php echo ((isset($tanda_vital['rr'])) ? $tanda_vital['rr'] : ''); ?>" class="text_dt" />&nbsp;x/menit</td>
				</tr>
				</table>
            </td>
        </tr>
		<tr>
            <td valign="top">Antropometri</td>
            <td colspan="3">
                <table border="0" width="100%">
				<tr>	
					<td width="150px">Berat Badan</td>
					<td><input type="text" name="berat_badan" value="<?php echo ((isset($antropometri['bb'])) ? $antropometri['bb'] : ''); ?>" class="text_dt" />&nbsp;Kg</td>
					<td width="50px">&nbsp;</td>
					<td width="150px">Tinggi Badan</td>
					<td><input type="text" name="tinggi_badan" value="<?php echo ((isset($antropometri['tb'])) ? $antropometri['tb'] : ''); ?>" class="text_dt" />&nbsp;Cm</td>
				</tr>		
				</table>
            </td>
        </tr>
		<tr>
            <td valign="top">Fungsional</td>
            <td colspan="3">&nbsp;</td>
		</tr>	
		 <tr>
            <td valign="top">&nbsp;</td>
            <td colspan="3">
                <table border="0" width="100%">
				<tr>	
					<td width="150px">Alat Bantu</td>
					<td><input type="text" name="alat_bantu" value="<?php echo ((isset($status_fungsional['alat_bantu'])) ? $status_fungsional['alat_bantu'] : ''); ?>" class="text_dt" style="width:510px;" /></td>
				</tr>
				<tr>	
					<td width="150px">Prothesa</td>
					<td><input type="text" name="prothesa" value="<?php echo ((isset($status_fungsional['prothesa'])) ? $status_fungsional['prothesa'] : ''); ?>" class="text_dt" style="width:510px;" /></td>
				</tr>	
				<tr>	
					<td width="150px">Cacat Tubuh</td>
					<td><input type="text" name="cacat" value="<?php echo ((isset($status_fungsional['cacat'])) ? $status_fungsional['cacat'] : ''); ?>" class="text_dt" style="width:510px;" /></td>
				</tr>
				<tr>	
					<td width="150px">ADL</td>
					<td><input type="radio" name="adl" value="1" 
						<?php echo ((isset($status_fungsional['adl']) and $status_fungsional['adl'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Mandiri
					 <input type="radio" name="adl" value="2" 
						<?php echo ((isset($status_fungsional['adl']) and $status_fungsional['adl'] == '2') ? 'checked' : ''); ?> 
					 />&nbsp;Dibantu</td>
				</tr>
				<tr>	
					<td width="150px">Resiko Jatuh</td>
					<td><input type="radio" name="jatuh" value="1" 
						<?php echo ((isset($status_fungsional['jatuh']) and $status_fungsional['jatuh'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Tidak
					 <input type="radio" name="jatuh" value="2" 
						<?php echo ((isset($status_fungsional['jatuh']) and $status_fungsional['jatuh'] == '2') ? 'checked' : ''); ?> 
					 />&nbsp;Risiko Rendah
					 <input type="radio" name="jatuh" value="3" 
						<?php echo ((isset($status_fungsional['jatuh']) and $status_fungsional['jatuh'] == '3') ? 'checked' : ''); ?> 
					 />&nbsp;Risiko Tinggi</td>
				</tr>
				<tr>	
					<td width="150px">Score</td>
					<td><input type="radio" name="score" value="1" 
						<?php echo ((isset($status_fungsional['score']) and $status_fungsional['score'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;0
					 <input type="radio" name="score" value="2" 
						<?php echo ((isset($status_fungsional['score']) and $status_fungsional['score'] == '2') ? 'checked' : ''); ?> 
					 />&nbsp;1
					 <input type="radio" name="score" value="3" 
						<?php echo ((isset($status_fungsional['score']) and $status_fungsional['score'] == '3') ? 'checked' : ''); ?> 
					 />&nbsp;2</td>
				</tr>
				<tr>	
					<td width="150px">Tindakan</td>
					<td><input type="checkbox" name="tindakan_edukasi" value="1" 
						<?php echo ((isset($status_fungsional['tindakan_edukasi']) and $status_fungsional['tindakan_edukasi'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Edukasi
					 <input type="checkbox" name="pita_kuning" value="1" 
						<?php echo ((isset($status_fungsional['pita_kuning']) and $status_fungsional['pita_kuning'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Pasang Pita Kuning</td>
				</tr>
				</table>
            </td>
        </tr>
		<tr>
            <td valign="top">Skrining Nyeri</td>
            <td colspan="3">&nbsp;</td>
		</tr>	
		<tr>
            <td valign="top">&nbsp;</td>
            <td colspan="3">
                <table border="0">
				<tr>
					<td colspan="2" align="center">
						<img src="edoc_rekammedik/new/skala_nyeri.jpg" width="650px" />
					</td>
				</tr>
				<tr>	
					<td width="150px">Rasa Nyeri</td>
					<td><input type="radio" name="rasa_nyeri" value="1" 
						<?php echo ((isset($nyeri['rasa']) and $nyeri['rasa'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Ada
					 <input type="radio" name="rasa_nyeri" value="2" 
						<?php echo ((isset($nyeri['rasa']) and $nyeri['rasa'] == '2') ? 'checked' : ''); ?> 
					 />&nbsp;Tidak</td>
				</tr>
				<tr>	
					<td>Skor Nyeri</td>
					<td><input type="text" name="skor" value="<?php echo ((isset($nyeri['skor'])) ? $nyeri['skor'] : ''); ?>" class="text_dt" style="width:150px" /></td>
				</tr>
				<tr>	
					<td>Durasi Nyeri</td>
					<td><input type="text" name="durasi" value="<?php echo ((isset($nyeri['durasi'])) ? $nyeri['durasi'] : ''); ?>" class="text_dt" style="width:150px" /></td>
				</tr>
				<tr>	
					<td>Frekuensi Nyeri</td>
					<td><input type="text" name="frekuensi" value="<?php echo ((isset($nyeri['frekuensi'])) ? $nyeri['frekuensi'] : ''); ?>" class="text_dt" style="width:150px" /></td>
				</tr>
				<tr>	
					<td>Karakter Nyeri</td>
					<td><input type="checkbox" name="berdenyut" value="1" 
						<?php echo ((isset($nyeri['berdenyut']) and $nyeri['berdenyut'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Berdenyut
					 <input type="checkbox" name="ngilu" value="1" 
						<?php echo ((isset($nyeri['ngilu']) and $nyeri['ngilu'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Ngilu
					 <input type="checkbox" name="tertusuk" value="1" 
						<?php echo ((isset($nyeri['tertusuk']) and $nyeri['tertusuk'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Tertusuk
					  <input type="checkbox" name="tertekan" value="1" 
						<?php echo ((isset($nyeri['tertekan']) and $nyeri['tertekan'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Tertekan
					 <input type="checkbox" name="tajam" value="1" 
						<?php echo ((isset($nyeri['tajam']) and $nyeri['tajam'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Tajam tumpul</td>
				</tr>
				</table>
            </td>
        </tr>
		<tr>
            <td valign="top">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
		</tr>
		<tr>
            <td colspan="4">
                <table border="0" width="100%" class="tableData">
				<tr>
					<th colspan="2">Riwayat Kesehatan Umum</th>
					<th>Risiko Rendah</th>
					<th>Kecendrungan</th>
					<th>Risiko Tinggi</th>
				</tr>
				<tr>
					<td align="center">1</td>
					<td>Memiliki penyakit sistemik (<input type="checkbox" name="sistemik_hipertensi" value="1" 
						<?php echo ((isset($kesehatan_umum['sistemik_hipertensi']) and $kesehatan_umum['sistemik_hipertensi'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Hipertensi/ 
					 <input type="checkbox" name="sistemik_kardiovaskular" value="1" 
						<?php echo ((isset($kesehatan_umum['sistemik_kardiovaskular']) and $kesehatan_umum['sistemik_kardiovaskular'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Penyakit Kardiovaskular/ 
					 <input type="checkbox" name="sistemik_diabetes" value="1" 
						<?php echo ((isset($kesehatan_umum['sistemik_diabetes']) and $kesehatan_umum['sistemik_diabetes'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Diabetes/ 
					 <input type="checkbox" name="sistemik_keldarah" value="1" 
						<?php echo ((isset($kesehatan_umum['sistemik_keldarah']) and $kesehatan_umum['sistemik_keldarah'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Kelainan darah/<br/>Lainnya
					<input type="text" name="sistemik" value="<?php echo ((isset($kesehatan_umum['sistemik'])) ? $kesehatan_umum['sistemik'] : ''); ?>" class="text_dt" style="width:200px;" />)</td>
					<td><input type="radio" name="sistemik_r" value="1" 
						<?php echo ((isset($kesehatan_umum['sistemik_r']) and $kesehatan_umum['sistemik_r'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Tidak</td>
					<td>&nbsp;</td>
					<td><input type="radio" name="sistemik_r" value="2" 
						<?php echo ((isset($kesehatan_umum['sistemik_r']) and $kesehatan_umum['sistemik_r'] == '2') ? 'checked' : ''); ?> 
					 />&nbsp;Ya</td>
				</tr>
				<tr>
					<td align="center">2</td>
					<td>Berkebutuhan khusus (<input type="checkbox" name="khusus_cp" value="1" 
						<?php echo ((isset($kesehatan_umum['khusus_cp']) and $kesehatan_umum['khusus_cp'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;CP/ 
					 <input type="checkbox" name="khusus_dsindrome" value="1" 
						<?php echo ((isset($kesehatan_umum['khusus_dsindrome']) and $kesehatan_umum['khusus_dsindrome'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Down syndrom/ 
					 <input type="checkbox" name="khusus_gds" value="1" 
						<?php echo ((isset($kesehatan_umum['khusus_gds']) and $kesehatan_umum['khusus_gds'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;General development syndrom/<br/>Lainnya
					<input type="text" name="khusus" value="<?php echo ((isset($kesehatan_umum['khusus'])) ? $kesehatan_umum['khusus'] : ''); ?>" class="text_dt" style="width:200px;" />)</td>
					<td><input type="radio" name="khusus_r" value="1" 
						<?php echo ((isset($kesehatan_umum['khusus_r']) and $kesehatan_umum['khusus_r'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Tidak</td>
					<td>&nbsp;</td>
					<td><input type="radio" name="khusus_r" value="2" 
						<?php echo ((isset($kesehatan_umum['khusus_r']) and $kesehatan_umum['khusus_r'] == '2') ? 'checked' : ''); ?> 
					 />&nbsp;Ya</td>
				</tr>	
				<tr>
					<td align="center">3</td>
					<td>Penggunaan obat-obatan (<input type="checkbox" name="obat_rutin" value="1" 
						<?php echo ((isset($kesehatan_umum['obat_rutin']) and $kesehatan_umum['obat_rutin'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Rutin/ 
					 <input type="checkbox" name="obat_kemoterapi" value="1" 
						<?php echo ((isset($kesehatan_umum['obat_kemoterapi']) and $kesehatan_umum['obat_kemoterapi'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Kemoterapi/ 
					 <input type="checkbox" name="obat_radiasi" value="1" 
						<?php echo ((isset($kesehatan_umum['obat_radiasi']) and $kesehatan_umum['obat_radiasi'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Terapi radiasi/ 
					 <input type="checkbox" name="obat_medika" value="1" 
						<?php echo ((isset($kesehatan_umum['obat_medika']) and $kesehatan_umum['obat_medika'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Medikasi hypersalivary/<br/>Lainnya
					<input type="text" name="obat" value="<?php echo ((isset($kesehatan_umum['obat'])) ? $kesehatan_umum['obat'] : ''); ?>" class="text_dt" style="width:200px;" />)</td>
					<td><input type="radio" name="obat_r" value="1" 
						<?php echo ((isset($kesehatan_umum['obat_r']) and $kesehatan_umum['obat_r'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Tidak</td>
					<td>&nbsp;</td>
					<td><input type="radio" name="obat_r" value="2" 
						<?php echo ((isset($kesehatan_umum['obat_r']) and $kesehatan_umum['obat_r'] == '2') ? 'checked' : ''); ?> 
					 />&nbsp;Ya</td>
				</tr>
				<tr>
					<td align="center">4</td>
					<td>Mengkonsumsi <input type="checkbox" name="alkohol_a" value="1" 
						<?php echo ((isset($kesehatan_umum['alkohol_a']) and $kesehatan_umum['alkohol_a'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Alkohol/ 
					 <input type="checkbox" name="alkohol_merokok" value="1" 
						<?php echo ((isset($kesehatan_umum['alkohol_merokok']) and $kesehatan_umum['alkohol_merokok'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Merokok/ 
					 <input type="checkbox" name="alkohol_narkoba" value="1" 
						<?php echo ((isset($kesehatan_umum['alkohol_narkoba']) and $kesehatan_umum['alkohol_narkoba'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Narkoba/ 
					 Lainnya <input type="text" name="alkohol" value="<?php echo ((isset($kesehatan_umum['alkohol'])) ? $kesehatan_umum['alkohol'] : ''); ?>" class="text_dt" style="width:200px;" /></td>
					<td><input type="radio" name="alkohol_r" value="1" 
						<?php echo ((isset($kesehatan_umum['alkohol_r']) and $kesehatan_umum['alkohol_r'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Tidak</td>
					<td><input type="radio" name="alkohol_r" value="2" 
						<?php echo ((isset($kesehatan_umum['alkohol_r']) and $kesehatan_umum['alkohol_r'] == '2') ? 'checked' : ''); ?> 
					 />&nbsp;Ya</td>
					 <td>&nbsp;</td>
				</tr>
				<tr>
					<td align="center">5</td>
					<td>Riwayat Alergi, sebutkan <input type="text" name="alergi" value="<?php echo $alergi; ?>" class="text_dt" style="width:450px;" /></td>
					<td><input type="radio" name="alergi_r" value="1" 
						<?php echo ((isset($kesehatan_umum['alergi_r']) and $kesehatan_umum['alergi_r'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Tidak</td>
					<td><input type="radio" name="alergi_r" value="2" 
						<?php echo ((isset($kesehatan_umum['alergi_r']) and $kesehatan_umum['alergi_r'] == '2') ? 'checked' : ''); ?> 
					 />&nbsp;Ya</td>
					 <td>&nbsp;</td>
				</tr>
				<tr>
					<td align="center">6</td>
					<td>Pertimbangan Hormonal (<input type="checkbox" name="hormonal_kehamilan" value="1" 
						<?php echo ((isset($kesehatan_umum['hormonal_kehamilan']) and $kesehatan_umum['hormonal_kehamilan'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Kehamilan/ 
					 <input type="checkbox" name="hormonal_menopouse" value="1" 
						<?php echo ((isset($kesehatan_umum['hormonal_menopouse']) and $kesehatan_umum['hormonal_menopouse'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Menopause/ 
					 <input type="checkbox" name="hormonal_puberty" value="1" 
						<?php echo ((isset($kesehatan_umum['hormonal_puberty']) and $kesehatan_umum['hormonal_puberty'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Puberty/<br/>Lainnya <input type="text" name="hormonal" value="<?php echo ((isset($kesehatan_umum['hormonal'])) ? $kesehatan_umum['hormonal'] : ''); ?>" class="text_dt" style="width:200px;" />)</td>
					<td><input type="radio" name="hormonal_r" value="1" 
						<?php echo ((isset($kesehatan_umum['hormonal_r']) and $kesehatan_umum['hormonal_r'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Tidak</td>
					<td><input type="radio" name="hormonal_r" value="2" 
						<?php echo ((isset($kesehatan_umum['hormonal_r']) and $kesehatan_umum['hormonal_r'] == '2') ? 'checked' : ''); ?> 
					 />&nbsp;Ya</td>
					 <td>&nbsp;</td>
				</tr>
				<tr>
					<td align="center">7</td>
					<td>Penurunan berat badan selama 1-3 bulan terakhir</td>
					<td><input type="radio" name="berat_r" value="1" 
						<?php echo ((isset($kesehatan_umum['berat_r']) and $kesehatan_umum['berat_r'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Tidak</td>
					<td><input type="radio" name="berat_r" value="2" 
						<?php echo ((isset($kesehatan_umum['berat_r']) and $kesehatan_umum['berat_r'] == '2') ? 'checked' : ''); ?> 
					 />&nbsp;Ya</td>
					 <td>&nbsp;</td>
				</tr>
				<tr>
					<td align="center">8</td>
					<td>Asupan makan berkurang karena tidak nafsu makanan</td>
					<td><input type="radio" name="makan_r" value="1" 
						<?php echo ((isset($kesehatan_umum['makan_r']) and $kesehatan_umum['makan_r'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Tidak</td>
					<td><input type="radio" name="makan_r" value="2" 
						<?php echo ((isset($kesehatan_umum['makan_r']) and $kesehatan_umum['makan_r'] == '2') ? 'checked' : ''); ?> 
					 />&nbsp;Ya</td>
					 <td>&nbsp;</td>
				</tr>

				<tr>
					<th colspan="2">Riwayat Kesehatan Gigi & Mulut</th>
					<th>Risiko Rendah</th>
					<th>Kecendrungan</th>
					<th>Risiko Tinggi</th>
				</tr>
				<tr>
					<td align="center">1</td>
					<td>Mengkonsumsi 1-3 kali/hari makanan/minuman manis</td>
					<td><input type="radio" name="manis" value="1" 
						<?php echo ((isset($kesehatan_mulut['manis']) and $kesehatan_mulut['manis'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Tidak</td>
					<td>&nbsp;</td>
					<td><input type="radio" name="manis" value="2" 
						<?php echo ((isset($kesehatan_mulut['manis']) and $kesehatan_mulut['manis'] == '2') ? 'checked' : ''); ?> 
					 />&nbsp;Ya</td>
				</tr>
				<tr>
					<td align="center">2</td>
					<td>Mengkonsumsi makanan yang berserat dalam menu harian</td>
					<td><input type="radio" name="berserat" value="1" 
						<?php echo ((isset($kesehatan_mulut['berserat']) and $kesehatan_mulut['berserat'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Ya</td>
					<td>&nbsp;</td>
					<td><input type="radio" name="berserat" value="2" 
						<?php echo ((isset($kesehatan_mulut['berserat']) and $kesehatan_mulut['berserat'] == '2') ? 'checked' : ''); ?> 
					 />&nbsp;Tidak</td>
				</tr>
				<tr>
					<td align="center">3</td>
					<td>Menyikat gigi menggunakan pasta gigi berfluoride 2x sehari</td>
					<td><input type="radio" name="sikat" value="1" 
						<?php echo ((isset($kesehatan_mulut['sikat']) and $kesehatan_mulut['sikat'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Ya</td>
					<td>&nbsp;</td>
					<td><input type="radio" name="sikat" value="2" 
						<?php echo ((isset($kesehatan_mulut['sikat']) and $kesehatan_mulut['sikat'] == '2') ? 'checked' : ''); ?> 
					 />&nbsp;Tidak</td>
				</tr>
				<tr>
					<td align="center">4</td>
					<td>Memiliki kebiasaan buruk bruxism, menggigit kuku/ pensil, mengemut makanan, mengunyah  satu sisi rahang</td>
					<td><input type="radio" name="buruk" value="1" 
						<?php echo ((isset($kesehatan_mulut['buruk']) and $kesehatan_mulut['buruk'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Tidak</td>
					<td>&nbsp;</td>
					<td><input type="radio" name="buruk" value="2" 
						<?php echo ((isset($kesehatan_mulut['buruk']) and $kesehatan_mulut['buruk'] == '2') ? 'checked' : ''); ?> 
					 />&nbsp;Ya</td>
				</tr>
				<tr>
					<td align="center">5</td>
					<td>Melakukan pemeriksaan kesehatan gigi dan mulut</td>
					<td><input type="radio" name="periksa" value="1" 
						<?php echo ((isset($kesehatan_mulut['periksa']) and $kesehatan_mulut['periksa'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;< 6 bulan</td>
					<td><input type="radio" name="periksa" value="2" 
						<?php echo ((isset($kesehatan_mulut['periksa']) and $kesehatan_mulut['periksa'] == '2') ? 'checked' : ''); ?> 
					 />&nbsp;1 tahun lalu</td>
					<td><input type="radio" name="periksa" value="3" 
						<?php echo ((isset($kesehatan_mulut['periksa']) and $kesehatan_mulut['periksa'] == '3') ? 'checked' : ''); ?> 
					 />&nbsp;> 1 tahun</td>
				</tr>
				<tr>
					<td colspan="2"><strong>Hasil Pengkajian risiko terhadap karies</strong></td>
					<td><input type="radio" name="risiko" value="1" 
						<?php echo ((isset($kesehatan_mulut['risiko']) and $kesehatan_mulut['risiko'] == '1') ? 'checked' : ''); ?> 
					 />&nbsp;Rendah</td>
					<td><input type="radio" name="risiko" value="2" 
						<?php echo ((isset($kesehatan_mulut['risiko']) and $kesehatan_mulut['risiko'] == '2') ? 'checked' : ''); ?> 
					 />&nbsp;Cenderung</td>
					<td><input type="radio" name="risiko" value="3" 
						<?php echo ((isset($kesehatan_mulut['risiko']) and $kesehatan_mulut['risiko'] == '3') ? 'checked' : ''); ?> 
					 />&nbsp;Tinggi</td>
				</tr>
				</table>
            </td>
        </tr>		
		<tr>
            <td valign="top">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
        </tr>
		<tr>
            <td valign="top">Diagnosa</td>
            <td colspan="3">
				<table border="0">
				<tr>	
					<td><input type="checkbox" name="diag_1" value="1" <?php echo ((isset($diagnosa['diag_1']) and $diagnosa['diag_1'] == '1') ? 'checked' : ''); ?> /></td>
					<td>Tidak terpenuhinya kebutuhan akan kesan wajah yang sehat</td>
				</tr>
				<tr>	
					<td><input type="checkbox" name="diag_2" value="1" <?php echo ((isset($diagnosa['diag_2']) and $diagnosa['diag_2'] == '1') ? 'checked' : ''); ?> /></td>
					<td>Tidak terpenuhinya kebutuhan akan bebas dari kecemasan/ stress</td>
				</tr>
				<tr>	
					<td><input type="checkbox" name="diag_3" value="1" <?php echo ((isset($diagnosa['diag_3']) and $diagnosa['diag_3'] == '1') ? 'checked' : ''); ?> /></td>
					<td>Tidak terpenuhinya integritas (keutuhan) jaringan kulit, mukosa dan membrane pada leher dan kepala</td>
				</tr>
				<tr>	
					<td><input type="checkbox" name="diag_4" value="1" <?php echo ((isset($diagnosa['diag_4']) and $diagnosa['diag_4'] == '1') ? 'checked' : ''); ?> /></td>
					<td>Tidak terpenuhinya kebutuhan akan perlindungan dari resiko penyakit gigi dan mulut</td>
				</tr>
				<tr>	
					<td><input type="checkbox" name="diag_5" value="1" <?php echo ((isset($diagnosa['diag_5']) and $diagnosa['diag_5'] == '1') ? 'checked' : ''); ?> /></td>
					<td>Tidak terpenuhinya kebutuhan akan bebas dari rasa nyeri pada leher dan kepala</td>
				</tr>
				<tr>	
					<td><input type="checkbox" name="diag_6" value="1" <?php echo ((isset($diagnosa['diag_6']) and $diagnosa['diag_6'] == '1') ? 'checked' : ''); ?> /></td>
					<td>Tidak terpenuhinya kondisi biologis gigi geligi yang baik</td>
				</tr>
				<tr>	
					<td><input type="checkbox" name="diag_7" value="1" <?php echo ((isset($diagnosa['diag_7']) and $diagnosa['diag_7'] == '1') ? 'checked' : ''); ?> /></td>
					<td>Tidak terpenuhinya kebutuhan untuk bertanggungjawab kesehatan gigi dan mulutnya sendiri</td>
				</tr>
				<tr>	
					<td><input type="checkbox" name="diag_8" value="1" <?php echo ((isset($diagnosa['diag_8']) and $diagnosa['diag_8'] == '1') ? 'checked' : ''); ?> /></td>
					<td>Tidak terpenuhinya kebutuhan pengetahuan/pemahaman yang baik tentang kesehatan gigi dan mulut</td>
				</tr>
				</table>
            </td>
        </tr>
		<tr>
            <td valign="top">Implementasi</td>
            <td colspan="3">
				<table border="0">
				<tr>	
					<td colspan="2">Kolaborasi :</td>
				</tr>
				<tr>	
					<td><input type="checkbox" name="impl_1" value="1" <?php echo ((isset($implementasi['impl_1']) and $implementasi['impl_1'] == '1') ? 'checked' : ''); ?> /></td>
					<td>Medik Dasar</td>
				</tr>
				<tr>	
					<td><input type="checkbox" name="impl_2" value="1" <?php echo ((isset($implementasi['impl_2']) and $implementasi['impl_2'] == '1') ? 'checked' : ''); ?> /></td>
					<td>Medik Spesialistik</td>
				</tr>
				<tr>	
					<td colspan="2">Mandiri :</td>
				</tr>
				<tr>	
					<td><input type="checkbox" name="impl_3" value="1" <?php echo ((isset($implementasi['impl_3']) and $implementasi['impl_3'] == '1') ? 'checked' : ''); ?> /></td>
					<td>Konseling Kesehatan Gigi dan Mulut :</td>
				</tr>
				<tr>	
					<td><input type="checkbox" name="impl_4" value="1" <?php echo ((isset($implementasi['impl_4']) and $implementasi['impl_4'] == '1') ? 'checked' : ''); ?> /></td>
					<td>Penkes higiene rongga mulut</td>
				</tr>
				<tr>	
					<td><input type="checkbox" name="impl_5" value="1" <?php echo ((isset($implementasi['impl_5']) and $implementasi['impl_5'] == '1') ? 'checked' : ''); ?> /></td>
					<td>Penkes selama perawatan gigi dan mulut</td>
				</tr>
				<tr>	
					<td><input type="checkbox" name="impl_6" value="1" <?php echo ((isset($implementasi['impl_6']) and $implementasi['impl_6'] == '1') ? 'checked' : ''); ?> /></td>
					<td>Penkes diet dan nutrisi</td>
				</tr>
				<tr>	
					<td><input type="checkbox" name="impl_7" value="1" <?php echo ((isset($implementasi['impl_7']) and $implementasi['impl_7'] == '1') ? 'checked' : ''); ?> /></td>
					<td>Penkes pra dan paska operasi </td>
				</tr>
				</table>
            </td>
        </tr>
		<tr>
            <td valign="top">Evaluasi</td>
            <td colspan="3">
				<table border="0">
				<tr>	
					<td><input type="checkbox" name="eval_1" value="1" <?php echo ((isset($evaluasi['eval_1']) and $evaluasi['eval_1'] == '1') ? 'checked' : ''); ?> /></td>
					<td>Terbebas dari gangguan rasa nyeri</td>
				</tr>
				<tr>	
					<td><input type="checkbox" name="eval_2" value="1" <?php echo ((isset($evaluasi['eval_2']) and $evaluasi['eval_2'] == '1') ? 'checked' : ''); ?> /></td>
					<td>Didapati kembali bentuk anatomi dan fungsi gigi geligi</td>
				</tr>
				<tr>	
					<td><input type="checkbox" name="eval_3" value="1" <?php echo ((isset($evaluasi['eval_3']) and $evaluasi['eval_3'] == '1') ? 'checked' : ''); ?> /></td>
					<td>Terlihat perubahan perilaku kesehatan gigi dan mulutnya</td>
				</tr>
				<tr>	
					<td><input type="checkbox" name="eval_4" value="1" <?php echo ((isset($evaluasi['eval_4']) and $evaluasi['eval_4'] == '1') ? 'checked' : ''); ?> /></td>
					<td>OH Indeks</td>
				</tr>
				<tr>	
					<td><input type="checkbox" name="eval_5" value="1" <?php echo ((isset($evaluasi['eval_5']) and $evaluasi['eval_5'] == '1') ? 'checked' : ''); ?> /></td>
					<td>Luka paska pencabutan/operasi</td>
				</tr>
				</table>
            </td>
        </tr>
        <tr><td colspan="4" align="right">
			<?php if(isPerawat($_SESSION['SES_SIMRS_TIPE_PEGAWAI']) and $irja_final == ''){ ?>
			<input type="checkbox" name="selesai" id="selesai" value="1" <?php if($selesai == '1') echo 'checked="checked"'; ?> />&nbsp;Final&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" name="simpan" value="simpan" class="myButton1" onclick="simpan_askep();" />
		    <?php if(!empty($idx)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "1"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idx . '"
						AND JENIS_DOKUMEN_ID = "30"
						ORDER BY FILE_ID DESC LIMIT 1';
				$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
				$dat_view_rm = mysql_fetch_assoc($get_view_rm);
			?>
				<input type="button" value="lihat" class="myButton1" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" />
			<?php } } ?>
			<?php if($irja_final == '' and isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI']) and $idx_askep != ''){ ?>
				<input type="button" name="copi" value="copy ke PAM" class="myButton1" onclick="copykePAM(<?php echo $irja_id; ?>,<?php echo $_SESSION['SES_SIMRS_UNIT_ID']; ?>);" />
			<?php } ?>
		   </td>
        </tr>
    </table>
</form>
<script language="javascript" type="text/javascript">
<?php if(!isPerawat($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
$(':input').attr('readonly','readonly');
<?php } ?>
function simpan_askep(){
	_haschange = false;
	if($('#idx_askep').val() != ''){
		if($('#ls_final').val() == '1'){
			if($('#ls_assesment').val() != $('#tgl_skr').val()){
				if(confirm('Revisi ?')){
					$('#formrujukan').submit();
				}	
			}else{
				$('#formrujukan').submit();
			}	
		}else{
			if($("#selesai").is(':checked')){
				if(confirm('Final ?')){
					$('#formrujukan').submit();
				}
			}else{
				$('#formrujukan').submit();
			}
		}
	}else{
		if($("#selesai").is(':checked')){
			if(confirm('Final ?')){
				$('#formrujukan').submit();
			}
		}else{
			$('#formrujukan').submit();
		}	
	}
}

function copykePAM(irja_id,unit){
	$.ajax({
		type: 'POST',
		url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=copyaskepkepam&irja_id=' + irja_id + '&unit=' + unit,
		data: { idx : 'idx'},
		cache: false,
		success: function(data) {
			alert(data);		
		}
	});
}
</script>