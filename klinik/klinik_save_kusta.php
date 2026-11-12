<?php
$_err = '';
$irja_id = $_POST['irja_id'];
$kusta_type = $_POST['kusta_type']; 
$kusta_bta_rata2_semula = $_POST['kusta_bta_rata2_semula'];
$kusta_tgl_bta_rata2 = $_POST['kusta_tgl_bta_rata2'];
$kusta_mdt_mulai = $_POST['kusta_mdt_mulai'];
$kusta_dosis_antireaksi = $_POST['kusta_dosis_antireaksi'];
$kusta_dosis_lamprene = $_POST['kusta_dosis_lamprene'];
$kusta_rft_cot = $_POST['kusta_rft_cot'];
$kusta_bta_mh_skr = $_POST['kusta_bta_mh_skr'];
$kusta_penyakit_lain = $_POST['kusta_penyakit_lain'];
$kusta_yg_perlu_dihubungi = $_POST['kusta_yg_perlu_dihubungi'];
$kusta_alamat_dihubungi = $_POST['kusta_alamat_dihubungi'];
$kusta_telepon_dihubungi = $_POST['kusta_telepon_dihubungi'];			
$kusta_keterangan = $_POST['kusta_keterangan'];
$kusta_opname = '';
if(isset($_POST['kusta_opname']))
	$kusta_opname = $_POST['kusta_opname'];
$kusta_keterangan_opname = $_POST['kusta_keterangan_opname'];
$kusta_kunjungan = $_POST['kusta_kunjungan'];
$pod = ''; 
if(isset($_POST['pod'])) $pod = $_POST['pod'];  
$user_name = currentUser();
	
	$_err = '';
	/*if (empty($kusta_type))
		$_err = $_err . 'Tipe Kusta Harus Diisi. \n';
	if ($kusta_bta_rata2_semula == '-')
		$_err = $_err . 'BTA Semula Harus Diisi. \n';
	if (empty($kusta_tgl_bta_rata2))
		$_err = $_err . 'Tanggal BTA Semula Harus Diisi. \n';
	if (empty($kusta_mdt_mulai))
		$_err = $_err . 'MDT Mulai Harus Diisi. \n';
	if($kusta_opname == '1'){
		if (empty($kusta_keterangan_opname))
			$_err = $_err . 'Keterangan Opname Harus Diisi. \n';
	}*/
	
	if (empty($_err)) {
		mysql_query('UPDATE t_irja SET KUSTA_TYPE = "' . $kusta_type . '",
					  KUSTA_BTA_RATA2_SEMULA = "' . $kusta_bta_rata2_semula . '",
					  KUSTA_TGL_BTA_RATA2 = ' . fieldDate($kusta_tgl_bta_rata2) . ',
					  KUSTA_MDT_MULAI = ' . fieldDate($kusta_mdt_mulai) . ',
					  KUSTA_DOSIS_ANTIREAKSI = "' . $kusta_dosis_antireaksi . '",
					  KUSTA_DOSIS_LAMPRENE = "' . $kusta_dosis_lamprene . '",
					  KUSTA_RFT_COT = ' . fieldDate($kusta_rft_cot) . ',
					  KUSTA_BTA_MH_SKR = "' . $kusta_bta_mh_skr . '",
					  KUSTA_PENYAKIT_LAIN = "' . $kusta_penyakit_lain . '",
					  KUSTA_YG_PERLU_DIHUBUNGI = "' . $kusta_yg_perlu_dihubungi . '",
					  KUSTA_TELEPON_DIHUBUNGI = "' . $kusta_telepon_dihubungi . '",
					  KUSTA_KETERANGAN = "' . $kusta_keterangan . '",
					  KUSTA_ALAMAT_DIHUBUNGI = "' . $kusta_alamat_dihubungi . '",
					  POD = "' . $pod . '",
					  KUSTA_OPNAME = "' . $kusta_opname . '",
					  KUSTA_KETERANGAN_OPNAME = "' . $kusta_keterangan_opname . '",
					  KUSTA_KUNJUNGAN = "' . $kusta_kunjungan . '",
					  USER_IRJA = "' . $user_name . '"
					  WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
					  
		mysql_query('DELETE FROM t_irja_pod WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
		$z = 1;
		while ($z <= 18){
			if(isset($_POST['podsub_'. $z])){
				mysql_query('INSERT INTO t_irja_pod (IRJA_ID,SUB_POD) VALUES("' . $irja_id . '","' . $_POST['podsub_'. $z] . '")') or die(mysql_error());
			}
			$z++;
		}	
?>
<script language="JavaScript" >
	alert('Simpan Data Kusta Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php			
		}else{
			$msg_info = $_err;
		}
?>