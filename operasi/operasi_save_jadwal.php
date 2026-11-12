<?php
$operasi_id = $_POST['operasi_id'];
$pegawai_operasi_id = $_POST['pegawai_operasi_id'];
$tgl_operasi = $_POST['tgl_operasi'];
$jam_operasi = $_POST['jam_operasi'];
$menit_operasi = $_POST['menit_operasi'];
$ord = $_POST['ord'];
$unit_id = $_POST['unit_id'];
$user_name = currentUser();

$_err = '';
if (empty($pegawai_operasi_id))
    $_err = $_err . 'Dokter Pelaksana Operasi Harus Diisi. \n';
if (empty($tgl_operasi))
    $_err = $_err . 'Tanggal Operasi Harus Diisi. \n';
if (empty($jam_operasi))
    $_err = $_err . 'Jam Operasi Harus Diisi. \n';
if (empty($menit_operasi))
    $_err = $_err . 'Menit Operasi Harus Diisi. \n';

if (empty($_err)) {
			$sql_cek_no_operasi = 'SELECT NO_OPERASI FROM t_operasi WHERE OPERASI_ID = "' . $_POST['operasi_id'] . '"';
			$get_cek_no_operasi = mysql_query($sql_cek_no_operasi) or die(mysql_error());
			$dat_cek_no_operasi = mysql_fetch_assoc($get_cek_no_operasi);
			if (empty($dat_cek_no_operasi['NO_OPERASI'])){
				if($ord == 'IRN'){
					$no_pendaftaran = getNomorBulanan('IRNA');
					mysql_query('UPDATE t_operasi SET TANGGAL_OPERASI = STR_TO_DATE("' . $tgl_operasi . '","%d/%m/%Y"), 
							PEGAWAI_PELAKSANA_ID = "' . $pegawai_operasi_id . '", USER_OPERASI = "' . $user_name . '",
							JAM_OPERASI = "' . $jam_operasi . ':' . $menit_operasi . '",ST_APPROVE = "1",
							NO_PENDAFTARAN = "' . $no_pendaftaran . '",ST_MASUK = "2"
							WHERE OPERASI_ID = "' . $operasi_id . '"') or die(mysql_error());
				}else{
					if($unit_id == '9'){
						$no_pendaftaran = getNomorBulanan('IRJA');
						mysql_query('UPDATE t_operasi SET TANGGAL_OPERASI = STR_TO_DATE("' . $tgl_operasi . '","%d/%m/%Y"), 
							PEGAWAI_PELAKSANA_ID = "' . $pegawai_operasi_id . '", USER_OPERASI = "' . $user_name . '",
							JAM_OPERASI = "' . $jam_operasi . ':' . $menit_operasi . '",ST_APPROVE = "1",
							NO_PENDAFTARAN = "' . $no_pendaftaran . '",ST_MASUK = "1"
							WHERE OPERASI_ID = "' . $operasi_id . '"') or die(mysql_error());
					}else{
						mysql_query('UPDATE t_operasi SET TANGGAL_OPERASI = STR_TO_DATE("' . $tgl_operasi . '","%d/%m/%Y"), 
							PEGAWAI_PELAKSANA_ID = "' . $pegawai_operasi_id . '", USER_OPERASI = "' . $user_name . '",
							JAM_OPERASI = "' . $jam_operasi . ':' . $menit_operasi . '",ST_APPROVE = "1"
							WHERE OPERASI_ID = "' . $operasi_id . '"') or die(mysql_error());
					}		
							
							
				}			
			}		
?>
       <script language="JavaScript" >
            alert('Simpan Jadwal Operasi Berhasil.');
			window.location = "index.php?link=829cf20116673b3135535e227e26245b";
        </script>
<?php
} else {
    $msg_info = $_err;
}
?>