<?php
function create_pdf_catatan_perkembangan_pasien($idx,$perawatan){
global $rmfile_path;
global $user_name;	
global $edoc_logo;
global $paper_width;
global $paper_height;
$jenis_document = 'Catatan Perkembangan Pasien Terintegrasi';
$id_document = '7';	

if($perawatan == 'RJ'){
	$jns_rawat = '1';
	$qry_perkembangan = 'SELECT m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,t_irja.UNIT_ID,m_unit.NAMA_UNIT,
					m_pegawai.NAMA_PEGAWAI,"" AS JNS_ORDER, "" AS RAWAT_ID
					FROM t_irja
					INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
					INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
					LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_irja.IRJA_ID = "' . $idx . '"';
	$qry_catatan = 'SELECT DATE_FORMAT(t_irja_perkembangan.TANGGAL,"%d/%m/%Y %H:%i%s") AS TANGGAL,m_pegawai.NAMA_PEGAWAI AS PEMBERI_ASUHAN,
					t_irja_perkembangan.HASIL_ASESMEN,t_irja_perkembangan.INTRUKSI_PPA,t_irja_perkembangan.VERIFIKASI_DPJP
					FROM t_irja_perkembangan
					LEFT JOIN m_pegawai ON (t_irja_perkembangan.PEMBERI_ASUHAN = m_pegawai.PEGAWAI_ID)
					WHERE t_irja_perkembangan.IRJA_ID = "' . $idx . '"
					ORDER BY t_irja_perkembangan.TANGGAL';				
}else if($perawatan == 'RI'){
	$jns_rawat = '2';
	$qry_perkembangan = 'SELECT m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,t_irna.RUANG_ID AS UNIT_ID,
					CONCAT(m_ruang.NAMA_RUANG," ",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,
					m_pegawai.NAMA_PEGAWAI,"" AS JNS_ORDER, "" AS RAWAT_ID
					FROM t_irna
					INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
					INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
					LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_irna.IRNA_ID = "' . $idx . '"';
	$qry_catatan = 'SELECT DATE_FORMAT(t_irna_perkembangan.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i%s") AS TANGGAL,m_pegawai.NAMA_PEGAWAI AS PEMBERI_ASUHAN,
					t_irna_perkembangan.HASIL_ASESMEN,t_irna_perkembangan.INTRUKSI_PPA,t_irna_perkembangan.VERIFIKASI_DPJP
					FROM t_irna_perkembangan
					LEFT JOIN m_pegawai ON (t_irna_perkembangan.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_irna_perkembangan.IRNA_ID = "' . $idx . '"
					ORDER BY t_irna_perkembangan.TANGGAL_PERIKSA';				
}

$get_catatan = mysql_query($qry_catatan) or die(mysql_error());
if(mysql_num_rows($get_catatan) > 0){
	$get_perkembangan = mysql_query($qry_perkembangan) or die(mysql_error());
	$dat_perkembangan = mysql_fetch_assoc($get_perkembangan);

	$nomr = $dat_perkembangan['NOMR'];
	$nama_pasien = $dat_perkembangan['NAMA_PASIEN'];
	$tgl_lahir = $dat_perkembangan['TGL_LAHIR'];
	$jns_kelamin = $dat_perkembangan['JNS_KELAMIN'];
	$unit_id = $dat_perkembangan['NAMA_UNIT'];
	$dokter = $dat_perkembangan['NAMA_PEGAWAI'];

	$edoc_norm = formatNoMR($nomr);
	$edoc_nama_pasien = $nama_pasien;
	$edoc_tanggal_lahir = changeDateFormat($tgl_lahir);
	$edoc_jenis_kelamin = jenisKelamin($jns_kelamin);
	$edoc_unit = $unit_id;
	$edoc_nama_documen = strtoupper($jenis_document);

	createFolder($nomr);
	$filename = $nomr . '_' . $perawatan . $idx . '_' . $id_document . '.pdf' ;

	$mpdf = new mPDF('utf-8', array($paper_width,$paper_height));
	$mpdf->autoPageBreak = false;
	$mpdf->SetHTMLHeader(setHeader($nomr,$nama_pasien));
	$mpdf->SetHTMLFooter(setFooter($jenis_document));

	$edoc_first = '<style>.tbl tr td {
	   border: 1px solid black;
	   padding-left:1px;
	   border-collapse: collapse;
	}</style>
	<table width="100%" class="tbl" cellpadding="0" cellspacing="0" autosize="1">
				  <tr>
					<td align="center" bgcolor="#CCCCCC" ><strong>No</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Tanggal & Pukul</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Profesional<br />Pemberi Asuhan</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Hasil Asesmen-IAR<br />Penatalaksana Pasien<br />(SOAP / ADIME)</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Intruksi PPA<br />Termasuk Pasca Bedah</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Verifikasi<br />DPJP</strong></td>
				  </tr>';
	$edoc_end = '</table>';

	$edoc_main = '';
	$x = 1;
	$y = 1;
	while($dat_catatan = mysql_fetch_array($get_catatan)){
		$edoc_main = $edoc_main . '<tr>
					<td align="center">' . $x . '</td>
					<td align="center">' . $dat_catatan['TANGGAL'] . '</td>
					<td>' . $dat_catatan['PEMBERI_ASUHAN'] . '</td>
					<td>' . $dat_catatan['HASIL_ASESMEN'] . '</td>
					<td>' . $dat_catatan['INTRUKSI_PPA'] . '</td>
					<td>' . $dat_catatan['VERIFIKASI_DPJP'] . '</td>
				  </tr>';
		if($x == 10){
			$edoc_content = $edoc_first . $edoc_main . $edoc_end;
			$edoc_main = '';
			ob_start();
			include('edoc_rekammedik/edoc_frame_main.php');
			$html = ob_get_contents();
			ob_end_clean();
			$mpdf->WriteHTML($html);
		}else if($x > 10){
			if($y == 12){
				$edoc_content_2 = $edoc_first . $edoc_main . $edoc_end;
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
		if($x > 10){
			$edoc_content_2 = $edoc_first . $edoc_main . $edoc_end;
			ob_start();
			include('edoc_rekammedik/edoc_frame_add.php');
			$html = ob_get_contents();
			ob_end_clean();
			$mpdf->AddPage('P'); 
			$mpdf->WriteHTML($html);
		}else{
			$edoc_content = $edoc_first . $edoc_main . $edoc_end;
			$edoc_main = '';
			ob_start();
			include('edoc_rekammedik/edoc_frame_main.php');
			$html = ob_get_contents();
			ob_end_clean();
			$mpdf->WriteHTML($html);
		}	
	}		  

	$mpdf->Output($rmfile_path . '/' . $nomr . '/' . $filename);	
	saveData($nomr,$idx,$jns_rawat,$id_document,$filename,$user_name,'','');
}
}
?>