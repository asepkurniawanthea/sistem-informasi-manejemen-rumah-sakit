<?php
function create_pdf_kusta($idx){
global $rmfile_path;
global $user_name;
global $edoc_logo;
global $paper_width;
global $paper_height;
$jenis_document = 'Kusta';
$id_document = '14';

$qry_kusta = 'SELECT 
					m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,t_irja.UNIT_ID,m_unit.NAMA_UNIT,
					m_pegawai.NAMA_PEGAWAI,"" AS JNS_ORDER, "" AS RAWAT_ID,
					t_irja.KUSTA_TYPE,t_irja.KUSTA_BTA_SEMULA,
					t_irja.KUSTA_BTA_RATA2_SEMULA,
					DATE_FORMAT(t_irja.KUSTA_TGL_BTA_RATA2,"%d/%m/%Y") AS KUSTA_TGL_BTA_RATA2,
					DATE_FORMAT(t_irja.KUSTA_MDT_MULAI,"%d/%m/%Y") AS KUSTA_MDT_MULAI,
					t_irja.KUSTA_DOSIS_ANTIREAKSI,t_irja.KUSTA_DOSIS_LAMPRENE,
					DATE_FORMAT(t_irja.KUSTA_RFT_COT,"%d/%m/%Y") AS KUSTA_RFT_COT,
					t_irja.KUSTA_BTA_MH_SKR,t_irja.KUSTA_PENYAKIT_LAIN,
					t_irja.KUSTA_YG_PERLU_DIHUBUNGI,t_irja.KUSTA_ALAMAT_DIHUBUNGI,
					t_irja.KUSTA_TELEPON_DIHUBUNGI,t_irja.KUSTA_KETERANGAN,
					t_irja.KUSTA_OPNAME,t_irja.KUSTA_KETERANGAN_OPNAME,
					t_irja.KUSTA_KUNJUNGAN,t_irja.POD
					FROM t_irja
					INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
					INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
					LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_irja.IRJA_ID = "' . $idx . '"';
$get_kusta = mysql_query($qry_kusta) or die(mysql_error());
$dat_kusta = mysql_fetch_assoc($get_kusta);

$nomr = $dat_kusta['NOMR'];
$nama_pasien = $dat_kusta['NAMA_PASIEN'];
$tgl_lahir = $dat_kusta['TGL_LAHIR'];
$jns_kelamin = $dat_kusta['JNS_KELAMIN'];
$unit_id = $dat_kusta['UNIT_ID'];
$nama_unit = $dat_kusta['NAMA_UNIT'];

if($unit_id == '35'){

	$edoc_norm = formatNoMR($nomr);
	$edoc_nama_pasien = $nama_pasien;
	$edoc_tanggal_lahir = changeDateFormat($tgl_lahir);
	$edoc_jenis_kelamin = jenisKelamin($jns_kelamin);
	$edoc_unit = $nama_unit;
	$edoc_nama_documen = strtoupper($jenis_document);
	
	$kusta_type = $dat_kusta['KUSTA_TYPE']; 
	$kusta_bta_semula = $dat_kusta['KUSTA_BTA_SEMULA'];
	$kusta_bta_rata2_semula = $dat_kusta['KUSTA_BTA_RATA2_SEMULA'];
	$kusta_tgl_bta_rata2 = $dat_kusta['KUSTA_TGL_BTA_RATA2'];
	$kusta_mdt_mulai = $dat_kusta['KUSTA_MDT_MULAI'];
	$kusta_dosis_antireaksi = $dat_kusta['KUSTA_DOSIS_ANTIREAKSI'];
	$kusta_dosis_lamprene = $dat_kusta['KUSTA_DOSIS_LAMPRENE'];
	$kusta_rft_cot = $dat_kusta['KUSTA_RFT_COT'];
	$kusta_bta_mh_skr = $dat_kusta['KUSTA_BTA_MH_SKR'];
	$kusta_penyakit_lain = $dat_kusta['KUSTA_PENYAKIT_LAIN'];
	$kusta_yg_perlu_dihubungi = $dat_kusta['KUSTA_YG_PERLU_DIHUBUNGI'];
	$kusta_alamat_dihubungi = $dat_kusta['KUSTA_ALAMAT_DIHUBUNGI'];
	$kusta_telepon_dihubungi = $dat_kusta['KUSTA_TELEPON_DIHUBUNGI'];			
	$kusta_keterangan = $dat_kusta['KUSTA_KETERANGAN'];
	$kusta_opname = $dat_kusta['KUSTA_OPNAME'];
	$kusta_keterangan_opname = $dat_kusta['KUSTA_KETERANGAN_OPNAME'];
	$kusta_kunjungan = $dat_kusta['KUSTA_KUNJUNGAN'];
	$pod = $dat_kusta['POD'];
	
	$sql_pod = 'SELECT t_irja_pod.POD_ID,t_irja_pod.SUB_POD
			FROM t_irja_pod
			WHERE t_irja_pod.IRJA_ID = "' . $idx . '"';
	$get_pod = mysql_query($sql_pod) or die(mysql_error());
	$podsub = array();
	while($dat_pod = mysql_fetch_array($get_pod)){
			$podsub[$dat_pod['SUB_POD']] = $dat_pod['SUB_POD']; 
	}
	
	$arr_type_kusta['NR'] = 'Neural';
	$arr_type_kusta['BB'] = 'BB';
	$arr_type_kusta['BL'] = 'BL';
	$arr_type_kusta['LL'] = 'LL';
	$arr_type_kusta['BT'] = 'BT';
	$arr_type_kusta['TT'] = 'TT';
	$arr_type_kusta['OM'] = 'Observasi MH';
	$arr_type_kusta['NM'] = 'Non MH';
	$arr_type_kusta['NL'] = 'NL';
	$arr_type_kusta['PB'] = 'PB';
	$arr_type_kusta['0'] = '';
	
	$edoc_content = '<table width="100%" border="0" autosize="1" >
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
    <td width="180">Tipe Kusta </td>
    <td>:&nbsp;' . setGarisIfNull($arr_type_kusta[$kusta_type]) . '</td>
  </tr>
  <tr>
    <td>BTA Semula</td>
    <td>:&nbsp;' . setGarisIfNull($kusta_bta_rata2_semula) . '</td>
  </tr>
  <tr>
    <td>Tanggal BTA</td>
    <td>:&nbsp;' . setGarisIfNull($kusta_tgl_bta_rata2) . '</td>
  </tr>
  <tr>
    <td>MDT Mulai </td>
    <td>:&nbsp;' . setGarisIfNull($kusta_mdt_mulai) . '</td>
  </tr>
  <tr>
    <td>Yang Perlu Dihubungi </td>
    <td>:&nbsp;' . setGarisIfNull($kusta_yg_perlu_dihubungi) . '</td>
  </tr>
  <tr>
    <td>Alamat</td>
    <td>:&nbsp;' . setGarisIfNull($kusta_alamat_dihubungi) . '</td>
  </tr>
  <tr>
    <td>Telepon</td>
    <td>:&nbsp;' . setGarisIfNull($kusta_telepon_dihubungi) . '</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Anti Reaksi </td>
    <td>:&nbsp;' . setGarisIfNull($kusta_dosis_antireaksi) . '</td>
  </tr>
  <tr>
    <td>Dosis Lamprene </td>
    <td>:&nbsp;' . setGarisIfNull($kusta_dosis_lamprene) . '</td>
  </tr>
  <tr>
    <td>RFT (COT) </td>
    <td>:&nbsp;' . setGarisIfNull($kusta_rft_cot) . '</td>
  </tr>
  <tr>
    <td>BTA Sekarang </td>
    <td>:&nbsp;' . setGarisIfNull($kusta_bta_mh_skr) . '</td>
  </tr>
  <tr>
    <td>Penyakit Lain </td>
    <td>:&nbsp;'  . setGarisIfNull($kusta_penyakit_lain) . '</td>
  </tr>
  <tr>
    <td>Kunjungan</td>
    <td>:&nbsp;' . setGarisIfNull($kusta_kunjungan == '1') . '</td>
  </tr>
  <tr>
    <td>Opname </td>
    <td>:&nbsp;<input type="checkbox" name="kusta_opname" value="1" ' . (($kusta_opname == '1') ? 'checked="checked"' : '') . '/>&nbsp;Ya&nbsp;' . setGarisIfNull($kusta_keterangan_opname) . '</td>
  </tr> 
 <tr>
    <td>Keterangan</td>
    <td>:&nbsp;' .  setGarisIfNull($kusta_keterangan) . '</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
		<td>Kategori P.O.D&nbsp;</td>
		<td><input type="radio" name="pod" id="pod_1" value="1" ' . (($pod == 1) ? 'checked="checked"' : '') . ' />&nbsp;Tanpa Cacat</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td><input type="radio" name="pod" id="pod_2" value="2" ' . (($pod == 2) ? 'checked="checked"' : '') . ' />&nbsp;Cacat Tingkat I</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_1" id="podsub_1" value="1" ' . ((isset($podsub[1])) ? 'checked="checked"' : '') . '  />&nbsp;Anestesi</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_2" id="podsub_2" value="2" ' . ((isset($podsub[2])) ? 'checked="checked"' : '') . '  />&nbsp;Parese</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_3" id="podsub_3" value="3" ' . ((isset($podsub[3])) ? 'checked="checked"' : '') . '  />&nbsp;Kulit Kering</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td><input type="radio" name="pod" id="pod_3" value="3" ' . (($pod == 3) ? 'checked="checked"' : '') . ' />&nbsp;Cacat Tingkat II</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_4" id="podsub_4" value="4" ' . ((isset($podsub[4])) ? 'checked="checked"' : '') . '  />&nbsp;Lagophthalmw</td>
	</tr>	
	<tr>
		<td align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_5" id="podsub_5" value="5" ' . ((isset($podsub[5])) ? 'checked="checked"' : '') . '  />&nbsp;Clawing</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_6" id="podsub_6" value="6" ' . ((isset($podsub[6])) ? 'checked="checked"' : '') . '  />&nbsp;Kontraktur</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_7" id="podsub_7" value="7" ' . ((isset($podsub[7])) ? 'checked="checked"' : '') . '  />&nbsp;Fissura</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_8" id="podsub_8" value="8" ' . ((isset($podsub[8])) ? 'checked="checked"' : '') . '  />&nbsp;Absorpsi</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_9" id="podsub_9" value="9" ' . ((isset($podsub[9])) ? 'checked="checked"' : '') . '  />&nbsp;Mutilasi</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_10" id="podsub_10" value="10" ' . ((isset($podsub[10])) ? 'checked="checked"' : '') . '  />&nbsp;Inversi</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_11" id="podsub_11" value="11" ' . ((isset($podsub[11])) ? 'checked="checked"' : '') . '  />&nbsp;Eksversi</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_12" id="podsub_12" value="12" ' . ((isset($podsub[12])) ? 'checked="checked"' : '') . '  />&nbsp;Rocker Bottom</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_13" id="podsub_13" value="13" ' . ((isset($podsub[13])) ? 'checked="checked"' : '') . '  />&nbsp;Short Foot</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_14" id="podsub_14" value="14" ' . ((isset($podsub[14])) ? 'checked="checked"' : '') . '  />&nbsp;Ulkus</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_15" id="podsub_15" value="15" ' . ((isset($podsub[15])) ? 'checked="checked"' : '') . '  />&nbsp;Amputasi</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_16" id="podsub_16" value="16" ' . ((isset($podsub[16])) ? 'checked="checked"' : '') . '  />&nbsp;Drop Foot</td>
	</tr>
	<tr>
		<td align="right">&nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="podsub_17" id="podsub_17" value="17" ' . ((isset($podsub[17])) ? 'checked="checked"' : '') . '  />&nbsp;Drop Hand</td>
	</tr>
	</table>';

	ob_start();
	include('edoc_rekammedik/edoc_frame_main.php');
	$html = ob_get_contents();
	ob_end_clean();

	createFolder($nomr);
	$filename = $nomr . '_RJ' . $idx . '_' . $id_document . '.pdf' ;

	$mpdf = new mPDF('utf-8', array($paper_width,$paper_height));
	$mpdf->autoPageBreak = false;
	$mpdf->SetHTMLHeader(setHeader($nomr,$nama_pasien));
	$mpdf->SetHTMLFooter(setFooter($jenis_document));
	$mpdf->WriteHTML($html);
	$mpdf->Output($rmfile_path . '/' . $nomr . '/' . $filename);	

	saveData($nomr,$idx,'1',$id_document,$filename,$user_name,'','');
}
}
?>