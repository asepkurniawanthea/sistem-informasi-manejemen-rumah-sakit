<?php
$penunjang_id = $_POST['penunjang_id'];
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
$st_baru = $_POST['st_baru'];
if(empty($st_baru)) {
	$st_baru = 'NULL';
}else{
	$st_baru = '"1"';
}	

$instansi_pengirim = $_POST['instansi_pengirim'];
$dokter_pengirim = $_POST['dokter_pengirim'];

$telp_instansi_pengirim = $_POST['telp_instansi_pengirim'];
$alamat_instansi_pengirim = $_POST['alamat_instansi_pengirim'];
$tgl_permintaan = $_POST['tgl_permintaan'];
$diagnosa = $_POST['diagnosa'];
$unit_id = $_POST['unit_id'];

$user_name = currentUser();
$no_penunjang = $_POST['no_penunjang'];

$jenis_bayar_id = $_POST['jenis_bayar_id'];

$_err = '';
if (empty($nama_pasien))
    $_err = 'Nama Pasien Harus Diisi. \n';
if (empty($tmp_lahir))
    $_err = $_err . 'Tempat Lahir Harus Diisi. \n';
if (empty($tgl_lahir)){ 
    $_err = $_err . 'Tanggal Lahir Harus Diisi. \n';
}else if(cekValidDate($tgl_lahir) == false){
	$_err = $_err . 'Tanggal Lahir Tidak Valid. \n';
}	
if (empty($jns_kelamin))
    $_err = $_err . 'Jenis Kelamin Harus Diisi. \n';
/*if (empty($st_kawin))
    $_err = $_err . 'Status Kawin Harus Diisi. \n';
if (empty($agama_id))
    $_err = $_err . 'Agama Harus Diisi. \n';
if (empty($alamat))
    $_err = $_err . 'Alamat Harus Diisi. \n';
if (empty($alamat_rt))
    $_err = $_err . 'Rt Harus Diisi. \n';
if (empty($alamat_rw))
    $_err = $_err . 'Rw Harus Diisi. \n';
if (empty($kelurahan_id))
    $_err = $_err . 'Kelurahan Harus Diisi. \n';
if (empty($kecamatan_id))
    $_err = $_err . 'Kecamatan Harus Diisi. \n';
if (empty($kota_id))
    $_err = $_err . 'Kota Harus Diisi. \n';
if (empty($propinsi_id))
    $_err = $_err . 'Propinsi Harus Diisi. \n';
if (empty($nama_ibu))
    $_err = $_err . 'Nama Ibu Harus Diisi. \n'; 
if (empty($nik))
    $_err = $_err . 'NIK Harus Diisi. \n'; */
if (empty($no_telepon))
    $_err = $_err . 'Nomor Telepon Harus Diisi. \n';	
if (empty($instansi_pengirim))
    $_err = $_err . 'Instansi Pengirim Harus Diisi. \n';
if (empty($dokter_pengirim))
    $_err = $_err . 'Dokter Pengirim Harus Diisi. \n';	
/*if (empty($telp_instansi_pengirim))
    $_err = $_err . 'Telepon Instansi Pengirim Harus Diisi. \n';		
if (empty($alamat_instansi_pengirim))
    $_err = $_err . 'Alamat Instansi Pengirim Harus Diisi. \n';			
if (empty($tgl_permintaan))
    $_err = $_err . 'Tanggal Permintaan Harus Diisi. \n';	*/
if (empty($unit_id))
    $_err = $_err . 'Penunjang Tujuan Harus Diisi. \n';	
	
    $st_save = true;
	if (empty($_err)) {
        if (!empty($_POST['penunjang_id'])) {
            $st_save = mysql_query('UPDATE t_ipenunjang SET NAMA_PASIEN = "' . strtoupper($nama_pasien) . '",TMP_LAHIR = "' . $tmp_lahir . '",TGL_LAHIR = ' . fieldDate($tgl_lahir) . ',
				JNS_KELAMIN = "' . $jns_kelamin . '",ST_KAWIN = "' . $st_kawin . '",AGAMA_ID = "' . $agama_id . '",PENDIDIKAN_ID = "' . $pendidikan_id . '",
				PEKERJAAN = "' . $pekerjaan . '",ALAMAT = "' . $alamat . '",ALAMAT_RT = "' . $alamat_rt . '",ALAMAT_RW = "' . $alamat_rw . '",
				KELURAHAN_ID = "' . $kelurahan_id . '",KECAMATAN_ID = "' . $kecamatan_id . '",KOTA_ID = "' . $kota_id . '",PROPINSI_ID = "' . $propinsi_id . '",
				KODE_POS = "' . $kode_pos . '",NO_TELEPON = "' . $no_telepon . '",NAMA_IBU = "' . $nama_ibu . '",NAMA_AYAH = "' . $nama_ayah . '",
				NAMA_SUAMI_ISTERI = "' . $nama_suami_isteri . '",NIK = "' . $nik . '", USER_ORDER = "' . $user_name . '",
				PENGIRIM = "' . $dokter_pengirim . '",INSTANSI_PENGIRIM = "' . $instansi_pengirim . '",
				ALAMAT_INSTANSI_PENGIRIM = "' . $alamat_instansi_pengirim . '",NO_TELP_INSTANSI_PENGIRIM = "' . $telp_instansi_pengirim . '",
				TANGGAL_PERMINTAAN = ' . fieldDate($tgl_permintaan) . ',DIAGNOSA_PENGIRIM = "' . $diagnosa . '",
				UNIT_ID = "' . $unit_id . '",
				NO_PASIEN_PENUNJANG = "' . $no_penunjang . '",
				JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
				WHERE PENUNJANG_ID = "' . $penunjang_id . '"') or die(mysql_error());
        } else {
			$nomor = getNomorBulanan('IPENUNJANG');
			if(empty($no_penunjang)) {
				if($unit_id == 31 or $unit_id == 40 or $unit_id == 41 
					or $unit_id == 47 or $unit_id == 51){
						$no_penunjang = getNoMR('1');
						mysql_query('INSERT INTO m_pasien (NOMR,NAMA_PASIEN,TMP_LAHIR,TGL_LAHIR,JNS_KELAMIN,ST_KAWIN,AGAMA_ID,PENDIDIKAN_ID,PEKERJAAN,ALAMAT,ALAMAT_RT,ALAMAT_RW,
							KELURAHAN_ID,KECAMATAN_ID,KOTA_ID,PROPINSI_ID,KODE_POS,NO_TELEPON,NAMA_IBU,NAMA_AYAH,NAMA_SUAMI_ISTERI,NIK,KHUSUS,USER_PENDAFTARAN) 
							VALUES ("' . $no_penunjang . '","' . strtoupper($nama_pasien) . '","' . $tmp_lahir . '",' . fieldDate($tgl_lahir) . ',"' . $jns_kelamin . '","' . $st_kawin . '","' . $agama_id . '","' . $pendidikan_id . '",
							"' . $pekerjaan . '","' . $alamat . '","' . $alamat_rt . '","' . $alamat_rw . '","' . $kelurahan_id . '","' . $kecamatan_id . '","' . $kota_id . '","' . $propinsi_id . '","' . $kode_pos . '",
							"' . $no_telepon . '","' . $nama_ibu . '","' . $nama_ayah . '","' . $nama_suami_isteri . '","' . $nik . '","0","' . $user_name . '")') or die(mysql_error());
					}else{
						$no_penunjang = getNoPasienPenunjang();	
					}
			}else{
				if(strlen($no_penunjang) > 6){
					if($unit_id == 31 or $unit_id == 40 or $unit_id == 41 
					or $unit_id == 47 or $unit_id == 51){
						$no_penunjang = getNoMR('1');
						mysql_query('INSERT INTO m_pasien (NOMR,NAMA_PASIEN,TMP_LAHIR,TGL_LAHIR,JNS_KELAMIN,ST_KAWIN,AGAMA_ID,PENDIDIKAN_ID,PEKERJAAN,ALAMAT,ALAMAT_RT,ALAMAT_RW,
							KELURAHAN_ID,KECAMATAN_ID,KOTA_ID,PROPINSI_ID,KODE_POS,NO_TELEPON,NAMA_IBU,NAMA_AYAH,NAMA_SUAMI_ISTERI,NIK,KHUSUS,USER_PENDAFTARAN) 
							VALUES ("' . $no_penunjang . '","' . strtoupper($nama_pasien) . '","' . $tmp_lahir . '",' . fieldDate($tgl_lahir) . ',"' . $jns_kelamin . '","' . $st_kawin . '","' . $agama_id . '","' . $pendidikan_id . '",
							"' . $pekerjaan . '","' . $alamat . '","' . $alamat_rt . '","' . $alamat_rw . '","' . $kelurahan_id . '","' . $kecamatan_id . '","' . $kota_id . '","' . $propinsi_id . '","' . $kode_pos . '",
							"' . $no_telepon . '","' . $nama_ibu . '","' . $nama_ayah . '","' . $nama_suami_isteri . '","' . $nik . '","0","' . $user_name . '")') or die(mysql_error());
					}		
				}else{
					
					mysql_query('UPDATE m_pasien SET NAMA_PASIEN = "' . strtoupper($nama_pasien) . '",TMP_LAHIR = "' . $tmp_lahir . '",TGL_LAHIR = ' . fieldDate($tgl_lahir) . ',
							JNS_KELAMIN = "' . $jns_kelamin . '",ST_KAWIN = "' . $st_kawin . '",AGAMA_ID = "' . $agama_id . '",PENDIDIKAN_ID = "' . $pendidikan_id . '",
							PEKERJAAN = "' . $pekerjaan . '",ALAMAT = "' . $alamat . '",ALAMAT_RT = "' . $alamat_rt . '",ALAMAT_RW = "' . $alamat_rw . '",
							KELURAHAN_ID = "' . $kelurahan_id . '",KECAMATAN_ID = "' . $kecamatan_id . '",KOTA_ID = "' . $kota_id . '",PROPINSI_ID = "' . $propinsi_id . '",
							KODE_POS = "' . $kode_pos . '",NO_TELEPON = "' . $no_telepon . '",NAMA_IBU = "' . $nama_ibu . '",NAMA_AYAH = "' . $nama_ayah . '",
							NAMA_SUAMI_ISTERI = "' . $nama_suami_isteri . '",NIK = "' . $nik . '",
							KHUSUS = "0", USER_PENDAFTARAN = "' . $user_name . '"
							WHERE NOMR = "' . $no_penunjang . '"') or die(mysql_error());
				}
			}	
				
            $st_save = mysql_query('INSERT INTO t_ipenunjang (JNS_PENUNJANG,JNS_ORDER,ST_BARU,JENIS_BAYAR_ID,TANGGAL_ORDER,
				NOMR,NAMA_PASIEN,TMP_LAHIR,TGL_LAHIR,JNS_KELAMIN,ST_KAWIN,AGAMA_ID,PENDIDIKAN_ID,PEKERJAAN,ALAMAT,ALAMAT_RT,ALAMAT_RW,
				KELURAHAN_ID,KECAMATAN_ID,KOTA_ID,PROPINSI_ID,KODE_POS,NO_TELEPON,NAMA_IBU,NAMA_AYAH,NAMA_SUAMI_ISTERI,NIK,USER_ORDER,
				DESKRIPSI,PENGIRIM,INSTANSI_PENGIRIM,NO_ORDER,ALAMAT_INSTANSI_PENGIRIM,NO_TELP_INSTANSI_PENGIRIM,TANGGAL_PERMINTAAN,
				DIAGNOSA_PENGIRIM,UNIT_ID,NO_PASIEN_PENUNJANG) 
				VALUES ("PNJ","APS",' . $st_baru . ',"' . $jenis_bayar_id . '",NOW(),"******","' . strtoupper($nama_pasien) . '","' . $tmp_lahir . '",' . fieldDate($tgl_lahir) . ',"' . $jns_kelamin . '","' . $st_kawin . '","' . $agama_id . '","' . $pendidikan_id . '",
				"' . $pekerjaan . '","' . $alamat . '","' . $alamat_rt . '","' . $alamat_rw . '","' . $kelurahan_id . '","' . $kecamatan_id . '","' . $kota_id . '","' . $propinsi_id . '","' . $kode_pos . '",
				"' . $no_telepon . '","' . $nama_ibu . '","' . $nama_ayah . '","' . $nama_suami_isteri . '","' . $nik . '","' . $user_name . '",NULL,
				"' . $dokter_pengirim . '", "' . $instansi_pengirim . '","' . $nomor . '",
				"' . $alamat_instansi_pengirim . '","' . $telp_instansi_pengirim . '",' . fieldDate($tgl_permintaan) . ',"' . $diagnosa . '","' . $unit_id . '",
				"' . $no_penunjang . '")') or die(mysql_error());
        }
        if ($st_save) {
            if (empty($penunjang_id)) {
				$rsl = mysql_query('SELECT PENUNJANG_ID FROM t_ipenunjang ORDER BY PENUNJANG_ID DESC LIMIT 1');
                $get = mysql_fetch_assoc($rsl);
                $penunjang_id = $get['PENUNJANG_ID'];
            }
        }
    }

if (empty($_err)) {
        ?>
        <script language="JavaScript" >
            window.location = "index.php?link=8d65b645a689626650a49a7cb88622a0&&idx=<?php echo $penunjang_id; ?>&ord=aps";
        </script> 
        <?php
} else {
    $msg_info = $_err;
}
?>
