<?php
function create_pdf_radiologi($idx,$idx_tarif,$perawatan,$no_order){
global $rmfile_path;
global $user_name;
global $edoc_logo;
global $paper_width;
global $paper_height;
$jenis_document = 'Radiologi';
$id_document = '6';		

if($perawatan == 'irj') {
	$perawatan_h = 'RJ';
	$jns_rawat = '1';
	$qry_radiologi = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y") AS TANGGAL_PERIKSA,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d/%m/%Y %h:%i:%s") AS TANGGAL_DIAGNOSA,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,m_pegawai.NAMA_PEGAWAI AS RADIOGRAFER,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_DIAGNOSA,t_ipenunjang_tarif.HASIL_DIAGNOSA,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_PHOTO
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai2.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRJ"
				AND t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $idx_tarif . '"';
}else if($perawatan == 'irn') {
	$perawatan_h = 'RI';
	$jns_rawat = '2';
	$qry_radiologi = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y") AS TANGGAL_PERIKSA,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d/%m/%Y %h:%i:%s") AS TANGGAL_DIAGNOSA,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN,
				m_pegawai.NAMA_PEGAWAI AS RADIOGRAFER,m_pegawai2.NAMA_PEGAWAI AS DOKTER_DIAGNOSA,
				t_ipenunjang_tarif.HASIL_DIAGNOSA,m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_PHOTO
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai2.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRN"
				AND t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $idx_tarif . '"';
}else if($perawatan == 'hrj') {
	$perawatan_h = 'RJ';
	$jns_rawat = '1';
	$qry_radiologi = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y") AS TANGGAL_PERIKSA,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d/%m/%Y %h:%i:%s") AS TANGGAL_DIAGNOSA,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				CONCAT(m_unit.NAMA_UNIT,"-Hemodialisa") AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN,
				m_pegawai.NAMA_PEGAWAI AS RADIOGRAFER,m_pegawai2.NAMA_PEGAWAI AS DOKTER_DIAGNOSA,
				t_ipenunjang_tarif.HASIL_DIAGNOSA,m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_PHOTO
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai2.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "HRJ"
				AND t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $idx_tarif . '"';
}else if($perawatan == 'hri') {
	$perawatan_h = 'RI';
	$jns_rawat = '2';
	$qry_radiologi = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y") AS TANGGAL_PERIKSA,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d/%m/%Y %h:%i:%s") AS TANGGAL_DIAGNOSA,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT,"-Hemodialisa") AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,m_pegawai.NAMA_PEGAWAI AS RADIOGRAFER,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_DIAGNOSA,t_ipenunjang_tarif.HASIL_DIAGNOSA,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_PHOTO
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai2.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "HRI"
				AND t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $idx_tarif . '"';
}else if($perawatan == 'orj') {
	$perawatan_h = 'RJ';
	$jns_rawat = '1';
	$qry_radiologi = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y") AS TANGGAL_PERIKSA,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d/%m/%Y %h:%i:%s") AS TANGGAL_DIAGNOSA,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				CONCAT(m_unit.NAMA_UNIT,"-Kamar Operasi") AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN,m_pegawai.NAMA_PEGAWAI AS RADIOGRAFER,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_DIAGNOSA,t_ipenunjang_tarif.HASIL_DIAGNOSA,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_PHOTO
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai2.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "ORJ"
				AND t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $idx_tarif . '"';	
}else if($perawatan == 'ori') {
	$perawatan_h = 'RI';
	$jns_rawat = '2';
	$qry_radiologi = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y") AS TANGGAL_PERIKSA,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d/%m/%Y %h:%i:%s") AS TANGGAL_DIAGNOSA,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT,"-Kamar Operasi") AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN,
				m_pegawai.NAMA_PEGAWAI AS RADIOGRAFER,m_pegawai2.NAMA_PEGAWAI AS DOKTER_DIAGNOSA,
				t_ipenunjang_tarif.HASIL_DIAGNOSA,m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_PHOTO
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai2.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "ORI"
				AND t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $idx_tarif . '"';				
}	


$mpdf = new mPDF('utf-8', array($paper_width,$paper_height));
$get_radiologi = mysql_query($qry_radiologi) or die(mysql_error());
$dat_radiologi = mysql_fetch_assoc($get_radiologi);
$nomr = $dat_radiologi['NOMR'];
$nama_pasien = $dat_radiologi['NAMA_PASIEN'];
$tgl_lahir = $dat_radiologi['TGL_LAHIR'];
$jns_kelamin = $dat_radiologi['JNS_KELAMIN'];
$nama_unit = $dat_radiologi['NAMA_UNIT'];

$edoc_norm = formatNoMR($nomr);
$edoc_nama_pasien = $nama_pasien;
$edoc_tanggal_lahir = changeDateFormat($tgl_lahir);
$edoc_jenis_kelamin = jenisKelamin($jns_kelamin);
$edoc_unit = $nama_unit;
$edoc_nama_documen = strtoupper($jenis_document);

$tanggal_photo = $dat_radiologi['TANGGAL_PERIKSA'];
$tanggal_diagnosa = $dat_radiologi['TANGGAL_DIAGNOSA'];
$radiografer = $dat_radiologi['RADIOGRAFER'];
$dokter_diagnosa = $dat_radiologi['DOKTER_DIAGNOSA'];
$hasil_diagnosa = $dat_radiologi['HASIL_DIAGNOSA'];
$jenis_photo = $dat_radiologi['NAMA_PHOTO'];

$edoc_content = '<table width="100%" border="0" autosize="1">
  <tr>
    <td>Jenis Photo</td>
    <td colspan="4">:&nbsp;' . setGarisIfNull($jenis_photo) . '</td>
  </tr>
  <tr>
    <td>Tanggal Photo </td>
    <td>:&nbsp;' . setGarisIfNull($tanggal_photo) . '</td>
    <td>&nbsp;</td>
    <td>Radiografer</td>
    <td>:&nbsp;' . setGarisIfNull($radiografer) . '</td>
  </tr>
  <tr>
    <td>Tanggal Diagnosa </td>
    <td>:&nbsp;' . setGarisIfNull($tanggal_diagnosa) . '</td>
    <td>&nbsp;</td>
    <td>Dokter</td>
    <td>:&nbsp;' . setGarisIfNull($dokter_diagnosa) . '</td>
  </tr>
  <tr>
    <td align="center" colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" colspan="5"><strong>HASIL DIAGNOSA</strong></td>
  </tr>
  <tr>
    <td colspan="5">' . setGarisIfNull($hasil_diagnosa) . '</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>';
  
ob_start();
include('edoc_rekammedik/edoc_frame_main.php');
$html = ob_get_contents();
ob_end_clean();			

createFolder($nomr);
$filename = $nomr . '_' . $perawatan_h . $idx . '_' . $id_document . '_' . $no_order.$idx_tarif . '.pdf' ;

$mpdf = new mPDF('utf-8', array($paper_width,$paper_height));
$mpdf->autoPageBreak = false;
$mpdf->SetHTMLHeader(setHeader($nomr,$nama_pasien));
$mpdf->SetHTMLFooter(setFooter($jenis_document));
$mpdf->WriteHTML($html);
$mpdf->Output($rmfile_path . '/' . $nomr . '/' . $filename);	

saveData($nomr,$idx,$jns_rawat,$id_document,$filename,$user_name,$no_order.$idx_tarif,'');
}
?>