<?php
function create_pdf_ringkasan_kunjungan_rawat_jalan($idx){
global $rmfile_path;
global $user_name;
global $edoc_logo;
global $paper_width;
global $paper_height;
$jenis_document = 'Ringkasan Kunjungan';
$id_document = '2';

if($idx == '350205') echo $idx;

$qry_kunjungan = 'SELECT t_irja.NOMR,t_irja.IRJA_ID,t_irja.TANGGAL_DAFTAR,t_irja.ST_BARU,t_irja.UNIT_ID,
					t_irja.JENIS_BAYAR_ID,t_irja.P_JAWAB_NAMA,t_irja.P_JAWAB_NO_TELP,t_irja.P_JAWAB_ALAMAT,
					t_irja.P_JAWAB_ALAMAT_RT,t_irja.P_JAWAB_ALAMAT_RW,t_irja.P_JAWAB_KELURAHAN_ID,t_irja.P_JAWAB_KECAMATAN_ID,
					t_irja.P_JAWAB_KOTA_ID,t_irja.P_JAWAB_PROPINSI_ID,t_irja.P_JAWAB_HUBUNGAN,m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,
					m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,m_propinsi.NAMA_PROPINSI,m_kota.NAMA_KOTA,m_pegawai.NAMA_PEGAWAI,
					t_irja.NO_PESERTA,t_irja.NO_SEP,t_irja.NO_SJP,m_asal_pasien.KET_ASAL_PASIEN AS ASAL_PASIEN,t_irja.KET_ASAL_PASIEN,
					t_irja.PASIEN_MASUK,t_irja.KECELAKAAN,t_irja.LOKASI_KECELAKAAN,
					t_irja.JKN_TGL_RUJUK,t_irja.JKN_NO_RUJUK,t_irja.JKN_KD_PKK,t_irja.JKN_NAMA_PKK,t_irja.JKN_CATATAN,
					t_irja.JKN_DIAGNOSA,t_irja.JKN_POLIKLINIK,t_irja.JKN_KELAS_RAWAT,t_irja.JKN_PBI_NONPBI,
					t_irja.MCU,m_pasien.NAMA_PASIEN,t_irja.KASUS_POLISI,
					m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN
					FROM t_irja
				  INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				  LEFT JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				  LEFT JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				  LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				  LEFT JOIN m_asal_pasien ON (t_irja.ASAL_PASIEN_ID = m_asal_pasien.ASAL_PASIEN_ID)
				  LEFT JOIN m_kelurahan ON (t_irja.P_JAWAB_KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				  LEFT JOIN m_kecamatan ON (t_irja.P_JAWAB_KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				  LEFT JOIN m_propinsi ON (t_irja.P_JAWAB_PROPINSI_ID = m_propinsi.PROPINSI_ID)
				  LEFT JOIN m_kota ON (t_irja.P_JAWAB_KOTA_ID = m_kota.KOTA_ID) 
				  WHERE IRJA_ID = "' . $idx . '"';
$get_kunjungan = mysql_query($qry_kunjungan) or die(mysql_error());
$dat_kunjungan = mysql_fetch_assoc($get_kunjungan);

$nomr = $dat_kunjungan['NOMR'];
$nama_pasien = $dat_kunjungan['NAMA_PASIEN'];
$tgl_lahir = $dat_kunjungan['TGL_LAHIR'];
$jns_kelamin = $dat_kunjungan['JNS_KELAMIN'];
$unit_id = $dat_kunjungan['NAMA_UNIT'];
if($dat_kunjungan['MCU'] != '') $unit_id = $unit_id . '(Medical Checkup)';
$jenis_bayar_id = $dat_kunjungan['NAMA_JAMINAN'];
$tanggal_daftar = $dat_kunjungan['TANGGAL_DAFTAR'];
$dokter = $dat_kunjungan['NAMA_PEGAWAI'];
$no_peserta = $dat_kunjungan['NO_PESERTA'];
$no_sep = $dat_kunjungan['NO_SEP'];
$no_sjp = $dat_kunjungan['NO_SJP'];
$asal_pasien = $dat_kunjungan['ASAL_PASIEN'];
$ket_asal_pasien = $dat_kunjungan['KET_ASAL_PASIEN']; 
$pasien_kecelakaan = $dat_kunjungan['KECELAKAAN']; 
if($pasien_kecelakaan == '1') $pasien_kecelakaan = 'Darat';
if($pasien_kecelakaan == '2') $pasien_kecelakaan = 'Perairan';
if($pasien_kecelakaan == '3') $pasien_kecelakaan = 'Udara';
$lokasi_kecelakaan = $dat_kunjungan['LOKASI_KECELAKAAN'];
$kasus_polisi = '';
if($dat_kunjungan['KASUS_POLISI'] == '1') $kasus_polisi = 'Ya';

$p_jawab_nama = $dat_kunjungan['P_JAWAB_NAMA'];
$p_jawab_no_telp = $dat_kunjungan['P_JAWAB_NO_TELP'];
$p_jawab_alamat = $dat_kunjungan['P_JAWAB_ALAMAT'];
$p_jawab_alamat_rt = $dat_kunjungan['P_JAWAB_ALAMAT_RT'];
$p_jawab_alamat_rw = $dat_kunjungan['P_JAWAB_ALAMAT_RW'];
$p_jawab_kelurahan_id = $dat_kunjungan['NAMA_KELURAHAN'];
$p_jawab_kecamatan_id = $dat_kunjungan['NAMA_KECAMATAN'];
$p_jawab_kota_id = $dat_kunjungan['NAMA_KOTA'];
$p_jawab_propinsi_id = $dat_kunjungan['NAMA_PROPINSI'];
$p_jawab_hubungan = $dat_kunjungan['P_JAWAB_HUBUNGAN'];
       
$jkn_tgl_rujuk = changeDateFormat($dat_kunjungan['JKN_TGL_RUJUK']);
$jkn_no_rujuk = $dat_kunjungan['JKN_NO_RUJUK'];
$jkn_kd_pkk = $dat_kunjungan['JKN_KD_PKK'];
$jkn_nama_pkk = $dat_kunjungan['JKN_NAMA_PKK'];
$jkn_catatan = $dat_kunjungan['JKN_CATATAN'];
$jkn_diagnosa = $dat_kunjungan['JKN_DIAGNOSA'];
$jkn_poliklinik = $dat_kunjungan['JKN_POLIKLINIK'];
$jkn_kelas_rawat = $dat_kunjungan['JKN_KELAS_RAWAT'];
$jkn_pbi_nonpbi = $dat_kunjungan['JKN_PBI_NONPBI'];

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
    <td>Klinik Tujuan </td>
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
    <td>Keterangan Asal Pasien</td>
    <td>:&nbsp;' . setGarisIfNull($ket_asal_pasien) . '</td>
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
$filename = $nomr . '_RJ' . $idx . '_' . $id_document . '.pdf' ;

$mpdf = new mPDF('utf-8', array($paper_width,$paper_height));
$mpdf->autoPageBreak = false;
$mpdf->SetHTMLHeader(setHeader($nomr,$nama_pasien));
$mpdf->SetHTMLFooter(setFooter($jenis_document));
$mpdf->WriteHTML($html);
$mpdf->Output($rmfile_path . '/' . $nomr . '/' . $filename);	

saveData($nomr,$idx,'1',$id_document,$filename,$user_name,'','');
}
?>