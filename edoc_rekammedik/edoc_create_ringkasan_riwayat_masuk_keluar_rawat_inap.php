<?php
function create_pdf_ringkasan_riwayat_masuk_keluar_rawat_inap($idx){
global $rmfile_path;
global $user_name;
global $edoc_logo;
global $paper_width;
global $paper_height;
$jenis_document = 'Ringkasan Riwayat Masuk Dan Keluar';
$id_document = '20';

$qry_masuk = 'SELECT t_irna.NOMR,t_irna.IRNA_ID,t_irja.TANGGAL_DAFTAR,t_irna.JENIS_BAYAR_ID,t_irna.P_JAWAB_NAMA,
					t_irna.P_JAWAB_NO_TELP,t_irna.P_JAWAB_ALAMAT,t_irna.P_JAWAB_ALAMAT_RT,t_irna.P_JAWAB_ALAMAT_RW,
					t_irna.P_JAWAB_KELURAHAN_ID,t_irna.P_JAWAB_KECAMATAN_ID,t_irna.P_JAWAB_KOTA_ID,
					t_irna.P_JAWAB_PROPINSI_ID,t_irna.P_JAWAB_HUBUNGAN,	CONCAT(m_ruang.NAMA_RUANG,"-",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,
					m_jaminan.NAMA_JAMINAN,m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,m_propinsi.NAMA_PROPINSI,
					m_kota.NAMA_KOTA,m_pegawai.NAMA_PEGAWAI,t_irna.NO_PESERTA,t_irna.NO_SEP,t_irna.NO_SJP,
					m_unit.NAMA_UNIT AS ASAL_PASIEN,t_irna.KECELAKAAN,t_irna.LOKASI_KECELAKAAN,
					t_irna.JKN_TGL_RUJUK,t_irna.JKN_NO_RUJUK,t_irna.JKN_KD_PKK,t_irna.JKN_NAMA_PKK,t_irna.JKN_CATATAN,
					t_irna.JKN_DIAGNOSA,t_irna.JKN_POLIKLINIK,t_irna.JKN_KELAS_RAWAT,t_irna.JKN_PBI_NONPBI,
					m_pasien.NAMA_PASIEN,t_irna.KASUS_POLISI,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,m_agama.NAMA_AGAMA,
					m_pasien.PEKERJAAN,CASE m_pasien.ST_KAWIN WHEN "1" THEN "Belum Kawin"
						WHEN "2" THEN "Kawin" WHEN "3" THEN "Janda/ Duda" ELSE "" END AS ST_KAWIN,
					m_pasien.ALAMAT,m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_asal_pasien.KET_ASAL_PASIEN,
					DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d/%m/%Y") AS TANGGAL_KELUAR,
					DATEDIFF(STR_TO_DATE(DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d/%m/%Y"),"%d/%m/%Y"),STR_TO_DATE(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y")) AS LAMA_DIRAWAT,
					m_pegawai2.NAMA_PEGAWAI AS DOKTER_PERAWAT,t_irna.KOMPLIKASI,
					m_pegawai3.NAMA_PEGAWAI AS DOKTER_PENERIMA,m_pasien_keadaan_pulang.NAMA_KEADAAN,
					m_pasien_pulang.KET_PASIEN_PULANG
					FROM t_irna
				  INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				  INNER JOIN t_irja ON (t_irna.IRNA_ID = t_irja.IRJA_ID)
				  LEFT JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				  LEFT JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				  LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				  LEFT JOIN m_pegawai m_pegawai2 ON (t_irna.PEGAWAI_RAWAT_ID = m_pegawai2.PEGAWAI_ID)
				  LEFT JOIN m_pegawai m_pegawai3 ON (t_irja.PEGAWAI_ID = m_pegawai3.PEGAWAI_ID)
				  LEFT JOIN m_kelurahan ON (t_irna.P_JAWAB_KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				  LEFT JOIN m_kecamatan ON (t_irna.P_JAWAB_KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				  LEFT JOIN m_propinsi ON (t_irna.P_JAWAB_PROPINSI_ID = m_propinsi.PROPINSI_ID)
				  LEFT JOIN m_kota ON (t_irna.P_JAWAB_KOTA_ID = m_kota.KOTA_ID) 
				  LEFT JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				  LEFT JOIN m_agama ON (m_pasien.AGAMA_ID = m_agama.AGAMA_ID)
				  LEFT JOIN m_asal_pasien ON (t_irja.ASAL_PASIEN_ID = m_asal_pasien.ASAL_PASIEN_ID)
				  LEFT JOIN m_pasien_keadaan_pulang on (t_irna.KEADAAN_PULANG_ID = m_pasien_keadaan_pulang.KEADAAN_ID)
				  LEFT JOIN m_pasien_pulang on (t_irna.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
				  WHERE IRNA_ID = "' . $idx . '"';
$get_masuk = mysql_query($qry_masuk) or die(mysql_error());
$dat_masuk = mysql_fetch_assoc($get_masuk);

$nomr = $dat_masuk['NOMR'];
$nama_pasien = $dat_masuk['NAMA_PASIEN'];
$tgl_lahir = $dat_masuk['TGL_LAHIR'];
$jns_kelamin = $dat_masuk['JNS_KELAMIN'];
$unit_id = $dat_masuk['NAMA_RUANG'];
$jenis_bayar_id = $dat_masuk['JENIS_BAYAR_ID'];
$tanggal_daftar = changeDateFormat($dat_masuk['TANGGAL_DAFTAR']);
$tanggal_keluar = $dat_masuk['TANGGAL_KELUAR'];
$dokter = $dat_masuk['NAMA_PEGAWAI'];
$dokter_perawat = $dat_masuk['DOKTER_PERAWAT'];
$dokter_penerima = $dat_masuk['DOKTER_PENERIMA'];
$no_peserta = $dat_masuk['NO_PESERTA'];
$no_sep = $dat_masuk['NO_SEP'];
$no_sjp = $dat_masuk['NO_SJP'];
$asal_pasien = $dat_masuk['ASAL_PASIEN'];
$pasien_kecelakaan = $dat_masuk['KECELAKAAN']; 
if($pasien_kecelakaan == '1') $pasien_kecelakaan = 'Darat';
if($pasien_kecelakaan == '2') $pasien_kecelakaan = 'Perairan';
if($pasien_kecelakaan == '3') $pasien_kecelakaan = 'Udara';
$lokasi_kecelakaan = $dat_masuk['LOKASI_KECELAKAAN'];
$kasus_polisi = 'Tidak';
if($dat_masuk['KASUS_POLISI'] == '1') $kasus_polisi = 'Ya';
$peserta_askes = 'Ya';
if($jenis_bayar_id != '12') $peserta_askes = 'Tidak (' . $dat_masuk['NAMA_JAMINAN'] . ')'; 
$alamat = $dat_masuk['ALAMAT'];
$kelurahan = $dat_masuk['NAMA_KELURAHAN'];
$kecamatan = $dat_masuk['NAMA_KECAMATAN'];
$kabupaten = $dat_masuk['NAMA_KOTA'];
$rt = $dat_masuk['ALAMAT_RT'];
$rw = $dat_masuk['ALAMAT_RW'];
$agama = $dat_masuk['NAMA_AGAMA'];
$pekerjaan = $dat_masuk['PEKERJAAN'];
$kawin = $dat_masuk['ST_KAWIN'];
$pengirim = $dat_masuk['KET_ASAL_PASIEN'];
$lama_dirwat = $dat_masuk['LAMA_DIRAWAT'] + 1;
$komplikasi = $dat_masuk['KOMPLIKASI'];
$keadaan_pulang = $dat_masuk['NAMA_KEADAAN'];
$cara_pulang = $dat_masuk['KET_PASIEN_PULANG'];

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
$edoc_content = '<style>.tbl tr td {
	   padding-left:1px;
	   border-collapse: collapse;
	   font-size: 12px;
	}</style>
	<table width="100%" class="tbl" border="0" cellspacing="0" cellpadding="0" 
		style="border-top: 1px solid #000000;border-bottom: 1px solid #000000;border-left: 1px solid #000000;border-right: 1px solid #000000;">
  <tr>
    <td style="border-bottom: 1px solid #000000;">AGAMA</td>
    <td colspan="7" style="border-bottom: 1px solid #000000;">:&nbsp;' . setGarisIfNull($agama) . '</td>
  </tr>
  <tr>
    <td style="border-bottom: 1px solid #000000;">PEKERJAAN</td>
    <td colspan="7" style="border-bottom: 1px solid #000000;">:&nbsp;' . setGarisIfNull($pekerjaan) . '</td>
  </tr>
  <tr>
    <td style="border-bottom: 1px solid #000000;">STATUS PERKAWINAN </td>
    <td style="border-bottom: 1px solid #000000;border-right: 1px solid #000000;">:&nbsp;' . setGarisIfNull($kawin) . '</td>
    <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
    <td style="border-bottom: 1px solid #000000;">KASUS POLISI </td>
    <td style="border-bottom: 1px solid #000000;border-right: 1px solid #000000;">:&nbsp;' . setGarisIfNull($kasus_polisi) . '</td>
    <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
    <td style="border-bottom: 1px solid #000000;">PESERTA ASKES </td>
    <td style="border-bottom: 1px solid #000000;">:&nbsp;' . setGarisIfNull($peserta_askes) . '</td>
  </tr>
  <tr>
    <td>ALAMAT</td>
    <td colspan="4" style="border-right: 1px solid #000000;">:&nbsp;' . setGarisIfNull($alamat) . '</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>KELURAHAN</td>
    <td>:&nbsp;' . setGarisIfNull($kelurahan) . '</td>
    <td>&nbsp;</td>
    <td>RT/ RW</td>
    <td style="border-right: 1px solid #000000;">:&nbsp;' . setGarisIfNull($rt) . '/' . setGarisIfNull($rw) . '</td>
    <td>&nbsp;</td>
    <td>DIKIRIM OLEH </td>
    <td>:&nbsp;' . setGarisIfNull($pengirim) . '</td>
  </tr>
  <tr>
    <td style="border-bottom: 1px solid #000000;">KECAMATAN</td>
    <td style="border-bottom: 1px solid #000000;">:&nbsp;' . setGarisIfNull($kecamatan) . '</td>
    <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
    <td style="border-bottom: 1px solid #000000;">KABUPATEN/ KOTA </td>
    <td style="border-right: 1px solid #000000;border-bottom: 1px solid #000000;">:&nbsp;' . setGarisIfNull($kabupaten) . '</td>
    <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
    <td style="border-bottom: 1px solid #000000;" >&nbsp;</td>
    <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
  </tr>
  <tr>
    <td>NAMA PENANGGUNGJAWAB</td>
    <td colspan="7">:&nbsp;' . setGarisIfNull($p_jawab_nama) . '</td>
  </tr>
  <tr>
    <td>PEKERJAAN</td>
    <td colspan="7">:&nbsp;' . setGarisIfNull('') . '</td>
  </tr>
  <tr>
    <td style="border-bottom: 1px solid #000000;">ALAMAT</td>
    <td colspan="7" style="border-bottom: 1px solid #000000;">:&nbsp;' . setGarisIfNull($p_jawab_alamat) . '</td>
  </tr>
  <tr>
    <td style="border-bottom: 1px solid #000000;">RUANGAN</td>
    <td style="border-bottom: 1px solid #000000;border-right: 1px solid #000000;">:&nbsp;' . setGarisIfNull($asal_pasien) . '</td>
    <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
    <td style="border-bottom: 1px solid #000000;">TANGGAL MASUK </td>
    <td style="border-bottom: 1px solid #000000;">:&nbsp;' . setGarisIfNull($tanggal_daftar) . '</td>
    <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
    <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
    <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
  </tr>
  <tr>
    <td style="border-bottom: 1px solid #000000;">BAGIAN</td>
    <td style="border-bottom: 1px solid #000000;border-right: 1px solid #000000;">:&nbsp;' . setGarisIfNull('') . '</td>
    <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
    <td style="border-bottom: 1px solid #000000;">TANGGAL KELUAR </td>
    <td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000;">:&nbsp;' . setGarisIfNull($tanggal_keluar) . '</td>
    <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
    <td style="border-bottom: 1px solid #000000;">LAMA DIRAWAT </td>
    <td style="border-bottom: 1px solid #000000;">:&nbsp;' . setGarisIfNull($lama_dirwat) . ' HARI</td>
  </tr>';
  
  $qry_diagnosa = 'SELECT t_irja_diagnosa.DIAGNOSA,t_irja_diagnosa.ICD_CODE,t_irja_diagnosa.DIAGNOSA_ORDER
					FROM t_irja_diagnosa
					WHERE t_irja_diagnosa.IRJA_ID = "' . $idx . '"
					ORDER BY t_irja_diagnosa.DIAGNOSA_ORDER';
  $get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
  if(mysql_num_rows($get_diagnosa) == 0){
	  $edoc_content = $edoc_content . '<tr>
					<td style="border-bottom: 1px solid #000000;">DIAGNOSIS MASUK </td>
					<td colspan="7" style="border-bottom: 1px solid #000000;">:&nbsp;' . setGarisIfNull('') . '</td>
				  </tr>';
  }else if(mysql_num_rows($get_diagnosa) == 1){
	  $dat_diagnosa = mysql_fetch_assoc($get_diagnosa);
	  $diagnosa = $dat_diagnosa['DIAGNOSA'];
	  if(!empty($dat_diagnosa['ICD_CODE'])) $diagnosa = $diagnosa . ' (' . $dat_diagnosa['ICD_CODE'] . ')'; 
	  $edoc_content = $edoc_content . '<tr>
					<td style="border-bottom: 1px solid #000000;">DIAGNOSIS MASUK </td>
					<td colspan="7" style="border-bottom: 1px solid #000000;">:&nbsp;' . setGarisIfNull($diagnosa) . '</td>
				  </tr>';
  }else{	  
	$c = 1;
	while($dat_diagnosa = mysql_fetch_array($get_diagnosa)){
		$diagnosa = $dat_diagnosa['DIAGNOSA'];
		if(!empty($dat_diagnosa['ICD_CODE'])) $diagnosa = $diagnosa . ' (' . $dat_diagnosa['ICD_CODE'] . ')'; 
	
		if($c == 1){
			$edoc_content = $edoc_content . '<tr>
					<td>DIAGNOSIS MASUK </td>
					<td colspan="7">:&nbsp;' . setGarisIfNull($diagnosa) . '</td>
				  </tr>';
		}else{
			if($c  == mysql_num_rows($get_diagnosa)){
				$edoc_content = $edoc_content . '<tr>
					<td style="border-bottom: 1px solid #000000;">&nbsp;</td>
					<td colspan="7" style="border-bottom: 1px solid #000000;">&nbsp;' . setGarisIfNull($diagnosa) . '</td>
				  </tr>';
			}else{
				$edoc_content = $edoc_content . '<tr>
					<td>&nbsp;</td>
					<td colspan="7">&nbsp;' . setGarisIfNull($diagnosa) . '</td>
				  </tr>';
			}	  
		}
	$c++;
	}	
  }	
  
  $edoc_content = $edoc_content . '<tr>
    <td style="border-bottom: 1px solid #000000;">DOKTER YANG MENERIMA </td>
    <td style="border-bottom: 1px solid #000000;border-right: 1px solid #000000;  ">:&nbsp;' . setGarisIfNull($dokter_penerima) . '</td>
    <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
    <td style="border-bottom: 1px solid #000000;">DOKTER YANG MERAWAT </td>
    <td colspan="4" style="border-bottom: 1px solid #000000;">:&nbsp;' . setGarisIfNull($dokter_perawat) . '</td>
  </tr>';
  
  $qry_diagnosa = 'SELECT t_irna_diagnosa_pulang.DIAGNOSA,t_irna_diagnosa_pulang.ICD_CODE,t_irna_diagnosa_pulang.DIAGNOSA_ORDER
					FROM t_irna_diagnosa_pulang
					WHERE t_irna_diagnosa_pulang.IRNA_ID = "' . $idx . '"
					ORDER BY t_irna_diagnosa_pulang.DIAGNOSA_ORDER';
  $get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
  if(mysql_num_rows($get_diagnosa) == 0){
	  $edoc_content = $edoc_content . '<tr>
					<td style="border-bottom: 1px solid #000000;">DIAGNOSIS AKHIR </td>
					<td colspan="7" style="border-bottom: 1px solid #000000;">:&nbsp;' . setGarisIfNull('') . '</td>
				  </tr>';
  }else if(mysql_num_rows($get_diagnosa) == 1){
	  $dat_diagnosa = mysql_fetch_assoc($get_diagnosa);
	  $diagnosa = $dat_diagnosa['DIAGNOSA'];
	  if(!empty($dat_diagnosa['ICD_CODE'])) $diagnosa = $diagnosa . ' (' . $dat_diagnosa['ICD_CODE'] . ')'; 
	  $edoc_content = $edoc_content . '<tr>
					<td style="border-bottom: 1px solid #000000;">DIAGNOSIS AKHIR </td>
					<td colspan="7" style="border-bottom: 1px solid #000000;">:&nbsp;' . setGarisIfNull($diagnosa) . '</td>
				  </tr>';
  }else{	  
	$c = 1;
	while($dat_diagnosa = mysql_fetch_array($get_diagnosa)){
		$diagnosa = $dat_diagnosa['DIAGNOSA'];
		if(!empty($dat_diagnosa['ICD_CODE'])) $diagnosa = $diagnosa . ' (' . $dat_diagnosa['ICD_CODE'] . ')'; 
	
		if($c == 1){
			$edoc_content = $edoc_content . '<tr>
					<td>DIAGNOSIS AKHIR </td>
					<td colspan="7">:&nbsp;' . setGarisIfNull($diagnosa) . '</td>
				  </tr>';
		}else{
			if($c  == mysql_num_rows($get_diagnosa)){
				$edoc_content = $edoc_content . '<tr>
					<td style="border-bottom: 1px solid #000000;">&nbsp;</td>
					<td colspan="7" style="border-bottom: 1px solid #000000;">&nbsp;' . setGarisIfNull($diagnosa) . '</td>
				  </tr>';
			}else{
				$edoc_content = $edoc_content . '<tr>
					<td>&nbsp;</td>
					<td colspan="7">&nbsp;' . setGarisIfNull($diagnosa) . '</td>
				  </tr>';
			}	  
		}
	$c++;
	}	
  }
  
  $edoc_content = $edoc_content . '<tr>
    <td style="border-bottom: 1px solid #000000;">KOMPLIKASI</td>
    <td colspan="7" style="border-bottom: 1px solid #000000;">:&nbsp;' . setGarisIfNull($komplikasi) . '</td>
  </tr>
  <tr>
    <td>NAMA OPERASI/ BIOPSI </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>TANGGAL</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>KODE</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
    <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
    <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
    <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
    <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
    <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
    <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
    <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
  </tr>';
  
  $qry_imunisasi = 'SELECT DISTINCT CASE WHEN IMUNISASI = "1" THEN "BCG"
						WHEN IMUNISASI = "2" THEN "DPT"
						WHEN IMUNISASI = "3" THEN "Campak"
						WHEN IMUNISASI = "4" THEN "Polio"
						WHEN IMUNISASI = "5" THEN "Tetanus Formal Foxoid"
						END AS IMUNISASI
					FROM (
					SELECT t_irna_tarif.IRNA_ID AS IDX,m_tarif.IMUNISASI, 
					t_irna_tarif.KUANTITI,m_tarif.KODE_TARIF,t_irna_tarif.NO_TARIF,
					t_irna_tarif.ST_BAYAR
					FROM t_irna_tarif
					INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
					WHERE (m_tarif.IMUNISASI <> "" AND m_tarif.IMUNISASI IS NOT NULL)
					AND t_irna_tarif.NO_TARIF IS NOT NULL
					AND (t_irna_tarif.ST_BAYAR IS NULL OR t_irna_tarif.ST_BAYAR = "Lunas")
					AND t_irna_tarif.IRNA_ID = "' . $idx . '" 					
					UNION ALL
					SELECT t_irja_tarif.IRJA_ID AS IDX,m_tarif.IMUNISASI, 
					t_irja_tarif.KUANTITI, m_tarif.KODE_TARIF, t_irja_tarif.NO_TARIF,
					t_irja_tarif.ST_BAYAR
					FROM t_irja_tarif
					INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
					WHERE (m_tarif.IMUNISASI <> "" AND m_tarif.IMUNISASI IS NOT NULL)
					AND t_irja_tarif.NO_TARIF IS NOT NULL
					AND (t_irja_tarif.ST_BAYAR IS NULL OR t_irja_tarif.ST_BAYAR = "Lunas")
					AND t_irja_tarif.IRJA_ID = "' . $idx . '"
					) t_im';
	$get_imunisasi = mysql_query($qry_imunisasi) or die(mysql_error());
	$imunisasi = '';
	while($dat_imunisasi = mysql_fetch_array($get_imunisasi)){
		$imunisasi = $imunisasi . $dat_imunisasi['IMUNISASI'] . ',';
	}		
	$imunisasi = substr($imunisasi,0,strlen($imunisasi) - 1);
	$edoc_content = $edoc_content . '<tr>
						<td style="border-bottom: 1px solid #000000;">IMUNISASI </td>
						<td colspan="7" style="border-bottom: 1px solid #000000;">:&nbsp;' . setGarisIfNull($imunisasi) . '</td>
					  </tr>';
  $edoc_content = $edoc_content . '<tr>
		<td style="border-bottom: 1px solid #000000;">KEADAAN KELUAR </td>
		<td style="border-bottom: 1px solid #000000;border-right: 1px solid #000000;">:&nbsp;' . setGarisIfNull($keadaan_pulang) . '</td>
		<td style="border-bottom: 1px solid #000000;">&nbsp;</td>
		<td style="border-bottom: 1px solid #000000;">CARA KELUAR </td>
		<td style="border-bottom: 1px solid #000000;border-right: 1px solid #000000;">:&nbsp;' . setGarisIfNull($cara_pulang) . '</td>
		<td style="border-bottom: 1px solid #000000;">&nbsp;</td>
		<td style="border-bottom: 1px solid #000000;">TRANSFUSI DARAH </td>
		<td style="border-bottom: 1px solid #000000;">:&nbsp;</td>
	  </tr>
	  <tr>
		<td>DOKTER PENANGGUNGJAWAB</td>
		<td colspan="7">:&nbsp;' . setGarisIfNull($dokter) . '</td>
	  </tr>
	</table>';

$sebab_kematian[1] = '';
$sebab_kematian[2] = '';
$sebab_kematian[3] = '';
$sebab_kematian[4] = '';

$mati_redupaksa[1] = '';
$mati_redupaksa[2] = '';
$mati_redupaksa[3] = '';

$kelahiran_mati[1] = '';
$kelahiran_mati[2] = '';

$persalinan_mati[1] = '';
$persalinan_mati[2] = '';

$operasi_mati[1] = '';
$operasi_mati[2] = '';

$qry_kematian = 'SELECT t_irna.SEBAB_KEMATIAN,t_irna.SEBAB_KEMATIAN_REDUPAKSA,t_irna.SEBAB_KEMATIAN_KELAHIRAN,
			t_irna.SEBAB_KEMATIAN_PERSALINAN,t_irna.SEBAB_KEMATIAN_OPERASI
			FROM t_irna
			WHERE t_irna.IRNA_ID = "' . $idx . '"';
$get_kematian = mysql_query($qry_kematian) or die(mysql_error());
$dat_kematian = mysql_fetch_assoc($get_kematian);

$f_sebab_mati = explode('|*|',$dat_kematian['SEBAB_KEMATIAN']);
if(count($f_sebab_mati) > 1){
	$sebab_kematian[1] = $f_sebab_mati[0];
	$sebab_kematian[2] = $f_sebab_mati[1];
	$sebab_kematian[3] = $f_sebab_mati[2];
	$sebab_kematian[4] = $f_sebab_mati[3];
}
$f_mati_redupaksa = explode('|*|',$dat_kematian['SEBAB_KEMATIAN_REDUPAKSA']);
if(count($f_mati_redupaksa) > 1){
	$mati_redupaksa[1] = $f_mati_redupaksa[0];
	$mati_redupaksa[2] = $f_mati_redupaksa[1];
	$mati_redupaksa[3] = $f_mati_redupaksa[2];
}
$f_kelahiran_mati = explode('|*|',$dat_kematian['SEBAB_KEMATIAN_KELAHIRAN']);
if(count($f_kelahiran_mati) > 1){
	$kelahiran_mati[1] = $f_kelahiran_mati[0];
	$kelahiran_mati[2] = $f_kelahiran_mati[1];
}
$f_persalinan_mati = explode('|*|',$dat_kematian['SEBAB_KEMATIAN_PERSALINAN']);
if(count($f_persalinan_mati) > 1){
	$persalinan_mati[1] = $f_persalinan_mati[0];
	$persalinan_mati[2] = $f_persalinan_mati[1];
}
$f_operasi_mati = explode('|*|',$dat_kematian['SEBAB_KEMATIAN_OPERASI']);
if(count($f_operasi_mati) > 1){
	$operasi_mati[1] = $f_operasi_mati[0];
	$operasi_mati[2] = $f_operasi_mati[1];
}

$edoc_content_2 = '<table width="100%" border="0" cellspacing="0" cellpadding="0" > 
  <tr>
    <td colspan="6"><strong>SEBAB KEMATIAN :</strong></td>
  </tr>
  <tr>
    <td rowspan="2" scope="row" valign="top">a.</td>
    <td rowspan="2" scope="row">&nbsp;</td>
    <td rowspan="2" scope="row" width="350" valign="top">Penyakit atau keadaan yang langsung mengakibatkan kematian</td>
    <td>&nbsp;</td>
    <td rowspan="2" width="100">' . setGarisIfNull($sebab_kematian[1]) . '</td>
    <td colspan="2" rowspan="2" valign="top">&nbsp;Penyakit tersebut dalam ruang adalah disebabkan oleh (atau akibat dari).</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="3" scope="row" valign="top">b.</td>
    <td rowspan="3" scope="row">&nbsp;</td>
    <td rowspan="3" scope="row" valign="top">Penyakit-penyakit (bila ada) yang menjadi lantaran timbulnya sebab kematian tersebut pada a, dengan menyebut penyakit yang menjadi poko pangkal terakhir. </td>
    <td>&nbsp;</td>
    <td rowspan="3">' . setGarisIfNull($sebab_kematian[2]) . '</td>
    <td colspan="2" rowspan="3" valign="top">&nbsp;Penyakit tersebut dalam ruang adalah disebabkan oleh (atau akibat dari). c. </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2" scope="row">&nbsp;</td>
    <td rowspan="2" scope="row">&nbsp;</td>
    <td rowspan="2" scope="row">Lamanya (kira-kira) :
    mulai sakit hingga meninggal dunia.</td>
    <td>&nbsp;</td>
    <td rowspan="2">' . setGarisIfNull($sebab_kematian[3]) . '</td>
    <td colspan="2" rowspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td scope="row" valign="top">c.</td>
    <td scope="row">&nbsp;</td>
    <td scope="row">Penyakit-penyakit lain yang berarti dan mempengaruhi pula kematian itu, tetapi tidak ada hubungannya dengan penyakit-penyakit a,b,c </td>
    <td>&nbsp;</td>
    <td>' . setGarisIfNull($sebab_kematian[4]) . '</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td colspan="2" scope="row">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td colspan="2" scope="row">Keterangan Khusus Untuk : </td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
    <tr>
    <td scope="row">&nbsp;</td>
    <td colspan="2" scope="row">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row"><strong>Mati Karena Redupaksa</strong> </td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row" valign="top">Macam Redupaksa </td>
    <td>&nbsp;</td>
	<td colspan="3"><input type="checkbox" name="mati_redupaksa_1" value="1" ' . (($mati_redupaksa[1] == '1') ? 'checked="checked"' : '') . ' />Bunuh Diri 
					<input type="checkbox" name="mati_redupaksa_1" value="2" ' . (($mati_redupaksa[1] == '2') ? 'checked="checked"' : '') . '/>Pembunuhan 
					<input type="checkbox" name="mati_redupaksa_1" value="3" ' . (($mati_redupaksa[1] == '3') ? 'checked="checked"' : '') . '/>Kecelakaan </td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row">Cara Kejadian Redupaksa </td>
    <td>&nbsp;</td>
	<td colspan="3">' . setGarisIfNull($mati_redupaksa[2]) . '</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row">Sifat Jelas (Kerusakan Tubuh) </td>
    <td>&nbsp;</td>
	<td colspan="3">' . setGarisIfNull($mati_redupaksa[3]) . '</td>
  </tr>
  <tr>
    <td colspan="3" scope="row">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row"><strong>Kelahiran Mati </strong></td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row">Apakah Ini Janin Lahir Mati </td>
    <td>&nbsp;</td>
	<td><input type="checkbox" name="kelahiran_mati_1" value="1" ' . (($kelahiran_mati[1] == '1') ? 'checked="checked"' : '') . ' />Ya 
					<input type="checkbox" name="kelahiran_mati_1" value="2" ' . (($kelahiran_mati[1] == '2') ? 'checked="checked"' : '') . ' />Tidak </td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row">Sebab Kelahiran Mati </td>
    <td>&nbsp;</td>
	<td colspan="3">' . setGarisIfNull($kelahiran_mati[2]) . '</td>
  </tr>
  <tr>
    <td colspan="3" scope="row">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row"><strong>Persalinan, Kehamilan</strong> </td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row">Apakah Ini Peristiwa Persalinan </td>
    <td>&nbsp;</td>
	<td><input type="checkbox" name="persalinan_mati_1" value="1" ' . (($persalinan_mati[1] == '1') ? 'checked="checked"' : '') . ' />Ya 
					<input type="checkbox" name="persalinan_mati_1" value="2" ' . (($persalinan_mati[1] == '2') ? 'checked="checked"' : '') . ' />Tidak </td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row">Apakah Ini Peristiwa Kehamilan </td>
    <td>&nbsp;</td>
	<td><input type="checkbox" name="persalinan_mati_2" value="1" ' . (($persalinan_mati[2] == '1') ? 'checked="checked"' : '') . ' />Ya 
					<input type="checkbox" name="persalinan_mati_2" value="2" ' . (($persalinan_mati[2] == '2') ? 'checked="checked"' : '') . ' />Tidak</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" scope="row">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row"><strong>Operasi</strong></td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row">Apakah Disini Dilakukan Operasi </td>
    <td>&nbsp;</td>
	<td><input type="checkbox" name="operasi_mati_1" value="1" ' . (($operasi_mati[2] == '1') ? 'checked="checked"' : '') . ' />Ya 
					<input type="checkbox" name="operasi_mati_1" value="2" ' . (($operasi_mati[2] == '2') ? 'checked="checked"' : '') . ' />Tidak</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row">Jenis Operasi </td>
    <td>&nbsp;</td>
	<td colspan="3">' . setGarisIfNull($operasi_mati[2]) . '</td>
  </tr>
  </table>';

ob_start();
include('edoc_rekammedik/edoc_frame_main.php');
$html = ob_get_contents();
ob_end_clean();

ob_start();
include('edoc_rekammedik/edoc_frame_add.php');
$html2 = ob_get_contents();
ob_end_clean();

createFolder($nomr);
$filename = $nomr . '_RI' . $idx . '_' . $id_document . '.pdf' ;

$mpdf = new mPDF('utf-8', array($paper_width,$paper_height));
$mpdf->autoPageBreak = false;
$mpdf->SetHTMLHeader(setHeader($nomr,$nama_pasien));
$mpdf->SetHTMLFooter(setFooter($jenis_document));
$mpdf->WriteHTML($html);
$mpdf->AddPage('P');
$mpdf->WriteHTML($html2);
$mpdf->Output($rmfile_path . '/' . $nomr . '/' . $filename);	

saveData($nomr,$idx,'2',$id_document,$filename,$user_name,'','');
}
?>