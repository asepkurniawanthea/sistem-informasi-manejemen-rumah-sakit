<?php
function create_pdf_hemodialisa($idx){
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

$id_document = '4';	

$qry_hemodialisa = 'SELECT m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,m_unit.NAMA_UNIT,
					CONCAT(m_ruang.NAMA_RUANG,"/",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,
					t_hemodialisa.JNS_ORDER,t_hemodialisa.RAWAT_ID
					FROM t_hemodialisa
					INNER JOIN m_pasien ON (t_hemodialisa.NOMR = m_pasien.NOMR)
					LEFT JOIN m_unit ON (t_hemodialisa.UNIT_ID = m_unit.UNIT_ID)
					LEFT JOIN m_ruang ON (t_hemodialisa.RUANG_ID = m_ruang.RUANG_ID)
					WHERE t_hemodialisa.HEMODIALISA_ID = "' . $idx . '"';
$get_hemodialisa = mysql_query($qry_hemodialisa) or die(mysql_error());
$dat_hemodialisa = mysql_fetch_assoc($get_hemodialisa);

$nomr = $dat_hemodialisa['NOMR'];
$nama_pasien = $dat_hemodialisa['NAMA_PASIEN'];
$tgl_lahir = $dat_hemodialisa['TGL_LAHIR'];
$jns_kelamin = $dat_hemodialisa['JNS_KELAMIN'];
$nama_unit = $dat_hemodialisa['NAMA_UNIT'];
$nama_ruang = $dat_hemodialisa['NAMA_RUANG'];
$rawat_id = $dat_hemodialisa['RAWAT_ID'];
$jns_order = $dat_hemodialisa['JNS_ORDER'];

$edoc_norm = formatNoMR($nomr);
$edoc_nama_pasien = $nama_pasien;
$edoc_tanggal_lahir = changeDateFormat($tgl_lahir);
$edoc_jenis_kelamin = jenisKelamin($jns_kelamin);
$edoc_unit = $nama_unit . '-Hemodialisa';
$jns_rawat = '1';
$perawatan = 'RJ';
$penunjang = 'HRJ';
if($jns_order == 'IRN'){
	$edoc_unit = $nama_ruang . '-Hemodialisa';
	$jns_rawat = '2';
	$perawatan = 'RI';
	$penunjang = 'HRI';
}	

createFolder($nomr);
$filename = $nomr . '_' . $perawatan . $rawat_id . '_' . $id_document . '_' . $idx . '.pdf' ;

$mpdf = new mPDF('utf-8', array($paper_width,$paper_height));
$mpdf->autoPageBreak = false;
$mpdf->SetHTMLHeader(setHeader($nomr,$nama_pasien));
$mpdf->SetHTMLFooter(setFooter('Hemodialisa'));

//Pengkajian Awal Medis
$edoc_nama_documen = strtoupper('Pengkajian Awal Medis');


$qry_pengkajian = 'SELECT t_hemodialisa.ANAMNESIS,t_hemodialisa.PEMERIKSAAN_FISIK,t_hemodialisa.PEMERIKSAAN_PENUNJANG,t_hemodialisa.STATUS_LOKALIS,
					m_pegawai.NAMA_PEGAWAI
					FROM t_hemodialisa
					LEFT JOIN m_pegawai ON (t_hemodialisa.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_hemodialisa.HEMODIALISA_ID = "' . $idx . '"';
$qry_alergi = 'SELECT t_hemodialisa_alergi.ALERGI,t_hemodialisa_alergi.HEMODIALISA_ID
					FROM t_hemodialisa_alergi
					WHERE t_hemodialisa_alergi.HEMODIALISA_ID = "' . $idx . '"';				
$qry_diagnosa = 'SELECT t_hemodialisa_diagnosa.DIAGNOSA,t_hemodialisa_diagnosa.ICD_CODE,t_hemodialisa_diagnosa.DIAGNOSA_ORDER
					FROM t_hemodialisa_diagnosa
					WHERE t_hemodialisa_diagnosa.HEMODIALISA_ID = "' . $idx . '"
					AND t_hemodialisa_diagnosa.DIAGNOSA_ORDER = 0
					ORDER BY t_hemodialisa_diagnosa.DIAGNOSA_ORDER';	
$qry_diagnosa_sk = 'SELECT t_hemodialisa_diagnosa.DIAGNOSA,t_hemodialisa_diagnosa.ICD_CODE,t_hemodialisa_diagnosa.DIAGNOSA_ORDER
					FROM t_hemodialisa_diagnosa
					WHERE t_hemodialisa_diagnosa.HEMODIALISA_ID = "' . $idx . '"
					AND t_hemodialisa_diagnosa.DIAGNOSA_ORDER > 0
					ORDER BY t_hemodialisa_diagnosa.DIAGNOSA_ORDER';						
$qry_tindakan = 'SELECT m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,
					m_tarif.SATUAN,SUM(t_hemodialisa_tarif.KUANTITI) AS KUANTITI,t_hemodialisa_tarif.ICD_CODE
					FROM t_hemodialisa_tarif
					INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE t_hemodialisa_tarif.HEMODIALISA_ID = "' . $idx . '" 
					AND m_tarif_group.KODE_TARIF_GROUP <> "01" 
					AND m_tarif_group.KODE_TARIF_GROUP <> "02" AND m_tarif_group.KODE_TARIF_GROUP <> "09" 
					AND m_tarif_group.KODE_TARIF_GROUP <> "49" AND m_tarif_group.KODE_TARIF_GROUP <> "50"
					AND m_tarif_group.KODE_TARIF_GROUP <> "51" AND m_tarif_group.KODE_TARIF_GROUP <> "52"
					AND m_tarif_group.KODE_TARIF_GROUP <> "92" AND m_tarif_group.KODE_TARIF_GROUP <> "93"
					AND m_tarif_group.KODE_TARIF_GROUP <> "102" AND m_tarif_group.KODE_TARIF_GROUP <> "103"
					AND m_tarif_group.KODE_TARIF_GROUP <> "104" AND m_tarif_group.KODE_TARIF_GROUP <> "105"
					AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL 
					AND (t_hemodialisa_tarif.ST_BAYAR IS NULL OR t_hemodialisa_tarif.ST_BAYAR = "Lunas")
					GROUP BY m_tarif.KODE_TARIF';
$qry_penunjang = 'SELECT m_tarif.KODE_TARIF,
					CASE WHEN m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
							OR m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
							THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF,
					m_tarif_group.NAMA_TARIF_GROUP,m_tarif.SATUAN,SUM(t_ipenunjang_tarif.KUANTITI) AS KUANTITI,
					t_ipenunjang_tarif.ICD_CODE 
					FROM t_ipenunjang 
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
					WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
					AND t_ipenunjang.JNS_ORDER = "' . $penunjang . '"	
					AND m_tarif_group.KODE_TARIF_GROUP <> "01" 
					AND m_tarif_group.KODE_TARIF_GROUP <> "02" AND m_tarif_group.KODE_TARIF_GROUP <> "09" 
					AND m_tarif_group.KODE_TARIF_GROUP <> "49" AND m_tarif_group.KODE_TARIF_GROUP <> "50"
					AND m_tarif_group.KODE_TARIF_GROUP <> "51" AND m_tarif_group.KODE_TARIF_GROUP <> "52"
					AND m_tarif_group.KODE_TARIF_GROUP <> "92" AND m_tarif_group.KODE_TARIF_GROUP <> "93"
					AND m_tarif_group.KODE_TARIF_GROUP <> "102" AND m_tarif_group.KODE_TARIF_GROUP <> "103"
					AND m_tarif_group.KODE_TARIF_GROUP <> "104" AND m_tarif_group.KODE_TARIF_GROUP <> "105"
					AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
					AND (t_ipenunjang_tarif.ST_BAYAR IS NULL OR t_ipenunjang_tarif.ST_BAYAR = "Lunas")  
					AND t_ipenunjang_tarif.ST_BATAL IS NULL
					GROUP BY m_tarif.KODE_TARIF';						

$get_pengkajian = mysql_query($qry_pengkajian) or die(mysql_error());
$dat_pengkajian = mysql_fetch_assoc($get_pengkajian);

$anamnesis = $dat_pengkajian['ANAMNESIS'];
$pemeriksaan_fisik = $dat_pengkajian['PEMERIKSAAN_FISIK'];
$pemeriksaan_penunjang = $dat_pengkajian['PEMERIKSAAN_PENUNJANG'];
$status_lokalis = $dat_pengkajian['STATUS_LOKALIS'];
$dokter = $dat_pengkajian['NAMA_PEGAWAI'];

$p_anamnesis[1] = '';
$p_anamnesis[2] = '';
$p_anamnesis[3] = '';
$p_anamnesis[4] = '';
$p_anamnesis_array = explode('|*|',$anamnesis);
$anam_count = sizeof($p_anamnesis_array); 
if($anam_count >= 4){
	$x = 1;
	while($x <= 4){
		$p_anamnesis[$x] = $p_anamnesis_array[$x - 1]; 	
	$x++;
	}
}

$p_fisik[1] = '';	
$p_fisik[2] = '';	
$p_fisik[3] = '';	
$p_fisik[4] = '';	
$p_fisik[5] = '';	
$p_fisik[6] = '';	
$p_fisik[7] = '';
$p_fisik[8] = '';
$p_fisik[9] = '';
$p_fisik[10] = '';

$p_fisik[11] = '';
$p_fisik[12] = '';
$p_fisik[13] = '';
$p_fisik[14] = '';
$p_fisik[15] = '';
$p_fisik[16] = '';
$p_fisik[17] = '';
$p_fisik[18] = '';
$p_fisik[19] = '';
$p_fisik[20] = '';

$p_fisik[21] = '';	
$p_fisik[22] = '';	
$p_fisik[23] = '';	
$p_fisik[24] = '';	
$p_fisik[25] = '';	
$p_fisik[26] = '';	
$p_fisik[27] = '';
$p_fisik[28] = '';
$p_fisik[29] = '';
$p_fisik[30] = '';

$p_fisik[31] = '';	
$p_fisik[32] = '';	
$p_fisik[33] = '';	
$p_fisik[34] = '';	
$p_fisik[35] = '';	
$p_fisik[36] = '';	
$p_fisik[37] = '';
$p_fisik[38] = '';
$p_fisik[39] = '';
$p_fisik[40] = '';

$p_fisik[41] = '';	
$p_fisik[42] = '';	
$p_fisik[43] = '';	
$p_fisik[44] = '';	
$p_fisik[45] = '';	
$p_fisik[46] = '';	
$p_fisik[47] = '';
$p_fisik[48] = '';
$p_fisik[49] = '';
$p_fisik[50] = '';

$p_fisik[51] = '';	
$p_fisik[52] = '';	
$p_fisik[53] = '';	
$p_fisik[54] = '';	
$p_fisik[55] = '';	
$p_fisik[56] = '';	
$p_fisik[57] = '';
$p_fisik[58] = '';
$p_fisik[59] = '';
$p_fisik[60] = '';

$p_fisik[61] = '';	
$p_fisik[62] = '';

$p_fisik_array = explode('|*|',$pemeriksaan_fisik); 
$fisik_count = sizeof($p_fisik_array); 

if($fisik_count >= 62){
	$x = 1;
	while($x <= 62){
		$p_fisik[$x] = $p_fisik_array[$x - 1]; 	
	$x++;
	}
}

$p_alergi = array();
$get_alergi = mysql_query($qry_alergi) or die(mysql_error());
while($dat_alergi = mysql_fetch_array($get_alergi)){
	$p_alergi[] = $dat_alergi['ALERGI'];
}

$p_diagnosa = array();
$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
while($dat_diagnosa = mysql_fetch_array($get_diagnosa)){
	$diagnosa = $dat_diagnosa['DIAGNOSA'];
	if(!empty($dat_diagnosa['ICD_CODE'])) $diagnosa = $diagnosa . ' (' . $dat_diagnosa['ICD_CODE'] . ')'; 
	$p_diagnosa[] = $diagnosa;
}

$p_diagnosa_sk = array();
$get_diagnosa_sk = mysql_query($qry_diagnosa_sk) or die(mysql_error());
while($dat_diagnosa_sk = mysql_fetch_array($get_diagnosa_sk)){
	$diagnosa_sk = $dat_diagnosa_sk['DIAGNOSA'];
	if(!empty($dat_diagnosa_sk['ICD_CODE'])) $diagnosa_sk = $diagnosa_sk . ' (' . $dat_diagnosa_sk['ICD_CODE'] . ')'; 
	$p_diagnosa_sk[] = $diagnosa_sk;
}

$p_tindakan = array();
$p_tindakan_group = array();
$p_tindakan_icd = array();
$p_tindakan_qty = array();
$get_tindakan = mysql_query($qry_tindakan) or die(mysql_error());

while($dat_tindakan = mysql_fetch_array($get_tindakan)){
	$p_tindakan[] = $dat_tindakan['NAMA_TARIF']; 
	$p_tindakan_group[] = $dat_tindakan['NAMA_TARIF_GROUP'];
	$p_tindakan_icd[] = $dat_tindakan['ICD_CODE'];
	$p_tindakan_qty[] = $dat_tindakan['KUANTITI'];
}

$get_tindakan = mysql_query($qry_penunjang) or die(mysql_error());
while($dat_tindakan = mysql_fetch_array($get_tindakan)){
	$p_tindakan[] = $dat_tindakan['NAMA_TARIF']; 
	$p_tindakan_group[] = $dat_tindakan['NAMA_TARIF_GROUP'];
	$p_tindakan_qty[] = $dat_tindakan['KUANTITI'];
}

$edoc_content = '<table width="100%" border="0" autosize="1" >
		<tr>
            <td valign="top" width="200px">Dokter Penanggungjawab</td>
            <td>:&nbsp;' . $dokter . '</td>
        </tr>
		<tr>
            <td valign="top">&nbsp;</td>
            <td align="center">&nbsp;</td>
        </tr>
		</table>
	<table width="100%" border="0" autosize="1" >
        <tr>
            <td colspan="2"></td>
        </tr>
		<tr>
            <td valign="top">Anamnesis</td>
            <td width="85%">'; 

if(!empty($anamnesis) and ($anam_count == 1)){			
	$edoc_content = $edoc_content . ':&nbsp;' . $anamnesis; 
	$a = 0;
	while($a < sizeof($p_alergi)){
		if($a==0){
			$edoc_content = $edoc_content . '<br />Alergi : ' . $p_alergi[$a]; 
		}else{
			$edoc_content = $edoc_content . ', ' . $p_alergi[$a]; 
		}
	$a++;
	}	
}else{
	$edoc_content = $edoc_content . '<table border="0" width="100%">
			<tr>
				<td>Keluhan Utama</td>
				<td>:</td>
				<td colspan="5">' . setGarisIfNull($p_anamnesis[1]) . '</td>
			</tr>	
			<tr>
				<td>Riwayat Penyakit Sekarang</td>
				<td>:</td>
				<td colspan="5">' . setGarisIfNull($p_anamnesis[2]) . '</td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Dahulu<br />dan Terapinya</td>
				<td>:</td>
				<td colspan="5">' . setGarisIfNull($p_anamnesis[3]) . '</td>
			</tr>
			<tr>
				<td>Riwayat Penyakit Keluarga</td>
				<td>:</td>
				<td colspan="5">' . setGarisIfNull($p_anamnesis[4]) . '</td>
			</tr>';
	if(sizeof($p_alergi) > 0){
		$a = 0;
		while($a < sizeof($p_alergi)){
			if($a==0){
				$edoc_content = $edoc_content . '<tr>
					<td>Alergi</td>
					<td>:</td>
					<td colspan="5">' . $p_alergi[$a] . '</td>
				</tr>'; 
			}else{
				$edoc_content = $edoc_content . '<tr>
					<td>Alergi</td>
					<td>:</td>
					<td colspan="5">' . $p_alergi[$a] . '</td>
				</tr>'; 
				$edoc_content = $edoc_content . '<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan="5">' . $p_alergi[$a] . '</td>
				</tr>'; 
			}
		$a++;
		}
	}else{
		$edoc_content = $edoc_content . '<tr>
					<td>Alergi</td>
					<td>:</td>
					<td colspan="5">__________</td>
				</tr>'; 
	}	
	$edoc_content = $edoc_content . '</table>';	
}			
			
$edoc_content = $edoc_content . '</td>
        </tr>
		<tr>
            <td valign="top">Pemeriksaan Fisik</td>
            <td >';			

if(!empty($pemeriksaan_fisik) and ($fisik_count == 1)){ 
		$edoc_content = $edoc_content . ':&nbsp;' . $pemeriksaan_fisik;
}else{
		$edoc_content = $edoc_content . '<table border="0" width="100%">
					<tr>
						<td>Keadaan Umum</td>
						<td>:</td>
						<td colspan="5">' . setGarisIfNull($p_fisik[1]) . '</td>
					</tr>	
					<tr>	
						<td>Tekanan Darah</td>
						<td>:</td>
						<td>' . setGarisIfNull($p_fisik[2]) . '</td>
						<td>&nbsp;</td>
						<td>GCS</td>
						<td>:</td>
						<td>' . setGarisIfNull($p_fisik[3]) . '</td>
					</tr>
					<tr>	
						<td>Nadi</td>
						<td>:</td>
						<td>' . setGarisIfNull($p_fisik[4]) . '</td>
						<td>&nbsp;</td>
						<td>Suhu</td>
						<td>:</td>
						<td>' . setGarisIfNull($p_fisik[5]) . '</td>
					</tr>
					<tr>	
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><input type="checkbox" name="p_fisik_6" value="1" class="text_dt" ' . (($p_fisik[6] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Teratur
						&nbsp;<input type="checkbox" name="p_fisik_7" value="1" class="text_dt" ' . (($p_fisik[7] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Tidak Teratur</td>
						<td>&nbsp;</td>
						<td>Tinggi Badan</td>
						<td>:</td>
						<td>' . setGarisIfNull($p_fisik[8]) . '</td>
					</tr>
					<tr>	
						<td>Kepala</td>
						<td>:</td>
						<td>' . setGarisIfNull($p_fisik[9]) . '</td>
						<td>&nbsp;</td>
						<td>Berat Badan</td>
						<td>:</td>
						<td>' . setGarisIfNull($p_fisik[10]) . '</td>
					</tr>
					<tr>	
						<td>Leher</td>
						<td>:</td>
						<td>' . setGarisIfNull($p_fisik[11]) . '</td>
						<td>&nbsp;</td>
						<td>RR</td>
						<td>:</td>
						<td>' . setGarisIfNull($p_fisik[12]) . '</td>
					</tr>
					<tr>	
						<td>Dada</td>
						<td>:</td>
						<td colspan="5">a. Jantung&nbsp;&nbsp;
						' . setGarisIfNull($p_fisik[13]) . '</td>
					</tr>
					<tr>	
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td colspan="5">b. Dada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
						' . setGarisIfNull($p_fisik[14]) . '</td>
					</tr>
					<tr>
						<td>Abdomen</td>
						<td>:</td>
						<td colspan="5">' . setGarisIfNull($p_fisik[15]) . '</td>
					</tr>
					<tr>
						<td>Extremitas</td>
						<td>:</td>
						<td colspan="5">' . setGarisIfNull($p_fisik[16]) . '</td>
					</tr>
		</table>';
	}
	
	$edoc_content = $edoc_content . '</td>
        </tr>
		<tr>
            <td valign="top">Status Lokalis</td>
            <td>:&nbsp;' .setGarisIfNull($status_lokalis) . '
            </td>
        </tr>
        <tr>
            <td colspan="2"></td>
        </tr>
    </table>';	
	
ob_start();
include('edoc_rekammedik/edoc_frame_main.php');
$html = ob_get_contents();
ob_end_clean();
$mpdf->WriteHTML($html);	

$edoc_content_2 = '<table width="100%" border="0" autosize="1" >
        <tr>
            <td colspan="2"></td>
        </tr>
		<tr>
            <td valign="top">Hasil Pemeriksaan Penunjang</td>
            <td width="85%">:&nbsp;' .setGarisIfNull($pemeriksaan_penunjang) . '</td>
        </tr>';
		
	if(sizeof($p_diagnosa) > 0){
		$d = 0;
		while($d < sizeof($p_diagnosa)){
			if($d==0){
				$edoc_content_2 = $edoc_content_2 . '<tr>
					<td valign="top">Diagnosa Utama</td>
					<td>:&nbsp;' . $p_diagnosa[$d] . '</td>
				</tr>';
			}else{
				$edoc_content_2 = $edoc_content_2 . '<tr>
					<td valign="top">&nbsp;</td>
					<td>' . $p_diagnosa[$d] . '</td>
				</tr>';
			}	
		$d++;
		}	
	}else{
		$edoc_content_2 = $edoc_content_2 . '<tr>
            <td valign="top">Diagnosa Utama</td>
            <td>:&nbsp;__________</td>
        </tr>';
	}
	
	if(sizeof($p_diagnosa_sk) > 0){
		$d = 0;
		while($d < sizeof($p_diagnosa_sk)){
			if($d==0){
				$edoc_content_2 = $edoc_content_2 . '<tr>
					<td valign="top">Diagnosa Banding</td>
					<td>:&nbsp;' . $p_diagnosa_sk[$d] . '</td>
				</tr>';
			}else{
				$edoc_content_2 = $edoc_content_2 . '<tr>
					<td valign="top">&nbsp;</td>
					<td>' . $p_diagnosa_sk[$d] . '</td>
				</tr>';
			}	
		$d++;
		}	
	}else{
		$edoc_content_2 = $edoc_content_2 . '<tr>
            <td valign="top">Diagnosa Banding</td>
            <td>:&nbsp;__________</td>
        </tr>';
	}	
		
if(sizeof($p_tindakan) == 0){
	$edoc_content_2 = $edoc_content_2 . '
		<tr>
            <td valign="top">Rencana Tatalaksana</td>
            <td>:&nbsp;__________</td>
        </tr>
    </table>';
}else{
		
	$p = 0;
	$q = 1;
	$fisrt_pg = false; 
	while($p < sizeof($p_tindakan)){
		$tatalaksana_content = $p_tindakan[$p] . ' (' . $p_tindakan_qty[$p] . ') - ' . $p_tindakan_group[$p];
		if(!empty($p_tindakan_icd[$p])) $tatalaksana_content = $tatalaksana_content . ' [' . $p_tindakan_icd[$p] . ']'; 	

		if($p == 0){
			$edoc_content_2 = $edoc_content_2 . '
				<tr>
					<td valign="top">Rencana Tatalaksana</td>
					<td>:&nbsp;' . $tatalaksana_content . '</td>
				</tr>';
		}else{
			$edoc_content_2 = $edoc_content_2 . '
				<tr>
					<td valign="top">&nbsp;</td>
					<td>' . $tatalaksana_content . '</td>
				</tr>';
		}
		
		if($fisrt_pg == false){
			if($q > 14){
				$edoc_content_2 = $edoc_content_2 . '</table>';
				ob_start();
				include('edoc_rekammedik/edoc_frame_add.php');
				$html = ob_get_contents();
				ob_end_clean();
				$mpdf->AddPage('P');
				$mpdf->WriteHTML($html);
				$edoc_content_2 = '<table width="100%" border="0" autosize="1" >
							<tr>
								<td colspan="2"></td>
							</tr>';
				$q = 0;				
				$fisrt_pg = true;
			}
		}else{
			if($q > 29){
				$edoc_content_2 = $edoc_content_2 . '</table>';
				ob_start();
				include('edoc_rekammedik/edoc_frame_add.php');
				$html = ob_get_contents();
				ob_end_clean();
				$mpdf->AddPage('P');
				$mpdf->WriteHTML($html);
				$edoc_content_2 = '<table width="100%" border="0" autosize="1" >
							<tr>
								<td colspan="2"></td>
							</tr>';
				$q = 0;				
			}
		}	
		
	$q++;	
	$p++;
	}	
		
}	

if($edoc_content_2 != '<table width="100%" border="0" autosize="1" >
							<tr>
								<td colspan="2"></td>
							</tr>'){
	$edoc_content_2 = $edoc_content_2 . '</table>';
	
	ob_start();
	include('edoc_rekammedik/edoc_frame_add.php');
	$html = ob_get_contents();
	ob_end_clean();
	$mpdf->AddPage('P');
	$mpdf->WriteHTML($html);
}

//end Pengkajian Awal Medis

//Resep
$edoc_nama_documen = strtoupper('Resep');

$qry_resep = 'SELECT t_hemodialisa_resep.NO_RESEP,m_pegawai.NAMA_PEGAWAI,
					DATE_FORMAT(t_hemodialisa_resep.TGL_RESEP,"%d/%m/%Y") AS TGL_RESEP,
					t_hemodialisa_resep.RESEP,t_hemodialisa_resep.RACIKAN,t_hemodialisa_resep.GENERIK,
					t_hemodialisa_resep.DOSIS,t_hemodialisa_resep.JUMLAH,t_hemodialisa_resep.PSIKOTROPIKA,
					t_hemodialisa_resep.SATUAN,t_hemodialisa_resep.FORMULARIUM,
					t_hemodialisa_resep.FORMULARIUM_NASIONAL
					FROM t_hemodialisa_resep
					LEFT JOIN m_pegawai ON (t_hemodialisa_resep.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					WHERE HEMODIALISA_ID = "' . $idx . '" AND t_hemodialisa_resep.NO_RESEP IS NOT NULL
					AND t_hemodialisa_resep.RESEP IS NOT NULL
					ORDER BY t_hemodialisa_resep.NO_RESEP';	
$get_resep = mysql_query($qry_resep) or die(mysql_error());
if(mysql_num_rows($get_resep) > 0){
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
			$mpdf->AddPage('P'); 
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
			$mpdf->AddPage('P'); 
			$mpdf->WriteHTML($html);
		}	
	}
}

//end Resep	

//Farmasi
$edoc_nama_documen = strtoupper('Farmasi');

if($jns_order == 'IRJ'){
	$qry_farmasi = 'SELECT DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") AS TANGGAL_KELUAR,
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
					WHERE t_rajal_resep.RAJAL_ID = "' . $rawat_id . '" AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_rajal_resep.HEMODIALISA_ID = "' . $idx . '"	
					AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
					GROUP BY DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),
					m_persediaan_farmasi.NAMA_PERSEDIAAN,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN
                    ORDER BY t_farmasi_apotik_pengeluaran.NO_PENGELUARAN';	
} else if($jns_order == 'IRN'){
	$qry_farmasi = 'SELECT DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y") AS TANGGAL_KELUAR,
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
					WHERE t_ranap_resep.RANAP_ID = "' . $rawat_id . '" AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
					AND t_ranap_resep.HEMODIALISA_ID = "' . $idx . '"	
					AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
					GROUP BY DATE_FORMAT(t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR,"%d/%m/%Y"),
					m_persediaan_farmasi.NAMA_PERSEDIAAN,t_farmasi_apotik_pengeluaran.NO_PENGELUARAN
                    ORDER BY t_farmasi_apotik_pengeluaran.NO_PENGELUARAN';
}

$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());

$get_farmasi = mysql_query($qry_farmasi) or die(mysql_error());
if(mysql_num_rows($get_farmasi) > 0){
	$edoc_first = '<style>.tbl tr td {
	   border: 1px solid black;
	   padding-left:1px;
	   border-collapse: collapse;
	}</style>
	<table width="100%" class="tbl" cellpadding="0" cellspacing="0" autosize="1" >
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
			$mpdf->AddPage('P'); 
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
			$mpdf->AddPage('P'); 
			$mpdf->WriteHTML($html);
		}	
	}
}

$connect = mysql_connect($hostname, $username, $password) or die(mysql_error());
mysql_select_db($database, $connect) or die(mysql_error());

//end Farmasi	

//Terapi & Monitoring
$edoc_nama_documen = strtoupper('Terapi - Monitoring - Evaluasi');

$qry_terapi = 'SELECT t_hemodialisa.THERAPI,t_hemodialisa.MONITORING,t_hemodialisa.EVALUASI
					FROM t_hemodialisa
					WHERE t_hemodialisa.HEMODIALISA_ID = "' . $idx . '"';
$get_terapi = mysql_query($qry_terapi) or die(mysql_error());
$dat_terapi = mysql_fetch_assoc($get_terapi);
$terapi = $dat_terapi['THERAPI'];
$monitoring = $dat_terapi['MONITORING'];
$evaluasi = $dat_terapi['EVALUASI'];

if($terapi != '' or $monitoring != '' or $evaluasi != ''){

	$edoc_content = '<table width="100%" border="0" autosize="1" >
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>Terapi</td>
		<td>:&nbsp;' . setGarisIfNull($terapi) . '</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>Monitoring</td>
		<td>:&nbsp;' . setGarisIfNull($monitoring) . '</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>Evaluasi</td>
		<td>:&nbsp;' . setGarisIfNull($evaluasi) . '</td>
	  </tr>
	</table>';

	ob_start();
	include('edoc_rekammedik/edoc_frame_main.php');
	$html = ob_get_contents();
	ob_end_clean();
	$mpdf->AddPage('P'); 
	$mpdf->WriteHTML($html);
}
//end Terapi & Monitoring

//Catatan Perkembangan Pasien
$edoc_nama_documen = strtoupper('Catatan Perkembangan Pasien Terintegrasi');

$qry_catatan = 'SELECT DATE_FORMAT(t_hemodialisa_perkembangan.TANGGAL,"%d/%m/%Y %H:%i%s") AS TANGGAL,m_pegawai.NAMA_PEGAWAI AS PEMBERI_ASUHAN,
					t_hemodialisa_perkembangan.HASIL_ASESMEN,t_hemodialisa_perkembangan.INTRUKSI_PPA,t_hemodialisa_perkembangan.VERIFIKASI_DPJP
					FROM t_hemodialisa_perkembangan
					LEFT JOIN m_pegawai ON (t_hemodialisa_perkembangan.PEMBERI_ASUHAN = m_pegawai.PEGAWAI_ID)
					WHERE t_hemodialisa_perkembangan.HEMODIALISA_ID = "' . $idx . '"
					ORDER BY t_hemodialisa_perkembangan.TANGGAL';
$get_catatan = mysql_query($qry_catatan) or die(mysql_error());
if(mysql_num_rows($get_catatan) > 0){
	$edoc_first = '<style>.tbl tr td {
	   border: 1px solid black;
	   padding-left:1px;
	   border-collapse: collapse;
	}</style>
	<table width="100%" class="tbl" cellpadding="0" cellspacing="0" autosize="1" >
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
			$mpdf->AddPage('P'); 
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
			$mpdf->AddPage('P'); 
			$mpdf->WriteHTML($html);
		}	
	}
}	
//end Catatan Perkembangan Pasien

//Asuhan Keperawatan
$edoc_nama_documen = strtoupper('Pengkajian Awal Keperawatan Rawat Jalan');

if($jns_order == 'IRJ'){
	$qry_keperawatan = 'SELECT m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,t_hemodialisa.UNIT_ID,m_unit.NAMA_UNIT,
					m_pegawai.NAMA_PEGAWAI,"" AS JNS_ORDER, "" AS RAWAT_ID,
					DATE_FORMAT(t_hemodialisa.PASIEN_MASUK,"%d/%m/%Y") AS TANGGAL_MASUK,
					DATE_FORMAT(t_hemodialisa.PASIEN_MASUK,"%H:%i:%s") AS JAM_MASUK,
					m_agama.NAMA_AGAMA,m_pendidikan.NAMA_PENDIDIKAN,m_pasien.PEKERJAAN,m_jaminan.NAMA_JAMINAN
					FROM t_hemodialisa
					INNER JOIN t_irja ON (t_hemodialisa.RAWAT_ID = t_irja.IRJA_ID) 
					INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
					INNER JOIN m_unit ON (t_hemodialisa.UNIT_ID = m_unit.UNIT_ID)
					LEFT JOIN m_pegawai ON (t_hemodialisa.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
					LEFT JOIN m_agama ON (m_pasien.AGAMA_ID = m_agama.AGAMA_ID)
					LEFT JOIN m_pendidikan ON (m_pasien.PENDIDIKAN_ID = m_pendidikan.PENDIDIKAN_ID)
					LEFT JOIN m_jaminan ON (t_hemodialisa.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE t_hemodialisa.HEMODIALISA_ID = "' . $idx . '"';
}else if($jns_order == 'IRN'){
	$qry_keperawatan = 'SELECT m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,t_hemodialisa.UNIT_ID,m_ruang.NAMA_RUANG AS NAMA_UNIT,
					m_pegawai.NAMA_PEGAWAI,"" AS JNS_ORDER, "" AS RAWAT_ID,
					DATE_FORMAT(t_hemodialisa.PASIEN_MASUK,"%d/%m/%Y") AS TANGGAL_MASUK,
					DATE_FORMAT(t_hemodialisa.PASIEN_MASUK,"%H:%i:%s") AS JAM_MASUK,
					m_agama.NAMA_AGAMA,m_pendidikan.NAMA_PENDIDIKAN,m_pasien.PEKERJAAN,m_jaminan.NAMA_JAMINAN
					FROM t_hemodialisa
					INNER JOIN t_irna ON (t_hemodialisa.RAWAT_ID = t_irna.IRNA_ID) 
					INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
					LEFT JOIN m_ruang ON (t_hemodialisa.RUANG_ID = m_ruang.RUANG_ID)
					LEFT JOIN m_pegawai ON (t_hemodialisa.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
					LEFT JOIN m_agama ON (m_pasien.AGAMA_ID = m_agama.AGAMA_ID)
					LEFT JOIN m_pendidikan ON (m_pasien.PENDIDIKAN_ID = m_pendidikan.PENDIDIKAN_ID)
					LEFT JOIN m_jaminan ON (t_hemodialisa.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE t_hemodialisa.HEMODIALISA_ID = "' . $idx . '"';	
}					
					
$qry_askep = 'SELECT t_hemodialisa_askep.HEMODIALISA_ASKEP_ID,t_hemodialisa_askep.KELUHAN_UTAMA,t_hemodialisa_askep.RIWAYAT_PENYAKIT,t_hemodialisa_askep.RIWAYAT_PENYAKIT_KELUARGA,
					t_hemodialisa_askep.GENOGRAM,t_hemodialisa_askep.TEKANAN_DARAH,t_hemodialisa_askep.FREKUENSI_NAFAS,t_hemodialisa_askep.SUHU_TUBUH,t_hemodialisa_askep.FREKUENSI_NADI,
					t_hemodialisa_askep.BERAT_BADAN,t_hemodialisa_askep.TINGGI_BADAN,t_hemodialisa_askep.PEMERIKSA_FISIK_TERKAIT_KELUHAN,t_hemodialisa_askep.HUBUNGAN_KELUARGA,
					t_hemodialisa_askep.STATUS_PSIKOLOGIS,t_hemodialisa_askep.STATUS_PSIKOLOGIS_BUNUH_DIRI,t_hemodialisa_askep.KETERANGAN_STATUS_PSIKOLOGIS,
					t_hemodialisa_askep.PENURUNAN_BERAT_BADAN,t_hemodialisa_askep.TIDAK_NAFSU_MAKAN,t_hemodialisa_askep.DIAGNOSIS_KHUSUS,t_hemodialisa_askep.DIAGNOSA_KHUSUS_DM,
					t_hemodialisa_askep.DIAGNOSA_KHUSUS_KEMOTERAPI,t_hemodialisa_askep.DIAGNOSA_KHUSUS_HEMODIALISA,t_hemodialisa_askep.DIAGNOSA_KHUSUS_GERIATRI,
					t_hemodialisa_askep.DIAGNOSA_KHUSUS_IMUNITAS,t_hemodialisa_askep.DIAGNOSA_KHUSUS_LAIN,t_hemodialisa_askep.KETERANGAN_DIAGNOSIS_KHUSUS,
					t_hemodialisa_askep.STATUS_FUNGSIONAL,t_hemodialisa_askep.KETERANGAN_STATUS_FUNGSIONAL,t_hemodialisa_askep.KETERANGAN_STATUS_FUNGSIONAL_KETERGANTUNGAN,
					t_hemodialisa_askep.CARA_BERJALAN,t_hemodialisa_askep.CARA_DUDUK,t_hemodialisa_askep.RESIKO_JATUH,t_hemodialisa_askep.KETERANGAN_RESIKO_JATUH,
					t_hemodialisa_askep.NYERI,t_hemodialisa_askep.SKALA_NYERI,t_hemodialisa_askep.LOKASI_NYERI,t_hemodialisa_askep.DURASI_NYERI,t_hemodialisa_askep.FREKUENSI_NYERI,
					t_hemodialisa_askep.NYERI_HILANG,t_hemodialisa_askep.KETERANGAN_NYERI_HILANG,t_hemodialisa_askep.STATUS_NYERI_HILANG,
					t_hemodialisa_askep.KETERANGAN_STATUS_NYERI_HILANG,t_hemodialisa_askep.RIWAYAT_ALERGI_OBAT,t_hemodialisa_askep.DIAGNOSA_KEPERAWATAN,
					t_hemodialisa_askep.RENCANA_KEPERAWATAN,t_hemodialisa_askep.IMPELEMENTASI_KEPERAWATAN,t_hemodialisa_askep.EVALUASI_KEPERAWATAN,t_hemodialisa_askep.ST_SELESAI
					FROM t_hemodialisa_askep
					WHERE t_hemodialisa_askep.HEMODIALISA_ASKEP_ID = "' . $idx . '"';				
$get_askep = mysql_query($qry_askep) or die(mysql_error());
if(mysql_num_rows($get_askep) > 0){
	$dat_askep = mysql_fetch_assoc($get_askep);
	
	$get_keperawatan = mysql_query($qry_keperawatan) or die(mysql_error());
	$dat_keperawatan = mysql_fetch_assoc($get_keperawatan);

	$dokter = $dat_keperawatan['NAMA_PEGAWAI'];
	$agama = $dat_keperawatan['NAMA_AGAMA'];
	$pendidikan = $dat_keperawatan['NAMA_PENDIDIKAN'];
	$pekerjaan = $dat_keperawatan['PEKERJAAN'];
	$jaminan = $dat_keperawatan['NAMA_JAMINAN'];
	
	$edoc_tanggal_masuk = $dat_keperawatan['TANGGAL_MASUK'];
	$edoc_jam_masuk = $dat_keperawatan['JAM_MASUK'];

	$keluhan_utama = $dat_askep['KELUHAN_UTAMA']; 
	$riwayat_penyakit = $dat_askep['RIWAYAT_PENYAKIT']; 
	$riwayat_penyakit_keluarga = $dat_askep['RIWAYAT_PENYAKIT_KELUARGA']; 
	$genogram = $dat_askep['GENOGRAM']; 
	$tekanan_darah = $dat_askep['TEKANAN_DARAH']; 
	$frekuensi_nafas = $dat_askep['FREKUENSI_NAFAS']; 
	$suhu_tubuh = $dat_askep['SUHU_TUBUH']; 
	$frekuensi_nadi = $dat_askep['FREKUENSI_NADI']; 
	$berat_badan = $dat_askep['BERAT_BADAN']; 
	$tinggi_badan = $dat_askep['TINGGI_BADAN']; 
	$pemeriksaan_fisik_terkait_keluhan = $dat_askep['PEMERIKSA_FISIK_TERKAIT_KELUHAN']; 
	$hubungan_keluarga = $dat_askep['HUBUNGAN_KELUARGA']; 
	$status_psikologis = $dat_askep['STATUS_PSIKOLOGIS']; 
	$keterangan_status_psikologis = $dat_askep['KETERANGAN_STATUS_PSIKOLOGIS']; 
	$penurunan_berat_badan = $dat_askep['PENURUNAN_BERAT_BADAN']; 
	$tidak_nafsu_makan = $dat_askep['TIDAK_NAFSU_MAKAN']; 
	$diagnosis_khusus = $dat_askep['DIAGNOSIS_KHUSUS']; 
	$keterangan_diagnosis_khusus = $dat_askep['KETERANGAN_DIAGNOSIS_KHUSUS'];
	$status_fungsional = $dat_askep['STATUS_FUNGSIONAL'];
	$keterangan_status_fungsional = $dat_askep['KETERANGAN_STATUS_FUNGSIONAL'];
	$cara_berjalan = $dat_askep['CARA_BERJALAN'];
	$cara_duduk = $dat_askep['CARA_DUDUK'];
	$nyeri = $dat_askep['NYERI'];
	$skala_nyeri = $dat_askep['SKALA_NYERI'];
	$lokasi_nyeri = $dat_askep['LOKASI_NYERI'];
	$durasi_nyeri = $dat_askep['DURASI_NYERI'];
	$frekuensi_nyeri = $dat_askep['FREKUENSI_NYERI'];
	$nyeri_hilang = $dat_askep['NYERI_HILANG'];
	$keterangan_nyeri_hilang = $dat_askep['KETERANGAN_NYERI_HILANG'];

	$status_bunuh_diri = $dat_askep['STATUS_PSIKOLOGIS_BUNUH_DIRI'];
	$diagnosis_khusus_dm = $dat_askep['DIAGNOSA_KHUSUS_DM'];
	$diagnosis_khusus_kemoterapi = $dat_askep['DIAGNOSA_KHUSUS_KEMOTERAPI'];
	$diagnosis_khusus_hemodialisa = $dat_askep['DIAGNOSA_KHUSUS_HEMODIALISA'];
	$diagnosis_khusus_geriatri = $dat_askep['DIAGNOSA_KHUSUS_GERIATRI'];
	$diagnosis_khusus_imunitas = $dat_askep['DIAGNOSA_KHUSUS_IMUNITAS'];
	$diagnosis_khusus_lain = $dat_askep['DIAGNOSA_KHUSUS_LAIN'];
	$keterangan_status_fungsional_ketergantungan = $dat_askep['KETERANGAN_STATUS_FUNGSIONAL_KETERGANTUNGAN'];
	$resiko_jatuh = $dat_askep['RESIKO_JATUH'];
	$keterangan_resiko_jatuh = $dat_askep['KETERANGAN_RESIKO_JATUH'];

	$status_nyeri_hilang = $dat_askep['STATUS_NYERI_HILANG'];
	$keterangan_status_nyeri_hilang = $dat_askep['KETERANGAN_STATUS_NYERI_HILANG'];
	$riwayat_alergi_obat = $dat_askep['RIWAYAT_ALERGI_OBAT'];
	$diagnosa_keperawatan = $dat_askep['DIAGNOSA_KEPERAWATAN'];
	$rencana_keperawatan = $dat_askep['RENCANA_KEPERAWATAN'];
	$implementasi_keperawatan = $dat_askep['IMPELEMENTASI_KEPERAWATAN'];
	$evaluasi_keperawatan = $dat_askep['EVALUASI_KEPERAWATAN'];
	
	$skor = 0;
	if($penurunan_berat_badan == 'Tidak Ada') $skor = $skor + 0;
	if($penurunan_berat_badan == 'Tidak Yakin') $skor = $skor + 2;
	if($penurunan_berat_badan == 'Ada|1 - 5 kg') $skor = $skor + 1;
	if($penurunan_berat_badan == 'Ada|6 - 10 kg') $skor = $skor + 2;
	if($penurunan_berat_badan == 'Ada|- 15 kg') $skor = $skor + 3;
	if($penurunan_berat_badan == 'Ada|> 15 kg') $skor = $skor + 4;
	if($tidak_nafsu_makan == 'Tidak') $skor = $skor + 0;
	if($tidak_nafsu_makan == 'Ya') $skor = $skor + 1;
	
	$hasil_cara_duduk = '';
	if(($cara_berjalan == 'Tidak') and ($cara_duduk == 'Tidak')) $hasil_cara_duduk = 'Tidak Berisiko';
	if(($cara_berjalan == 'Ya') and ($cara_duduk == 'Ya')) $hasil_cara_duduk = 'Risiko Tinggi';
	if(($cara_berjalan == 'Tidak') and ($cara_duduk == 'Ya')) $hasil_cara_duduk = 'Risiko Rendah';
	if(($cara_berjalan == 'Ya') and ($cara_duduk == 'Tidak')) $hasil_cara_duduk = 'Risiko Rendah';
	
	$edoc_content = '<table width="100%" border="0" autosize="1" >
	<tr>
            <td colspan="2" valign="top">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
        </tr>
	<tr>
		  <td colspan="5" valign="top">Tanggal Kunjungan : ' . $edoc_tanggal_masuk . '&nbsp;&nbsp;&nbsp;&nbsp;Pukul : ' . $edoc_jam_masuk . 
		'&nbsp;&nbsp;&nbsp;&nbsp;Nama Klinik : ' . $edoc_unit . '</td>
	</tr>
		<tr>
            <td colspan="2" valign="top">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td width="10px" valign="top" >1.</td>
          <td width="160px" valign="top">Identitas Pasien </td>
          <td width="10px">a.</td>
          <td width="160px">Nama</td>
          <td >:&nbsp;' . $edoc_nama_pasien . '</td>
        </tr>
		<tr>
		  <td valign="top">&nbsp;</td>
		  <td valign="top">&nbsp;</td>
		  <td>b.</td>
		  <td>No Rekam Medik </td>
		  <td>:&nbsp;' . $edoc_norm . '</td>
  </tr>
		<tr>
		  <td valign="top">&nbsp;</td>
		  <td valign="top">&nbsp;</td>
		  <td>c.</td>
		  <td>Tanggal Lahir </td>
		  <td>:&nbsp;' . $edoc_tanggal_lahir . '</td>
  </tr>
		<tr>
		  <td valign="top">&nbsp;</td>
		  <td valign="top">&nbsp;</td>
		  <td>d.</td>
		  <td>Jenis Kelamin </td>
		  <td>:&nbsp;' . $edoc_jenis_kelamin . '</td>
  </tr>
		<tr>
		  <td valign="top">&nbsp;</td>
		  <td valign="top">&nbsp;</td>
		  <td>e.</td>
		  <td>Agama</td>
		  <td>:&nbsp;' . $agama . '</td>
  </tr>
		<tr>
		  <td valign="top">&nbsp;</td>
		  <td valign="top">&nbsp;</td>
		  <td>f.</td>
		  <td>Pendidikan</td>
		  <td>:&nbsp;' . $pendidikan . '</td>
  </tr>
		<tr>
		  <td valign="top">&nbsp;</td>
		  <td valign="top">&nbsp;</td>
		  <td>g.</td>
		  <td>Pekerjaan</td>
		  <td>:&nbsp;' . $pekerjaan . '</td>
  </tr>
		<tr>
		  <td valign="top">&nbsp;</td>
		  <td valign="top">&nbsp;</td>
		  <td>h.</td>
		  <td>Status Pembayaran </td>
		  <td>:&nbsp;' . $jaminan . '</td>
  </tr>
		
		
        <tr>
            <td valign="top">2.</td>
            <td valign="top">Keluhan Utama</td>
            <td colspan="3">:&nbsp;' . setGarisIfNull($keluhan_utama) . '</td>
        </tr>
        <tr>
            <td valign="top">3.</td>
            <td valign="top">Riwayat Penyakit Dahulu</td>
            <td colspan="3">:&nbsp;' . setGarisIfNull($riwayat_penyakit) . '</td>
        </tr>
        <tr>
            <td valign="top">4.</td>
            <td valign="top">Riwayat Penyakit Keluarga</td>
            <td colspan="3">:&nbsp;' . setGarisIfNull($riwayat_penyakit_keluarga) . '</td>
        </tr>
		<tr>
            <td valign="top">5.</td>
            <td valign="top">Genogram</td>
            <td colspan="3">:&nbsp;' . setGarisIfNull($genogram) . '</td>
        </tr>
		<tr>
            <td valign="top">6.</td>
            <td valign="top">Pemeriksaan Fisik</td>
            <td colspan="3">
                <table border="0">
				<tr>	
					<td>Tekanan Darah</td>
					<td>:&nbsp;' . setGarisIfNull($tekanan_darah) . '&nbsp;mmHg</td>
					<td width="50px">&nbsp;</td>
					<td>Frekuensi Nafas</td>
					<td>:&nbsp;' . setGarisIfNull($frekuensi_nafas) . '&nbsp;x/menit</td>
				</tr>	
				<tr>	
					<td>Suhu Tubuh</td>
					<td>:&nbsp;' . setGarisIfNull($suhu_tubuh) . '&nbsp;oC</td>
					<td width="50px">&nbsp;</td>
					<td>Frekuensi Nadi</td>
					<td>:&nbsp;' . setGarisIfNull($frekuensi_nadi) . '&nbsp;x/menit</td>
				</tr>	
				<tr>	
					<td>Berat Badan</td>
					<td>:&nbsp;' . setGarisIfNull($berat_badan) . '&nbsp;Kg</td>
					<td width="50px">&nbsp;</td>
					<td>Tinggi Badan</td>
					<td>:&nbsp;' . setGarisIfNull($tinggi_badan) . '&nbsp;Cm</td>
				</tr>	
				<tr>	
					<td>Pemeriksaan Fisik <br>Terkait Keluhan Utama</td>
					<td colspan="4">:&nbsp;' . setGarisIfNull($pemeriksaan_fisik_terkait_keluhan) . '</td>
				</tr>	
				</table></td>
        </tr>
		<tr>
            <td valign="top">7.</td>
            <td valign="top">Riwayat Psikososial</td>
            <td colspan="3">
                <table border="0">
				<tr>	
					<td>Hubungan Dgn Anggota Keluarga</td>
					<td>:&nbsp;<input type="checkbox" name="hubungan_keluarga" value="Baik" class="text_dt" 
					' . (($hubungan_keluarga == 'Baik') ? 'checked="checked"' : '') . ' />&nbsp;Baik
					&nbsp;&nbsp;<input type="checkbox" name="hubungan_keluarga" value="Tidak Baik" class="text_dt" 
					' . (($hubungan_keluarga == 'Tidak Baik') ? 'checked="checked"' : '') . ' />&nbsp;Tidak Baik</td>
				</tr>	
				<tr>	
					<td valign="top">Status Psikologis</td>
					<td>:&nbsp;<input type="checkbox" name="status_psikologis" value="Tenang" class="text_dt" 
					' . (($status_psikologis == 'Tenang')  ? 'checked="checked"' : '') . ' />&nbsp;Tenang
					<input type="checkbox" name="status_psikologis" value="Cemas" class="text_dt" 
					' . (($status_psikologis == 'Cemas')  ? 'checked="checked"' : '') . ' />&nbsp;Cemas
					<input type="checkbox" name="status_psikologis" value="Takut" class="text_dt" 
					' . (($status_psikologis == 'Takut')  ? 'checked="checked"' : '') . ' />&nbsp;Takut
					<br>
					<input type="checkbox" name="status_psikologis" value="Marah" class="text_dt" 
					' . (($status_psikologis == 'Marah')  ? 'checked="checked"' : '') . ' />&nbsp;Marah
					<input type="checkbox" name="status_psikologis" value="Sedih" class="text_dt" 
					' . (($status_psikologis == 'Sedih')  ? 'checked="checked"' : '') . ' />&nbsp;Sedih
					<input type="checkbox" name="status_psikologis" value="Kecendrungan Bunuh" class="text_dt" 
					' . (($status_psikologis == 'Kecendrungan Bunuh')  ? 'checked="checked"' : '') . ' />&nbsp;Kecendrungan Bunuh Diri
					Dilaporkan Ke&nbsp;' . setGarisIfNull($status_bunuh_diri) . '
					<br />
					<input type="checkbox" name="status_psikologis" value="Lain-lain" class="text_dt" 
					' . (($status_psikologis == 'Lain-lain')  ? 'checked="checked"' : '') . ' />&nbsp;Lain-lain, Sebutkan ' . setGarisIfNull($keterangan_status_psikologis) . '</td>
				</tr>	
				</table></td>
        </tr>
        <tr>
            <td colspan="2" valign="top">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
        </tr>
    </table>';
	
	$edoc_content_2 = '<table width="100%" border="0" autosize="1" >
	<tr>
            <td colspan="2" valign="top">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
        </tr>
		<tr>
            <td valign="top">8.</td>
            <td valign="top">Skrining Gizi</td>
            <td colspan="3">
                <table border="0">
				<tr>	
					<td>Berdasarkan Malnutrition Screening Tooll</td>
					<td>&nbsp;</td>
					<td width="50px">&nbsp;</td>
				</tr>
				<tr>	
					<td colspan="2"><i>Parameter</i></td>
					<td width="50px"><i>Skors</i></td>
				</tr>	
				<tr>	
					<td>Apakah Pasien Mengalami Penurunan BB<br>Dlm 6 Bulan Terakhir?</td>
					<td>:&nbsp;<input type="checkbox" name="penurunan_berat_badan" value="Tidak Ada" class="text_dt" 
					' . (($penurunan_berat_badan == 'Tidak Ada') ? 'checked="checked"' : '') . ' />&nbsp;Tidak Ada Penurunan BB</td>
					<td width="50px" align="center">0</td>
				</tr>
				<tr>	
					<td>&nbsp;</td>
					<td><input type="checkbox" name="penurunan_berat_badan" value="Tidak Yakin" class="text_dt" 
					' . (($penurunan_berat_badan == 'Tidak Yakin') ? 'checked="checked"' : '') . ' />&nbsp;Tidak Yakin /Tidak Tahu /Baju Terasa Longgar</td>
					<td width="50px" align="center">2</td>
				</tr>
				<tr>	
					<td>Jika Ya, Berapa Penurunan Berat Badan Tersebut</td>
					<td>:&nbsp;<input type="checkbox" name="penurunan_berat_badan" value="Ada|1 - 5 kg" class="text_dt" 
					' . (($penurunan_berat_badan == 'Ada|1 - 5 kg') ? 'checked="checked"' : '') . ' />&nbsp;1 - 5 kg</td>
					<td width="50px" align="center">1</td>
				</tr>
				<tr>	
					<td>&nbsp;</td>
					<td><input type="checkbox" name="penurunan_berat_badan" value="Ada|6 - 10 kg" class="text_dt" 
					' . (($penurunan_berat_badan == 'Ada|6 - 10 kg') ? 'checked="checked"' : '') . ' />&nbsp;6 - 10 kg</td>
					<td width="50px" align="center">2</td>
				</tr>
				<tr>	
					<td>&nbsp;</td>
					<td><input type="checkbox" name="penurunan_berat_badan" value="Ada|- 15 kg" class="text_dt" 
					' . (($penurunan_berat_badan == 'Ada|- 15 kg') ? 'checked="checked"' : '') . ' />&nbsp;- 15 kg</td>
					<td width="50px" align="center">3</td>
				</tr>
				<tr>	
					<td>&nbsp;</td>
					<td><input type="checkbox" name="penurunan_berat_badan" value="Ada|> 15 kg" class="text_dt" 
					' . (($penurunan_berat_badan == 'Ada|> 15 kg') ? 'checked="checked"' : '') . ' />&nbsp;> 15 kg</td>
					<td width="50px" align="center">4</td>
				</tr>
				<tr>	
					<td>Apakah Asupan Makanan Berkurang<br>Karena Tdk Nafsu makan?</td>
					<td>:&nbsp;<input type="checkbox" name="tidak_nafsu_makan" value="Tidak" class="text_dt" 
					' . (($tidak_nafsu_makan == 'Tidak') ? 'checked="checked"' : '') . ' />&nbsp;Tidak					</td>
					<td width="50px" align="center">0</td>
				</tr>
				<tr>	
					<td>&nbsp;</td>
					<td><input type="checkbox" name="tidak_nafsu_makan" value="Ya" class="text_dt" 
					' . (($tidak_nafsu_makan == 'Ya') ? 'checked="checked"' : '') . ' />&nbsp;Ya					</td>
					<td width="50px" align="center">1</td>
				</tr>
				<tr>	
					<td>&nbsp;</td>
					<td align="right"><i>Total Skors</i>&nbsp;</td>
					<td width="50px" align="center">' . setGarisIfNull($skor) . '</td>
				</tr>
				<tr>	
					<td>Pasien Dgn Diagnosis Khusus</td>
					<td>:&nbsp;<input type="checkbox" name="diagnosis_khusus" value="Ya" class="text_dt" 
					' . (($diagnosis_khusus == 'Ya') ? 'checked="checked"' : '') . '/>&nbsp;Ya
					<input type="checkbox" name="diagnosis_khusus" value="Tidak" class="text_dt" 
					' . (($diagnosis_khusus == 'Tidak') ? 'checked="checked"' : '') . ' />&nbsp;Tidak</td>
					<td width="50px" align="center">&nbsp;</td>
				</tr>
				<tr>	
					<td>&nbsp;</td>
					<td><input type="checkbox" name="diagnosis_khusus_dm" value="1" class="text_dt" ' . (($diagnosis_khusus_dm == '1') ? 'checked="checked"' : '') . ' />DM
					<input type="checkbox" name="diagnosis_khusus_kemoterapi" value="1" class="text_dt" ' . (($diagnosis_khusus_kemoterapi == '1') ? 'checked="checked"' : '') . ' />Kemoterapi
					<input type="checkbox" name="diagnosis_khusus_hemodialisa" value="1" class="text_dt" ' . (($diagnosis_khusus_hemodialisa == '1') ? 'checked="checked"' : '') . ' />Hemodialisa
					<input type="checkbox" name="diagnosis_khusus_geriatri" value="1" class="text_dt" ' . (($diagnosis_khusus_geriatri == '1') ? 'checked="checked"' : '') . ' />Geriatri
					<input type="checkbox" name="diagnosis_khusus_imunitas" value="1" class="text_dt" ' . (($diagnosis_khusus_imunitas == '1') ? 'checked="checked"' : '') . ' />Imunitas Menurun
					<input type="checkbox" name="diagnosis_khusus_lain" value="1" class="text_dt" ' . (($diagnosis_khusus_lain == '1') ? 'checked="checked"' : '') . ' />Lain-lain
					' . setGarisIfNull($keterangan_diagnosis_khusus) . '</td>
				</tr>
				</table></td>
        </tr>
		<tr>
            <td valign="top">9.</td>
            <td valign="top">Status Fungsional</td>
            <td colspan="3">
                <table border="0">
				<tr>	
					<td colspan="2">:&nbsp;<input type="checkbox" name="status_fungsional" value="Mandiri" class="text_dt" 
					' . (($status_fungsional == 'Mandiri') ? 'checked="checked"' : '') . ' />&nbsp;Mandiri
					<input type="checkbox" name="status_fungsional" value="Perlu Bantuan" class="text_dt" 
					' . (($status_fungsional == 'Perlu Bantuan') ? 'checked="checked"' : '') . ' />&nbsp;Perlu Bantuan, Sebutkan&nbsp;
					' . setGarisIfNull($keterangan_status_fungsional) . '</td>
				</tr>
				<tr>	
					<td colspan="2"><input type="checkbox" name="status_fungsional" value="Ketergantungan Total" class="text_dt" 
					' . (($status_fungsional == 'Ketergantungan Total') ? 'checked="checked"' : '') . '/>&nbsp;Ketergantungan Total, Dilaporkan Ke Dokter Pukul&nbsp;
					' . setGarisIfNull($keterangan_status_fungsional_ketergantungan) . '</td>
				</tr>
				</table></td>
        </tr>
		<tr>
            <td valign="top">10.</td>
            <td valign="top">Skrining Resiko Cedera/ Jatuh</td>
            <td colspan="3">
                <table border="0">
				<tr>	
					<td>Perhatikan Cara Berjalan Saat Akan Duduk Di Kursi<br>Apakah Pasien Tampak Tdk Seimbang</td>
					<td colspan="2">:&nbsp;<input type="checkbox" name="cara_berjalan" value="Ya" class="text_dt" 
					' . (($cara_berjalan == 'Ya') ? 'checked="checked"' : '') . ' />&nbsp;Ya
					<input type="checkbox" name="cara_berjalan" value="Tidak" class="text_dt" 
					' . (($cara_berjalan == 'Tidak') ? 'checked="checked"' : '') . ' />&nbsp;Tidak</td>
				</tr>
				<tr>	
					<td>Apakah Pasien Memegang Pinggiran Kursi/ Meja/ Benda Lain<br>Sebaga Penopang Saat Akan Duduk</td>
					<td colspan="2">:&nbsp;<input type="checkbox" name="cara_duduk" value="Ya" class="text_dt" 
					' . (($cara_duduk == 'Ya') ? 'checked="checked"' : '') . ' />&nbsp;Ya
					<input type="checkbox" name="cara_duduk" value="Tidak" class="text_dt" 
					' . (($cara_duduk == 'Tidak') ? 'checked="checked"' : '') . ' />&nbsp;Tidak</td>
				</tr>
				<tr>	
					<td>Hasil :&nbsp;' . setGarisIfNull($hasil_cara_duduk) . '</td>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>	
					<td>Diberitahukan Ke Dokter</td>
					<td colspan="2">:&nbsp;<input type="checkbox" name="resiko_jatuh" value="Ya" class="text_dt" 
					' . (($resiko_jatuh == 'Ya') ? 'checked="checked"' : '') . ' />&nbsp;Ya, Pukul &nbsp; ' . setGarisIfNull($keterangan_resiko_jatuh) . '
					<input type="checkbox" name="resiko_jatuh" value="Tidak" class="text_dt" 
					' . (($resiko_jatuh == 'Tidak') ? 'checked="checked"' : '') . ' />&nbsp;Tidak</td>
				</tr>
				</table></td>
        </tr>
		<tr>
            <td valign="top">11.</td>
            <td valign="top">Skrining Nyeri (Metode Numerik Wong Baker -Face) </td>
            <td colspan="3">
                <table border="0">
				<tr>	
					<td colspan="2">:&nbsp;<input type="checkbox" name="nyeri" value="Tidak Ada" class="text_dt" 
					' . (($nyeri == 'Tidak Ada') ? 'checked="checked"' : '') . ' />&nbsp;Tidak Ada
					<input type="checkbox" name="nyeri" value="Nyeri Kronis" class="text_dt" 
					' . (($nyeri == 'Nyeri Kronis') ? 'checked="checked"' : '') . ' />&nbsp;Nyeri Kronis
					<input type="checkbox" name="nyeri" value="Nyeri Akut" class="text_dt" 
					' . (($nyeri == 'Nyeri Akut') ? 'checked="checked"' : '') . ' />&nbsp;Nyeri Akut</td>
				</tr>
				<tr>	
					<td>Skala Nyeri</td>
					<td>:&nbsp;<input type="checkbox" name="skala_nyeri" value="0" class="text_dt"' . (($skala_nyeri == '0') ? 'checked="checked"' : '') . ' />&nbsp;0
					<input type="checkbox" name="skala_nyeri" value="1" class="text_dt"' . (($skala_nyeri == '1') ? 'checked="checked"' : '') . ' />&nbsp;1
					<input type="checkbox" name="skala_nyeri" value="2" class="text_dt"' . (($skala_nyeri == '2') ? 'checked="checked"' : '') . ' />&nbsp;2
					<input type="checkbox" name="skala_nyeri" value="3" class="text_dt"' . (($skala_nyeri == '3') ? 'checked="checked"' : '') . ' />&nbsp;3
					<input type="checkbox" name="skala_nyeri" value="4" class="text_dt"' . (($skala_nyeri == '4') ? 'checked="checked"' : '') . ' />&nbsp;4
					<input type="checkbox" name="skala_nyeri" value="5" class="text_dt"' . (($skala_nyeri == '5') ? 'checked="checked"' : '') . ' />&nbsp;5
					<input type="checkbox" name="skala_nyeri" value="6" class="text_dt"' . (($skala_nyeri == '6') ? 'checked="checked"' : '') . ' />&nbsp;6
					<input type="checkbox" name="skala_nyeri" value="7" class="text_dt"' . (($skala_nyeri == '7') ? 'checked="checked"' : '') . ' />&nbsp;7
					<input type="checkbox" name="skala_nyeri" value="8" class="text_dt"' . (($skala_nyeri == '8') ? 'checked="checked"' : '') . ' />&nbsp;8
					<input type="checkbox" name="skala_nyeri" value="9" class="text_dt"' . (($skala_nyeri == '9') ? 'checked="checked"' : '') . ' />&nbsp;9
					<input type="checkbox" name="skala_nyeri" value="10" class="text_dt"' . (($skala_nyeri == '10') ? 'checked="checked"' : '') . ' />&nbsp;10</td>
				</tr>
				<tr>	
					<td>Lokasi</td>
					<td>:&nbsp;' . setGarisIfNull($lokasi_nyeri) . '</td>
				</tr>	
				<tr>	
					<td>Durasi</td>
					<td>:&nbsp;' . setGarisIfNull($durasi_nyeri) . '</td>
				</tr>
				<tr>	
					<td>Frekuensi</td>
					<td>:&nbsp;' . setGarisIfNull($frekuensi_nyeri) . '</td>
				</tr>
				<tr>	
					<td>Nyeri Hilang Bila</td>
					<td>:&nbsp;<input type="checkbox" name="nyeri_hilang" value="Minum Obat" class="text_dt" 
					' . (($nyeri_hilang == 'Minum Obat') ? 'checked="checked"' : '') . ' />&nbsp;Minum Obat
					<input type="checkbox" name="nyeri_hilang" value="Istirahat" class="text_dt" 
					' . (($nyeri_hilang == 'Istirahat') ? 'checked="checked"' : '') . ' />&nbsp;Istirahat
					<input type="checkbox" name="nyeri_hilang" value="Mendengar Musik" class="text_dt" 
					' . (($nyeri_hilang == 'Mendengar Musik') ? 'checked="checked"' : '') . '  />&nbsp;Mendengar Musik
					<input type="checkbox" name="nyeri_hilang" value="Berubah Posisi" class="text_dt" 
					' . (($nyeri_hilang == 'Berubah Posisi') ? 'checked="checked"' : '') . ' />&nbsp;Berubah Posisi/ Tidur
					<input type="checkbox" name="nyeri_hilang" value="Lain-lain" class="text_dt" 
					' . (($nyeri_hilang == 'Lain-lain') ? 'checked="checked"' : '') . ' />&nbsp;Lain-lain, Sebutkan ' . setGarisIfNull($keterangan_nyeri_hilang) . '</td>
				</tr>
				<tr>	
					<td>Diberitahukan Ke Dokter</td>
					<td>:&nbsp;<input type="checkbox" name="status_nyeri_hilang" value="Ya" class="text_dt" 
					' . (($status_nyeri_hilang == 'Ya') ? 'checked="checked"' : '') . ' />&nbsp;Ya, Pukul &nbsp; ' . setGarisIfNull($keterangan_status_nyeri_hilang) .'
					<input type="checkbox" name="status_nyeri_hilang" value="Tidak" class="text_dt" 
					' . (($status_nyeri_hilang == 'Tidak') ? 'checked="checked"' : '') . ' />&nbsp;Tidak</td>
				</tr>
				</table></td>
        </tr>
		<tr>
            <td valign="top">12.</td>
            <td valign="top">Riwayat Alergi Obat</td>
            <td colspan="3">:&nbsp;' . setGarisIfNull($riwayat_alergi_obat) . '</td>
        </tr>
        <tr>
            <td colspan="2" valign="top">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
        </tr>
    </table>';
	
	$edoc_content_3 = '<style>.tbl tr td {
   border: 1px solid black;
   padding-left:1px;
   border-collapse: collapse;
}</style><table width="100%" border="0" autosize="1" >
        <tr>
            <td colspan="2" valign="top">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
        </tr>
		<tr>
		  <td colspan="5" valign="top">
		    <table width="100%" border="1" cellspacing="0" class="tbl" cellpadding="0">
              <tr>
                <td width="50%" align="center" bgcolor="#CCCCCC" ><strong>Diagnosa Keperawatan</strong></td>
                <td width="50%" align="center" bgcolor="#CCCCCC" ><strong>Rencana Keperawatan</strong></td>
              </tr>
              <tr>
                <td>' . setGarisIfNull($diagnosa_keperawatan) . '</td>
                <td>' . setGarisIfNull($rencana_keperawatan) . '</td>
              </tr>
              <tr>
                <td>Tanggal &amp; Jam </td>
                <td>Nama &amp; Tandatangan</td>
              </tr>
			<tr>
				<td>:&nbsp;</td>
				<td>:&nbsp;</td>
			</tr>	
			<tr>
				<td style="border: 0px;">&nbsp;</td>
				<td style="border: 0px;">&nbsp;</td>
			</tr>	
              <tr>
                <td align="center" bgcolor="#CCCCCC" ><strong>Implementasi Keperawatan</strong></td>
                <td align="center" bgcolor="#CCCCCC" ><strong>Evaluasi Keperawatan</strong></td>
              </tr>
              <tr>
                <td>' . setGarisIfNull($implementasi_keperawatan) . '</td>
                <td>' . setGarisIfNull($evaluasi_keperawatan) . '</td>
              </tr>
              <tr>
                <td>Tanggal &amp; Jam</td>
                <td>Nama &amp; Tandatangan</td>
              </tr>
			  <tr>
                <td>:&nbsp;</td>
                <td>:&nbsp;</td>
              </tr>
            </table>
		  </td>
	  </tr>
        <tr>
            <td colspan="2" valign="top">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
        </tr>
    </table>';
	
	ob_start();
	include('edoc_rekammedik/edoc_frame_main_2.php');
	$html = ob_get_contents();
	ob_end_clean();
	
	ob_start();
	include('edoc_rekammedik/edoc_frame_add.php');
	$html_2 = ob_get_contents();
	ob_end_clean();
	
	ob_start();
	$edoc_content_2 = $edoc_content_3;
	include('edoc_rekammedik/edoc_frame_add.php');
	$html_3 = ob_get_contents();
	ob_end_clean();

	$mpdf->AddPage('P');
	$mpdf->WriteHTML($html);
	$mpdf->AddPage('P');
	$mpdf->WriteHTML($html_2);
	$mpdf->AddPage('P');
	$mpdf->WriteHTML($html_3);
}
//end Asuhan Keperawatan

//Pemberian Edukasi Pasien	
$edoc_nama_documen = strtoupper('Pemberian Edukasi Terintegrasi Pasien Dan Keluarga');

$qry_edukasi = 'SELECT HEMODIALISA_EDUKASI_ID,HAMBATAN_TIDAKADA,HAMBATAN_PENGLIHATAN,HAMBATAN_PENDENGARAN,HAMBATAN_EMOSIONAL,
					HAMBATAN_JASMANI,HAMBATAN_KEPERCAYAAN,HAMBATAN_BAHASA,HAMBATAN_PENDIDIKAN,HAMBATAN_MOTIVASI,HAMBATAN_PROSES_FIKIR,
					HAMBATAN_BUDAYA,HAMBATAN_LAINNYA,HAMBATAN_LAINNYA_KET,BICARA,AGAMA,AGAMA_KET,BAHASA_INDONESIA,BAHASA_INDONESIA_AKTIF_PASIF,
					BAHASA_DAERAH,BAHASA_DAERAH_KET,BAHASA_INGGRIS,BAHASA_INGGRIS_AKTIF_PASIF,BAHASA_LAINNYA,BAHASA_LAINNYA_KET,
					BUDAYA_PANTANGAN_MAKAN,BUDAYA_PANTANGAN_MAKAN_KET,BUDAYA_JAM_MAKAN,BUDAYA_JAM_MAKAN_KET,BUDAYA_LAINNYA,
					BUDAYA_LAINNYA_KET,BUDAYA_TIDAKADA,PENDIDIKAN,PENERJEMAH,PENERJEMAH_KET,BAHASA_ISARAT,BAHASA_ISARAT_KET,
					EMOSIONAL,EMOSIONAL_KET,MOTIVASI,MOTIVASI_KET,PEMBELAJARAN_PENYAKIT,PEMBELAJARAN_PENGOBATAN,PEMBELAJARAN_DIIT,
					PEMBELAJARAN_TERAPI,PEMBELAJARAN_ALATMEDIS,PEMBELAJARAN_NYERI,PEMBELAJARAN_REHABILITASI,PEMBELAJARAN_PERAWATAN,
					PEMBELAJARAN_LAINNYA,PEMBELAJARAN_LAINNYA_KET
					FROM t_hemodialisa_edukasi
					WHERE HEMODIALISA_EDUKASI_ID = "' . $idx . '"';
$qry_edukasi_detail = 'SELECT HEMODIALISA_EDUKASI_ID,ISI_EDUKASI_ID,DATE_FORMAT(TANGGAL,"%d/%m/%Y") AS TANGGAL,RUANGAN,TINGKAT_PEMAHAMAN,JAM_1,JAM_2,
					PROFESI,METODE,PENERIMA_PENDIDIKAN,EVALUASI_RESPONSE,PEMBERI_EDUKASI,PENERIMA_EDUKASI,
					PEMBERI_EDUKASI_2,PENERIMA_EDUKASI_2,ISI_EDUKASI_DES
					FROM t_hemodialisa_edukasi_detail
					WHERE HEMODIALISA_EDUKASI_ID = "' . $idx . '"';
$get_edukasi = mysql_query($qry_edukasi) or die(mysql_error());
if(mysql_num_rows($get_edukasi) > 0){
	$dat_edukasi = mysql_fetch_assoc($get_edukasi);	
	$hambatan_tidakada = $dat_edukasi['HAMBATAN_TIDAKADA'];
	$hambatan_penglihatan = $dat_edukasi['HAMBATAN_PENGLIHATAN'];
	$hambatan_pendengaran = $dat_edukasi['HAMBATAN_PENDENGARAN'];
	$hambatan_emosional = $dat_edukasi['HAMBATAN_EMOSIONAL'];
	$hambatan_jasmani = $dat_edukasi['HAMBATAN_JASMANI'];
	$hambatan_kepercayaan = $dat_edukasi['HAMBATAN_KEPERCAYAAN'];
	$hambatan_bahasa = $dat_edukasi['HAMBATAN_BAHASA'];
	$hambatan_pendidikan = $dat_edukasi['HAMBATAN_PENDIDIKAN'];
	$hambatan_motivasi = $dat_edukasi['HAMBATAN_MOTIVASI'];
	$hambatan_proses_fikir = $dat_edukasi['HAMBATAN_PROSES_FIKIR'];
	$hambatan_budaya = $dat_edukasi['HAMBATAN_BUDAYA'];
	$hambatan_lainnya = $dat_edukasi['HAMBATAN_LAINNYA'];
	$hambatan_lainnya_ket = $dat_edukasi['HAMBATAN_LAINNYA_KET'];
	$bicara = $dat_edukasi['BICARA'];
	$agama = $dat_edukasi['AGAMA'];
	$agama_ket = $dat_edukasi['AGAMA_KET'];
	$bahasa_indonesia = $dat_edukasi['BAHASA_INDONESIA'];
	$bahasa_indonesia_aktif_pasif = $dat_edukasi['BAHASA_INDONESIA_AKTIF_PASIF'];
	$bahasa_daerah = $dat_edukasi['BAHASA_DAERAH'];
	$bahasa_daerah_ket = $dat_edukasi['BAHASA_DAERAH_KET'];
	$bahasa_inggris = $dat_edukasi['BAHASA_INGGRIS'];
	$bahasa_inggris_aktif_pasif = $dat_edukasi['BAHASA_INGGRIS_AKTIF_PASIF'];
	$bahasa_lainnya = $dat_edukasi['BAHASA_LAINNYA'];
	$bahasa_lainnya_ket = $dat_edukasi['BAHASA_LAINNYA_KET'];
	$budaya_pantangan_makan = $dat_edukasi['BUDAYA_PANTANGAN_MAKAN'];
	$budaya_pantangan_makan_ket = $dat_edukasi['BUDAYA_PANTANGAN_MAKAN_KET'];
	$budaya_jam_makan = $dat_edukasi['BUDAYA_JAM_MAKAN'];
	$budaya_jam_makan_ket = $dat_edukasi['BUDAYA_JAM_MAKAN_KET'];
	$budaya_lainnya = $dat_edukasi['BUDAYA_LAINNYA'];
	$budaya_lainnya_ket = $dat_edukasi['BUDAYA_LAINNYA_KET'];
	$budaya_tidakada = $dat_edukasi['BUDAYA_TIDAKADA'];
	$pendidikan = $dat_edukasi['PENDIDIKAN'];
	$penerjemah = $dat_edukasi['PENERJEMAH'];
	$penerjemah_ket = $dat_edukasi['PENERJEMAH_KET'];
	$bahasa_isarat = $dat_edukasi['BAHASA_ISARAT'];
	$bahasa_isarat_ket = $dat_edukasi['BAHASA_ISARAT_KET'];
	$emosional = $dat_edukasi['EMOSIONAL'];
	$emosional_ket = $dat_edukasi['EMOSIONAL_KET'];
	$motivasi = $dat_edukasi['MOTIVASI'];
	$motivasi_ket = $dat_edukasi['MOTIVASI_KET'];
	$pembelajaran_penyakit = $dat_edukasi['PEMBELAJARAN_PENYAKIT'];
	$pembelajaran_pengobatan = $dat_edukasi['PEMBELAJARAN_PENGOBATAN'];
	$pembelajaran_diit = $dat_edukasi['PEMBELAJARAN_DIIT'];
	$pembelajaran_terapi = $dat_edukasi['PEMBELAJARAN_TERAPI'];
	$pembelajaran_alatmedis = $dat_edukasi['PEMBELAJARAN_ALATMEDIS'];
	$pembelajaran_nyeri = $dat_edukasi['PEMBELAJARAN_NYERI'];
	$pembelajaran_rehabilitasi = $dat_edukasi['PEMBELAJARAN_REHABILITASI'];
	$pembelajaran_perawatan = $dat_edukasi['PEMBELAJARAN_PERAWATAN'];
	$pembelajaran_lainnya = $dat_edukasi['PEMBELAJARAN_LAINNYA'];
	$pembelajaran_lainnya_ket = $dat_edukasi['PEMBELAJARAN_LAINNYA_KET'];		  

	$ruang_arr = array();
	$ruang_arr_id = array();
	$qry_ruang = 'SELECT m_unit.UNIT_ID,m_unit.NAMA_UNIT
					FROM m_unit
					WHERE m_unit.IRJA IS NOT NULL';
	$get_ruang = mysql_query($qry_ruang) or die(mysql_error());				
	while($dat_ruang = mysql_fetch_array($get_ruang)){
		$ruang_arr[] = $dat_ruang['NAMA_UNIT'];
		$ruang_arr_id[] = $dat_ruang['UNIT_ID'];
	}

	$jam = date('H');
	$menit = date('i');

	$isi_edu_arr[1] = 'Edukasi tentang pemasangan gelang identifikasi';
	$isi_edu_arr[2] = 'Edukasi tentang etika batuk, alergi, resiko jatuh, dan keselamatan pasien';
	$isi_edu_arr[3] = 'Informasi tentang penyimpanan barang berharga milik pasien';
	$isi_edu_arr[4] = 'Cuci tangan';
	$isi_edu_arr[5] = 'Personal hygiene';
	$isi_edu_arr[6] = 'Informasi tentang pelayanan kerohanian';
	$isi_edu_arr[7] = 'Informasi tentang hak pasien dan keluarga untuk berpatisipasi dalam rencana pelayanan dan pengobatan';
	$isi_edu_arr[8] = 'Informasi tentang hak pasien dan keluarga untuk berpatisipasi dalam keputusan pengobatan';
	$isi_edu_arr[9] = 'Informasi tentang cara penyampaian keluhan dan hak dalam ikut berpartisipasi menyelesaikan masalahnya';
	$isi_edu_arr[10] = 'Informasi tentang kerahasiaan informasi pasien di rekam medis dan pembukaannya (pelepasan informasi)';
	$isi_edu_arr[11] = 'Manajemen nyeri';
	$isi_edu_arr[12] = 'Kondisi kesehatan & diagnosis pasti';
	$isi_edu_arr[13] = 'Informasi tentang Second Opinion';
	$isi_edu_arr[14] = 'Informasi kepada pasien dan keluarga untuk diperbolehkan menolak pengobatan';
	$isi_edu_arr[15] = 'Informasi tentang alternatif pelayanan kesehatan';
	$isi_edu_arr[16] = 'Informasi tentang hasil pelayanan dan pengobatan';
	$isi_edu_arr[17] = 'Informasi tentang hasil yang tidak diantisipasi dalam pelayanan dan pengobatan';
	$isi_edu_arr[18] = 'Informasi tentang pemeriksaan penunjang diluar RSKS terkait hubungan, jenis dan kualitas pemeriksaan di tempat rujukan';
	$isi_edu_arr[19] = 'Keamanan dan efektifitas penggunaan peralatan medis';
	$isi_edu_arr[20] = 'Informed Consent tentang';
	$isi_edu_arr[21] = 'Informed Consent tentang';
	$isi_edu_arr[22] = 'Penggunaan obat-obatan, potensi efek samping obat dan pencegahan terhadap potensi interaksi obat OTC<br >(over the counter) dan obat- obatan yang dibawa pulang serta penyimpanannya';
	$isi_edu_arr[23] = 'Informasi dan edukasi tentang diit dan/ atau pembatasan diit pasien';
	$isi_edu_arr[24] = 'Tehnik Rehabilitasi tentang';
	$isi_edu_arr[25] = 'Perawatan luka';
	$isi_edu_arr[26] = 'Informasi dan edukasi tentang risiko, manfaat dan risiko anestesi oleh dokter anestesi';
	$isi_edu_arr[27] = 'Informasi dan edukasi tentang risiko, manfaat dan risiko prosedur bedah yang direncanakan yang dilakukan oleh dokter bedah';
	$isi_edu_arr[28] = 'Discharge planning';
	$isi_edu_arr[29] = 'Rujukan ke komunitas';
	$isi_edu_arr[30] = '';
	$isi_edu_arr[31] = '';
	$isi_edu_arr[32] = '';
	$isi_edu_arr[33] = '';
	$isi_edu_arr[34] = '';
	$isi_edu_arr[35] = '';
	$isi_edu_arr[36] = '';
	$isi_edu_arr[37] = '';
	$isi_edu_arr[38] = '';
	$isi_edu_arr[39] = '';
	$isi_edu_arr[40] = '';
	$isi_edu_arr[41] = '';

	$tanggal = array();
	$isi_edukasi = array();
	$isi_edukasi_des = array();
	$ruangan = array();
	$pemahaman = array();
	$jam_1 = array();
	$menit_1 = array();
	$jam_2 = array();
	$menit_2 = array();
	$profesi = array();
	$metode = array();
	$penerima = array();
	$evaluasi = array();
	$pemberi_edukasi = array();
	$pemberi_edukasi_2 = array();
	$penerima_edukasi = array();
	$penerima_edukasi_2 = array();

	$get_edukasi_detail = mysql_query($qry_edukasi_detail) or die(mysql_error());
	while ($dat_edukasi_detail = mysql_fetch_array($get_edukasi_detail)){
		$tanggal[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['TANGGAL'];
		$isi_edukasi[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['ISI_EDUKASI_ID'];
		$isi_edukasi_des[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['ISI_EDUKASI_DES'];
		$ruangan[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['RUANGAN'];
		$pemahaman[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['TINGKAT_PEMAHAMAN'];
		$jam_1_array = explode(':',$dat_edukasi_detail['JAM_1']);
		if(sizeof($jam_1_array) == 2){
			$jam_1[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $jam_1_array[0];
			$menit_1[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $jam_1_array[1];
		}
		$jam_2_array = explode(':',$dat_edukasi_detail['JAM_2']);
		if(sizeof($jam_2_array) == 2){	
			$jam_2[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $jam_2_array[0];
			$menit_2[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $jam_2_array[1];
		}	
		$profesi[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['PROFESI'];
		$metode[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['METODE'];
		$penerima[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['PENERIMA_PENDIDIKAN'];
		$evaluasi[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['EVALUASI_RESPONSE'];
		$pemberi_edukasi[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['PEMBERI_EDUKASI'];
		$pemberi_edukasi_2[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['PEMBERI_EDUKASI_2'];
		$penerima_edukasi[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['PENERIMA_EDUKASI'];
		$penerima_edukasi_2[$dat_edukasi_detail['ISI_EDUKASI_ID']] = $dat_edukasi_detail['PENERIMA_EDUKASI_2'];
	}
	
	$edoc_content = '<style>.tbl tr td {
	   border: 1px solid black;
	   padding-left:1px;
	   padding-bottom:1px;
	   border-collapse: collapse;
	}</style>
	<table border="0" width="100%" cellpadding="0" cellspacing="0" class="tbl" autosize="1" >
	<tr>
		<td width="250px">Kesediaan pasien dan keluarga untuk menerima</td>
		<td>
			<input type="radio" name="kesediaan" id="kesediaan" value="1" />&nbsp;Ya
			<input type="radio" name="kesediaan" id="kesediaan" value="2" />&nbsp;Tidak
		</td>
	</tr>
	<tr>
		<td width="250px">Hambatan Edukasi</td>
		<td>
			<input type="checkbox" name="hambatan_tidakada" id="hambatan_tidakada" value="1" ' . (($hambatan_tidakada=="1") ? 'checked="checked"' : '') . ' />&nbsp;Tidak ada hambatan
			<input type="checkbox" name="hambatan_penglihatan" id="hambatan_penglihatan" value="1" ' . (($hambatan_penglihatan=="1") ? 'checked="checked"' : '') . ' />&nbsp;Gangguan penglihatan
			<input type="checkbox" name="hambatan_pendengaran" id="hambatan_pendengaran" value="1"  ' . (($hambatan_pendengaran=="1") ? 'checked="checked"' : '') . ' />&nbsp;Gangguan pendengaran
			<input type="checkbox" name="hambatan_emosional" id="hambatan_emosional" value="1"  ' . (($hambatan_emosional=="1") ? 'checked="checked"' : '') . ' />&nbsp;Gangguan Emosional
			<input type="checkbox" name="hambatan_jasmani" id="hambatan_jasmani" value="1"  ' . (($hambatan_jasmani=="1") ? 'checked="checked"' : '') . ' />&nbsp;Batasan jasmani & kognitif<br />
			<input type="checkbox" name="hambatan_kepercayaan" id="hambatan_kepercayaan" value="1" ' . (($hambatan_kepercayaan=="1") ? 'checked="checked"' : '') . ' />&nbsp;Kepercayaan pasien & keluarga
			<input type="checkbox" name="hambatan_bahasa" id="hambatan_bahasa" value="1" ' . (($hambatan_bahasa=="1") ? 'checked="checked"' : '') . ' />&nbsp;Hambatan bahasa
			<input type="checkbox" name="hambatan_pendidikan" id="hambatan_pendidikan" value="1" ' . (($hambatan_pendidikan=="1") ? 'checked="checked"' : '') . ' />&nbsp;Tingkat pendidikan
			<input type="checkbox" name="hambatan_motivasi" id="hambatan_motivasi" value="1" ' . (($hambatan_motivasi=="1") ? 'checked="checked"' : '') . ' />&nbsp;Motivasi belajar
			<input type="checkbox" name="hambatan_proses_fikir" id="hambatan_proses_fikir" value="1" ' . (($hambatan_proses_fikir=="1") ? 'checked="checked"' : '') . ' />&nbsp;Gangguan proses fikir<br />
			<input type="checkbox" name="hambatan_budaya" id="hambatan_budaya" value="1" ' . (($hambatan_budaya=="1") ? 'checked="checked"' : '') . ' />&nbsp;Perbedaan budaya
			<input type="checkbox" name="hambatan_lainnya" id="hambatan_lainnya" value="1" ' . (($hambatan_lainnya=="1") ? 'checked="checked"' : '') . ' />&nbsp;Lainnya ' . setGarisIfNull($hambatan_lainnya_ket) . '
		</td>
	</tr>
	<tr>
		<td>Bicara</td>
		<td><input type="radio" name="bicara" id="bicara" value="1" ' . (($bicara=="1") ? 'checked="checked"' : '') . ' />&nbsp;Normal
		<input type="radio" name="bicara" id="bicara2" value="2" ' . (($bicara=="2") ? 'checked="checked"' : '') . ' />&nbsp;Ada hambatan</td>
	</tr>
	<tr>
		<td>Agama</td>
		<td>
			<input type="radio" name="agama" id="agama" value="1" ' . (($agama=="1") ? 'checked="checked"' : '') . ' />&nbsp;Islam
			<input type="radio" name="agama" id="agama2" value="2" ' . (($agama=="2") ? 'checked="checked"' : '') . ' />&nbsp;Katholik
			<input type="radio" name="agama" id="agama3" value="3" ' . (($agama=="3") ? 'checked="checked"' : '') . ' />&nbsp;Protestan
			<input type="radio" name="agama" id="agama4" value="4" ' . (($agama=="4") ? 'checked="checked"' : '') . ' />&nbsp;Budha
			<input type="radio" name="agama" id="agama5" value="5" ' . (($agama=="5") ? 'checked="checked"' : '') . ' />&nbsp;Hindu
			<input type="radio" name="agama" id="agama6" value="6" ' . (($agama=="6") ? 'checked="checked"' : '') . ' />&nbsp;Lainnya ' . setGarisIfNull($agama_ket) . '</td>
	</tr>
	<tr>
		<td>Nilai/ budaya yang dianut</td>
		<td>
			<input type="checkbox" name="budaya_pantangan_makan" id="budaya_pantangan_makan" value="1" ' . (($budaya_pantangan_makan=="1") ? 'checked="checked"' : '') . ' />&nbsp;Pantangan makanan ' . setGarisIfNull($budaya_pantangan_makan_ket) . '<br />
			<input type="checkbox" name="budaya_jam_makan" id="budaya_jam_makan" value="1" ' . (($budaya_jam_makan=="1") ? 'checked="checked"' : '') . ' />&nbsp;Jam makan ' . setGarisIfNull($budaya_jam_makan_ket) . '<br />
			<input type="checkbox" name="budaya_lainnya" id="budaya_lainnya" value="1" ' . (($budaya_lainnya=="1") ? 'checked="checked"' : '') . ' />&nbsp;Lainnya ' . setGarisIfNull($budaya_lainnya_ket) . '<br />
			<input type="checkbox" name="budaya_tidakada" id="budaya_tidakada" value="1" ' . (($budaya_tidakada=="1") ? 'checked="checked"' : '') . ' />&nbsp;Tidak ada
			</td>
	</tr>
	<tr>
		<td>Bahasa sehari-hari</td>
		<td>
			<input type="checkbox" name="bahasa_indonesia" id="bahasa_indonesia" value="1" ' . (($bahasa_indonesia=="1") ? 'checked="checked"' : '') . ' />&nbsp;Indonesia
			<input type="radio" name="bahasa_indonesia_aktif_pasif" id="bahasa_indonesia_aktif_pasif" value="1" ' . (($bahasa_indonesia_aktif_pasif=="1") ? 'checked="checked"' : '') . ' />&nbsp;Aktif
			<input type="radio" name="bahasa_indonesia_aktif_pasif" id="bahasa_indonesia_aktif_pasif2" value="2" ' . (($bahasa_indonesia_aktif_pasif=="2") ? 'checked="checked"' : '') . ' />&nbsp;Pasif<br />
			<input type="checkbox" name="bahasa_daerah" id="bahasa_daerah" value="1" ' . (($bahasa_daerah=="1") ? 'checked="checked"' : '') . ' />&nbsp;Daerah ' . setGarisIfNull($bahasa_daerah_ket) . '<br />
			<input type="checkbox" name="bahasa_inggris" id="bahasa_inggris" value="1" ' . (($bahasa_inggris=="1") ? 'checked="checked"' : '') . ' />&nbsp;Inggris
			<input type="radio" name="bahasa_inggris_aktif_pasif" id="bahasa_inggris_aktif_pasif" value="1" ' . (($bahasa_inggris_aktif_pasif=="1") ? 'checked="checked"' : '') . ' />&nbsp;Aktif
			<input type="radio" name="bahasa_inggris_aktif_pasif" id="bahasa_inggris_aktif_pasif2" value="2" ' . (($bahasa_inggris_aktif_pasif=="2") ? 'checked="checked"' : '') . ' />&nbsp;Pasif<br />
			<input type="checkbox" name="bahasa_lainnya" id="bahasa_lainnya" value="1" ' . (($bahasa_lainnya=="1") ? 'checked="checked"' : '') . ' />&nbsp;Lainnya ' . setGarisIfNull($bahasa_lainnya_ket) . '</td>
	</tr>
	<tr>
		<td>Tingkat pendidikan</td>
			<td>
			<input type="radio" name="pendidikan" id="pendidikan" value="1" ' . (($pendidikan=="1") ? 'checked="checked"' : '') . ' />&nbsp;SD
			<input type="radio" name="pendidikan" id="pendidikan2" value="2" ' . (($pendidikan=="2") ? 'checked="checked"' : '') . ' />&nbsp;SMP
			<input type="radio" name="pendidikan" id="pendidikan3" value="3" ' . (($pendidikan=="3") ? 'checked="checked"' : '') . ' />&nbsp;SMA
			<input type="radio" name="pendidikan" id="pendidikan4" value="4" ' . (($pendidikan=="4") ? 'checked="checked"' : '') . ' />&nbsp;Diploma
			<input type="radio" name="pendidikan" id="pendidikan5" value="5" ' . (($pendidikan=="5") ? 'checked="checked"' : '') . ' />&nbsp;S1
			<input type="radio" name="pendidikan" id="pendidikan6" value="6" ' . (($pendidikan=="6") ? 'checked="checked"' : '') . ' />&nbsp;S2/ S3
			</td>
	</tr>
	<tr>
		<td>Perlu penerjemah</td>
			<td>
			<input type="radio" name="penerjemah" id="penerjemah" value="1" ' . (($penerjemah=="1") ? 'checked="checked"' : '') . ' />&nbsp;Tidak
			<input type="radio" name="penerjemah" id="penerjemah2" value="2" ' . (($penerjemah=="2") ? 'checked="checked"' : '') . ' />&nbsp;Ya ' . setGarisIfNull($penerjemah_ket) . '
			</td>
	</tr>
	<tr>
		<td>Bahasa isarat</td>
		<td>
		<input type="radio" name="bahasa_isarat" id="bahasa_isarat" value="1" ' . (($bahasa_isarat=="1") ? 'checked="checked"' : '') . ' />&nbsp;Tidak
		<input type="radio" name="bahasa_isarat" id="bahasa_isarat2" value="2" ' . (($bahasa_isarat=="2") ? 'checked="checked"' : '') . ' />&nbsp;Ya ' . setGarisIfNull($bahasa_isarat_ket) . '
		</td>
	</tr>
	<tr>
		<td>Hambatan emosional</td>
		<td>
		<input type="radio" name="emosional" id="emosional" value="1" ' . (($emosional=="1") ? 'checked="checked"' : '') . ' />&nbsp;Tidak
		<input type="radio" name="emosional" id="emosional2" value="2" ' . (($emosional=="2") ? 'checked="checked"' : '') . ' />&nbsp;Ya ' . setGarisIfNull($emosional_ket) . '
		</td>
	</tr>
	<tr>
		<td>Hambatan didalam motivasi</td>
		<td>
		<input type="radio" name="motivasi" id="motivasi" value="1" ' . (($motivasi=="1") ? 'checked="checked"' : '') . ' />&nbsp;Tidak
		<input type="radio" name="motivasi" id="motivasi2" value="2" ' . (($motivasi=="2") ? 'checked="checked"' : '') . ' />&nbsp;Ya ' . setGarisIfNull($motivasi_ket) . '
		</td>
	</tr>
	<tr>
		<td>Potensial kebutuhan pembelajaran</td>
		<td>
		<input type="checkbox" name="pembelajaran_penyakit" id="pembelajaran_penyakit" value="1" ' . (($pembelajaran_penyakit=="1") ? 'checked="checked"' : '') . ' />&nbsp;Proses penyakit
		<input type="checkbox" name="pembelajaran_pengobatan" id="pembelajaran_pengobatan" value="1" ' . (($pembelajaran_pengobatan=="1") ? 'checked="checked"' : '') . ' />&nbsp;Pengobatan/ tindakan
		<input type="checkbox" name="pembelajaran_diit" id="pembelajaran_diit" value="1" ' . (($pembelajaran_diit=="1") ? 'checked="checked"' : '') . ' />&nbsp;Diit & nutrisi
		<input type="checkbox" name="pembelajaran_terapi" id="pembelajaran_terapi" value="1" ' . (($pembelajaran_terapi=="1") ? 'checked="checked"' : '') . ' />&nbsp;Terapi/ obat/ interaksi obat
		<input type="checkbox" name="pembelajaran_alatmedis" id="pembelajaran_alatmedis" value="1" ' . (($pembelajaran_alatmedis=="1") ? 'checked="checked"' : '') . ' />&nbsp;Penggunaan peralatan medis<br />
		<input type="checkbox" name="pembelajaran_nyeri" id="pembelajaran_nyeri" value="1" ' . (($pembelajaran_nyeri=="1") ? 'checked="checked"' : '') . ' />&nbsp;Manajemen nyeri
		<input type="checkbox" name="pembelajaran_rehabilitasi" id="pembelajaran_rehabilitasi" value="1" ' . (($pembelajaran_rehabilitasi=="1") ? 'checked="checked"' : '') . ' />&nbsp;Tehnik rehabilitasi
		<input type="checkbox" name="pembelajaran_perawatan" id="pembelajaran_perawatan" value="1" ' . (($pembelajaran_perawatan=="1") ? 'checked="checked"' : '') . ' />&nbsp;Perawatan di rumah<br />
		<input type="checkbox" name="pembelajaran_lainnya" id="pembelajaran_lainnya" value="1" ' . (($pembelajaran_lainnya=="1") ? 'checked="checked"' : '') . ' />&nbsp;Lainnya ' . setGarisIfNull($pembelajaran_lainnya_ket) . '</td>
	</tr>
	</table>';
	
	ob_start();
	include('edoc_rekammedik/edoc_frame_main.php');
	$html = ob_get_contents();
	ob_end_clean();
	$mpdf->AddPage('L'); 
	$mpdf->WriteHTML($html);
	
	$edoc_first = '<style>.tbl tr td {
	   border: 1px solid black;
	   padding-left:1px;
	   border-collapse: collapse;
	}</style>
	<table width="100%" class="tbl" cellpadding="0" cellspacing="0" autosize="1" >
	<tr>
		<td rowspan="2" width="100px" align="center" bgcolor="#CCCCCC" ><strong>Tanggal</strong></td>
		<td rowspan="2" width="280px" align="center" bgcolor="#CCCCCC" ><strong>Isi Edukasi</strong></td>
		<td colspan="3" rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Ruangan, Tingkat Pemahaman<br />Lama Edukasi</strong></td>
		<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Profesi</strong></td>
		<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Metode</strong></td>
		<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Penerima<br />Pendidikan</strong></td>
		<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Evaluasi<br />Response</strong></td>
		<td colspan="2" align="center" bgcolor="#CCCCCC" ><strong>Nama &amp; Tandatangan</strong></td>
	</tr>
	<tr>
	  <th align="center" bgcolor="#CCCCCC" ><strong>Pemberi<br />Edukasi</strong></th>
      <th align="center" bgcolor="#CCCCCC" ><strong>Penerima<br />Edukasi</strong></th>
  </tr>';
	$edoc_end = '</table>';
	
	$edoc_main = '';
	$x = 1;
	$y = 1;
	while($x <= 41){
		$edoc_main = $edoc_main . '<tr>
								<td rowspan="2">' . $tanggal[$x] . '</td>
								<td rowspan="2"><input type="checkbox" name="isi_edukasi" ' . ((isset($isi_edukasi[$x])) ? 'checked="checked"' : '') . '/>';
								 if(($x == 20) or ($x == 21) or ($x == 24) or ($x == 20) or ($x > 29)){ 
										if(isset($isi_edukasi[$x])){
											$edoc_main = $edoc_main . $isi_edukasi_des[$x]; 
										}else{ 
											$edoc_main = $edoc_main . $isi_edu_arr[$x]; 
										}	
								  }else{
									  $edoc_main = $edoc_main . $isi_edu_arr[$x];
								  }	  
		$edoc_main = $edoc_main . '</td>
								<td rowspan="2">';
								$i = 0;
								while($i < sizeof($ruang_arr)){
									if(isset($isi_edukasi[$x])){
										if($ruang_arr_id[$i] == $ruangan[$x]) $edoc_main = $edoc_main . setGarisIfNull($ruang_arr[$i]);
									} 
								$i++; }
		$edoc_main = $edoc_main . '</td>
								<td rowspan="2">';
								if(isset($isi_edukasi[$x]) and ($pemahaman[$x] == '1')) $edoc_main = $edoc_main . 'Edukasi Pertama';
								if(isset($isi_edukasi[$x]) and ($pemahaman[$x] == '2')) $edoc_main = $edoc_main . 'Re-Edukasi ke 2, ke 3 atau lebih';
		$edoc_main = $edoc_main . '</td><td>'; 
				
				if(isset($isi_edukasi[$x])) {
					$edoc_main = $edoc_main . $jam_1[$x] . ':' . $menit_1[$x];
				}
		$edoc_main = $edoc_main . '</td>
								<td rowspan="2">';
			if(isset($isi_edukasi[$x])) $edoc_main = $edoc_main . $profesi[$x];
		$edoc_main = $edoc_main . '</td>
								<td rowspan="2">';
			if(isset($isi_edukasi[$x]) and ($metode[$x] == '1')) $edoc_main = $edoc_main . 'Diskusi';
			if(isset($isi_edukasi[$x]) and ($metode[$x] == '2')) $edoc_main = $edoc_main . 'Peragaan';
			if(isset($isi_edukasi[$x]) and ($metode[$x] == '3')) $edoc_main = $edoc_main . 'Selebaran';
			if(isset($isi_edukasi[$x]) and ($metode[$x] == '4')) $edoc_main = $edoc_main . 'Audio Visual';
		$edoc_main = $edoc_main . '</td>
								<td rowspan="2">';	
			if(isset($isi_edukasi[$x]) and ($penerima[$x] == '1')) $edoc_main = $edoc_main . 'Pasien';
			if(isset($isi_edukasi[$x]) and ($penerima[$x] == '2')) $edoc_main = $edoc_main . 'Suami';
			if(isset($isi_edukasi[$x]) and ($penerima[$x] == '3')) $edoc_main = $edoc_main . 'Isteri';
			if(isset($isi_edukasi[$x]) and ($penerima[$x] == '4')) $edoc_main = $edoc_main . 'Ayah';
			if(isset($isi_edukasi[$x]) and ($penerima[$x] == '5')) $edoc_main = $edoc_main . 'Ibu';
			if(isset($isi_edukasi[$x]) and ($penerima[$x] == '6')) $edoc_main = $edoc_main . 'Anak laki-laki';
			if(isset($isi_edukasi[$x]) and ($penerima[$x] == '7')) $edoc_main = $edoc_main . 'Anak perempuan';
			if(isset($isi_edukasi[$x]) and ($penerima[$x] == '8')) $edoc_main = $edoc_main . 'Lain-lain';
		$edoc_main = $edoc_main . '</td>
								<td rowspan="2">';	
			if(isset($isi_edukasi[$x]) and ($evaluasi[$x] == '1')) $edoc_main = $edoc_main . 'Tidak respon sama sekali (tidak antusia dlm belajar)';
			if(isset($isi_edukasi[$x]) and ($evaluasi[$x] == '2')) $edoc_main = $edoc_main . 'Tidak paham (ingin belajar tap kesulitan mengerti)';
			if(isset($isi_edukasi[$x]) and ($evaluasi[$x] == '3')) $edoc_main = $edoc_main . 'Paham hal yang diajarkan, tapi tdk bisa menjelaskan';
			if(isset($isi_edukasi[$x]) and ($evaluasi[$x] == '4')) $edoc_main = $edoc_main . 'Dapat menjelaskan, tetapi harus dibantu edukator';
			if(isset($isi_edukasi[$x]) and ($evaluasi[$x] == '5')) $edoc_main = $edoc_main . 'Dapat menjelaskan tanpa dibantu edukator';
		$edoc_main = $edoc_main . '</td><td>';	
			if(isset($isi_edukasi[$x])) $edoc_main = $edoc_main . $pemberi_edukasi[$x];
		$edoc_main = $edoc_main . '</td><td>';		
			if(isset($isi_edukasi[$x])) $edoc_main = $edoc_main . $pemberi_edukasi_2[$x];
		$edoc_main = $edoc_main . '</td></tr>
								<tr><td width="105px">';	
			if(isset($isi_edukasi[$x])) {
					$edoc_main = $edoc_main . $jam_2[$x] . ':' . $menit_2[$x];
				}							
		$edoc_main = $edoc_main . '</td><td>';
			if(isset($isi_edukasi[$x])) $edoc_main = $edoc_main . $penerima_edukasi[$x];
		$edoc_main = $edoc_main . '</td><td>';
			if(isset($isi_edukasi[$x])) $edoc_main = $edoc_main . $penerima_edukasi_2[$x];	
		$edoc_main = $edoc_main . '</td></tr>';

			if($y == 12){
				$edoc_content_2 = $edoc_first . $edoc_main . $edoc_end;
				$edoc_main = '';
				$y = 0;
				ob_start();
				include('edoc_rekammedik/edoc_frame_add.php');
				$html = ob_get_contents();
				ob_end_clean();
				$mpdf->AddPage('L'); 
				$mpdf->WriteHTML($html);
			}
			$y++;				
	$x++; 
	} 
	
	if($edoc_main != ''){
			$edoc_content_2 = $edoc_first . $edoc_main . $edoc_end;
			ob_start();
			include('edoc_rekammedik/edoc_frame_add.php');
			$html = ob_get_contents();
			ob_end_clean();
			$mpdf->AddPage('L'); 
			$mpdf->WriteHTML($html);	
	}					
}
//end Pemberian Edukasi Pasien

//Rencana Pemulangan
$edoc_nama_documen = strtoupper('Rencana Pemulangan Pasien');

$qry_pemulangan = 'SELECT HEMODIALISA_RENCANA_PULANG_ID,OBAT_LANJUT_NAMA,OBAT_LANJUT_JUMLAH,OBAT_LANJUT_WAKTU,OBAT_LANJUT_CARA,LINGKUNGAN_AIR_BERSIH,
					LINGKUNGAN_VENTILASI,LINGKUNGAN_FASILITAS,LINGKUNGAN_KETERAMPILAN_RAWAT_LUKA,LINGKUNGAN_KETERAMPILAN_INJEKSI,
					LINGKUNGAN_KETERAMPILAN_PERAWATAN_BAYI,LINGKUNGAN_KETERAMPILAN_LAINNYA,LINGKUNGAN_KETERAMPILAN_LAINNYA_KET,LINGKUNGAN_FASKES,
					HOME_CARE_MAKAN,HOME_CARE_MINUM,HOME_CARE_MANDI,HOME_CARE_BAK,HOME_CARE_BAB,HOME_CARE_BERPAKAIAN,HOME_CARE_ALATBANTU_TONGKAT,
					HOME_CARE_ALATBANTU_KURSI,HOME_CARE_ALATBANTU_WALKER,HOME_CARE_ALATMEDIS_KATETERURINE,HOME_CARE_ALATMEDIS_NGT,
					HOME_CARE_ALATMEDIS_OKSIGEN,HOME_CARE_ALATMEDIS_LAINNYA,HOME_CARE_ALATMEDIS_LAINNYA_KET,EDUKASI_OBAT,EDUKASI_NYERI,EDUKASI_DIET,
					EDUKASI_CARITOLONG,EDUKASI_PERAWATAN,EDUKASI_LAINNYA,EDUKASI_LAINNYA_KET,FASKES_PUSKESMAS,FASKES_RS,FASKES_KLINIK,
					FASKES_DOKTER_KELUARGA,FASKES_RUMAH_RAWAT,FASKES_BIDAN_PRAKTEK,FASKES_LAINNYA,FASKES_LAINNYA_KET,DIET_JENIS,DIET_JUMLAH,
					DIET_WAKTU,TRANSPORTASI_AMBULANCE,TRANSPORTASI_PRIBADI,TRANSPORTASI_UMUM,YAYASAN_JANTUNG,YAYASAN_STROKE,YAYASAN_LAINNYA,
					YAYASAN_LAINNYA_KET,RENCANA_TINDAK_LANJUT
					FROM t_hemodialisa_rencana_pulang
					WHERE HEMODIALISA_RENCANA_PULANG_ID = "' . $idx . '"';
$get_pemulangan = mysql_query($qry_pemulangan) or die(mysql_error());
if(mysql_num_rows($get_pemulangan) > 0){
	$dat_pemulangan = mysql_fetch_assoc($get_pemulangan);
	
	$obat_lanjut_nama = $dat_pemulangan['OBAT_LANJUT_NAMA'];
	$obat_lanjut_jumlah = $dat_pemulangan['OBAT_LANJUT_JUMLAH'];
	$obat_lanjut_waktu = $dat_pemulangan['OBAT_LANJUT_WAKTU'];
	$obat_lanjut_cara = $dat_pemulangan['OBAT_LANJUT_CARA'];
	$lingkungan_air_bersih = $dat_pemulangan['LINGKUNGAN_AIR_BERSIH'];
	$lingkungan_ventilasi = $dat_pemulangan['LINGKUNGAN_VENTILASI'];
	$lingkungan_fasilitas = $dat_pemulangan['LINGKUNGAN_FASILITAS'];
	$lingkungan_keterampilan_rawat_luka = $dat_pemulangan['LINGKUNGAN_KETERAMPILAN_RAWAT_LUKA'];
	$lingkungan_keterampilan_injeksi = $dat_pemulangan['LINGKUNGAN_KETERAMPILAN_INJEKSI'];
	$lingkungan_keterampilan_perawatan_bayi = $dat_pemulangan['LINGKUNGAN_KETERAMPILAN_PERAWATAN_BAYI'];
	$lingkungan_keterampilan_lainnya = $dat_pemulangan['LINGKUNGAN_KETERAMPILAN_LAINNYA'];
	$lingkungan_keterampilan_lainnya_ket = $dat_pemulangan['LINGKUNGAN_KETERAMPILAN_LAINNYA_KET'];
	$lingkungan_faskes = $dat_pemulangan['LINGKUNGAN_FASKES'];
	$home_care_makan = $dat_pemulangan['HOME_CARE_MAKAN'];
	$home_care_minum = $dat_pemulangan['HOME_CARE_MINUM'];
	$home_care_mandi = $dat_pemulangan['HOME_CARE_MANDI'];
	$home_care_bak = $dat_pemulangan['HOME_CARE_BAK'];
	$home_care_bab = $dat_pemulangan['HOME_CARE_BAB'];
	$home_care_berpakaian = $dat_pemulangan['HOME_CARE_BERPAKAIAN'];
	$home_care_alatbantu_tongkat = $dat_pemulangan['HOME_CARE_ALATBANTU_TONGKAT'];
	$home_care_alatbantu_kursi = $dat_pemulangan['HOME_CARE_ALATBANTU_KURSI'];
	$home_care_alatbantu_walker = $dat_pemulangan['HOME_CARE_ALATBANTU_WALKER'];
	$home_care_alatmedis_kateterurine = $dat_pemulangan['HOME_CARE_ALATMEDIS_KATETERURINE'];
	$home_care_alatmedis_ngt = $dat_pemulangan['HOME_CARE_ALATMEDIS_NGT'];
	$home_care_alatmedis_oksigen = $dat_pemulangan['HOME_CARE_ALATMEDIS_OKSIGEN'];
	$home_care_alatmedis_lainnya = $dat_pemulangan['HOME_CARE_ALATMEDIS_LAINNYA'];
	$home_care_alatmedis_lainnya_ket = $dat_pemulangan['HOME_CARE_ALATMEDIS_LAINNYA_KET'];
	$edukasi_obat = $dat_pemulangan['EDUKASI_OBAT'];
	$edukasi_nyeri = $dat_pemulangan['EDUKASI_NYERI'];
	$edukasi_diet = $dat_pemulangan['EDUKASI_DIET'];
	$edukasi_caritolong = $dat_pemulangan['EDUKASI_CARITOLONG'];
	$edukasi_perawatan = $dat_pemulangan['EDUKASI_PERAWATAN'];
	$edukasi_lainnya = $dat_pemulangan['EDUKASI_LAINNYA'];
	$edukasi_lainnya_ket = $dat_pemulangan['EDUKASI_LAINNYA_KET'];
	$faskes_puskesmas = $dat_pemulangan['FASKES_PUSKESMAS'];
	$faskes_rs = $dat_pemulangan['FASKES_RS'];
	$faskes_klinik = $dat_pemulangan['FASKES_KLINIK'];
	$faskes_dokter_keluarga = $dat_pemulangan['FASKES_DOKTER_KELUARGA'];
	$faskes_rumah_rawat = $dat_pemulangan['FASKES_RUMAH_RAWAT'];
	$faskes_bidan_praktek = $dat_pemulangan['FASKES_BIDAN_PRAKTEK'];
	$faskes_lainnya = $dat_pemulangan['FASKES_LAINNYA'];
	$faskes_lainnya_ket = $dat_pemulangan['FASKES_LAINNYA_KET'];
	$diet_jenis = $dat_pemulangan['DIET_JENIS'];
	$diet_jumlah = $dat_pemulangan['DIET_JUMLAH'];
	$diet_waktu = $dat_pemulangan['DIET_WAKTU'];
	$transportasi_ambulance = $dat_pemulangan['TRANSPORTASI_AMBULANCE'];
	$transportasi_pribadi = $dat_pemulangan['TRANSPORTASI_PRIBADI'];
	$transportasi_umum = $dat_pemulangan['TRANSPORTASI_UMUM'];
	$yayasan_jantung = $dat_pemulangan['YAYASAN_JANTUNG'];
	$yayasan_stroke = $dat_pemulangan['YAYASAN_STROKE'];
	$yayasan_lainnya = $dat_pemulangan['YAYASAN_LAINNYA'];
	$yayasan_lainnya_ket = $dat_pemulangan['YAYASAN_LAINNYA_KET'];
	$rencana_tindak_lanjut = $dat_pemulangan['RENCANA_TINDAK_LANJUT'];

	$edoc_content = '<table width="100%" cellpadding="0" cellspacing="0" autosize="1" >
		<tr>
			<td colspan="4">&nbsp;</td>
			<td align="center" width="75px">&nbsp;</td>
			<td align="center" width="75px">&nbsp;</td>
			</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
			<td align="center" >Ya</td>
			<td align="center" >Tidak</td>
		</tr>
		<tr>
			<td colspan="6">1. Bagaimana pasien dan keluarga mengetahui tentang obat yang harus dilanjutkan di rumah ?</td>
		</tr>
		<tr>
			<td width="80px">&nbsp;</td>
			<td colspan="3">a. Nama obatnya</td>
			<td align="center"><input type="radio" name="obat_lanjut_nama" id="obat_lanjut_nama" value="1" ' . (($obat_lanjut_nama=='1') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="radio" name="obat_lanjut_nama" id="obat_lanjut_nama2" value="2" ' . (($obat_lanjut_nama=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">b. Jumlahnya</td>
		<td align="center"><input type="radio" name="obat_lanjut_jumlah" id="obat_lanjut_jumlah" value="1" ' . (($obat_lanjut_jumlah=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="obat_lanjut_jumlah" id="obat_lanjut_jumlah2" value="2" ' . (($obat_lanjut_jumlah=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">c. Waktu pemberiannya</td>
		<td align="center"><input type="radio" name="obat_lanjut_waktu" id="obat_lanjut_waktu" value="1" ' . (($obat_lanjut_waktu=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="obat_lanjut_waktu" id="obat_lanjut_waktu2" value="2" ' . (($obat_lanjut_waktu=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">d. Cara pemberiannya</td>
		<td align="center"><input type="radio" name="obat_lanjut_cara" id="obat_lanjut_cara" value="1" ' . (($obat_lanjut_cara=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="obat_lanjut_cara" id="obat_lanjut_cara2" value="2" ' . (($obat_lanjut_cara=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td colspan="6">2. Bagaimana pasien mengetahui tentang lingkungan yang aman dan nyaman di rumah setelah keluar dari rumah sakit ?</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">a. Air bersih</td>
		<td align="center"><input type="radio" name="lingkungan_air_bersih" id="lingkungan_air_bersih" value="1" ' . (($lingkungan_air_bersih=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="lingkungan_air_bersih" id="lingkungan_air_bersih2" value="2" ' . (($lingkungan_air_bersih=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">b. Ventilasi udara yang cukup</td>
		<td align="center"><input type="radio" name="lingkungan_ventilasi" id="lingkungan_ventilasi" value="1" ' . (($lingkungan_ventilasi=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="lingkungan_ventilasi" id="lingkungan_ventilasi2" value="2" ' . (($lingkungan_ventilasi=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">c. Fasilitas dan peralatan yang dibutuhkan sesuai dengan kondisi pasien</td>
		<td align="center"><input type="radio" name="lingkungan_fasilitas" id="lingkungan_fasilitas" value="1" ' . (($lingkungan_fasilitas=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="lingkungan_fasilitas" id="lingkungan_fasilitas2" value="2" ' . (($lingkungan_fasilitas=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="5">d. Keterampilan Khusus</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<td colspan="2">1. Perawatan Luka</td>
		<td align="center"><input type="radio" name="lingkungan_keterampilan_rawat_luka" id="lingkungan_keterampilan_rawat_luka" value="1" ' . (($lingkungan_keterampilan_rawat_luka=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="lingkungan_keterampilan_rawat_luka" id="lingkungan_keterampilan_rawat_luka2" value="2" ' . (($lingkungan_keterampilan_rawat_luka=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<td colspan="2">2. Injeksi</td>
		<td align="center"><input type="radio" name="lingkungan_keterampilan_injeksi" id="lingkungan_keterampilan_injeksi" value="1" ' . (($lingkungan_keterampilan_injeksi=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="lingkungan_keterampilan_injeksi" id="lingkungan_keterampilan_injeksi2" value="2" ' . (($lingkungan_keterampilan_injeksi=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<td colspan="2">3. Perawatan bayi</td>
		<td align="center"><input type="radio" name="lingkungan_keterampilan_perawatan_bayi" id="lingkungan_keterampilan_perawatan_bayi" value="1" ' . (($lingkungan_keterampilan_perawatan_bayi=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="lingkungan_keterampilan_perawatan_bayi" id="lingkungan_keterampilan_perawatan_bayi2" value="2" ' . (($lingkungan_keterampilan_perawatan_bayi=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<td colspan="2">4. Lainnya ' . setGarisIfNull($lingkungan_keterampilan_lainnya_ket) . '</td>
		<td align="center"><input type="radio" name="lingkungan_keterampilan_lainnya" id="lingkungan_keterampilan_lainnya" value="1" ' . (($lingkungan_keterampilan_lainnya=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="lingkungan_keterampilan_lainnya" id="lingkungan_keterampilan_lainnya2" value="2" ' . (($lingkungan_keterampilan_lainnya=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">e. Fasilitas kesehatan yang dekat dari rumah</td>
		<td align="center">
		<input type="radio" name="lingkungan_faskes" id="lingkungan_faskes" value="1" ' . (($lingkungan_faskes=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center">
		<input type="radio" name="lingkungan_faskes" id="lingkungan_faskes2" value="2" ' . (($lingkungan_faskes=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td colspan="6">3. Bagaimana pasien dan keluarga memerlukan bantuan/ perawatn khusus di rumah setelah keluar<br />dari rumah sakit (home care/ home visite) ?</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">a. Makan</td>
		<td align="center"><input type="radio" name="home_care_makan" id="home_care_makan" value="1" ' . (($home_care_makan=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_makan" id="home_care_makan2" value="2" ' . (($home_care_makan=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">b. Minum</td>
		<td align="center"><input type="radio" name="home_care_minum" id="home_care_minum" value="1" ' . (($home_care_minum=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_minum" id="home_care_minum2" value="2" ' . (($home_care_minum=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">c. Mandi</td>
		<td align="center"><input type="radio" name="home_care_mandi" id="home_care_mandi" value="1" ' . (($home_care_mandi=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_mandi" id="home_care_mandi2" value="2" ' . (($home_care_mandi=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">d. BAK</td>
		<td align="center"><input type="radio" name="home_care_bak" id="home_care_bak" value="1" ' . (($home_care_bak=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_bak" id="home_care_bak2" value="2" ' . (($home_care_bak=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">e. BAB</td>
		<td align="center"><input type="radio" name="home_care_bab" id="home_care_bab" value="1" ' . (($home_care_bab=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_bab" id="home_care_bab2" value="2" ' . (($home_care_bab=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">f. Berpakaian</td>
		<td align="center"><input type="radio" name="home_care_berpakaian" id="home_care_berpakaian" value="1" ' . (($home_care_berpakaian=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_berpakaian" id="home_care_berpakaian2" value="2" ' . (($home_care_berpakaian=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="5">g. Alat Bantu</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<td colspan="2">1. Tongkat</td>
		<td align="center"><input type="radio" name="home_care_alatbantu_tongkat" id="home_care_alatbantu_tongkat" value="1" ' . (($home_care_alatbantu_tongkat=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_alatbantu_tongkat" id="home_care_alatbantu_tongkat2" value="2" ' . (($home_care_alatbantu_tongkat=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<td colspan="2">2. Kursi</td>
		<td align="center"><input type="radio" name="home_care_alatbantu_kursi" id="home_care_alatbantu_kursi" value="1" ' . (($home_care_alatbantu_kursi=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_alatbantu_kursi" id="home_care_alatbantu_kursi2" value="2" ' . (($home_care_alatbantu_kursi=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<td colspan="2">3. Walker</td>
		<td align="center"><input type="radio" name="home_care_alatbantu_walker" id="home_care_alatbantu_walker" value="1" ' . (($home_care_alatbantu_walker=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_alatbantu_walker" id="home_care_alatbantu_walker2" value="2" ' . (($home_care_alatbantu_walker=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="5">h. Peralatan Medis</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<td colspan="2">1. Kateter Urine</td>
		<td align="center"><input type="radio" name="home_care_alatmedis_kateterurine" id="home_care_alatmedis_kateterurine" value="1" ' . (($home_care_alatmedis_kateterurine=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_alatmedis_kateterurine" id="home_care_alatmedis_kateterurine2" value="2" ' . (($home_care_alatmedis_kateterurine=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		 <td>&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<td colspan="2">2. NGT</td>
		<td align="center"><input type="radio" name="home_care_alatmedis_ngt" id="home_care_alatmedis_ngt" value="1" ' . (($home_care_alatmedis_ngt=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_alatmedis_ngt" id="home_care_alatmedis_ngt2" value="2" ' . (($home_care_alatmedis_ngt=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		 <td>&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<td colspan="2">3. Oksigen</td>
		<td align="center"><input type="radio" name="home_care_alatmedis_oksigen" id="home_care_alatmedis_oksigen" value="1" ' . (($home_care_alatmedis_oksigen=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_alatmedis_oksigen" id="home_care_alatmedis_oksigen2" value="2" ' . (($home_care_alatmedis_oksigen=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		 <td>&nbsp;</td>
		<td width="80px">&nbsp;</td>
		<td colspan="2">4. Lainnya ' . setGarisIfNull($home_care_alatmedis_lainnya_ket) . '</td>
		<td align="center"><input type="radio" name="home_care_alatmedis_lainnya" id="home_care_alatmedis_lainnya" value="1" ' . (($home_care_alatmedis_lainnya=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="home_care_alatmedis_lainnya" id="home_care_alatmedis_lainnya2" value="2" ' . (($home_care_alatmedis_lainnya=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td colspan="6">4. Bagaimana pasien dan keluarga memerlukan edukasi kesehatan setelah keluar dari rumah sakit dalam hal :</td>
	</tr>
	<tr>
		 <td>&nbsp;</td>
		<td colspan="3">a. Obat-obatan</td>
		<td align="center"><input type="radio" name="edukasi_obat" id="edukasi_obat" value="1" ' . (($edukasi_obat=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="edukasi_obat" id="edukasi_obat2" value="2" ' . (($edukasi_obat=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		 <td>&nbsp;</td>
		<td colspan="3">b. Nyeri</td>
		<td align="center"><input type="radio" name="edukasi_nyeri" id="edukasi_nyeri" value="1" ' . (($edukasi_nyeri=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="edukasi_nyeri" id="edukasi_nyeri2" value="2" ' . (($edukasi_nyeri=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		 <td>&nbsp;</td>
		<td colspan="3">c. Diet</td>
		<td align="center"><input type="radio" name="edukasi_diet" id="edukasi_diet" value="1" ' . (($edukasi_diet=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="edukasi_diet" id="edukasi_diet2" value="2" ' . (($edukasi_diet=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">d. Mencari Pertolongan</td>
		<td align="center"><input type="radio" name="edukasi_caritolong" id="edukasi_caritolong" value="1" ' . (($edukasi_caritolong=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="edukasi_caritolong" id="edukasi_caritolong2" value="2" ' . (($edukasi_caritolong=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">e. Tindak lanjut pengobatan/ perawatan</td>
		<td align="center"><input type="radio" name="edukasi_perawatan" id="edukasi_perawatan" value="1" ' . (($edukasi_perawatan=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="edukasi_perawatan" id="edukasi_perawatan2" value="2" ' . (($edukasi_perawatan=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">f. Lainnya ' . setGarisIfNull($edukasi_lainnya_ket) . '</td>
		<td align="center"><input type="radio" name="edukasi_lainnya" id="edukasi_lainnya" value="1" ' . (($edukasi_lainnya=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="edukasi_lainnya" id="edukasi_lainnya2" value="2" ' . (($edukasi_lainnya=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td colspan="6">5. Bagaimana pasien dan keluarga mengetahui fasilitas pelayanan kesehatan yang dapat digunakan :</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">a. Puskesmas</td>
		<td align="center"><input type="radio" name="faskes_puskesmas" id="faskes_puskesmas" value="1" ' . (($faskes_puskesmas=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="faskes_puskesmas" id="faskes_puskesmas2" value="2" ' . (($faskes_puskesmas=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">b. Rumah Sakit</td>
		<td align="center"><input type="radio" name="faskes_rs" id="faskes_rs" value="1" ' . (($faskes_rs=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="faskes_rs" id="faskes_rs2" value="2" ' . (($faskes_rs=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">c. Klinik</td>
		<td align="center"><input type="radio" name="faskes_klinik" id="faskes_klinik" value="1" ' . (($faskes_klinik=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="faskes_klinik" id="faskes_klinik2" value="2" ' . (($faskes_klinik=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">d. Dokter keluarga</td>
		<td align="center"><input type="radio" name="faskes_dokter_keluarga" id="faskes_dokter_keluarga" value="1" ' . (($faskes_dokter_keluarga=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="faskes_dokter_keluarga" id="faskes_dokter_keluarga2" value="2" ' . (($faskes_dokter_keluarga=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">e. Rumah perawatan</td>
		<td align="center"><input type="radio" name="faskes_rumah_rawat" id="faskes_rumah_rawat" value="1" ' . (($faskes_rumah_rawat=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="faskes_rumah_rawat" id="faskes_rumah_rawat2" value="2" ' . (($faskes_rumah_rawat=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">f. Bidan praktek</td>
		<td align="center"><input type="radio" name="faskes_bidan_praktek" id="faskes_bidan_praktek" value="1" ' . (($faskes_bidan_praktek=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="faskes_bidan_praktek" id="faskes_bidan_praktek2" value="2" ' . (($faskes_bidan_praktek=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">g. Lainnya ' . setGarisIfNull($faskes_lainnya_ket) . '</td>
		<td align="center"><input type="radio" name="faskes_lainnya" id="faskes_lainnya" value="1" ' . (($faskes_lainnya=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="faskes_lainnya" id="faskes_lainnya2" value="2" ' . (($faskes_lainnya=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td colspan="6">6. Bagaimana pasien dan keluarga mengetahui tentang diet yang diperbolehkan untuk pasien ?</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">a. Jenisnya</td>
		<td align="center"><input type="radio" name="diet_jenis" id="diet_jenis" value="1" ' . (($diet_jenis=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="diet_jenis" id="diet_jenis2" value="2" ' . (($diet_jenis=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">b. Jumlahnya</td>
		<td align="center"><input type="radio" name="diet_jumlah" id="diet_jumlah" value="1" ' . (($diet_jumlah=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="diet_jumlah" id="diet_jumlah2" value="2" ' . (($diet_jumlah=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">c. Waktunya</td>
		<td align="center"><input type="radio" name="diet_waktu" id="diet_waktu" value="1" ' . (($diet_waktu=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="diet_waktu" id="diet_waktu2" value="2" ' . (($diet_waktu=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	</table>';
	
	$edoc_content_2 = '<table width="100%" cellpadding="0" cellspacing="0" autosize="1" >
		<tr>
			<td colspan="4">&nbsp;</td>
			<td align="center" width="75px">&nbsp;</td>
			<td align="center" width="75px">&nbsp;</td>
			</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
			<td align="center" >Ya</td>
			<td align="center" >Tidak</td>
		</tr>
	<tr>
		<td colspan="6">7. Bagaimana pasien dan keluarga mengetahui tentang transportasi yang dapat digunakan ?</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">a. Ambulance</td>
		<td align="center"><input type="radio" name="transportasi_ambulance" id="transportasi_ambulance" value="1" ' . (($transportasi_ambulance=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="transportasi_ambulance" id="transportasi_ambulance2" value="2" ' . (($transportasi_ambulance=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">b. Kendaraan pribadi</td>
		<td align="center"><input type="radio" name="transportasi_pribadi" id="transportasi_pribadi" value="1" ' . (($transportasi_pribadi=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="transportasi_pribadi" id="transportasi_pribadi2" value="2" ' . (($transportasi_pribadi=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">c. Kendaraan umum</td>
		<td align="center"><input type="radio" name="transportasi_umum" id="transportasi_umum" value="1" ' . (($transportasi_umum=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="transportasi_umum" id="transportasi_umum2" value="2" ' . (($transportasi_umum=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>	
	<tr>
		<td colspan="6">8. Bagaimana pasien dan keluarga mengetahui tentang yayasan penyakit sejenis yang ada di lingkungannya ?</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">a. Yayasan jantung sehat</td>
		<td align="center"><input type="radio" name="yayasan_jantung" id="yayasan_jantung" value="1" ' . (($yayasan_jantung=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="yayasan_jantung" id="yayasan_jantung2" value="2" ' . (($yayasan_jantung=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">b. Yayasan stroke</td>
		<td align="center"><input type="radio" name="yayasan_stroke" id="yayasan_stroke" value="1" ' . (($yayasan_stroke=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="yayasan_stroke" id="yayasan_stroke2" value="2" ' . (($yayasan_stroke=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">c. Lainnya ' . setGarisIfNull($yayasan_lainnya_ket) . '</td>
		<td align="center"><input type="radio" name="yayasan_lainnya" id="yayasan_lainnya" value="1" ' . (($yayasan_lainnya=='1') ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="radio" name="yayasan_lainnya" id="yayasan_lainnya2" value="2" ' . (($yayasan_lainnya=='2') ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td colspan="6">9. Rencana tindak lanjut setelah perawatan di Rumah Sakit :</td>
	</tr>
	<tr>
		<td>&nbsp;</td><td colspan="5">' . setGarisIfNull($rencana_tindak_lanjut) . '</td>
	</tr>
	<tr>
		<td colspan="6" align="right">&nbsp;</td>
	</tr>
	</table>'; 		  

	ob_start();
	include('edoc_rekammedik/edoc_frame_main.php');
	$html = ob_get_contents();
	ob_end_clean();
	
	ob_start();
	include('edoc_rekammedik/edoc_frame_add.php');
	$html_2 = ob_get_contents();
	ob_end_clean();
	
	$mpdf->AddPage('P');
	$mpdf->WriteHTML($html);
	$mpdf->AddPage('P');
	$mpdf->WriteHTML($html_2);
}					

//end Rencana Pemulangan	

$mpdf->Output($rmfile_path . '/' . $nomr . '/' . $filename);	

saveData($nomr,$rawat_id,$jns_rawat,$id_document,$filename,$user_name,$idx,'');
}
?>