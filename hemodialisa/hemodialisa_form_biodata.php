<?php
if($jns_order == 'aps'){
	$sql_pasien = 'SELECT t_hemodialisa.HEMODIALISA_ID AS PASIEN_ID,t_hemodialisa.NO_PASIEN_PENUNJANG AS NOMR,t_hemodialisa.NAMA_PASIEN,t_hemodialisa.TMP_LAHIR,t_hemodialisa.TGL_LAHIR,t_hemodialisa.JNS_KELAMIN,t_hemodialisa.ST_KAWIN,
				t_hemodialisa.AGAMA_ID,t_hemodialisa.PENDIDIKAN_ID,t_hemodialisa.PEKERJAAN,t_hemodialisa.ALAMAT,t_hemodialisa.ALAMAT_RT,t_hemodialisa.ALAMAT_RW,t_hemodialisa.KELURAHAN_ID,
				t_hemodialisa.KECAMATAN_ID,t_hemodialisa.KOTA_ID,t_hemodialisa.PROPINSI_ID,t_hemodialisa.KODE_POS,t_hemodialisa.NO_TELEPON,t_hemodialisa.NAMA_IBU,t_hemodialisa.NAMA_AYAH,
				t_hemodialisa.NAMA_SUAMI_ISTERI,t_hemodialisa.NIK,t_hemodialisa.KHUSUS,m_agama.NAMA_AGAMA,m_pendidikan.NAMA_PENDIDIKAN,
				m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,m_propinsi.NAMA_PROPINSI
				FROM t_hemodialisa
				  LEFT JOIN m_agama ON (t_hemodialisa.AGAMA_ID = m_agama.AGAMA_ID)
				  LEFT JOIN m_pendidikan ON (t_hemodialisa.PENDIDIKAN_ID = m_pendidikan.PENDIDIKAN_ID)
				  LEFT JOIN m_kelurahan ON (t_hemodialisa.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				  LEFT JOIN m_kecamatan ON (t_hemodialisa.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				  LEFT JOIN m_kota ON (t_hemodialisa.KOTA_ID = m_kota.KOTA_ID)
				  LEFT JOIN m_propinsi ON (t_hemodialisa.PROPINSI_ID = m_propinsi.PROPINSI_ID) WHERE t_hemodialisa.HEMODIALISA_ID = "' . $idx . '"';
}else{	
   $sql_pasien = 'SELECT m_pasien.PASIEN_ID,m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TMP_LAHIR,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ST_KAWIN,
				m_pasien.AGAMA_ID,m_pasien.PENDIDIKAN_ID,m_pasien.PEKERJAAN,m_pasien.ALAMAT,m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_pasien.KELURAHAN_ID,
				m_pasien.KECAMATAN_ID,m_pasien.KOTA_ID,m_pasien.PROPINSI_ID,m_pasien.KODE_POS,m_pasien.NO_TELEPON,m_pasien.NAMA_IBU,m_pasien.NAMA_AYAH,
				m_pasien.NAMA_SUAMI_ISTERI,m_pasien.NIK,m_pasien.KHUSUS,m_agama.NAMA_AGAMA,m_pendidikan.NAMA_PENDIDIKAN,
				m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,m_propinsi.NAMA_PROPINSI
				FROM m_pasien
				  LEFT JOIN m_agama ON (m_pasien.AGAMA_ID = m_agama.AGAMA_ID)
				  LEFT JOIN m_pendidikan ON (m_pasien.PENDIDIKAN_ID = m_pendidikan.PENDIDIKAN_ID)
				  LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				  LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				  LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				  LEFT JOIN m_propinsi ON (m_pasien.PROPINSI_ID = m_propinsi.PROPINSI_ID) WHERE m_pasien.NOMR = "' . $nomr . '"';
}				  
    $get_pasien = mysql_query($sql_pasien);
    $dat_pasien = mysql_fetch_assoc($get_pasien);

    $nama_pasien = $dat_pasien['NAMA_PASIEN'];
    $tmp_lahir = $dat_pasien['TMP_LAHIR'];
    $tgl_lahir = changeDateFormat($dat_pasien['TGL_LAHIR']);
    $jns_kelamin = $dat_pasien['JNS_KELAMIN'];
    $st_kawin = $dat_pasien['ST_KAWIN'];
    $agama_id = $dat_pasien['NAMA_AGAMA'];
    $pendidikan_id = $dat_pasien['NAMA_PENDIDIKAN'];
    $pekerjaan_id = $dat_pasien['PEKERJAAN'];
    $alamat = $dat_pasien['ALAMAT'];
    $alamat_rt = $dat_pasien['ALAMAT_RT'];
    $alamat_rw = $dat_pasien['ALAMAT_RW'];
    $kelurahan_id = $dat_pasien['NAMA_KELURAHAN'];
    $kecamatan_id = $dat_pasien['NAMA_KECAMATAN'];
    $kota_id = $dat_pasien['NAMA_KOTA'];
    $propinsi_id = $dat_pasien['NAMA_PROPINSI'];
    $kode_pos = $dat_pasien['KODE_POS'];
    $no_telepon = $dat_pasien['NO_TELEPON'];
    $nama_ibu = $dat_pasien['NAMA_IBU'];
    $nama_ayah = $dat_pasien['NAMA_AYAH'];
    $nama_suami_isteri = $dat_pasien['NAMA_SUAMI_ISTERI'];
    $nik = $dat_pasien['NIK'];
   
	include('pasien/pasien_view.php');
	?>
	<br>