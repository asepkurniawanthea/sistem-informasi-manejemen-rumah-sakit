<?php
function create_pdf_resep($idx,$perawatan){
global $rmfile_path;
global $user_name;	
global $edoc_logo;
global $paper_width;
global $paper_height;
$jenis_document = 'Resep';
$id_document = '12';	

if($perawatan == 'RJ'){
	$jns_rawat = '1';
	$qry_pasien = 'SELECT m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,t_irja.UNIT_ID,m_unit.NAMA_UNIT,
					m_pegawai.NAMA_PEGAWAI,"" AS JNS_ORDER, "" AS RAWAT_ID
					FROM t_irja
					INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
					INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
					LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_irja.IRJA_ID = "' . $idx . '"';
	$qry_resep = 'SELECT t_irja_resep.NO_RESEP,m_pegawai.NAMA_PEGAWAI,
					DATE_FORMAT(t_irja_resep.TGL_RESEP,"%d/%m/%Y") AS TGL_RESEP,
					t_irja_resep.RESEP,t_irja_resep.RACIKAN,t_irja_resep.GENERIK,
					t_irja_resep.DOSIS,t_irja_resep.JUMLAH,t_irja_resep.PSIKOTROPIKA,
					t_irja_resep.SATUAN,t_irja_resep.FORMULARIUM,
					t_irja_resep.FORMULARIUM_NASIONAL
					FROM t_irja_resep
					LEFT JOIN m_pegawai ON (t_irja_resep.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					WHERE IRJA_ID = "' . $idx . '" AND t_irja_resep.NO_RESEP IS NOT NULL
					AND t_irja_resep.RESEP IS NOT NULL
					ORDER BY t_irja_resep.NO_RESEP';	
}else if($perawatan == 'RI'){
	$jns_rawat = '2';
	$qry_pasien = 'SELECT m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,t_irna.RUANG_ID AS UNIT_ID,
					CONCAT(m_ruang.NAMA_RUANG," ",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,
					m_pegawai.NAMA_PEGAWAI,"" AS JNS_ORDER, "" AS RAWAT_ID
					FROM t_irna
					INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
					INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
					LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_irna.IRNA_ID = "' . $idx . '"';
	$qry_resep = 'SELECT t_irna_resep.NO_RESEP,m_pegawai.NAMA_PEGAWAI,
					DATE_FORMAT(t_irna_resep.TGL_RESEP,"%d/%m/%Y") AS TGL_RESEP,
					t_irna_resep.RESEP,t_irna_resep.RACIKAN,t_irna_resep.GENERIK,
					t_irna_resep.DOSIS,t_irna_resep.JUMLAH,t_irna_resep.PSIKOTROPIKA,
					t_irna_resep.SATUAN,t_irna_resep.FORMULARIUM,
					t_irna_resep.FORMULARIUM_NASIONAL
					FROM t_irna_resep
					LEFT JOIN m_pegawai ON (t_irna_resep.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					WHERE IRNA_ID = "' . $idx . '" AND t_irna_resep.NO_RESEP IS NOT NULL
					AND t_irna_resep.RESEP IS NOT NULL
					ORDER BY t_irna_resep.NO_RESEP';				
}

$get_resep = mysql_query($qry_resep) or die(mysql_error());
if(mysql_num_rows($get_resep) > 0){
	$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
	$dat_pasien = mysql_fetch_assoc($get_pasien);

	$nomr = $dat_pasien['NOMR'];
	$nama_pasien = $dat_pasien['NAMA_PASIEN'];
	$tgl_lahir = $dat_pasien['TGL_LAHIR'];
	$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
	$unit_id = $dat_pasien['NAMA_UNIT'];
	$dokter = $dat_pasien['NAMA_PEGAWAI'];

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
	<table width="100%" class="tbl" cellpadding="0" cellspacing="0" autosize="1" >
				  <tr>
					<td align="center" bgcolor="#CCCCCC" ><strong>No</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Tanggal</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Pengirim</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Nama Obat</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Aturan Pakai</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Jumlah</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Satuan</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Racikan</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Generik</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Psikotropika</strong></td>
				</tr>';
	$edoc_end = '</table>';

	$edoc_main = '';
	$x = 1;
	$y = 1;
	$tgl_resep = '';
	$pengirim = '';
	while($dat_resep = mysql_fetch_array($get_resep)){
		$tgl = '';
		$pgr = '';
		if($dat_resep['TGL_RESEP'] != $tgl_resep){
			$tgl = $dat_resep['TGL_RESEP'];
			$tgl_resep = $dat_resep['TGL_RESEP'];
		}
		
		if($dat_resep['NAMA_PEGAWAI'] != $pengirim){
			$pgr = $dat_resep['NAMA_PEGAWAI'];
			$pengirim = $dat_resep['NAMA_PEGAWAI'];
		}
		
		$edoc_main = $edoc_main . '<tr>
					<td align="center">' . $x . '</td>
					<td>' . $tgl . '</td>
					<td>' . $pgr . '</td>
					<td>' . $dat_resep['RESEP'] . '</td>
					<td>' . $dat_resep['DOSIS'] . '</td>
					<td>' . $dat_resep['JUMLAH'] . '</td>
					<td>' . $dat_resep['SATUAN'] . '</td>
					<td>' . (($dat_resep['RACIKAN'] == '1') ? '&radic;' : '') . '</td>
					<td>' . (($dat_resep['GENERIK'] == '1') ? '&radic;' : '') . '</td>
					<td>' . (($dat_resep['PSIKOTROPIKA'] == '1') ? '&radic;' : '') . '</td>
				  </tr>';
		if($x == 20){
			$edoc_content = $edoc_first . $edoc_main . $edoc_end;
			$edoc_main = '';
			ob_start();
			include('edoc_rekammedik/edoc_frame_main.php');
			$html = ob_get_contents();
			ob_end_clean();
			$mpdf->WriteHTML($html);
		}else if($x > 20){
			if($y == 25){
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
		if($x > 20){
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