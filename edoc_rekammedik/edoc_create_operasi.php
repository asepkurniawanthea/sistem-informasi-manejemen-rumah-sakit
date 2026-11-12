<?php
function create_pdf_operasi($idx){
global $rmfile_path;
global $user_name;	
global $edoc_logo;
global $paper_width;
global $paper_height;
global $adline;

$id_document = '21';
$st_print = false;	
$st_ls = false;

$qry_perawat = 'SELECT m_pegawai.PEGAWAI_ID,
			m_pegawai.NAMA_PEGAWAI
			FROM m_pegawai
			INNER JOIN m_pegawai_tipe 
			ON (m_pegawai.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
			ORDER BY m_pegawai.NAMA_PEGAWAI';
$rsl_perawat = mysql_query($qry_perawat);
$arr_perawat = array();
$arr_perawat[''] = '__________';
while ($dat_perawat = mysql_fetch_array($rsl_perawat)) {
    $arr_perawat[$dat_perawat['PEGAWAI_ID']] = $dat_perawat['NAMA_PEGAWAI'];
}

$qry_pasien = 'SELECT "RI" AS ORD,t_operasi.OPERASI_ID,t_operasi.NOMR,t_operasi.PEGAWAI_PELAKSANA_ID,
				t_irna.RUANG_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
				m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
				DATE_FORMAT(t_operasi.JAM_OPERASI,"%H:%i") AS JAM_OPERASI,
				t_operasi.JENIS_BAYAR_ID,t_operasi.KELAS_RAWAT,
				t_irna.KASUS_POLISI,m_pegawai.NAMA_PEGAWAI AS NAMA_DOKTER,
				m_ruang.NAMA_RUANG,t_irna.KELAS_JAMINAN,t_operasi.RAWAT_ID,
				t_operasi.JENIS_OPERASI,t_operasi.KET_JENIS_OPERASI,
				t_operasi.TIPE_OPERASI,t_operasi.JENIS_LUKA,t_operasi.LAMA_OPERASI,
				t_operasi.ASA_SCORE,t_operasi.RISK_SCORE,
				t_operasi.PERUBAHAN_JADWAL,t_operasi.TANGGAL_PELAKSANAAN_OPERASI,
				t_operasi.KETERANGAN_PERUBAHAN_JADWAL,t_operasi.CARA_DIRAWAT,
				DATE_FORMAT(TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
				DATE_FORMAT(JAM_OPERASI,"%H") AS JAM_OPERASI,
				DATE_FORMAT(JAM_OPERASI,"%i") AS MENIT_OPERASI,
				DATE_FORMAT(TANGGAL_PELAKSANAAN_OPERASI,"%d/%m/%Y") AS TANGGAL_PELAKSANAAN_OPERASI,
				DATE_FORMAT(TANGGAL_PELAKSANAAN_OPERASI,"%H") AS JAM_PELAKSANAAN_OPERASI,
				DATE_FORMAT(TANGGAL_PELAKSANAAN_OPERASI,"%i") AS MENIT_PELAKSANAAN_OPERASI 
				FROM t_operasi
				INNER JOIN t_irna ON (t_irna.IRNA_ID = t_operasi.RAWAT_ID)
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_operasi.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_pegawai ON (t_operasi.PEGAWAI_PELAKSANA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_operasi.OPERASI_ID = "' . $idx . '"
				AND (t_operasi.JNS_ORDER = "IRN" OR t_operasi.ST_MASUK = "2")
				UNION
				SELECT "RJ" AS ORD,t_operasi.OPERASI_ID,t_operasi.NOMR,t_operasi.PEGAWAI_PELAKSANA_ID,
				t_irja.UNIT_ID AS RUANG_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
				m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
				DATE_FORMAT(t_operasi.JAM_OPERASI,"%H:%i") AS JAM_OPERASI,
				t_operasi.JENIS_BAYAR_ID,t_operasi.KELAS_RAWAT,
				t_irja.KASUS_POLISI,m_pegawai.NAMA_PEGAWAI AS NAMA_DOKTER,
				m_unit.NAMA_UNIT AS NAMA_RUANG,"3" AS KELAS_JAMINAN,t_operasi.RAWAT_ID,
				t_operasi.JENIS_OPERASI,t_operasi.KET_JENIS_OPERASI,
				t_operasi.TIPE_OPERASI,t_operasi.JENIS_LUKA,t_operasi.LAMA_OPERASI,
				t_operasi.ASA_SCORE,t_operasi.RISK_SCORE,
				t_operasi.PERUBAHAN_JADWAL,t_operasi.TANGGAL_PELAKSANAAN_OPERASI,
				t_operasi.KETERANGAN_PERUBAHAN_JADWAL,t_operasi.CARA_DIRAWAT,
				DATE_FORMAT(TANGGAL_OPERASI,"%d/%m/%Y") AS TANGGAL_OPERASI,
				DATE_FORMAT(JAM_OPERASI,"%H") AS JAM_OPERASI,
				DATE_FORMAT(JAM_OPERASI,"%i") AS MENIT_OPERASI,
				DATE_FORMAT(TANGGAL_PELAKSANAAN_OPERASI,"%d/%m/%Y") AS TANGGAL_PELAKSANAAN_OPERASI,
				DATE_FORMAT(TANGGAL_PELAKSANAAN_OPERASI,"%H") AS JAM_PELAKSANAAN_OPERASI,
				DATE_FORMAT(TANGGAL_PELAKSANAAN_OPERASI,"%i") AS MENIT_PELAKSANAAN_OPERASI
				FROM t_operasi
				INNER JOIN t_irja ON (t_irja.IRJA_ID = t_operasi.RAWAT_ID)
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_operasi.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_pegawai ON (t_operasi.PEGAWAI_PELAKSANA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_operasi.OPERASI_ID = "' . $idx . '"
				AND t_operasi.JNS_ORDER = "IRJ" AND t_operasi.ST_MASUK = "1"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);

$nomr = $dat_pasien['NOMR'];
$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = $dat_pasien['TGL_LAHIR'];
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$nama_ruang = $dat_pasien['NAMA_RUANG'];
$rawat_id = $dat_pasien['RAWAT_ID'];
$pegawai_id = $dat_pasien['PEGAWAI_PELAKSANA_ID'];
$jnsorder = $dat_pasien['ORD'];

$jenis_operasi = $dat_pasien['JENIS_OPERASI'];
$ket_jenis_operasi = $dat_pasien['KET_JENIS_OPERASI'];
$tipe_operasi = $dat_pasien['TIPE_OPERASI'];
$jenis_luka = $dat_pasien['JENIS_LUKA'];
$lama_operasi = $dat_pasien['LAMA_OPERASI'];
$asa_score = $dat_pasien['ASA_SCORE'];
$risk_score = $dat_pasien['RISK_SCORE'];

$plks_tanggal_operasi = $dat_pasien['TANGGAL_PELAKSANAAN_OPERASI'];
$plks_jam_operasi = $dat_pasien['JAM_PELAKSANAAN_OPERASI'];
$plks_menit_operasi = $dat_pasien['MENIT_PELAKSANAAN_OPERASI'];
if($plks_tanggal_operasi == '' or $plks_tanggal_operasi == '00/00/0000'){
	$plks_tanggal_operasi = $dat_pasien['TANGGAL_OPERASI'];
	$plks_jam_operasi = $dat_pasien['JAM_OPERASI'];
	$plks_menit_operasi = $dat_pasien['MENIT_OPERASI'];
}	

$perubahan_jadwal = $dat_pasien['PERUBAHAN_JADWAL'];
$keterangan_perubahan = $dat_pasien['KETERANGAN_PERUBAHAN_JADWAL'];
$cara_dirawat = $dat_pasien['CARA_DIRAWAT'];

$edoc_norm = formatNoMR($nomr);
$edoc_nama_pasien = $nama_pasien;
$edoc_tanggal_lahir = $tgl_lahir;
$edoc_jenis_kelamin = jenisKelamin($jns_kelamin);
$edoc_unit = $nama_ruang;

createFolder($nomr);
$filename = $nomr . '_' . $jnsorder . $rawat_id . '_' . $id_document . '_' . $idx . '.pdf' ;

$mpdf = new mPDF('utf-8', array($paper_width,$paper_height));
$mpdf->autoPageBreak = false;
$mpdf->SetHTMLHeader(setHeader($nomr,$nama_pasien));
$mpdf->SetHTMLFooter(setFooter('Operasi'));

//Formulir Persetujuan Tindakan Kedokteran
$edoc_nama_documen = strtoupper('Formulir Persetujuan Tindakan Kedokteran');

$qry_perst_dokter = 'SELECT t_operasi_persetujuan_dokter.PERSETUJUAN_DOKTER_ID,
				DATE_FORMAT(t_operasi_persetujuan_dokter.TANGGAL_PERSETUJUAN,"%d %M %Y") AS TANGGAL_PERSETUJUAN,
				t_operasi_persetujuan_dokter.PEMBERI_INFORMASI,
				t_operasi_persetujuan_dokter.PENERIMA_INFORMASI,t_operasi_persetujuan_dokter.NAMA_PENERIMA_INFORMASI,
				t_operasi_persetujuan_dokter.ALAMAT,t_operasi_persetujuan_dokter.JNS_KEL,t_operasi_persetujuan_dokter.UMUR,
				t_operasi_persetujuan_dokter.DIAG_WD_DD,t_operasi_persetujuan_dokter.DASAR_DIAG,t_operasi_persetujuan_dokter.TIND_DOKTER,
				t_operasi_persetujuan_dokter.TIND_DOKTER_SEKUNDER,t_operasi_persetujuan_dokter.INDIKASI_TINDK,
				t_operasi_persetujuan_dokter.TATA_CARA,t_operasi_persetujuan_dokter.TUJUAN,t_operasi_persetujuan_dokter.RESIKO,
				t_operasi_persetujuan_dokter.KOMPLIKASI,t_operasi_persetujuan_dokter.PRONOSIS,t_operasi_persetujuan_dokter.ALT_RESIKO,
				t_operasi_persetujuan_dokter.PENYELAMATAN_PASIEN,t_operasi_persetujuan_dokter.LAIN_LAIN,
				t_operasi_persetujuan_dokter.TIND_DOKTER1,t_operasi_persetujuan_dokter.SAKSI_1,t_operasi_persetujuan_dokter.SAKSI_2,
				t_operasi_persetujuan_dokter.PERSETUJUAN
				FROM t_operasi_persetujuan_dokter
				WHERE t_operasi_persetujuan_dokter.OPERASI_ID = "' . $idx . '"';
$get_perst_dokter = mysql_query($qry_perst_dokter) or die(mysql_error());
if(mysql_num_rows($get_perst_dokter) > 0){
	$dat_perst_dokter = mysql_fetch_assoc($get_perst_dokter);

	$persetujuan_dokter_id = $dat_perst_dokter['PERSETUJUAN_DOKTER_ID'];
	$tanggal_persetujuan = $dat_perst_dokter['TANGGAL_PERSETUJUAN'];
	$pemberi_informasi = $dat_perst_dokter['PEMBERI_INFORMASI'];
	$penerima_informasi = $dat_perst_dokter['PENERIMA_INFORMASI'];
	$nama_penerima_informasi = $dat_perst_dokter['NAMA_PENERIMA_INFORMASI'];
	$alamat = $dat_perst_dokter['ALAMAT'];
	$jns_kel = $dat_perst_dokter['JNS_KEL'];
	$umur = $dat_perst_dokter['UMUR'];
	$diag_wd_dd = $dat_perst_dokter['DIAG_WD_DD'];
	$dasar_diag = $dat_perst_dokter['DASAR_DIAG'];
	$tind_dokter = $dat_perst_dokter['TIND_DOKTER'];
	$tind_dokter_sekunder = $dat_perst_dokter['TIND_DOKTER_SEKUNDER'];
	$indikasi_tindk = $dat_perst_dokter['INDIKASI_TINDK'];
	$tata_cara = $dat_perst_dokter['TATA_CARA'];
	$tujuan = $dat_perst_dokter['TUJUAN'];
	$resiko = $dat_perst_dokter['RESIKO'];
	$komplikasi = $dat_perst_dokter['KOMPLIKASI'];
	$pronosis = $dat_perst_dokter['PRONOSIS'];
	$alt_resiko = $dat_perst_dokter['ALT_RESIKO'];
	$penyelamatan_pasien = $dat_perst_dokter['PENYELAMATAN_PASIEN'];
	$lain_lain = $dat_perst_dokter['LAIN_LAIN'];
	$tind_dokter1 = $dat_perst_dokter['TIND_DOKTER1'];
	$saksi_1 = $dat_perst_dokter['SAKSI_1'];
	$saksi_2 = $dat_perst_dokter['SAKSI_2'];
	$persetujuan = explode('|',$dat_perst_dokter['PERSETUJUAN']);
		
	$edoc_content = '<style>.tbl tr td {
	   border: 1px solid black;
	   padding-left:1px;
	   padding-bottom:1px;
	   border-collapse: collapse;
	}</style>
	<table width="100%" cellpadding="0" cellspacing="0" autosize="1" >
		<tr>
			<td colspan="2">PEMBERI INFORMASI</td>
		</tr>
		<tr>
			<td colspan="2" align="center">&nbsp;</td>
		</tr>
		<tr>
			<td width="30%">Dokter Pelaksana Tindakan</td>
			<td>:&nbsp;' . setGarisIfNull($arr_perawat[$pegawai_id]) . '</td>
		</tr>
		<tr>
			<td>Pemberi Informasi</td>
			<td>:&nbsp;' . setGarisIfNull($arr_perawat[$pemberi_informasi]) . '</td>
		</tr>
		<tr>
			<td>Penerima Informasi/Pemberi Persetujuan</td>
			<td>:&nbsp;' . setGarisIfNull($penerima_informasi) . '</td>
		</tr>	
		<tr>
			<td colspan="2" align="center">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
			
				<table border="0" width="100%" cellpadding="0" cellspacing="0" class="tbl" autosize="1" >
					<tr>
					<td align="center" bgcolor="#CCCCCC" ><strong>No</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Jenis Informasi</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Isi Informasi</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Tanda<br />(&radic;)</strong></td>
					</tr>
					<tr>
						<td align="center" valign="top">1.</td>
						<td align="left" valign="top">Diagnosis (WD/DD)</td>
						<td align="left" valign="top">' . setGarisIfNull($diag_wd_dd) . '</td>
						<td align="center" valign="middle"><input type="checkbox" value="1" ' . ((isset($persetujuan[0]) and $persetujuan[0] == '1') ? 'checked="checked"' : '') . '/></td>
					</tr>
					<tr>
						<td align="center" valign="top">2.</td>
						<td align="left" valign="top">Dasar Diagnosis</td>
						<td align="left" valign="top">' . setGarisIfNull($dasar_diag) . '</td>
						<td align="center" valign="middle"><input type="checkbox" value="1" ' . ((isset($persetujuan[1]) and $persetujuan[1] == '1') ? 'checked="checked"' : '') . '/></td>
					</tr>
					<tr>
						<td align="center" valign="top">3.</td>
						<td align="left" valign="top">Tindakan Kedokteran</td>
						<td align="left" valign="top">' . setGarisIfNull($tind_dokter) . '<br />
						' . setGarisIfNull($tind_dokter_sekunder) . '</td>
						<td align="center" valign="middle"><input type="checkbox" value="1" ' . ((isset($persetujuan[2]) and $persetujuan[2] == '1') ? 'checked="checked"' : '') . '/></td>
					</tr>
					<tr>
						<td align="center" valign="top">4.</td>
						<td align="left" valign="top">Indikasi Tindakan</td>
						<td align="left" valign="top">' . setGarisIfNull($indikasi_tindk) . '</td>
						<td align="center" valign="middle"><input type="checkbox" value="1" ' . ((isset($persetujuan[3]) and $persetujuan[3] == '1') ? 'checked="checked"' : '') . '/></td>
					</tr>
					<tr>
						<td align="center" valign="top">5.</td>
						<td align="left" valign="top">Tata Cara</td>
						<td align="left" valign="top"><input type="checkbox" value="1" ' . (($tata_cara=='1') ? 'checked="checked"' : '') . '>&nbsp;Tipe Sedasi/Anasthesia
							<input type="checkbox" value="2" ' . (($tata_cara=='2') ? 'checked="checked"' : '') . '>&nbsp;Uraian singkat prosedur dan tahapan yang penting</td>
						<td align="center" valign="middle"><input type="checkbox" value="1" ' . ((isset($persetujuan[4]) and $persetujuan[4] == '1') ? 'checked="checked"' : '') . '/></td>
					</tr>
					<tr>
						<td align="center" valign="top">6.</td>
						<td align="left" valign="top">Tujuan</td>
						<td align="left" valign="top">' . setGarisIfNull($tujuan) . '</td>
						<td align="center" valign="middle"><input type="checkbox" value="1" ' . ((isset($persetujuan[5]) and $persetujuan[5] == '1') ? 'checked="checked"' : '') . '/></td>
					</tr>
					<tr>
						<td align="center" valign="top">7.</td>
						<td align="left" valign="top">Resiko</td>
						<td align="left" valign="top">' . setGarisIfNull($resiko) . '</td>
						<td align="center" valign="middle"><input type="checkbox" value="1" ' . ((isset($persetujuan[6]) and $persetujuan[6] == '1') ? 'checked="checked"' : '') . '/></td>
					</tr>
					<tr>
						<td align="center" valign="top">8.</td>
						<td align="left" valign="top">Komplikasi</td>
						<td align="left" valign="top">' . setGarisIfNull($komplikasi) . '</td>
						<td align="center" valign="middle"><input type="checkbox" value="1" ' . ((isset($persetujuan[7]) and $persetujuan[7] == '1') ? 'checked="checked"' : '') . '/></td>
					</tr>
					<tr>
						<td align="center" valign="top">9.</td>
						<td align="left" valign="top">Pronosis : Prognosis Vital, Prognosis Fungsi dan Prognosis Kesembuhan</td>
						<td align="left" valign="top">' . setGarisIfNull($pronosis) . '</td>
						<td align="center" valign="middle"><input type="checkbox" value="1" ' . ((isset($persetujuan[8]) and $persetujuan[8] == '1') ? 'checked="checked"' : '') . '/></td>
					</tr>
					<tr>
						<td align="center" valign="top">10.</td>
						<td align="left" valign="top">Alternatif & Resiko</td>
						<td align="left" valign="top"><input type="checkbox" value="1" ' . (($alt_resiko=='1') ? 'checked="checked"' : '') . '>&nbsp;Pilihan Pengobatan/Penatalaksanaan</td>
						<td align="center" valign="middle"><input type="checkbox" value="1" ' . ((isset($persetujuan[9]) and $persetujuan[9] == '1') ? 'checked="checked"' : '') . '/></td>
					</tr>
					<tr>
						<td align="center" valign="top">11.</td>
						<td align="left" valign="top">Hal Lain yang akan dilakukan untuk menyelamatkan pasien</td>
						<td align="left" valign="top">
							<input type="checkbox" value="1" ' . (($penyelamatan_pasien=='1') ? 'checked="checked"' : '') . '>&nbsp;Perluasan Tindakan
							<input type="checkbox" value="2" ' . (($penyelamatan_pasien=='2') ? 'checked="checked"' : '') . '>&nbsp;Konsultasi Selama Tindakan							
							<input type="checkbox" value="3" ' . (($penyelamatan_pasien=='3') ? 'checked="checked"' : '') . '>&nbsp;Resusitasi</td>
						<td align="center" valign="middle"><input type="checkbox" value="1" ' . ((isset($persetujuan[10]) and $persetujuan[10] == '1') ? 'checked="checked"' : '') . '/></td>
					</tr>
					<tr>
						<td align="center" valign="top">&nbsp;</td>
						<td align="left" valign="top">Lain-lain</td>
						<td align="left" valign="top">' . setGarisIfNull($lain_lain) . '</td>
						<td align="center" valign="middle"><input type="checkbox" value="1" ' . ((isset($persetujuan[11]) and $persetujuan[11] == '1') ? 'checked="checked"' : '') . '/></td>
					</tr>
				</table>
			
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:justify;" valign="top">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dengan ini menyatakan bahwa saya telah menerangkan hal-hal di atas secara benar dan jelas dan memberikan kesempatan untuk bertanya dan/atau berdiskusi.
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:justify;" valign="top">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dengan ini menyatakan bahwa saya telah menerima informasi dari dokter sebagaimana di atas kemudian saya beri tanda/paraf di kolom kanannya, dan telah memahaminya.
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:justify;" valign="top">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Bila pasien tidak kompeten atau tidak mau menerima informasi, maka penerima informasi adalah wali atau keluarga terdekat.
			</td>			
		</tr>
		<tr>
			<td colspan="2" align="center">&nbsp;</td>
		</tr>		
		<tr>
			<td colspan="2">PERSETUJUAN TINDAKAN KEDOKTERAN</td>			
		</tr>
		<tr>
			<td colspan="2" align="center">&nbsp;</td>
		</tr>
		<tr>
			<td valign="top" style="text-align:justify;" colspan="2">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yang bertandatangan di bawah ini saya, nama&nbsp;' . setGarisIfNull($nama_penerima_informasi) . '
				&nbsp;&nbsp;umur&nbsp;' . setGarisIfNull($umur) . '&nbsp;tahun,&nbsp;&nbsp;
				<input type="checkbox" value="1" ' . (($jns_kel=='L') ? 'checked="checked"' : '') . '/>Laki-laki&nbsp;&nbsp;
				<input type="checkbox" value="2" ' . (($jns_kel=='P') ? 'checked="checked"' : '') . '/>Perempuan,&nbsp;&nbsp;
				Alamat&nbsp;' . setGarisIfNull($alamat) . '<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dengan ini menyatakan persetujuan untuk dilakukannya tindakan&nbsp;' . setGarisIfNull($tind_dokter1) . '
				terhadap saya/&nbsp;' . setGarisIfNull($nama_penerima_informasi) . '&nbsp;&nbsp;
				saya* bernama&nbsp;' . setGarisIfNull($nama_penerima_informasi) . '
				&nbsp;&nbsp;umur&nbsp;' . setGarisIfNull($umur) . '&nbsp;tahun,&nbsp;&nbsp;
				<input type="checkbox" value="1" ' . (($jns_kel=='1') ? 'checked="checked"' : '') . '>Laki-laki&nbsp;&nbsp;
				<input type="checkbox" value="2" ' . (($jns_kel=='2') ? 'checked="checked"' : '') . '>Perempuan<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Saya memahami perlunya dan manfaat tindakan sebagaimana telah dijelaskan seperti di atas kepada saya, 
				termasuk risiko dan komplikasi yang mungkin timbul. 
				Saya juga menyadari bahwa dokter melakukan suatu upaya dan oleh karena ilmu kedokteran bukanlah ilmu pasti, 
				maka keberhasilan tindakan kedokteran bukanlah keniscayaan, melainkan sangat bergantung 
				kepada izin Tuhan Yang Maha Esa.
			</td>			
		</tr>
		<tr>
			<td colspan="2" align="center">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				
				<table width="100%" cellpadding="0" cellspacing="0" autosize="1" >
					<tr>
						<td>Tangerang, ' . setGarisIfNull($tanggal_persetujuan) . '</td>
						<td>Yang Menyatakan</td>
						<td>Saksi 1</td>
						<td>Saksi 2</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>' . setGarisIfNull($saksi_1) . '</td>
						<td>' . setGarisIfNull($saksi_2) . '</td>
					</tr>
				</table>
				
			</td>
		</tr>
	</table>';
	
	ob_start();
	include('edoc_rekammedik/edoc_frame_main.php');
	$html = ob_get_contents();
	ob_end_clean();
	$mpdf->WriteHTML($html);
	$st_print = true;	
}
//End Formulir Persetujuan Tindakan Kedokteran	

//Procedure Safety (Time Out)
$edoc_nama_documen = strtoupper('Procedure Safety (Time Out)');

$qry_proc_safety = 'SELECT t_operasi_prosedure_safety.PROCEDURE_SAFETY_ID,
					t_operasi_prosedure_safety.KELENGKAPAN_TIM,t_operasi_prosedure_safety.PERAN_TIM,
					t_operasi_prosedure_safety.ANTIBIOTIK_PROPILAKSIS,
					DATE_FORMAT(t_operasi_prosedure_safety.DIBERIKAN_JAM,"%H") AS DIBERIKAN_JAM,
					DATE_FORMAT(t_operasi_prosedure_safety.DIBERIKAN_JAM,"%i") AS DIBERIKAN_MENIT,
					t_operasi_prosedure_safety.ANTISIPASI_KRITIS,
					DATE_FORMAT(t_operasi_prosedure_safety.ANTISIPASI_KRITIS_MULAI,"%H") AS ANTISIPASI_KRITIS_MULAI_JAM,
					DATE_FORMAT(t_operasi_prosedure_safety.ANTISIPASI_KRITIS_MULAI,"%i") AS ANTISIPASI_KRITIS_MULAI_MENIT,
					DATE_FORMAT(t_operasi_prosedure_safety.ANTISIPASI_KRITIS_SELESAI,"%H") AS ANTISIPASI_KRITIS_SELESAI_JAM,
					DATE_FORMAT(t_operasi_prosedure_safety.ANTISIPASI_KRITIS_SELESAI,"%i") AS ANTISIPASI_KRITIS_SELESAI_MENIT,
					t_operasi_prosedure_safety.ANTISIPASI_KRITIS2,
					t_operasi_prosedure_safety.CEK_STERILISASI,t_operasi_prosedure_safety.KESIAPAN_PERALATAN,
					t_operasi_prosedure_safety.FOTO_RADIOLOGI,t_operasi_prosedure_safety.KETERANGAN,t_operasi_prosedure_safety.PERAWAT,
					t_operasi_prosedure_safety.JNS_ANTIBIOTIK,t_operasi_prosedure_safety.KET_KESIAPAN_PERALATAN
					FROM t_operasi_prosedure_safety
				WHERE t_operasi_prosedure_safety.OPERASI_ID = "' . $idx . '"';
$get_proc_safety = mysql_query($qry_proc_safety) or die(mysql_error());
if(mysql_num_rows($get_proc_safety) > 0){
	$dat_proc_safety = mysql_fetch_assoc($get_proc_safety);

	$procedure_safety_id = $dat_proc_safety['PROCEDURE_SAFETY_ID'];
	$kelengkapan_tim = $dat_proc_safety['KELENGKAPAN_TIM'];
	$peran_tim = $dat_proc_safety['PERAN_TIM'];
	$antibiotik_propilaksis = $dat_proc_safety['ANTIBIOTIK_PROPILAKSIS'];
	$diberikan_jam = $dat_proc_safety['DIBERIKAN_JAM'];
	$diberikan_menit = $dat_proc_safety['DIBERIKAN_MENIT'];
	$antisipasi_kritis = $dat_proc_safety['ANTISIPASI_KRITIS'];
	$antisipasi_kritis_mulai_jam = $dat_proc_safety['ANTISIPASI_KRITIS_MULAI_JAM'];
	$antisipasi_kritis_mulai_menit = $dat_proc_safety['ANTISIPASI_KRITIS_MULAI_MENIT'];
	$antisipasi_kritis_selesai_jam = $dat_proc_safety['ANTISIPASI_KRITIS_SELESAI_JAM'];
	$antisipasi_kritis_selesai_menit = $dat_proc_safety['ANTISIPASI_KRITIS_SELESAI_MENIT'];
	$antisipasi_kritis2 = $dat_proc_safety['ANTISIPASI_KRITIS2'];
	$cek_sterilisasi = $dat_proc_safety['CEK_STERILISASI'];
	$kesiapan_peralatan = $dat_proc_safety['KESIAPAN_PERALATAN'];
	$foto_radiologi = $dat_proc_safety['FOTO_RADIOLOGI'];
	$keterangan = $dat_proc_safety['KETERANGAN'];
	$perawat = $dat_proc_safety['PERAWAT'];
	$jns_antibiotik = $dat_proc_safety['JNS_ANTIBIOTIK'];
	$ket_kesiapan_peralatan = $dat_proc_safety['KET_KESIAPAN_PERALATAN'];
		
	$edoc_content = '<style>.tbl tr td {
	   border: 1px solid black;
	   padding-left:1px;
	   padding-bottom:1px;
	   border-collapse: collapse;
	}</style>
	<table width="100%" cellpadding="0" cellspacing="0" autosize="1" >
		<tr>
			<td colspan="2" valign="top" nowrap>Kelengkapan Tim Tindakan</td>
			<td>&nbsp;</td>	
			<td>:&nbsp;<input type="checkbox" ' . (($kelengkapan_tim=='1') ? 'checked="checked"' : '') . ' />&nbsp;Lengkap
				<input type="checkbox" ' . (($kelengkapan_tim=='2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak Lengkap</td>
		</tr>
		<tr>
			<td width="5" colspan="2" valign="top" nowrap>Menyebutkan nama dan peran tim</td>
					<td>&nbsp;</td>
					<td>:&nbsp;<input type="checkbox" ' . (($peran_tim=='1') ? 'checked="checked"' : '') . ' />&nbsp;Menyebutkan secara verbal<br>
					<table>
						<tr>
							<td>&nbsp;</td>
							<td>&raquo;</td>
							<td>Tanggal Tindakan</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&raquo;</td>
							<td>Nama Lengkap dan Tanggal Lahir</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&raquo;</td>
							<td>Prosedur Tindakan</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&raquo;</td>
							<td>Tempat Dilakukan Tindakan</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&raquo;</td>
							<td>Inform Consen</td>
						</tr>
					</table>
				
			</td>
		</tr>
		<tr>							
			<td width="5" colspan="2" valign="top" nowrap>Antibiotik Propilaksis sudah diberikan 60 menit sebelumnya ?</td>
				<td>&nbsp;</td>
				<td>:&nbsp;
					<input type="checkbox" ' . (($antibiotik_propilaksis=='1') ? 'checked="checked"' : '') . ' />&nbsp;Tidak
					<input type="checkbox" ' . (($antibiotik_propilaksis=='2') ? 'checked="checked"' : '') . ' />&nbsp;Ya, &nbsp;Jenis&nbsp;
					' . setGarisIfNull($jns_antibiotik) . '
					<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Diberikan Jam&nbsp;&nbsp;
					' . setGarisIfNull($diberikan_jam) . ' ' . setGarisIfNull($diberikan_menit) . '</td>		
		</tr>
		<tr>							
			<td width="5" colspan="2" nowrap>Mengantisipasi Peristiwa Kritis</td>	
			<td>Dokter&nbsp;:&nbsp;&nbsp;</td>
			<td>&nbsp;</td>	
		</tr>	
		<tr>
			<td colspan="2">&nbsp;</td>
			<td>&nbsp;</td>
			<td>Apakah Tindakan yang dilakukan beresiko tinggi ?&nbsp;<input type="checkbox" ' . (($antisipasi_kritis=='1') ? 'checked="checked"' : '') . ' />&nbsp;Ya&nbsp;&nbsp;
				<input type="checkbox" ' . (($antisipasi_kritis=='2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
			<td>&nbsp;</td>
			<td>Berapa lama tindakan ini akan di lakukan ?&nbsp;Mulai&nbsp;' . setGarisIfNull($antisipasi_kritis_mulai_jam) . ' ' . setGarisIfNull($antisipasi_kritis_mulai_menit) . '
			&nbsp;&nbsp;Sd&nbsp;' . setGarisIfNull($antisipasi_kritis_selesai_jam) . ' ' . setGarisIfNull($antisipasi_kritis_selesai_menit) . '</td>
		</tr>		
		<tr>
			<td colspan="2">&nbsp;</td>
			<td>&nbsp;</td>
			<td>Apakah Sudah di Antisipasi Perdarahan ?&nbsp;<input type="checkbox"  ' . (($antisipasi_kritis2=='1') ? 'checked="checked"' : '') . ' />&nbsp;Ya&nbsp;&nbsp;
			<input type="checkbox" ' . (($antisipasi_kritis2=='2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak</td>
		</tr>			
		<tr>							
			<td width="5" colspan="2" nowrap>&nbsp;</td>	
			<td>Perawat&nbsp;:&nbsp;&nbsp;</td>
			<td>&nbsp;</td>	
		</tr>	
		<tr>
			<td colspan="2">&nbsp;</td>
			<td>&nbsp;</td>
			<td>Apakah Sudah mengecek sterilisasi alat (melalui indicator sterilisasi) ? &nbsp;<input type="checkbox" ' . (($cek_sterilisasi=='1') ? 'checked="checked"' : '') . ' />&nbsp;Ya&nbsp;&nbsp;
			<input type="checkbox" ' . (($cek_sterilisasi=='2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
			<td>&nbsp;</td>
			<td>Apakah ada kesiapan peralatan yang harus diperhatikan ?&nbsp;&nbsp;<input type="checkbox" ' . (($kesiapan_peralatan=='1') ? 'checked="checked"' : '') . ' />&nbsp;Ya&nbsp;&nbsp;
			<input type="checkbox" ' . (($kesiapan_peralatan=='2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak<br>						
			Jika Ya, sebutkan &nbsp;&nbsp; ' . setGarisIfNull($ket_kesiapan_peralatan) . '</td>
		</tr>		
		<tr>
			<td colspan="2">&nbsp;</td>
			<td>&nbsp;</td>
			<td>Foto Radiologi yang penting sudah dipasang ?&nbsp;<input type="checkbox" ' . (($foto_checkboxlogi=='1') ? 'checked="checked"' : '') . ' />&nbsp;Dipasang&nbsp;&nbsp;
			<input type="checkbox" ' . (($foto_checkboxlogi=='2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak dipasang</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
			<td>&nbsp;</td>
			<td>Hal yang harus di perhatikan :&nbsp;<br>' . setGarisIfNull($keterangan) . '</td>
		</tr>
		<tr>
			<td colspan="4" align="right" style="font-size:15px; ">
			&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">Perawat Penanggungjawab</td>
			<td>&nbsp;</td>
			<td>:&nbsp;' . $arr_perawat[$perawat] . '</td>
		</tr>
	</table>';
	
	ob_start();
	include('edoc_rekammedik/edoc_frame_main.php');
	$html = ob_get_contents();
	ob_end_clean();
	if($st_print) $mpdf->AddPage('P');
	$mpdf->WriteHTML($html);
	$st_print = true;	
}
//End Procedure Safety (Time Out)		

//Perencanaan Anestesi dan Sedasi
$edoc_nama_documen = strtoupper('Perencanaan Anestesi dan Sedasi');

$qry_anestesi_sedasi = 'SELECT t_operasi_perencanaan_sedasi.ID_PERENCANAAN_SEDASI,
					t_operasi_perencanaan_sedasi.SEDASI,t_operasi_perencanaan_sedasi.KET_SEDASI,t_operasi_perencanaan_sedasi.GA,
					t_operasi_perencanaan_sedasi.KET_GA,t_operasi_perencanaan_sedasi.REGIONAL,t_operasi_perencanaan_sedasi.LAIN_LAIN,
					t_operasi_perencanaan_sedasi.KET_LAIN_LAIN,t_operasi_perencanaan_sedasi.TEHNIK_KHUSUS,t_operasi_perencanaan_sedasi.MONITORING,
					t_operasi_perencanaan_sedasi.KET_MONITORING_EKG_LEAD,t_operasi_perencanaan_sedasi.KET_MONITORING_CVP,
					t_operasi_perencanaan_sedasi.KET_MONITORING_ARTERI_LINE,t_operasi_perencanaan_sedasi.ALAT_KHUSUS,
					t_operasi_perencanaan_sedasi.KET_ALAT_KHUSUS_LAIN_LAIN,t_operasi_perencanaan_sedasi.PASCA_ANESTESI,
					t_operasi_perencanaan_sedasi.KET_PASCA_ANESTESI_APS,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_MULAI,"%d/%m/%Y") AS PRA_ANESTESI_MULAI_TANGGAL,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_MULAI,"%H") AS PRA_ANESTESI_MULAI_JAM,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_MULAI,"%i") AS PRA_ANESTESI_MULAI_MENIT,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_MEDIKASI,"%d/%m/%Y") AS PRA_ANESTESI_MEDIKASI_TANGGAL,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_MEDIKASI,"%H") AS PRA_ANESTESI_MEDIKASI_JAM,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_MEDIKASI,"%i") AS PRA_ANESTESI_MEDIKASI_MENIT,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_KAMAR_BEDAH,"%d/%m/%Y") AS PRA_ANESTESI_KAMAR_BEDAH_TANGGAL,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_KAMAR_BEDAH,"%H") AS PRA_ANESTESI_KAMAR_BEDAH_JAM,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_KAMAR_BEDAH,"%i") AS PRA_ANESTESI_KAMAR_BEDAH_MENIT,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_REN_OPERASI,"%d/%m/%Y") AS PRA_ANESTESI_REN_OPERASI_TANGGAL,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_REN_OPERASI,"%H") AS PRA_ANESTESI_REN_OPERASI_JAM,
					DATE_FORMAT(t_operasi_perencanaan_sedasi.PRA_ANESTESI_REN_OPERASI,"%i") AS PRA_ANESTESI_REN_OPERASI_MENIT,
					t_operasi_perencanaan_sedasi.CATATAN_PRA_ANESTESI,
					t_operasi_perencanaan_sedasi.DOKTER_DPJP_ANESTESI,t_operasi_perencanaan_sedasi.KET_REGIONAL
					FROM t_operasi_perencanaan_sedasi
				WHERE t_operasi_perencanaan_sedasi.ID_OPERASI = "' . $idx . '"';
$get_anestesi_sedasi = mysql_query($qry_anestesi_sedasi) or die(mysql_error());
if(mysql_num_rows($get_anestesi_sedasi) > 0){
	$dat_anestesi_sedasi = mysql_fetch_assoc($get_anestesi_sedasi);

	$id_perencanaan_sedasi = $dat_anestesi_sedasi['ID_PERENCANAAN_SEDASI'];
	$sedasi = $dat_anestesi_sedasi['SEDASI'];
	$ket_sedasi = $dat_anestesi_sedasi['KET_SEDASI'];
	$ga = $dat_anestesi_sedasi['GA'];
	$ket_ga = $dat_anestesi_sedasi['KET_GA'];
	$regional = $dat_anestesi_sedasi['REGIONAL'];
	$ket_regional = $dat_anestesi_sedasi['KET_REGIONAL'];
	$lain_lain = $dat_anestesi_sedasi['LAIN_LAIN'];
	$ket_lain_lain = $dat_anestesi_sedasi['KET_LAIN_LAIN'];
	$tehnik_khusus = $dat_anestesi_sedasi['TEHNIK_KHUSUS'];
	$monitoring = $dat_anestesi_sedasi['MONITORING'];
	$ket_monitoring_ekg_lead = $dat_anestesi_sedasi['KET_MONITORING_EKG_LEAD'];
	$ket_monitoring_cvp = $dat_anestesi_sedasi['KET_MONITORING_CVP'];
	$ket_monitoring_arteri_line = $dat_anestesi_sedasi['KET_MONITORING_ARTERI_LINE'];
	$alat_khusus = $dat_anestesi_sedasi['ALAT_KHUSUS'];
	$ket_alat_khusus_lain_lain = $dat_anestesi_sedasi['KET_ALAT_KHUSUS_LAIN_LAIN'];
	$pasca_anestesi = $dat_anestesi_sedasi['PASCA_ANESTESI'];
	$ket_pasca_anestesi_aps = $dat_anestesi_sedasi['KET_PASCA_ANESTESI_APS'];
	$pra_anestesi_mulai_tanggal = $dat_anestesi_sedasi['PRA_ANESTESI_MULAI_TANGGAL'];
	$pra_anestesi_mulai_jam = $dat_anestesi_sedasi['PRA_ANESTESI_MULAI_JAM'];
	$pra_anestesi_mulai_menit = $dat_anestesi_sedasi['PRA_ANESTESI_MULAI_MENIT'];
	$pra_anestesi_medikasi_tanggal = $dat_anestesi_sedasi['PRA_ANESTESI_MEDIKASI_TANGGAL'];
	$pra_anestesi_medikasi_jam = $dat_anestesi_sedasi['PRA_ANESTESI_MEDIKASI_JAM'];
	$pra_anestesi_medikasi_menit = $dat_anestesi_sedasi['PRA_ANESTESI_MEDIKASI_MENIT'];
	$pra_anestesi_kamar_bedah_tanggal = $dat_anestesi_sedasi['PRA_ANESTESI_KAMAR_BEDAH_TANGGAL'];
	$pra_anestesi_kamar_bedah_jam = $dat_anestesi_sedasi['PRA_ANESTESI_KAMAR_BEDAH_JAM'];
	$pra_anestesi_kamar_bedah_menit = $dat_anestesi_sedasi['PRA_ANESTESI_KAMAR_BEDAH_MENIT'];
	$pra_anestesi_ren_operasi_tanggal = $dat_anestesi_sedasi['PRA_ANESTESI_REN_OPERASI_TANGGAL'];
	$pra_anestesi_ren_operasi_jam = $dat_anestesi_sedasi['PRA_ANESTESI_REN_OPERASI_JAM'];
	$pra_anestesi_ren_operasi_menit = $dat_anestesi_sedasi['PRA_ANESTESI_REN_OPERASI_MENIT'];
	$catatan_pra_anestesi = $dat_anestesi_sedasi['CATATAN_PRA_ANESTESI'];
	$dokter_dpjp_anestesi = $dat_anestesi_sedasi['DOKTER_DPJP_ANESTESI'];
		
	$edoc_content = '<style>.tbl tr td {
	   border: 1px solid black;
	   padding-left:1px;
	   padding-bottom:1px;
	   border-collapse: collapse;
	}</style>
	<table width="100%" cellpadding="0" cellspacing="0" autosize="1" >
			
						<tr>
							<td rowspan="4" style="padding-top:5px; " valign="top">Teknik Anestesia dan Sedasi</td>
							<td>:&nbsp;<input type="checkbox" ' . (($sedasi =='1') ? 'checked="checked"' : '') . '>&nbsp;Sedasi</td>
							<td>' . setGarisIfNull($ket_sedasi) . '</td>
						</tr>
						<tr>
							<td><input type="checkbox" ' . (($ga =='1') ? 'checked="checked"' : '') . '>&nbsp;GA</td>
							<td>' . setGarisIfNull($ket_ga) . '</td>
						</tr>
						<tr>
							<td><input type="checkbox" ' . (($regional == '1') ? 'checked="checked"' : '') . '>&nbsp;Regional </td>
							<td>
								<input type="checkbox" ' . (($ket_regional=='1') ? 'checked="checked"' : '') . '>&nbsp;Spinal&nbsp;
								<input type="checkbox" ' . (($ket_regional=='2') ? 'checked="checked"' : '') . '>&nbsp;Epidural&nbsp;	
								<input type="checkbox" ' . (($ket_regional=='3') ? 'checked="checked"' : '') . '>&nbsp;Klaudal&nbsp;
								<input type="checkbox" ' . (($ket_regional=='4') ? 'checked="checked"' : '') . '>&nbsp;Blok Perifer&nbsp;															
							</td>
						</tr>
						<tr>
							<td><input type="checkbox" ' . (($lain_lain=='1') ? 'checked="checked"' : '') . '>&nbsp;Lain-lain</td>
							<td>' . setGarisIfNull($ket_lain_lain) . '</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						<td>
						<tr>
							<td  style="padding-top:5px; " valign="top">Tehnik Khusus</td>
							<td colspan="2">:&nbsp;<input type="checkbox" ' . (($tehnik_khusus=='1') ? 'checked="checked"' : '') . '>&nbsp;Hipotensi&nbsp;&nbsp;
								<input type="checkbox" ' . (($tehnik_khusus=='2') ? 'checked="checked"' : '') . '>&nbsp;Ventilasi Satu Paru&nbsp;&nbsp;
								<input type="checkbox" ' . (($tehnik_khusus=='3') ? 'checked="checked"' : '') . '>&nbsp;TCI&nbsp;&nbsp;
								<input type="checkbox" ' . (($tehnik_khusus=='4') ? 'checked="checked"' : '') . '>&nbsp;Lain-lain&nbsp;&nbsp;
							</td>							
						</tr>
						<tr>
							<td>&nbsp;</td>
						<td>	
						<tr>
							<td  style="padding-top:5px; " valign="top">Monitoring</td>
							<td>:&nbsp;<input type="checkbox" ' . (($monitoring=='1') ? 'checked="checked"' : '') . '>&nbsp;EKG Lead</td>
							<td>' . setGarisIfNull($ket_monitoring_ekg_lead) . '</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td colspan="2">
								<input type="checkbox" ' . (($monitoring=='2') ? 'checked="checked"' : '') . '>&nbsp;SpO2&nbsp;&nbsp;
								<input type="checkbox" ' . (($monitoring=='3') ? 'checked="checked"' : '') . '>&nbsp;NIBP&nbsp;&nbsp;
								<input type="checkbox" ' . (($monitoring=='4') ? 'checked="checked"' : '') . '>&nbsp;Temp&nbsp;&nbsp;
								<input type="checkbox" ' . (($monitoring=='5') ? 'checked="checked"' : '') . '>&nbsp;Lain-lain&nbsp;&nbsp;<br>
							</td>
						</tr>
						<tr>	
							<td>&nbsp;</td>
							<td><input type="checkbox" ' . (($monitoring=='6') ? 'checked="checked"' : '') . '>&nbsp;CVP</td>
							<td>' . setGarisIfNull($ket_monitoring_cvp) . '</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><input type="checkbox" ' . (($monitoring=='7') ? 'checked="checked"' : '') . '>&nbsp;Arteri line</td>
							<td>' . setGarisIfNull($ket_monitoring_arteri_line) . '</td>
						</tr>
						<tr>
							<td>&nbsp;</td>	
							<td colspan="2"><input type="checkbox" ' . (($monitoring=='8') ? 'checked="checked"' : '') . '>&nbsp;EtCO2&nbsp;&nbsp;
								<input type="checkbox" ' . (($monitoring=='9') ? 'checked="checked"' : '') . '>&nbsp;BIS&nbsp;&nbsp;</td>							
						</tr>
						<tr>
							<td>&nbsp;</td>
						<td>	
						<tr>
							<td  style="padding-top:5px; " valign="top">Alat Khusus</td>
							<td colspan="2">:&nbsp;<input type="checkbox" ' . (($alat_khusus=='1') ? 'checked="checked"' : '') . '>&nbsp;Bronchoscopy&nbsp;&nbsp;
								<input type="checkbox" ' . (($alat_khusus=='2') ? 'checked="checked"' : '') . '>&nbsp;Glidescope&nbsp;&nbsp;
								<input type="checkbox" ' . (($alat_khusus=='3') ? 'checked="checked"' : '') . '>&nbsp;USG&nbsp;&nbsp;</td>
						</tr>
						<tr>		
							<td>&nbsp;</td>		
							<td><input type="checkbox" ' . (($alat_khusus=='4') ? 'checked="checked"' : '') . '>&nbsp;Lain-lain</td>							
							<td>' . setGarisIfNull($ket_alat_khusus_lain_lain) . '</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						<td>
						<tr>
							<td  style="padding-top:5px; " valign="top" rowspan="4">Perawatan Pasca Anestesia</td>
							<td colspan="2">:&nbsp;<input type="checkbox" ' . (($pasca_anestesi=='1') ? 'checked="checked"' : '') . '>&nbsp;Rawat Inap&nbsp;&nbsp;<br></td>							
						</tr>
						<tr>							
							<td colspan="2"><input type="checkbox" ' . (($pasca_anestesi=='2') ? 'checked="checked"' : '') . '>&nbsp;Rawat Jalan&nbsp;&nbsp;<br></td>							
						</tr>
						<tr>							
							<td colspan="2"><input type="checkbox" ' . (($pasca_anestesi=='3') ? 'checked="checked"' : '') . '>&nbsp;Rawat Khusus&nbsp;&nbsp;<br></td>							
						</tr>
						<tr>							
							<td><input type="checkbox" ' . (($pasca_anestesi=='4') ? 'checked="checked"' : '') . '>&nbsp;APS &nbsp;&nbsp;<br></td>
							<td>' . setGarisIfNull($ket_pasca_anestesi_aps) .'</td>							
						</tr>
						<tr>
							<td>&nbsp;</td>
						<td>
						<tr>
							<td  style="padding-top:5px; " valign="top" rowspan="4">Persiapan Pra Anestesia</td>
							<td>Puasa Mulai&nbsp;</td>
							<td>:&nbsp;Jam&nbsp;' . setGarisIfNull($pra_anestesi_mulai_jam) . '
							' . setGarisIfNull($pra_anestesi_mulai_menit) . '&nbsp;&nbsp;Tanggal&nbsp;&nbsp;
							' . setGarisIfNull($pra_anestesi_mulai_tanggal) . '</td>								
						</tr>
						<tr>							
							<td>Pre Medikasi&nbsp;</td>
							<td>:&nbsp;Jam&nbsp;' . setGarisIfNull($pra_anestesi_medikasi_jam) . '
							' . setGarisIfNull($pra_anestesi_medikasi_menit) . '&nbsp;&nbsp;Tanggal&nbsp;&nbsp;
							' . setGarisIfNull($pra_anestesi_medikasi_tanggal) .'</td>								
						</tr>
						<tr>							
							<td>Transportasi ke Kamar Bedah&nbsp;							
							</td>
							<td>:&nbsp;Jam&nbsp;' . setGarisIfNull($pra_anestesi_kamar_bedah_jam) . '
							' . setGarisIfNull($pra_anestesi_kamar_bedah_menit) . '&nbsp;&nbsp;Tanggal&nbsp;&nbsp;
							' . setGarisIfNull($pra_anestesi_kamar_bedah_tanggal) . '</td>								
						</tr>
						<tr>							
							<td>Rencana Operasi&nbsp;</td>
							<td>:&nbsp;Jam&nbsp;' . setGarisIfNull($pra_anestesi_ren_operasi_jam) . '
							' . setGarisIfNull($pra_anestesi_ren_operasi_menit) . '&nbsp;&nbsp;Tanggal&nbsp;&nbsp;
							' . setGarisIfNull($pra_anestesi_ren_operasi_tanggal) . '</td>								
						</tr>
						<tr>
							<td>&nbsp;</td>
						<td>
						<tr>
							<td>Catatan Persiapan Pra Anestesia&nbsp;</td>							
							<td colspan="3">:&nbsp;' . setGarisIfNull($catatan_pra_anestesi) . '</td>								
						</tr>
						<tr>
							<td>DPJP Anestesiologi</td>
							<td colspan="3">:&nbsp;' . $arr_perawat[$dokter_dpjp_anestesi] . '</td>
						</tr>
	</table>';
	
	ob_start();
	include('edoc_rekammedik/edoc_frame_main.php');
	$html = ob_get_contents();
	ob_end_clean();
	if($st_print) $mpdf->AddPage('P');
	$mpdf->WriteHTML($html);
	$st_print = true;	
}
//End Perencanaan Anestesi dan Sedasi

//Skala Risiko Jatuh (Humpty Dumpty)
$edoc_nama_documen = strtoupper('Skala Risiko Jatuh (Humpty Dumpty)<br />Pasien Pediatri');

$qry_humpty_dumpty = 'SELECT t_operasi_humpty_dumpty.HUNPTY_DUMPTY_ID,t_operasi_humpty_dumpty.USIA_MIN_3_SKOR,
				t_operasi_humpty_dumpty.USIA_3_7_SKOR,t_operasi_humpty_dumpty.USIA_7_13_SKOR,
				t_operasi_humpty_dumpty.USIA_MAX_13_SKOR,t_operasi_humpty_dumpty.JNS_KEL_L_SKOR,
				t_operasi_humpty_dumpty.JNS_KEL_P_SKOR,t_operasi_humpty_dumpty.DIAGNOSIS_NEUROLOGI_SKOR,
				t_operasi_humpty_dumpty.PERUBAHAN_OKSIGENASI_SKOR,t_operasi_humpty_dumpty.GANGGUAN_PERILAKU_SKOR,
				t_operasi_humpty_dumpty.DIAGNOSIS_LAINYA_SKOR,t_operasi_humpty_dumpty.SADAR_KETERBATASAN_DIRI_SKOR,
				t_operasi_humpty_dumpty.LUPA_KETERBATASAN_DIRI_SKOR,t_operasi_humpty_dumpty.ORIENTASI_BAIK_SKOR,
				t_operasi_humpty_dumpty.RIWAYAT_JATUH_BAYI_SKOR,t_operasi_humpty_dumpty.ALAT_BANTU_SKOR,
				t_operasi_humpty_dumpty.TMP_TIDUR_STANDAR_SKOR,t_operasi_humpty_dumpty.RAWAT_JALAN_SKOR,
				t_operasi_humpty_dumpty.RESPONSE_24_JAM_SKOR,t_operasi_humpty_dumpty.RESPONSE_48_JAM_SKOR,
				t_operasi_humpty_dumpty.RESPONSE_48_JAM_MAX_SKOR,t_operasi_humpty_dumpty.MULTIPLE_OBAT_SKOR,
				t_operasi_humpty_dumpty.SATU_OBAT_SKOR,t_operasi_humpty_dumpty.MEDIKASI_LAIN_SKOR
				FROM t_operasi_humpty_dumpty
				WHERE t_operasi_humpty_dumpty.OPERASI_ID = "' . $idx . '"';
$get_humpty_dumpty = mysql_query($qry_humpty_dumpty) or die(mysql_error());
if(mysql_num_rows($get_humpty_dumpty) > 0){
	$dat_humpty_dumpty = mysql_fetch_assoc($get_humpty_dumpty);

	$hunpty_dumpty_id = $dat_humpty_dumpty['HUNPTY_DUMPTY_ID'];
	$usia_min_3_skor = $dat_humpty_dumpty['USIA_MIN_3_SKOR'];
	$usia_3_7_skor = $dat_humpty_dumpty['USIA_3_7_SKOR'];
	$usia_7_13_skor = $dat_humpty_dumpty['USIA_7_13_SKOR'];
	$usia_max_13_skor = $dat_humpty_dumpty['USIA_MAX_13_SKOR'];
	$jns_kel_l_skor = $dat_humpty_dumpty['JNS_KEL_L_SKOR'];
	$jns_kel_p_skor = $dat_humpty_dumpty['JNS_KEL_P_SKOR'];
	$diagnosis_neurologi_skor = $dat_humpty_dumpty['DIAGNOSIS_NEUROLOGI_SKOR'];
	$perubahan_oksigenasi_skor = $dat_humpty_dumpty['PERUBAHAN_OKSIGENASI_SKOR'];
	$gangguan_perilaku_skor = $dat_humpty_dumpty['GANGGUAN_PERILAKU_SKOR'];
	$diagnosis_lainya_skor = $dat_humpty_dumpty['DIAGNOSIS_LAINYA_SKOR'];
	$sadar_keterbatasan_diri_skor = $dat_humpty_dumpty['SADAR_KETERBATASAN_DIRI_SKOR'];
	$lupa_keterbatasan_diri_skor = $dat_humpty_dumpty['LUPA_KETERBATASAN_DIRI_SKOR'];
	$orientasi_baik_skor = $dat_humpty_dumpty['ORIENTASI_BAIK_SKOR'];
	$riwayat_jatuh_bayi_skor = $dat_humpty_dumpty['RIWAYAT_JATUH_BAYI_SKOR'];
	$alat_bantu_skor = $dat_humpty_dumpty['ALAT_BANTU_SKOR'];
	$tmp_tidur_standar_skor = $dat_humpty_dumpty['TMP_TIDUR_STANDAR_SKOR'];
	$rawat_jalan_skor = $dat_humpty_dumpty['RAWAT_JALAN_SKOR'];
	$response_24_jam_skor = $dat_humpty_dumpty['RESPONSE_24_JAM_SKOR'];
	$response_48_jam_skor = $dat_humpty_dumpty['RESPONSE_48_JAM_SKOR'];
	$response_48_jam_max_skor = $dat_humpty_dumpty['RESPONSE_48_JAM_MAX_SKOR'];
	$multiple_obat_skor = $dat_humpty_dumpty['MULTIPLE_OBAT_SKOR'];
	$satu_obat_skor = $dat_humpty_dumpty['SATU_OBAT_SKOR'];
	$medikasi_lain_skor = $dat_humpty_dumpty['MEDIKASI_LAIN_SKOR'];
	
	$skor = 0;
	mysql_data_seek($get_humpty_dumpty,0);
	while($row = mysql_fetch_assoc($get_humpty_dumpty)){
		foreach($row as $key => $value) {
			if($key != 'HUNPTY_DUMPTY_ID') $skor = $skor + $value;
		}
	}
	
	$edoc_content = '<style>.tbl tr td {
	   border: 1px solid black;
	   padding-left:1px;
	   padding-bottom:1px;
	   border-collapse: collapse;
	}</style>
	<table width="100%" cellpadding="0" cellspacing="0" autosize="1" class="tbl">
	<tr>
					<td align="center" bgcolor="#CCCCCC" ><strong>Parameter</strong></td>
					<td align="center" bgcolor="#CCCCCC" colspan="2" ><strong>Kriteria</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Nilai</strong></td>
					</tr>
		<tr>
			<td rowspan="4" valign="top">USIA</td>
			<td width="5"><input type="checkbox" value="4" name="usia_min_3_skor" class="text_dt" ' . (($usia_min_3_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td>< 3 Tahun</td>
			<td width="5" align="center">4</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" value="3" name="usia_3_7_skor" class="text_dt" ' . (($usia_3_7_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td>3 - 7 Tahun</td>
			<td width="5" align="center">3</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" value="2" name="usia_7_13_skor" class="text_dt" ' . (($usia_7_13_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td>7 - 13 Tahun</td>
			<td width="5" align="center">2</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" value="1" name="usia_max_13_skor" class="text_dt" ' . (($usia_max_13_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td><u>></u> 13 Tahun</td>
			<td width="5" align="center">1</td>
		</tr>
		
		<tr>
			<td rowspan="2" valign="top">JENIS KELAMIN</td>
			<td width="5"><input type="checkbox" name="jns_kel_l_skor" value="2" class="text_dt" ' . (($jns_kel_l_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td>Laki-Laki</td>
			<td width="5" align="center">2</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="jns_kel_p_skor" value="1" class="text_dt" ' . (($jns_kel_p_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td>Perempuan</td>
			<td width="5" align="center">1</td>
		</tr>
		<tr>
			<td rowspan="4" valign="top">DIAGNOSIS</td>
			<td width="5"><input type="checkbox" name="diagnosis_neurologi_skor" value="4" class="text_dt" ' . (($diagnosis_neurologi_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td>Diagnosis Neurologi</td>
			<td width="5" align="center">4</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="perubahan_oksigenasi_skor" value="3" class="text_dt" ' . (($perubahan_oksigenasi_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td wrap style="text-align:justify; ">Perubahan Oksigenasi (diagnosis respiratorik, dehidrasi, anemia, anoreksia, sinkop, pusing, dsb)</td>
			<td width="5" align="center">3</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="gangguan_perilaku_skor" value="2" class="text_dt" ' . (($gangguan_perilaku_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td>Gangguan Perilaku/ Psikiatri</td>
			<td width="5" align="center">2</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="diagnosis_lainya_skor" value="1" class="text_dt" ' . (($diagnosis_lainya_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td>Diagnosis Lainnya</td>
			<td width="5" align="center">1</td>
		</tr>
		<tr>
			<td rowspan="3" valign="top">GANGGUAN KOGNITIF</td>
			<td width="5"><input type="checkbox" name="sadar_keterbatasan_diri_skor" value="3" class="text_dt"' . (($sadar_keterbatasan_diri_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td>Tidak Menyadari Keterbatasan Dirinya</td>
			<td width="5" align="center">3</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="lupa_keterbatasan_diri_skor" value="2" class="text_dt" ' . (($lupa_keterbatasan_diri_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td wrap style="text-align:justify; ">Lupa Akan Adanya Keterbatasan</td>
			<td width="5" align="center">2</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="orientasi_baik_skor" value="1" class="text_dt" ' . (($orientasi_baik_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td>Orientasi Baik Terhadap Diri Sendiri</td>
			<td width="5" align="center">1</td>
		</tr>	
		
		<tr>
			<td rowspan="4" valign="top">FAKTOR LINGKUNGAN</td>
			<td width="5"><input type="checkbox" name="riwayat_jatuh_bayi_skor" value="4" class="text_dt" ' . (($riwayat_jatuh_bayi_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td>Riwayat jatuh bayi/ balita yang diletakkan di tempat tidur dewasa</td>
			<td width="5" align="center">4</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="alat_bantu_skor" value="3" class="text_dt" ' . (($alat_bantu_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td wrap style="text-align:justify; ">Pasien menggunakan alat bantu/ bayi diletakkan di tempat tidur balita dalam ayunan.</td>
			<td width="5" align="center">3</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="tmp_tidur_standar_skor" value="2" class="text_dt" ' . (($tmp_tidur_standar_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td>Pasien diletakkan di tempat tidur standar</td>
			<td width="5" align="center">2</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="rawat_jalan_skor" value="1" class="text_dt" ' . (($rawat_jalan_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td>Area pasien rawat jalan</td>
			<td width="5" align="center">1</td>
		</tr>
		<tr>
			<td rowspan="3" valign="top">RESPONS TERHADAP PEMBEDAHAN/<br>SEDASI/ANESTESI</td>
			<td width="5"><input type="checkbox" name="response_24_jam_skor" value="3" class="text_dt" ' . (($response_24_jam_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td>Dalam 24 Jam</td>
			<td width="5" align="center">3</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="response_48_jam_skor" value="2" class="text_dt" ' . (($response_48_jam_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td wrap style="text-align:justify; ">Dalam 48 Jam</td>
			<td width="5" align="center">2</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="response_48_jam_max_skor" value="1" class="text_dt" ' . (($response_48_jam_max_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td>> 48 Jam atau tidak menjalani pembedahan/sedasi/anestesi</td>
			<td width="5" align="center">1</td>
		</tr>
		
		<tr>
			<td rowspan="3" valign="top">PENGGUNAAN MEDIKAMENTOSA</td>
			<td width="5"><input type="checkbox" name="multiple_obat_skor" value="3" class="text_dt" ' . (($multiple_obat_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td>Penggunaan multipel : sedatif, obat hipnosis, barbiturat, fenotizin, antidepresan, pencahar, diuretik, narkose.</td>
			<td width="5" align="center">3</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="satu_obat_skor" value="2" class="text_dt" ' . (($satu_obat_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td wrap style="text-align:justify; ">Penggunaan salah satu obat diatas.</td>
			<td width="5" align="center">2</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="medikasi_lain_skor" value="1" class="text_dt" ' . (($medikasi_lain_skor > 0) ? 'checked="checked"' : '') . '></td>
			<td>Penggunaan medikasi lainnya/tidak ada medikasi</td>
			<td width="5" align="center">1</td>
		</tr>
		<tr>
			<td colspan="3" style=" font-weight:bold;">TOTAL SKOR</td>
			<td width="5" align="center">' . $skor . '</td>			
		</tr>
	</table>';
	
	ob_start();
	include('edoc_rekammedik/edoc_frame_main.php');
	$html = ob_get_contents();
	ob_end_clean();
	if($st_print) $mpdf->AddPage('P');
	$mpdf->WriteHTML($html);
	$st_print = true;	
}
//End Skala Risiko Jatuh (Humpty Dumpty)		

//Catatan Keperawatan Pra-Operasi
$edoc_nama_documen = strtoupper('Catatan Keperawatan Pra-Operasi');

$qry_prwt_praoperasi = 'SELECT t_operasi_askep_praoperasi.ASKEP_PRAOPERASI_ID,t_operasi_askep_praoperasi.IRNA_ID,
				t_operasi_askep_praoperasi.OPERASI_ID,t_operasi_askep_praoperasi.TANDA_VITAL_SUHU,
				t_operasi_askep_praoperasi.TANDA_VITAL_NADI,t_operasi_askep_praoperasi.TANDA_VITAL_RR,
				t_operasi_askep_praoperasi.TANDA_VITAL_TD,t_operasi_askep_praoperasi.TANDA_VITAL_SKOR_NYERI,
				t_operasi_askep_praoperasi.TANDA_VITAL_TB,t_operasi_askep_praoperasi.TANDA_VITAL_BB,
				t_operasi_askep_praoperasi.KESADARAN,t_operasi_askep_praoperasi.RIWAYAT_PENYAKIT_HIPERTENSI,
				t_operasi_askep_praoperasi.RIWAYAT_PENYAKIT_DIABETES,t_operasi_askep_praoperasi.RIWAYAT_PENYAKIT_HEPATITIS,
				t_operasi_askep_praoperasi.RIWAYAT_PENYAKIT_LAIN,t_operasi_askep_praoperasi.RIWAYAT_PENYAKIT_LAIN_KET,
				t_operasi_askep_praoperasi.PENGOBATAN_SAAT_INI,t_operasi_askep_praoperasi.ALAT_BANTU,
				t_operasi_askep_praoperasi.OPERASI_SEBELUM_JENIS,t_operasi_askep_praoperasi.OPERASI_SEBELUM_KAPAN,
				t_operasi_askep_praoperasi.OPERASI_SEBELUM_DI,t_operasi_askep_praoperasi.ALERGI,
				t_operasi_askep_praoperasi.ALERGI_KET,t_operasi_askep_praoperasi.HASIL_LAB_HB,
				t_operasi_askep_praoperasi.HASIL_LAB_BT,t_operasi_askep_praoperasi.HASIL_LAB_CT_APTT,
				t_operasi_askep_praoperasi.HASIL_LAB_URINE,t_operasi_askep_praoperasi.HASIL_LAB_LAIN,
				t_operasi_askep_praoperasi.HASIL_LAB_LAIN_KET,t_operasi_askep_praoperasi.BATUK_FLU_DEMAM,
				t_operasi_askep_praoperasi.SEDANG_HAID,t_operasi_askep_praoperasi.PERIKSA_IDENTITAS,
				t_operasi_askep_praoperasi.PERIKSA_IDENTITAS_KET,t_operasi_askep_praoperasi.PERIKSA_GELANG_IDENTITAS,
				t_operasi_askep_praoperasi.PERIKSA_GELANG_IDENTITAS_KET,t_operasi_askep_praoperasi.PERIKSA_GELANG_RESIKO,
				t_operasi_askep_praoperasi.PERIKSA_GELANG_RESIKO_KET,t_operasi_askep_praoperasi.PERIKSA_SURAT_PENGANTAR_OPERASI,
				t_operasi_askep_praoperasi.PERIKSA_SURAT_PENGANTAR_OPERASI_KET,t_operasi_askep_praoperasi.PERIKSA_JENIS_LOKASI_PEMBEDAHAN,
				t_operasi_askep_praoperasi.PERIKSA_JENIS_LOKASI_PEMBEDAHAN_KET,t_operasi_askep_praoperasi.PERIKSA_MASALAH_KOMUNIKASI,
				t_operasi_askep_praoperasi.PERIKSA_MASALAH_KOMUNIKASI_KET,t_operasi_askep_praoperasi.PERIKSA_SURAT_IJIN_OPERASI,
				t_operasi_askep_praoperasi.PERIKSA_SURAT_IJIN_OPERASI_KET,t_operasi_askep_praoperasi.PERIKSA_PERSETUJUAN_ANESTESI,
				t_operasi_askep_praoperasi.PERIKSA_PERSETUJUAN_ANESTESI_KET,t_operasi_askep_praoperasi.PERIKSA_KELENGKAPAN_INTERNIST,
				t_operasi_askep_praoperasi.PERIKSA_KELENGKAPAN_INTERNIST_KET,t_operasi_askep_praoperasi.PERIKSA_KELENGKAPAN_ANESTESI,
				t_operasi_askep_praoperasi.PERIKSA_KELENGKAPAN_ANESTESI_KET,t_operasi_askep_praoperasi.PERIKSA_KELENGKAPAN_LAIN,
				t_operasi_askep_praoperasi.PERIKSA_KELENGKAPAN_LAIN_KET,t_operasi_askep_praoperasi.PERIKSA_KETERSEDIAAN_HCU,
				t_operasi_askep_praoperasi.PERIKSA_KETERSEDIAAN_HCU_KET,t_operasi_askep_praoperasi.PERIKSA_KELENGKAPAN_RM,
				t_operasi_askep_praoperasi.PERIKSA_KELENGKAPAN_RM_KET,t_operasi_askep_praoperasi.PERIKSA_KELENGKAPAN_ROTHGEN,
				t_operasi_askep_praoperasi.PERIKSA_KELENGKAPAN_ROTHGEN_KET,t_operasi_askep_praoperasi.PERSIAPAN_PUASA,
				t_operasi_askep_praoperasi.PERSIAPAN_PUASA_KET,t_operasi_askep_praoperasi.PERSIAPAN_PROTHESE_LUAR,
				t_operasi_askep_praoperasi.PERSIAPAN_PROTHESE_LUAR_KET,t_operasi_askep_praoperasi.PERSIAPAN_PROTHESE_DALAM,
				t_operasi_askep_praoperasi.PERSIAPAN_PROTHESE_DALAM_KET,t_operasi_askep_praoperasi.PERSIAPAN_PERHIASAN,
				t_operasi_askep_praoperasi.PERSIAPAN_PERHIASAN_KET,t_operasi_askep_praoperasi.PERSIAPAN_PENGOSONGAN_KANDUNG_KEMIH,
				t_operasi_askep_praoperasi.PERSIAPAN_PENGOSONGAN_KANDUNG_KEMIH_KET,t_operasi_askep_praoperasi.PERSIAPAN_KETERSEDIAAN_KANTUNG_DARAH,
				t_operasi_askep_praoperasi.PERSIAPAN_KETERSEDIAAN_KANTUNG_DARAH_KET,t_operasi_askep_praoperasi.PERSIAPAN_ALAT_BANTU,
				t_operasi_askep_praoperasi.PERSIAPAN_ALAT_BANTU_KET,t_operasi_askep_praoperasi.PERSIAPAN_OBAT_DISERTAKAN,
				t_operasi_askep_praoperasi.PERSIAPAN_OBAT_DISERTAKAN_KET,t_operasi_askep_praoperasi.PERSIAPAN_OBAT_DIBERIKAN,
				t_operasi_askep_praoperasi.PERSIAPAN_OBAT_DIBERIKAN_KET,t_operasi_askep_praoperasi.PERSIAPAN_VASKULERAKSIS,
				t_operasi_askep_praoperasi.PERSIAPAN_VASKULERAKSIS_KET,t_operasi_askep_praoperasi.PERAWAT_RUANGAN,
				t_operasi_askep_praoperasi.PERAWAT_BEDAH,
				DATE_FORMAT(t_operasi_askep_praoperasi.PERAWAT_RUANGAN_JAM,"%d/%m/%Y") AS PERAWAT_RUANGAN_TANGGAL,
				DATE_FORMAT(t_operasi_askep_praoperasi.PERAWAT_RUANGAN_JAM,"%H") AS PERAWAT_RUANGAN_JAM,
				DATE_FORMAT(t_operasi_askep_praoperasi.PERAWAT_RUANGAN_JAM,"%i") AS PERAWAT_RUANGAN_MENIT,
				DATE_FORMAT(t_operasi_askep_praoperasi.PERAWAT_BEDAH_JAM,"%d/%m/%Y") AS PERAWAT_BEDAH_TANGGAL,
				DATE_FORMAT(t_operasi_askep_praoperasi.PERAWAT_BEDAH_JAM,"%H") AS PERAWAT_BEDAH_JAM,
				DATE_FORMAT(t_operasi_askep_praoperasi.PERAWAT_BEDAH_JAM,"%i") AS PERAWAT_BEDAH_MENIT,
				t_operasi_askep_praoperasi.PERSIAPAN_SITE_MARKING,t_operasi_askep_praoperasi.PERSIAPAN_SITE_MARKING_KET,
				t_operasi_askep_praoperasi.PERSIAPAN_PENJELASAN_DOKTER,t_operasi_askep_praoperasi.PERSIAPAN_PENJELASAN_DOKTER_KET,
				t_operasi_askep_praoperasi.PERAWAT_PENERIMA,
				DATE_FORMAT(t_operasi_askep_praoperasi.PERAWAT_PENERIMA_JAM,"%d/%m/%Y") AS PERAWAT_PENERIMA_TANGGAL,
				DATE_FORMAT(t_operasi_askep_praoperasi.PERAWAT_PENERIMA_JAM,"%H") AS PERAWAT_PENERIMA_JAM,
				DATE_FORMAT(t_operasi_askep_praoperasi.PERAWAT_PENERIMA_JAM,"%i") AS PERAWAT_PENERIMA_MENIT
				FROM t_operasi_askep_praoperasi 
				WHERE OPERASI_ID = "' . $idx . '"';
$get_prwt_praoperasi = mysql_query($qry_prwt_praoperasi) or die(mysql_error());
if(mysql_num_rows($get_prwt_praoperasi) > 0){
	$dat_prwt_praoperasi = mysql_fetch_assoc($get_prwt_praoperasi);

	$askep_praoperasi_id = $dat_prwt_praoperasi['ASKEP_PRAOPERASI_ID'];
	$tanda_vital_suhu = $dat_prwt_praoperasi['TANDA_VITAL_SUHU'];
	$tanda_vital_nadi = $dat_prwt_praoperasi['TANDA_VITAL_NADI'];
	$tanda_vital_rr = $dat_prwt_praoperasi['TANDA_VITAL_RR'];
	$tanda_vital_td = $dat_prwt_praoperasi['TANDA_VITAL_TD'];
	$tanda_vital_skor_nyeri = $dat_prwt_praoperasi['TANDA_VITAL_SKOR_NYERI'];
	$tanda_vital_tb = $dat_prwt_praoperasi['TANDA_VITAL_TB'];
	$tanda_vital_bb = $dat_prwt_praoperasi['TANDA_VITAL_BB'];
	$kesadaran = $dat_prwt_praoperasi['KESADARAN'];
	$riwayat_penyakit_hipertensi = $dat_prwt_praoperasi['RIWAYAT_PENYAKIT_HIPERTENSI'];
	$riwayat_penyakit_diabetes = $dat_prwt_praoperasi['RIWAYAT_PENYAKIT_DIABETES'];
	$riwayat_penyakit_hepatitis = $dat_prwt_praoperasi['RIWAYAT_PENYAKIT_HEPATITIS'];
	$riwayat_penyakit_lain = $dat_prwt_praoperasi['RIWAYAT_PENYAKIT_LAIN'];
	$riwayat_penyakit_lain_ket = $dat_prwt_praoperasi['RIWAYAT_PENYAKIT_LAIN_KET'];
	$pengobatan_saat_ini = $dat_prwt_praoperasi['PENGOBATAN_SAAT_INI'];
	$alat_bantu = $dat_prwt_praoperasi['ALAT_BANTU'];
	$operasi_sebelum_jenis = $dat_prwt_praoperasi['OPERASI_SEBELUM_JENIS'];
	$operasi_sebelum_kapan = $dat_prwt_praoperasi['OPERASI_SEBELUM_KAPAN'];
	$operasi_sebelum_di = $dat_prwt_praoperasi['OPERASI_SEBELUM_DI'];
	$alergi = $dat_prwt_praoperasi['ALERGI'];
	$alergi_ket = $dat_prwt_praoperasi['ALERGI_KET'];
	$hasil_lab_hb = $dat_prwt_praoperasi['HASIL_LAB_HB'];
	$hasil_lab_bt = $dat_prwt_praoperasi['HASIL_LAB_BT'];
	$hasil_lab_ct_aptt = $dat_prwt_praoperasi['HASIL_LAB_CT_APTT'];
	$hasil_lab_urine = $dat_prwt_praoperasi['HASIL_LAB_URINE'];
	$hasil_lab_lain = $dat_prwt_praoperasi['HASIL_LAB_LAIN'];
	$hasil_lab_lain_ket = $dat_prwt_praoperasi['HASIL_LAB_LAIN_KET'];
	$batuk_flu_demam = $dat_prwt_praoperasi['BATUK_FLU_DEMAM'];
	$sedang_haid = $dat_prwt_praoperasi['SEDANG_HAID'];
	$periksa_identitas = $dat_prwt_praoperasi['PERIKSA_IDENTITAS'];
	$periksa_identitas_ket = $dat_prwt_praoperasi['PERIKSA_IDENTITAS_KET'];
	$periksa_gelang_identitas = $dat_prwt_praoperasi['PERIKSA_GELANG_IDENTITAS'];
	$periksa_gelang_identitas_ket = $dat_prwt_praoperasi['PERIKSA_GELANG_IDENTITAS_KET'];
	$periksa_gelang_resiko = $dat_prwt_praoperasi['PERIKSA_GELANG_RESIKO'];
	$periksa_gelang_resiko_ket = $dat_prwt_praoperasi['PERIKSA_GELANG_RESIKO_KET'];
	$periksa_surat_pengantar_operasi = $dat_prwt_praoperasi['PERIKSA_SURAT_PENGANTAR_OPERASI'];
	$periksa_surat_pengantar_operasi_ket = $dat_prwt_praoperasi['PERIKSA_SURAT_PENGANTAR_OPERASI_KET'];
	$periksa_jenis_lokasi_pembedahan = $dat_prwt_praoperasi['PERIKSA_JENIS_LOKASI_PEMBEDAHAN'];
	$periksa_jenis_lokasi_pembedahan_ket = $dat_prwt_praoperasi['PERIKSA_JENIS_LOKASI_PEMBEDAHAN_KET'];
	$periksa_masalah_komunikasi = $dat_prwt_praoperasi['PERIKSA_MASALAH_KOMUNIKASI'];
	$periksa_masalah_komunikasi_ket = $dat_prwt_praoperasi['PERIKSA_MASALAH_KOMUNIKASI_KET'];
	$periksa_surat_ijin_operasi = $dat_prwt_praoperasi['PERIKSA_SURAT_IJIN_OPERASI'];
	$periksa_surat_ijin_operasi_ket = $dat_prwt_praoperasi['PERIKSA_SURAT_IJIN_OPERASI_KET'];
	$periksa_persetujuan_anestesi = $dat_prwt_praoperasi['PERIKSA_PERSETUJUAN_ANESTESI'];
	$periksa_persetujuan_anestesi_ket = $dat_prwt_praoperasi['PERIKSA_PERSETUJUAN_ANESTESI_KET'];
	$periksa_kelengkapan_internist = $dat_prwt_praoperasi['PERIKSA_KELENGKAPAN_INTERNIST'];
	$periksa_kelengkapan_internist_ket = $dat_prwt_praoperasi['PERIKSA_KELENGKAPAN_INTERNIST_KET'];
	$periksa_kelengkapan_anestesi = $dat_prwt_praoperasi['PERIKSA_KELENGKAPAN_ANESTESI'];
	$periksa_kelengkapan_anestesi_ket = $dat_prwt_praoperasi['PERIKSA_KELENGKAPAN_ANESTESI_KET'];
	$periksa_kelengkapan_lain = $dat_prwt_praoperasi['PERIKSA_KELENGKAPAN_LAIN'];
	$periksa_kelengkapan_lain_ket = $dat_prwt_praoperasi['PERIKSA_KELENGKAPAN_LAIN_KET'];
	$periksa_ketersediaan_hcu = $dat_prwt_praoperasi['PERIKSA_KETERSEDIAAN_HCU'];
	$periksa_ketersediaan_hcu_ket = $dat_prwt_praoperasi['PERIKSA_KETERSEDIAAN_HCU_KET'];
	$periksa_kelengkapan_rm = $dat_prwt_praoperasi['PERIKSA_KELENGKAPAN_RM'];
	$periksa_kelengkapan_rm_ket = $dat_prwt_praoperasi['PERIKSA_KELENGKAPAN_RM_KET'];
	$periksa_kelengkapan_rothgen = $dat_prwt_praoperasi['PERIKSA_KELENGKAPAN_ROTHGEN'];
	$periksa_kelengkapan_rothgen_ket = $dat_prwt_praoperasi['PERIKSA_KELENGKAPAN_ROTHGEN_KET'];
	$persiapan_puasa = $dat_prwt_praoperasi['PERSIAPAN_PUASA'];
	$persiapan_puasa_ket = $dat_prwt_praoperasi['PERSIAPAN_PUASA_KET'];
	$persiapan_prothese_luar = $dat_prwt_praoperasi['PERSIAPAN_PROTHESE_LUAR'];
	$persiapan_prothese_luar_ket = $dat_prwt_praoperasi['PERSIAPAN_PROTHESE_LUAR_KET'];
	$persiapan_prothese_dalam = $dat_prwt_praoperasi['PERSIAPAN_PROTHESE_DALAM'];
	$persiapan_prothese_dalam_ket = $dat_prwt_praoperasi['PERSIAPAN_PROTHESE_DALAM_KET'];
	$persiapan_perhiasan = $dat_prwt_praoperasi['PERSIAPAN_PERHIASAN'];
	$persiapan_perhiasan_ket = $dat_prwt_praoperasi['PERSIAPAN_PERHIASAN_KET'];
	$persiapan_pengosongan_kandung_kemih = $dat_prwt_praoperasi['PERSIAPAN_PENGOSONGAN_KANDUNG_KEMIH'];
	$persiapan_pengosongan_kandung_kemih_ket = $dat_prwt_praoperasi['PERSIAPAN_PENGOSONGAN_KANDUNG_KEMIH_KET'];
	$persiapan_ketersediaan_kantung_darah = $dat_prwt_praoperasi['PERSIAPAN_KETERSEDIAAN_KANTUNG_DARAH'];
	$persiapan_ketersediaan_kantung_darah_ket = $dat_prwt_praoperasi['PERSIAPAN_KETERSEDIAAN_KANTUNG_DARAH_KET'];
	$persiapan_alat_bantu = $dat_prwt_praoperasi['PERSIAPAN_ALAT_BANTU'];
	$persiapan_alat_bantu_ket = $dat_prwt_praoperasi['PERSIAPAN_ALAT_BANTU_KET'];
	$persiapan_obat_disertakan = $dat_prwt_praoperasi['PERSIAPAN_OBAT_DISERTAKAN'];
	$persiapan_obat_disertakan_ket = $dat_prwt_praoperasi['PERSIAPAN_OBAT_DISERTAKAN_KET'];
	$persiapan_obat_diberikan = $dat_prwt_praoperasi['PERSIAPAN_OBAT_DIBERIKAN'];
	$persiapan_obat_diberikan_ket = $dat_prwt_praoperasi['PERSIAPAN_OBAT_DIBERIKAN_KET'];
	$persiapan_vaskuleraksis = $dat_prwt_praoperasi['PERSIAPAN_VASKULERAKSIS'];
	$persiapan_vaskuleraksis_ket = $dat_prwt_praoperasi['PERSIAPAN_VASKULERAKSIS_KET'];
	$perawat_ruangan = $dat_prwt_praoperasi['PERAWAT_RUANGAN'];
	$perawat_bedah = $dat_prwt_praoperasi['PERAWAT_BEDAH'];
	$perawat_ruangan_tanggal = $dat_prwt_praoperasi['PERAWAT_RUANGAN_TANGGAL'];
	$perawat_ruangan_jam = $dat_prwt_praoperasi['PERAWAT_RUANGAN_JAM'];
	$perawat_ruangan_menit = $dat_prwt_praoperasi['PERAWAT_RUANGAN_MENIT'];
	$perawat_bedah_tanggal = $dat_prwt_praoperasi['PERAWAT_BEDAH_TANGGAL'];
	$perawat_bedah_jam = $dat_prwt_praoperasi['PERAWAT_BEDAH_JAM'];
	$perawat_bedah_menit = $dat_prwt_praoperasi['PERAWAT_BEDAH_MENIT'];
	$persiapan_site_marking = $dat_prwt_praoperasi['PERSIAPAN_SITE_MARKING'];
	$persiapan_site_marking_ket = $dat_prwt_praoperasi['PERSIAPAN_SITE_MARKING_KET'];
	$persiapan_penjelasan_dokter = $dat_prwt_praoperasi['PERSIAPAN_PENJELASAN_DOKTER'];
	$persiapan_penjelasan_dokter_ket = $dat_prwt_praoperasi['PERSIAPAN_PENJELASAN_DOKTER_KET'];
	$perawat_penerima = $dat_prwt_praoperasi['PERAWAT_PENERIMA'];
	$perawat_penerima_tanggal = $dat_prwt_praoperasi['PERAWAT_PENERIMA_TANGGAL'];
	$perawat_penerima_jam = $dat_prwt_praoperasi['PERAWAT_PENERIMA_JAM'];
	$perawat_penerima_menit = $dat_prwt_praoperasi['PERAWAT_PENERIMA_MENIT'];
	
	$edoc_content = '<style>.tbl tr td {
	   border: 1px solid black;
	   padding-left:1px;
	   padding-bottom:1px;
	   border-collapse: collapse;
	}</style>
	<table width="100%" cellpadding="0" cellspacing="0" autosize="1" >
	<tr>
			<td valign="top"  colspan="7"><strong>Catatan Keperawatan Pra Operasi</strong><br />
			<i>* Diisi oleh perawat ruangan maksimal 1 jam sebelum diantar ke kamar operasi : </i></td>			
		</tr>		
		<tr>
			<td valign="top"  width="25" align="center">1</td>
			<td valign="top"  colspan="2">Tanda-tanda Vital</td>
			<td valign="top"  colspan="4">Suhu:&nbsp;' . setGarisIfNull($tanda_vital_suhu) . '&nbsp;&nbsp;
			Nadi:&nbsp;' . setGarisIfNull($tanda_vital_nadi) . '&nbsp;&nbsp;
			RR:&nbsp;' . setGarisIfNull($tanda_vital_rr) . '&nbsp;&nbsp;
			TD:&nbsp;' . setGarisIfNull($tanda_vital_td) . '&nbsp;&nbsp;
			Skor Nyeri:&nbsp;' . setGarisIfNull($tanda_vital_skor_nyeri) . '&nbsp;&nbsp;
			TB:&nbsp;' . setGarisIfNull($tanda_vital_tb) . '&nbsp;&nbsp;
			BB:&nbsp;' . setGarisIfNull($tanda_vital_bb) . '&nbsp;kg</td>
		</tr>
		<tr>
			<td valign="top"  align="center" >2</td>
			<td valign="top"  colspan="2">Kesadaran</td>
			<td valign="top"  colspan="4">:&nbsp;<input type="checkbox" ' . (($kesadaran == '1') ? 'checked="checked"' : '') . ' >
				Sadar Penuh&nbsp;&nbsp;			
				<input type="checkbox" ' . (($kesadaran == '2') ? 'checked="checked"' : '') . ' >
				Bingung&nbsp;&nbsp;
				<input type="checkbox" ' . (($kesadaran == '3') ? 'checked="checked"' : '') . ' >
				Agitasi&nbsp;&nbsp;
				<input type="checkbox" ' . (($kesadaran == '4') ? 'checked="checked"' : '') . ' >
				Mengantuk&nbsp;&nbsp;			
				<input type="checkbox" ' . (($kesadaran == '5') ? 'checked="checked"' : '') . ' >
			Koma&nbsp;&nbsp;</td>
	    </tr>
		<tr>
			<td valign="top"  align="center" >3</td>
			<td valign="top"  colspan="2">Riwayat Penyakit</td>
			<td valign="top"  colspan="4">:&nbsp;<input type="checkbox" ' . (($riwayat_penyakit_hipertensi == '1') ? 'checked="checked"' : '') . ' >
				Hipertensi&nbsp;&nbsp;			
				<input type="checkbox" ' . (($riwayat_penyakit_diabetes == '1') ? 'checked="checked"' : '') . ' >
				Diabetes&nbsp;&nbsp;
				<input type="checkbox" ' . (($riwayat_penyakit_hepatitis == '1') ? 'checked="checked"' : '') . ' >
			Hepatitis&nbsp;&nbsp;
			<input type="checkbox" ' . (($riwayat_penyakit_lain == '1') ? 'checked="checked"' : '') . ' >
Lain-lain&nbsp;' . setGarisIfNull($riwayat_penyakit_lain_ket) . '</td>
	    </tr>
		<tr>
			<td valign="top"  align="center" >4</td>
			<td valign="top"  colspan="2">Pengobatan Saat ini</td>
			<td valign="top"  colspan="4">:&nbsp;' . setGarisIfNull($pengobatan_saat_ini) . '</td>
		</tr>
		<tr>
			<td valign="top"  align="center" >5</td>
			<td valign="top"  colspan="2" >Alat bantu yang digunakan</td>
			<td valign="top"  colspan="4" >:&nbsp;' . setGarisIfNull($alat_bantu) . '</td>
		</tr>
		<tr>
			<td valign="top"  align="center" >6</td>
			<td valign="top"  colspan="2">Operasi sebelumnya</td>
			<td valign="top"  colspan="4">:&nbsp;Jenis Operasi&nbsp;' . setGarisIfNull($operasi_sebelum_jenis) . '&nbsp;&nbsp;
			Kapan&nbsp;' . setGarisIfNull($operasi_sebelum_kapan) . '&nbsp;&nbsp;
			Di&nbsp;' . setGarisIfNull($operasi_sebelum_di) . '</td>
		</tr>
		<tr>
			<td valign="top"  align="center" >7</td>
			<td valign="top"  colspan="2">Alergi</td>
			<td valign="top"  colspan="4">:&nbsp;<input type="checkbox" ' . (($alergi == '1') ? 'checked="checked"' : '') . '>
				Tidak ada&nbsp;&nbsp;			
				<input type="checkbox" ' . (($alergi == '2') ? 'checked="checked"' : '') . '>
			Tidak diketahui&nbsp;&nbsp;
			<input type="checkbox" ' . (($alergi == '3') ? 'checked="checked"' : '') . ' >
			Ada, Jelaskan ' . setGarisIfNull($alergi_ket) . '</td>
		</tr>
		<tr>
			<td valign="top"  align="center" >8</td>
			<td valign="top"  colspan="2">Hasil Laboratorium</td>
			<td valign="top"  colspan="4">:&nbsp;<input type="checkbox" ' . (($hasil_lab_hb == '1') ? 'checked="checked"' : '') . ' />
			  HB&nbsp;&nbsp;
              <input type="checkbox" ' . (($hasil_lab_bt == '1') ? 'checked="checked"' : '') . ' />
              BT&nbsp;&nbsp;
              <input type="checkbox" ' . (($hasil_lab_ct_aptt == '1') ? 'checked="checked"' : '') . ' />
              CT/APTT&nbsp;&nbsp;
              <input type="checkbox" ' . (($hasil_lab_urine == '1') ? 'checked="checked"' : '') . ' />
            Urine&nbsp;&nbsp;
			<input name="hasil_lab_lain" id="hasil_lab_lain"  value="1" type="checkbox" ' . (($hasil_lab_lain == '1') ? 'checked="checked"' : '') . ' />
Lain-lain, Jelaskan&nbsp;' . setGarisIfNull($hasil_lab_lain_ket) . '</td>
		</tr>
		<tr>
			<td valign="top"  align="center" >9</td>
			<td valign="top"  colspan="2">Batuk/ Flu/ Demam</td>
			<td valign="top"  colspan="4">:&nbsp;<input type="checkbox" ' . (($batuk_flu_demam == '1') ? 'checked="checked"' : '') . ' />
			  Ya&nbsp;&nbsp;
              <input type="checkbox" ' . (($batuk_flu_demam == '2') ? 'checked="checked"' : '') . ' />
            Tidak </td>
		</tr>
		<tr>
			<td valign="top"  align="center" >10</td>
			<td valign="top"  colspan="2">Bila Pasien perempuan, apakah sedang haid/menstruasi&nbsp;&nbsp;&nbsp;</td>
		    <td valign="top"  colspan="4">:&nbsp;<input type="checkbox" ' . (($sedang_haid == '1') ? 'checked="checked"' : '') . ' />
Ya&nbsp;&nbsp;
<input type="checkbox" ' . (($sedang_haid == '2') ? 'checked="checked"' : '') . ' />
Tidak </td>
	    </tr>
		<tr>
		  <td valign="top"  colspan="7">&nbsp;</td>
  </tr>
		<tr>
			<td valign="top"  colspan="7">Persiapan Operasi<br />
			<i>* Diisi oleh perawat ruangan dan perawat kamar bedah : </i></td>			
		</tr>
		<tr >
			<td valign="top"  colspan="5">Verifikasi Pasien</td>
			<td valign="top"  width="40" align="center">Ya</td>
			<td valign="top"  width="40" align="center">Tidak</td>
		</tr>
			
				<tr>
					<td valign="top"  align="center" >1</td>
					<td valign="top"  colspan="2" >Periksa Identitas Pasien&nbsp;</td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($periksa_identitas_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_identitas == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_identitas == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" >2</td>
					<td valign="top"  colspan="2" >Periksa Gelang Identitas&nbsp;</td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($periksa_gelang_identitas_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_gelang_identitas == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_gelang_identitas == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" >3</td>
					<td valign="top"  colspan="2" >Periksa Gelang Resiko&nbsp;</td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($periksa_gelang_resiko_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_gelang_resiko == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_gelang_resiko == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" >4</td>
					<td valign="top"  colspan="2" >Surat pengantar rawat inap/ surat pengantar operasi&nbsp;</td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($periksa_surat_pengantar_operasi_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_surat_pengantar_operasi == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_surat_pengantar_operasi == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" >5</td>
					<td valign="top"  colspan="2" >Jenis dan Lokasi pembedahan dipastikan bersama pasien&nbsp;</td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($periksa_jenis_lokasi_pembedahan_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_jenis_lokasi_pembedahan == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_jenis_lokasi_pembedahan == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" >6</td>

					<td valign="top"  colspan="2" >Masalah bahasa/ komunikasi&nbsp;</td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($periksa_masalah_komunikasi_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_masalah_komunikasi == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_masalah_komunikasi == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" >7</td>
					<td valign="top"  colspan="2" >Periksa kelengkapan persetujuan pembedahan (surat ijin operasi)&nbsp;</td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($periksa_surat_ijin_operasi_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_surat_ijin_operasi == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_surat_ijin_operasi == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" >8</td>
					<td valign="top"  colspan="2" >Periksa kelengkapan persetujuan anestesi&nbsp;</td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($periksa_persetujuan_anestesi_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_persetujuan_anestesi == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_persetujuan_anestesi == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" >9</td>
					<td valign="top"   colspan="6">Periksa kelengkapan hasil konsultasi</td>									
				<tr>
					<td valign="top"  align="center" ></td>					
					<td valign="top"  >&nbsp;</td>
					<td valign="top"  >Internist<br></td>
					<td valign="top"  colspan="2">:&nbsp;' . setGarisIfNull($periksa_kelengkapan_internist_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_kelengkapan_internist == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_kelengkapan_internist == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" ></td>					
					<td valign="top"  align="center" >&nbsp;<br></td>
					<td valign="top"  >Anestesi</td>
					<td valign="top"  colspan="2">:&nbsp;' . setGarisIfNull($periksa_kelengkapan_anestesi_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_kelengkapan_anestesi == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_kelengkapan_anestesi == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" ></td>					
					<td valign="top"  align="center" >&nbsp;<br></td>
					<td valign="top"  >Lain-lain</td>
					<td valign="top"  colspan="2">:&nbsp;' . setGarisIfNull($periksa_kelengkapan_lain_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_kelengkapan_lain == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_kelengkapan_lain == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" >10</td>
					<td valign="top"  colspan="2" >Surat ketersediaan HCU/ ICU bila dibutuhkan</td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($periksa_ketersediaan_hcu_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_ketersediaan_hcu == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_ketersediaan_hcu == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" >11</td>
					<td valign="top"  colspan="2" >Periksa kelengkapan rekam medik rawat inap/ rawat jalan</td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($periksa_kelengkapan_rm_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_kelengkapan_rm == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_kelengkapan_rm == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" >12</td>
					<td valign="top"  colspan="2" >Periksa Kelengkapan X-ray/ CT-Scan/ MRI/ EKG/ Angiografi/ Echo&nbsp;</td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($periksa_kelengkapan_rothgen_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_kelengkapan_rothgen == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($periksa_kelengkapan_rothgen == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>		
		        <tr >
		          <td valign="top"  colspan="8" valign="top" style="font-weight:bold; ">&nbsp;</td>
  </tr>
        <tr >
			<td valign="top"  colspan="8">Persiapan Fisik Pasien</td>
		</tr>	
				<tr>
					<td valign="top"  align="center" >1</td>
					<td valign="top"  colspan="2" >Puasa/ makan dan minum terakhir, Jam </td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($persiapan_puasa_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_puasa == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_puasa == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" >2</td>
					<td valign="top"  colspan="2" >Prothese luar dilepaskan (gigi,palsu,lensa kontak)</td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($persiapan_prothese_luar_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_prothese_luar == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_prothese_luar == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" >3</td>
					<td valign="top"  colspan="2" >Menggunakan prothese dalam <br />(pacemaker, implant, prothese, panggul/ bahu, VP Shunt)</td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($persiapan_prothese_dalam_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_prothese_dalam == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_prothese_dalam == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" >4</td>
					<td valign="top"  colspan="2" >Penjepit rambut/ cat kuku/ perhiasan dilepaskan</td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($persiapan_perhiasan_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_perhiasan == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_perhiasan == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" >5</td>
					<td valign="top"  colspan="2" >Pengosongan kandung kemih/ clysma</td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($persiapan_pengosongan_kandung_kemih_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_pengosongan_kandung_kemih == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_pengosongan_kandung_kemih == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" >6</td>
					<td valign="top"  colspan="2" >Memastikan persediaan darah</td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($persiapan_ketersediaan_kantung_darah_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_ketersediaan_kantung_darah == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_ketersediaan_kantung_darah == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" >7</td>
					<td valign="top"  colspan="2" >Alat bantu (kacamata, alat bantu dengar) disimpan</td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($persiapan_alat_bantu_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_alat_bantu == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_alat_bantu == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" >8</td>
					<td valign="top"  colspan="2" >Obat yang disertakan</td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($persiapan_obat_disertakan_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_obat_disertakan == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_obat_disertakan == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" >9</td>
					<td valign="top"  colspan="2" >Obat terakhir yang diberikan</td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($persiapan_obat_diberikan_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_obat_diberikan == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_obat_diberikan == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" >10</td>
					<td valign="top"  colspan="2" >Vaskuleraksis</td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($persiapan_vaskuleraksis_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_vaskuleraksis == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_vaskuleraksis == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
	</table>';
	
	$edoc_content_2 = '<style>.tbl tr td {
	   border: 1px solid black;
	   padding-left:1px;
	   padding-bottom:1px;
	   border-collapse: collapse;
	}</style>
	<table width="100%" cellpadding="0" cellspacing="0" autosize="1" >
	<tr >
			<td valign="top"  colspan="8">Persiapan Lain-lain</td>
			</tr>
				<tr>
					<td valign="top"  align="center" >1</td>
					<td valign="top"  colspan="2" >Site Marking (terlampir)</td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($persiapan_site_marking_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_site_marking == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_site_marking == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
				<tr>
					<td valign="top"  align="center" >2</td>
					<td valign="top"  colspan="2" >Penjelasan singkat oleh dokter bedah <br />tentang prosedur yang akan dilakukan kepada pasien&nbsp;</td>
					<td valign="top"  colspan="2" >:&nbsp;' . setGarisIfNull($persiapan_penjelasan_dokter_ket) . '</td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_penjelasan_dokter == '1') ? 'checked="checked"' : '') . ' >
				    </td>
					<td valign="top"  align="center" >
					  <input type="checkbox" ' . (($persiapan_penjelasan_dokter == '2') ? 'checked="checked"' : '') . ' >
				    </td>
				</tr>
		<tr>
			<td valign="top"  colspan="9" align="right" style="font-size:15px; ">&nbsp;</td>
		</tr>
		<tr>
					<td valign="top"  align="center" >&nbsp;</td>
					<td valign="top" >Perawat Ruangan</td>
					<td valign="top"  colspan="2" >:&nbsp;' . $arr_perawat[$perawat_ruangan] . '</td>
					<td valign="top"  colspan="3" >Tanggal Jam
					&nbsp;' . setGarisIfNull($perawat_ruangan_tanggal) . ' ' . setGarisIfNull($perawat_ruangan_jam) . ':' . setGarisIfNull($perawat_ruangan_menit) . '</td>
		</tr>
		<tr>
					<td valign="top"  align="center" >&nbsp;</td>
					<td valign="top"  >Perawat Kamar Bedah</td>
					<td valign="top"  colspan="2" >:&nbsp;' . $arr_perawat[$perawat_bedah] . '</td>
					<td valign="top"  colspan="3" >Tanggal Jam
					&nbsp;' . setGarisIfNull($perawat_bedah_tanggal) . ' ' . setGarisIfNull($perawat_bedah_jam) . ':' . setGarisIfNull($perawat_bedah_menit) . '</td>
		</tr>
		<tr>
					<td valign="top"  align="center" >&nbsp;</td>
					<td valign="top"  >Perawat Penerima</td>
					<td valign="top"  colspan="2" >:&nbsp;' . $arr_perawat[$perawat_penerima] . '</td>
					<td valign="top"  colspan="3" >Tanggal Jam
					&nbsp;' . setGarisIfNull($perawat_penerima_tanggal) . ' ' . setGarisIfNull($perawat_penerima_jam) . ':' . setGarisIfNull($perawat_penerima_menit) . '</td>
		</tr>
	</table>';
	
	ob_start();
	include('edoc_rekammedik/edoc_frame_main.php');
	$html = ob_get_contents();
	ob_end_clean();
	if($st_print) $mpdf->AddPage('P');
	$mpdf->WriteHTML($html);

	ob_start();
	include('edoc_rekammedik/edoc_frame_add.php');
	$html = ob_get_contents();
	ob_end_clean();
	$mpdf->AddPage('P');
	$mpdf->WriteHTML($html);
	$st_print = true;	
}
//End Catatan Keperawatan Pra-Operasi

//Skala Jatuh Ontario Modified Stratify Sydney Scoring (Untuk Pasien Geriatri)		
$edoc_nama_documen = strtoupper('Skala Jatuh Ontario Modified Stratify Sydney Scoring (Untuk Pasien Geriatri)');

$qry_ontario = 'SELECT t_operasi_skala_jatuh_ontario.SKALA_JATUH_ID,
			  t_operasi_skala_jatuh_ontario.RIWAYAT_JATUH_DATANG,
			  t_operasi_skala_jatuh_ontario.RIWAYAT_JATUH_2_BULAN,
			  t_operasi_skala_jatuh_ontario.STATUS_MENTAL_DELIRIUM,
			  t_operasi_skala_jatuh_ontario.STATUS_MENTAL_DISORIENTASI,
			  t_operasi_skala_jatuh_ontario.STATUS_MENTAL_AGITASI,
			  t_operasi_skala_jatuh_ontario.PENGLIHATAN_KACAMATA,
			  t_operasi_skala_jatuh_ontario.PENGLIHATAN_BURAM,
			  t_operasi_skala_jatuh_ontario.PENGLIHATAN_GLUKOMA,
			  t_operasi_skala_jatuh_ontario.KEBIASAAN_BERKEMIH,
			  t_operasi_skala_jatuh_ontario.TRANSFER_MANDIRI,
			  t_operasi_skala_jatuh_ontario.TRANSFER_BANTUAN_1_ORANG,
			  t_operasi_skala_jatuh_ontario.TRANSFER_BANTUAN_2_ORANG,
			  t_operasi_skala_jatuh_ontario.TRANSFER_BANTUAN_TOTAL,
			  t_operasi_skala_jatuh_ontario.MOBILITAS_MANDIRI,
			  t_operasi_skala_jatuh_ontario.MOBILITAS_BANTUAN_1_ORANG,
			  t_operasi_skala_jatuh_ontario.MOBILITAS_KURSI_RODA,
			  t_operasi_skala_jatuh_ontario.IMMOBILISASI
			FROM t_operasi_skala_jatuh_ontario
			WHERE t_operasi_skala_jatuh_ontario.OPERASI_ID = "' . $idx . '"';
$get_ontario = mysql_query($qry_ontario) or die(mysql_error());
if(mysql_num_rows($get_ontario) > 0){
	$dat_ontario = mysql_fetch_assoc($get_ontario);

	$skala_jatuh_id = $dat_ontario['SKALA_JATUH_ID'];
	$riwayat_jatuh_datang = $dat_ontario['RIWAYAT_JATUH_DATANG'];
	$riwayat_jatuh_2_bulan = $dat_ontario['RIWAYAT_JATUH_2_BULAN'];
	$status_mental_delirium = $dat_ontario['STATUS_MENTAL_DELIRIUM'];
	$status_mental_disorientasi = $dat_ontario['STATUS_MENTAL_DISORIENTASI'];
	$status_mental_agitasi = $dat_ontario['STATUS_MENTAL_AGITASI'];
	$penglihatan_kacamata = $dat_ontario['PENGLIHATAN_KACAMATA'];
	$penglihatan_buram = $dat_ontario['PENGLIHATAN_BURAM'];
	$penglihatan_glukoma = $dat_ontario['PENGLIHATAN_GLUKOMA'];
	$kebiasaan_berkemih = $dat_ontario['KEBIASAAN_BERKEMIH'];
	$transfer_mandiri = $dat_ontario['TRANSFER_MANDIRI'];
	$transfer_bantuan_1_orang = $dat_ontario['TRANSFER_BANTUAN_1_ORANG'];
	$transfer_bantuan_2_orang = $dat_ontario['TRANSFER_BANTUAN_2_ORANG'];
	$transfer_bantuan_total = $dat_ontario['TRANSFER_BANTUAN_TOTAL'];
	$mobilitas_mandiri = $dat_ontario['MOBILITAS_MANDIRI'];
	$mobilitas_bantuan_1_orang = $dat_ontario['MOBILITAS_BANTUAN_1_ORANG'];
	$mobilitas_kursi_roda = $dat_ontario['MOBILITAS_KURSI_RODA'];
	$immobilisasi = $dat_ontario['IMMOBILISASI'];
	
	$skor = 0;
	if(($riwayat_jatuh_datang == '1') or ($riwayat_jatuh_2_bulan == '1')) $skor = $skor + 6;
	if(($status_mental_delirium == '1') or ($status_mental_disorientasi == '1') or ($status_mental_agitasi == '1')) $skor = $skor + 14;
	if(($penglihatan_kacamata == '1') or ($penglihatan_buram == '1') or ($penglihatan_glukoma == '1')) $skor = $skor + 1;
	if($kebiasaan_berkemih == '1') $skor = $skor + 2;

	$transfer = 0;
	if($transfer_mandiri == '1') $transfer = $transfer + 0;
	if($transfer_bantuan_1_orang == '1') $transfer = $transfer + 1;
	if($transfer_bantuan_2_orang == '1') $transfer = $transfer + 2;
	if($transfer_bantuan_total == '1') $transfer = $transfer + 3;
	if($transfer < 4) $skor = $skor;

	$mobilitas = 0;
	if($mobilitas_mandiri == '1') $mobilitas = $mobilitas + 0;
	if($mobilitas_bantuan_1_orang == '1') $mobilitas = $mobilitas + 1;
	if($mobilitas_kursi_roda == '1') $mobilitas = $mobilitas + 2;
	if($immobilisasi == '1') $mobilitas = $mobilitas + 3;
	if(($mobilitas >= 4) and ($mobilitas <= 6)) $skor = $skor + 7;
		
	$edoc_content = '<style>.tbl tr td {
	   border: 1px solid black;
	   padding-left:1px;
	   padding-bottom:1px;
	   border-collapse: collapse;
	}</style>
	<table width="100%" cellpadding="0" cellspacing="0" autosize="1" class="tbl" >
		<tr>
			<td align="center" bgcolor="#CCCCCC" ><strong>Parameter</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Skrining</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Jawaban</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Keterangan Nilai</strong></td>
		</tr>		
		<tr>
			<td rowspan="2" valign="top" style="padding-top:15px; ">RIWAYAT JATUH</td>
			<td>Apakah pasien datang ke rumah sakit karena jatuh ?</td>
			<td align="center">
				<input name="riwayat_jatuh_datang" id="riwayat_jatuh_datang" value="1" type="checkbox" ' . (($riwayat_jatuh_datang == '1') ? 'checked="checked"' : '') . ' >Ya&nbsp;&nbsp;			
				<input name="riwayat_jatuh_datang" id="riwayat_jatuh_datang" value="2" type="checkbox" ' . (($riwayat_jatuh_datang == '2') ? 'checked="checked"' : '') . ' >Tidak
			</td>
			<td rowspan="2">Salah satu jawaban Ya = 6</td>
		</tr>
		<tr>
			<td>Jika tidak, apakah pasien mengalami jatuh dalam 2 bulan terakhir ?</td>
			<td align="center">
				<input name="riwayat_jatuh_2_bulan" id="riwayat_jatuh_2_bulan" value="1" type="checkbox" ' . (($riwayat_jatuh_2_bulan == '1') ? 'checked="checked"' : '') . ' >Ya&nbsp;&nbsp;			
				<input name="riwayat_jatuh_2_bulan" id="riwayat_jatuh_2_bulan" value="2" type="checkbox" ' . (($riwayat_jatuh_2_bulan == '2') ? 'checked="checked"' : '') . '>Tidak
			</td>			
		</tr>
		<tr>
			<td rowspan="3" valign="top" style="padding-top:15px; ">STATUS MENTAL</td>
			<td>Apakah pasien delirium ? (tidak dapat membuat keputusan, pola pikir tidak terorganisir, gangguan daya ingat)</td>
			<td align="center">
				<input name="status_mental_delirium" id="status_mental_delirium" value="1" type="checkbox" ' . (($status_mental_delirium == '1') ? 'checked="checked"' : '') . ' >Ya&nbsp;&nbsp;			
				<input name="status_mental_delirium" id="status_mental_delirium" value="2" type="checkbox" ' . (($status_mental_delirium == '2') ? 'checked="checked"' : '') . '>Tidak
			</td>
			<td rowspan="3" nowrap>Salah satu jawaban Ya = 14</td>
		</tr>
		<tr>
			<td>Apakah pasien disorientasi ? (salah menyebutkan waktu, tempat atau orang)</td>
			<td align="center">
				<input name="status_mental_disorientasi" id="status_mental_disorientasi" value="1" type="checkbox" ' . (($status_mental_disorientasi == '1') ? 'checked="checked"' : '') . ' >Ya&nbsp;&nbsp;			
				<input name="status_mental_disorientasi" id="status_mental_disorientasi" value="2" type="checkbox" ' . (($status_mental_disorientasi == '2') ? 'checked="checked"' : '') . ' >Tidak
			</td>			
		</tr>
		<tr>
			<td>Apakah pasien mengalami agitasi ? (ketakutan, gelisah dan cemas)</td>
			<td align="center">
				<input name="status_mental_agitasi" id="status_mental_agitasi" value="1" type="checkbox" ' . (($status_mental_agitasi == '1') ? 'checked="checked"' : '') . ' >Ya&nbsp;&nbsp;			
				<input name="status_mental_agitasi" id="status_mental_agitasi" value="2" type="checkbox" ' . (($status_mental_agitasi == '2') ? 'checked="checked"' : '') . '>Tidak
			</td>			
		</tr>
		<tr>
			<td rowspan="3" valign="top" style="padding-top:15px; ">PENGLIHATAN</td>
			<td>Apakah pasien memakai kacamata ?</td>
			<td align="center">
				<input name="penglihatan_kacamata" id="penglihatan_kacamata" value="1" type="checkbox" ' . (($penglihatan_kacamata == '1') ? 'checked="checked"' : '') . ' >Ya&nbsp;&nbsp;			
				<input name="penglihatan_kacamata" id="penglihatan_kacamata" value="2" type="checkbox" ' . (($penglihatan_kacamata == '2') ? 'checked="checked"' : '') . ' >Tidak
			</td>
			<td rowspan="3" >Salah satu jawaban Ya = 1</td>
		</tr>
		<tr>
			<td>Apakah pasien mengeluh adanya penglihatan buram ?</td>
			<td align="center">
				<input name="penglihatan_buram" id="penglihatan_buram" value="1" type="checkbox" ' . (($penglihatan_buram == '1') ? 'checked="checked"' : '') . ' >Ya&nbsp;&nbsp;			
				<input name="penglihatan_buram" id="penglihatan_buram" value="2" type="checkbox" ' . (($penglihatan_buram == '2') ? 'checked="checked"' : '') . ' >Tidak
			</td>			
		</tr>
		<tr>
			<td>Apakah pasien mempunyai glokoma, katarak atau degerasi makula ?</td>
			<td align="center">
				<input name="penglihatan_glukoma" id="penglihatan_glukoma" value="1" type="checkbox" ' . (($penglihatan_glukoma == '1') ? 'checked="checked"' : '') . ' >Ya&nbsp;&nbsp;			
				<input name="penglihatan_glukoma" id="penglihatan_glukoma" value="2" type="checkbox" ' . (($penglihatan_glukoma == '2') ? 'checked="checked"' : '') . ' >Tidak
			</td>			
		</tr>
		<tr>
			<td>KEBIASAAN BERKEMIH</td>
			<td>Apakah terdapat perubahan perilaku berkemih ? (frekuensi, urgensi, inkontinensia, nokturia)</td>
			<td align="center" nowrap>
				<input name="kebiasaan_berkemih" id="kebiasaan_berkemih" value="1" type="checkbox" ' . (($kebiasaan_berkemih == '1') ? 'checked="checked"' : '') . ' >Ya&nbsp;&nbsp;			
				<input name="kebiasaan_berkemih" id="kebiasaan_berkemih" value="2" type="checkbox" ' . (($kebiasaan_berkemih == '2') ? 'checked="checked"' : '') . ' >Tidak
			</td>
			<td>Salah satu jawaban Ya = 2</td>
		</tr>
		<tr>
			<td rowspan="4" valign="top" style="padding-top:15px; ">TRANSFER (dari tempat tidur ke kursi dan kembali ke tempat tidur)</td>
			<td>Mandiri (boleh menggunakan alat bantu)</td>
			<td align="center">
				<input name="transfer_mandiri" id="transfer_mandiri" value="1" type="checkbox" ' . (($transfer_mandiri == '1') ? 'checked="checked"' : '') . ' >&nbsp;0			
			</td>
			<td rowspan="4">Jumlah nilai Transfer dan Mobilitas.<br><br>Jika nilai total 0-3 maka skor = 0</td>
		</tr>
		<tr>
			<td>Memerlukan sedikir bantuan (1 orang) / dalam pengawasan</td>
			<td align="center">
				<input name="transfer_bantuan_1_orang" id="transfer_bantuan_1_orang" value="1" type="checkbox" ' . (($transfer_bantuan_1_orang == '1') ? 'checked="checked"' : '') . ' >&nbsp;1			
			</td>			
		</tr>
		<tr>
			<td>Memerlukan bantuan yang nyata (2 orang)</td>
			<td align="center">
				<input name="transfer_bantuan_2_orang" id="transfer_bantuan_2_orang" value="1" type="checkbox" ' . (($transfer_bantuan_2_orang == '1') ? 'checked="checked"' : '') . ' >&nbsp;2
			</td>			
		</tr>
		<tr>
			<td>Tidak dapat duduk dengan simbang, perlu bantuan total</td>
			<td align="center">
				<input name="transfer_bantuan_total" id="transfer_bantuan_total" value="1" type="checkbox" ' . (($transfer_bantuan_total == '1') ? 'checked="checked"' : '') . ' >&nbsp;3
			</td>			
		</tr>
		<tr>
			<td rowspan="4" valign="top" style="padding-top:15px; ">MOBILITAS</td>
			<td>Mandiri (boleh menggunakan alat bantu jalan)</td>
			<td align="center">
				<input name="mobilitas_mandiri" id="mobilitas_mandiri" value="1" type="checkbox" ' . (($mobilitas_mandiri == '1') ? 'checked="checked"' : '') . ' >&nbsp;0			
			</td>
			<td rowspan="4">Jika nilai total 4-6 maka skor = 7</td>
		</tr>
		<tr>
			<td>Berjalan dengan bantuan 1 orang (verbal / fisik)</td>
			<td align="center">
				<input name="mobilitas_bantuan_1_orang" id="mobilitas_bantuan_1_orang" value="1" type="checkbox" ' . (($mobilitas_bantuan_1_orang == '1') ? 'checked="checked"' : '') . ' >&nbsp;1			
			</td>			
		</tr>
		<tr>
			<td>Menggunakan kursi roda</td>
			<td align="center">
				<input name="mobilitas_kursi_roda" id="mobilitas_kursi_roda" value="1" type="checkbox" ' . (($mobilitas_kursi_roda == '1') ? 'checked="checked"' : '') . ' >&nbsp;2
			</td>			
		</tr>
		<tr>
			<td>Immobilisasi</td>
			<td align="center">
				<input name="immobilisasi" id="immobilisasi" value="1" type="checkbox" ' . (($immobilisasi == '1') ? 'checked="checked"' : '') . ' >&nbsp;3
			</td>			
		</tr>
		<tr>
			<td colspan="3" style=" font-weight:bold;">TOTAL SKOR</td>
			<td width="5" align="center">' . $skor . '</td>			
		</tr>
	</table>';
	
	ob_start();
	include('edoc_rekammedik/edoc_frame_main.php');
	$html = ob_get_contents();
	ob_end_clean();
	if($st_print) $mpdf->AddPage('P');
	$mpdf->WriteHTML($html);
	$st_print = true;	
}
//End Skala Jatuh Ontario Modified Stratify Sydney Scoring (Untuk Pasien Geriatri)		

//Morse Fall Scale		
$edoc_nama_documen = strtoupper('Morse Fall Scale');

$qry_morse = 'SELECT t_operasi_morse_fall_scale.MORSE_FALL_SCALE_ID,
			  t_operasi_morse_fall_scale.RIWAYAT_JATUH,
			  t_operasi_morse_fall_scale.DIAGNOSIS_SEKUNDER,
			  t_operasi_morse_fall_scale.ALAT_BANTU,
			  t_operasi_morse_fall_scale.TERPASANG_INFUS,
			  t_operasi_morse_fall_scale.GAYA_BERJALAN,
			  t_operasi_morse_fall_scale.STATUS_MENTAL
			FROM t_operasi_morse_fall_scale
			WHERE t_operasi_morse_fall_scale.OPERASI_ID = "' . $idx . '"';
$get_morse = mysql_query($qry_morse) or die(mysql_error());
if(mysql_num_rows($get_morse) > 0){
	$dat_morse = mysql_fetch_assoc($get_morse);

	$morse_fall_scale_id = $dat_morse['MORSE_FALL_SCALE_ID'];
	$riwayat_jatuh = $dat_morse['RIWAYAT_JATUH'];
	$diagnosis_sekunder = $dat_morse['DIAGNOSIS_SEKUNDER'];
	$alat_bantu = $dat_morse['ALAT_BANTU'];
	$terpasang_infus = $dat_morse['TERPASANG_INFUS'];
	$gaya_berjalan = $dat_morse['GAYA_BERJALAN'];
	$status_mental = $dat_morse['STATUS_MENTAL'];
	
	$skor = 0;
	mysql_data_seek($get_morse,0);
	while($row = mysql_fetch_assoc($get_morse)){
		foreach($row as $key => $value) {
			if($key != 'MORSE_FALL_SCALE_ID') $skor = $skor + $value;
		}
	}
		
	$edoc_content = '<style>.tbl tr td {
	   border: 1px solid black;
	   padding-left:1px;
	   padding-bottom:1px;
	   border-collapse: collapse;
	}</style>
	<table width="100%" cellpadding="0" cellspacing="0" autosize="1" class="tbl" >
		<tr>
			<td align="center" bgcolor="#CCCCCC" ><strong>Faktor Risiko</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Skala</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Point</strong></td>
		</tr>
		<tr>
			<td rowspan="2" valign="top" style="padding-top:15px; ">RIWAYAT JATUH</td>			
			<td>
				<input name="riwayat_jatuh" id="riwayat_jatuh" value="25" type="checkbox" ' . (($riwayat_jatuh == '25') ? 'checked="checked"' : '') . ' >Ya&nbsp;&nbsp;							
			</td>
			<td align="center">25</td>
		</tr>
		<tr>			
			<td>				
				<input name="riwayat_jatuh" id="riwayat_jatuh" value="0" type="checkbox" ' . (($riwayat_jatuh == '0') ? 'checked="checked"' : '') . '>Tidak
			</td>		
			<td align="center">0</td>	
		</tr>		
		<tr>
			<td rowspan="2" valign="top" style="padding-top:15px; ">DIAGNOSIS SEKUNDER ( <u>></u> 2 DIAGNOSISIS MEDIS)</td>			
			<td>
				<input name="diagnosis_sekunder" id="diagnosis_sekunder" value="15" type="checkbox" ' . (($diagnosis_sekunder == '15') ? 'checked="checked"' : '') . ' >Ya&nbsp;&nbsp;			
			</td>
			<td align="center">15</td>
		</tr>
		<tr>			
			<td>				
				<input name="diagnosis_sekunder" id="diagnosis_sekunder" value="0" type="checkbox" ' . (($diagnosis_sekunder == '0') ? 'checked="checked"' : '') . ' >Tidak
			</td>			
			<td align="center">0</td>
		</tr>
		<tr>
			<td rowspan="3" valign="top" style="padding-top:15px; ">ALAT BANTU</td>
			<td>
				<input name="alat_bantu" id="alat_bantu" value="30" type="checkbox" ' . (($alat_bantu == '30') ? 'checked="checked"' : '') . ' >Berpegangan pada perabot&nbsp;&nbsp;							
			</td>
			<td align="center">30</td>
		</tr>
		<tr>			
			<td>				
				<input name="alat_bantu" id="alat_bantu" value="15" type="checkbox" ' . (($alat_bantu == '15') ? 'checked="checked"' : '') . ' >Tongkat / alat penopang
			</td>			
			<td align="center">15</td>
		</tr>		
		<tr>			
			<td>				
				<input name="alat_bantu" id="alat_bantu" value="0" type="checkbox" ' . (($alat_bantu == '0') ? 'checked="checked"' : '') . ' >Tidak ada / kursi roda / perawat / tirah baring
			</td>			
			<td align="center">0</td>
		</tr>
		<tr>
			<td rowspan="2" valign="top" style="padding-top:15px; ">TERPASANG INFUS</td>
			<td>
				<input name="terpasang_infus" id="terpasang_infus" value="20" type="checkbox" ' . (($terpasang_infus == '20') ? 'checked="checked"' : '') . ' >Ya&nbsp;&nbsp;							
			</td>
			<td align="center">20</td>
		</tr>
		<tr>			
			<td>				
				<input name="terpasang_infus" id="terpasang_infus" value="0" type="checkbox" ' . (($terpasang_infus == '0') ? 'checked="checked"' : '') . ' >Tidak
			</td>			
			<td align="center">0</td>
		</tr>		
		<tr>
			<td rowspan="3" valign="top" style="padding-top:15px; ">GAYA BERJALAN</td>
			<td>
				<input name="gaya_berjalan" id="gaya_berjalan" value="20" type="checkbox" ' . (($gaya_berjalan == '20') ? 'checked="checked"' : '') . ' >Terganggu&nbsp;&nbsp;							
			</td>
			<td align="center">20</td>
		</tr>
		<tr>			
			<td>				
				<input name="gaya_berjalan" id="gaya_berjalan" value="10" type="checkbox" ' . (($gaya_berjalan == '10') ? 'checked="checked"' : '') . ' >Lemah
			</td>			
			<td align="center">10</td>
		</tr>		
		<tr>			
			<td>				
				<input name="gaya_berjalan" id="gaya_berjalan" value="0" type="checkbox" ' . (($gaya_berjalan == '0') ? 'checked="checked"' : '') . ' >Normal / Tirah baring / Immobilisasi
			</td>			
			<td align="center">0</td>
		</tr>
		<tr>
			<td rowspan="2" valign="top" style="padding-top:15px; ">STATUS MENTAL</td>
			<td>
				<input name="status_mental" id="status_mental" value="15" type="checkbox" ' . (($status_mental == '15') ? 'checked="checked"' : '') . ' >Sering lupa akan keterbatasan yang dimiliki&nbsp;&nbsp;						
			</td>
			<td align="center">15</td>
		</tr>
		<tr>			
			<td>				
				<input name="status_mental" id="status_mental" value="0" type="checkbox" ' . (($status_mental == '0') ? 'checked="checked"' : '') . ' >Sadar akan kemampuan diri sendiri
			</td>			
			<td align="center">0</td>
		</tr>
		<tr>
			<td colspan="2" style=" font-weight:bold;">TOTAL SKOR</td>
			<td align="center">' . $skor . '</td>			
		</tr>
	</table>';
	
	ob_start();
	include('edoc_rekammedik/edoc_frame_main.php');
	$html = ob_get_contents();
	ob_end_clean();
	if($st_print) $mpdf->AddPage('P');
	$mpdf->WriteHTML($html);
	$st_print = true;	
}
//End Morse Fall Scale

//Ringkasan Operasi	
$edoc_nama_documen = strtoupper('Ringkasan Operasi');

$arr_jenis_operasi = getJenisOperasi();
$arr_jenis_luka = getJenisLuka();
$arr_lama_operasi = getLamaOperasi();

$qry_tindakan = 'SELECT m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,
					m_tarif.SATUAN,SUM(t_operasi_tarif.KUANTITI) AS KUANTITI,t_operasi_tarif.ICD_CODE
				FROM t_operasi_tarif
				INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_operasi_tarif.OPERASI_ID = "' . $idx . '"
				AND t_operasi_tarif.NO_TARIF IS NOT NULL
				AND (t_operasi_tarif.ST_BAYAR IS NULL OR t_operasi_tarif.ST_BAYAR = "Lunas")
				GROUP BY m_tarif.KODE_TARIF
				ORDER BY t_operasi_tarif.NO_TARIF';
$get_tindakan = mysql_query($qry_tindakan) or die(mysql_error());
if(mysql_num_rows($get_tindakan) > 0){
	$p_tindakan = array();
	$p_tindakan_group = array();
	$p_tindakan_icd = array();
	$p_tindakan_qty = array();

	while($dat_tindakan = mysql_fetch_array($get_tindakan)){
		$p_tindakan[] = $dat_tindakan['NAMA_TARIF']; 
		$p_tindakan_group[] = $dat_tindakan['NAMA_TARIF_GROUP'];
		$p_tindakan_icd[] = $dat_tindakan['ICD_CODE'];
		$p_tindakan_qty[] = $dat_tindakan['KUANTITI'];
	}
	
	$edoc_content = '<style>.tbl tr td {
	   border: 1px solid black;
	   padding-left:1px;
	   padding-bottom:1px;
	   border-collapse: collapse;
	}</style>
	<table width="100%" cellpadding="0" cellspacing="0" autosize="1" >
		<tr>
			<td>Cara Dirawat</td>
			<td>: ' . (($cara_dirawat == '1') ? 'Elektif' : '') . (($cara_dirawat == '2') ? 'Emergency' : '') . '</td> 
		</tr>
		<tr>
			<td>Jenis Operasi</td>
			<td>: ' . $arr_jenis_operasi[$jenis_operasi] . ' Keterangan : ' . $ket_jenis_operasi . '</td> 
		</tr>
		<tr>
			<td>Tipe Operasi</td>
			<td>: ' . (($tipe_operasi == '1') ? 'Terbuka' : '') . (($tipe_operasi == '2') ? 'Tertutup' : '') . '</td> 
		</tr>
		<tr>
			<td>Jenis Luka</td>
			<td>: ' . $arr_jenis_luka[$jenis_luka] . '</td> 
		</tr>
		<tr>
			<td>Lama Operasi</td>
			<td>: ' . $arr_lama_operasi[$lama_operasi] . '</td> 
		</tr>
		<tr>
			<td>ASA Score - Risk Score</td>
			<td>: ' . $asa_score . ' - ' . $risk_score . '</td> 
		</tr>
		<tr>
			<td>Perubahan Jadwal</td>
			<td>: ' . (($perubahan_jadwal == '1') ? 'Ya' : '') . ' ' . $plks_tanggal_operasi . ' ' . $plks_jam_operasi . ':' . $plks_menit_operasi . '</td> 
		</tr>
		<tr>
			<td>Keterangan</td>
			<td>: ' . $keterangan_perubahan . '</td> 
		</tr>';
	
	if(sizeof($p_tindakan) == 0){
		$edoc_content = $edoc_content . '
			<tr>
				<td valign="top">Tindakan</td>
				<td>:&nbsp;__________</td>
			</tr>
		</table>';
	}else{
		
		$p = 0;
		while($p < sizeof($p_tindakan)){
			$tindakan = $p_tindakan[$p] . ' (' . $p_tindakan_qty[$p] . ') - ' . $p_tindakan_group[$p];
			if(!empty($p_tindakan_icd[$p])) $tindakan = $tindakan . ' [' . $p_tindakan_icd[$p] . ']'; 	

			if($p == 0){
				$edoc_content = $edoc_content . '
					<tr>
						<td valign="top">Tindakan</td>
						<td>:&nbsp;' . $tindakan . '</td>
					</tr>';
			}else{
				$edoc_content = $edoc_content . '
					<tr>
						<td valign="top">&nbsp;</td>
						<td>' . $tindakan . '</td>
					</tr>';
			}	
			
		$p++;
		}	
		
	}
	
	$edoc_content = $edoc_content . '</table>';
	
	ob_start();
	include('edoc_rekammedik/edoc_frame_main.php');
	$html = ob_get_contents();
	ob_end_clean();
	if($st_print) $mpdf->AddPage('P');
	$mpdf->WriteHTML($html);
	$st_print = true;	
}
//End Ringkasan Operasi

if($st_print == true) {
	$mpdf->Output($rmfile_path . '/' . $nomr . '/' . $filename);	
	saveData($nomr,$rawat_id,$jnsorder,$id_document,$filename,$user_name,$idx,'');
}	
}
?>