<?php
$irna_id = $_POST['irna_id'];
$nomr = $_POST['nomr'];
$ruang_id = $_POST['ruang_id'];
$tmp_tidur = $_POST['tmp_tidur'];
$pegawai_id = $_POST['pegawai_id'];
$keterangan_pindah = $_POST['keterangan_pindah'];

$_err = '';
if (empty($ruang_id))
    $_err = $_err . 'Ruang Rawat Harus Diisi. \n';
if (empty($pegawai_id))
    $_err = $_err . 'Dokter Harus Diisi. \n';	
if (empty($keterangan_pindah))
    $_err = $_err . 'Keterangan Pindah Harus Diisi. \n';	
		

$st_save = true;
if (empty($_err)) {
		$sql_log = 'SELECT NO_RAWAT,NOMR,JENIS_BAYAR_ID,
					RUANG_ID,PEGAWAI_ID,
					PEGAWAI_RAWAT_ID,PEGAWAI_RAWAT_ID_2,PEGAWAI_RAWAT_ID_3,
					DATE_FORMAT(PASIEN_MASUK,"%d-%m-%Y %H:%i:%s") AS TANGGAL_MASUK
					FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
		$get_log = mysql_query($sql_log) or die(mysql_error());
		$dat_log = mysql_fetch_assoc($get_log);
			
		$qry_pindah = 'SELECT DATE_FORMAT(t_irna_log.TANGGAL_MASUK,"%d-%m-%Y %H:%i:%s") AS TANGGAL_MASUK
							 FROM t_irna_log
							 WHERE t_irna_log.IRNA_ID = "' . $_POST['irna_id'] . '"
							 AND t_irna_log.JNS_UPDATE = "R"
							 AND t_irna_log.TANGGAL_MASUK IS NOT NULL
							 ORDER BY t_irna_log.TANGGAL_MASUK DESC LIMIT 1';
		$get_pindah = mysql_query($qry_pindah) or die(mysql_error());
		if(mysql_num_rows($get_pindah) > 0){
			$dat_pindah = mysql_fetch_assoc($get_pindah);
			$tgl_masuk = $dat_pindah['TANGGAL_MASUK']; 
		}else{
			$tgl_masuk = $dat_log['TANGGAL_MASUK']; 
		}
			

		mysql_query('INSERT INTO t_irna_log(IRNA_ID,NOMR,TANGGAL_UPDATE,JNS_UPDATE,
					RUANG_ID_ASAL,RUANG_ID_BARU,PEGAWAI_ID,PEGAWAI_RAWAT_ID,PEGAWAI_RAWAT_ID_2,
					PEGAWAI_RAWAT_ID_3,KETERANGAN_PINDAH,USER_IRNA,TANGGAL_KELUAR,JENIS_BAYAR_ID,
					LAMA_DIRAWAT)
					VALUES("' . $irna_id . '","' . $nomr . '",NOW(),"R",
					"' . $dat_log['RUANG_ID'] . '","' . $ruang_id . '",
					"' . $dat_log['PEGAWAI_ID'] . '","' . $dat_log['PEGAWAI_RAWAT_ID'] . '",
					"' . $dat_log['PEGAWAI_RAWAT_ID_2'] . '","' . $dat_log['PEGAWAI_RAWAT_ID_3'] . '",
					"' . $keterangan_pindah . '","' . $user_name . '",NOW(),"' . $dat_log['JENIS_BAYAR_ID'] . '",
					DATEDIFF(NOW(),STR_TO_DATE("' . $tgl_masuk . '","%d-%m-%Y %H:%i:%s")))') or die(mysql_error());
		
		$sql_log_id = 'SELECT IRNA_LOG_ID FROM t_irna_log
						WHERE IRNA_ID = "' . $irna_id . '"
						ORDER BY IRNA_LOG_ID DESC LIMIT 1';
		$get_log_id = mysql_query($sql_log_id) or die(mysql_error());
		$dat_log_id = mysql_fetch_assoc($get_log_id);	
		
		$st_save = mysql_query('UPDATE t_irna SET RUANG_ID = "' . $ruang_id . '",PEGAWAI_ID = "' . $pegawai_id . '",
						KELAS_RAWAT = (SELECT m_ruang.KELAS_RAWAT FROM m_ruang WHERE m_ruang.RUANG_ID = "' . $ruang_id . '"),
						NO_TMP_TIDUR = "' . $tmp_tidur . '",ST_PINDAH = "1",LOG_PINDAH_ID = "' . $dat_log_id['IRNA_LOG_ID'] . '",
						USER_PENDAFTARAN = "' . $user_name . '"
						WHERE IRNA_ID = "' . $irna_id . '"') or die(mysql_error());
						
		
$link = 'pendaftaranlistrawat';
function ubahDateFormat($originalDate) {
	$date = new DateTime($originalDate);
	return $date->format('d M Y');
}
$rm1=substr($nomr,0,2);
$rm2=substr($nomr,2,2);
$rm3=substr($nomr,4,2);
	
$sql_pasien = 'SELECT m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,
				t_irna.TANGGAL_DAFTAR,m_ruang.NAMA_RUANG,m_pegawai.NAMA_PEGAWAI,t_irna.KELAS_RAWAT
				FROM m_pasien
				INNER JOIN t_irna ON (m_pasien.NOMR = t_irna.NOMR)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_irna.IRNA_ID = "' . $irna_id . '"';
$get_pasien = mysql_query($sql_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
	
$nomr = $rm1 . '.' . $rm2 . '.' . $rm3;
$umur = ubahDateFormat($dat_pasien['TGL_LAHIR']);
$pasien = $dat_pasien['NAMA_PASIEN'].' ('.strtoupper($dat_pasien['JNS_KELAMIN']).', '.$umur.')';
$tgl_masuk = $dat_pasien['TANGGAL_DAFTAR'];
$dokter = $dat_pasien['NAMA_PEGAWAI'];
$ruang = $dat_pasien['NAMA_RUANG'] . ' Kelas ' . $dat_pasien['KELAS_RAWAT'];
?>
<script language="JavaScript" >
var p_sjp = 'no';
if(confirm('Print SJP?')){
	p_sjp = 'yes';
}
var p_sep = 'no';	
window.open('http://localhost/nsimrs_print/print_sjp_irna.php?idx=<?php echo $irna_id; ?>&sjp=' + p_sjp + '&sep=' + p_sep,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
window.open("index.php?print=gelangpasien&pasien=<?php echo $pasien; ?>&norm=<?php echo 'MR '.$nomr; ?>&tglmasuk=<?php echo ubahDateFormat($tgl_masuk); ?>&dokter=<?php echo $dokter; ?>&ruangan=<?php echo $ruang; ?>","Gelang Pasien");

alert('Simpan Perubahan Data Rawat Berhasil.');
window.location = "index.php?link=<?php echo md5($link); ?>&idx=<?php echo $irna_id; ?>";
</script> 
<?php
} else {
  $msg_info = $_err;
}
?>