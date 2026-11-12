<?php
$_err = '';
	
$persetujuan_dokter_id = $_POST['persetujuan_dokter_id'];
$tanggal_persetujuan = $_POST['tanggal_persetujuan'];
$pemberi_informasi = $_POST['pemberi_informasi'];
$penerima_informasi = $_POST['penerima_informasi'];
$nama_penerima_informasi = $_POST['nama_penerima_informasi'];
$alamat = $_POST['alamat'];
if(isset($_POST['jns_kel']))
	$jns_kel = $_POST['jns_kel'];
$umur = $_POST['umur'];
$diag_wd_dd = $_POST['diag_wd_dd'];
$dasar_diag = $_POST['dasar_diag'];
$tind_dokter = $_POST['tind_dokter'];
$tind_dokter_sekunder = $_POST['tind_dokter_sekunder'];
$indikasi_tindk = $_POST['indikasi_tindk'];
if(isset($_POST['tata_cara']))
	$tata_cara = $_POST['tata_cara'];
$tujuan = $_POST['tujuan'];
$resiko = $_POST['resiko'];
$komplikasi = $_POST['komplikasi'];
$pronosis = $_POST['pronosis'];
if(isset($_POST['alt_resiko']))
	$alt_resiko = $_POST['alt_resiko'];
if(isset($_POST['penyelamatan_pasien']))
	$penyelamatan_pasien = $_POST['penyelamatan_pasien'];
$lain_lain = $_POST['lain_lain'];
$tind_dokter1 = $_POST['tind_dokter1'];
$saksi_1 = $_POST['saksi_1'];
$saksi_2 = $_POST['saksi_2'];
	
$user_name = currentUser();
$operasi_id = $_POST['operasi_id'];

$perstj = '';
$p = 1;
while($p <= 12 ){
	$s = '';
	if(isset($_POST['setuju_' . $p])){
		$s = '1';	
	}
	$perstj = $perstj . $s . '|';
$p++;
}

if (isset($_POST['simpan'])) {
		
    $sql_cek_no_operasi = 'SELECT NO_OPERASI FROM t_operasi WHERE OPERASI_ID = "' . $operasi_id . '"';
	$get_cek_no_operasi = mysql_query($sql_cek_no_operasi) or die(mysql_error());
	$dat_cek_no_operasi = mysql_fetch_assoc($get_cek_no_operasi);
	if (empty($dat_cek_no_operasi['NO_OPERASI']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	
	$_err = '';
	if (empty($pemberi_informasi))
		$_err = $_err . 'Pemberi Informasi Harus Diisi. \n';
	if (empty($penerima_informasi))
		$_err = $_err . 'Penerima Informasi Harus Diisi. \n';
	if (empty($nama_penerima_informasi))
		$_err = $_err . 'Nama Penerima Informasi Harus Diisi. \n';
	if (empty($alamat))
		$_err = $_err . 'Alamat Harus Diisi. \n';
	if (empty($jns_kel))
		$_err = $_err . 'Jenis Kelamin Harus Diisi. \n';
	if (empty($jns_kel))
		$_err = $_err . 'Jenis Kelamin Harus Diisi. \n';
	if (empty($umur))
		$_err = $_err . 'Umur Harus Diisi. \n';
	if (empty($tind_dokter1))
		$_err = $_err . 'Tindakan Harus Diisi. \n';
	if (empty($tanggal_persetujuan))
		$_err = $_err . 'Tanggal Persetujuan Harus Diisi. \n';
	
	if (empty($_err)) {
		if(empty($persetujuan_dokter_id)){
			mysql_query('INSERT INTO t_operasi_persetujuan_dokter(OPERASI_ID,TANGGAL_PERSETUJUAN,PEMBERI_INFORMASI,
						PENERIMA_INFORMASI,NAMA_PENERIMA_INFORMASI,ALAMAT,JNS_KEL,UMUR,
						DIAG_WD_DD,DASAR_DIAG,TIND_DOKTER,TIND_DOKTER_SEKUNDER,INDIKASI_TINDK,
						TATA_CARA,TUJUAN,RESIKO,KOMPLIKASI,PRONOSIS,ALT_RESIKO,PENYELAMATAN_PASIEN,
						LAIN_LAIN,TIND_DOKTER1,SAKSI_1,SAKSI_2,USER_OPERASI,PERSETUJUAN)
						VALUES("' . $operasi_id . '",' . fieldDate($tanggal_persetujuan) . ',"' . $pemberi_informasi . '",
						"' . $penerima_informasi . '","' . $nama_penerima_informasi . '","' . $alamat . '","' . $jns_kel . '","' . $umur . '",
						"' . $diag_wd_dd . '","' . $dasar_diag . '","' . $tind_dokter . '","' . $tind_dokter_sekunder . '","' . $indikasi_tindk . '",
						"' . $tata_cara . '","' . $tujuan . '","' . $resiko . '","' . $komplikasi . '","' . $pronosis . '","' . $alt_resiko . '",
						"' . $penyelamatan_pasien . '","' . $lain_lain . '","' . $tind_dokter1 . '","' . $saksi_1 . '","' . $saksi_2 . '",
						"' . $user_name . '","' . $perstj . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_operasi_persetujuan_dokter SET TANGGAL_PERSETUJUAN = ' . fieldDate($tanggal_persetujuan) . ',
							PEMBERI_INFORMASI = "' . $pemberi_informasi . '",
							PENERIMA_INFORMASI = "' . $penerima_informasi . '",
							NAMA_PENERIMA_INFORMASI = "' . $nama_penerima_informasi . '",
							ALAMAT = "' . $alamat . '",
							JNS_KEL = "' . $jns_kel . '",
							UMUR = "' . $umur . '",
							DIAG_WD_DD = "' . $diag_wd_dd . '",
							DASAR_DIAG = "' . $dasar_diag . '",
							TIND_DOKTER = "' . $tind_dokter . '",
							TIND_DOKTER_SEKUNDER = "' . $tind_dokter_sekunder . '",
							INDIKASI_TINDK = "' . $indikasi_tindk . '",
							TATA_CARA = "' . $tata_cara . '",
							TUJUAN = "' . $tujuan . '",
							RESIKO = "' . $resiko . '",
							KOMPLIKASI = "' . $komplikasi . '",
							PRONOSIS = "' . $pronosis . '",
							ALT_RESIKO = "' . $alt_resiko . '",
							PENYELAMATAN_PASIEN = "' . $penyelamatan_pasien . '",
							LAIN_LAIN = "' . $lain_lain . '",
							TIND_DOKTER1 = "' . $tind_dokter1 . '",
							SAKSI_1 = "' . $saksi_1 . '",
							SAKSI_2 = "' . $saksi_2 . '",
							USER_OPERASI = "' . $user_name . '",
							PERSETUJUAN = "' . $perstj . '"
							WHERE PERSETUJUAN_DOKTER_ID = "' . $persetujuan_dokter_id . '"') or die(mysql_error());
		}			  
?>
<script language="JavaScript" >
	alert('Simpan Data Persetujuan Tindakan Dokter Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php			
		}else{
			$msg_info = $_err;
		}
	}
}
?>