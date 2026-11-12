<?php
//edoc rekam medic
//include('edoc_rekammedik/edoc_main.php');
			
$cnt = $_POST['cnt'];
$ret = true;
if($cnt > 1){
$l = 1;
while ($l < $cnt){
	if(isset($_POST['penunjang_tarif_id' . $l]) and isset($_POST['jenis_film' . $l]) 
			and isset($_POST['pegawai_id' . $l])){
	$penunjang_tarif_id = $_POST['penunjang_tarif_id' . $l];
	$jenis_film = $_POST['jenis_film' . $l];
	$pegawai_id = $_POST['pegawai_id' . $l];
	$pegawai_id_2 = $_POST['pegawai_id_2_' . $l];
	$pegawai_id_3 = $_POST['pegawai_id_3_' . $l];
	
	if(empty($jenis_film) or empty($pegawai_id)) $ret = false;
		
		if(!empty($jenis_film) and !empty($pegawai_id)){
			$sql_cek = 'SELECT t_ipenunjang_tarif.NO_PENUNJANG,t_ipenunjang_tarif.ST_PERIKSA
					FROM t_ipenunjang_tarif 
					WHERE t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $penunjang_tarif_id . '"';
			$get_cek = mysql_query($sql_cek) or die(mysql_error());	
			$dat_cek = mysql_fetch_assoc($get_cek);
			$st_periksa = $dat_cek['ST_PERIKSA']; 
			$no_penunjang = $dat_cek['NO_PENUNJANG']; 
			if(empty($st_periksa) or $_SESSION['SES_SIMRS_ADMIN'] == '1'){
				mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_PERIKSA = NOW(),
					PEGAWAI_PERIKSA_ID = "' . $pegawai_id . '",
					PEGAWAI_PERIKSA_ID_2 = "' . $pegawai_id_2 . '",
					PEGAWAI_PERIKSA_ID_3 = "' . $pegawai_id_3 . '",
					JENIS_FILM = "' . $jenis_film . '",
					SHIFT_PENUNJANG = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
					USER_PERIKSA = "' . $user_name . '"
					WHERE PENUNJANG_TARIF_ID = "' . $penunjang_tarif_id . '"') or die(mysql_error());
					
					//upload file
					$countfiles = count($_FILES['file' . $l]['name']);
					if($countfiles > 0){
						$ada_file = false;
						for($i = 0;$i < $countfiles; $i++){
							$filename = $_FILES['file' . $l]['name'][$i];
							if($filename != ''){
								$ada_file = true;
							}
						}
						if($ada_file){
							mysql_query('DELETE FROM t_ipenunjang_tarif_photo
								WHERE PENUNJANG_TARIF_ID = "' . $penunjang_tarif_id . '"') or die(mysql_error());
						
							if(!file_exists($dicom_path . '/' . $nomr)){
								@mkdir($dicom_path . '/' . $nomr, 0700, true);
							}
						
							for($i = 0;$i < $countfiles; $i++){
								$filename = $_FILES['file' . $l]['name'][$i];
								move_uploaded_file($_FILES['file' . $l]['tmp_name'][$i],$dicom_path . '/' . $nomr . '/' . $filename);
								mysql_query('INSERT INTO t_ipenunjang_tarif_photo(PENUNJANG_TARIF_ID,PHOTO_FILE)
									VALUES("' . $penunjang_tarif_id . '","' . $filename . '")') or die(mysql_error());
							}
						}	
					}	
					//end upload
			}
			if(empty($no_penunjang)){
				$nomor = getNomorHarian('Radiologi');
				mysql_query('UPDATE t_ipenunjang_tarif SET NO_PENUNJANG = "' . $nomor . '",NO_TP = "' . $nomor . '"
						WHERE PENUNJANG_TARIF_ID = "' . $penunjang_tarif_id . '"') or die(mysql_error());	
			}
			
			if(isset($_POST['selesai'. $l]) and $ret == true){
				mysql_query('UPDATE t_ipenunjang_tarif SET ST_PERIKSA = "1" WHERE PENUNJANG_TARIF_ID = "' . $penunjang_tarif_id . '"') or die(mysql_error());
			}else{
				if($_POST['ls_selesai'. $l] == '1'){
					if($_SESSION['SES_SIMRS_ADMIN'] == '1'){
						mysql_query('UPDATE t_ipenunjang_tarif SET ST_PERIKSA = NULL WHERE PENUNJANG_TARIF_ID = "' . $penunjang_tarif_id . '"') or die(mysql_error());	
					}
				}	
			}
		
		}
	}	
$l++; 
	}	
}

if($ret == true){
	$msg_info = 'Simpan Data Radiologi Berhasil.';
}else{
	$msg_info = 'Ada Isian Yang Belum Diisi.';
}		
?>