<?php
function create_pdf_pengkajian_awal($idx,$perawatan){
global $rmfile_path;
global $user_name;	
global $edoc_logo;
global $paper_width;
global $paper_height;
$jenis_document = 'Pengkajian Awal Medis';
$id_document = '3';	

$jns_rawat = '1';
if($perawatan == 'RI') $jns_rawat = '2';
$qry_pengkajian = 'SELECT t_irja.ANAMNESIS,t_irja.PEMERIKSAAN_FISIK,t_irja.PEMERIKSAAN_PENUNJANG,t_irja.STATUS_LOKALIS,
					m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,t_irja.UNIT_ID,m_unit.NAMA_UNIT,
					m_pegawai.NAMA_PEGAWAI,"" AS JNS_ORDER, "" AS RAWAT_ID
					FROM t_irja
					INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
					INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
					LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_irja.IRJA_ID = "' . $idx . '"';
$qry_alergi = 'SELECT t_irja_alergi.ALERGI,t_irja_alergi.IRJA_ID
					FROM t_irja_alergi
					WHERE t_irja_alergi.IRJA_ID = "' . $idx . '"';				
$qry_diagnosa = 'SELECT t_irja_diagnosa.DIAGNOSA,t_irja_diagnosa.ICD_CODE,t_irja_diagnosa.DIAGNOSA_ORDER
					FROM t_irja_diagnosa
					WHERE t_irja_diagnosa.IRJA_ID = "' . $idx . '"
					AND t_irja_diagnosa.DIAGNOSA_ORDER = 0
					ORDER BY t_irja_diagnosa.DIAGNOSA_ORDER';	
$qry_diagnosa_sk = 'SELECT t_irja_diagnosa.DIAGNOSA,t_irja_diagnosa.ICD_CODE,t_irja_diagnosa.DIAGNOSA_ORDER
					FROM t_irja_diagnosa
					WHERE t_irja_diagnosa.IRJA_ID = "' . $idx . '"
					AND t_irja_diagnosa.DIAGNOSA_ORDER > 0
					ORDER BY t_irja_diagnosa.DIAGNOSA_ORDER';	
$qry_tindakan = 'SELECT m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,
					m_tarif.SATUAN,SUM(t_irja_tarif.KUANTITI) AS KUANTITI,t_irja_tarif.ICD_CODE
					FROM t_irja_tarif
					INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE t_irja_tarif.IRJA_ID = "' . $idx . '" 
					AND m_tarif_group.KODE_TARIF_GROUP <> "01" 
					AND m_tarif_group.KODE_TARIF_GROUP <> "02" AND m_tarif_group.KODE_TARIF_GROUP <> "09" 
					AND m_tarif_group.KODE_TARIF_GROUP <> "49" AND m_tarif_group.KODE_TARIF_GROUP <> "50"
					AND m_tarif_group.KODE_TARIF_GROUP <> "51" AND m_tarif_group.KODE_TARIF_GROUP <> "52"
					AND m_tarif_group.KODE_TARIF_GROUP <> "92" AND m_tarif_group.KODE_TARIF_GROUP <> "93"
					AND m_tarif_group.KODE_TARIF_GROUP <> "102" AND m_tarif_group.KODE_TARIF_GROUP <> "103"
					AND m_tarif_group.KODE_TARIF_GROUP <> "104" AND m_tarif_group.KODE_TARIF_GROUP <> "105"
					AND t_irja_tarif.NO_TARIF IS NOT NULL 
					AND (t_irja_tarif.ST_BAYAR IS NULL OR t_irja_tarif.ST_BAYAR = "Lunas")
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
					AND t_ipenunjang.JNS_ORDER = "IRJ"	
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
$nomr = $dat_pengkajian['NOMR'];
$nama_pasien = $dat_pengkajian['NAMA_PASIEN'];
$tgl_lahir = $dat_pengkajian['TGL_LAHIR'];
$jns_kelamin = $dat_pengkajian['JNS_KELAMIN'];
$unit_id = $dat_pengkajian['NAMA_UNIT'];
$dokter = $dat_pengkajian['NAMA_PEGAWAI'];
$igd = false;
if($dat_pengkajian['UNIT_ID'] == '9') $igd = true;

$edoc_norm = formatNoMR($nomr);
$edoc_nama_pasien = $nama_pasien;
$edoc_tanggal_lahir = changeDateFormat($tgl_lahir);
$edoc_jenis_kelamin = jenisKelamin($jns_kelamin);
$edoc_unit = $unit_id;
$edoc_nama_documen = strtoupper($jenis_document);

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

if($igd == false){			
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
	
}else{
	//if igd = true
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
						<td colspan="7">&nbsp;</td>
					</tr>
					<tr>
						<td>Nadi</td>
						<td>:</td>
						<td>' . setGarisIfNull($p_fisik[3]) . '</td>
						<td>&nbsp;</td>
						<td>Suhu</td>
						<td>:</td>
						<td>' . setGarisIfNull($p_fisik[4]) . '</td>
					</tr>
					<tr>
						<td>Respirasi</td>
						<td>:</td>
						<td>' . setGarisIfNull($p_fisik[5]) . '</td>
						<td>&nbsp;</td>
						<td>Berat Badan</td>
						<td>:</td>
						<td>' . setGarisIfNull($p_fisik[6]) . '</td>
					</tr>
					<tr>
						<td colspan="7">&nbsp;</td>
					</tr>
					<tr>
						<td>A. Status Neurologis</td>
						<td>:</td>
						<td colspan="5"><input type="checkbox" name="p_fisik_7" value="1" class="text_dt" ' . (($p_fisik[7] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Kaku Kuduk (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_8" value="1" class="text_dt" ' . (($p_fisik[8] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Kaku Kuduk (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>GCS: E,M,V</td>
						<td>:</td>
						<td colspan="3">' . setGarisIfNull($p_fisik[9]) . '</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>Lain-lain</td>
						<td>:</td>
						<td colspan="3">' . setGarisIfNull($p_fisik[10]). '</td>
					</tr>
					<tr>
						<td colspan="7">&nbsp;</td>
					</tr>
					<tr>
						<td>B. Kepala Leher</td>
						<td>:</td>
						<td colspan="5"><input type="checkbox" name="p_fisik_11" value="1" class="text_dt" ' . (($p_fisik[11] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Nafas Cufing Hidung (NCH) (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_12" value="1" class="text_dt" ' . (($p_fisik[12] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Nafas Cufing Hidung (NCH) (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td colspan="5"><input type="checkbox" name="p_fisik_13" value="1" class="text_dt" ' . (($p_fisik[13] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Congjungtira Anemis (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_14" value="1" class="text_dt" ' . (($p_fisik[14] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Congjungtira Anemis (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td colspan="5"><input type="checkbox" name="p_fisik_15" value="1" class="text_dt" ' . (($p_fisik[15] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Sklera Ikterik (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_16" value="1" class="text_dt" ' . (($p_fisik[16] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Sklera Ikterik (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td colspan="5">JVP&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p_fisik_17" value="1" class="text_dt" ' . (($p_fisik[17] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Meningkat&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_18" value="1" class="text_dt" ' . (($p_fisik[18] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Tidak Meningkat</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>Lain-lain</td>
						<td>:</td>
						<td colspan="3">' . setGarisIfNull($p_fisik[19]) . '</td>
					</tr>
					<tr>
						<td colspan="7">&nbsp;</td>
					</tr>
					<tr>
						<td>C. Thorax</td>
						<td>:&nbsp;&nbsp;1.</td>
						<td colspan="5"><input type="checkbox" name="p_fisik_20" value="1" class="text_dt" ' . (($p_fisik[20] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Retraksi (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_21" value="1" class="text_dt" ' . (($p_fisik[21] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Retraksi (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;2.</td>
						<td colspan="5"><input type="checkbox" name="p_fisik_22" value="1" class="text_dt" ' . (($p_fisik[22] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Fraktur (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_23" value="1" class="text_dt" ' . (($p_fisik[23] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Fraktur (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;3.</td>
						<td colspan="5">Cor=S1-S2&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p_fisik_24" value="1" class="text_dt" ' . (($p_fisik[24] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Irreguler&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_25" value="1" class="text_dt" ' . (($p_fisik[25] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Reguler</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;4.</td>
						<td colspan="5"><input type="checkbox" name="p_fisik_26" value="1" class="text_dt" ' . (($p_fisik[26] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Murmur (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_27" value="1" class="text_dt" ' . (($p_fisik[27] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Murmur (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;5.</td>
						<td colspan="5"><input type="checkbox" name="p_fisik_28" value="1" class="text_dt" ' . (($p_fisik[28] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Gallop (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_29" value="1" class="text_dt" ' . (($p_fisik[29] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Gallop (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;6.</td>
						<td colspan="5">Pulmo&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p_fisik_30" value="1" class="text_dt" ' . (($p_fisik[30] == '1') ? 'checked="checked"' : '') . ' >&nbsp;So Verikuler (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_31" value="1" class="text_dt" ' . (($p_fisik[31] == '1') ? 'checked="checked"' : '') . ' >&nbsp;So Verikuler (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td colspan="5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_32" value="1" class="text_dt" ' . (($p_fisik[32] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Ronkhi (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_33" value="1" class="text_dt" ' . (($p_fisik[33] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Ronkhi (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td colspan="5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_34" value="1" class="text_dt" ' . (($p_fisik[34] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Wheezing (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_35" value="1" class="text_dt" ' . (($p_fisik[35] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Wheezing (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>Lain-lain</td>
						<td>:</td>
						<td colspan="3">' . setGarisIfNull($p_fisik[36]). '</td>
					</tr>
					<tr>
						<td colspan="7">&nbsp;</td>
					</tr>
					</table>
			</td>
		</tr>
        <tr>
            <td colspan="2"></td>
        </tr>
    </table>';					
					
	$edoc_content_2 = '<table width="100%" border="0" autosize="1" >
        <tr>
            <td colspan="2"></td>
        </tr>
		<tr>
            <td valign="top">&nbsp;</td>
            <td width="85%">
				<table table border="0" width="100%">				
					<tr>
						<td>D. Abdomen</td>
						<td>:&nbsp;&nbsp;1.</td>
						<td colspan="5"><input type="checkbox" name="p_fisik_37" value="1" class="text_dt" ' . (($p_fisik[37] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Supel&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_38" value="1" class="text_dt" ' . (($p_fisik[38] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Keras&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_39" value="1" class="text_dt" ' . (($p_fisik[39] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Datar</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;2.</td>
						<td colspan="5">Bissing Usus&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p_fisik_40" value="1" class="text_dt" ' . (($p_fisik[40] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Normal&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_41" value="1" class="text_dt" ' . (($p_fisik[41] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Menurun&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_42" value="1" class="text_dt" ' . (($p_fisik[42] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Meningkat&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_43" value="1" class="text_dt" ' . (($p_fisik[43] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Menghilang</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;3.</td>
						<td colspan="5">
						<input type="checkbox" name="p_fisik_44" value="1" class="text_dt" ' . (($p_fisik[44] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Nyeri Tekan Epigastrium (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_45" value="1" class="text_dt" ' . (($p_fisik[45] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Nyeri Tekan Epigastrium (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;4.</td>
						<td colspan="5">
						<input type="checkbox" name="p_fisik_46" value="1" class="text_dt" ' . (($p_fisik[46] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Nyeri Tekan MC Burney (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_47" value="1" class="text_dt" ' . (($p_fisik[47] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Nyeri Tekan MC Burney (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;5.</td>
						<td colspan="5">Hepar&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p_fisik_48" value="1" class="text_dt" ' . (($p_fisik[48] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Teraba&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_49" value="1" class="text_dt" ' . (($p_fisik[49] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Tidak Teraba</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;6.</td>
						<td colspan="5">Lien&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p_fisik_50" value="1" class="text_dt" ' . (($p_fisik[50] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Membesar&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_51" value="1" class="text_dt" ' . (($p_fisik[51] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Tidak Membesar</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>Lain-lain</td>
						<td>:</td>
						<td colspan="3">' . setGarisIfNull($p_fisik[52]) . '</td>
					</tr>
					<tr>
						<td colspan="7">&nbsp;</td>
					</tr>
					<tr>
						<td>E. Ekstremitas</td>
						<td>:</td>
						<td colspan="5"><input type="checkbox" name="p_fisik_53" value="1" class="text_dt" ' . (($p_fisik[53] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Atas&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_54" value="1" class="text_dt" ' . (($p_fisik[54] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Bawah&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_55" value="1" class="text_dt" ' . (($p_fisik[55] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Kanan&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_56" value="1" class="text_dt" ' . (($p_fisik[56] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Kiri</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;1.</td>
						<td colspan="5">
						<input type="checkbox" name="p_fisik_57" value="1" class="text_dt" ' . (($p_fisik[57] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Sianosi (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_58" value="1" class="text_dt" ' . (($p_fisik[58] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Sianosi (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;2.</td>
						<td colspan="5">
						<input type="checkbox" name="p_fisik_59" value="1" class="text_dt" ' . (($p_fisik[59] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Udem (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_60" value="1" class="text_dt" ' . (($p_fisik[60] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Udem (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;3.</td>
						<td colspan="5">
						<input type="checkbox" name="p_fisik_61" value="1" class="text_dt" ' . (($p_fisik[61] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Akral Hangat&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_62" value="1" class="text_dt" ' . (($p_fisik[62] == '1') ? 'checked="checked"' : '') . ' >&nbsp;Akral Dingin</td>
					</tr>
				</table>';
	$edoc_content_2 = $edoc_content_2 . '</td>
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
}	

createFolder($nomr);
$filename = $nomr . '_' . $perawatan . $idx . '_' . $id_document . '.pdf' ;

$mpdf = new mPDF('utf-8', array($paper_width,$paper_height));
$mpdf->autoPageBreak = false;
$mpdf->SetHTMLHeader(setHeader($nomr,$nama_pasien));
$mpdf->SetHTMLFooter(setFooter($jenis_document));

ob_start();
include('edoc_rekammedik/edoc_frame_main.php');
$html = ob_get_contents();
ob_end_clean();
$mpdf->WriteHTML($html);

if($igd){
	ob_start();
	include('edoc_rekammedik/edoc_frame_add.php');
	$html = ob_get_contents();
	ob_end_clean();
	$mpdf->AddPage('P');
	$mpdf->WriteHTML($html);
}

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

$mpdf->Output($rmfile_path . '/' . $nomr . '/' . $filename);	

saveData($nomr,$idx,$jns_rawat,$id_document,$filename,$user_name,'','');
}
?>