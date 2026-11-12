<?php 
if (isset($_POST['irna_id']) and $pam == '3'){
	mysql_query('UPDATE t_irna SET PAM = "3" WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());

	$st_save = true;
	if($st_save){
		$st_final = 'NULL';
		if(isset($_POST['final'])) $st_final = '"1"';

		$riwayat_hamil = array('riwayat'=>replace_quote($_POST['riwayat_hamil']),
						'anc'=>replace_quote($_POST['anc']),
						'natal_care'=>replace_quote($_POST['natal_care']),
						'periode_neonatal'=>replace_quote($_POST['periode_natal']));
		$riwayat_hamil = json_encode($riwayat_hamil);
		$riwayat_hamil = str_replace('"','|',$riwayat_hamil);

		$perkembangan_kepandaian = array('motorik_kasar'=>replace_quote($_POST['motorik_kasar']),
								'motorik_halus'=>replace_quote($_POST['motorik_halus']),
								'bicara'=>replace_quote($_POST['bicara']),
								'sosial'=>replace_quote($_POST['sosial']));
		$perkembangan_kepandaian = json_encode($perkembangan_kepandaian);
		$perkembangan_kepandaian = str_replace('"','|',$perkembangan_kepandaian);

		$vaksinasi = array('vaksinasi'=>replace_quote($_POST['vaksinasi']),
					'bcg'=>replace_quote($_POST['bcg']),
					'hepatitis_b'=>replace_quote($_POST['hepatitis_b']),
					'dpt'=>replace_quote($_POST['dpt']),
					'polio'=>replace_quote($_POST['polio']),
					'campak'=>replace_quote($_POST['campak']),
					'hib'=>replace_quote($_POST['hib']),
					'ipd'=>replace_quote($_POST['ipd']),
					'influenza'=>replace_quote($_POST['influenza']),
					'cacar_air'=>replace_quote($_POST['cacar_air']),
					'mmr'=>replace_quote($_POST['mmr']));
		$vaksinasi = json_encode($vaksinasi);
		$vaksinasi = str_replace('"','|',$vaksinasi);

		$nadi = array('irama_nadi'=>replace_quote($_POST['irama_nadi']),
				'nadi'=>replace_quote($_POST['nadi']),
				'tegangan_nadi'=>replace_quote($_POST['tegangan_nadi']));
		$nadi = json_encode($nadi);
		$nadi = str_replace('"','|',$nadi);

		$suhu_badan = array('suhu_badan'=>replace_quote($_POST['suhu_badan']),
					'tekanan_darah'=>replace_quote($_POST['tekanan_darah']));
		$suhu_badan = json_encode($suhu_badan);
		$suhu_badan = str_replace('"','|',$suhu_badan);

		$pernapasan = array('pernapasan'=>replace_quote($_POST['pernapasan']),
					'tipe_pernapasan'=>replace_quote($_POST['tipe_pernapasan']));
		$pernapasan = json_encode($pernapasan);
		$pernapasan = str_replace('"','|',$pernapasan);

		$berat_badan = array('berat_b'=>replace_quote($_POST['berat_b']),
					'tinggi_b'=>replace_quote($_POST['tinggi_b']),
					'lingkar_kepala'=>replace_quote($_POST['lingkar_kepala']));
		$berat_badan = json_encode($berat_badan);
		$berat_badan = str_replace('"','|',$berat_badan);

		$ubun = array('uub'=>replace_quote($_POST['uub']),
			'lla'=>replace_quote($_POST['lla']));
		$ubun = json_encode($ubun);
		$ubun = str_replace('"','|',$ubun);

	
		if(empty($_POST['idx'])){				
			mysql_query('INSERT INTO t_irna_pengkajian_awal_medis_anak (IRNA_ID,NAMA_AYAH,NAMA_IBU,PEKERJAAN_AYAH,PEKERJAAN_IBU,PENDIDIKAN_AYAH,PENDIDIKAN_IBU,
			UMUR_AYAH,UMUR_IBU,ALAMAT,KELUHAN_UTAMA,RIWAYAT_PENY_SKRG,RIWAYAT_PENY_DAHULU,RIWAYAT_PENY_KELUARGA,RIWAYAT_PRIBADI,RIWAYAT_KEHAMILAN_KELAHIRAN,
			RIWAYAT_MAKANAN,PERKEMBANGAN_KEPANDAIAN,VAKSINASI,TANDA_UTAMA,NADI,SUHU_BADAN,PERNAPASAN,BERAT_BADAN,UBUN_BESAR,KESIMPULAN_GIZI,KELENJAR_LIMPA,
			LEHER,DADA,JANTUNG,PARU_PARU,PERUT,HATI,LIMPA_ANOGENITAL,EKTERMITAS,
			GERAKAN,TONUS,TROFI,CLONUS,REFLEKS_FISILOGIS,REFLEKS_PATOLOGIS,KEPALA,
			MATA,HIDUNG,TELINGA,MULUT,PHARING,GIGI,PEMERIKSAAN_LAB,PEMERIKSAAN_RAD,
			RENCANA_TATALAKSANA,FINAL,REGISTER,TGL_ASSESMENT,PEGAWAI_ID) 
			VALUES ("' . $_POST['irna_id'] . '","' . $_POST['nama_ayah'] . '","' . $_POST['nama_ibu'] . '","' . $_POST['pekerjaan_ayah'] . '","' . $_POST['pekerjaan_ibu'] . '","' . $_POST['pendidikan_ayah'] . '","' . $_POST['pendidikan_ibu'] . '",
			"' . $_POST['umur_ayah'] . '","' . $_POST['umur_ibu'] . '","' . $_POST['alamat'] . '","' . $_POST['keluhan_utama'] . '","' . $_POST['riwayat_skrg'] . '","' . $_POST['riwayat_dahulu'] . '","' . $_POST['riwayat_klrg'] . '",
			"' . $_POST['riwayat_pribadi'] . '","' . $riwayat_hamil . '","' . $_POST['riwayat_makan'] . '","' . $perkembangan_kepandaian . '","' . $vaksinasi . '","' . $_POST['tanda_utama'] . '","' . $nadi. '",
			"' . $suhu_badan . '","' . $pernapasan . '","' . $berat_badan . '","' . $ubun. '","' . $_POST['status_gizi'] . '","' . $_POST['kelenjar_limpa'] . '",
			"' . $_POST['leher'] . '","' . $_POST['dada'] . '","' . $_POST['jantung'] . '","' . $_POST['paru'] . '","' . $_POST['perut'] . '","' . $_POST['hati'] . '","' . $_POST['limpa'] . '","' . $_POST['ektermitas'] . '",
			"' . $_POST['gerakan'] . '","' . $_POST['tonus'] . '","' . $_POST['trofi'] . '","' . $_POST['clonus'] . '","' . $_POST['ref_fisilogis'] . '","' . $_POST['ref_patologis'] . '","' . $_POST['kepala'] . '",
			"' . $_POST['mata'] . '","' . $_POST['hidung'] . '","' . $_POST['telinga'] . '","' . $_POST['mulut'] . '","' . $_POST['pharing'] . '","' . $_POST['gigi'] . '","' . $_POST['periksa_lab'] . '","' . $_POST['periksa_rad'] . '",
			"' . $_POST['renc_tatalaksana'] . '",' . $st_final . ',"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",NOW(),"' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irna_pengkajian_awal_medis_anak 
				SET NAMA_AYAH = "' . $_POST['nama_ayah'] . '",
				NAMA_IBU = "' . $_POST['nama_ibu'] . '",
				PEKERJAAN_AYAH = "' . $_POST['pekerjaan_ayah'] . '",
				PEKERJAAN_IBU = "' . $_POST['pekerjaan_ibu'] . '",
				PENDIDIKAN_AYAH = "' . $_POST['pendidikan_ayah'] . '",
				PENDIDIKAN_IBU = "' . $_POST['pendidikan_ibu'] . '",
				UMUR_AYAH = "' . $_POST['umur_ayah'] . '",
				UMUR_IBU = "' . $_POST['umur_ibu'] . '",
				ALAMAT = "' . $_POST['alamat'] . '",
				KELUHAN_UTAMA = "' . $_POST['keluhan_utama'] . '",
				RIWAYAT_PENY_SKRG = "' . $_POST['riwayat_skrg'] . '",
				RIWAYAT_PENY_DAHULU = "' . $_POST['riwayat_dahulu'] . '",
				RIWAYAT_PENY_KELUARGA = "' . $_POST['riwayat_klrg'] . '",
				RIWAYAT_PRIBADI = "' . $_POST['riwayat_pribadi'] . '",
				RIWAYAT_KEHAMILAN_KELAHIRAN = "' . $riwayat_hamil . '",
				RIWAYAT_MAKANAN = "' . $_POST['riwayat_makan'] . '",
				PERKEMBANGAN_KEPANDAIAN ="' . $perkembangan_kepandaian . '",
				VAKSINASI = "' . $vaksinasi . '",
				TANDA_UTAMA = "' . $_POST['tanda_utama'] . '",
				NADI ="' . $nadi . '",
				SUHU_BADAN = "' . $suhu_badan . '",
				PERNAPASAN = "' . $pernapasan . '",
				UBUN_BESAR = "' . $ubun . '",
				KESIMPULAN_GIZI = "' . $_POST['status_gizi'] . '",
				KELENJAR_LIMPA = "' . $_POST['kelenjar_limpa'] . '",
				LEHER = "' . $_POST['leher'] . '",
				DADA = "' . $_POST['dada'] . '",
				JANTUNG = "' . $_POST['jantung'] . '",
				PARU_PARU = "' . $_POST['paru'] . '",
				PERUT = "' . $_POST['perut'] . '",
				HATI = "' . $_POST['hati'] . '",
				LIMPA_ANOGENITAL = "' . $_POST['limpa'] . '",
				EKTERMITAS = "' . $_POST['ektermitas'] . '",
				GERAKAN = "' . $_POST['gerakan'] . '",
				TONUS = "' . $_POST['tonus'] . '",
				TROFI = "' . $_POST['trofi'] . '",
				CLONUS = "' . $_POST['clonus'] . '",
				REFLEKS_FISILOGIS = "' . $_POST['ref_fisilogis'] . '",
				REFLEKS_PATOLOGIS = "' . $_POST['ref_patologis'] . '",
				KEPALA = "' . $_POST['kepala'] . '",
				MATA = "' . $_POST['mata'] . '",
				HIDUNG = "' . $_POST['hidung'] . '",
				TELINGA = "' . $_POST['telinga'] . '",
				MULUT = "' . $_POST['mulut'] . '",
				PHARING = "' . $_POST['pharing'] . '",
				GIGI = "' . $_POST['gigi'] . '",
				PEMERIKSAAN_LAB = "' . $_POST['periksa_lab'] . '",
				PEMERIKSAAN_RAD = "' . $_POST['periksa_rad'] . '",
				RENCANA_TATALAKSANA = "' . $_POST['renc_tatalaksana'] . '",
				FINAL = ' . $st_final . ',
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				TGL_ASSESMENT = NOW(),
				PEGAWAI_ID = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '",
				ST_CREATE_ERM = NULL
				WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
		}

		mysql_query('DELETE FROM t_irna_diagnosa WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
		$d=0;
		while($d <= 3){
			if(!empty($_POST['diagnosaanak_'. $d])){
				$diagnosa = replace_quote($_POST['diagnosaanak_'. $d]);
				mysql_query('INSERT INTO t_irna_diagnosa (IRNA_ID,DIAGNOSA_ORDER,DIAGNOSA) 
					VALUES("' . $_POST['irna_id'] . '","' . $d . '","' . $diagnosa . '")') or die(mysql_error());
			}
		$d++;
		}

		mysql_query('UPDATE t_irna SET ST_CREATE_ERM_PAM = NULL WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
	
		/*
		include('lib/vendor/autoload.php');
		include('lib/html2openxml/HTMLtoOpenXML.php');
		include('edoc_rekammedik/new/erm_create_pengkajian_awal_kebidanan_d_kandungan.php');
		erm_pengkajian_awal_kebidanan_d_kandungan($_POST['irja_id'],$_POST['ls_assesment'],$_POST['tgl_skr'],$_POST['ls_final']);
		*/
		?>
		<script language="JavaScript" >
			alert('Simpan Pengkajian Awal Medis Anak berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 
	}else{
		$msg_info = 'Harus Oleh Dokter DPJP';
	}	
}

$qry_pasien = 'SELECT IRNA_ID,NAMA_AYAH,NAMA_IBU,PEKERJAAN_AYAH,PEKERJAAN_IBU,PENDIDIKAN_AYAH,PENDIDIKAN_IBU,
			UMUR_AYAH,UMUR_IBU,ALAMAT,KELUHAN_UTAMA,RIWAYAT_PENY_SKRG,RIWAYAT_PENY_DAHULU,RIWAYAT_PENY_KELUARGA,RIWAYAT_PRIBADI,RIWAYAT_KEHAMILAN_KELAHIRAN,
			RIWAYAT_MAKANAN,PERKEMBANGAN_KEPANDAIAN,VAKSINASI,TANDA_UTAMA,NADI,SUHU_BADAN,PERNAPASAN,BERAT_BADAN,UBUN_BESAR,KESIMPULAN_GIZI,KELENJAR_LIMPA,
			LEHER,DADA,JANTUNG,PARU_PARU,PERUT,HATI,LIMPA_ANOGENITAL,EKTERMITAS,
			GERAKAN,TONUS,TROFI,CLONUS,REFLEKS_FISILOGIS,REFLEKS_PATOLOGIS,KEPALA,
			MATA,HIDUNG,TELINGA,MULUT,PHARING,GIGI,PEMERIKSAAN_LAB,PEMERIKSAAN_RAD,
			RENCANA_TATALAKSANA,FINAL,REGISTER,DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT,
			PEGAWAI_ID,DATE_FORMAT(NOW(),"%d/%m/%Y") AS TGL_SKR,DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS REGISTER_DT
			FROM t_irna_pengkajian_awal_medis_anak
			WHERE IRNA_ID = "' . $idx . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx_pam = $dat_pasien['IRNA_ID'];
//$idx_askep = $dat_pasien['IRNA_ID'];

$nama_ayah = $dat_pasien['NAMA_AYAH'];
$nama_ibu = $dat_pasien['NAMA_IBU'];
$pekerjaan_ayah = $dat_pasien['PEKERJAAN_AYAH'];
$pekerjaan_ibu = $dat_pasien['PEKERJAAN_IBU'];
$pendidikan_ayah = $dat_pasien['PENDIDIKAN_AYAH'];
$pendidikan_ibu = $dat_pasien['PENDIDIKAN_IBU'];
$umur_ayah = $dat_pasien['UMUR_AYAH'];
$umur_ibu = $dat_pasien['UMUR_IBU'];
$alamat = $dat_pasien['ALAMAT'];
$keluhan_utama = $dat_pasien['KELUHAN_UTAMA'];
$riwayat_skrg = $dat_pasien['RIWAYAT_PENY_SKRG'];
$riwayat_dahulu = $dat_pasien['RIWAYAT_PENY_DAHULU'];
$riwayat_klrg = $dat_pasien['RIWAYAT_PENY_KELUARGA'];
$riwayat_pribadi = $dat_pasien['RIWAYAT_PRIBADI'];

$riwayat_hamil = str_replace('|','"',$dat_pasien['RIWAYAT_KEHAMILAN_KELAHIRAN']);
$riwayat_hamil = preg_replace('/\r|\n/','\n',trim($riwayat_hamil));
$riwayat_hamil = json_decode($riwayat_hamil,true);

$riwayat_makan = $dat_pasien['RIWAYAT_MAKANAN'];

$perkembangan_kepandaian = str_replace('|','"',$dat_pasien['PERKEMBANGAN_KEPANDAIAN']);
$perkembangan_kepandaian = preg_replace('/\r|\n/','\n',trim($perkembangan_kepandaian));
$perkembangan_kepandaian = json_decode($perkembangan_kepandaian,true);

$vaksinasi = str_replace('|','"',$dat_pasien['VAKSINASI']);
$vaksinasi = preg_replace('/\r|\n/','\n',trim($vaksinasi));
$vaksinasi = json_decode($vaksinasi,true);

$tanda_utama = $dat_pasien['TANDA_UTAMA'];

$nadi = str_replace('|','"',$dat_pasien['NADI']);
$nadi = preg_replace('/\r|\n/','\n',trim($nadi));
$nadi = json_decode($nadi,true);

$suhu_badan = str_replace('|','"',$dat_pasien['SUHU_BADAN']);
$suhu_badan = preg_replace('/\r|\n/','\n',trim($suhu_badan));
$suhu_badan = json_decode($suhu_badan,true);

$pernapasan = str_replace('|','"',$dat_pasien['PERNAPASAN']);
$pernapasan = preg_replace('/\r|\n/','\n',trim($pernapasan));
$pernapasan = json_decode($pernapasan,true);

$berat_badan = str_replace('|','"',$dat_pasien['BERAT_BADAN']);
$berat_badan = preg_replace('/\r|\n/','\n',trim($berat_badan));
$berat_badan = json_decode($berat_badan,true);

$ubun = str_replace('|','"',$dat_pasien['UBUN_BESAR']);
$ubun = preg_replace('/\r|\n/','\n',trim($ubun));
$ubun = json_decode($ubun,true);

$status_gizi = $dat_pasien['KESIMPULAN_GIZI'];
$kelenjar_limpa = $dat_pasien['KELENJAR_LIMPA'];
$leher = $dat_pasien['LEHER'];
$dada = $dat_pasien['DADA'];
$jantung = $dat_pasien['JANTUNG'];
$paru = $dat_pasien['PARU_PARU'];
$perut = $dat_pasien['PERUT'];
$hati = $dat_pasien['HATI'];
$limpa_anog = $dat_pasien['LIMPA_ANOGENITAL'];
$ektermitas = $dat_pasien['EKTERMITAS'];
$gerakan = $dat_pasien['GERAKAN'];
$tonus = $dat_pasien['TONUS'];
$trofi = $dat_pasien['TROFI'];
$clonus = $dat_pasien['CLONUS'];
$refleks_fis = $dat_pasien['REFLEKS_FISILOGIS'];
$refleks_pat = $dat_pasien['REFLEKS_PATOLOGIS'];
$kepala = $dat_pasien['KEPALA'];
$mata = $dat_pasien['MATA'];
$hidung = $dat_pasien['HIDUNG'];
$telinga = $dat_pasien['TELINGA'];
$mulut = $dat_pasien['MULUT'];
$pharing = $dat_pasien['PHARING'];
$gigi = $dat_pasien['GIGI'];
$periksa_lab = $dat_pasien['PEMERIKSAAN_LAB'];
$periksa_rad = $dat_pasien['PEMERIKSAAN_RAD'];
$renc_tatalaksana = $dat_pasien['RENCANA_TATALAKSANA'];
$final = $dat_pasien['FINAL'];
$register = $dat_pasien['REGISTER'] . ' ' . $dat_pasien['REGISTER_DT'];
$tgl_assesment = $dat_pasien['TGL_ASSESMENT'];
$pegawai_id = $dat_pasien['PEGAWAI_ID'];
$tgl_skr = $dat_pasien['TGL_SKR'];

$qry_diagnosa = 'SELECT DIAGNOSA_ORDER,DIAGNOSA
		FROM t_irna_diagnosa
		WHERE IRNA_ID = "' . $idx . '"
		ORDER BY DIAGNOSA_ORDER';
$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
$d=0;
$diagnosa = array();
while($dat_diagnosa= mysql_fetch_array($get_diagnosa)){
	$diagnosa[$dat_diagnosa['DIAGNOSA_ORDER']]=$dat_diagnosa['DIAGNOSA'];
$d++;
}

?>

<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#diagnosaanak_0").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosaanak_1").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosaanak_2").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
		jQuery("#diagnosaanak_3").autocomplete("index.php?autocomp=autocompklinikdiagnosa",{width: 760});
    });
</script>

<form name="formperiksa_37" id="formperiksa_37" method="post" action="http://<?php echo $_SERVER['SERVER_NAME']; ?>/nsimrs/index.php?link=74ac04efa30ba0f5fb861758cbad5b3a&smn=kjam&idx=<?php echo $idx; ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx_pam; ?>" />	
	<input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />	
	<input type="hidden" name="ls_assesment" id="ls_assesment" value="<?php echo $tgl_assesment; ?>" />	
	<input type="hidden" name="ls_final" id="ls_final" value="<?php echo $final; ?>" />	
	<input type="hidden" name="tgl_skr" id="tgl_skr" value="<?php echo $tgl_skr; ?>" />
	<input type="hidden" name="pam" id="pam" value="3" />	
	<table border="0" align="center" style="position:static; " width="90%">
		<tr>
			<td valign="top" colspan="2">Nama Ayah</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5">
				<input type="text" name="nama_ayah" id="nama_ayah" value="<?php echo $nama_ayah; ?>" class="text_dt" style="width:228px;"></td>
			</tr>
		<tr>
			<td valign="top" colspan="2">Pekerjaan</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" value="<?php echo $pekerjaan_ayah; ?>" class="text_dt" style="width:228px;"></td>	
		</tr>
		<tr>
			<td valign="top" colspan="2">Pendidikan</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="text" name="pendidikan_ayah" id="pendidikan_ayah" value="<?php echo $pendidikan_ayah; ?>" class="text_dt" style="width:228px;"></td>	
		</tr>
		<tr>
			<td valign="top" colspan="2">Umur</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="text" name="umur_ayah" id="umur_ayah" value="<?php echo $umur_ayah; ?>" class="text_dt" style="width:228px;"></td>	
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Nama Ibu</td>
			<td valign="top" width="10px">:</td>
			<td colspan="4"><input type="text" name="nama_ibu" id="nama_ibu" value="<?php echo $nama_ibu; ?>" class="text_dt" style="width:228px;"></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Pekerjaan</td>
			<td valign="top" width="10px">:</td>
			<td colspan="4"><input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" value="<?php echo $pekerjaan_ibu; ?>" class="text_dt" style="width:228px;"></td>
		
		</tr>
		<tr>
		<td valign="top" colspan="2">Pendidikan</td>
			<td valign="top" width="10px">:</td>
			<td colspan="4"><input type="text" name="pendidikan_ibu" id="pendidikan_ibu" value="<?php echo $pendidikan_ibu; ?>" class="text_dt" style="width:228px;"></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Umur</td>
			<td valign="top" width="10px">:</td>
			<td colspan="4"><input type="text" name="umur_ibu" id="umur_ibu" value="<?php echo $umur_ibu; ?>" class="text_dt" style="width:228px;"></td>	
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Alamat</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="alamat" id="alamat" class="text_dt10"><?php echo $alamat; ?></textarea></td>
		</tr>
	<!--	<tr>
			<td colspan="18">&nbsp;</td>
		</tr>
		<tr>
			<td valign="top" colspan="2"><b>Dokter yang merawat</td>
			<td valign="top" width="10px">:</td>
			<td colspan="10"><input type="text" name="dokter_rawat" id="dokter_rawat" value="" class="text_dt" style="width:228px;"></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Tgl Masuk</td>
			<td valign="top" width="10px">:</td>
			<td colspan="2"><input type="text" name="tgl_masuk" id="tgl_3" class="text_dt" size="10" value="" readonly="readonly" onblur="false_kan();" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar11')"/> </td>
			<td valign="top">Pukul</td>
			<td valign="top" width="10px">:</td>
			<td><input type="text" name="jam_masuk" id="jam_masuk" value="" class="text_dt" style="width:100px;"></td>
			
			<td valign="top">Tgl Assesment</td>
			<td valign="top" width="10px">:</td>
			<td><input type="text" name="tgl_assesment" id="tgl_3" class="text_dt" size="10" value="" readonly="readonly" onblur="false_kan();" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar11')"/> </td>
			<td valign="top">Pukul</td>
			<td valign="top" width="10px">:</td>
			<td><input type="text" name="jam_masuk" id="jam_masuk" value="" class="text_dt" style="width:100px;"></td>
		</tr>
-->		<tr>
			<td colspan="18">&nbsp;</td>
		</tr>
		<tr>
			<td valign="top"><b>I.</td>
			<td valign="top" colspan="18"><b>ANAMNESIS</td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Keluhan Utama</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="keluhan_utama" id="keluhan_utama" class="text_dt10"><?php echo $keluhan_utama; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Riwayat Penyakit Sekarang</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="riwayat_skrg" id="riwayat_skrg" class="text_dt10"><?php echo $riwayat_skrg; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Riwayat Penyakit Dahulu</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="riwayat_dahulu" id="riwayat_dahulu" class="text_dt10"><?php echo $riwayat_dahulu; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Riwayat Penyakit Keluarga</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="riwayat_klrg" id="riwayat_klrg" class="text_dt10"><?php echo $riwayat_klrg; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Riwayat Pribadi</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="riwayat_pribadi" id="riwayat_pribadi" class="text_dt10"><?php echo $riwayat_pribadi; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top">1.</td>
			<td valign="top">Riwayat Kehamilan dan Kelahiran</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="riwayat_hamil" id="riwayat_hamil" class="text_dt10"><?php echo ((isset($riwayat_hamil['riwayat'])) ? $riwayat_hamil['riwayat'] : ''); ?></textarea></td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
			<td valign="top">ANC</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><input type="text" name="anc" id="anc" value="<?php echo ((isset($riwayat_hamil['anc'])) ? $riwayat_hamil['anc'] : ''); ?>" class="text_dt" style="width:565px;"></td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
			<td valign="top">Natal Care</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><input type="text" name="natal_care" id="natal_care" value="<?php echo ((isset($riwayat_hamil['natal_care'])) ? $riwayat_hamil['natal_care'] : ''); ?>" class="text_dt" style="width:565px;"></td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
			<td valign="top">Periode Neonatal</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><input type="text" name="periode_natal" id="periode_natal" value="<?php echo ((isset($riwayat_hamil['periode_natal'])) ? $riwayat_hamil['periode_natal'] : ''); ?>" class="text_dt" style="width:565px;"></td>
		</tr>
		<tr>
			<td valign="top">2.</td>
			<td valign="top">Riwayat Makanan  ( sejak lahir sampai sekaraang, kualitas dan kuantitas )</td>
			<td valign="top" width="10px">:</td>
			<td colspan="8"><textarea name="riwayat_makan" id="riwayat_makan" class="text_dt10"><?php echo $riwayat_makan; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top">3.</td>
			<td valign="top">Perkembangan dan Kepandaian</td>
			<td valign="top" width="10px">:</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
			<td valign="top">Motorik Kasar</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><input type="text" name="motorik_kasar" id="motorik_kasar" value="<?php echo ((isset($perkembangan_kepandaian['motorik_kasar'])) ? $perkembangan_kepandaian['motorik_kasar'] : ''); ?>" class="text_dt" style="width:565px;"></td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
			<td valign="top">Motorik Halus</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><input type="text" name="motorik_halus" id="motorik_halus" value="<?php echo ((isset($perkembangan_kepandaian['motorik_halus'])) ? $perkembangan_kepandaian['motorik_halus'] : ''); ?>" class="text_dt" style="width:565px;"></td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
			<td valign="top">Bicara</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><input type="text" name="bicara" id="bicara" value="<?php echo ((isset($perkembangan_kepandaian['bicara'])) ? $perkembangan_kepandaian['bicara'] : ''); ?>" class="text_dt" style="width:565px;"></td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
			<td valign="top">Sosial</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><input type="text" name="sosial" id="sosial" value="<?php echo ((isset($perkembangan_kepandaian['sosial'])) ? $perkembangan_kepandaian['sosial'] : ''); ?>" class="text_dt" style="width:565px;"></td>
		</tr>
		<tr>
			<td valign="top">4.</td>
			<td valign="top">Vaksinasi</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="vaksinasi" id="vaksinasi" class="text_dt10"><?php echo ((isset($vaksinasi['vaksinasi'])) ? $vaksinasi['vaksinasi'] : ''); ?></textarea></td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
			<td colspan="15">
				<table>
					<tr>
						<td valign="top">BCG</td>
						<td valign="top" width="10px">:</td>
						<td valign="top" ><input type="text" name="bcg" id="bcg" value="<?php echo ((isset($vaksinasi['bcg'])) ? $vaksinasi['bcg'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td valign="top" width="90px">Hepatitis B</td>
						<td valign="top" width="10px">:</td>
						<td valign="top" ><input type="text" name="hepatitis_b" id="hepatitis_b" value="<?php echo ((isset($vaksinasi['hepatitis_b'])) ? $vaksinasi['hepatitis_b'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td valign="top">DPT</td>
						<td valign="top" width="10px">:</td>
						<td valign="top" ><input type="text" name="dpt" id="dpt" value="<?php echo ((isset($vaksinasi['dpt'])) ? $vaksinasi['dpt'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td valign="top" width="85px">Polio</td>
						<td valign="top" width="10px">:</td>
						<td valign="top" ><input type="text" name="polio" id="polio" value="<?php echo ((isset($vaksinasi['polio'])) ? $vaksinasi['polio'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td valign="top">Campak</td>
						<td valign="top" width="10px">:</td>
						<td valign="top" ><input type="text" name="campak" id="campak" value="<?php echo ((isset($vaksinasi['campak'])) ? $vaksinasi['campak'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						
					</tr>
					<tr>
						<td valign="top">Hib</td>
						<td valign="top" width="10px">:</td>
						<td valign="top" ><input type="text" name="hib" id="hib" value="<?php echo ((isset($vaksinasi['hib'])) ? $vaksinasi['hib'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td valign="top" >IPD</td>
						<td valign="top" width="10px">:</td>
						<td valign="top" ><input type="text" name="ipd" id="ipd" value="<?php echo ((isset($vaksinasi['ipd'])) ? $vaksinasi['ipd'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td valign="top">Infuenza</td>
						<td valign="top" width="10px">:</td>
						<td valign="top" ><input type="text" name="influenza" id="influenza" value="<?php echo ((isset($vaksinasi['influenza'])) ? $vaksinasi['influenza'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td valign="top">Cacar Air</td>
						<td valign="top" width="10px">:</td>
						<td valign="top" ><input type="text" name="cacar_air" id="cacar_air" value="<?php echo ((isset($vaksinasi['cacar_air'])) ? $vaksinasi['cacar_air'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td valign="top">MMR</td>
						<td valign="top" width="10px">:</td>
						<td valign="top" ><input type="text" name="mmr" id="mmr" value="<?php echo ((isset($vaksinasi['mmr'])) ? $vaksinasi['mmr'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="18">&nbsp;</td>
		</tr>
		<tr>
			<td valign="top"><b>II.</td>
			<td valign="top" colspan="18"><b>PEMERIKSAAN JASMANI</td>
		</tr>
		<tr>
			<td valign="top">1.</td>
			<td valign="top" >Tanda Utama</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><input type="text" name="tanda_utama" id="tanda_utama" value="<?php echo $tanda_utama; ?>" class="text_dt" style="width:750px;"></td>
		</tr>
		<tr>
			<td valign="top">2.</td>
			<td valign="top" >Nadi</td>
			<td valign="top" width="10px">:</td>
			<td width="125px"><select name="irama_nadi" id="irama_nadi" style="width:125px;" class="text_dt">
					<option value="">--</option>
					<option value="0" <?php if($nadi['irama_nadi'] == '0') echo 'selected="selected"'; ?> >Teratur</option>
					<option value="1" <?php if($nadi['irama_nadi'] == '1') echo 'selected="selected"'; ?>>Tidak Teratur</option>
				</select>
			</td>
			<td valign="top" colspan="4"><input type="text" name="nadi" id="nadi" value="<?php echo ((isset($nadi['nadi'])) ? $nadi['nadi'] : ''); ?>" class="text_dt" style="width:80px;"> x/menit,</td>
			<td valign="top" align="right">isi dan tegangan</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" width="150px"><input type="text" name="tegangan_nadi" id="tegangan_nadi" value="<?php echo ((isset($nadi['tegangan_nadi'])) ? $nadi['tegangan_nadi'] : ''); ?>" class="text_dt" style="width:150px;"></td>
		</tr>
		<tr>
			<td valign="top">3.</td>
			<td valign="top">Suhu Badan</td>
			<td valign="top" width="10px">:</td>
			<td valign="top"><input type="text" name="suhu_badan" id="suhu_badan" value="<?php echo ((isset($suhu_badan['suhu_badan'])) ? $suhu_badan['suhu_badan'] : ''); ?>" class="text_dt" style="width:80px;"> &degC</td>
			<td valign="top" colspan="5" align="right">Tekanan darah</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" width="150px"><input type="text" name="tekanan_darah" id="tekanan_darah" value="<?php echo ((isset($suhu_badan['tekanan_darah'])) ? $suhu_badan['tekanan_darah'] : ''); ?>" class="text_dt" style="width:80px;"> mmHg,</td>
			
		</tr>
		<tr>
			<td valign="top">4.</td>
			<td valign="top">Pernapasan</td>
			<td valign="top" width="10px">:</td>
			<td valign="top"><input type="text" name="pernapasan" id="pernapasan" value="<?php echo ((isset($pernapasan['pernapasan'])) ? $pernapasan['pernapasan'] : ''); ?>" class="text_dt" style="width:120px;"></td>
			<td colspan="3"> x/menit</td>
			<td valign="top" colspan="2" align="right">Tipe</td>
			<td valign="top" width="10px">:</td>
			<td valign="top"><input type="text" name="tipe_pernapasan" id="tipe_pernapasan" value="<?php echo ((isset($pernapasan['tipe_pernapasan'])) ? $pernapasan['tipe_pernapasan'] : ''); ?>" class="text_dt" style="width:150px;"></td>
		</tr>
		<tr>
			<td valign="top">5.</td>
			<td valign="top">Berat Badan</td>
			<td valign="top" width="10px">:</td>
			<td valign="top"><input type="text" name="berat_b" id="berat_b" value="<?php echo ((isset($berat_badan['berat_b'])) ? $berat_badan['berat_b'] : ''); ?>" class="text_dt" style="width:80px;"> Kg</td>
			<td colspan="2" align="right">Tinggi Badan</td>
			<td valign="top" width="10px">:</td>
			<td valign="top"><input type="text" name="tinggi_b" id="tinggi_b" value="<?php echo ((isset($berat_badan['tinggi_b'])) ? $berat_badan['tinggi_b'] : ''); ?>" class="text_dt" style="width:80px;"> cm</td>
			<td valign="top" align="right">Lingkar Kepala</td>
			<td valign="top" width="10px">:</td>
			<td valign="top"><input type="text" name="lingkar_kepala" id="lingkar_kepala" value="<?php echo ((isset($berat_badan['lingkar_kepala'])) ? $berat_badan['lingkar_kepala'] : ''); ?>" class="text_dt" style="width:80px;"> cm</td>
			<td></td>
		</tr>
		<tr>
			<td valign="top">6.</td>
			<td valign="top">Ubun Ubun Besar (UUB)</td>
			<td valign="top" width="10px">:</td>
			<td valign="top"><input type="text" name="uub" id="uub" value="<?php echo ((isset($ubun['uub'])) ? $ubun['uub'] : ''); ?>" class="text_dt" style="width:120px;"></td>
			<td colspan="5" align="right">Lingkar Lengan Atas (LLA)</td>
			<td valign="top" width="10px">:</td>
			<td valign="top"><input type="text" name="lla" id="lla" value="<?php echo ((isset($ubun['lla'])) ? $ubun['lla'] : ''); ?>" class="text_dt" style="width:80px;"> cm</td>
		</tr>
		<tr>
			<td valign="top">7.</td>
			<td valign="top">Kesimpulan Status Gizi</td>
			<td valign="top" width="10px">:</td>
			<td width="125px" valign="top"><select name="status_gizi" id="status_gizi" style="width:125px;" class="text_dt">
					<option value="">--</option>
					<option value="0" <?php if($status_gizi == '0') echo 'selected="selected"'; ?> >Baik</option>
					<option value="1" <?php if($status_gizi == '1') echo 'selected="selected"'; ?> >Cukup</option>
					<option value="2" <?php if($status_gizi == '2') echo 'selected="selected"'; ?> >Sedang</option>
					<option value="3" <?php if($status_gizi == '3') echo 'selected="selected"'; ?> >Kurang</option>
					<option value="4" <?php if($status_gizi == '4') echo 'selected="selected"'; ?> >Kurang Sekali</option>
				</select>
			</td>
		</tr>
		<tr>
			<td valign="top">8.</td>
			<td valign="top">Kelenjar Limpa</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><input type="text" name="kelenjar_limpa" id="kelenjar_limpa" value="<? echo $kelenjar_limpa; ?>" class="text_dt" style="width:750px;"></td>	
		</tr>
		<tr>
			<td colspan="18">&nbsp;</td>
		</tr>
		<tr>
			<td valign="top"><b>III.</td>
			<td valign="top" colspan="18"><b>PEMERIKSAAN KHUSUS</td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Leher</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="leher" id="leher" class="text_dt10"><?php echo $leher; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Dada</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="dada" id="dada" class="text_dt10"><?php echo $dada; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Jantung</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="jantung" id="jantung" class="text_dt10"><?php echo $jantung; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Paru-paru</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="paru" id="paru" class="text_dt10"><?php echo $paru; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Perut</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="perut" id="perut" class="text_dt10"><?php echo $perut; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Hati</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="hati" id="hati" class="text_dt10"><?php echo $hati; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Limpa Anogenital</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="limpa" id="limpa" class="text_dt10"><?php echo $limpa_anog; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Ektermitas</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="ektermitas" id="ektermitas" class="text_dt10"><?php echo $ektermitas; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Gerakan</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="gerakan" id="gerakan" class="text_dt10"><?php echo $gerakan; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Tonus</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="tonus" id="tonus" class="text_dt10"><?php echo $tonus; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Trofi</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="trofi" id="trofi" class="text_dt10"><?php echo $trofi; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Clonus</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="clonus" id="clonus" class="text_dt10"><?php echo $clonus; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Refleks Fisilogis</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="ref_fisilogis" id="ref_fisilogis" class="text_dt10"><?php echo $refleks_fis; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Refleks Patologis</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="ref_patologis" id="ref_patologis" class="text_dt10"><?php echo $refleks_pat; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Kepala</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="kepala" id="kepala" class="text_dt10"><?php echo $kepala; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Mata</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="mata" id="mata" class="text_dt10"><?php echo $mata; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Hidung</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="hidung" id="hidung" class="text_dt10"><?php echo $hidung; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Telinga</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="telinga" id="telinga" class="text_dt10"><?php echo $telinga; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Mulut</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="mulut" id="mulut" class="text_dt10"><?php echo $mulut; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Pharing</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="pharing" id="pharing" class="text_dt10"><?php echo $pharing; ?></textarea></td>
		</tr>
		<tr>
			<td valign="top" colspan="2">Gigi</td>
			<td valign="top" width="10px">:</td>
			<td valign="top" colspan="10"><textarea name="gigi" id="gigi" class="text_dt10"><?php echo $gigi; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="18">&nbsp;</td>
		</tr>
		<tr>
			<td valign="top"><b>IV.</td>
			<td valign="top"><b>PEMERIKSAAN LABORATORIUM</td>
			<td valign="top" width="10px"><b>:</td>
			<td valign="top" colspan="10"><textarea name="periksa_lab" id="periksa_lab" cols="100" style="height:100px;" class="text_dt"><?php echo $periksa_lab; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="18">&nbsp;</td>
		</tr>
		<tr>
			<td valign="top"><b>V.</td>
			<td valign="top"><b>PEMERIKSAAN RADIOLOGI</td>
			<td valign="top" width="10px"><b>:</td>
			<td valign="top" colspan="10"><textarea name="periksa_rad" id="periksa_rad" cols="100" style="height:100px;" class="text_dt"><?php echo $periksa_rad; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="18">&nbsp;</td>
		</tr>
		<tr>
			<td valign="top"><b>VI.</td>
			<td valign="top"><b>DIAGNOSA</td>
			<td valign="top" width="10px"><b>:</td>
			<td valign="top" colspan="10"><input type="text" name="diagnosaanak_0" id="diagnosaanak_0" value="<?php echo ((isset($diagnosa[0])) ? $diagnosa[0] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td valign="top" colspan="3">&nbsp;</td>
			<td colspan="10"><input type="text" name="diagnosaanak_1" id="diagnosaanak_1" value="<?php echo ((isset($diagnosa[1])) ? $diagnosa[1] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td valign="top" colspan="3">&nbsp;</td>
			<td colspan="10"><input type="text" name="diagnosaanak_2" id="diagnosaanak_2" value="<?php echo ((isset($diagnosa[2])) ? $diagnosa[2] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td valign="top" colspan="3">&nbsp;</td>
			<td colspan="10"><input type="text" name="diagnosaanak_3" id="diagnosaanak_3" value="<?php echo ((isset($diagnosa[3])) ? $diagnosa[3] : ''); ?>" class="text_dt" style="width:755px;" ></td>
		</tr>
		<tr>
			<td colspan="18">&nbsp;</td>
		</tr>
		<tr>
			<td valign="top"><b>VII.</td>
			<td valign="top"><b>RENCANA TATALAKSANA</td>
			<td valign="top" width="10px"><b>:</td>
			<td valign="top" colspan="10"><textarea name="renc_tatalaksana" id="renc_tatalaksana" cols="100" style="height:100px;" class="text_dt"><?php echo $renc_tatalaksana; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="18">&nbsp;</td>
		</tr>
		<tr><td colspan="18" align="right" >
		Update : <?php echo $register; ?>
			<input type="checkbox" name="final" id="final" value="1" <?php echo (($final == '1') ? 'checked' : ''); ?> />&nbsp;Final&nbsp;&nbsp;&nbsp;&nbsp;
			<?php if(isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
				<?php if($final == '1'){ ?>
					<?php if($dokter_pjawab == $_SESSION['SES_SIMRS_PEGAWAI_ID']){ ?>
						<input type="button" value="simpan" class="myButton1" onclick="simpan_37();"/>
					<?php } ?>
				<?php }else{ ?>
					<input type="button" value="simpan" class="myButton1" onclick="simpan_37();"/>
				<?php } ?>
			<?php } ?>
		
			<?php if(!empty($idx)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "2"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idx . '"
						AND JENIS_DOKUMEN_ID = "70"
						ORDER BY FILE_ID DESC LIMIT 1';
				$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
				$dat_view_rm = mysql_fetch_assoc($get_view_rm);
			?>
	<!--			<input type="button" value="lihat" class="myButton1" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" />
		-->	<?php } ?>
			</td>
        </tr>

	</table>
</form>
<script>
<?php if(isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
	<?php if($final == '1'){ ?>
		<?php if($dokter_pjawab != $_SESSION['SES_SIMRS_PEGAWAI_ID']){ ?>
			$(':input').attr('readonly','readonly');
		<?php } ?>
	<?php } ?>
<?php }else{ ?>
	$(':input').attr('readonly','readonly');
<?php } ?>

function simpan_37(){
	_haschange = false;
	$('#formperiksa_37').submit();
}	
</script>