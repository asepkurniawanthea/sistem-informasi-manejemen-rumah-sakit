<?php
function create_pdf_penunjang($idx,$perawatan,$no_order){
global $rmfile_path;
global $user_name;
global $edoc_logo;
global $paper_width;
global $paper_height;
$id_document = '9';		

if($perawatan == 'irj') {
	$perawatan_h = 'RJ';
	$jns_rawat = '1';
	$qry_penunjang = 'SELECT DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_unit.NAMA_UNIT,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.HASIL_DIAGNOSA,
				m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,
				m_unit2.NAMA_UNIT AS NAMA_UNIT_PENUNJANG,m_pegawai.NAMA_PEGAWAI
				FROM t_ipenunjang
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				LEFT JOIN m_unit m_unit2 ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit2.UNIT_ID)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRJ"
				AND t_ipenunjang_tarif.NO_SJP = "' . $no_order . '"
				AND t_ipenunjang.PENUNJANG_ID = "' . $idx . '"';
				
}else if($perawatan == 'irn') {
	$perawatan_h = 'RI';
	$jns_rawat = '2';
	$qry_penunjang = 'SELECT DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,
				t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.HASIL_DIAGNOSA,
				m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,
				m_unit2.NAMA_UNIT AS NAMA_UNIT_PENUNJANG,m_pegawai.NAMA_PEGAWAI
				FROM t_ipenunjang
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				LEFT JOIN m_unit m_unit2 ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit2.UNIT_ID)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRN"
				AND t_ipenunjang_tarif.NO_SJP = "' . $no_order . '"
				AND t_ipenunjang.PENUNJANG_ID = "' . $idx . '"';
}else if($perawatan == 'hrj') {
	$perawatan_h = 'RJ';
	$jns_rawat = '1';
	$qry_penunjang = 'SELECT DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				CONCAT(m_unit.NAMA_UNIT,"-Hemodialisa") AS NAMA_UNIT,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.HASIL_DIAGNOSA,
				m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,
				m_unit2.NAMA_UNIT AS NAMA_UNIT_PENUNJANG,m_pegawai.NAMA_PEGAWAI
				FROM t_ipenunjang
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				LEFT JOIN m_unit m_unit2 ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit2.UNIT_ID)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "HRJ"
				AND t_ipenunjang_tarif.NO_SJP = "' . $no_order . '"
				AND t_ipenunjang.PENUNJANG_ID = "' . $idx . '"';
}else if($perawatan == 'hri') {
	$perawatan_h = 'RI';
	$jns_rawat = '2';
	$qry_penunjang = 'SELECT DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT,"-Hemodialisa") AS NAMA_UNIT,
				t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.HASIL_DIAGNOSA,
				m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,
				m_unit2.NAMA_UNIT AS NAMA_UNIT_PENUNJANG,m_pegawai.NAMA_PEGAWAI
				FROM t_ipenunjang
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				LEFT JOIN m_unit m_unit2 ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit2.UNIT_ID)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "HRI"
				AND t_ipenunjang_tarif.NO_SJP = "' . $no_order . '"
				AND t_ipenunjang.PENUNJANG_ID = "' . $idx . '"';
}	


$get_penunjang = mysql_query($qry_penunjang) or die(mysql_error());
$dat_penunjang = mysql_fetch_assoc($get_penunjang);

$nama_pasien = $dat_penunjang['NAMA_PASIEN'];
$tgl_lahir = changeDateFormat($dat_penunjang['TGL_LAHIR']);
$jns_kelamin = $dat_penunjang['JNS_KELAMIN'];
$nomr = $dat_penunjang['NOMR'];
$nama_unit = $dat_penunjang['NAMA_UNIT'];
$jenis_document = $dat_penunjang['NAMA_UNIT_PENUNJANG'];
$pemeriksa = $dat_penunjang['NAMA_PEGAWAI'];
$rawat_id = $dat_penunjang['RAWAT_ID'];
$hasil_pemeriksaan = $dat_penunjang['HASIL_DIAGNOSA'];

$edoc_norm = formatNoMR($nomr);
$edoc_nama_pasien = $nama_pasien;
$edoc_tanggal_lahir = $tgl_lahir;
$edoc_jenis_kelamin = jenisKelamin($jns_kelamin);
$edoc_unit = $nama_unit;
$edoc_nama_documen = strtoupper($jenis_document);
$edoc_content = '<table width="100%" border="0" autosize="1" >
  <tr>
    <td>Pemeriksa</td>
    <td>:&nbsp;' . setGarisIfNull($pemeriksa) . '</td>
  </tr>
  <tr>
    <td>Hasil Pemeriksaan</td>
    <td>:&nbsp;' . setGarisIfNull($hasil_pemeriksaan) . '</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>';

$qry_tindakan = 'SELECT m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,
				SUM(t_ipenunjang_tarif.KUANTITI) AS KUANTITI
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.PENUNJANG_ID = "' . $idx . '"
				AND t_ipenunjang.JNS_ORDER = "' . strtoupper($perawatan) . '" 
				AND t_ipenunjang_tarif.NO_SJP = "' . $no_order . '"
				AND (m_tarif_group.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '" OR m_tarif.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '")
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				GROUP BY m_tarif.KODE_TARIF';	
$get_tindakan = mysql_query($qry_tindakan) or die(mysql_error());
if(mysql_num_rows($get_tindakan) == 0){
	$edoc_content = $edoc_content . '<tr>
			<td>Tindakan</td>
			<td>:&nbsp;__________</td>
		  </tr>'; 		
}else{
	$x = 1;
	while($dat_tindakan = mysql_fetch_array($get_tindakan)){
		if($x == 1){
			$edoc_content = $edoc_content . '<tr>
					<td>Tindakan</td>
					<td>:&nbsp;' . $dat_tindakan['NAMA_TARIF'] . '(' . $dat_tindakan['KUANTITI'] . ') - ' . $dat_tindakan['NAMA_TARIF_GROUP'] . '</td>
				  </tr>'; 		
		}else{
			$edoc_content = $edoc_content . '<tr>
					<td>&nbsp;</td>
					<td>&nbsp;' . $dat_tindakan['NAMA_TARIF'] . '(' . $dat_tindakan['KUANTITI'] . ') - ' . $dat_tindakan['NAMA_TARIF_GROUP'] . '</td>
				  </tr>'; 		
		}
	
	$x++;
	}					
}
$edoc_content = $edoc_content . '</table>';

ob_start();
include('edoc_rekammedik/edoc_frame_main.php');
$html = ob_get_contents();
ob_end_clean();

createFolder($nomr);
$filename = $nomr . '_' . $perawatan_h . $rawat_id . '_' . $id_document . '_' . $no_order . $idx . '.pdf' ;

$mpdf = new mPDF('utf-8', array($paper_width,$paper_height));
$mpdf->autoPageBreak = false;
$mpdf->SetHTMLHeader(setHeader($nomr,$nama_pasien));
$mpdf->SetHTMLFooter(setFooter($jenis_document));
$mpdf->WriteHTML($html);
$mpdf->Output($rmfile_path . '/' . $nomr . '/' . $filename);	

saveData($nomr,$rawat_id,$jns_rawat,$id_document,$filename,$user_name,$no_order . $idx,$jenis_document);
}
?>