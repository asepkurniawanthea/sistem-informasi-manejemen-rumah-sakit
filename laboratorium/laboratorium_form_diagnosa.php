<?php
if (isset($_GET['idx']) and isset($_GET['ord']) and isset($_GET['no']) and isset($_GET['fr'])) {
    $idx = $_GET['idx'];
    $ord = $_GET['ord'];
	$no = $_GET['no'];
	$fr = $_GET['fr'];
    $selesai = '';
	
    if ($ord == 'irj') {
        $qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,t_ipenunjang.RAWAT_ID,m_pasien.NO_TELEPON,
				m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
				m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,t_ipenunjang.HEMODIALISA_ID,
				t_irja.ST_BARU,t_ipenunjang.OPERASI_ID
				FROM t_ipenunjang
				INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				WHERE t_ipenunjang.JNS_ORDER = "IRJ" AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang.RAWAT_ID = "' . $_GET['idx'] . '"
				AND t_ipenunjang_tarif.NO_TARIF ="' . $no . '"';
    } else if ($ord == 'irn') {
        $qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.RUANG_ID AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,t_ipenunjang.RAWAT_ID,m_pasien.NO_TELEPON,
				m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
				m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,t_ipenunjang.HEMODIALISA_ID,
				"" AS ST_BARU,t_ipenunjang.OPERASI_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				WHERE t_ipenunjang.JNS_ORDER = "IRN" AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang.RAWAT_ID = "' . $_GET['idx'] . '"
				AND t_ipenunjang_tarif.NO_TARIF ="' . $no . '"';
    } else if ($ord == 'aps') {
        $qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NAMA_PASIEN,t_ipenunjang.NO_PASIEN_PENUNJANG AS NOMR,t_ipenunjang.TGL_LAHIR,t_ipenunjang.ALAMAT,
				t_ipenunjang.INSTANSI_PENGIRIM AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN, "" AS RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.PENGIRIM AS NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,"" AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang.JNS_KELAMIN,t_ipenunjang.NIK,t_ipenunjang.NO_TELEPON,
				m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
				t_ipenunjang.ALAMAT_RT,t_ipenunjang.ALAMAT_RW,t_ipenunjang.HEMODIALISA_ID,
				t_ipenunjang.ST_BARU,t_ipenunjang.OPERASI_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				LEFT JOIN m_kelurahan ON (t_ipenunjang.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (t_ipenunjang.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (t_ipenunjang.KOTA_ID = m_kota.KOTA_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.JNS_ORDER = "APS" AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang.PENUNJANG_ID = "' . $_GET['idx'] . '"
				AND t_ipenunjang_tarif.NO_TARIF ="' . $no . '"';
	}else if ($ord == 'hrj') {
        $qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_unit.NAMA_UNIT,"-Hemodialisa"),m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,t_ipenunjang.RAWAT_ID,m_pasien.NO_TELEPON,
				m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
				m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,t_ipenunjang.HEMODIALISA_ID,
				t_irja.ST_BARU,t_ipenunjang.OPERASI_ID
				FROM t_ipenunjang
				INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				WHERE t_ipenunjang.JNS_ORDER = "HRJ" AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang.RAWAT_ID = "' . $_GET['idx'] . '"
				AND t_ipenunjang_tarif.NO_TARIF ="' . $no . '"';
	} else if ($ord == 'hri') {
        $qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT,"-Hemodialisa") AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.RUANG_ID AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,t_ipenunjang.RAWAT_ID,m_pasien.NO_TELEPON,
				m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
				m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,t_ipenunjang.HEMODIALISA_ID,
				"" AS ST_BARU,t_ipenunjang.OPERASI_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				WHERE t_ipenunjang.JNS_ORDER = "HRI" AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang.RAWAT_ID = "' . $_GET['idx'] . '"
				AND t_ipenunjang_tarif.NO_TARIF ="' . $no . '"';				
    }else if($ord == 'orj'){
		$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_unit.NAMA_UNIT,"-Kamar Operasi") AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,t_ipenunjang.RAWAT_ID,m_pasien.NO_TELEPON,
				m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
				m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,t_ipenunjang.HEMODIALISA_ID,
				t_irja.ST_BARU,t_ipenunjang.OPERASI_ID
				FROM t_ipenunjang
				INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				WHERE t_ipenunjang.JNS_ORDER = "ORJ" AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang.RAWAT_ID = "' . $_GET['idx'] . '"
				AND t_ipenunjang_tarif.NO_TARIF ="' . $no . '"';
	} else if ($ord == 'ori') {
        $qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT,"-Kamar Operasi") AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.RUANG_ID AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,t_ipenunjang.RAWAT_ID,m_pasien.NO_TELEPON,
				m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
				m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,t_ipenunjang.HEMODIALISA_ID,
				"" AS ST_BARU,t_ipenunjang.OPERASI_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				WHERE t_ipenunjang.JNS_ORDER = "ORI" AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang.RAWAT_ID = "' . $_GET['idx'] . '"
				AND t_ipenunjang_tarif.NO_TARIF ="' . $no . '"';			
	}
    $get_pasien = mysql_query($qry_pasien) or die(mysql_error());
    $dat_pasien = mysql_fetch_assoc($get_pasien);
    $nomr = $dat_pasien['NOMR'];
    $nama_pasien = $dat_pasien['NAMA_PASIEN'];
    $tgl_lahir = changeDateFormat($dat_pasien['TGL_LAHIR']);
    $jns_kelamin = $dat_pasien['JNS_KELAMIN'];
    $alamat = $dat_pasien['ALAMAT'] . ' ' . $dat_pasien['ALAMAT_RT'] . ' ' . $dat_pasien['ALAMAT_RW'] . ' ' . $dat_pasien['NAMA_KELURAHAN'] . ' ' . $dat_pasien['NAMA_KECAMATAN'] . ' ' . $dat_pasien['NAMA_KOTA'];
    $nik = $dat_pasien['NIK'];
    $jns_pembayaran = $dat_pasien['NAMA_JAMINAN'];

    $penunjang_id = $dat_pasien['PENUNJANG_ID'];
    $pegawai_id = $dat_pasien['NAMA_PEGAWAI'];
    $nama_unit = $dat_pasien['NAMA_UNIT'] . ' (' . $dat_pasien['NAMA_PEGAWAI'] . ')';
    $tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
    $rawat_id = $dat_pasien['RAWAT_ID'];
	
	$no_telepon = $dat_pasien['NO_TELEPON'];
	$umur_daftar = getUmurDaftar($tgl_lahir,$tgl_daftar);
	if($dat_pasien['ST_BARU'] == '1') $tgl_daftar = $tgl_daftar . ' (Pasien Baru)'; 
	$hemodialisa_id = $dat_pasien['HEMODIALISA_ID']; 
	$operasi_id = $dat_pasien['OPERASI_ID']; 

	function cekNilaiRujukan($d,$r){
		$ret = false;
		$r_array_1 = explode('|',$r);
		if(count($r_array_1) > 1){
			$r_array_2 = explode('-',$r_array_1[1]);
			if(count($r_array_2) > 1){
				$r_1 = trim(str_replace(' ','',$r_array_2[0]));
				$r_2 = trim(str_replace(' ','',$r_array_2[1]));
				
				$d = trim(str_replace(',','.',$d));

				if(is_numeric($r_1) and is_numeric($r_2) and is_numeric($d)){ 
					if(($d >= $r_1) and ($d <= $r_2)) $ret = true;
				}
			}	
		}else{
			$ret = true;
		}
		$ret = true;
		return $ret;
	}
	
    if (isset($_POST['penunjang_id']))
        include('laboratorium/laboratorium_save_diagnosa.php');	
    ?>
    <div style=" height:auto; padding:15px; ">

        <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
            <?php include('pasien/pasien_view_short.php'); ?>
            <div style=" width:250px; float:left; text-indent:25px; " align="left">Klinik/Ruang/Instansi</div>
            <div style=" width:20px; float:left; ">:</div>
            <div style=" width:400px; float:left; text-indent:5px; " align="left"><?php echo $nama_unit; ?></div>
            <div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $tgl_daftar; ?></div>
            <div style=" width:20px; float:right; ">:</div>
            <div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Daftar</div><br><br>
            <?php
            if($ord == 'irj' or $ord == 'orj'){
				$qry_diagnosa = 'SELECT t_irja_diagnosa.DIAGNOSA,
								CASE WHEN TRIM(t_irja_diagnosa.DIAGNOSA) = TRIM(m_icd_x.DESKRIPSI) THEN t_irja_diagnosa.ICD_CODE
								ELSE CONCAT(t_irja_diagnosa.ICD_CODE,"--",m_icd_x.DESKRIPSI) END AS ICD
								FROM t_irja_diagnosa
								LEFT JOIN m_icd_x ON (t_irja_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
								WHERE t_irja_diagnosa.IRJA_ID = "' . $rawat_id . '"
								ORDER BY t_irja_diagnosa.DIAGNOSA_ORDER';
			} else if($ord == 'irn' or $ord == 'ori'){
				$qry_diagnosa = 'SELECT t_irna_diagnosa.DIAGNOSA,
								CASE WHEN TRIM(t_irna_diagnosa.DIAGNOSA) = TRIM(m_icd_x.DESKRIPSI) THEN t_irna_diagnosa.ICD_CODE
								ELSE CONCAT(t_irna_diagnosa.ICD_CODE,"--",m_icd_x.DESKRIPSI) END AS ICD
								FROM t_irna_diagnosa
								LEFT JOIN m_icd_x ON (t_irna_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
								WHERE t_irna_diagnosa.IRNA_ID = "' . $rawat_id . '"
								ORDER BY t_irna_diagnosa.DIAGNOSA_ORDER';
			} else if($ord == 'aps'){
				$qry_diagnosa = 'SELECT t_ipenunjang.DIAGNOSA_PENGIRIM AS DIAGNOSA, "" AS ICD
								FROM t_ipenunjang WHERE PENUNJANG_ID = "' . $idx. '"';
			} else if($ord == 'hrj'){
				$qry_diagnosa = 'SELECT t_hemodialisa_diagnosa.DIAGNOSA,
								CASE WHEN TRIM(t_hemodialisa_diagnosa.DIAGNOSA) = TRIM(m_icd_x.DESKRIPSI) THEN t_hemodialisa_diagnosa.ICD_CODE
								ELSE CONCAT(t_hemodialisa_diagnosa.ICD_CODE,"--",m_icd_x.DESKRIPSI) END AS ICD
								FROM t_hemodialisa_diagnosa
								LEFT JOIN m_icd_x ON (t_hemodialisa_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
								WHERE t_hemodialisa_diagnosa.HEMODIALISA_ID = "' . $hemodialisa_id . '"
								ORDER BY t_hemodialisa_diagnosa.DIAGNOSA_ORDER';
			} else if($ord == 'hri'){
				$qry_diagnosa = 'SELECT t_hemodialisa_diagnosa.DIAGNOSA,
								CASE WHEN TRIM(t_hemodialisa_diagnosa.DIAGNOSA) = TRIM(m_icd_x.DESKRIPSI) THEN t_hemodialisa_diagnosa.ICD_CODE
								ELSE CONCAT(t_hemodialisa_diagnosa.ICD_CODE,"--",m_icd_x.DESKRIPSI) END AS ICD
								FROM t_hemodialisa_diagnosa
								LEFT JOIN m_icd_x ON (t_hemodialisa_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
								WHERE t_hemodialisa_diagnosa.HEMODIALISA_ID = "' . $hemodialisa_id . '"
								ORDER BY t_hemodialisa_diagnosa.DIAGNOSA_ORDER';					
			}

            $get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
            $i = 0;
			
            ?>
            	<div style=" width:250px; float:left; text-indent:25px; " align="left">Diagnosa</div>
	<div style=" width:20px; float:left; ">:</div>
	
<?php
if(mysql_num_rows($get_diagnosa) > 0){
while($dat_diagnosa = mysql_fetch_array($get_diagnosa)){
if($i == 0){
?>
	<div style=" width:450px; float:left; text-indent:5px; " align="left"><?php echo $i + 1; echo '. ' . $dat_diagnosa['DIAGNOSA'] . ' ' . $dat_diagnosa['ICD']; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><i><?php echo $umur_daftar; ?></i></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left"><i>Umur</i></div><br><br>
<?php
}else{
?>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:450px; float:left; text-indent:5px; " align="left"><?php echo $i + 1; echo '. ' . $dat_diagnosa['DIAGNOSA'] . ' ' . $dat_diagnosa['ICD']; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
<?php }
$i++; }	
}else{				
?>
<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><i><?php echo $umur_daftar; ?></i></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left"><i>Umur</i></div><br>
<?php } ?>
        </div>
<form name="search" id="form_edit" method="post" autocomplete="off">
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php
$tgl_sampling = date('d/m/Y');
$jam_sampling = date('H');
$menit_sampling = date('i');
		
$tgl_hasil = date('d/m/Y');
$jam_hasil = date('H');
$menit_hasil = date('i');

$catatan_spesimen = '';
$pemeriksa = '';
$dokter = '';
$hasil_tes_kritis = '';

if($ord != 'aps'){
$sql_tarif  = 'SELECT DISTINCT m_tarif_pemeriksaan.CH_REPORT,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d/%m/%Y") AS TANGGAL_SAMPLING,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%H") AS JAM_SAMPLING,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%i") AS MENIT_SAMPLING,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y") AS TANGGAL_PERIKSA,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%H") AS JAM_PERIKSA,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%i") AS MENIT_PERIKSA,
					t_ipenunjang_tarif.CATATAN_SPESIMEN,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,
					t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d/%m/%Y") AS TANGGAL_JAM_SAMPLING,
					t_ipenunjang_tarif.HASIL_TES_KRITIS
					FROM t_ipenunjang
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
					WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
					AND t_ipenunjang.JNS_ORDER = "' . strtoupper($ord) . '"	
					AND t_ipenunjang_tarif.NO_TARIF = "' . $no . '"		
					AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
					OR m_tarif.UNIT_ID = "45")
					AND m_tarif_pemeriksaan.FORM_HASIL = "' . $fr . '"
					ORDER BY m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID';
}else{
$sql_tarif  = 'SELECT DISTINCT m_tarif_pemeriksaan.CH_REPORT,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d/%m/%Y") AS TANGGAL_SAMPLING,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%H") AS JAM_SAMPLING,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%i") AS MENIT_SAMPLING,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y") AS TANGGAL_PERIKSA,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%H") AS JAM_PERIKSA,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%i") AS MENIT_PERIKSA,
					t_ipenunjang_tarif.CATATAN_SPESIMEN,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,
					t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d/%m/%Y") AS TANGGAL_JAM_SAMPLING,
					t_ipenunjang_tarif.HASIL_TES_KRITIS
					FROM t_ipenunjang
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
					WHERE t_ipenunjang.PENUNJANG_ID = "' . $idx . '"
					AND t_ipenunjang_tarif.NO_TARIF = "' . $no . '"		
					AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
					OR m_tarif.UNIT_ID = "45")
					AND m_tarif_pemeriksaan.FORM_HASIL = "' . $fr . '"
					ORDER BY m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID';
}	
$get_tarif = mysql_query($sql_tarif) or die(mysql_error());	
?>
<table border="1" class="tableData" id="tfhover" >
 <tr>
	<?php if($fr == '1'){ ?>
	<th width="20">No</th>
	<th colspan="3">Jenis Pemeriksaan</th>
	<th width="200">Hasil</th>
	<th width="80">Satuan</th>
	<th width="150">Nilai Rujukan</th>
	<?php }else if($fr == '2'){ ?>
	<th width="20">No</th>
	<th colspan="3">Jenis Pemeriksaan</th>
	<th width="200">Hasil</th>
	<th width="150">Nilai Rujukan</th>
	<?php }else if($fr == '3'){ ?>
	<th width="20">No</th>
	<th colspan="3" >Jenis Pemeriksaan</th>
	<th width="200">Hasil</th>
 	<?php } ?>
	<th width="100">Nilai Kritis</th>
	<th width="80">Metode</th>
	<th width="104">Option</th>
  </tr>
<?php
	$i = 1;
	$x = 1;
	$id_counter = 1;
	while($dat_tarif = mysql_fetch_array($get_tarif)){
		?>
		<tr>
		<?php if($fr == '1'){ ?>
		<td width="20" align="center"><?php echo $i; ?></td>
		<td colspan="3"><strong><?php echo strtoupper($dat_tarif['CH_REPORT']); ?></strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<?php }else if($fr == '2'){ ?>
		<td width="20" align="center"><?php echo $i; ?></td>
		<td colspan="3"><strong><?php echo strtoupper($dat_tarif['CH_REPORT']); ?></strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<?php }else if($fr == '3'){ ?>
		<td width="20" align="center"><?php echo $i; ?></td>
		<td colspan="3"><strong><?php echo strtoupper($dat_tarif['CH_REPORT']); ?></strong></td>
		<td>&nbsp;</td>
		<?php } ?>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>	
	<?php 	
		if($ord == 'aps'){
		$sql_diagnosa = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID,m_tarif_pemeriksaan.CH_LEVEL,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_GROUP,m_tarif_pemeriksaan.NAMA_PEMERIKSAAN,m_tarif_pemeriksaan.REPORT_FORMAT,
				m_tarif_pemeriksaan.REPORT_ORDER,t_ipenunjang_tarif_pemeriksaan.SATUAN,t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN,
				t_ipenunjang_tarif_pemeriksaan.METHODE,t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN_ID,
				t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID,t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,
				m_tarif_pemeriksaan.CH_REPORT,m_tarif_pemeriksaan.TEXT_HASIL,m_tarif.KODE_TARIF
				FROM t_ipenunjang_tarif
				INNER JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN t_ipenunjang_tarif_pemeriksaan ON (m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID = t_ipenunjang_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID 
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID = 
				t_ipenunjang_tarif.PENUNJANG_TARIF_ID)
				LEFT JOIN m_nilai_rujukan_laboratorium ON (t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN_ID = m_nilai_rujukan_laboratorium.NILAI_RUJUKAN_ID)
				WHERE t_ipenunjang.PENUNJANG_ID = "' . $idx . '" AND t_ipenunjang_tarif.NO_TARIF = "' . $no . '"
				AND m_tarif_pemeriksaan.CH_REPORT = "' . $dat_tarif['CH_REPORT'] . '"
				AND m_tarif_pemeriksaan.FORM_HASIL = "' . $fr . '"
				ORDER BY m_tarif_pemeriksaan.KODE_TARIF,m_tarif_pemeriksaan.REPORT_ORDER';
		}else{
			$sql_diagnosa = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID,m_tarif_pemeriksaan.CH_LEVEL,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_GROUP,m_tarif_pemeriksaan.NAMA_PEMERIKSAAN,m_tarif_pemeriksaan.REPORT_FORMAT,
				m_tarif_pemeriksaan.REPORT_ORDER,t_ipenunjang_tarif_pemeriksaan.SATUAN,t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN,
				t_ipenunjang_tarif_pemeriksaan.METHODE,t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN_ID,
				t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID,t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,
				m_tarif_pemeriksaan.CH_REPORT,m_tarif_pemeriksaan.TEXT_HASIL,m_tarif.KODE_TARIF
				FROM t_ipenunjang_tarif
				INNER JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN t_ipenunjang_tarif_pemeriksaan ON (m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID = t_ipenunjang_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID 
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID = 
				t_ipenunjang_tarif.PENUNJANG_TARIF_ID)
				LEFT JOIN m_nilai_rujukan_laboratorium ON (t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN_ID = m_nilai_rujukan_laboratorium.NILAI_RUJUKAN_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" 
				AND t_ipenunjang.JNS_ORDER = "' . strtoupper($ord) . '"	
				AND t_ipenunjang_tarif.NO_TARIF = "' . $no . '"
				AND m_tarif_pemeriksaan.CH_REPORT = "' . $dat_tarif['CH_REPORT'] . '"
				AND m_tarif_pemeriksaan.FORM_HASIL = "' . $fr . '"
				ORDER BY m_tarif_pemeriksaan.KODE_TARIF,m_tarif_pemeriksaan.REPORT_ORDER';
		}		
        $get_diagnosa = mysql_query($sql_diagnosa) or die(mysql_error());
		$z = 1;
        $nama_pemeriksaan_group = '';
        $ret_selesai = true;
		
		while ($dat_diagnosa = mysql_fetch_array($get_diagnosa)) {
				if ($fr == '1'){
                            include('laboratorium/laboratorium_tmp_diagnosa_1.php');
                } else if ($fr == '2') {
                            include('laboratorium/laboratorium_tmp_diagnosa_2.php');
                } else if ($fr == '3') {
                            include('laboratorium/laboratorium_tmp_diagnosa_3.php');
                }
		$z++;
		$id_counter++;
        }		
$i++; 

if(!empty($dat_tarif['TANGGAL_SAMPLING'])) $tgl_sampling = $dat_tarif['TANGGAL_SAMPLING'];
if(!empty($dat_tarif['JAM_SAMPLING'])) $jam_sampling = $dat_tarif['JAM_SAMPLING'];
if(!empty($dat_tarif['MENIT_SAMPLING'])) $menit_sampling = $dat_tarif['MENIT_SAMPLING'];
		
if(!empty($dat_tarif['TANGGAL_PERIKSA'])) $tgl_hasil = $dat_tarif['TANGGAL_PERIKSA'];
if(!empty($dat_tarif['JAM_PERIKSA'])) $jam_hasil = $dat_tarif['JAM_PERIKSA'];
if(!empty($dat_tarif['MENIT_PERIKSA'])) $menit_hasil = $dat_tarif['MENIT_PERIKSA'];

$catatan_spesimen = $dat_tarif['CATATAN_SPESIMEN'];
$pemeriksa = $dat_tarif['PEGAWAI_PERIKSA_ID'];
$dokter = $dat_tarif['PEGAWAI_DIAGNOSA_ID'];
$hasil_tes_kritis = $dat_tarif['HASIL_TES_KRITIS'];
} 
?>
	<tr>
        <td colspan="10">&nbsp;</td>
    </tr>	
	<tr>
		<td>&nbsp;</td>
        <td colspan="3"><strong>Catatan Spesimen</strong></td>
        <td colspan="6"><textarea name="catatan_spesimen" id="catatan_spesimen" class="text_dt5" ><?php echo $catatan_spesimen; ?></textarea></td>
	<tr>
		<td>&nbsp;</td>
        <td colspan="3"><strong>Tanggal - Jam Terima Sample</strong></td>
        <td colspan="6">
			<input type="text" name="tgl_sampling" id="tgl_1" class="text_dt" value="<?php echo $tgl_sampling; ?>" size="10" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/>
			<select name="jam_sampling" id="jam_sampling" style="width:50px;" class="text_dt" >
			<?php echo getJam($jam_sampling); ?>
			</select>
			<select name="menit_sampling" id="menit_sampling" style="width:50px;" class="text_dt" >
			<?php echo getMenit($menit_sampling); ?>
			</select>
		</td>
    </tr>
	<tr>
		<td>&nbsp;</td>
        <td colspan="3"><strong>Tanggal - Jam Hasil</strong></td>
        <td colspan="6">
			<input type="text" name="tgl_hasil" id="tgl_2" class="text_dt" value="<?php echo $tgl_hasil; ?>" size="10" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>
			<select name="jam_hasil" id="jam_hasil" style="width:50px;" class="text_dt" >
			<?php echo getJam($jam_hasil); ?>
			</select>
			<select name="menit_hasil" id="menit_hasil" style="width:50px;" class="text_dt" >
			<?php echo getMenit($menit_hasil); ?>
			</select>	
		</td>
    </tr>
	<tr>
		<td>&nbsp;</td>
        <td colspan="3"><strong>Pemeriksa</strong></td>
        <td colspan="6"><select name="pemeriksa" id="pemeriksa" style="width:328px;" class="text_dt" >
		<option value="" > - </option>
		<?php 
		if(empty($pemeriksa)) $pemeriksa = $_SESSION['SES_SIMRS_PEGAWAI_ID'];
		echo getPelaksanaPenunjang($pemeriksa, '45'); ?>
		</select>
		</td>
    </tr>
	<tr>
		<td>&nbsp;</td>
        <td colspan="3"><strong>Dokter Penaggungjawab</strong></td>
        <td colspan="6"><select name="dokter" id="dokter" style="width:328px;" class="text_dt" >
		<?php echo getDokter($dokter,'45'); ?>
		</select>
		</td>
    </tr>
	<tr>
		<td>&nbsp;</td>
        <td colspan="3"><strong>Hasil Tes Kritis</strong></td>
        <td colspan="6">
			<input type="checkbox" name="hasil_tes_kritis" value="1" 
			<?php if($hasil_tes_kritis == '1') echo 'checked="checked"'; ?> />
		</td>
    </tr>
	 <tr>
        <td colspan="10" align="right">
            <input type="button" name="simpan" value="simpan" class="myButton1" onclick="javascript : simpan_hasil();" />
			<input type="button" value="print hasil" class="myButton1" onclick="javascript : print_hasil('<?php echo $idx; ?>','<?php echo $ord; ?>','<?php echo $no; ?>','<?php echo $fr; ?>');return false;" />
			<input type="button" value="print hasil [PDF]" class="myButton1" onclick="javascript : print_hasil_pdf('<?php echo $idx; ?>','<?php echo $ord; ?>','<?php echo $no; ?>','<?php echo $fr; ?>');return false;" />
			<input type="button" value="tutup" class="myButton1" onclick="javascript : selesaikan('index.php?link=<?php echo md5('laboratoriumformperiksa'); ?>&idx=<?php echo $idx; ?>&ord=<?php echo $_GET['ord']; ?>&no=<?php echo $no; ?>');return false;" /></td>
      </tr>	
</table>
</div>
<input type="hidden" name="cnz" value="<?php echo $id_counter; ?>" />
<input type="hidden" name="ord" value="<?php echo $_GET['ord']; ?>" />
<input type="hidden" name="penunjang_id" value="<?php echo $penunjang_id; ?>" />
<input type="hidden" name="rawat_id" value="<?php echo $idx; ?>" />
<input type="hidden" name="no_tarif" value="<?php echo $no; ?>" />
</form>
</div>
<?php } 
?>
<div id="hapushasil"></div>
<script language="JavaScript" >
    function simpan_hasil(){
		document.getElementById('form_edit').submit();
	}
	
	function selesaikan(link){
        window.location = link;
    }
	
	function print_hasil(idx,ord,no,fr){
		var print = prompt("Jumlah Copy", "1");
		if (print != null) {
			window.open('http://localhost/nsimrs_print_lab/print_hasil_laboratorium.php?idx=' + idx + '&ord=' + ord + '&no=' + no + '&print=' + print + '&fr=' + fr + '&by=<?php echo $_SESSION['SES_SIMRS_NAMA_PEGAWAI']; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
		}
	}
	
	function print_hasil_pdf(idx,ord,no,fr){
		window.open('index.php?print=hasillaboratorium&idx=' + idx + '&ord=' + ord + '&nomor=' + no + '&form=' + fr + '&nomr=<?php echo $nomr; ?>','_blank');
	}
	
	function riwayat(chreport,group,pemeriksaan){
		window.open('index.php?popup=laboratoriumformriwayat&nomr=<?php echo $nomr; ?>&rpt=' + chreport + '&grp=' + group + '&pmr=' + pemeriksaan,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=250');
	}
	
	function hapus_hasil(idp,pemeriksaan){
		if(confirm(pemeriksaan +' Hasil Diagnosa Dihapus ?')){
			MyAjaxRequest('hapushasil','index.php?ajaxrequest=laboratoriumhapushasil&idx=' + idp);	
			alert('Hasil Diagnosa Telah Dihapus.');
			window.location = '<?php echo currentURl(); ?>';
		}
	}
	
	$(function() {
            $('input:text:first').focus();
            var $inp = $('input:text');
            $inp.bind('keydown', function(e) {
                //var key = (e.keyCode ? e.keyCode : e.charCode);
                var key = e.which;
                if (key == 13) {
                    e.preventDefault();
                    var nxtIdx = $inp.index(this) + 1;
                    $(":input:text:eq(" + nxtIdx + ")").focus();
                }
            });
        });
</script>
