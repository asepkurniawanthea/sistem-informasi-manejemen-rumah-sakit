<?php
function create_pdf_resume_medis($idx){
global $rmfile_path;
global $user_name;	
global $edoc_logo;
global $paper_width;
global $paper_height;
$jenis_document = 'Resume Medis';
$id_document = '17';	

$qry_anamnesis = 'SELECT t_irna.ANAMNESIS,t_irna.PEMERIKSAAN_FISIK, t_irna.PEMERIKSAAN_PENUNJANG,
				t_irna.ALASAN_DIRAWAT,t_irna.THERAPI,t_irna.MONITORING,t_irna.EVALUASI,t_irna.DIET,
				m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,
				m_pasien.JNS_KELAMIN,CONCAT(m_ruang.NAMA_RUANG," ",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,
				m_pegawai.NAMA_PEGAWAI AS DOKTER_PENANGGUNGJAWAB,
				DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_MASUK,
				DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d/%m/%Y") AS TANGGAL_KELUAR,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_PENGIRIM,
				CASE WHEN t_irna.P_JAWAB_NAMA IS NULL OR t_irna.P_JAWAB_NAMA = "" 
					THEN "Pasien" ELSE t_irna.P_JAWAB_NAMA END AS PENANGGUNGJAWAB,
				CASE WHEN t_irna.P_JAWAB_HUBUNGAN IS NULL OR t_irna.P_JAWAB_HUBUNGAN = "" 
					THEN "" ELSE CONCAT("(",t_irna.P_JAWAB_HUBUNGAN,")") END AS PENANGGUNGJAWAB_HUBUNGAN,
				m_pasien_pulang.KET_PASIEN_PULANG,t_irna.LANJUT_PENGOBATAN,t_irna.TEMPAT_RUJUKAN,
				DATE_FORMAT(t_irna.TGL_KONTROL_POLIKLINIK,"%d/%m/%Y") AS TGL_KONTROL_POLIKLINIK,
				t_irna.KET_PASIEN_PULANG
				FROM t_irna
				INNER JOIN t_irja ON (t_irna.IRNA_ID = t_irja.IRJA_ID)
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_irja.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_pasien_pulang on (t_irna.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
				WHERE t_irna.IRNA_ID = "' . $idx . '"';
$get_anamnesis = mysql_query($qry_anamnesis);
$dat_anamnesis = mysql_fetch_assoc($get_anamnesis);
$alasan_dirawat = $dat_anamnesis['ALASAN_DIRAWAT'];
$anamnesis = $dat_anamnesis['ANAMNESIS'];
$pemeriksaan_fisik = $dat_anamnesis['PEMERIKSAAN_FISIK'];
$pemeriksaan_penunjang = $dat_anamnesis['PEMERIKSAAN_PENUNJANG'];
$terapi = $dat_anamnesis['THERAPI'];
$hasil_konsul = $dat_anamnesis['MONITORING'];
$diet = $dat_anamnesis['DIET'];
$intruksi = $dat_anamnesis['EVALUASI'];
$keadaan_keluar = $dat_anamnesis['KET_PASIEN_PULANG'];
$lanjut_pengobatan_id = $dat_anamnesis['LANJUT_PENGOBATAN'];
$tempat_rujukan = $dat_anamnesis['TEMPAT_RUJUKAN'];
$tanggal_kontrol = $dat_anamnesis['TGL_KONTROL_POLIKLINIK'];
$keterangan_pulang = $dat_anamnesis['KET_PASIEN_PULANG'];

$nomr = $dat_anamnesis['NOMR'];
$nama_pasien = $dat_anamnesis['NAMA_PASIEN'];
$tgl_lahir = $dat_anamnesis['TGL_LAHIR'];
$jns_kelamin = $dat_anamnesis['JNS_KELAMIN'];
$unit_id = $dat_anamnesis['NAMA_RUANG'];
$dokter_pengirim = $dat_anamnesis['DOKTER_PENGIRIM'];
$dokter_penanggungjawab = $dat_anamnesis['DOKTER_PENANGGUNGJAWAB'];
$tanggal_masuk = $dat_anamnesis['TANGGAL_MASUK'];
$tanggal_keluar = $dat_anamnesis['TANGGAL_KELUAR'];
$penanggungjawab = $dat_anamnesis['PENANGGUNGJAWAB'] . ' ' . $dat_anamnesis['PENANGGUNGJAWAB_HUBUNGAN'];

$edoc_norm = formatNoMR($nomr);
$edoc_nama_pasien = $nama_pasien;
$edoc_tanggal_lahir = changeDateFormat($tgl_lahir);
$edoc_jenis_kelamin = jenisKelamin($jns_kelamin);
$edoc_unit = $unit_id;
$edoc_nama_documen = strtoupper($jenis_document);

createFolder($nomr);
$filename = $nomr . '_RI' . $idx . '_' . $id_document . '.pdf' ;

$mpdf = new mPDF('utf-8', array($paper_width,$paper_height));
$mpdf->autoPageBreak = false;
$mpdf->SetHTMLHeader(setHeader($nomr,$nama_pasien));
$mpdf->SetHTMLFooter(setFooter($jenis_document));

$edoc_content = '<table border="0" width="100%" cellpadding="0" cellspacing="0" class="tbc" autosize="1" >
			<tr>
				<td width="200">Tanggal Masuk</td>
				<td>:&nbsp;' . $tanggal_masuk . '</td>
				<td width="120">Tanggal Keluar</td>
				<td>:&nbsp;' . $tanggal_keluar . '</td>
			</tr>
			<tr>
				<td width="200">Dokter Yang Mengirim</td>
				<td>:&nbsp;' . $dokter_pengirim . '</td>
				<td width="120">Dokter Yang Merawat</td>
				<td>:&nbsp;' . $dokter_penanggungjawab . '</td>
			</tr>';
$qry_diagnosis = 'SELECT t_irja_diagnosa.DIAGNOSA,t_irja_diagnosa.ICD_CODE,t_irja_diagnosa.DIAGNOSA_ORDER
					FROM t_irja_diagnosa
					WHERE t_irja_diagnosa.IRJA_ID = "' . $idx . '"
					ORDER BY t_irja_diagnosa.DIAGNOSA_ORDER';
$get_diagnosis = mysql_query($qry_diagnosis) or die(mysql_error());
if(mysql_num_rows($get_diagnosis) == 0){
	$edoc_content = $edoc_content . '<tr>
				<td width="200">Penanggungjawab Pembayaran</td>
				<td>:&nbsp;' . $penanggungjawab . '</td>
				<td width="120">Diagnosis</td>
				<td>:&nbsp;__________</td>
			</tr>
			</table>';
}else{
	$r = 1;
	while($dat_diagnosis = mysql_fetch_array($get_diagnosis)){
		if($r==1){
			$edoc_content = $edoc_content . '<tr>
				<td width="200">Penanggungjawab Pembayaran</td>
				<td>:&nbsp;' . $penanggungjawab . '</td>
				<td width="120">Diagnosis</td>';
			$diagnosis = $dat_diagnosis['DIAGNOSA'];
			if(!empty($dat_diagnosis['ICD_CODE'])) $diagnosis = $diagnosis . ' (' . $dat_diagnosis['ICD_CODE'] . ')'; 	
			$edoc_content = $edoc_content .	'<td>:&nbsp;' . $diagnosis . '</td>
							</tr>';
		}else{
			$edoc_content = $edoc_content . '<tr>
				<td width="200">&nbsp;</td>
				<td>&nbsp;</td>
				<td width="120">&nbsp;</td>';
			$diagnosis = $dat_diagnosis['DIAGNOSA'];
			if(!empty($dat_diagnosis['ICD_CODE'])) $diagnosis = $diagnosis . ' (' . $dat_diagnosis['ICD_CODE'] . ')'; 	
			$edoc_content = $edoc_content .	'<td>&nbsp;' . $diagnosis . '</td>
							</tr>';
		}
	$r++;
	}
	
	$edoc_content = $edoc_content . '</table>';
}					
			
$edoc_content = $edoc_content . '<table width="100%" border="0" autosize="1" >
        <tr>
            <td valign="top">&nbsp;</td>
            <td width="50%">&nbsp;</td>
        </tr>
		<tr>
            <td valign="top">Alasan Masuk Dirawat</td>
            <td width="50%">:&nbsp;' . setGarisIfNull($alasan_dirawat) . '</td>
        </tr>
		<tr>
            <td valign="top">Ringkasan Riwayat Penyakit</td>
            <td>:&nbsp;' . setGarisIfNull($anamnesis) . '</td>
        </tr>
        <tr>
            <td valign="top">Pemeriksaan Fisik</td>
            <td>:&nbsp;' . setGarisIfNull($pemeriksaan_fisik) . '</td>
        </tr>
        <tr>
            <td valign="top">Pemeriksaan Penunjang/ <br />Diagnostik Terpenting</td>
            <td>:&nbsp;' . setGarisIfNull($pemeriksaan_penunjang) . '</td>
        </tr>
		<tr>
            <td valign="top">Terapi/ Pengobatan Selama<br />Di RSK. Dr. Sitanala</td>
            <td>:&nbsp;' . setGarisIfNull($terapi) . '</td>
        </tr>
		<tr>
            <td valign="top">Hasil Konsultasi</td>
            <td>:&nbsp;' . setGarisIfNull($hasil_konsul) . '</td>
        </tr>';

$qry_diagnosis_irna = 'SELECT t_irna_diagnosa.DIAGNOSA,t_irna_diagnosa.ICD_CODE,t_irna_diagnosa.DIAGNOSA_ORDER
					FROM t_irna_diagnosa
					WHERE t_irna_diagnosa.IRNA_ID = "' . $idx . '"
					AND t_irna_diagnosa.DIAGNOSA_ORDER = 0
					ORDER BY t_irna_diagnosa.DIAGNOSA_ORDER';
$get_diagnosis_irna = mysql_query($qry_diagnosis_irna) or die(mysql_error());
if(mysql_num_rows($get_diagnosis_irna) == 0){
	$edoc_content = $edoc_content . '<tr>
				<td valign="top">Diagnosis Utama</td>
				<td>:&nbsp;__________</td>
			</tr>';
}else{
	$r = 1;
	while($dat_diagnosis_irna = mysql_fetch_array($get_diagnosis_irna)){
	$diagnosis_irna = $dat_diagnosis_irna['DIAGNOSA'];
	if(!empty($dat_diagnosis_irna['ICD_CODE'])) $diagnosis_irna = $diagnosis_irna . ' (' . $dat_diagnosis_irna['ICD_CODE'] . ')'; 	
	
		if($r==1){
			$edoc_content = $edoc_content . '<tr>
				<td valign="top">Diagnosis Utama</td>
				<td>:&nbsp;' . $diagnosis_irna . '</td>
			</tr>';
		}else{
			$edoc_content = $edoc_content . '<tr>
					<td valign="top">&nbsp;</td>
					<td>&nbsp;' . $diagnosis_irna . '</td>
				</tr>';
		}
	$r++;
	}
}

$qry_diagnosa_sk_irna = 'SELECT t_irna_diagnosa.DIAGNOSA,t_irna_diagnosa.ICD_CODE,t_irna_diagnosa.DIAGNOSA_ORDER
					FROM t_irna_diagnosa
					WHERE t_irna_diagnosa.IRNA_ID = "' . $idx . '"
					AND t_irna_diagnosa.DIAGNOSA_ORDER > 0
					ORDER BY t_irna_diagnosa.DIAGNOSA_ORDER';
$get_diagnosa_sk_irna = mysql_query($qry_diagnosa_sk_irna) or die(mysql_error());
if(mysql_num_rows($get_diagnosa_sk_irna) == 0){
	$edoc_content = $edoc_content . '<tr>
				<td valign="top">Diagnosis Sekunder</td>
				<td>:&nbsp;__________</td>
			</tr>';
}else{
	$r = 1;
	while($dat_diagnosa_sk_irna = mysql_fetch_array($get_diagnosa_sk_irna)){
	$diagnosa_sk_irna = $dat_diagnosa_sk_irna['DIAGNOSA'];
	if(!empty($dat_diagnosa_sk_irna['ICD_CODE'])) $diagnosa_sk_irna = $diagnosa_sk_irna . ' (' . $dat_diagnosa_sk_irna['ICD_CODE'] . ')'; 	
	
		if($r==1){
			$edoc_content = $edoc_content . '<tr>
				<td valign="top">Diagnosis Sekunder</td>
				<td>:&nbsp;' . $diagnosa_sk_irna . '</td>
			</tr>';
		}else{
			$edoc_content = $edoc_content . '<tr>
					<td valign="top">&nbsp;</td>
					<td>&nbsp;' . $diagnosa_sk_irna . '</td>
				</tr>';
		}
	$r++;
	}
}

$edoc_content = $edoc_content . '</table>';
ob_start();
include('edoc_rekammedik/edoc_frame_main.php');
$html = ob_get_contents();
ob_end_clean();
$mpdf->WriteHTML($html);

$edoc_content_2 = '<table width="100%" border="0" autosize="1" >';

$qry_tindakan = 'SELECT m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,
					m_tarif.SATUAN,SUM(t_irna_tarif.KUANTITI) AS KUANTITI,t_irna_tarif.ICD_CODE
					FROM t_irna_tarif
					INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE t_irna_tarif.IRNA_ID = "' . $idx . '" 
					AND m_tarif_group.KODE_TARIF_GROUP <> "01" 
					AND m_tarif_group.KODE_TARIF_GROUP <> "02" AND m_tarif_group.KODE_TARIF_GROUP <> "09" 
					AND m_tarif_group.KODE_TARIF_GROUP <> "49" AND m_tarif_group.KODE_TARIF_GROUP <> "50"
					AND m_tarif_group.KODE_TARIF_GROUP <> "51" AND m_tarif_group.KODE_TARIF_GROUP <> "52"
					AND m_tarif_group.KODE_TARIF_GROUP <> "92" AND m_tarif_group.KODE_TARIF_GROUP <> "93"
					AND m_tarif_group.KODE_TARIF_GROUP <> "102" AND m_tarif_group.KODE_TARIF_GROUP <> "103"
					AND m_tarif_group.KODE_TARIF_GROUP <> "104" AND m_tarif_group.KODE_TARIF_GROUP <> "105"
					AND t_irna_tarif.NO_TARIF IS NOT NULL 
					AND (t_irna_tarif.ST_BAYAR IS NULL OR t_irna_tarif.ST_BAYAR = "Lunas")
					GROUP BY m_tarif.KODE_TARIF';
$get_tindakan = mysql_query($qry_tindakan) or die(mysql_error());
if(mysql_num_rows($get_tindakan) == 0){
	$edoc_content_2 =  $edoc_content_2 . '<tr>
            <td valign="top">Tindakan/ Procedure</td>
            <td>:&nbsp;__________</td>
        </tr>';
}else{
	$r = 1;
	$y = 1;
	while($dat_tindakan = mysql_fetch_array($get_tindakan)){
		$tindakan = $dat_tindakan['NAMA_TARIF'] . ' (' . $dat_tindakan['KUANTITI'] . ') - ' . $dat_tindakan['NAMA_TARIF_GROUP'];
		if(!empty($dat_tindakan['ICD_CODE'])) $tindakan = $tindakan . ' [' . $dat_tindakan['ICD_CODE'] . ']'; 	
		
		if($r==1){
			$edoc_content_2 =  $edoc_content_2 . '<tr>
            <td valign="top">Tindakan/ Procedure</td>
            <td>:&nbsp;' . $tindakan . '</td>
        </tr>';
		}else{
			$edoc_content_2 =  $edoc_content_2 . '<tr>
            <td>&nbsp;</td>
            <td>&nbsp;' . $tindakan . '</td>
        </tr>';
		}
		
		if($y == 20){
			$edoc_content_2 = $edoc_content_2 . '</table>';
			ob_start();
			include('edoc_rekammedik/edoc_frame_add.php');
			$html = ob_get_contents();
			ob_end_clean();
			$mpdf->AddPage('P'); 
			$mpdf->WriteHTML($html);
			$y = 0;	
			$edoc_content_2 = '<table width="100%" border="0" autosize="1" >';
		}
		$y++;	
	$r++;
	}
}

if($edoc_content_2 != '<table width="100%" border="0" autosize="1" >'){
	$edoc_content_2 = $edoc_content_2 . '</table>';
	ob_start();
	include('edoc_rekammedik/edoc_frame_add.php');
	$html = ob_get_contents();
	ob_end_clean();
	$mpdf->AddPage('P'); 
	$mpdf->WriteHTML($html);
}	

$edoc_content_2 = '<table width="100%" border="0" autosize="1" >';

$qry_alergi = 'SELECT t_irna_alergi.ALERGI,t_irna_alergi.IRNA_ID
					FROM t_irna_alergi
					WHERE t_irna_alergi.IRNA_ID = "' . $idx . '"';
$get_alergi = mysql_query($qry_alergi) or die(mysql_error());
if(mysql_num_rows($get_alergi) == 0){
	$edoc_content_2 =  $edoc_content_2 . '<tr>
            <td valign="top">Alergi (Reaksi Obat)</td>
            <td>:&nbsp;__________</td>
        </tr>';
}else{
	$x = 1;
	while($dat_alergi = mysql_fetch_array($get_alergi)){
		if($x == 1){
			$edoc_content_2 =  $edoc_content_2 . '<tr>
            <td valign="top">Alergi (Reaksi Obat)</td>
            <td>:&nbsp;' . $dat_alergi['ALERGI'] . '</td>
        </tr>';
		}else{
			$edoc_content_2 =  $edoc_content_2 . '<tr>
            <td>&nbsp;</td>
            <td>&nbsp;' . $dat_alergi['ALERGI'] . '</td>
        </tr>';
		}
	
	$x++;
	}
}	

$qry_laboratorium = 'SELECT DISTINCT m_tarif.KODE_TARIF,m_tarif_group.NAMA_TARIF_GROUP,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_TARIF
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" 
				AND t_ipenunjang.JNS_ORDER = "IRN" 
				AND t_ipenunjang.NO_ORDER IS NOT NULL
				AND t_ipenunjang_tarif.ST_PERIKSA IS NULL
				AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1")';
$get_laboratorium = mysql_query($qry_laboratorium) or die(mysql_error());
if(mysql_num_rows($get_laboratorium) == 0){
	$edoc_content_2 =  $edoc_content_2 . '<tr>
            <td valign="top">Hasil Laboratorium <br />Belum Selesai (pending)</td>
            <td>:&nbsp;__________</td>
        </tr>';
}else{
	$y = 1;
	while($dat_laboratorium = mysql_fetch_array($get_laboratorium)){
		if($y == 1){
			$edoc_content_2 =  $edoc_content_2 . '<tr>
            <td valign="top">Hasil Laboratorium <br />Belum Selesai (pending)</td>
            <td>:&nbsp;' . $dat_laboratorium['NAMA_TARIF'] . '(' . $dat_laboratorium['NAMA_TARIF_GROUP'] . ')</td>
        </tr>';
		}else{
			
		}
	
	$y++;
	}
}
				

$lanjut_pengobatan[1] = 'Poliklinik';				
$lanjut_pengobatan[2] = 'RS Lain';				
$lanjut_pengobatan[3] = 'Puskesmas';				
$lanjut_pengobatan[4] = 'Dokter Luar';				
$lanjut_pengobatan[5] = 'Lain-lain';	

$tmp = 	$lanjut_pengobatan[$lanjut_pengobatan_id];
if(!empty($tempat_rujukan)) $tmp = $tmp . ' ' . $tempat_rujukan;
				
$edoc_content_2 = $edoc_content_2 . '<tr>
            <td valign="top">Diet</td>
            <td>:&nbsp;' . setGarisIfNull($diet) . '</td>
        </tr>
		<tr>
            <td valign="top">Intruksi/Anjuran dan <br />Edukasi (Folow up)</td>
            <td>:&nbsp;' . setGarisIfNull($intruksi) . '</td>
        </tr>
		<tr>
            <td valign="top">Kondisi Waktu Keluar</td>
            <td>:&nbsp;' . setGarisIfNull($keadaan_keluar) . '</td>
        </tr>
		<tr>
            <td valign="top">Pengobatan Dilanjutkan</td>
            <td>:&nbsp;' . setGarisIfNull($tmp) . '</td>
        </tr>
		<tr>
            <td valign="top">Tanggal Kontrol Poliklinik</td>
            <td>:&nbsp;' . setGarisIfNull($tanggal_kontrol) . '</td>
        </tr>
    </table>';

ob_start();
include('edoc_rekammedik/edoc_frame_add.php');
$html = ob_get_contents();
ob_end_clean();
$mpdf->AddPage('P'); 
$mpdf->WriteHTML($html);

$edoc_content_2 = '<style>.tbl tr td {
	   border: 1px solid black;
	   padding-left:1px;
	   border-collapse: collapse;
	}</style>
	Terapi Pulang :<br />
	<table width="100%" class="tbl" cellpadding="0" cellspacing="0" autosize="1" >
				  <tr>
					<td align="center" bgcolor="#CCCCCC" ><strong>Nama Obat</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Jumlah</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Dosis</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Frekuensi</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Cara Pemberian</strong></td>
				</tr>';

$qry_terapi = 'SELECT t_irna_terapi_pulang.TERAPI_PULANG_ID,t_irna_terapi_pulang.NAMA_OBAT,
						t_irna_terapi_pulang.JUMLAH,t_irna_terapi_pulang.DOSIS,t_irna_terapi_pulang.FREKUENSI,
						t_irna_terapi_pulang.CARA_PEMBERIAN
						FROM t_irna_terapi_pulang
						WHERE t_irna_terapi_pulang.IRNA_ID = "' . $idx . '"';
$get_terapi = mysql_query($qry_terapi) or die(mysql_error());
while($dat_terapi = mysql_fetch_array($get_terapi)){
	$edoc_content_2 = $edoc_content_2 . '<tr>
						<td>' . $dat_terapi['NAMA_OBAT'] . '</td>
						<td>' . $dat_terapi['JUMLAH'] . '</td>
						<td>' . $dat_terapi['DOSIS'] . '</td>
						<td>' . $dat_terapi['FREKUENSI'] . '</td>
						<td>' . $dat_terapi['CARA_PEMBERIAN'] . '</td>';
}						
$edoc_content_2 = $edoc_content_2 . '</table>';

ob_start();
include('edoc_rekammedik/edoc_frame_add.php');
$html = ob_get_contents();
ob_end_clean();
$mpdf->AddPage('P'); 
$mpdf->WriteHTML($html);

if(!empty($keterangan_pulang)){
	$edoc_content_2 = '<table width="100%" border="0" autosize="1" >
					<tr>
						<td valign="top">Keterangan</td>
						<td>:&nbsp;' . setGarisIfNull($keterangan_pulang) . '</td>
					</tr>
					</table>';
	ob_start();
	include('edoc_rekammedik/edoc_frame_add.php');
	$html = ob_get_contents();
	ob_end_clean();
	$mpdf->AddPage('P'); 
	$mpdf->WriteHTML($html);

}

$mpdf->Output($rmfile_path . '/' . $nomr . '/' . $filename);	

saveData($nomr,$idx,'2',$id_document,$filename,$user_name,'','');
}
?>