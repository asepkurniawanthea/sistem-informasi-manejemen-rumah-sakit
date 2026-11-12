<?php if(isset($_GET['idx']) and isset($_GET['ord'])){
$idx	= $_GET['idx'];
$ord	= $_GET['ord'];

include('../config/config.php');
include('../shared/connect_db.php');
include('../shared/function.php');
	
if($ord == 'irj'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d-%m-%Y %H:%i") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR2,
				DATE_FORMAT(t_ipenunjang_tarif_pemeriksaan.TGL_DIAGNOSA,"%d-%m-%Y %H:%i") AS TANGGAL_DIAGNOSA,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				m_pasien.NAMA_SUAMI_ISTERI,t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_DIAGNOSA,t_ipenunjang_tarif.JENIS_FOTO,
				m_pegawai_tipe.KET_TIPE_PEGAWAI
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN t_ipenunjang_tarif_pemeriksaan ON (t_ipenunjang_tarif.PENUNJANG_TARIF_ID = t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif_pemeriksaan.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_pegawai_tipe ON (m_pegawai2.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRJ"
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $idx . '"';
}else if($ord == 'irn'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d-%m-%Y %H:%i") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR2,
				DATE_FORMAT(t_ipenunjang_tarif_pemeriksaan.TGL_DIAGNOSA,"%d-%m-%Y %H:%i") AS TANGGAL_DIAGNOSA,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,
				t_ipenunjang.RUANG_ID AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				m_pasien.NAMA_SUAMI_ISTERI,t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_DIAGNOSA,t_ipenunjang_tarif.JENIS_FOTO,
				m_pegawai_tipe.KET_TIPE_PEGAWAI
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN t_ipenunjang_tarif_pemeriksaan ON (t_ipenunjang_tarif.PENUNJANG_TARIF_ID = t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif_pemeriksaan.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_pegawai_tipe ON (m_pegawai2.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRN"
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $idx . '"';
}else if($ord == 'aps'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d-%m-%Y %H:%i") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR2,
				DATE_FORMAT(t_ipenunjang_tarif_pemeriksaan.TGL_DIAGNOSA,"%d-%m-%Y %H:%i") AS TANGGAL_DIAGNOSA,
				t_ipenunjang.NAMA_PASIEN,t_ipenunjang.NO_PASIEN_PENUNJANG AS NOMR,t_ipenunjang.TGL_LAHIR,t_ipenunjang.ALAMAT,
				t_ipenunjang.INSTANSI_PENGIRIM AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN, "" AS RAWAT_ID,
				t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.PENGIRIM AS NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,"" AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang.JNS_KELAMIN,t_ipenunjang.NIK,t_ipenunjang.NO_TELEPON,
				t_ipenunjang.NAMA_SUAMI_ISTERI,t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_DIAGNOSA,t_ipenunjang_tarif.JENIS_FOTO,
				m_pegawai_tipe.KET_TIPE_PEGAWAI
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN t_ipenunjang_tarif_pemeriksaan ON (t_ipenunjang_tarif.PENUNJANG_TARIF_ID = t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif_pemeriksaan.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_pegawai_tipe ON (m_pegawai2.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "APS"
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $idx . '"';
}else if($ord == 'hrj'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d-%m-%Y %H:%i") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR2,
				DATE_FORMAT(t_ipenunjang_tarif_pemeriksaan.TGL_DIAGNOSA,"%d-%m-%Y %H:%i") AS TANGGAL_DIAGNOSA,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_unit.NAMA_UNIT,"-Hemodialisa") AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				m_pasien.NAMA_SUAMI_ISTERI,t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_DIAGNOSA,t_ipenunjang_tarif.JENIS_FOTO,
				m_pegawai_tipe.KET_TIPE_PEGAWAI,t_ipenunjang.HEMODIALISA_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN t_ipenunjang_tarif_pemeriksaan ON (t_ipenunjang_tarif.PENUNJANG_TARIF_ID = t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif_pemeriksaan.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_pegawai_tipe ON (m_pegawai2.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "HRJ"
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $idx . '"';
}else if($ord == 'hri'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d-%m-%Y %H:%i") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR2,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT,"-Hemodialisa") AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.RUANG_ID AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				m_pasien.NAMA_SUAMI_ISTERI,t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_DIAGNOSA,t_ipenunjang_tarif.JENIS_FOTO,
				m_pegawai_tipe.KET_TIPE_PEGAWAI,t_ipenunjang.HEMODIALISA_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN t_ipenunjang_tarif_pemeriksaan ON (t_ipenunjang_tarif.PENUNJANG_TARIF_ID = t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif_pemeriksaan.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_pegawai_tipe ON (m_pegawai2.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "HRI"
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $idx . '"';
}else if($ord == 'orj'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d-%m-%Y %H:%i") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR2,
				INNER JOIN t_ipenunjang_tarif_pemeriksaan ON (t_ipenunjang_tarif.PENUNJANG_TARIF_ID = t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID)
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_unit.NAMA_UNIT,"-Kamar Operasi") AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				m_pasien.NAMA_SUAMI_ISTERI,t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_DIAGNOSA,t_ipenunjang_tarif.JENIS_FOTO,
				m_pegawai_tipe.KET_TIPE_PEGAWAI
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN t_ipenunjang_tarif_pemeriksaan ON (t_ipenunjang_tarif.PENUNJANG_TARIF_ID = t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif_pemeriksaan.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_pegawai_tipe ON (m_pegawai2.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "ORJ"
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $idx . '"';
}else if($ord == 'ori'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d-%m-%Y %H:%i") AS TANGGAL_DAFTAR,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR2,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT,"-Kamar Operasi") AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.RUANG_ID AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				m_pasien.NAMA_SUAMI_ISTERI,t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_DIAGNOSA,t_ipenunjang_tarif.JENIS_FOTO,
				m_pegawai_tipe.KET_TIPE_PEGAWAI
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN t_ipenunjang_tarif_pemeriksaan ON (t_ipenunjang_tarif.PENUNJANG_TARIF_ID = t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif_pemeriksaan.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_pegawai_tipe ON (m_pegawai2.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "ORI"
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $idx . '"';									
}				
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = formatNomr($dat_pasien['NOMR']);
$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = changeDateFormat($dat_pasien['TGL_LAHIR']);
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$alamat = $dat_pasien['ALAMAT'];
$nik = $dat_pasien['NIK'];
$jns_pembayaran = $dat_pasien['NAMA_JAMINAN'];

$penunjang_id = $dat_pasien['PENUNJANG_ID'];
$pegawai_id = $dat_pasien['NAMA_PEGAWAI'];
$nama_unit = $dat_pasien['NAMA_UNIT'];
$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
$tgl_daftar2 = $dat_pasien['TANGGAL_DAFTAR2'];
$rawat_id = $dat_pasien['RAWAT_ID'];

$no_telepon = $dat_pasien['NO_TELEPON'];
$umur = getUmurDaftar($tgl_lahir,$tgl_daftar2);
$nama_suami_isteri = $dat_pasien['NAMA_SUAMI_ISTERI'];

$tanggal_diagnosa = $dat_pasien['TANGGAL_DIAGNOSA'];
$hasil_diagnosa = $dat_pasien['HASIL_DIAGNOSA'];
$dokter_diagnosa = $dat_pasien['DOKTER_DIAGNOSA'];
$jenis_foto = $dat_pasien['JENIS_FOTO'];
$tipe_pegawai = $dat_pasien['KET_TIPE_PEGAWAI'];
?>
<!DOCTYPE html>
  <html><head>
  <link rel="stylesheet" media="print" href="../style/radiologi_diagnosa_pdf.css" type="text/css">
  <script>
  function subst() {
      var vars = {};
      var query_strings_from_url = document.location.search.substring(1).split('&');
      for (var query_string in query_strings_from_url) {
          if (query_strings_from_url.hasOwnProperty(query_string)) {
              var temp_var = query_strings_from_url[query_string].split('=', 2);
              vars[temp_var[0]] = decodeURI(temp_var[1]);
          }
      }
      var css_selector_classes = ['page', 'frompage', 'topage', 'webpage', 'section', 'subsection', 'date', 'isodate', 'time', 'title', 'doctitle', 'sitepage', 'sitepages'];
      for (var css_class in css_selector_classes) {
          if (css_selector_classes.hasOwnProperty(css_class)) {
              var element = document.getElementsByClassName(css_selector_classes[css_class]);
              for (var j = 0; j < element.length; ++j) {
                  element[j].textContent = vars[css_selector_classes[css_class]];
              }
          }
      }
  }
  </script></head><body style="border:0; margin: 0;" onload="subst()">
  <table style="border-bottom: 1px solid black; width: 100%">
    <tr>
      <td style="text-align:right">
        Autorisasi oleh : <?php echo $dokter_diagnosa; ?>
      </td>
	</tr>
	<tr>	
	  <td style="text-align:right">
        Tanggal Expertise : <?php echo $tgl_daftar; ?>
      </td>
	</tr>
	<tr>
	 <td style="text-align:right">
        Expertise ini sudah diverifikasi secara elektronik, tanda tangan petugas tidak diperlukan.
      </td>	
    </tr>
  </table>
  </body></html>
<?php } ?>  