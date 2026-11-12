<?php
function create_pdf_identitas($idx,$perawatan){
global $rmfile_path;
global $user_name;
global $edoc_logo;
global $paper_width;
global $paper_height;
$jenis_document = 'Identitas';
$id_document = '1';		

if($perawatan == 'RJ'){
	$jns_rawat = '1';
	$qry_identitas = 'SELECT m_pasien.PASIEN_ID,m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TMP_LAHIR,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ST_KAWIN,
				m_pasien.AGAMA_ID,m_pasien.PENDIDIKAN_ID,m_pasien.PEKERJAAN,m_pasien.ALAMAT,m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_pasien.KELURAHAN_ID,
				m_pasien.KECAMATAN_ID,m_pasien.KOTA_ID,m_pasien.PROPINSI_ID,m_pasien.KODE_POS,m_pasien.NO_TELEPON,m_pasien.NAMA_IBU,m_pasien.NAMA_AYAH,
				m_pasien.NAMA_SUAMI_ISTERI,m_pasien.NIK,m_pasien.KHUSUS,m_agama.NAMA_AGAMA,m_pendidikan.NAMA_PENDIDIKAN,
				m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,m_propinsi.NAMA_PROPINSI,
				m_unit.NAMA_UNIT
				FROM t_irja 
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				LEFT JOIN m_agama ON (m_pasien.AGAMA_ID = m_agama.AGAMA_ID)
				LEFT JOIN m_pendidikan ON (m_pasien.PENDIDIKAN_ID = m_pendidikan.PENDIDIKAN_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				LEFT JOIN m_propinsi ON (m_pasien.PROPINSI_ID = m_propinsi.PROPINSI_ID) 
				LEFT JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				WHERE t_irja.IRJA_ID = "' . $idx . '"';
}else{
	$jns_rawat = '2';
	$qry_identitas = 'SELECT m_pasien.PASIEN_ID,m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TMP_LAHIR,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ST_KAWIN,
				m_pasien.AGAMA_ID,m_pasien.PENDIDIKAN_ID,m_pasien.PEKERJAAN,m_pasien.ALAMAT,m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_pasien.KELURAHAN_ID,
				m_pasien.KECAMATAN_ID,m_pasien.KOTA_ID,m_pasien.PROPINSI_ID,m_pasien.KODE_POS,m_pasien.NO_TELEPON,m_pasien.NAMA_IBU,m_pasien.NAMA_AYAH,
				m_pasien.NAMA_SUAMI_ISTERI,m_pasien.NIK,m_pasien.KHUSUS,m_agama.NAMA_AGAMA,m_pendidikan.NAMA_PENDIDIKAN,
				m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,m_propinsi.NAMA_PROPINSI,
				CONCAT(m_ruang.NAMA_RUANG," ",m_ruang.KELAS_RAWAT) AS NAMA_UNIT
				FROM t_irna 
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				LEFT JOIN m_agama ON (m_pasien.AGAMA_ID = m_agama.AGAMA_ID)
				LEFT JOIN m_pendidikan ON (m_pasien.PENDIDIKAN_ID = m_pendidikan.PENDIDIKAN_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				LEFT JOIN m_propinsi ON (m_pasien.PROPINSI_ID = m_propinsi.PROPINSI_ID) 
				LEFT JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				WHERE t_irna.IRNA_ID = "' . $idx . '"';
}

$get_identitas = mysql_query($qry_identitas) or die(mysql_error());
$dat_identitas = mysql_fetch_assoc($get_identitas);

$nama_pasien = $dat_identitas['NAMA_PASIEN'];
$tmp_lahir = $dat_identitas['TMP_LAHIR'];
$tgl_lahir = changeDateFormat($dat_identitas['TGL_LAHIR']);
$jns_kelamin = $dat_identitas['JNS_KELAMIN'];
$st_kawin = $dat_identitas['ST_KAWIN'];
$agama_id = $dat_identitas['NAMA_AGAMA'];
$pendidikan_id = $dat_identitas['NAMA_PENDIDIKAN'];
$pekerjaan_id = $dat_identitas['PEKERJAAN'];
$alamat = $dat_identitas['ALAMAT'];
$alamat_rt = $dat_identitas['ALAMAT_RT'];
$alamat_rw = $dat_identitas['ALAMAT_RW'];
$kelurahan_id = $dat_identitas['NAMA_KELURAHAN'];
$kecamatan_id = $dat_identitas['NAMA_KECAMATAN'];
$kota_id = $dat_identitas['NAMA_KOTA'];
$propinsi_id = $dat_identitas['NAMA_PROPINSI'];
$kode_pos = $dat_identitas['KODE_POS'];
$no_telepon = $dat_identitas['NO_TELEPON'];
$nama_ibu = $dat_identitas['NAMA_IBU'];
$nama_ayah = $dat_identitas['NAMA_AYAH'];
$nama_suami_isteri = $dat_identitas['NAMA_SUAMI_ISTERI'];
$nik = $dat_identitas['NIK'];
$nomr = $dat_identitas['NOMR'];
$nama_unit = $dat_identitas['NAMA_UNIT'];

$edoc_norm = formatNoMR($nomr);
$edoc_nama_pasien = $nama_pasien;
$edoc_tanggal_lahir = $tgl_lahir;
$edoc_jenis_kelamin = jenisKelamin($jns_kelamin);
$edoc_unit = $nama_unit;
$edoc_nama_documen = strtoupper($jenis_document);
$edoc_content = '<table width="100%" border="0" autosize="1" >
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nomor Medical Record</td>
    <td>:&nbsp;' . formatNoMR($nomr) . '</td>
    <td>&nbsp;</td>
    <td>Nama Pasien</td>
    <td>:&nbsp;' . setGarisIfNull($nama_pasien) . '</td>
  </tr>
  <tr>
    <td>Tempat Lahir</td>
    <td>:&nbsp;' . setGarisIfNull($tmp_lahir) . '</td>
    <td>&nbsp;</td>
    <td>Tanggal Lahir</td>
    <td>:&nbsp;' . setGarisIfNull($tgl_lahir) . '</td>
  </tr>
  <tr>
    <td>Jenis Kelamin</td>
    <td>:&nbsp;' . jenisKelamin($jns_kelamin) . '</td>
    <td>&nbsp;</td>
    <td>Status Perkawinan</td>
    <td>:&nbsp;' . setGarisIfNull(statusKawin($st_kawin)) . '</td>
  </tr>
  <tr>
    <td>Agama</td>
    <td>:&nbsp;' . setGarisIfNull($agama_id) . '</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Pendidikan Terakhir</td>
    <td>:&nbsp;' . setGarisIfNull($pendidikan_id) . '</td>
    <td>&nbsp;</td>
    <td>Pekerjaan</td>
    <td>:&nbsp;' . setGarisIfNull($pekerjaan_id) . '</td>
  </tr>
  <tr>
    <td>Alamat</td>
    <td>:&nbsp;' . setGarisIfNull($alamat) . '</td>
    <td>&nbsp;</td>
    <td>Rt/Rw</td>
    <td>:&nbsp;' . setGarisIfNull($alamat_rt) . '/' . setGarisIfNull($alamat_rw) . '</td>
  </tr>
  <tr>
    <td>Propinsi</td>
    <td>:&nbsp;' . setGarisIfNull($propinsi_id) . '</td>
    <td>&nbsp;</td>
    <td>Kab /Kota</td>
    <td>:&nbsp;' . setGarisIfNull($kota_id) . '</td>
  </tr>
  <tr>
    <td>Kecamatan</td>
    <td>:&nbsp;' . setGarisIfNull($kecamatan_id) . '</td>
    <td>&nbsp;</td>
    <td>Kelurahan</td>
    <td>:&nbsp;' . setGarisIfNull($kelurahan_id) . '</td>
  </tr>
  <tr>
    <td>Kode Pos</td>
    <td>:&nbsp;' . setGarisIfNull($kode_pos) . '</td>
    <td>&nbsp;</td>
    <td>Nomor Telepon</td>
    <td>:&nbsp;' . setGarisIfNull($no_telepon) . '</td>
  </tr>
  <tr>
    <td>Nama Ibu Kandung</td>
    <td>:&nbsp;' . setGarisIfNull($nama_ibu) . '</td>
    <td>&nbsp;</td>
    <td>Nama Ayah Kandung</td>
    <td>:&nbsp;' . setGarisIfNull($nama_ayah) . '</td>
  </tr>
  <tr>
    <td>Nama Suami / Isteri</td>
    <td>:&nbsp;' . setGarisIfNull($nama_suami_isteri) . '</td>
    <td>&nbsp;</td>
    <td>NIK</td>
    <td>:&nbsp;' . setGarisIfNull($nik) . '</td>
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
$filename = $nomr . '_' . $perawatan . $idx . '_' . $id_document . '.pdf' ;

$mpdf = new mPDF('utf-8', array($paper_width,$paper_height));
$mpdf->autoPageBreak = false;
$mpdf->SetHTMLHeader(setHeader($nomr,$nama_pasien));
$mpdf->SetHTMLFooter(setFooter($jenis_document));
$mpdf->WriteHTML($html);
$mpdf->Output($rmfile_path . '/' . $nomr . '/' . $filename);	

saveData($nomr,$idx,$jns_rawat,$id_document,$filename,$user_name,'','');
}
?>