<?php
$nomr = $_POST['nomr'];
$nama_pasien = $_POST['nama_pasien'];
$tmp_lahir = $_POST['tmp_lahir'];
$tgl_lahir = $_POST['tgl_lahir'];
if(isset($_POST['jns_kelamin'])) $jns_kelamin = $_POST['jns_kelamin'];
if(isset($_POST['st_kawin'])) $st_kawin = $_POST['st_kawin'];
$agama_id = $_POST['agama_id'];
$pendidikan_id = $_POST['pendidikan_id'];
$pekerjaan = $_POST['pekerjaan'];
$alamat = $_POST['alamat'];
$alamat_rt = $_POST['alamat_rt'];
$alamat_rw = $_POST['alamat_rw'];
$kelurahan_id = $_POST['kelurahan_id'];
$kecamatan_id = $_POST['kecamatan_id'];
$kota_id = $_POST['kota_id'];
$propinsi_id = $_POST['propinsi_id'];
$kode_pos = $_POST['kode_pos'];
$no_telepon = $_POST['no_telepon'];
$nama_ibu = $_POST['nama_ibu'];
$nama_ayah = $_POST['nama_ayah'];
$nama_suami_isteri = $_POST['nama_suami_isteri'];
$nik = $_POST['nik'];
$khusus = $_POST['khusus'];
$st_baru = $_POST['st_baru'];

$irja_id = $_POST['irja_id'];
$user_name = currentUser();
$shift = $_SESSION['SES_SIMRS_SHIFT'];
$pasien = $_POST['pasien'];

$_err = '';
if (empty($nama_pasien))
    $_err = 'Nama Pasien Harus Diisi. \n';
if (empty($tmp_lahir))
    $_err = $_err . 'Tempat Lahir Harus Diisi. \n';
if (empty($tgl_lahir))
    $_err = $_err . 'Tanggal Lahir Harus Diisi. \n';
if (empty($jns_kelamin))
    $_err = $_err . 'Jenis Kelamin Harus Diisi. \n';
//if (empty($st_kawin))
//    $_err = $_err . 'Status Kawin Harus Diisi. \n';
if (empty($agama_id))
    $_err = $_err . 'Agama Harus Diisi. \n';
//if (empty($alamat))
//    $_err = $_err . 'Alamat Harus Diisi. \n';
//if (empty($alamat_rt))
//    $_err = $_err . 'Rt Harus Diisi. \n';
//if (empty($alamat_rw))
//    $_err = $_err . 'Rw Harus Diisi. \n';
//if (empty($kelurahan_id))
//    $_err = $_err . 'Kelurahan Harus Diisi. \n';
//if (empty($kecamatan_id))
//    $_err = $_err . 'Kecamatan Harus Diisi. \n';
//if (empty($kota_id))
//    $_err = $_err . 'Kota Harus Diisi. \n';
//if (empty($propinsi_id))
//    $_err = $_err . 'Propinsi Harus Diisi. \n';
if (empty($nama_ibu))
    $_err = $_err . 'Nama Ibu Harus Diisi. \n';
//if (empty($nik))
//    $_err = $_err . 'NIK Harus Diisi. \n';	

    $st_save = true;
	if (empty($_err)) {
        if (!empty($_POST['nomr'])) {
            $st_save = mysql_query('UPDATE m_pasien SET NAMA_PASIEN = "' . strtoupper($nama_pasien) . '",TMP_LAHIR = "' . $tmp_lahir . '",TGL_LAHIR = ' . fieldDate($tgl_lahir) . ',
				JNS_KELAMIN = "' . $jns_kelamin . '",ST_KAWIN = "' . $st_kawin . '",AGAMA_ID = "' . $agama_id . '",PENDIDIKAN_ID = "' . $pendidikan_id . '",
				PEKERJAAN = "' . $pekerjaan . '",ALAMAT = "' . $alamat . '",ALAMAT_RT = "' . $alamat_rt . '",ALAMAT_RW = "' . $alamat_rw . '",
				KELURAHAN_ID = "' . $kelurahan_id . '",KECAMATAN_ID = "' . $kecamatan_id . '",KOTA_ID = "' . $kota_id . '",PROPINSI_ID = "' . $propinsi_id . '",
				KODE_POS = "' . $kode_pos . '",NO_TELEPON = "' . $no_telepon . '",NAMA_IBU = "' . $nama_ibu . '",NAMA_AYAH = "' . $nama_ayah . '",
				NAMA_SUAMI_ISTERI = "' . $nama_suami_isteri . '",NIK = "' . $nik . '",
				KHUSUS = "' . $khusus . '", USER_PENDAFTARAN = "' . $user_name . '"
				WHERE NOMR = "' . $nomr . '"') or die(mysql_error());
			//
			$connect_2 = mysql_connect($hostname_2, $username_2, $password_2) or die(mysql_error());
			mysql_select_db($database_2, $connect_2) or die(mysql_error());
			
			simrs_update_pasien('upd',$nomr,strtoupper($nama_pasien),$tmp_lahir,$tgl_lahir,$jns_kelamin,$alamat . ' ' . $alamat_rt . ' ' . $alamat_rw,
						$kelurahan_id,$kecamatan_id,$kota_id,$propinsi_id,$no_telepon,$nik,$nama_suami_isteri,$pekerjaan,
						$st_kawin,$agama_id,$pendidikan_id,$nama_ibu);
			
			$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
			mysql_select_db($database, $connect) or die(mysql_error());
			//	
        } else {
            $nomr = getNoMR($khusus);
            $st_save = mysql_query('INSERT INTO m_pasien (NOMR,NAMA_PASIEN,TMP_LAHIR,TGL_LAHIR,JNS_KELAMIN,ST_KAWIN,AGAMA_ID,PENDIDIKAN_ID,PEKERJAAN,ALAMAT,ALAMAT_RT,ALAMAT_RW,
				KELURAHAN_ID,KECAMATAN_ID,KOTA_ID,PROPINSI_ID,KODE_POS,NO_TELEPON,NAMA_IBU,NAMA_AYAH,NAMA_SUAMI_ISTERI,NIK,KHUSUS,USER_PENDAFTARAN) 
				VALUES ("' . $nomr . '","' . strtoupper($nama_pasien) . '","' . $tmp_lahir . '",' . fieldDate($tgl_lahir) . ',"' . $jns_kelamin . '","' . $st_kawin . '","' . $agama_id . '","' . $pendidikan_id . '",
				"' . $pekerjaan . '","' . $alamat . '","' . $alamat_rt . '","' . $alamat_rw . '","' . $kelurahan_id . '","' . $kecamatan_id . '","' . $kota_id . '","' . $propinsi_id . '","' . $kode_pos . '",
				"' . $no_telepon . '","' . $nama_ibu . '","' . $nama_ayah . '","' . $nama_suami_isteri . '","' . $nik . '","' . $khusus . '","' . $user_name . '")') or die(mysql_error());
			//
			$connect_2 = mysql_connect($hostname_2, $username_2, $password_2) or die(mysql_error());
			mysql_select_db($database_2, $connect_2) or die(mysql_error());
			
			simrs_update_pasien('ins',$nomr,strtoupper($nama_pasien),$tmp_lahir,$tgl_lahir,$jns_kelamin,$alamat . ' ' . $alamat_rt . ' ' . $alamat_rw,
						$kelurahan_id,$kecamatan_id,$kota_id,$propinsi_id,$no_telepon,$nik,$nama_suami_isteri,$pekerjaan,
						$st_kawin,$agama_id,$pendidikan_id,$nama_ibu);
			
			$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
			mysql_select_db($database, $connect) or die(mysql_error());
			//	
        }
        if ($st_save) {
            if (empty($irja_id)) {
				mysql_query('INSERT INTO t_irja (NOMR,TANGGAL_DAFTAR,ST_BARU,SHIFT_ID,USER_PENDAFTARAN) VALUES("' . $nomr . '",NOW(),"' . $st_baru . '","' . $shift . '","' . $user_name . '")') or die(mysql_error());
                $rsl = mysql_query('SELECT IRJA_ID FROM t_irja WHERE NOMR = "' . $nomr . '"
				ORDER BY IRJA_ID DESC LIMIT 1');
                $get = mysql_fetch_assoc($rsl);
                $irja_id = $get['IRJA_ID'];
				
				//
				$connect_2 = mysql_connect($hostname_2, $username_2, $password_2) or die(mysql_error());
				mysql_select_db($database_2, $connect_2) or die(mysql_error());
			
				simrs_update_irja('ins',$irja_id,$nomr,'','',
							'','','',$shift,$st_baru,
							'','','','','');
			
				$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
				mysql_select_db($database, $connect) or die(mysql_error());
				//
            }
        }
    }

if (empty($_err)) {
		$link = '';
		if($pasien == 'igd') $link = 'pendaftaranformdaftarigd';
		if($pasien == 'umum') $link = 'pendaftaranformdaftarpoliklinik';
		if($pasien == 'kusta') $link = 'pendaftaranformdaftarkusta';
        ?>
        <script language="JavaScript" >
            window.location = "index.php?link=<?php echo md5($link); ?>&idx=<?php echo $irja_id; ?>&pasien=<?php echo $pasien; ?>";
        </script> 
        <?php
} else {
    $msg_info = $_err;
}
?>
