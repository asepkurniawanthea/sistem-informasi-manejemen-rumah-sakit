<?php
function create_pdf_terapi_monitoring_rawat_jalan($idx){
global $rmfile_path;
global $user_name;
global $edoc_logo;
global $paper_width;
global $paper_height;
$jenis_document = 'Terapi - Monitoring - Evaluasi';
$id_document = '13';

$qry_terapi = 'SELECT m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,t_irja.UNIT_ID,m_unit.NAMA_UNIT,
					m_pegawai.NAMA_PEGAWAI,"" AS JNS_ORDER, "" AS RAWAT_ID,
					t_irja.THERAPI,t_irja.MONITORING,t_irja.EVALUASI
					FROM t_irja
					INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
					INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
					LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_irja.IRJA_ID = "' . $idx . '"';
$get_terapi = mysql_query($qry_terapi) or die(mysql_error());
$dat_terapi = mysql_fetch_assoc($get_terapi);

$nomr = $dat_terapi['NOMR'];
$nama_pasien = $dat_terapi['NAMA_PASIEN'];
$tgl_lahir = $dat_terapi['TGL_LAHIR'];
$jns_kelamin = $dat_terapi['JNS_KELAMIN'];
$unit_id = $dat_terapi['NAMA_UNIT'];

$terapi = $dat_terapi['THERAPI'];
$monitoring = $dat_terapi['MONITORING'];
$evaluasi = $dat_terapi['EVALUASI'];

$edoc_norm = formatNoMR($nomr);
$edoc_nama_pasien = $nama_pasien;
$edoc_tanggal_lahir = changeDateFormat($tgl_lahir);
$edoc_jenis_kelamin = jenisKelamin($jns_kelamin);
$edoc_unit = $unit_id;
$edoc_nama_documen = strtoupper($jenis_document);

if($terapi != '' or $monitoring != '' or $evaluasi != ''){

$edoc_content = '<table width="100%" border="0" autosize="1" >
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Terapi</td>
    <td>:&nbsp;' . setGarisIfNull($terapi) . '</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Monitoring</td>
    <td>:&nbsp;' . setGarisIfNull($monitoring) . '</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Evaluasi</td>
    <td>:&nbsp;' . setGarisIfNull($evaluasi) . '</td>
  </tr>
</table>';

ob_start();
include('edoc_rekammedik/edoc_frame_main.php');
$html = ob_get_contents();
ob_end_clean();

createFolder($nomr);
$filename = $nomr . '_RJ' . $idx . '_' . $id_document . '.pdf' ;

$mpdf = new mPDF('utf-8', array($paper_width,$paper_height));
$mpdf->autoPageBreak = false;
$mpdf->SetHTMLHeader(setHeader($nomr,$nama_pasien));
$mpdf->SetHTMLFooter(setFooter($jenis_document));
$mpdf->WriteHTML($html);
$mpdf->Output($rmfile_path . '/' . $nomr . '/' . $filename);	

saveData($nomr,$idx,'1',$id_document,$filename,$user_name,'','');
}
}
?>