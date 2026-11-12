<?php
function create_pdf_laboratorium($idx,$perawatan,$no_order,$fr){
global $rmfile_path;
global $user_name;
global $edoc_logo;
global $paper_width;
global $paper_height;
$jenis_document = 'Laboratorium';
$id_document = '5';		

if($perawatan == 'irj') {
	$perawatan_h = 'RJ';
	$jns_rawat = '1';
	$qry_laboratorium = 'SELECT DISTINCT m_tarif_pemeriksaan.CH_REPORT,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d/%m/%Y %H:%i") AS TANGGAL_SAMPLING,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i") AS TANGGAL_PERIKSA,
				t_ipenunjang_tarif.CATATAN_SPESIMEN,
				m_pegawai.NAMA_PEGAWAI AS PEGAWAI_PERIKSA_ID,
				m_pegawai2.NAMA_PEGAWAI AS PEGAWAI_DIAGNOSA_ID,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d/%m/%Y") AS TANGGAL_JAM_SAMPLING,
				m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,
				m_unit.NAMA_UNIT,t_ipenunjang.RAWAT_ID
				FROM t_ipenunjang
				INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai2.PEGAWAI_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND t_ipenunjang_tarif.NO_TARIF = "' . $no_order . '"		
				AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
				OR m_tarif.UNIT_ID = "45")
				AND m_tarif_pemeriksaan.FORM_HASIL = "' . $fr . '"
				ORDER BY m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID';
}else if($perawatan == 'irn') {
	$perawatan_h = 'RI';
	$jns_rawat = '2';
	$qry_laboratorium = 'SELECT DISTINCT m_tarif_pemeriksaan.CH_REPORT,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d/%m/%Y %H:%i") AS TANGGAL_SAMPLING,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y  %H:%i") AS TANGGAL_PERIKSA,
				t_ipenunjang_tarif.CATATAN_SPESIMEN,
				m_pegawai.NAMA_PEGAWAI AS PEGAWAI_PERIKSA_ID,
				m_pegawai2.NAMA_PEGAWAI AS PEGAWAI_DIAGNOSA_ID,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d/%m/%Y") AS TANGGAL_JAM_SAMPLING,
				m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,
				CONCAT(m_ruang.NAMA_RUANG," ",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,t_ipenunjang.RAWAT_ID
				FROM t_ipenunjang
				INNER JOIN t_irna ON (t_ipenunjang.RAWAT_ID = t_irna.IRNA_ID)
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai2.PEGAWAI_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND t_ipenunjang_tarif.NO_TARIF = "' . $no_order . '"		
				AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
				OR m_tarif.UNIT_ID = "45")
				AND m_tarif_pemeriksaan.FORM_HASIL = "' . $fr . '"
				ORDER BY m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID';
}else if($perawatan == 'hrj') {
	$perawatan_h = 'RJ';
	$jns_rawat = '1';
	$qry_laboratorium = 'SELECT DISTINCT m_tarif_pemeriksaan.CH_REPORT,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d/%m/%Y %H:%i") AS TANGGAL_SAMPLING,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i") AS TANGGAL_PERIKSA,
				t_ipenunjang_tarif.CATATAN_SPESIMEN,
				m_pegawai.NAMA_PEGAWAI AS PEGAWAI_PERIKSA_ID,
				m_pegawai2.NAMA_PEGAWAI AS PEGAWAI_DIAGNOSA_ID,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d/%m/%Y") AS TANGGAL_JAM_SAMPLING,
				m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,
				CONCAT(m_unit.NAMA_UNIT,"-Hemodialisa") AS NAMA_UNIT,t_ipenunjang.RAWAT_ID
				FROM t_ipenunjang
				INNER JOIN t_hemodialisa ON (t_ipenunjang.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
				INNER JOIN t_irja ON (t_hemodialisa.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai2.PEGAWAI_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND t_ipenunjang_tarif.NO_TARIF = "' . $no_order . '"		
				AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
				OR m_tarif.UNIT_ID = "45")
				AND m_tarif_pemeriksaan.FORM_HASIL = "' . $fr . '"
				ORDER BY m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID';
}else if($perawatan == 'hri') {
	$perawatan_h = 'RI';
	$jns_rawat = '2';
	$qry_laboratorium = 'SELECT DISTINCT m_tarif_pemeriksaan.CH_REPORT,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d/%m/%Y %H:%i") AS TANGGAL_SAMPLING,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i") AS TANGGAL_PERIKSA,
				t_ipenunjang_tarif.CATATAN_SPESIMEN,
				m_pegawai.NAMA_PEGAWAI AS PEGAWAI_PERIKSA_ID,
				m_pegawai2.NAMA_PEGAWAI AS PEGAWAI_DIAGNOSA_ID,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d/%m/%Y") AS TANGGAL_JAM_SAMPLING,
				m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,
				CONCAT(m_ruang.NAMA_RUANG," ",m_ruang.KELAS_RAWAT,"-Hemodialisa") AS NAMA_UNIT,t_ipenunjang.RAWAT_ID
				FROM t_ipenunjang
				INNER JOIN t_hemodialisa ON (t_ipenunjang.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
				INNER JOIN t_irna ON (t_hemodialisa.RAWAT_ID = t_irna.IRNA_ID)
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai2.PEGAWAI_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND t_ipenunjang_tarif.NO_TARIF = "' . $no_order . '"		
				AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
				OR m_tarif.UNIT_ID = "45")
				AND m_tarif_pemeriksaan.FORM_HASIL = "' . $fr . '"
				ORDER BY m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID';
} else if($perawatan == 'orj') {	
	$perawatan_h = 'RJ';
	$jns_rawat = '1';
	$qry_laboratorium = 'SELECT DISTINCT m_tarif_pemeriksaan.CH_REPORT,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d/%m/%Y %H:%i") AS TANGGAL_SAMPLING,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i") AS TANGGAL_PERIKSA,
				t_ipenunjang_tarif.CATATAN_SPESIMEN,
				m_pegawai.NAMA_PEGAWAI AS PEGAWAI_PERIKSA_ID,
				m_pegawai2.NAMA_PEGAWAI AS PEGAWAI_DIAGNOSA_ID,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d/%m/%Y") AS TANGGAL_JAM_SAMPLING,
				m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,
				CONCAT(m_unit.NAMA_UNIT,"-Kamar Operasi") AS NAMA_UNIT,t_ipenunjang.RAWAT_ID
				FROM t_ipenunjang
				INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai2.PEGAWAI_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND t_ipenunjang_tarif.NO_TARIF = "' . $no_order . '"		
				AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
				OR m_tarif.UNIT_ID = "45")
				AND m_tarif_pemeriksaan.FORM_HASIL = "' . $fr . '"
				ORDER BY m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID';		
} else if($perawatan == 'ori') {	
	$perawatan_h = 'RI';
	$jns_rawat = '2';
	$qry_laboratorium = 'SELECT DISTINCT m_tarif_pemeriksaan.CH_REPORT,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d/%m/%Y %H:%i") AS TANGGAL_SAMPLING,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y  %H:%i") AS TANGGAL_PERIKSA,
				t_ipenunjang_tarif.CATATAN_SPESIMEN,
				m_pegawai.NAMA_PEGAWAI AS PEGAWAI_PERIKSA_ID,
				m_pegawai2.NAMA_PEGAWAI AS PEGAWAI_DIAGNOSA_ID,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d/%m/%Y") AS TANGGAL_JAM_SAMPLING,
				m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,
				CONCAT(m_ruang.NAMA_RUANG," ",m_ruang.KELAS_RAWAT,"-Kamar Operasi") AS NAMA_UNIT,t_ipenunjang.RAWAT_ID
				FROM t_ipenunjang
				INNER JOIN t_irna ON (t_ipenunjang.RAWAT_ID = t_irna.IRNA_ID)
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai2.PEGAWAI_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND t_ipenunjang_tarif.NO_TARIF = "' . $no_order . '"		
				AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
				OR m_tarif.UNIT_ID = "45")
				AND m_tarif_pemeriksaan.FORM_HASIL = "' . $fr . '"
				ORDER BY m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID';			
}	


$mpdf = new mPDF('utf-8', array($paper_width,$paper_height));

$i = 1;
$x = 1;
$r = 1;
$s = 1;
$edoc_main = '';
$get_laboratorium = mysql_query($qry_laboratorium) or die(mysql_error());
while ($dat_laboratorium = mysql_fetch_array($get_laboratorium)){
	
	$nomr = $dat_laboratorium['NOMR'];
	$nama_pasien = $dat_laboratorium['NAMA_PASIEN'];
	$tgl_lahir = $dat_laboratorium['TGL_LAHIR'];
	$jns_kelamin = $dat_laboratorium['JNS_KELAMIN'];
	$nama_unit = $dat_laboratorium['NAMA_UNIT'];

	$tgl_sampling = $dat_laboratorium['TANGGAL_SAMPLING'];
	$tgl_hasil = $dat_laboratorium['TANGGAL_PERIKSA'];
	$catatan_spesimen = $dat_laboratorium['CATATAN_SPESIMEN'];
	$pemeriksa = $dat_laboratorium['PEGAWAI_PERIKSA_ID'];
	$dokter = $dat_laboratorium['PEGAWAI_DIAGNOSA_ID'];
	
	$edoc_norm = formatNoMR($nomr);
	$edoc_nama_pasien = $nama_pasien;
	$edoc_tanggal_lahir = changeDateFormat($tgl_lahir);
	$edoc_jenis_kelamin = jenisKelamin($jns_kelamin);
	$edoc_unit = $nama_unit;
	$edoc_nama_documen = strtoupper($jenis_document);

	$edoc_top = '<style>.tbl tr td {
			   border: 1px solid black;
			   padding-left:1px;
			   padding-bottom:1px;
			   border-collapse: collapse;
			}</style>
			<style>.tbc tr td {
			   border: none;
			   padding-left:1px;
			   padding-bottom:1px;
			   border-collapse: collapse;
			}</style>
			<table border="0" width="100%" cellpadding="0" cellspacing="0" class="tbc" autosize="1" >
			<tr>
				<td width="200">Tanggal Terima Sample</td>
				<td>:&nbsp;' . $tgl_sampling . '</td>
				<td width="120">Tanggal Hasil</td>
				<td>:&nbsp;' . $tgl_hasil . '</td>
			</tr>
			<tr>
				<td>Dokter Penanggungjawab</td>
				<td>:&nbsp;' . $dokter . '</td>
				<td>Pemeriksa</td>
				<td>:&nbsp;' . $pemeriksa . '</td>
			</tr>
			</table>';
	$edoc_header = '<table border="0" width="100%" cellpadding="0" cellspacing="0" class="tbl" autosize="1" >
			<tr>';
	if($fr == '1'){
		$edoc_header = $edoc_header . '<td align="center" bgcolor="#CCCCCC" width="25"><strong>No</strong></td>
				<td colspan="3" align="center" bgcolor="#CCCCCC" ><strong>Jenis Pemeriksaan</strong></td>
				<td align="center" bgcolor="#CCCCCC" ><strong>Hasil</strong></td>
				<td align="center" bgcolor="#CCCCCC" ><strong>Satuan</strong></td>
				<td align="center" bgcolor="#CCCCCC" ><strong>Nilai Rujukan</strong></td>
				<td align="center" bgcolor="#CCCCCC" ><strong>Metode</strong></td>
				</tr>';
	}else if($fr == '2'){
		$edoc_header = $edoc_header . '<td align="center" bgcolor="#CCCCCC" ><strong>No</strong></td>
				<td colspan="3" align="center" bgcolor="#CCCCCC" ><strong>Jenis Pemeriksaan</strong></td>
				<td align="center" bgcolor="#CCCCCC" ><strong>Hasil</strong></td>
				<td align="center" bgcolor="#CCCCCC" ><strong>Nilai Rujukan</strong></td>
				<td align="center" bgcolor="#CCCCCC" ><strong>Metode</strong></td>
				</tr>';
	}else if($fr == '3'){
		$edoc_header = $edoc_header . '<td align="center" bgcolor="#CCCCCC" ><strong>No</strong></td>
				<td colspan="3" align="center" bgcolor="#CCCCCC" ><strong>Jenis Pemeriksaan</strong></td>
				<td align="center" bgcolor="#CCCCCC" ><strong>Hasil</strong></td>
				<td align="center" bgcolor="#CCCCCC" ><strong>Metode</strong></td>
				</tr>';			
	}
	
	$edoc_main 	= $edoc_main . '<tr>';
	if($fr == '1'){ 
		$edoc_main 	= $edoc_main . '<td width="20" align="center">' . $i . '</td>
			<td colspan="7"><strong>' . strtoupper($dat_laboratorium['CH_REPORT']) . '</strong></td>';
	}else if($fr == '2'){ 
		$edoc_main 	= $edoc_main . '<td width="20" align="center">' . $i . '</td>
			<td colspan="6"><strong>' . strtoupper($dat_laboratorium['CH_REPORT']) . '</strong></td>';
	 }else if($fr == '3'){ 
		$edoc_main 	= $edoc_main . '<td width="20" align="center">' . $i . '</td>
			<td colspan="5"><strong>';
			if(strtoupper($dat_laboratorium['CH_REPORT']) != 'GAMBARAN DARAH TEPI') { 
				$edoc_main 	= $edoc_main . strtoupper($dat_laboratorium['CH_REPORT']); 
			}else{ 
				$edoc_main 	= $edoc_main . 'HEMATOLOGI'; 
			} 
		$edoc_main 	= $edoc_main . '</strong></td>';
	} 
	$edoc_main 	= $edoc_main . '</tr>';	
	
	/*if($dat_laboratorium['CH_REPORT'] == 'Mikrobiologi'){
		$edoc_main 	= $edoc_main . '<tr>
			<td>&nbsp;</td>
			<td colspan="6"><strong>BAHAN&nbsp;&nbsp;&nbsp;:</strong></td>
			</tr>';
	}*/
	
	$qry_hasil = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID,m_tarif_pemeriksaan.CH_LEVEL,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_GROUP,m_tarif_pemeriksaan.NAMA_PEMERIKSAAN,m_tarif_pemeriksaan.REPORT_FORMAT,
				m_tarif_pemeriksaan.REPORT_ORDER,t_ipenunjang_tarif_pemeriksaan.SATUAN,t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN,
				t_ipenunjang_tarif_pemeriksaan.METHODE,t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN_ID,
				t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID,t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,
				m_tarif_pemeriksaan.CH_REPORT,m_tarif_pemeriksaan.TEXT_HASIL
				FROM t_ipenunjang_tarif
				INNER JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN t_ipenunjang_tarif_pemeriksaan ON (m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID = t_ipenunjang_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID 
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID = 
				t_ipenunjang_tarif.PENUNJANG_TARIF_ID)
				LEFT JOIN m_nilai_rujukan_laboratorium ON (t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN_ID = m_nilai_rujukan_laboratorium.NILAI_RUJUKAN_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" 
				AND t_ipenunjang.JNS_ORDER = "' . strtoupper($perawatan) . '"	
				AND t_ipenunjang_tarif.NO_TARIF = "' . $no_order . '"
				AND m_tarif_pemeriksaan.CH_REPORT = "' . $dat_laboratorium['CH_REPORT'] . '"
				AND m_tarif_pemeriksaan.FORM_HASIL = "' . $fr . '"
				ORDER BY m_tarif_pemeriksaan.REPORT_ORDER';
	$get_hasil = mysql_query($qry_hasil) or die(mysql_error());
	$z = 1;
    $nama_pemeriksaan_group = '';
    $ret_selesai = true;
		
	while ($dat_hasil = mysql_fetch_array($get_hasil)) {
		ob_start();
		if($fr == '1') {
				include('edoc_rekammedik/edoc_form_laboratorium_1.php');       
		}else if($fr == '2') {
                include('edoc_rekammedik/edoc_form_laboratorium_2.php');
        }else if($fr == '3') {
                include('edoc_rekammedik/edoc_form_laboratorium_3.php');
        }
		$edoc_hasil = ob_get_contents();
		ob_end_clean();
		
		$edoc_main 	= $edoc_main . $edoc_hasil;
		
		if($r == 20){
			$edoc_content = $edoc_top . $edoc_header . $edoc_main . '</table>';
			$edoc_main = '';
			ob_start();
			include('edoc_rekammedik/edoc_frame_main.php');
			$html = ob_get_contents();
			ob_end_clean();
			$mpdf->WriteHTML($html);
		}else if($r > 20){
			if($s == 25){
				$edoc_content_2 = $edoc_header . $edoc_main . '</table>';
				$edoc_main = '';
				$s = 0;
				ob_start();
				include('edoc_rekammedik/edoc_frame_add.php');
				$html = ob_get_contents();
				ob_end_clean();
				$mpdf->AddPage('P'); 
				$mpdf->WriteHTML($html);
			}
			$s++;
		}
			
	$z++;
	$r++;
    }		
$i++; 
	
}

if($edoc_main != ''){
	if($r > 20){
		$edoc_content_2 = $edoc_header . $edoc_main . '</table>';
		ob_start();
		include('edoc_rekammedik/edoc_frame_add.php');
		$html = ob_get_contents();
		ob_end_clean();
		$mpdf->AddPage('P'); 
		$mpdf->WriteHTML($html);
	}else{
		$edoc_content = $edoc_top . $edoc_header . $edoc_main . '</table>';
		ob_start();
		include('edoc_rekammedik/edoc_frame_main.php');
		$html = ob_get_contents();
		ob_end_clean();
		$mpdf->WriteHTML($html);
	}	
}

$html = '<table border="0" width="100%" cellpadding="0" cellspacing="0" class="tbc" autosize="1" >
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="120">Catatan</td>
				<td>:&nbsp;' . $catatan_spesimen . '</td>
			</tr>
			</table>';
$mpdf->WriteHTML($html);		

createFolder($nomr);
$filename = $nomr . '_' . $perawatan_h . $idx . '_' . $id_document . '_' . $no_order.$fr . '.pdf' ;

$mpdf->autoPageBreak = false;
$mpdf->SetHTMLHeader(setHeader($nomr,$nama_pasien));
$mpdf->SetHTMLFooter(setFooter($jenis_document));
$mpdf->Output($rmfile_path . '/' . $nomr . '/' . $filename);	

saveData($nomr,$idx,$jns_rawat,$id_document,$filename,$user_name,$no_order.$fr,'');
}
?>