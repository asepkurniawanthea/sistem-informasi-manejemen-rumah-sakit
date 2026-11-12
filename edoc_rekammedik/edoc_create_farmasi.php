<?php
function create_pdf_farmasi($idx,$perawatan){
global $rmfile_path;
global $user_name;	
global $edoc_logo;
global $paper_width;
global $paper_height;

global $hostname_3;
global $database_3;
global $username_3;
global $password_3; 

global $hostname;
global $database;
global $username;
global $password; 

$jenis_document = 'Farmasi';
$id_document = '15';	

if($perawatan == 'RJ'){
	$jns_rawat = '1';
	$qry_pasien = 'SELECT m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,t_irja.UNIT_ID,m_unit.NAMA_UNIT,
					m_pegawai.NAMA_PEGAWAI,"" AS JNS_ORDER, "" AS RAWAT_ID
					FROM t_irja
					INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
					INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
					LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_irja.IRJA_ID = "' . $idx . '"';
	$qry_resep = 'SELECT DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") AS TANGGAL_KELUAR,
					m_persediaan_farmasi.NAMA_PERSEDIAAN,SUM(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) AS JUMLAH_KELUAR,
					m_persediaan_farmasi.SATUAN,CASE WHEN m_persediaan_farmasi.ALKES = "1" THEN "&radic;" END AS ALKES,
					t_rajal_resep_detail.RACIKAN,t_rajal_resep_detail.NAMA_RACIKAN,
					t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
					CASE WHEN t_rajal_resep_detail.GENERIK = "1" THEN "&radic;" END AS GENERIK,
					t_farmasi_apotik_pengeluaran.NO_PENGELUARAN
					FROM t_rajal_resep 
					INNER JOIN t_rajal_resep_detail ON (t_rajal_resep.RAJAL_RESEP_ID = t_rajal_resep_detail.RAJAL_RESEP_ID)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_rajal_resep_detail.RAJAL_RESEP_DETAIL_ID = t_farmasi_apotik_pengeluaran_detail.RAJAL_RESEP_DETAIL_ID)
					INNER JOIN t_farmasi_apotik_pengeluaran ON (t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID = t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					INNER JOIN m_persediaan_group ON (m_persediaan_farmasi.PERSEDIAAN_GROUP_ID = m_persediaan_group.PERSEDIAAN_GROUP_ID)
					WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '" AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_rajal_resep.HEMODIALISA_ID IS NULL	
					AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
					GROUP BY DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),
					m_persediaan_farmasi.NAMA_PERSEDIAAN,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN
                    ORDER BY t_farmasi_apotik_pengeluaran.NO_PENGELUARAN';	
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
	$qry_resep = 'SELECT DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") AS TANGGAL_KELUAR,
					m_persediaan_farmasi.NAMA_PERSEDIAAN,SUM(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) AS JUMLAH_KELUAR,
					m_persediaan_farmasi.SATUAN,CASE WHEN m_persediaan_farmasi.ALKES = "1" THEN "&radic;" END AS ALKES,
					t_ranap_resep_detail.RACIKAN,t_ranap_resep_detail.NAMA_RACIKAN,
					t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
					CASE WHEN t_ranap_resep_detail.GENERIK = "1" THEN "&radic;" END AS GENERIK,
					t_farmasi_apotik_pengeluaran.NO_PENGELUARAN
					FROM t_ranap_resep 
					INNER JOIN t_ranap_resep_detail ON (t_ranap_resep.RANAP_RESEP_ID = t_ranap_resep_detail.RANAP_RESEP_ID)
					INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_ranap_resep_detail.RANAP_RESEP_DETAIL_ID = t_farmasi_apotik_pengeluaran_detail.RANAP_RESEP_DETAIL_ID)
					INNER JOIN t_farmasi_apotik_pengeluaran ON (t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID = t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID)
					INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
					INNER JOIN m_persediaan_group ON (m_persediaan_farmasi.PERSEDIAAN_GROUP_ID = m_persediaan_group.PERSEDIAAN_GROUP_ID)
					WHERE t_ranap_resep.RANAP_ID = "' . $idx . '" AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_ranap_resep.HEMODIALISA_ID IS NULL	
					AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
					GROUP BY DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),
					m_persediaan_farmasi.NAMA_PERSEDIAAN,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN
                    ORDER BY t_farmasi_apotik_pengeluaran.NO_PENGELUARAN';				
}

$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());

$get_resep = mysql_query($qry_resep) or die(mysql_error());
if(mysql_num_rows($get_resep) > 0){
	$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
	mysql_select_db($database, $connect) or die(mysql_error());
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
	<table width="100%" class="tbl" cellpadding="0" cellspacing="0" autosize="1">
				  <tr>
					<td align="center" bgcolor="#CCCCCC" ><strong>No</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Tanggal</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Nama Obat/ BHP</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Jumlah</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Satuan</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Alkes</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Racikan</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Generik</strong></td>
				</tr>';
	$edoc_end = '</table>';

	$edoc_main = '';
	$x = 1;
	$y = 1;
	$tgl_resep = '';
	while($dat_resep = mysql_fetch_array($get_resep)){
		$tgl = '';
		if($dat_resep['TANGGAL_KELUAR'] != $tgl_resep){
			$tgl = $dat_resep['TANGGAL_KELUAR'];
			$tgl_resep = $dat_resep['TANGGAL_KELUAR'];
		}
		
		$edoc_main = $edoc_main . '<tr>
					<td align="center">' . $x . '</td>
					<td>' . $tgl . '</td>
					<td>' . $dat_resep['NAMA_PERSEDIAAN'] . '</td>
					<td>' . $dat_resep['JUMLAH_KELUAR'] . '</td>
					<td>' . $dat_resep['SATUAN'] . '</td>
					<td>' . $dat_resep['ALKES'] . '</td>
					<td>' . (($dat_resep['RACIKAN'] == '1') ? $dat_resep['NAMA_RACIKAN'] : '') . '</td>
					<td>' . $dat_resep['GENERIK'] . '</td>
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