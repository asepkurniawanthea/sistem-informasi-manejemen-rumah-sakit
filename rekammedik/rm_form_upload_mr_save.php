<?php
$nomr = $_POST['nomr'];
$kunjungan = $_POST['kunjungan'];
$jns_dokumen = $_POST['jns_dokumen'];
$keterangan = $_POST['keterangan'];
$filename = $_FILES['namafile']['name'];
$x_filename = $nomr . $kunjungan . $jns_dokumen;

$_err = '';
if (empty($kunjungan))
    $_err = $_err . 'Kunjungan Harus Diisi. \n';
if (empty($jns_dokumen))
    $_err = $_err . 'Jenis Status/ Dokumen Harus Diisi. \n';

if(empty($_err)){
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	if(strtolower($ext) == 'pdf'){
		if(!file_exists($rmfile_path . '/' . $nomr)){
			@mkdir($rmfile_path . '/' . $nomr, 0700, true);
		}
		
		$new_filename = $x_filename . '_' . str_replace(' ','',$filename); 

		move_uploaded_file($_FILES['namafile']['tmp_name'], $rmfile_path . '/' . $nomr . '/' . $new_filename);
		$jns_rawat = '1';
		if(substr($kunjungan,0,2) == 'RI') $jns_rawat = '2'; 
		$rawat_id = '';
		$rawat_id = substr($kunjungan,2,strlen($kunjungan) - 2);

		mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,ORDER_PENUNJANG,NAMA_PENUNJANG,
					NAMA_FILE,KETERANGAN,ST_SISTEM,USER_UPLOAD)
					VALUES("' . $jns_dokumen . '","' . $nomr . '","' . $rawat_id . '","' . $jns_rawat . '",
					"' . $x_filename . '","","' . $new_filename . '","' . $keterangan . '","1","' . $user_name . '")') or die(mysql_error());
		?>
		<script language="JavaScript" >
			alert('Upload File MR Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php	
}else{
	$msg_info = 'File (PDF) Belum Dipilih. \n Atau File Harus Berbentuk PDF.';
}
}else{
	$msg_info = $_err;
}			
?>