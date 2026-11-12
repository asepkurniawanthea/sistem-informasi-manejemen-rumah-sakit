<?php
function cekxNilaiRujukan($d, $r) {
    $ret = false;

    if (strtolower($r) == 'negatif') {
        $diag_array = explode('|!|', $d);
        if (sizeof($diag_array) == 5) {
            if ((strtolower($diag_array[0]) == 'negatif') and (strtolower($diag_array[1]) == 'negatif')
                    and (strtolower($diag_array[2]) == 'negatif') and (strtolower($diag_array[3]) == 'negatif')
                    and (strtolower($diag_array[4]) == 'negatif')) {
                $ret = true;
            }
        } else {
            if (strtolower($d) == 'negatif')
                $ret = true;
        }
    }else if (cekxString('<', $r) == true) {

        $r_array_3 = explode('<', $r);
        if (sizeof($r_array_3) > 1) {
            if (!empty($r_array_3[0])) {
                $rl = $r_array_3[1];
                $rl = trim(str_replace(',', '.', $rl));
                $dl = trim(str_replace(',', '.', $d));
                if ($dl < $rl) {
                    $ret = true;
                }
            } else {
                $rl = trim(str_replace('<', '', $r));
                $rl = trim(str_replace(',', '.', $rl));
                $dl = trim(str_replace(',', '.', $d));
                if ($dl < $rl) {
                    $ret = true;
                }
            }
        }
    } else {
        $r_array_2 = explode('-', $r);
        if (sizeof($r_array_2) > 1) {
            $r_1 = trim(str_replace(' ', '', $r_array_2[0]));
            $r_2 = trim(str_replace(' ', '', $r_array_2[1]));

            $d = trim(str_replace(',', '.', $d));

            if (is_numeric($r_1) and is_numeric($r_2) and is_numeric($d)) {
                if (($d >= $r_1) and ($d <= $r_2))
                    $ret = true;
            }
        }else {
            $ret = true;
        }
    }
    return $ret;
}

function cekxString($s, $str) {
    $ret = false;
    $len = strlen($str);
    $x = 0;
    while ($x < $len) {
        if (substr($str, $x, 1) == $s) {
            $ret = true;
            break;
        }
        $x++;
    }
    return $ret;
}

function erm_laboratorium($idx,$ord,$nomor,$form,$by){
	global $rmfile_path;

	if($form == '1') $templatelab = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\laboratorium_form_1.docx');
	if($form == '2') $templatelab = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\laboratorium_form_2.docx');
	if($form == '3') $templatelab = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\laboratorium_form_3.docx');
	
	if($ord == 'aps'){
		$jns_perawatan = '1';
		$qry_lab = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,
			t_ipenunjang.PENUNJANG_ID AS RAWAT_ID,
			t_ipenunjang.NO_PASIEN_PENUNJANG AS NOMR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%Y/%m/%d") AS TANGGAL_DAFTAR_2,
			t_ipenunjang.NAMA_PASIEN AS NAMA_PASIEN,
			t_ipenunjang.JNS_KELAMIN AS JNS_KELAMIN,
			t_ipenunjang.NAMA_IBU AS NAMA_IBU,
			DATE_FORMAT(t_ipenunjang.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
			DATE_FORMAT(t_ipenunjang.TGL_LAHIR,"%Y/%m/%d") AS TGL_LAHIR_2,
			t_ipenunjang.ALAMAT AS ALAMAT,
			t_ipenunjang.NO_TELEPON AS NO_TELEPON,
			t_ipenunjang.INSTANSI_PENGIRIM AS NAMA_UNIT,
			t_ipenunjang.PENGIRIM AS DOKTER_PENGIRIM, 
			m_jaminan.NAMA_JAMINAN,t_ipenunjang_tarif.NO_PENUNJANG,t_ipenunjang_tarif.USER_DIAGNOSA,t_ipenunjang_tarif.USER_PERIKSA,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_DIAGNOSA,t_ipenunjang_tarif.NO_TP,
			m_pegawai.NAMA_PEGAWAI,m_pegawai3.NAMA_PEGAWAI AS DOKTER_PENANGGUNGJAWAB,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d-%m-%Y %H:%i:%s") AS TANGGAL_SAMPLING,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_HASIL,
			t_ipenunjang_tarif.CATATAN_SPESIMEN,
			m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
			t_ipenunjang.ALAMAT_RT,t_ipenunjang.ALAMAT_RW,
			t_ipenunjang.ST_BARU,
			DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d-%m-%Y %H:%i:%s") AS TANGGAL_ORDER
			FROM t_ipenunjang 
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
			INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
			INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai3 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai3.PEGAWAI_ID)
			LEFT JOIN m_kelurahan ON (t_ipenunjang.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (t_ipenunjang.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			LEFT JOIN m_kota ON (t_ipenunjang.KOTA_ID = m_kota.KOTA_ID)
			WHERE t_ipenunjang.PENUNJANG_ID = "' . $idx . '"
			AND m_tarif_pemeriksaan.FORM_HASIL = "' . $form . '"
			ORDER BY t_ipenunjang_tarif.TANGGAL_DIAGNOSA';
	}else if($ord == 'irj'){
		$jns_perawatan = '1';
		$qry_lab = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,
			t_ipenunjang.RAWAT_ID,
			t_ipenunjang.NOMR AS NOMR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%Y/%m/%d") AS TANGGAL_DAFTAR_2,
			m_pasien.NAMA_PASIEN AS NAMA_PASIEN,
			m_pasien.JNS_KELAMIN AS JNS_KELAMIN,
			m_pasien.NAMA_IBU AS NAMA_IBU,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%Y/%m/%d") AS TGL_LAHIR_2,
			m_pasien.ALAMAT AS ALAMAT,
			m_pasien.NO_TELEPON AS NO_TELEPON,
			m_unit.NAMA_UNIT AS NAMA_UNIT,
			m_pegawai2.NAMA_PEGAWAI AS DOKTER_PENGIRIM, 
			m_jaminan.NAMA_JAMINAN,t_ipenunjang_tarif.NO_PENUNJANG,t_ipenunjang_tarif.USER_DIAGNOSA,t_ipenunjang_tarif.USER_PERIKSA,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_DIAGNOSA,t_ipenunjang_tarif.NO_TP,
			m_pegawai.NAMA_PEGAWAI,m_pegawai3.NAMA_PEGAWAI AS DOKTER_PENANGGUNGJAWAB,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d-%m-%Y %H:%i:%s") AS TANGGAL_SAMPLING,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_HASIL,
			t_ipenunjang_tarif.CATATAN_SPESIMEN,
			m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
			m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
			t_irja.ST_BARU,
			DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d-%m-%Y %H:%i:%s") AS TANGGAL_ORDER
			FROM t_ipenunjang
			INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)	
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
			INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
			INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
			LEFT JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
			LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai3 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai3.PEGAWAI_ID)
			LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
			WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" AND t_ipenunjang_tarif.NO_TARIF = "' . $nomor . '"
			AND t_ipenunjang.JNS_ORDER = "IRJ"
			AND m_tarif_pemeriksaan.FORM_HASIL = "' . $form . '"
			ORDER BY t_ipenunjang_tarif.TANGGAL_DIAGNOSA';	
	}else if($ord == 'irn'){
		$jns_perawatan = '2';
		$qry_lab = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,
			t_ipenunjang.RAWAT_ID,
			t_ipenunjang.NOMR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%Y/%m/%d") AS TANGGAL_DAFTAR_2,
			m_pasien.NAMA_PASIEN AS NAMA_PASIEN,
			m_pasien.JNS_KELAMIN AS JNS_KELAMIN,
			m_pasien.NAMA_IBU AS NAMA_IBU,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%Y/%m/%d") AS TGL_LAHIR_2,
			m_pasien.ALAMAT AS ALAMAT,
			m_pasien.NO_TELEPON AS NO_TELEPON,
			CONCAT(m_ruang.NAMA_RUANG," Kelas ",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,
			m_pegawai2.NAMA_PEGAWAI AS DOKTER_PENGIRIM, 
			m_jaminan.NAMA_JAMINAN,t_ipenunjang_tarif.NO_PENUNJANG,t_ipenunjang_tarif.USER_DIAGNOSA,t_ipenunjang_tarif.USER_PERIKSA,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_DIAGNOSA,t_ipenunjang_tarif.NO_TP,
			m_pegawai.NAMA_PEGAWAI,m_pegawai3.NAMA_PEGAWAI AS DOKTER_PENANGGUNGJAWAB,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d-%m-%Y %H:%i:%s") AS TANGGAL_SAMPLING,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_HASIL,
			t_ipenunjang_tarif.CATATAN_SPESIMEN,
			m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
			m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
			"" AS ST_BARU,
			DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d-%m-%Y %H:%i:%s") AS TANGGAL_ORDER
			FROM t_ipenunjang 
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
			INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
			INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
			LEFT JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
			LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai3 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai3.PEGAWAI_ID)
			LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
			WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" AND t_ipenunjang_tarif.NO_TARIF = "' . $nomor . '"
			AND t_ipenunjang.JNS_ORDER = "IRN"
			AND m_tarif_pemeriksaan.FORM_HASIL = "' . $form . '"
			ORDER BY t_ipenunjang_tarif.TANGGAL_DIAGNOSA';	
	}else if($ord == 'hrj'){
		$jns_perawatan = '1';
		$qry_lab = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,
			t_ipenunjang.RAWAT_ID,
			t_ipenunjang.NOMR AS NOMR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%Y/%m/%d") AS TANGGAL_DAFTAR_2,
			m_pasien.NAMA_PASIEN AS NAMA_PASIEN,
			m_pasien.JNS_KELAMIN AS JNS_KELAMIN,
			m_pasien.NAMA_IBU AS NAMA_IBU,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%Y/%m/%d") AS TGL_LAHIR_2,
			m_pasien.ALAMAT AS ALAMAT,
			m_pasien.NO_TELEPON AS NO_TELEPON,
			CONCAT(m_unit.NAMA_UNIT,"-Hemodialisa") AS NAMA_UNIT,
			m_pegawai2.NAMA_PEGAWAI AS DOKTER_PENGIRIM, 
			m_jaminan.NAMA_JAMINAN,t_ipenunjang_tarif.NO_PENUNJANG,t_ipenunjang_tarif.USER_DIAGNOSA,t_ipenunjang_tarif.USER_PERIKSA,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_DIAGNOSA,t_ipenunjang_tarif.NO_TP,
			m_pegawai.NAMA_PEGAWAI,m_pegawai3.NAMA_PEGAWAI AS DOKTER_PENANGGUNGJAWAB,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d-%m-%Y %H:%i:%s") AS TANGGAL_SAMPLING,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_HASIL,
			t_ipenunjang_tarif.CATATAN_SPESIMEN,
			m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
			m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
			t_irja.ST_BARU,
			DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d-%m-%Y %H:%i:%s") AS TANGGAL_ORDER
			FROM t_ipenunjang
			INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)	
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
			INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
			INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
			LEFT JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
			LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai3 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai3.PEGAWAI_ID)
			LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
			WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" AND t_ipenunjang_tarif.NO_TARIF = "' . $nomor . '"
			AND t_ipenunjang.JNS_ORDER = "HRJ"
			AND m_tarif_pemeriksaan.FORM_HASIL = "' . $form . '"
			ORDER BY t_ipenunjang_tarif.TANGGAL_DIAGNOSA';	
	}else if($ord == 'hri'){
		$jns_perawatan = '2';
		$qry_lab = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,
			t_ipenunjang.RAWAT_ID,
			t_ipenunjang.NOMR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%Y/%m/%d") AS TANGGAL_DAFTAR_2,
			m_pasien.NAMA_PASIEN AS NAMA_PASIEN,
			m_pasien.JNS_KELAMIN AS JNS_KELAMIN,
			m_pasien.NAMA_IBU AS NAMA_IBU,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%Y/%m/%d") AS TGL_LAHIR_2,
			m_pasien.ALAMAT AS ALAMAT,
			m_pasien.NO_TELEPON AS NO_TELEPON,
			CONCAT(m_ruang.NAMA_RUANG," Kelas ",m_ruang.KELAS_RAWAT,"-Hemodialisa") AS NAMA_UNIT,
			m_pegawai2.NAMA_PEGAWAI AS DOKTER_PENGIRIM, 
			m_jaminan.NAMA_JAMINAN,t_ipenunjang_tarif.NO_PENUNJANG,t_ipenunjang_tarif.USER_DIAGNOSA,t_ipenunjang_tarif.USER_PERIKSA,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_DIAGNOSA,t_ipenunjang_tarif.NO_TP,
			m_pegawai.NAMA_PEGAWAI,m_pegawai3.NAMA_PEGAWAI AS DOKTER_PENANGGUNGJAWAB,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d-%m-%Y %H:%i:%s") AS TANGGAL_SAMPLING,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_HASIL,
			t_ipenunjang_tarif.CATATAN_SPESIMEN,
			m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
			m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
			"" AS ST_BARU,
			DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d-%m-%Y %H:%i:%s") AS TANGGAL_ORDER
			FROM t_ipenunjang 
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
			INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
			INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
			LEFT JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
			LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai3 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai3.PEGAWAI_ID)
			LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
			WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" AND t_ipenunjang_tarif.NO_TARIF = "' . $nomor . '"
			AND t_ipenunjang.JNS_ORDER = "HRI"
			AND m_tarif_pemeriksaan.FORM_HASIL = "' . $form . '"
			ORDER BY t_ipenunjang_tarif.TANGGAL_DIAGNOSA';			
	}else if($ord == 'ori'){
		$jns_perawatan = '2';
		$qry_lab = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,
			t_ipenunjang.RAWAT_ID,
			t_ipenunjang.NOMR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%Y/%m/%d") AS TANGGAL_DAFTAR_2,
			m_pasien.NAMA_PASIEN AS NAMA_PASIEN,
			m_pasien.JNS_KELAMIN AS JNS_KELAMIN,
			m_pasien.NAMA_IBU AS NAMA_IBU,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%Y/%m/%d") AS TGL_LAHIR_2,
			m_pasien.ALAMAT AS ALAMAT,
			m_pasien.NO_TELEPON AS NO_TELEPON,
			CONCAT(m_ruang.NAMA_RUANG," Kelas ",m_ruang.KELAS_RAWAT,"-Kamar Operasi") AS NAMA_UNIT,
			m_pegawai2.NAMA_PEGAWAI AS DOKTER_PENGIRIM, 
			m_jaminan.NAMA_JAMINAN,t_ipenunjang_tarif.NO_PENUNJANG,t_ipenunjang_tarif.USER_DIAGNOSA,t_ipenunjang_tarif.USER_PERIKSA,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_DIAGNOSA,t_ipenunjang_tarif.NO_TP,
			m_pegawai.NAMA_PEGAWAI,m_pegawai3.NAMA_PEGAWAI AS DOKTER_PENANGGUNGJAWAB,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d-%m-%Y %H:%i:%s") AS TANGGAL_SAMPLING,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_HASIL,
			t_ipenunjang_tarif.CATATAN_SPESIMEN,
			m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
			m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
			"" AS ST_BARU,
			DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d-%m-%Y %H:%i:%s") AS TANGGAL_ORDER
			FROM t_ipenunjang 
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
			INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
			INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
			LEFT JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
			LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai3 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai3.PEGAWAI_ID)
			LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
			WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" AND t_ipenunjang_tarif.NO_TARIF = "' . $nomor . '"
			AND t_ipenunjang.JNS_ORDER = "ORI"
			AND m_tarif_pemeriksaan.FORM_HASIL = "' . $form . '"
			ORDER BY t_ipenunjang_tarif.TANGGAL_DIAGNOSA';
	}else if($ord == 'orj'){
		$jns_perawatan = '1';
		$qry_lab = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,
			t_ipenunjang.RAWAT_ID,
			t_ipenunjang.NOMR AS NOMR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%Y/%m/%d") AS TANGGAL_DAFTAR_2,
			m_pasien.NAMA_PASIEN AS NAMA_PASIEN,
			m_pasien.JNS_KELAMIN AS JNS_KELAMIN,
			m_pasien.NAMA_IBU AS NAMA_IBU,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%Y/%m/%d") AS TGL_LAHIR_2,
			m_pasien.ALAMAT AS ALAMAT,
			m_pasien.NO_TELEPON AS NO_TELEPON,
			CONCAT(m_unit.NAMA_UNIT,"-Kamar Operasi") AS NAMA_UNIT,
			m_pegawai2.NAMA_PEGAWAI AS DOKTER_PENGIRIM, 
			m_jaminan.NAMA_JAMINAN,t_ipenunjang_tarif.NO_PENUNJANG,t_ipenunjang_tarif.USER_DIAGNOSA,t_ipenunjang_tarif.USER_PERIKSA,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_DIAGNOSA,t_ipenunjang_tarif.NO_TP,
			m_pegawai.NAMA_PEGAWAI,m_pegawai3.NAMA_PEGAWAI AS DOKTER_PENANGGUNGJAWAB,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d-%m-%Y %H:%i:%s") AS TANGGAL_SAMPLING,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_HASIL,
			t_ipenunjang_tarif.CATATAN_SPESIMEN,
			m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
			m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
			t_irja.ST_BARU,
			DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d-%m-%Y %H:%i:%s") AS TANGGAL_ORDER
			FROM t_ipenunjang
			INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)	
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
			INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
			INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
			LEFT JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
			LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai3 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai3.PEGAWAI_ID)
			LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
			WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" AND t_ipenunjang_tarif.NO_TARIF = "' . $nomor . '"
			AND t_ipenunjang.JNS_ORDER = "ORJ"
			AND m_tarif_pemeriksaan.FORM_HASIL = "' . $form . '"
			ORDER BY t_ipenunjang_tarif.TANGGAL_DIAGNOSA';			
	}
	
	$get_lab = mysql_query($qry_lab) or die(mysql_error());
	$dat_lab = mysql_fetch_assoc($get_lab);
	
	$rawat_id = $dat_lab['RAWAT_ID'];
	$nomr = $dat_lab['NOMR'];
    $nama_pasien = $dat_lab['NAMA_PASIEN'];
    $tgl_lahir = $dat_lab['TGL_LAHIR'];
    $jns_kelamin = $dat_lab['JNS_KELAMIN'];
    $alamat = trim($dat_lab['ALAMAT']) . ' ' . trim($dat_lab['ALAMAT_RT']) . '/' . trim($dat_lab['ALAMAT_RW']) . ' ' . trim($dat_lab['NAMA_KELURAHAN']) . ' ' . trim($dat_lab['NAMA_KECAMATAN']);
    if (!empty($dat_lab['NO_TELEPON']))
        $alamat = $alamat . ', Telp. ' . $dat_lab['NO_TELEPON'];
	$alamat = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($alamat))));
	
	$nama_unit = $dat_lab['NAMA_UNIT'];
    $nama_dokter = $dat_lab['DOKTER_PENGIRIM'];
    
	$tgl_sampling = $dat_lab['TANGGAL_SAMPLING'];
    $tgl_hasil = $dat_lab['TANGGAL_HASIL'];
    $tgl_diagnosa = $dat_lab['TANGGAL_DIAGNOSA'];
    $tgl_daftar = $dat_lab['TANGGAL_HASIL'];
    $tgl_order = $dat_lab['TANGGAL_ORDER'];

    $tgl_sampling = substr($tgl_sampling, 0, strlen($tgl_sampling) - 3);
    $tgl_hasil = substr($tgl_hasil, 0, strlen($tgl_hasil) - 3);

    $pemeriksa = $dat_lab['NAMA_PEGAWAI'];
    $penanggungjawab = $dat_lab['DOKTER_PENANGGUNGJAWAB'];

    $no_penunjang = $dat_lab['NO_TP'];
    $no_tp = $dat_lab['NO_TP'];

    $user_diagnosa = $dat_lab['USER_DIAGNOSA'];
    $catatan_spesimen = $dat_lab['CATATAN_SPESIMEN'];

    $st_baru = $dat_lab['ST_BARU'];
	
	$umur = getUmurDaftar($dat_lab['TGL_LAHIR'],$dat_lab['TANGGAL_DAFTAR']);
	$tgl_lahir = str_replace('/', '-', $tgl_lahir);
	
	$tgl_daftar_a = explode(' ', $tgl_daftar);
    $tanggal_daftar_array = explode('/', str_replace('-', '/', $tgl_daftar_a[0]));
    $tanggal_daftar_hari = $tanggal_daftar_array[0] + 0;
    $tanggal_daftar_bulan = $tanggal_daftar_array[1];
    
    $tanggal_daftar_bulan_nama['01'] = 'Januari';
	$tanggal_daftar_bulan_nama['02'] = 'Februari';
	$tanggal_daftar_bulan_nama['03'] = 'Maret';
	$tanggal_daftar_bulan_nama['04'] = 'April';
	$tanggal_daftar_bulan_nama['05'] = 'Mei';
	$tanggal_daftar_bulan_nama['06'] = 'Juni';
	$tanggal_daftar_bulan_nama['07'] = 'Juli';
	$tanggal_daftar_bulan_nama['08'] = 'Agustus';
	$tanggal_daftar_bulan_nama['09'] = 'September';
	$tanggal_daftar_bulan_nama['10'] = 'Oktober';
	$tanggal_daftar_bulan_nama['11'] = 'Nopember';
	$tanggal_daftar_bulan_nama['12'] = 'Desember';
    
    $tanggal_daftar_tahun = $tanggal_daftar_array[2];
    $tanggal_daftar = $tanggal_daftar_hari . ' ' . $tanggal_daftar_bulan_nama[$tanggal_daftar_bulan] . ' ' . $tanggal_daftar_tahun;
	
	if (strlen($nomr) == 8) {
        $rm1 = substr($nomr, 0, 4);
        $rm2 = substr($nomr, 4, 4);
        $nomr = $rm1 . '-' . $rm2;
    }

    if (strlen($nomr) == 6) {
        $rm1 = substr($nomr, 0, 2);
        $rm2 = substr($nomr, 2, 2);
        $rm3 = substr($nomr, 4, 2);
        $nomr = $rm1 . '-' . $rm2 . '-' . $rm3;
    }
	
	if ($jns_kelamin == 'L')
        $jns_kelamin = 'Laki-laki';
    if ($jns_kelamin == 'P')
        $jns_kelamin = 'Perempuan';

    $asal_pasien = $nama_unit;
    if ($ord == 'aps') {
        $asal_pasien = 'Permintaan Sendiri';
        $no_penunjang = 'APS/' . $no_penunjang;
    }
    if ($nama_unit == 'IGD') {
        $no_penunjang = 'IGD/' . $no_penunjang;
    }
    if (($nama_unit != 'IGD') and ($ord == 'irj')) {
        $asal_pasien = 'Poliklinik ' . $asal_pasien;
        $no_penunjang = 'RJ/' . $no_penunjang;
    }
    if ($ord == 'irn') {
        $no_penunjang = 'RI/' . $no_penunjang;
    }

    if ($st_baru == '1')
        $asal_pasien = $asal_pasien . ' (Pasien Baru)';
	
	$tgl_order_array = explode(' ', $tgl_order);
	$tanggal_order = $tgl_order_array[0];
	$jam_order = $tgl_order_array[1];
	
	$tgl_hasil_array = explode(' ', $tgl_hasil);
	$tgl_hasil_nya = $tgl_hasil_array[0];
	$jam_hasil = $tgl_hasil_array[1];

	$tgl_sampling_array = explode(' ', $tgl_sampling);
	$tgl_sampling_nya = $tgl_sampling_array[0];
	$jam_sampling = $tgl_sampling_array[1];
	
	
	$templatelab->setValue('nomor', $no_penunjang);
	$templatelab->setValue('nomor_mr', $nomr);
	$templatelab->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templatelab->setValue('tanggal_lahir', $tgl_lahir);
	$templatelab->setValue('jenis_kelamin', $jns_kelamin);
	$templatelab->setValue('alamat', htmlspecialchars($alamat));
	$templatelab->setValue('permintaan_tanggal', $tanggal_order . ' Jam : ' . $jam_order);
	$templatelab->setValue('asal', htmlspecialchars($asal_pasien));
	$templatelab->setValue('dokter_pengirim', htmlspecialchars($nama_dokter));
	$templatelab->setValue('dokter_laboratorium', htmlspecialchars($penanggungjawab));
	$templatelab->setValue('nama_pemeriksa', htmlspecialchars($pemeriksa));
	$templatelab->setValue('tanggal', $tanggal_daftar);
	$templatelab->setValue('catatan', htmlspecialchars($catatan_spesimen));
	$templatelab->setValue('tanggal_selesai', $tgl_hasil_nya . '  Jam : ' . $jam_hasil);
	$templatelab->setValue('tanggal_spesimen', $tgl_sampling_nya . '  Jam : ' . $jam_sampling);
	
	$tanggal = date('d-m-Y');
    $jam = date('H:i:s');
	$templatelab->setValue('dicetak_oleh', htmlspecialchars($by) . ' ' . $tanggal. '  ' . $jam);
	
	if($ord != 'aps'){
		$qry_lab_detail = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID,m_tarif_pemeriksaan.CH_LEVEL,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_GROUP,m_tarif_pemeriksaan.NAMA_PEMERIKSAAN,m_tarif_pemeriksaan.REPORT_FORMAT,
				m_tarif_pemeriksaan.REPORT_ORDER,t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID,
				t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,m_tarif_pemeriksaan.CH_REPORT,t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN,
				t_ipenunjang_tarif_pemeriksaan.METHODE,t_ipenunjang_tarif_pemeriksaan.SATUAN,m_tarif_pemeriksaan.TEXT_HASIL,
				m_tarif.KODE_TARIF
				FROM t_ipenunjang_tarif
				INNER JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN t_ipenunjang_tarif_pemeriksaan ON (m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID = t_ipenunjang_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID 
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID = 
				t_ipenunjang_tarif.PENUNJANG_TARIF_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" 
				AND t_ipenunjang.JNS_ORDER = "' . strtoupper($ord) . '"	
				AND t_ipenunjang_tarif.NO_TARIF = "' . $nomor . '"
				AND m_tarif_pemeriksaan.FORM_HASIL = "' . $form . '"
				ORDER BY m_tarif_pemeriksaan.CH_REPORT,
				m_tarif_pemeriksaan.KODE_TARIF,
				m_tarif_pemeriksaan.REPORT_ORDER';
	}else{
		$qry_lab_detail = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID,m_tarif_pemeriksaan.CH_LEVEL,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_GROUP,m_tarif_pemeriksaan.NAMA_PEMERIKSAAN,m_tarif_pemeriksaan.REPORT_FORMAT,
				m_tarif_pemeriksaan.REPORT_ORDER,t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID,
				t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,m_tarif_pemeriksaan.CH_REPORT,t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN,
				t_ipenunjang_tarif_pemeriksaan.METHODE,t_ipenunjang_tarif_pemeriksaan.SATUAN,m_tarif_pemeriksaan.TEXT_HASIL,
				m_tarif.KODE_TARIF
				FROM t_ipenunjang_tarif
				INNER JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN t_ipenunjang_tarif_pemeriksaan ON (m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID = t_ipenunjang_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID 
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID = 
				t_ipenunjang_tarif.PENUNJANG_TARIF_ID)
				WHERE t_ipenunjang.PENUNJANG_ID = "' . $idx . '" 
				AND t_ipenunjang_tarif.NO_TARIF = "' . $nomor . '"
				AND m_tarif_pemeriksaan.FORM_HASIL = "' . $form . '"
				ORDER BY m_tarif_pemeriksaan.CH_REPORT,
				m_tarif_pemeriksaan.KODE_TARIF,
				m_tarif_pemeriksaan.REPORT_ORDER';
	}
	
	$get_lab_detail = mysql_query($qry_lab_detail) or die(mysql_error());
	$nama_pemeriksaan_report = '';
	$nama_pemeriksaan_group = '';
	$jml_row = 0;
	while($dat_lab_detail = mysql_fetch_array($get_lab_detail)){
		if ($nama_pemeriksaan_report != $dat_lab_detail['CH_REPORT']) {
			$nama_pemeriksaan_report = $dat_lab_detail['CH_REPORT'];
			$jml_row++; 	
		}
		
		$sm = true;
		if ($nama_pemeriksaan_group != $dat_lab_detail['NAMA_PEMERIKSAAN_GROUP']) {
			$nama_pemeriksaan_group = $dat_lab_detail['NAMA_PEMERIKSAAN_GROUP'];
			$sm = false;
		}
		
		if (!empty($dat_lab_detail['NAMA_PEMERIKSAAN_GROUP']) and $sm == false) $jml_row++; 	
		$jml_row++; 	
	};
	
	$templatelab->cloneRow('pemeriksaan_row', $jml_row);
	
	$tbl_center = '<w:tbl><w:tblPr><w:tblStyle w:val="TableGrid"/><w:tblW w:w="0" w:type="auto"/><w:tblBorders><w:top w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:left w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:bottom w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:right w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:insideH w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:insideV w:val="none" w:sz="0" w:space="0" w:color="auto"/></w:tblBorders><w:tblLook w:val="04A0"/></w:tblPr><w:tblGrid><w:gridCol w:w="9576"/></w:tblGrid><w:tr w:rsidR="008625A1" w:rsidRPr="00B83DDE" w:rsidTr="002934D7"><w:tc><w:tcPr><w:tcW w:w="9576" w:type="dxa"/></w:tcPr><w:p w:rsidR="008625A1" w:rsidRPr="00B83DDE" w:rsidRDefault="000B0E14" w:rsidP="008A2F08"><w:pPr><w:jc w:val="center"/><w:rPr><w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr></w:pPr><w:r w:rsidRPr="00B83DDE"><w:rPr><w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr><w:t>${rpl_hasil}</w:t></w:r></w:p></w:tc></w:tr></w:tbl>';
		
	$tbl_left = '<w:tbl><w:tblPr><w:tblStyle w:val="TableGrid"/><w:tblW w:w="0" w:type="auto"/><w:tblBorders><w:top w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:left w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:bottom w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:right w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:insideH w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:insideV w:val="none" w:sz="0" w:space="0" w:color="auto"/></w:tblBorders><w:tblLook w:val="04A0"/></w:tblPr><w:tblGrid><w:gridCol w:w="9576"/></w:tblGrid><w:tr w:rsidR="008A2F08" w:rsidRPr="00B83DDE" w:rsidTr="002934D7"><w:tc><w:tcPr><w:tcW w:w="9576" w:type="dxa"/></w:tcPr><w:p w:rsidR="008A2F08" w:rsidRPr="00B83DDE" w:rsidRDefault="000B0E14" w:rsidP="008A2F08"><w:pPr><w:jc w:val="both"/><w:rPr><w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr></w:pPr><w:r w:rsidRPr="00B83DDE"><w:rPr><w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr><w:t>${rpl_hasil}</w:t></w:r></w:p></w:tc></w:tr></w:tbl>';
		
	$tbl_5col = '<w:tbl><w:tblPr><w:tblStyle w:val="TableGrid"/><w:tblW w:w="5000" w:type="pct"/><w:tblBorders><w:top w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:left w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:bottom w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:right w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:insideH w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:insideV w:val="none" w:sz="0" w:space="0" w:color="auto"/></w:tblBorders><w:tblLook w:val="04A0"/></w:tblPr><w:tblGrid><w:gridCol w:w="1916"/><w:gridCol w:w="1915"/><w:gridCol w:w="1915"/><w:gridCol w:w="1915"/><w:gridCol w:w="1915"/></w:tblGrid><w:tr w:rsidR="00814449" w:rsidRPr="00CF4E1A" w:rsidTr="00836523"><w:tc><w:tcPr><w:tcW w:w="1000" w:type="pct"/><w:vAlign w:val="center"/></w:tcPr><w:p w:rsidR="00814449" w:rsidRPr="00CF4E1A" w:rsidRDefault="00CF4E1A" w:rsidP="00814449"><w:pPr><w:jc w:val="center"/><w:rPr><w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr></w:pPr><w:r w:rsidRPr="00CF4E1A"><w:rPr><w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr><w:t>${rpl_hasil_1}</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="1000" w:type="pct"/><w:vAlign w:val="center"/></w:tcPr><w:p w:rsidR="00814449" w:rsidRPr="00CF4E1A" w:rsidRDefault="00CF4E1A" w:rsidP="00814449"><w:pPr><w:jc w:val="center"/><w:rPr><w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr></w:pPr><w:r w:rsidRPr="00CF4E1A"><w:rPr><w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr><w:t>${rpl_hasil_2}</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="1000" w:type="pct"/><w:vAlign w:val="center"/></w:tcPr><w:p w:rsidR="00814449" w:rsidRPr="00CF4E1A" w:rsidRDefault="00CF4E1A" w:rsidP="00814449"><w:pPr><w:jc w:val="center"/><w:rPr><w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr></w:pPr><w:r w:rsidRPr="00CF4E1A"><w:rPr><w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr><w:t>${rpl_hasil_3}</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="1000" w:type="pct"/><w:vAlign w:val="center"/></w:tcPr><w:p w:rsidR="00814449" w:rsidRPr="00CF4E1A" w:rsidRDefault="00CF4E1A" w:rsidP="00814449"><w:pPr><w:jc w:val="center"/><w:rPr><w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr></w:pPr><w:r w:rsidRPr="00CF4E1A"><w:rPr><w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr><w:t>${rpl_hasil_4}</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="1000" w:type="pct"/><w:vAlign w:val="center"/></w:tcPr><w:p w:rsidR="00814449" w:rsidRPr="00CF4E1A" w:rsidRDefault="00CF4E1A" w:rsidP="00814449"><w:pPr><w:jc w:val="center"/><w:rPr><w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr></w:pPr><w:r w:rsidRPr="00CF4E1A"><w:rPr><w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr><w:t>${rpl_hasil_5}</w:t></w:r></w:p></w:tc></w:tr></w:tbl>';
		
	$nama_pemeriksaan_report = '';
	$nama_pemeriksaan_group = '';
	$l = 1;
	mysql_data_seek($get_lab_detail,0);
	while($dat_lab_detail = mysql_fetch_array($get_lab_detail)){
		if ($nama_pemeriksaan_report != $dat_lab_detail['CH_REPORT']) {
			$nama_pemeriksaan_report = $dat_lab_detail['CH_REPORT'];
			$templatelab->setValue('pemeriksaan_row#' . $l, '<w:r><w:rPr><w:b/></w:rPr><w:t>' . htmlspecialchars(strtoupper($dat_lab_detail['CH_REPORT'])) . '</w:t></w:r>');
			$templatelab->setValue('hasil#' . $l, '');
			$templatelab->setValue('satuan#' . $l, '');
			$templatelab->setValue('nilai_rujukan#' . $l, '');
			$l++;
		}
		
		$sm = true;
		if ($nama_pemeriksaan_group != $dat_lab_detail['NAMA_PEMERIKSAAN_GROUP']) {
			$nama_pemeriksaan_group = $dat_lab_detail['NAMA_PEMERIKSAAN_GROUP'];
			$sm = false;
		}
		
		$hasil_a = explode('|!|',$dat_lab_detail['HASIL_DIAGNOSA']);
		if (!empty($dat_lab_detail['NAMA_PEMERIKSAAN_GROUP']) and $sm == false) {
			$templatelab->setValue('pemeriksaan_row#' . $l, '<w:r><w:rPr><w:b/></w:rPr><w:t>' . htmlspecialchars($dat_lab_detail['NAMA_PEMERIKSAAN_GROUP']) . '</w:t></w:r>');
			
			$hd_hasil = '';
			if(sizeof($hasil_a) == 5){
				$hd_hasil = str_replace('${rpl_hasil_1}','<w:r><w:rPr><w:b/></w:rPr><w:t>' . htmlspecialchars('Bi') . '</w:t></w:r>',$tbl_5col);
				$hd_hasil = str_replace('${rpl_hasil_2}','<w:r><w:rPr><w:b/></w:rPr><w:t>' . htmlspecialchars('Mi') . '</w:t></w:r>',$hd_hasil);
				$hd_hasil = str_replace('${rpl_hasil_3}','<w:r><w:rPr><w:b/></w:rPr><w:t>' . htmlspecialchars('S(%)') . '</w:t></w:r>',$hd_hasil);
				$hd_hasil = str_replace('${rpl_hasil_4}','<w:r><w:rPr><w:b/></w:rPr><w:t>' . htmlspecialchars('F(%)') . '</w:t></w:r>',$hd_hasil);
				$hd_hasil = str_replace('${rpl_hasil_5}','<w:r><w:rPr><w:b/></w:rPr><w:t>' . htmlspecialchars('G(%)') . '</w:t></w:r>',$hd_hasil);
			}
			
			$templatelab->setValue('hasil#' . $l, $hd_hasil);
			$templatelab->setValue('satuan#' . $l, '');
			$templatelab->setValue('nilai_rujukan#' . $l, '');
			$l++;
		}	
		
		if(!empty($dat_lab_detail['NAMA_PEMERIKSAAN_GROUP'])){
			$nama_pemeriksaan = '- ' . $dat_lab_detail['NAMA_PEMERIKSAAN'];
			if($dat_lab_detail['CH_LEVEL'] == '1') $nama_pemeriksaan = '<w:r><w:rPr><w:b/></w:rPr><w:t>' . htmlspecialchars($nama_pemeriksaan) . '</w:t></w:r>';	
		}else{
			$nama_pemeriksaan = $dat_lab_detail['NAMA_PEMERIKSAAN'];
			if($dat_lab_detail['CH_LEVEL'] == '1') $nama_pemeriksaan = '<w:r><w:rPr><w:b/></w:rPr><w:t>' . htmlspecialchars($nama_pemeriksaan) . '</w:t></w:r>';		
		}
			
		if(sizeof($hasil_a) == 5){
			$hasil = str_replace('${rpl_hasil_1}',htmlspecialchars($hasil_a[0]),$tbl_5col);
			$hasil = str_replace('${rpl_hasil_2}',htmlspecialchars($hasil_a[1]),$hasil);
			$hasil = str_replace('${rpl_hasil_3}',htmlspecialchars($hasil_a[2]),$hasil);
			$hasil = str_replace('${rpl_hasil_4}',htmlspecialchars($hasil_a[3]),$hasil);
			$hasil = str_replace('${rpl_hasil_5}',htmlspecialchars($hasil_a[4]),$hasil);
		}else{
			if($dat_lab_detail['TEXT_HASIL'] == '1'){
				$hasil = str_replace('${rpl_hasil}',htmlspecialchars($dat_lab_detail['HASIL_DIAGNOSA']),$tbl_left);
			}else{
				$hasil = str_replace('${rpl_hasil}',htmlspecialchars($dat_lab_detail['HASIL_DIAGNOSA']),$tbl_center);
			}
		}
		
		$rujukan = '';
		$rujukan_array = explode('|',$dat_lab_detail['NILAI_RUJUKAN']);
		if(sizeof($rujukan_array) > 0){
			$rujukan = $rujukan_array[1];
		}
		
		$templatelab->setValue('pemeriksaan_row#' . $l, $nama_pemeriksaan);
		$templatelab->setValue('hasil#' . $l, $hasil);
		$templatelab->setValue('satuan#' . $l, htmlspecialchars($dat_lab_detail['SATUAN']));
		$templatelab->setValue('nilai_rujukan#' . $l, htmlspecialchars($rujukan));
		
		$l++;
	}	
		
	if(!file_exists($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $dat_lab['NOMR'] . '/' . $rawat_id)){
		@mkdir($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $dat_lab['NOMR'] . '/' . $rawat_id, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/' . $jns_perawatan . '/' . $dat_lab['NOMR'] . '/' . $rawat_id)){
		@mkdir($rmfile_path . '/doc/' . $jns_perawatan . '/' . $dat_lab['NOMR'] . '/' . $rawat_id, 0700, true);
	}
	
	$nama_file = $dat_lab['NOMR'] . '_' . strtoupper($ord) . $rawat_id . '_5_' . $nomor . '_' . $form;	
	$templatelab->saveAs($rmfile_path . '/doc/' . $jns_perawatan . '/' . $dat_lab['NOMR'] . '/' . $rawat_id . '/' . $nama_file . '.docx');
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $rawat_id . '"
				AND JNS_PERAWATAN = "' . $jns_perawatan . '"
				AND JENIS_DOKUMEN_ID = "5"
				AND ORDER_PENUNJANG = "' . strtoupper($ord) . $nomor . $form . '"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,
				ORDER_PENUNJANG,TANGGAL) VALUES("5","' . $dat_lab['NOMR'] . '","' . $rawat_id . '","' . $jns_perawatan . '",
				"' . $nama_file . '.pdf","1","' . strtoupper($ord) . $nomor . $form . '",
				STR_TO_DATE("' . $dat_lab['TANGGAL_DAFTAR'] . '","%d/%m/%Y"))') or die(mysql_error());	

	$source_file = $rmfile_path . '/doc/' . $jns_perawatan . '/' . $dat_lab['NOMR'] . '/' . $rawat_id . '/' . $nama_file . '.docx';			
	$source_file = str_replace('/','\\',$source_file);
	$target_file = $rmfile_path . '/pdf/' . $jns_perawatan . '/' . $dat_lab['NOMR'] . '/' . $rawat_id . '/' . $nama_file . '.pdf';
	$target_file = str_replace('/','\\',$target_file);
	
	try{
		$word = new COM("Word.Application") or die ("Could not initialise Object.");
		$word->Visible = 0;
		$word->DisplayAlerts = 0;
		$word->Documents->Open($source_file);
		if(file_exists($target_file)){
			unlink($target_file);
		}
		$word->ActiveDocument->ExportAsFixedFormat($target_file, 17, false, 0, 0, 0, 0, 7, true, true, 2, true, true, false);
		$word->Quit(false);
		unset($word);
	} catch (Exception $e) {
		echo $e;
	}		
}	
?>