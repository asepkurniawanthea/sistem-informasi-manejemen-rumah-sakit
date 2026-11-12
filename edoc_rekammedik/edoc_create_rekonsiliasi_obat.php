<?php
function create_pdf_rekonsiliasi_obat($idx){
global $rmfile_path;
global $user_name;	
global $edoc_logo;
global $paper_width;
global $paper_height;
$jenis_document = 'Formulir Rekonsiliasi Obat';
$id_document = '18';	

$qry_pasien = 'SELECT m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,
				m_pasien.JNS_KELAMIN,CONCAT(m_ruang.NAMA_RUANG," ",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,
				m_pegawai.NAMA_PEGAWAI AS DOKTER_PENANGGUNGJAWAB,
				DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_MASUK,
				DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d/%m/%Y") AS TANGGAL_KELUAR,
				DATE_FORMAT(t_irna_rekonsiliasi.TANGGAL,"%d/%m/%Y %H:%i") AS TANGGAL,
				t_irna_rekonsiliasi.BERAT_BADAN,t_irna_rekonsiliasi.TINGGI_BADAN,
				DATE_FORMAT(t_irna_rekonsiliasi.TANGGAL_DOKTER,"%d/%m/%Y") AS TANGGAL_DOKTER,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER,
				DATE_FORMAT(t_irna_rekonsiliasi.APOTEKER_TANGGAL,"%d/%m/%Y") AS APOTEKER_TANGGAL,
				t_irna_rekonsiliasi.APOTEKER,
				DATE_FORMAT(t_irna_rekonsiliasi.PERAWAT_TANGGAL,"%d/%m/%Y") AS PERAWAT_TANGGAL,
				m_pegawai3.NAMA_PEGAWAI AS PERAWAT,
				t_irna_rekonsiliasi.INTRUKSI_DOKTER
				FROM t_irna
				INNER JOIN t_irja ON (t_irna.IRNA_ID = t_irja.IRJA_ID)
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN t_irna_rekonsiliasi ON (t_irna.IRNA_ID = t_irna_rekonsiliasi.IRNA_ID)
				LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_irna_rekonsiliasi.DOKTER = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai3 ON (t_irna_rekonsiliasi.PERAWAT = m_pegawai3.PEGAWAI_ID)
				WHERE t_irna.IRNA_ID = "' . $idx . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);

$nomr = $dat_pasien['NOMR'];
$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = $dat_pasien['TGL_LAHIR'];
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$unit_id = $dat_pasien['NAMA_RUANG'];
$dokter_penanggungjawab = $dat_pasien['DOKTER_PENANGGUNGJAWAB'];
$tanggal_masuk = $dat_pasien['TANGGAL_MASUK'];
$tanggal_keluar = $dat_pasien['TANGGAL_KELUAR'];

$intruksi_dokter = $dat_pasien['INTRUKSI_DOKTER'];
$tanggal_rekon = $dat_pasien['TANGGAL'];
$berat_badan = $dat_pasien['BERAT_BADAN'];
$tinggi_badan = $dat_pasien['TINGGI_BADAN'];

$dokter_tanggal = $dat_pasien['TANGGAL_DOKTER'];
$dokter = $dat_pasien['DOKTER'];
$apoteker_tanggal = $dat_pasien['APOTEKER_TANGGAL'];
$apoteker = $dat_pasien['APOTEKER'];
$perawat_tanggal = $dat_pasien['PERAWAT_TANGGAL'];
$perawat = $dat_pasien['PERAWAT'];

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

$edoc_header = '<style>.tbl tr td {
	   border: 1px solid black;
	   padding-left:1px;
	   border-collapse: collapse;
	}</style>
	<table width="100%" class="tbl" cellpadding="0" cellspacing="0" autosize="1" >
				  <tr>
					<td width="40" rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>No</strong></td>
					<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Daftar Nama Obat</td>
					<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Dosis (mg, ml,mcrogram,<br />gram, unit)</strong></td>
					<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Frekuensi</strong></td>
					<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Rute Pemberian</strong></td>
					<td colspan="2" align="center" bgcolor="#CCCCCC" ><strong>Tanggal</strong></td>
					<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Obat Dilanjutkan<br />Selama Perawatan</strong></td>
					<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Obat Dilanjutkan<br />Saat Pasien Pulang</strong></td>
				</tr>
				<tr>
				  <td align="center" bgcolor="#CCCCCC" ><strong>Mulai</strong></td>
				  <td align="center" bgcolor="#CCCCCC" ><strong>Stop</strong></td>
				</tr>';

$qry_rekon = 'SELECT t_irna_rekonsiliasi_obat.REKONSILIASI_ID,t_irna_rekonsiliasi_obat.NAMA_OBAT,
						t_irna_rekonsiliasi_obat.DOSIS,t_irna_rekonsiliasi_obat.FREKUENSI,t_irna_rekonsiliasi_obat.RUTE_PEMBERIAN,
						t_irna_rekonsiliasi_obat.TGL_MULAI,t_irna_rekonsiliasi_obat.TGL_STOP,
						t_irna_rekonsiliasi_obat.DILANJUTKAN_SELAMA_PERAWATAN,t_irna_rekonsiliasi_obat.DILANJUTKAN_SAAT_PULANG
						FROM t_irna_rekonsiliasi_obat
						WHERE t_irna_rekonsiliasi_obat.IRNA_ID = "' . $idx . '"';
$get_rekon = mysql_query($qry_rekon) or die(mysql_error());
if(mysql_num_rows($get_rekon) > 0){
	$edoc_main = '';
	$x = 1;
	$y = 1;
	$st_print = false;
	while($dat_rekon = mysql_fetch_array($get_rekon)){
		$edoc_main = $edoc_main . '<tr>
							<td align="center">' . $x . '</td>
							<td>' . $dat_rekon['NAMA_OBAT'] . '</td>
							<td>' . $dat_rekon['DOSIS'] . '</td>
							<td>' . $dat_rekon['FREKUENSI'] . '</td>
							<td>' . $dat_rekon['RUTE_PEMBERIAN'] . '</td>
							<td>' . $dat_rekon['TGL_MULAI'] . '</td>
							<td>' . $dat_rekon['TGL_STOP'] . '</td>
							<td align="center">' . (($dat_rekon['DILANJUTKAN_SELAMA_PERAWATAN'] == '1') ? '&radic;' : '') . '</td>
							<td align="center">' . (($dat_rekon['DILANJUTKAN_SAAT_PULANG'] == '1') ? '&radic;' : '') . '</td>
							</tr>';
		if($x == 10){
			$edoc_content = $edoc_header . $edoc_main . '</table>';
			$edoc_main = '';
			ob_start();
			include('edoc_rekammedik/edoc_frame_main.php');
			$html = ob_get_contents();
			ob_end_clean();
			$mpdf->WriteHTML($html);
		}else if($x > 10){
			if($y == 15){
				$edoc_content_2 = $edoc_header . $edoc_main . '</table>';
				$edoc_main = '';
				$y = 0;
				ob_start();
				include('edoc_rekammedik/edoc_frame_add.php');
				$html = ob_get_contents();
				ob_end_clean();
				$mpdf->AddPage('P'); 
				$mpdf->WriteHTML($html);
			}
			$y++;
		}								
	$x++;						
	}						

if($edoc_main != ''){
$st_print = true;	
	if($x > 10){
		$edoc_content_2 = $edoc_header . $edoc_main . '</table>';
		ob_start();
		include('edoc_rekammedik/edoc_frame_add.php');
		$html = ob_get_contents();
		ob_end_clean();
		$mpdf->AddPage('P'); 
		$mpdf->WriteHTML($html);
	}else{
		
		$edoc_content = $edoc_header . $edoc_main . '</table>';
		ob_start();
		include('edoc_rekammedik/edoc_frame_main.php');
		$html = ob_get_contents();
		ob_end_clean();
		$mpdf->AddPage('P'); 
		$mpdf->WriteHTML($html);
	}	
}	

$edoc_content_2 = '<table border="0" width="100%" >
			<tr>
				<td width="100">Tanggal</td>
				<td>:&nbsp;' . setGarisIfNull($tanggal_rekon) . '</td>
				<td width="100">Berat Badan</td>
				<td>:&nbsp;' . setGarisIfNull($berat_badan) . '</td>
				<td width="100">Tinggi Badan</td>
				<td>:&nbsp;' . setGarisIfNull($tinggi_badan) . '</td>
			</tr>';
			
$qry_diagnosa = 'SELECT t_irna_diagnosa.DIAGNOSA,t_irna_diagnosa.ICD_CODE,t_irna_diagnosa.DIAGNOSA_ORDER
					FROM t_irna_diagnosa
					WHERE t_irna_diagnosa.IRNA_ID = "' . $idx . '"
					ORDER BY t_irna_diagnosa.DIAGNOSA_ORDER';
$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
if(mysql_num_rows($get_diagnosa) == 0){
	  $edoc_content_2 = $edoc_content_2 . '<tr>
				<td width="100">Diagnostik</td>
				<td colspan="5">:&nbsp;' . setGarisIfNull('') . '</td>
			</tr>';
}else{	  
	$c = 1;
	while($dat_diagnosa = mysql_fetch_array($get_diagnosa)){
		$diagnosa = $dat_diagnosa['DIAGNOSA'];
		if(!empty($dat_diagnosa['ICD_CODE'])) $diagnosa = $diagnosa . ' (' . $dat_diagnosa['ICD_CODE'] . ')'; 
	
		if($c == 1){
			$edoc_content_2 = $edoc_content_2 . '<tr>
				<td width="100">Diagnostik</td>
				<td colspan="5">:&nbsp;' . setGarisIfNull($diagnosa) . '</td>
			</tr>';
		}else{
			$edoc_content_2 = $edoc_content_2 . '<tr>
				<td width="100">&nbsp;</td>
				<td colspan="5">&nbsp;' . setGarisIfNull($diagnosa) . '</td>
			</tr>';	  
		}
	$c++;
	}	
}				
			
$qry_alergi = 'SELECT t_irna_alergi.ALERGI
					FROM t_irna_alergi
					WHERE t_irna_alergi.IRNA_ID = "' . $idx . '"';
$get_alergi = mysql_query($qry_alergi) or die(mysql_error());
if(mysql_num_rows($get_alergi) == 0){
	  $edoc_content_2 = $edoc_content_2 . '<tr>
				<td width="100">Alergi Obat</td>
				<td colspan="5">:&nbsp;' . setGarisIfNull('') . '</td>
			</tr>';
}else{	  
	$c = 1;
	while($dat_alergi = mysql_fetch_array($get_alergi)){
		
		if($c == 1){
			$edoc_content_2 = $edoc_content_2 . '<tr>
				<td width="100">Alergi Obat</td>
				<td colspan="5">:&nbsp;' . setGarisIfNull($dat_alergi['ALERGI']) . '</td>
			</tr>';
		}else{
			$edoc_content_2 = $edoc_content_2 . '<tr>
				<td width="100">&nbsp;</td>
				<td colspan="5">&nbsp;' . setGarisIfNull($dat_alergi['ALERGI']) . '</td>
			</tr>';	  
		}
	$c++;
	}	
}

$edoc_content_2 = $edoc_content_2 . '<tr>
				<td width="100">Intruksi Dokter</td>
				<td colspan="5">:&nbsp;' . setGarisIfNull($intruksi_dokter) . '</td>
			</tr>
			<tr>
				<td width="100">Dokter</td>
				<td>:&nbsp;' . setGarisIfNull($dokter) . '</td>
				<td width="100">Tanggal</td>
				<td>:&nbsp;' . setGarisIfNull($dokter_tanggal) . '</td>
				<td width="100">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="100">Perawat Penanggungjawab</td>
				<td>:&nbsp;' . setGarisIfNull($perawat) . '</td>
				<td width="100">Tanggal</td>
				<td>:&nbsp;' . setGarisIfNull($perawat_tanggal) . '</td>
				<td width="100">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="100">Apoteker</td>
				<td>:&nbsp;' . setGarisIfNull($apoteker) . '</td>
				<td width="100">Tanggal</td>
				<td>:&nbsp;' . setGarisIfNull($apoteker_tanggal) . '</td>
				<td width="100">&nbsp;</td>
				<td>&nbsp;</td>
			</tr></table>';
			
ob_start();
include('edoc_rekammedik/edoc_frame_add.php');
$html = ob_get_contents();
ob_end_clean();
$mpdf->AddPage('P'); 
$mpdf->WriteHTML($html);			

$mpdf->Output($rmfile_path . '/' . $nomr . '/' . $filename);	
saveData($nomr,$idx,'2',$id_document,$filename,$user_name,'','');
}	
}
?>