<?php
function create_pdf_ringkasan_masuk_rawat_inap($idx){
global $rmfile_path;
global $user_name;
global $edoc_logo;
global $paper_width;
global $paper_height;
$jenis_document = 'Ringkasan Masuk';
$id_document = '16';

$qry_masuk = 'SELECT t_irna.NOMR,t_irna.IRNA_ID,t_irna.TANGGAL_DAFTAR,t_irna.JENIS_BAYAR_ID,t_irna.P_JAWAB_NAMA,
					t_irna.P_JAWAB_NO_TELP,t_irna.P_JAWAB_ALAMAT,t_irna.P_JAWAB_ALAMAT_RT,t_irna.P_JAWAB_ALAMAT_RW,
					t_irna.P_JAWAB_KELURAHAN_ID,t_irna.P_JAWAB_KECAMATAN_ID,t_irna.P_JAWAB_KOTA_ID,
					t_irna.P_JAWAB_PROPINSI_ID,t_irna.P_JAWAB_HUBUNGAN,	CONCAT(m_ruang.NAMA_RUANG,"-",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,
					m_jaminan.NAMA_JAMINAN,m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,m_propinsi.NAMA_PROPINSI,
					m_kota.NAMA_KOTA,m_pegawai.NAMA_PEGAWAI,t_irna.NO_PESERTA,t_irna.NO_SEP,t_irna.NO_SJP,
					m_unit.NAMA_UNIT AS ASAL_PASIEN,t_irna.KECELAKAAN,t_irna.LOKASI_KECELAKAAN,
					t_irna.JKN_TGL_RUJUK,t_irna.JKN_NO_RUJUK,t_irna.JKN_KD_PKK,t_irna.JKN_NAMA_PKK,t_irna.JKN_CATATAN,
					t_irna.JKN_DIAGNOSA,t_irna.JKN_POLIKLINIK,t_irna.JKN_KELAS_RAWAT,t_irna.JKN_PBI_NONPBI,
					m_pasien.NAMA_PASIEN,t_irna.KASUS_POLISI,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN
					FROM t_irna
				  INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				  INNER JOIN t_irja ON (t_irna.IRNA_ID = t_irja.IRJA_ID)
				  LEFT JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				  LEFT JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				  LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				  LEFT JOIN m_kelurahan ON (t_irna.P_JAWAB_KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				  LEFT JOIN m_kecamatan ON (t_irna.P_JAWAB_KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				  LEFT JOIN m_propinsi ON (t_irna.P_JAWAB_PROPINSI_ID = m_propinsi.PROPINSI_ID)
				  LEFT JOIN m_kota ON (t_irna.P_JAWAB_KOTA_ID = m_kota.KOTA_ID) 
				  LEFT JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				  
				  WHERE IRNA_ID = "' . $idx . '"';
$get_masuk = mysql_query($qry_masuk) or die(mysql_error());
$dat_masuk = mysql_fetch_assoc($get_masuk);

$nomr = $dat_masuk['NOMR'];
$nama_pasien = $dat_masuk['NAMA_PASIEN'];
$tgl_lahir = $dat_masuk['TGL_LAHIR'];
$jns_kelamin = $dat_masuk['JNS_KELAMIN'];
$unit_id = $dat_masuk['NAMA_RUANG'];
$jenis_bayar_id = $dat_masuk['NAMA_JAMINAN'];
$tanggal_daftar = $dat_masuk['TANGGAL_DAFTAR'];
$dokter = $dat_masuk['NAMA_PEGAWAI'];
$no_peserta = $dat_masuk['NO_PESERTA'];
$no_sep = $dat_masuk['NO_SEP'];
$no_sjp = $dat_masuk['NO_SJP'];
$asal_pasien = $dat_masuk['ASAL_PASIEN'];
$pasien_kecelakaan = $dat_masuk['KECELAKAAN']; 
if($pasien_kecelakaan == '1') $pasien_kecelakaan = 'Darat';
if($pasien_kecelakaan == '2') $pasien_kecelakaan = 'Perairan';
if($pasien_kecelakaan == '3') $pasien_kecelakaan = 'Udara';
$lokasi_kecelakaan = $dat_masuk['LOKASI_KECELAKAAN'];
$kasus_polisi = '';
if($dat_masuk['KASUS_POLISI'] == '1') $kasus_polisi = 'Ya';

$p_jawab_nama = $dat_masuk['P_JAWAB_NAMA'];
$p_jawab_no_telp = $dat_masuk['P_JAWAB_NO_TELP'];
$p_jawab_alamat = $dat_masuk['P_JAWAB_ALAMAT'];
$p_jawab_alamat_rt = $dat_masuk['P_JAWAB_ALAMAT_RT'];
$p_jawab_alamat_rw = $dat_masuk['P_JAWAB_ALAMAT_RW'];
$p_jawab_kelurahan_id = $dat_masuk['NAMA_KELURAHAN'];
$p_jawab_kecamatan_id = $dat_masuk['NAMA_KECAMATAN'];
$p_jawab_kota_id = $dat_masuk['NAMA_KOTA'];
$p_jawab_propinsi_id = $dat_masuk['NAMA_PROPINSI'];
$p_jawab_hubungan = $dat_masuk['P_JAWAB_HUBUNGAN'];
       
$jkn_tgl_rujuk = changeDateFormat($dat_masuk['JKN_TGL_RUJUK']);
$jkn_no_rujuk = $dat_masuk['JKN_NO_RUJUK'];
$jkn_kd_pkk = $dat_masuk['JKN_KD_PKK'];
$jkn_nama_pkk = $dat_masuk['JKN_NAMA_PKK'];
$jkn_catatan = $dat_masuk['JKN_CATATAN'];
$jkn_diagnosa = $dat_masuk['JKN_DIAGNOSA'];
$jkn_poliklinik = $dat_masuk['JKN_POLIKLINIK'];
$jkn_kelas_rawat = $dat_masuk['JKN_KELAS_RAWAT'];
$jkn_pbi_nonpbi = $dat_masuk['JKN_PBI_NONPBI'];

$edoc_norm = formatNoMR($nomr);
$edoc_nama_pasien = $nama_pasien;
$edoc_tanggal_lahir = changeDateFormat($tgl_lahir);
$edoc_jenis_kelamin = jenisKelamin($jns_kelamin);
$edoc_unit = $unit_id;
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
    <td>Ruang Rawat </td>
    <td>:&nbsp;' . setGarisIfNull($unit_id) . '</td>
	<td>&nbsp;</td>
    <td>Dokter</td>
    <td>:&nbsp;' . setGarisIfNull($dokter) . '</td>
  </tr>
  <tr>
    <td>Jenis Pembayaran</td>
    <td>:&nbsp;' . setGarisIfNull($jenis_bayar_id) . '</td>
    <td>&nbsp;</td>
    <td>Nomor Peserta</td>
    <td>:&nbsp;' . setGarisIfNull($no_peserta) . '</td>
  </tr>
  <tr>
    <td>Nomor SEP</td>
    <td>:&nbsp;' . setGarisIfNull($no_sep) . '</td>
    <td>&nbsp;</td>
    <td>Nomor SJP</td>
    <td>:&nbsp;' . setGarisIfNull($no_sjp) . '</td>
  </tr>
  <tr>
    <td>Asal Pasien</td>
    <td>:&nbsp;' . setGarisIfNull($asal_pasien) . '</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Pasien Kecelakaan</td>
    <td>:&nbsp;' . setGarisIfNull($pasien_kecelakaan) . '</td>
    <td>&nbsp;</td>
    <td>Lokasi Kecelakaan</td>
    <td>:&nbsp;' . setGarisIfNull($lokasi_kecelakaan) . '</td>
  </tr>
  <tr>
    <td>Kasus Polisi</td>
    <td>:&nbsp;' . setGarisIfNull($kasus_polisi) . '</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Tanggal Rujukan</td>
    <td>:&nbsp;' . setGarisIfNull($jkn_tgl_rujuk) . '</td>
    <td>&nbsp;</td>
    <td>Nomor Rujukan</td>
    <td>:&nbsp;' . setGarisIfNull($jkn_no_rujuk) . '</td>
  </tr>
  <tr>
    <td>Diagnosa</td>
    <td>:&nbsp;' . setGarisIfNull($jkn_diagnosa) . '</td>
    <td>&nbsp;</td>
    <td>Catatan</td>
    <td>:&nbsp;' . setGarisIfNull($jkn_catatan) . '</td>
  </tr>
  <tr>
    <td>Kode Puskesmas</td>
    <td>:&nbsp;' . setGarisIfNull($jkn_kd_pkk) . '</td>
    <td>&nbsp;</td>
    <td>Nama Puskesmas</td>
    <td>:&nbsp;' . setGarisIfNull($jkn_nama_pkk) . '</td>
  </tr>
  <tr>
    <td>Kelas Rawat</td>
    <td>:&nbsp;' . setGarisIfNull($jkn_kelas_rawat) . '</td>
    <td>&nbsp;</td>
    <td>Jenis Peserta</td>
    <td>:&nbsp;' . setGarisIfNull($jkn_kelas_rawat) . '</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nama Penanggung Jawab</td>
    <td>:&nbsp;' . setGarisIfNull($p_jawab_nama) . '</td>
    <td>&nbsp;</td>
    <td>Nomor Telepon</td>
    <td>:&nbsp;' . setGarisIfNull($p_jawab_no_telp) . '</td>
  </tr>
  <tr>
    <td>Alamat</td>
    <td>:&nbsp;' . setGarisIfNull($p_jawab_alamat) . '</td>
    <td>&nbsp;</td>
    <td>Rt/Rw</td>
    <td>:&nbsp;' . setGarisIfNull($p_jawab_alamat_rt) . '/' . setGarisIfNull($p_jawab_alamat_rw) . '</td>
  </tr>
  <tr>
    <td>Propinsi</td>
    <td>:&nbsp;' . setGarisIfNull($p_jawab_propinsi_id) . '</td>
    <td>&nbsp;</td>
    <td>Kab /Kota</td>
    <td>:&nbsp;' . setGarisIfNull($p_jawab_kota_id) . '</td>
  </tr>
  <tr>
    <td>Kecamatan</td>
    <td>:&nbsp;' . setGarisIfNull($p_jawab_kecamatan_id) . '</td>
    <td>&nbsp;</td>
    <td>Kelurahan</td>
    <td>:&nbsp;' . setGarisIfNull($p_jawab_kelurahan_id) . '</td>
  </tr>
  <tr>
    <td>Hubungan Dengan Pasien</td>
    <td>:&nbsp;' . setGarisIfNull($p_jawab_hubungan) . '</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
$filename = $nomr . '_RI' . $idx . '_' . $id_document . '.pdf' ;

$mpdf = new mPDF('utf-8', array($paper_width,$paper_height));
$mpdf->autoPageBreak = false;
$mpdf->SetHTMLHeader(setHeader($nomr,$nama_pasien));
$mpdf->SetHTMLFooter(setFooter($jenis_document));
$mpdf->WriteHTML($html);
$mpdf->Output($rmfile_path . '/' . $nomr . '/' . $filename);	

saveData($nomr,$idx,'2',$id_document,$filename,$user_name,'','');
}
?>