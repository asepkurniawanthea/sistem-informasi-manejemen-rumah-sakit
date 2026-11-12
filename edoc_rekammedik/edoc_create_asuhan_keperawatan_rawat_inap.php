<?php
function create_pdf_asuhan_keperawatan_rawat_inap($idx){
global $rmfile_path;
global $user_name;	
global $edoc_logo;
global $paper_width;
global $paper_height;
global $adline;

$id_document = '19';
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

$qry_pasien = 'SELECT m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,
				m_pasien.JNS_KELAMIN,CONCAT(m_ruang.NAMA_RUANG," ",m_ruang.KELAS_RAWAT) AS NAMA_RUANG
				FROM t_irna
				INNER JOIN t_irja ON (t_irna.IRNA_ID = t_irja.IRJA_ID)
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				WHERE t_irna.IRNA_ID = "' . $idx . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);

$nomr = $dat_pasien['NOMR'];
$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = $dat_pasien['TGL_LAHIR'];
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$nama_unit = $dat_pasien['NAMA_UNIT'];
$nama_ruang = $dat_pasien['NAMA_RUANG'];

$edoc_norm = formatNoMR($nomr);
$edoc_nama_pasien = $nama_pasien;
$edoc_tanggal_lahir = changeDateFormat($tgl_lahir);
$edoc_jenis_kelamin = jenisKelamin($jns_kelamin);
$edoc_unit = $nama_ruang;

createFolder($nomr);
$filename = $nomr . '_RI' . $idx . '_' . $id_document . '.pdf' ;

$mpdf = new mPDF('utf-8', array($paper_width,$paper_height));
$mpdf->autoPageBreak = false;
$mpdf->SetHTMLHeader(setHeader($nomr,$nama_pasien));
$mpdf->SetHTMLFooter(setFooter('Asuhan Keperawatan'));

//Penilaian Status Fungsional
$edoc_nama_documen = strtoupper('Penilaian Status Fungsional');

$qry_status_fungsional = 'SELECT STATUS_FUNGSIONAL_ID,MENGENDALIKAN_RANGSANG_DEFEKASI_0,MENGENDALIKAN_RANGSANG_DEFEKASI_1,MENGENDALIKAN_RANGSANG_DEFEKASI_2,
			MENGENDALIKAN_RANGSANG_BERKEMIH_0,MENGENDALIKAN_RANGSANG_BERKEMIH_1,MENGENDALIKAN_RANGSANG_BERKEMIH_2,MEMBERSIHKAN_DIRI_0,
			MEMBERSIHKAN_DIRI_1,PENGGUNAAN_JAMBAN_0,PENGGUNAAN_JAMBAN_1,PENGGUNAAN_JAMBAN_2,
			MAKAN_0,MAKAN_1,MAKAN_2,BERBARING_KE_DUDUK_0,BERBARING_KE_DUDUK_1,BERBARING_KE_DUDUK_2,BERBARING_KE_DUDUK_3,BERJALAN_0,
			BERJALAN_1,BERJALAN_2,BERJALAN_3,MEMAKAI_BAJU_0,MEMAKAI_BAJU_1,MEMAKAI_BAJU_2,NAIK_TURUN_TANGGA_0,NAIK_TURUN_TANGGA_1,NAIK_TURUN_TANGGA_2,
			MANDI_0,MANDI_2,DATE_FORMAT(TANGGAL,"%d/%m/%Y") AS TANGGAL,PERAWAT
			FROM t_irna_askep_status_fungsional
			WHERE STATUS_FUNGSIONAL_ID = "' . $idx . '"';
$get_status_fungsional = mysql_query($qry_status_fungsional) or die(mysql_error());
if(mysql_num_rows($get_status_fungsional) > 0){
	$dat_status_fungsional = mysql_fetch_assoc($get_status_fungsional);

	$status_fungsional_id = $dat_status_fungsional['STATUS_FUNGSIONAL_ID'];
	$mengendalikan_rangsang_defekasi_0 = explode('|',$dat_status_fungsional['MENGENDALIKAN_RANGSANG_DEFEKASI_0']);
	$mengendalikan_rangsang_defekasi_1 = explode('|',$dat_status_fungsional['MENGENDALIKAN_RANGSANG_DEFEKASI_1']);
	$mengendalikan_rangsang_defekasi_2 = explode('|',$dat_status_fungsional['MENGENDALIKAN_RANGSANG_DEFEKASI_2']);
	$mengendalikan_rangsang_berkemih_0 = explode('|',$dat_status_fungsional['MENGENDALIKAN_RANGSANG_BERKEMIH_0']);
	$mengendalikan_rangsang_berkemih_1 = explode('|',$dat_status_fungsional['MENGENDALIKAN_RANGSANG_BERKEMIH_1']);
	$mengendalikan_rangsang_berkemih_2 = explode('|',$dat_status_fungsional['MENGENDALIKAN_RANGSANG_BERKEMIH_2']);
	$membersihkan_diri_0 = explode('|',$dat_status_fungsional['MEMBERSIHKAN_DIRI_0']);
	$membersihkan_diri_1 = explode('|',$dat_status_fungsional['MEMBERSIHKAN_DIRI_1']);
	$penggunaan_jamban_0 = explode('|',$dat_status_fungsional['PENGGUNAAN_JAMBAN_0']);
	$penggunaan_jamban_1 = explode('|',$dat_status_fungsional['PENGGUNAAN_JAMBAN_1']);
	$penggunaan_jamban_2 = explode('|',$dat_status_fungsional['PENGGUNAAN_JAMBAN_2']);
	$makan_0 = explode('|',$dat_status_fungsional['MAKAN_0']);
	$makan_1 = explode('|',$dat_status_fungsional['MAKAN_1']);
	$makan_2 = explode('|',$dat_status_fungsional['MAKAN_2']);
	$berbaring_ke_duduk_0 = explode('|',$dat_status_fungsional['BERBARING_KE_DUDUK_0']);
	$berbaring_ke_duduk_1 = explode('|',$dat_status_fungsional['BERBARING_KE_DUDUK_1']);
	$berbaring_ke_duduk_2 = explode('|',$dat_status_fungsional['BERBARING_KE_DUDUK_2']);
	$berbaring_ke_duduk_3 = explode('|',$dat_status_fungsional['BERBARING_KE_DUDUK_3']);
	$berjalan_0 = explode('|',$dat_status_fungsional['BERJALAN_0']);
	$berjalan_1 = explode('|',$dat_status_fungsional['BERJALAN_1']);
	$berjalan_2 = explode('|',$dat_status_fungsional['BERJALAN_2']);
	$berjalan_3 = explode('|',$dat_status_fungsional['BERJALAN_3']);
	$memakai_baju_0 = explode('|',$dat_status_fungsional['MEMAKAI_BAJU_0']);
	$memakai_baju_1 = explode('|',$dat_status_fungsional['MEMAKAI_BAJU_1']);
	$memakai_baju_2 = explode('|',$dat_status_fungsional['MEMAKAI_BAJU_2']);
	$naik_turun_tangga_0 = explode('|',$dat_status_fungsional['NAIK_TURUN_TANGGA_0']);
	$naik_turun_tangga_1 = explode('|',$dat_status_fungsional['NAIK_TURUN_TANGGA_1']);
	$naik_turun_tangga_2 = explode('|',$dat_status_fungsional['NAIK_TURUN_TANGGA_2']);
	$mandi_0 = explode('|',$dat_status_fungsional['MANDI_0']);
	$mandi_2 = explode('|',$dat_status_fungsional['MANDI_2']);
	$tanggal = $dat_status_fungsional['TANGGAL'];
	$perawat = explode('|',$dat_status_fungsional['PERAWAT']);	
	$perawat_arr = array();
	for($y=0;$y<7;$y++){
		$perawat_arr[$y] = $arr_perawat[$perawat[$y]];
	}

	$edoc_content = '<table border="0" width="100%" >
			<tr>
				<td width="100">Tanggal</td>
				<td>:&nbsp;' . $tanggal . '</td>
			</tr>
			</table>
			<style>.tbl tr td {
				   border: 1px solid black;
				   padding-left:1px;
				   border-collapse: collapse;
			}</style>
	<table width="100%" class="tbl" cellpadding="0" cellspacing="0" autosize="1" >
		<tr>
			<td rowspan="2" width="25px" align="center" bgcolor="#CCCCCC" ><strong>No</strong></td>
			<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Fungsi</strong></td>
			<td rowspan="2" width="40px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
			<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Uraian</strong></td>
			<td colspan="7" align="center" bgcolor="#CCCCCC" ><strong>Nilai Skor</strong></td>
		  </tr>
		  <tr>
			<td align="center" bgcolor="#CCCCCC" ><strong>Sebelum Sakit</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Saat Masuk</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Minggu I<br />Di RS</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Minggu II<br />Di RS</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Minggu III<br />Di RS</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Minggu IV<br />Di RS</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Saat Pulang</strong></td>
		  </tr>
		<tr>
			<td rowspan="3" align="center">1</td>
			<td rowspan="3">Mengendalikan rangsang defekasi (BAB)</td>
			<td align="center">0</td>
			<td>Tak terkendali/ tak teratur (perlu pencahar)</td>
			<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_0_0" id="mengendalikan_rangsang_defekasi_0_0" value="0" ' . ((isset($mengendalikan_rangsang_defekasi_0[0]) and ($mengendalikan_rangsang_defekasi_0[0]=='0')) ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_0_1" id="mengendalikan_rangsang_defekasi_0_1" value="0" ' . ((isset($mengendalikan_rangsang_defekasi_0[1]) and ($mengendalikan_rangsang_defekasi_0[1]=='0')) ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_0_2" id="mengendalikan_rangsang_defekasi_0_2" value="0" ' . ((isset($mengendalikan_rangsang_defekasi_0[2]) and ($mengendalikan_rangsang_defekasi_0[2]=='0')) ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_0_3" id="mengendalikan_rangsang_defekasi_0_3" value="0" ' . ((isset($mengendalikan_rangsang_defekasi_0[3]) and ($mengendalikan_rangsang_defekasi_0[3]=='0')) ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_0_4" id="mengendalikan_rangsang_defekasi_0_4" value="0" ' . ((isset($mengendalikan_rangsang_defekasi_0[4]) and ($mengendalikan_rangsang_defekasi_0[4]=='0')) ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_0_5" id="mengendalikan_rangsang_defekasi_0_5" value="0" ' . ((isset($mengendalikan_rangsang_defekasi_0[5]) and ($mengendalikan_rangsang_defekasi_0[5]=='0')) ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_0_6" id="mengendalikan_rangsang_defekasi_0_6" value="0" ' . ((isset($mengendalikan_rangsang_defekasi_0[6]) and ($mengendalikan_rangsang_defekasi_0[6]=='0')) ? 'checked="checked"' : '') . ' /></td>
		</tr>
	<tr>
		<td align="center">1</td>
		<td>Kadang-kadang tak terkendali</td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_1_0" id="mengendalikan_rangsang_defekasi_1_0" value="1" ' . ((isset($mengendalikan_rangsang_defekasi_1[0]) and ($mengendalikan_rangsang_defekasi_1[0]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_1_1" id="mengendalikan_rangsang_defekasi_1_1" value="1" ' . ((isset($mengendalikan_rangsang_defekasi_1[1]) and ($mengendalikan_rangsang_defekasi_1[1]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_1_2" id="mengendalikan_rangsang_defekasi_1_2" value="1" ' . ((isset($mengendalikan_rangsang_defekasi_1[2]) and ($mengendalikan_rangsang_defekasi_1[2]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_1_3" id="mengendalikan_rangsang_defekasi_1_3" value="1" ' . ((isset($mengendalikan_rangsang_defekasi_1[3]) and ($mengendalikan_rangsang_defekasi_1[3]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_1_4" id="mengendalikan_rangsang_defekasi_1_4" value="1" ' . ((isset($mengendalikan_rangsang_defekasi_1[4]) and ($mengendalikan_rangsang_defekasi_1[4]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_1_5" id="mengendalikan_rangsang_defekasi_1_5" value="1" ' . ((isset($mengendalikan_rangsang_defekasi_1[5]) and ($mengendalikan_rangsang_defekasi_1[5]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_1_6" id="mengendalikan_rangsang_defekasi_1_6" value="1" ' . ((isset($mengendalikan_rangsang_defekasi_1[6]) and ($mengendalikan_rangsang_defekasi_1[6]=='1')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td align="center">2</td>
		<td>Mandiri</td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_2_0" id="mengendalikan_rangsang_defekasi_2_0" value="2" ' . ((isset($mengendalikan_rangsang_defekasi_2[0]) and ($mengendalikan_rangsang_defekasi_2[0]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_2_1" id="mengendalikan_rangsang_defekasi_2_1" value="2" ' . ((isset($mengendalikan_rangsang_defekasi_2[1]) and ($mengendalikan_rangsang_defekasi_2[1]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_2_2" id="mengendalikan_rangsang_defekasi_2_2" value="2" ' . ((isset($mengendalikan_rangsang_defekasi_2[2]) and ($mengendalikan_rangsang_defekasi_2[2]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_2_3" id="mengendalikan_rangsang_defekasi_2_3" value="2" ' . ((isset($mengendalikan_rangsang_defekasi_2[3]) and ($mengendalikan_rangsang_defekasi_2[3]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_2_4" id="mengendalikan_rangsang_defekasi_2_4" value="2" ' . ((isset($mengendalikan_rangsang_defekasi_2[4]) and ($mengendalikan_rangsang_defekasi_2[4]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_2_5" id="mengendalikan_rangsang_defekasi_2_5" value="2" ' . ((isset($mengendalikan_rangsang_defekasi_2[5]) and ($mengendalikan_rangsang_defekasi_2[5]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_defekasi_2_6" id="mengendalikan_rangsang_defekasi_2_6" value="2" ' . ((isset($mengendalikan_rangsang_defekasi_2[6]) and ($mengendalikan_rangsang_defekasi_2[6]=='2')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td rowspan="3" align="center">2</td>
		<td rowspan="3">Mengendalikan rangsang berkemih (BAK)</td>
		<td align="center">0</td>
		<td>Tidak terkendali/ pakai keteter</td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_0_0" id="mengendalikan_rangsang_berkemih_0_0" value="0" ' . ((isset($mengendalikan_rangsang_berkemih_0[0]) and ($mengendalikan_rangsang_berkemih_0[0]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_0_1" id="mengendalikan_rangsang_berkemih_0_1" value="0" ' . ((isset($mengendalikan_rangsang_berkemih_0[1]) and ($mengendalikan_rangsang_berkemih_0[1]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_0_2" id="mengendalikan_rangsang_berkemih_0_2" value="0" ' . ((isset($mengendalikan_rangsang_berkemih_0[2]) and ($mengendalikan_rangsang_berkemih_0[2]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_0_3" id="mengendalikan_rangsang_berkemih_0_3" value="0" ' . ((isset($mengendalikan_rangsang_berkemih_0[3]) and ($mengendalikan_rangsang_berkemih_0[3]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_0_4" id="mengendalikan_rangsang_berkemih_0_4" value="0" ' . ((isset($mengendalikan_rangsang_berkemih_0[4]) and ($mengendalikan_rangsang_berkemih_0[4]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_0_5" id="mengendalikan_rangsang_berkemih_0_5" value="0" ' . ((isset($mengendalikan_rangsang_berkemih_0[5]) and ($mengendalikan_rangsang_berkemih_0[5]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_0_6" id="mengendalikan_rangsang_berkemih_0_6" value="0" ' . ((isset($mengendalikan_rangsang_berkemih_0[6]) and ($mengendalikan_rangsang_berkemih_0[6]=='0')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td align="center">1</td>
		<td>Kadang-kadang tak terkendali (1 x 24 jam)</td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_1_0" id="mengendalikan_rangsang_berkemih_1_0" value="1" ' . ((isset($mengendalikan_rangsang_berkemih_1[0]) and ($mengendalikan_rangsang_berkemih_1[0]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_1_1" id="mengendalikan_rangsang_berkemih_1_1" value="1" ' . ((isset($mengendalikan_rangsang_berkemih_1[1]) and ($mengendalikan_rangsang_berkemih_1[1]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_1_2" id="mengendalikan_rangsang_berkemih_1_2" value="1" ' . ((isset($mengendalikan_rangsang_berkemih_1[2]) and ($mengendalikan_rangsang_berkemih_1[2]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_1_3" id="mengendalikan_rangsang_berkemih_1_3" value="1" ' . ((isset($mengendalikan_rangsang_berkemih_1[3]) and ($mengendalikan_rangsang_berkemih_1[3]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_1_4" id="mengendalikan_rangsang_berkemih_1_4" value="1" ' . ((isset($mengendalikan_rangsang_berkemih_1[4]) and ($mengendalikan_rangsang_berkemih_1[4]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_1_5" id="mengendalikan_rangsang_berkemih_1_5" value="1" ' . ((isset($mengendalikan_rangsang_berkemih_1[5]) and ($mengendalikan_rangsang_berkemih_1[5]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_1_6" id="mengendalikan_rangsang_berkemih_1_6" value="1" ' . ((isset($mengendalikan_rangsang_berkemih_1[6]) and ($mengendalikan_rangsang_berkemih_1[6]=='1')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td align="center">2</td>
		<td>Mandiri</td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_2_0" id="mengendalikan_rangsang_berkemih_2_0" value="2" ' . ((isset($mengendalikan_rangsang_berkemih_2[0]) and ($mengendalikan_rangsang_berkemih_2[0]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_2_1" id="mengendalikan_rangsang_berkemih_2_1" value="2" ' . ((isset($mengendalikan_rangsang_berkemih_2[1]) and ($mengendalikan_rangsang_berkemih_2[1]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_2_2" id="mengendalikan_rangsang_berkemih_2_2" value="2" ' . ((isset($mengendalikan_rangsang_berkemih_2[2]) and ($mengendalikan_rangsang_berkemih_2[2]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_2_3" id="mengendalikan_rangsang_berkemih_2_3" value="2" ' . ((isset($mengendalikan_rangsang_berkemih_2[3]) and ($mengendalikan_rangsang_berkemih_2[3]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_2_4" id="mengendalikan_rangsang_berkemih_2_4" value="2" ' . ((isset($mengendalikan_rangsang_berkemih_2[4]) and ($mengendalikan_rangsang_berkemih_2[4]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_2_5" id="mengendalikan_rangsang_berkemih_2_5" value="2" ' . ((isset($mengendalikan_rangsang_berkemih_2[5]) and ($mengendalikan_rangsang_berkemih_2[5]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mengendalikan_rangsang_berkemih_2_6" id="mengendalikan_rangsang_berkemih_2_6" value="2" ' . ((isset($mengendalikan_rangsang_berkemih_2[6]) and ($mengendalikan_rangsang_berkemih_2[6]=='2')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td rowspan="2" align="center">3</td>
		<td rowspan="2">Membersihkan diri (cuci muka, sisir rambut, sikat gigi)</td>
		<td align="center">0</td>
		<td>Butuh pertolongan orang lain</td>
		<td align="center"><input type="checkbox" name="membersihkan_diri_0_0" id="membersihkan_diri_0_0" value="0" ' . ((isset($membersihkan_diri_0[0]) and ($membersihkan_diri_0[0]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="membersihkan_diri_0_1" id="membersihkan_diri_0_1" value="0" ' . ((isset($membersihkan_diri_0[1]) and ($membersihkan_diri_0[1]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="membersihkan_diri_0_2" id="membersihkan_diri_0_2" value="0" ' . ((isset($membersihkan_diri_0[2]) and ($membersihkan_diri_0[2]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="membersihkan_diri_0_3" id="membersihkan_diri_0_3" value="0" ' . ((isset($membersihkan_diri_0[3]) and ($membersihkan_diri_0[3]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="membersihkan_diri_0_4" id="membersihkan_diri_0_4" value="0" ' . ((isset($membersihkan_diri_0[4]) and ($membersihkan_diri_0[4]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="membersihkan_diri_0_5" id="membersihkan_diri_0_5" value="0" ' . ((isset($membersihkan_diri_0[5]) and ($membersihkan_diri_0[5]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="membersihkan_diri_0_6" id="membersihkan_diri_0_6" value="0" ' . ((isset($membersihkan_diri_0[6]) and ($membersihkan_diri_0[6]=='0')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td align="center">1</td>
		<td>Mandiri</td>
		<td align="center"><input type="checkbox" name="membersihkan_diri_1_0" id="membersihkan_diri_1_0" value="1" ' . ((isset($membersihkan_diri_1[0]) and ($membersihkan_diri_1[0]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="membersihkan_diri_1_1" id="membersihkan_diri_1_1" value="1" ' . ((isset($membersihkan_diri_1[1]) and ($membersihkan_diri_1[1]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="membersihkan_diri_1_2" id="membersihkan_diri_1_2" value="1" ' . ((isset($membersihkan_diri_1[2]) and ($membersihkan_diri_1[2]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="membersihkan_diri_1_3" id="membersihkan_diri_1_3" value="1" ' . ((isset($membersihkan_diri_1[3]) and ($membersihkan_diri_1[3]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="membersihkan_diri_1_4" id="membersihkan_diri_1_4" value="1" ' . ((isset($membersihkan_diri_1[4]) and ($membersihkan_diri_1[4]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="membersihkan_diri_1_5" id="membersihkan_diri_1_5" value="1" ' . ((isset($membersihkan_diri_1[5]) and ($membersihkan_diri_1[5]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="membersihkan_diri_1_6" id="membersihkan_diri_1_6" value="1" ' . ((isset($membersihkan_diri_1[6]) and ($membersihkan_diri_1[6]=='1')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td rowspan="3" align="center">4</td>
		<td rowspan="3">Penggunaan jamban, masuk dan keluar (melepaskan, memakai celana, membersihkan, menyiram)</td>
		<td align="center">0</td>
		<td>Tergantung pertolongan orang lain</td>
		<td align="center"><input type="checkbox" name="penggunaan_jamban_0_0" id="penggunaan_jamban_0_0" value="0" ' . ((isset($penggunaan_jamban_0[0]) and ($penggunaan_jamban_0[0]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="penggunaan_jamban_0_1" id="penggunaan_jamban_0_1" value="0" ' . ((isset($penggunaan_jamban_0[1]) and ($penggunaan_jamban_0[1]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="penggunaan_jamban_0_2" id="penggunaan_jamban_0_2" value="0" ' . ((isset($penggunaan_jamban_0[2]) and ($penggunaan_jamban_0[2]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="penggunaan_jamban_0_3" id="penggunaan_jamban_0_3" value="0" ' . ((isset($penggunaan_jamban_0[3]) and ($penggunaan_jamban_0[3]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="penggunaan_jamban_0_4" id="penggunaan_jamban_0_4" value="0" ' . ((isset($penggunaan_jamban_0[4]) and ($penggunaan_jamban_0[4]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="penggunaan_jamban_0_5" id="penggunaan_jamban_0_5" value="0" ' . ((isset($penggunaan_jamban_0[5]) and ($penggunaan_jamban_0[5]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="penggunaan_jamban_0_6" id="penggunaan_jamban_0_6" value="0" ' . ((isset($penggunaan_jamban_0[6]) and ($penggunaan_jamban_0[6]=='0')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td align="center">1</td>
		<td>Perlu pertolongan pada beberapa kegiatan teapi dapat mengerjakan sendiri kegiatan yang lain</td>
		<td align="center"><input type="checkbox" name="penggunaan_jamban_1_0" id="penggunaan_jamban_1_0" value="1" ' . ((isset($penggunaan_jamban_1[0]) and ($penggunaan_jamban_1[0]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="penggunaan_jamban_1_1" id="penggunaan_jamban_1_1" value="1" ' . ((isset($penggunaan_jamban_1[1]) and ($penggunaan_jamban_1[1]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="penggunaan_jamban_1_2" id="penggunaan_jamban_1_2" value="1" ' . ((isset($penggunaan_jamban_1[2]) and ($penggunaan_jamban_1[2]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="penggunaan_jamban_1_3" id="penggunaan_jamban_1_3" value="1" ' . ((isset($penggunaan_jamban_1[3]) and ($penggunaan_jamban_1[3]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="penggunaan_jamban_1_4" id="penggunaan_jamban_1_4" value="1" ' . ((isset($penggunaan_jamban_1[4]) and ($penggunaan_jamban_1[4]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="penggunaan_jamban_1_5" id="penggunaan_jamban_1_5" value="1" ' . ((isset($penggunaan_jamban_1[5]) and ($penggunaan_jamban_1[5]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="penggunaan_jamban_1_6" id="penggunaan_jamban_1_6" value="1" ' . ((isset($penggunaan_jamban_1[6]) and ($penggunaan_jamban_1[6]=='1')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td align="center">2</td>
		<td>Mandiri</td>
		<td align="center"><input type="checkbox" name="penggunaan_jamban_2_0" id="penggunaan_jamban_2_0" value="2" ' . ((isset($penggunaan_jamban_2[0]) and ($penggunaan_jamban_2[0]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="penggunaan_jamban_2_1" id="penggunaan_jamban_2_1" value="2" ' . ((isset($penggunaan_jamban_2[1]) and ($penggunaan_jamban_2[1]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="penggunaan_jamban_2_2" id="penggunaan_jamban_2_2" value="2" ' . ((isset($penggunaan_jamban_2[2]) and ($penggunaan_jamban_2[2]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="penggunaan_jamban_2_3" id="penggunaan_jamban_2_3" value="2" ' . ((isset($penggunaan_jamban_2[3]) and ($penggunaan_jamban_2[3]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="penggunaan_jamban_2_4" id="penggunaan_jamban_2_4" value="2" ' . ((isset($penggunaan_jamban_2[4]) and ($penggunaan_jamban_2[4]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="penggunaan_jamban_2_5" id="penggunaan_jamban_2_5" value="2" ' . ((isset($penggunaan_jamban_2[5]) and ($penggunaan_jamban_2[5]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="penggunaan_jamban_2_6" id="penggunaan_jamban_2_6" value="2" ' . ((isset($penggunaan_jamban_2[6]) and ($penggunaan_jamban_2[6]=='2')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td rowspan="3" align="center">5</td>
		<td rowspan="3">Makan</td>
		<td align="center">0</td>
		<td>Tidak mampu</td>
		<td align="center"><input type="checkbox" name="makan_0_0" id="makan_0_0" value="0" ' . ((isset($makan_0[0]) and ($makan_0[0]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="makan_0_1" id="makan_0_1" value="0" ' . ((isset($makan_0[1]) and ($makan_0[1]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="makan_0_2" id="makan_0_2" value="0" ' . ((isset($makan_0[2]) and ($makan_0[2]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="makan_0_3" id="makan_0_3" value="0" ' . ((isset($makan_0[3]) and ($makan_0[3]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="makan_0_4" id="makan_0_4" value="0" ' . ((isset($makan_0[4]) and ($makan_0[4]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="makan_0_5" id="makan_0_5" value="0" ' . ((isset($makan_0[5]) and ($makan_0[5]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="makan_0_6" id="makan_0_6" value="0" ' . ((isset($makan_0[6]) and ($makan_0[6]=='0')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td align="center">1</td>
		<td>Perlu ditolong memotong makanan</td>
		<td align="center"><input type="checkbox" name="makan_1_0" id="makan_1_0" value="1" ' . ((isset($makan_1[0]) and ($makan_1[0]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="makan_1_1" id="makan_1_1" value="1" ' . ((isset($makan_1[1]) and ($makan_1[1]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="makan_1_2" id="makan_1_2" value="1" ' . ((isset($makan_1[2]) and ($makan_1[2]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="makan_1_3" id="makan_1_3" value="1" ' . ((isset($makan_1[3]) and ($makan_1[3]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="makan_1_4" id="makan_1_4" value="1" ' . ((isset($makan_1[4]) and ($makan_1[4]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="makan_1_5" id="makan_1_5" value="1" ' . ((isset($makan_1[5]) and ($makan_1[5]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="makan_1_6" id="makan_1_6" value="1" ' . ((isset($makan_1[6]) and ($makan_1[6]=='1')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td align="center">2</td>
		<td>Mandiri</td>
		<td align="center"><input type="checkbox" name="makan_2_0" id="makan_2_0" value="2" ' . ((isset($makan_2[0]) and ($makan_2[0]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="makan_2_1" id="makan_2_1" value="2" ' . ((isset($makan_2[1]) and ($makan_2[1]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="makan_2_2" id="makan_2_2" value="2" ' . ((isset($makan_2[2]) and ($makan_2[2]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="makan_2_3" id="makan_2_3" value="2" ' . ((isset($makan_2[3]) and ($makan_2[3]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="makan_2_4" id="makan_2_4" value="2" ' . ((isset($makan_2[4]) and ($makan_2[4]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="makan_2_5" id="makan_2_5" value="2" ' . ((isset($makan_2[5]) and ($makan_2[5]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="makan_2_6" id="makan_2_6" value="2" ' . ((isset($makan_2[6]) and ($makan_2[6]=='2')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td rowspan="4" align="center">6</td>
		<td rowspan="4">Berubah sikap dari berbaring ke duduk</td>
		<td align="center">0</td>
		<td>Tidak mampu</td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_0_0" id="berbaring_ke_duduk_0_0" value="0" ' . ((isset($berbaring_ke_duduk_0[0]) and ($berbaring_ke_duduk_0[0]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_0_1" id="berbaring_ke_duduk_0_1" value="0" ' . ((isset($berbaring_ke_duduk_0[1]) and ($berbaring_ke_duduk_0[1]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_0_2" id="berbaring_ke_duduk_0_2" value="0" ' . ((isset($berbaring_ke_duduk_0[2]) and ($berbaring_ke_duduk_0[2]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_0_3" id="berbaring_ke_duduk_0_3" value="0" ' . ((isset($berbaring_ke_duduk_0[3]) and ($berbaring_ke_duduk_0[3]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_0_4" id="berbaring_ke_duduk_0_4" value="0" ' . ((isset($berbaring_ke_duduk_0[4]) and ($berbaring_ke_duduk_0[4]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_0_5" id="berbaring_ke_duduk_0_5" value="0" ' . ((isset($berbaring_ke_duduk_0[5]) and ($berbaring_ke_duduk_0[5]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_0_6" id="berbaring_ke_duduk_0_6" value="0" ' . ((isset($berbaring_ke_duduk_0[6]) and ($berbaring_ke_duduk_0[6]=='0')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td align="center">1</td>
		<td>Perlu banyak bantuan untuk bisa duduk (2 orang)</td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_1_0" id="berbaring_ke_duduk_1_0" value="1" ' . ((isset($berbaring_ke_duduk_1[0]) and ($berbaring_ke_duduk_1[0]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_1_1" id="berbaring_ke_duduk_1_1" value="1" ' . ((isset($berbaring_ke_duduk_1[1]) and ($berbaring_ke_duduk_1[1]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_1_2" id="berbaring_ke_duduk_1_2" value="1" ' . ((isset($berbaring_ke_duduk_1[2]) and ($berbaring_ke_duduk_1[2]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_1_3" id="berbaring_ke_duduk_1_3" value="1" ' . ((isset($berbaring_ke_duduk_1[3]) and ($berbaring_ke_duduk_1[3]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_1_4" id="berbaring_ke_duduk_1_4" value="1" ' . ((isset($berbaring_ke_duduk_1[4]) and ($berbaring_ke_duduk_1[4]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_1_5" id="berbaring_ke_duduk_1_5" value="1" ' . ((isset($berbaring_ke_duduk_1[5]) and ($berbaring_ke_duduk_1[5]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_1_6" id="berbaring_ke_duduk_1_6" value="1" ' . ((isset($berbaring_ke_duduk_1[6]) and ($berbaring_ke_duduk_1[6]=='1')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td align="center">2</td>
		<td>Batuan (1 orang)</td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_2_0" id="berbaring_ke_duduk_2_0" value="2" ' . ((isset($berbaring_ke_duduk_2[0]) and ($berbaring_ke_duduk_2[0]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_2_1" id="berbaring_ke_duduk_2_1" value="2" ' . ((isset($berbaring_ke_duduk_2[1]) and ($berbaring_ke_duduk_2[1]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_2_2" id="berbaring_ke_duduk_2_2" value="2" ' . ((isset($berbaring_ke_duduk_2[2]) and ($berbaring_ke_duduk_2[2]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_2_3" id="berbaring_ke_duduk_2_3" value="2" ' . ((isset($berbaring_ke_duduk_2[3]) and ($berbaring_ke_duduk_2[3]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_2_4" id="berbaring_ke_duduk_2_4" value="2" ' . ((isset($berbaring_ke_duduk_2[4]) and ($berbaring_ke_duduk_2[4]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_2_5" id="berbaring_ke_duduk_2_5" value="2" ' . ((isset($berbaring_ke_duduk_2[5]) and ($berbaring_ke_duduk_2[5]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_2_6" id="berbaring_ke_duduk_2_6" value="2" ' . ((isset($berbaring_ke_duduk_2[6]) and ($berbaring_ke_duduk_2[6]=='2')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td align="center">3</td>
		<td>Mandiri</td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_3_0" id="berbaring_ke_duduk_3_0" value="3" ' . ((isset($berbaring_ke_duduk_3[0]) and ($berbaring_ke_duduk_3[0]=='3')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_3_1" id="berbaring_ke_duduk_3_1" value="3" ' . ((isset($berbaring_ke_duduk_3[1]) and ($berbaring_ke_duduk_3[1]=='3')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_3_2" id="berbaring_ke_duduk_3_2" value="3" ' . ((isset($berbaring_ke_duduk_3[2]) and ($berbaring_ke_duduk_3[2]=='3')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_3_3" id="berbaring_ke_duduk_3_3" value="3" ' . ((isset($berbaring_ke_duduk_3[3]) and ($berbaring_ke_duduk_3[3]=='3')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_3_4" id="berbaring_ke_duduk_3_4" value="3" ' . ((isset($berbaring_ke_duduk_3[4]) and ($berbaring_ke_duduk_3[4]=='3')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_3_5" id="berbaring_ke_duduk_3_5" value="3" ' . ((isset($berbaring_ke_duduk_3[5]) and ($berbaring_ke_duduk_3[5]=='3')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berbaring_ke_duduk_3_6" id="berbaring_ke_duduk_3_6" value="3" ' . ((isset($berbaring_ke_duduk_3[6]) and ($berbaring_ke_duduk_3[6]=='3')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td rowspan="4" align="center">7</td>
		<td rowspan="4">Berpindah/ berjalan</td>
		<td align="center">0</td>
		<td>Tidak mampu</td>
		<td align="center"><input type="checkbox" name="berjalan_0_0" id="berjalan_0_0" value="0" ' . ((isset($berjalan_0[0]) and ($berjalan_0[0]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_0_1" id="berjalan_0_1" value="0" ' . ((isset($berjalan_0[1]) and ($berjalan_0[1]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_0_2" id="berjalan_0_2" value="0" ' . ((isset($berjalan_0[2]) and ($berjalan_0[2]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_0_3" id="berjalan_0_3" value="0" ' . ((isset($berjalan_0[3]) and ($berjalan_0[3]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_0_4" id="berjalan_0_4" value="0" ' . ((isset($berjalan_0[4]) and ($berjalan_0[4]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_0_5" id="berjalan_0_5" value="0" ' . ((isset($berjalan_0[5]) and ($berjalan_0[5]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_0_6" id="berjalan_0_6" value="0" ' . ((isset($berjalan_0[6]) and ($berjalan_0[6]=='0')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td align="center">1</td>
		<td>Bisa (pindah) dengan kursi roda</td>
		<td align="center"><input type="checkbox" name="berjalan_1_0" id="berjalan_1_0" value="1" ' . ((isset($berjalan_1[0]) and ($berjalan_1[0]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_1_1" id="berjalan_1_1" value="1" ' . ((isset($berjalan_1[1]) and ($berjalan_1[1]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_1_2" id="berjalan_1_2" value="1" ' . ((isset($berjalan_1[2]) and ($berjalan_1[2]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_1_3" id="berjalan_1_3" value="1" ' . ((isset($berjalan_1[3]) and ($berjalan_1[3]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_1_4" id="berjalan_1_4" value="1" ' . ((isset($berjalan_1[4]) and ($berjalan_1[4]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_1_5" id="berjalan_1_5" value="1" ' . ((isset($berjalan_1[5]) and ($berjalan_1[5]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_1_6" id="berjalan_1_6" value="1" ' . ((isset($berjalan_1[6]) and ($berjalan_1[6]=='1')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td align="center">2</td>
		<td>Berjalan dengan bantuan 1 orang</td>
		<td align="center"><input type="checkbox" name="berjalan_2_0" id="berjalan_2_0" value="2" ' . ((isset($berjalan_2[0]) and ($berjalan_2[0]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_2_1" id="berjalan_2_1" value="2" ' . ((isset($berjalan_2[1]) and ($berjalan_2[1]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_2_2" id="berjalan_2_2" value="2" ' . ((isset($berjalan_2[2]) and ($berjalan_2[2]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_2_3" id="berjalan_2_3" value="2" ' . ((isset($berjalan_2[3]) and ($berjalan_2[3]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_2_4" id="berjalan_2_4" value="2" ' . ((isset($berjalan_2[4]) and ($berjalan_2[4]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_2_5" id="berjalan_2_5" value="2" ' . ((isset($berjalan_2[5]) and ($berjalan_2[5]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_2_6" id="berjalan_2_6" value="2" ' . ((isset($berjalan_2[6]) and ($berjalan_2[6]=='2')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td align="center">3</td>
		<td>Mandiri</td>
		<td align="center"><input type="checkbox" name="berjalan_3_0" id="berjalan_3_0" value="3" ' . ((isset($berjalan_3[0]) and ($berjalan_3[0]=='3')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_3_1" id="berjalan_3_1" value="3" ' . ((isset($berjalan_3[1]) and ($berjalan_3[1]=='3')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_3_2" id="berjalan_3_2" value="3" ' . ((isset($berjalan_3[2]) and ($berjalan_3[2]=='3')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_3_3" id="berjalan_3_3" value="3" ' . ((isset($berjalan_3[3]) and ($berjalan_3[3]=='3')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_3_4" id="berjalan_3_4" value="3" ' . ((isset($berjalan_3[4]) and ($berjalan_3[4]=='3')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_3_5" id="berjalan_3_5" value="3" ' . ((isset($berjalan_3[5]) and ($berjalan_3[5]=='3')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="berjalan_3_6" id="berjalan_3_6" value="3" ' . ((isset($berjalan_3[6]) and ($berjalan_3[6]=='3')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	</table>';
	
	ob_start();
	include('edoc_rekammedik/edoc_frame_main.php');
	$html = ob_get_contents();
	ob_end_clean();
	$mpdf->WriteHTML($html);	
	
	$edoc_content_2 = '<table width="100%" class="tbl" cellpadding="0" cellspacing="0" autosize="1" >
		<tr>
			<td rowspan="2" width="25px" align="center" bgcolor="#CCCCCC" ><strong>No</strong></td>
			<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Fungsi</strong></td>
			<td rowspan="2" width="40px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
			<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Uraian</strong></td>
			<td colspan="7" align="center" bgcolor="#CCCCCC" ><strong>Nilai Skor</strong></td>
		  </tr>
		  <tr>
			<td align="center" bgcolor="#CCCCCC" ><strong>Sebelum Sakit</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Saat Masuk</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Minggu I<br />Di RS</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Minggu II<br />Di RS</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Minggu III<br />Di RS</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Minggu IV<br />Di RS</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Saat Pulang</strong></td>
		  </tr>
	<tr>
		<td rowspan="3" align="center">8</td>
		<td rowspan="3">Memakai baju</td>
		<td align="center">0</td>
		<td>Tergantung orang lain</td>
		<td align="center"><input type="checkbox" name="memakai_baju_0_0" id="memakai_baju_0_0" value="0" ' . ((isset($memakai_baju_0[0]) and ($memakai_baju_0[0]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="memakai_baju_0_1" id="memakai_baju_0_1" value="0" ' . ((isset($memakai_baju_0[1]) and ($memakai_baju_0[1]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="memakai_baju_0_2" id="memakai_baju_0_2" value="0" ' . ((isset($memakai_baju_0[2]) and ($memakai_baju_0[2]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="memakai_baju_0_3" id="memakai_baju_0_3" value="0" ' . ((isset($memakai_baju_0[3]) and ($memakai_baju_0[3]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="memakai_baju_0_4" id="memakai_baju_0_4" value="0" ' . ((isset($memakai_baju_0[4]) and ($memakai_baju_0[4]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="memakai_baju_0_5" id="memakai_baju_0_5" value="0" ' . ((isset($memakai_baju_0[5]) and ($memakai_baju_0[5]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="memakai_baju_0_6" id="memakai_baju_0_6" value="0" ' . ((isset($memakai_baju_0[6]) and ($memakai_baju_0[6]=='0')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td align="center">1</td>
		<td>Sebagian dibantu (misalnya mengancingkan baju)</td>
		<td align="center"><input type="checkbox" name="memakai_baju_1_0" id="memakai_baju_1_0" value="1" ' . ((isset($memakai_baju_1[0]) and ($memakai_baju_1[0]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="memakai_baju_1_1" id="memakai_baju_1_1" value="1" ' . ((isset($memakai_baju_1[1]) and ($memakai_baju_1[1]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="memakai_baju_1_2" id="memakai_baju_1_2" value="1" ' . ((isset($memakai_baju_1[2]) and ($memakai_baju_1[2]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="memakai_baju_1_3" id="memakai_baju_1_3" value="1" ' . ((isset($memakai_baju_1[3]) and ($memakai_baju_1[3]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="memakai_baju_1_4" id="memakai_baju_1_4" value="1" ' . ((isset($memakai_baju_1[4]) and ($memakai_baju_1[4]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="memakai_baju_1_5" id="memakai_baju_1_5" value="1" ' . ((isset($memakai_baju_1[5]) and ($memakai_baju_1[5]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="memakai_baju_1_6" id="memakai_baju_1_6" value="1" ' . ((isset($memakai_baju_1[6]) and ($memakai_baju_1[6]=='1')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td align="center">2</td>
		<td>Mandiri</td>
		<td align="center"><input type="checkbox" name="memakai_baju_2_0" id="memakai_baju_2_0" value="2" ' . ((isset($memakai_baju_2[0]) and ($memakai_baju_2[0]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="memakai_baju_2_1" id="memakai_baju_2_1" value="2" ' . ((isset($memakai_baju_2[1]) and ($memakai_baju_2[1]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="memakai_baju_2_2" id="memakai_baju_2_2" value="2" ' . ((isset($memakai_baju_2[2]) and ($memakai_baju_2[2]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="memakai_baju_2_3" id="memakai_baju_2_3" value="2" ' . ((isset($memakai_baju_2[3]) and ($memakai_baju_2[3]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="memakai_baju_2_4" id="memakai_baju_2_4" value="2" ' . ((isset($memakai_baju_2[4]) and ($memakai_baju_2[4]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="memakai_baju_2_5" id="memakai_baju_2_5" value="2" ' . ((isset($memakai_baju_2[5]) and ($memakai_baju_2[5]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="memakai_baju_2_6" id="memakai_baju_2_6" value="2" ' . ((isset($memakai_baju_2[6]) and ($memakai_baju_2[6]=='2')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td rowspan="3" align="center">9</td>
		<td rowspan="3">Naik turun tangga</td>
		<td align="center">0</td>
		<td>Tidak mampu</td>
		<td align="center"><input type="checkbox" name="naik_turun_tangga_0_0" id="naik_turun_tangga_0_0" value="0" ' . ((isset($naik_turun_tangga_0[0]) and ($naik_turun_tangga_0[0]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="naik_turun_tangga_0_1" id="naik_turun_tangga_0_1" value="0" ' . ((isset($naik_turun_tangga_0[1]) and ($naik_turun_tangga_0[1]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="naik_turun_tangga_0_2" id="naik_turun_tangga_0_2" value="0" ' . ((isset($naik_turun_tangga_0[2]) and ($naik_turun_tangga_0[2]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="naik_turun_tangga_0_3" id="naik_turun_tangga_0_3" value="0" ' . ((isset($naik_turun_tangga_0[3]) and ($naik_turun_tangga_0[3]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="naik_turun_tangga_0_4" id="naik_turun_tangga_0_4" value="0" ' . ((isset($naik_turun_tangga_0[4]) and ($naik_turun_tangga_0[4]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="naik_turun_tangga_0_5" id="naik_turun_tangga_0_5" value="0" ' . ((isset($naik_turun_tangga_0[5]) and ($naik_turun_tangga_0[5]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="naik_turun_tangga_0_6" id="naik_turun_tangga_0_6" value="0" ' . ((isset($naik_turun_tangga_0[6]) and ($naik_turun_tangga_0[6]=='0')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td align="center">1</td>
		<td>Butuh pertolongan</td>
		<td align="center"><input type="checkbox" name="naik_turun_tangga_1_0" id="naik_turun_tangga_1_0" value="1" ' . ((isset($naik_turun_tangga_1[0]) and ($naik_turun_tangga_1[0]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="naik_turun_tangga_1_1" id="naik_turun_tangga_1_1" value="1" ' . ((isset($naik_turun_tangga_1[1]) and ($naik_turun_tangga_1[1]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="naik_turun_tangga_1_2" id="naik_turun_tangga_1_2" value="1" ' . ((isset($naik_turun_tangga_1[2]) and ($naik_turun_tangga_1[2]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="naik_turun_tangga_1_3" id="naik_turun_tangga_1_3" value="1" ' . ((isset($naik_turun_tangga_1[3]) and ($naik_turun_tangga_1[3]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="naik_turun_tangga_1_4" id="naik_turun_tangga_1_4" value="1" ' . ((isset($naik_turun_tangga_1[4]) and ($naik_turun_tangga_1[4]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="naik_turun_tangga_1_5" id="naik_turun_tangga_1_5" value="1" ' . ((isset($naik_turun_tangga_1[5]) and ($naik_turun_tangga_1[5]=='1')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="naik_turun_tangga_1_6" id="naik_turun_tangga_1_6" value="1" ' . ((isset($naik_turun_tangga_1[6]) and ($naik_turun_tangga_1[6]=='1')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td align="center">2</td>
		<td>Mandiri</td>
		<td align="center"><input type="checkbox" name="naik_turun_tangga_2_0" id="naik_turun_tangga_2_0" value="2" ' . ((isset($naik_turun_tangga_2[0]) and ($naik_turun_tangga_2[0]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="naik_turun_tangga_2_1" id="naik_turun_tangga_2_1" value="2" ' . ((isset($naik_turun_tangga_2[1]) and ($naik_turun_tangga_2[1]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="naik_turun_tangga_2_2" id="naik_turun_tangga_2_2" value="2" ' . ((isset($naik_turun_tangga_2[2]) and ($naik_turun_tangga_2[2]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="naik_turun_tangga_2_3" id="naik_turun_tangga_2_3" value="2" ' . ((isset($naik_turun_tangga_2[3]) and ($naik_turun_tangga_2[3]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="naik_turun_tangga_2_4" id="naik_turun_tangga_2_4" value="2" ' . ((isset($naik_turun_tangga_2[4]) and ($naik_turun_tangga_2[4]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="naik_turun_tangga_2_5" id="naik_turun_tangga_2_5" value="2" ' . ((isset($naik_turun_tangga_2[5]) and ($naik_turun_tangga_2[5]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="naik_turun_tangga_2_6" id="naik_turun_tangga_2_6" value="2" ' . ((isset($naik_turun_tangga_2[6]) and ($naik_turun_tangga_2[6]=='2')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td rowspan="2" align="center">10</td>
		<td rowspan="2">Mandi</td>
		<td align="center">0</td>
		<td>Tergantung orang lain</td>
		<td align="center"><input type="checkbox" name="mandi_0_0" id="mandi_0_0" value="0" ' . ((isset($mandi_0[0]) and ($mandi_0[0]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mandi_0_1" id="mandi_0_1" value="0" ' . ((isset($mandi_0[1]) and ($mandi_0[1]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mandi_0_2" id="mandi_0_2" value="0" ' . ((isset($mandi_0[2]) and ($mandi_0[2]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mandi_0_3" id="mandi_0_3" value="0" ' . ((isset($mandi_0[3]) and ($mandi_0[3]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mandi_0_4" id="mandi_0_4" value="0" ' . ((isset($mandi_0[4]) and ($mandi_0[4]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mandi_0_5" id="mandi_0_5" value="0" ' . ((isset($mandi_0[5]) and ($mandi_0[5]=='0')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mandi_0_6" id="mandi_0_6" value="0" ' . ((isset($mandi_0[6]) and ($mandi_0[6]=='0')) ? 'checked="checked"' : '') . ' /></td>
	</tr>
	<tr>
		<td align="center">2</td>
		<td>Mandiri</td>
		<td align="center"><input type="checkbox" name="mandi_2_0" id="mandi_2_0" value="2" ' . ((isset($mandi_2[0]) and ($mandi_2[0]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mandi_2_1" id="mandi_2_1" value="2" ' . ((isset($mandi_2[1]) and ($mandi_2[1]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mandi_2_2" id="mandi_2_2" value="2" ' . ((isset($mandi_2[2]) and ($mandi_2[2]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mandi_2_3" id="mandi_2_3" value="2" ' . ((isset($mandi_2[3]) and ($mandi_2[3]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mandi_2_4" id="mandi_2_4" value="2" ' . ((isset($mandi_2[4]) and ($mandi_2[4]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mandi_2_5" id="mandi_2_5" value="2" ' . ((isset($mandi_2[5]) and ($mandi_2[5]=='2')) ? 'checked="checked"' : '') . ' /></td>
		<td align="center"><input type="checkbox" name="mandi_2_6" id="mandi_2_6" value="2" ' . ((isset($mandi_2[6]) and ($mandi_2[6]=='2')) ? 'checked="checked"' : '') . ' /></td>
	</tr>';

	$skor_st_1 = '';
	$skor_st_2 = '';
	$skor_st_3 = '';
	$skor_st_4 = '';
	$skor_st_5 = '';
	$skor_st_6 = '';
	$skor_st_7 = '';

	if(!empty($status_fungsional_id)){
		$skor_st_1 = $mengendalikan_rangsang_defekasi_0[0] + $mengendalikan_rangsang_defekasi_1[0] + $mengendalikan_rangsang_defekasi_2[0] + 
					$mengendalikan_rangsang_berkemih_0[0] + $mengendalikan_rangsang_berkemih_1[0] + $mengendalikan_rangsang_berkemih_2[0] + 
					$membersihkan_diri_0[0] + $membersihkan_diri_1[0] + $penggunaan_jamban_0[0] + $penggunaan_jamban_1[0] + 
					$penggunaan_jamban_2[0] + $makan_0[0] + $makan_1[0] + $makan_2[0] + $berbaring_ke_duduk_0[0] + 
					$berbaring_ke_duduk_1[0] + $berbaring_ke_duduk_2[0] + $berbaring_ke_duduk_3[0] + $berjalan_0[0] + $berjalan_1[0] + 
					$berjalan_2[0] + $berjalan_3[0] + $memakai_baju_0[0] + $memakai_baju_1[0] + $memakai_baju_2[0] + 
					$naik_turun_tangga_0[0] + $naik_turun_tangga_1[0] + $naik_turun_tangga_2[0] + $mandi_0[0] + $mandi_2[0]; 
		$skor_st_2 = $mengendalikan_rangsang_defekasi_0[1] + $mengendalikan_rangsang_defekasi_1[1] + $mengendalikan_rangsang_defekasi_2[1] + 
					$mengendalikan_rangsang_berkemih_0[1] + $mengendalikan_rangsang_berkemih_1[1] + $mengendalikan_rangsang_berkemih_2[1] + 
					$membersihkan_diri_0[1] + $membersihkan_diri_1[1] + $penggunaan_jamban_0[1] + $penggunaan_jamban_1[1] + 
					$penggunaan_jamban_2[1] + $makan_0[1] + $makan_1[1] + $makan_2[1] + $berbaring_ke_duduk_0[1] + 
					$berbaring_ke_duduk_1[1] + $berbaring_ke_duduk_2[1] + $berbaring_ke_duduk_3[1] + $berjalan_0[1] + $berjalan_1[1] + 
					$berjalan_2[1] + $berjalan_3[1] + $memakai_baju_0[1] + $memakai_baju_1[1] + $memakai_baju_2[1] + 
					$naik_turun_tangga_0[1] + $naik_turun_tangga_1[1] + $naik_turun_tangga_2[1] + $mandi_0[1] + $mandi_2[1];
		$skor_st_3 = $mengendalikan_rangsang_defekasi_0[2] + $mengendalikan_rangsang_defekasi_1[2] + $mengendalikan_rangsang_defekasi_2[2] + 
					$mengendalikan_rangsang_berkemih_0[2] + $mengendalikan_rangsang_berkemih_1[2] + $mengendalikan_rangsang_berkemih_2[2] + 
					$membersihkan_diri_0[2] + $membersihkan_diri_1[2] + $penggunaan_jamban_0[2] + $penggunaan_jamban_1[2] + 
					$penggunaan_jamban_2[2] + $makan_0[2] + $makan_1[2] + $makan_2[2] + $berbaring_ke_duduk_0[2] + 
					$berbaring_ke_duduk_1[2] + $berbaring_ke_duduk_2[2] + $berbaring_ke_duduk_3[2] + $berjalan_0[2] + $berjalan_1[2] + 
					$berjalan_2[2] + $berjalan_3[2] + $memakai_baju_0[2] + $memakai_baju_1[2] + $memakai_baju_2[2] + 
					$naik_turun_tangga_0[2] + $naik_turun_tangga_1[2] + $naik_turun_tangga_2[2] + $mandi_0[2] + $mandi_2[2];	
		$skor_st_4 = $mengendalikan_rangsang_defekasi_0[3] + $mengendalikan_rangsang_defekasi_1[3] + $mengendalikan_rangsang_defekasi_2[3] + 
					$mengendalikan_rangsang_berkemih_0[3] + $mengendalikan_rangsang_berkemih_1[3] + $mengendalikan_rangsang_berkemih_2[3] + 
					$membersihkan_diri_0[3] + $membersihkan_diri_1[3] + $penggunaan_jamban_0[3] + $penggunaan_jamban_1[3] + 
					$penggunaan_jamban_2[3] + $makan_0[3] + $makan_1[3] + $makan_2[3] + $berbaring_ke_duduk_0[3] + 
					$berbaring_ke_duduk_1[3] + $berbaring_ke_duduk_2[3] + $berbaring_ke_duduk_3[3] + $berjalan_0[3] + $berjalan_1[3] + 
					$berjalan_2[3] + $berjalan_3[3] + $memakai_baju_0[3] + $memakai_baju_1[3] + $memakai_baju_2[3] + 
					$naik_turun_tangga_0[3] + $naik_turun_tangga_1[3] + $naik_turun_tangga_2[3] + $mandi_0[3] + $mandi_2[3];
		$skor_st_5 = $mengendalikan_rangsang_defekasi_0[4] + $mengendalikan_rangsang_defekasi_1[4] + $mengendalikan_rangsang_defekasi_2[4] + 
					$mengendalikan_rangsang_berkemih_0[4] + $mengendalikan_rangsang_berkemih_1[4] + $mengendalikan_rangsang_berkemih_2[4] + 
					$membersihkan_diri_0[4] + $membersihkan_diri_1[4] + $penggunaan_jamban_0[4] + $penggunaan_jamban_1[4] + 
					$penggunaan_jamban_2[4] + $makan_0[4] + $makan_1[4] + $makan_2[4] + $berbaring_ke_duduk_0[4] + 
					$berbaring_ke_duduk_1[4] + $berbaring_ke_duduk_2[4] + $berbaring_ke_duduk_3[4] + $berjalan_0[4] + $berjalan_1[4] + 
					$berjalan_2[4] + $berjalan_3[4] + $memakai_baju_0[4] + $memakai_baju_1[4] + $memakai_baju_2[4] + 
					$naik_turun_tangga_0[4] + $naik_turun_tangga_1[4] + $naik_turun_tangga_2[4] + $mandi_0[4] + $mandi_2[4];
		$skor_st_6 = $mengendalikan_rangsang_defekasi_0[5] + $mengendalikan_rangsang_defekasi_1[5] + $mengendalikan_rangsang_defekasi_2[5] + 
					$mengendalikan_rangsang_berkemih_0[5] + $mengendalikan_rangsang_berkemih_1[5] + $mengendalikan_rangsang_berkemih_2[5] + 
					$membersihkan_diri_0[5] + $membersihkan_diri_1[5] + $penggunaan_jamban_0[5] + $penggunaan_jamban_1[5] + 
					$penggunaan_jamban_2[5] + $makan_0[5] + $makan_1[5] + $makan_2[5] + $berbaring_ke_duduk_0[5] + 
					$berbaring_ke_duduk_1[5] + $berbaring_ke_duduk_2[5] + $berbaring_ke_duduk_3[5] + $berjalan_0[5] + $berjalan_1[5] + 
					$berjalan_2[5] + $berjalan_3[5] + $memakai_baju_0[5] + $memakai_baju_1[5] + $memakai_baju_2[5] + 
					$naik_turun_tangga_0[5] + $naik_turun_tangga_1[5] + $naik_turun_tangga_2[5] + $mandi_0[5] + $mandi_2[5];
		$skor_st_7 = $mengendalikan_rangsang_defekasi_0[6] + $mengendalikan_rangsang_defekasi_1[6] + $mengendalikan_rangsang_defekasi_2[6] + 
					$mengendalikan_rangsang_berkemih_0[6] + $mengendalikan_rangsang_berkemih_1[6] + $mengendalikan_rangsang_berkemih_2[6] + 
					$membersihkan_diri_0[6] + $membersihkan_diri_1[6] + $penggunaan_jamban_0[6] + $penggunaan_jamban_1[6] + 
					$penggunaan_jamban_2[6] + $makan_0[6] + $makan_1[6] + $makan_2[6] + $berbaring_ke_duduk_0[6] + 
					$berbaring_ke_duduk_1[6] + $berbaring_ke_duduk_2[6] + $berbaring_ke_duduk_3[6] + $berjalan_0[6] + $berjalan_1[6] + 
					$berjalan_2[6] + $berjalan_3[6] + $memakai_baju_0[6] + $memakai_baju_1[6] + $memakai_baju_2[6] + 
					$naik_turun_tangga_0[6] + $naik_turun_tangga_1[6] + $naik_turun_tangga_2[6] + $mandi_0[6] + $mandi_2[6];			
	}

	$edoc_content_2 = $edoc_content_2 . '<tr>
			<td colspan="4" align="center">TOTAL SKOR</td>
			<td align="center">' . $skor_st_1. '</td>
			<td align="center">' . $skor_st_2. '</td>
			<td align="center">' . $skor_st_3. '</td>
			<td align="center">' . $skor_st_4. '</td>
			<td align="center">' . $skor_st_5. '</td>
			<td align="center">' . $skor_st_6. '</td>
			<td align="center">' . $skor_st_7. '</td>
		</tr>
		<tr>
			<td colspan="4" align="center">Perawat</td>
			<td align="center">' . $perawat_arr[0] . '</td>
			<td align="center">' . $perawat_arr[1] . '</td>
			<td align="center">' . $perawat_arr[2] . '</td>
			<td align="center">' . $perawat_arr[3] . '</td>
			<td align="center">' . $perawat_arr[4] . '</td>
			<td align="center">' . $perawat_arr[5] . '</td>
			<td align="center">' . $perawat_arr[6] . '</td>
		</tr>
		</table>';	
	ob_start();
	include('edoc_rekammedik/edoc_frame_add.php');
	$html = ob_get_contents();
	ob_end_clean();
	$mpdf->AddPage('P');
	$mpdf->WriteHTML($html);
	$st_print = true;		
}
//end Penilaian Status Fungsional

//Pengkajian Awal Rawat Inap Umum
$edoc_nama_documen = strtoupper('Pengkajian Awal Rawat Inap Umum');

$qry_pengkajian = 'SELECT PENGKAJIAN_AWAL_ID,NAMA_PANGGILAN,STATUS_KAWIN,STATUS_KAWIN_KET,JUMLAH_ANAK,AGAMA,PENDIDIKAN,PENDIDIKAN_KET,PEKERJAAN,
			PEKERJAAN_KET,ALAMAT,NO_TELEPON,
			DATE_FORMAT(TANGGAL_MASUK,"%d/%m/%Y") AS TANGGAL_MASUK,
			DATE_FORMAT(TANGGAL_MASUK,"%H:%i") AS JAM_MASUK,
			DATE_FORMAT(TANGGAL_MASUK,"%i") AS MENIT_MASUK,
			CARA_MASUK,TIDAK_ADA_ALERGI,ALERGI_OBAT,ALERGI_OBAT_KET,ALERGI_OBAT_REAKSI,
			ALERGI_MAKANAN,ALERGI_MAKANAN_KET,ALERGI_MAKANAN_REAKSI,ALERGI_LAINNYA,ALERGI_LAINNYA_KET,ALERGI_LAINNYA_REAKSI,GELANG_TANDA_ALERGI,
			ALERGI_TIDAK_DIKETAHUI,ALASAN_MASUK_RS,PERNAH_DIRAWAT,PERNAH_DIRAWAT_KAPAN,PERNAH_DIRAWAT_DIMANA,DIAGNOSIS,TANDA_VITAL,TERPASANG_ALAT_IMPLAN,
			TERPASANG_ALAT_IMPLAN_KET,PENYAKIT_RIWAYAT_KELUARGA,PENYAKIT_RIWAYAT_PENYAKIT,PENYAKIT_RIWAYAT_KET,STATUS_PSIKOLOGIS,STATUS_PSIKOLOGIS_KET,
			STATUS_MENTAL,STATUS_MENTAL_KET_1,STATUS_MENTAL_KET_2,STATUS_SOSIAL,STATUS_SOSIAL_KET,STATUS_SOSIAL_KERABAT,PEMERIKSAAN_FISIK_KEPALA,
			PEMERIKSAAN_FISIK_MATA,PEMERIKSAAN_FISIK_TELINGA,PEMERIKSAAN_FISIK_HIDUNG,PEMERIKSAAN_FISIK_MULUT,PEMERIKSAAN_FISIK_LEHER,PEMERIKSAAN_FISIK_THORAX,
			PEMERIKSAAN_FISIK_ABDOMEN,PEMERIKSAAN_FISIK_KULIT,PEMERIKSAAN_FISIK_TERKAIT_PENYAKIT,SKRINING_GIZI,STATUS_FUNGSIONAL,STATUS_FUNGSIONAL_KET,
			RISIKO_CEDERA,SKRINING_NYERI,PEMERIKSAAN_PENUNJANG,KEBUTUHAN_EDUKASI,DATE_FORMAT(TANGGAL,"%d/%m/%Y %H:%i") AS TANGGAL,
			DATE_FORMAT(TANGGAL,"%H") AS JAM,DATE_FORMAT(TANGGAL,"%i") AS MENIT,
			DATE_FORMAT(TANGGAL_PELENGKAP,"%d/%m/%Y %H:%i") AS TANGGAL_PELENGKAP,DATE_FORMAT(TANGGAL_PELENGKAP,"%H") AS JAM_PELENGKAP,
			DATE_FORMAT(TANGGAL_PELENGKAP,"%i") AS MENIT_PELENGKAP,m_pegawai.NAMA_PEGAWAI AS PERAWAT,m_pegawai2.NAMA_PEGAWAI AS PERAWAT_PELENGKAP	
			FROM t_irna_askep_pengkajian_awal
			LEFT JOIN m_pegawai ON (t_irna_askep_pengkajian_awal.PERAWAT = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai2 ON (t_irna_askep_pengkajian_awal.PERAWAT = m_pegawai2.PEGAWAI_ID)
			WHERE PENGKAJIAN_AWAL_ID = "' . $idx . '"';
$get_pengkajian = mysql_query($qry_pengkajian) or die(mysql_error());
if(mysql_num_rows($get_pengkajian) > 0){
	$dat_pengkajian = mysql_fetch_assoc($get_pengkajian);
	
	$pengkajian_awal_id = $dat_pengkajian['PENGKAJIAN_AWAL_ID'];
	$nama_panggilan = $dat_pengkajian['NAMA_PANGGILAN'];
	$status_kawin = $dat_pengkajian['STATUS_KAWIN'];
	$status_kawin_ket = $dat_pengkajian['STATUS_KAWIN_KET'];
	$jumlah_anak = $dat_pengkajian['JUMLAH_ANAK'];
	$agama = $dat_pengkajian['AGAMA'];
	$pendidikan = $dat_pengkajian['PENDIDIKAN'];
	$pendidikan_ket = $dat_pengkajian['PENDIDIKAN_KET'];
	$pekerjaan = $dat_pengkajian['PEKERJAAN'];
	$pekerjaan_ket = $dat_pengkajian['PEKERJAAN_KET'];
	$alamat = $dat_pengkajian['ALAMAT'];
	$no_telepon = $dat_pengkajian['NO_TELEPON'];
	$tanggal_masuk = $dat_pengkajian['TANGGAL_MASUK'];
	$jam_masuk = $dat_pengkajian['JAM_MASUK'];
	$menit_masuk = $dat_pengkajian['MENIT_MASUK'];
	$cara_masuk = $dat_pengkajian['CARA_MASUK'];
	$tidak_ada_alergi = $dat_pengkajian['TIDAK_ADA_ALERGI'];
	$alergi_obat = $dat_pengkajian['ALERGI_OBAT'];
	$alergi_obat_ket = $dat_pengkajian['ALERGI_OBAT_KET'];
	$alergi_obat_reaksi = $dat_pengkajian['ALERGI_OBAT_REAKSI'];
	$alergi_makanan = $dat_pengkajian['ALERGI_MAKANAN'];
	$alergi_makanan_ket = $dat_pengkajian['ALERGI_MAKANAN_KET'];
	$alergi_makanan_reaksi = $dat_pengkajian['ALERGI_MAKANAN_REAKSI'];
	$alergi_lainnya = $dat_pengkajian['ALERGI_LAINNYA'];
	$alergi_lainnya_ket = $dat_pengkajian['ALERGI_LAINNYA_KET'];
	$alergi_lainnya_reaksi = $dat_pengkajian['ALERGI_LAINNYA_REAKSI'];
	$gelang_tanda_alergi = $dat_pengkajian['GELANG_TANDA_ALERGI'];
	$alergi_tidak_diketahui = $dat_pengkajian['ALERGI_TIDAK_DIKETAHUI'];
	$alasan_masuk_rs = $dat_pengkajian['ALASAN_MASUK_RS'];
	$pernah_dirawat = $dat_pengkajian['PERNAH_DIRAWAT'];
	$pernah_dirawat_kapan = $dat_pengkajian['PERNAH_DIRAWAT_KAPAN'];
	$pernah_dirawat_dimana = $dat_pengkajian['PERNAH_DIRAWAT_DIMANA'];
	$diagnosis = $dat_pengkajian['DIAGNOSIS'];
	$tanda_vital = $dat_pengkajian['TANDA_VITAL'];
	$terpasang_alat_implan = $dat_pengkajian['TERPASANG_ALAT_IMPLAN'];
	$terpasang_alat_implan_ket = $dat_pengkajian['TERPASANG_ALAT_IMPLAN_KET'];
	$penyakit_riwayat_keluarga = $dat_pengkajian['PENYAKIT_RIWAYAT_KELUARGA'];
	$penyakit_riwayat_penyakit = $dat_pengkajian['PENYAKIT_RIWAYAT_PENYAKIT'];
	$penyakit_riwayat_ket = $dat_pengkajian['PENYAKIT_RIWAYAT_KET'];
	$status_psikologis = $dat_pengkajian['STATUS_PSIKOLOGIS'];
	$status_psikologis_ket = $dat_pengkajian['STATUS_PSIKOLOGIS_KET'];
	$status_mental = $dat_pengkajian['STATUS_MENTAL'];
	$status_mental_ket_1 = $dat_pengkajian['STATUS_MENTAL_KET_1'];
	$status_mental_ket_2 = $dat_pengkajian['STATUS_MENTAL_KET_2'];
	$status_sosial = $dat_pengkajian['STATUS_SOSIAL'];
	$status_sosial_ket = $dat_pengkajian['STATUS_SOSIAL_KET'];
	$status_sosial_kerabat = $dat_pengkajian['STATUS_SOSIAL_KERABAT'];
	$pemeriksaan_fisik_kepala = $dat_pengkajian['PEMERIKSAAN_FISIK_KEPALA'];
	$pemeriksaan_fisik_mata = $dat_pengkajian['PEMERIKSAAN_FISIK_MATA'];
	$pemeriksaan_fisik_telinga = $dat_pengkajian['PEMERIKSAAN_FISIK_TELINGA'];
	$pemeriksaan_fisik_hidung = $dat_pengkajian['PEMERIKSAAN_FISIK_HIDUNG'];
	$pemeriksaan_fisik_mulut = $dat_pengkajian['PEMERIKSAAN_FISIK_MULUT'];
	$pemeriksaan_fisik_leher = $dat_pengkajian['PEMERIKSAAN_FISIK_LEHER'];
	$pemeriksaan_fisik_thorax = $dat_pengkajian['PEMERIKSAAN_FISIK_THORAX'];
	$pemeriksaan_fisik_abdomen = $dat_pengkajian['PEMERIKSAAN_FISIK_ABDOMEN'];
	$pemeriksaan_fisik_kulit = $dat_pengkajian['PEMERIKSAAN_FISIK_KULIT'];
	$pemeriksaan_fisik_terkait_penyakit = $dat_pengkajian['PEMERIKSAAN_FISIK_TERKAIT_PENYAKIT'];
	$skrining_gizi = $dat_pengkajian['SKRINING_GIZI'];
	$status_fungsional = $dat_pengkajian['STATUS_FUNGSIONAL'];
	$status_fungsional_ket = $dat_pengkajian['STATUS_FUNGSIONAL_KET'];
	$risiko_cedera = $dat_pengkajian['RISIKO_CEDERA'];
	$skrining_nyeri = $dat_pengkajian['SKRINING_NYERI'];
	$pemeriksaan_penunjang = $dat_pengkajian['PEMERIKSAAN_PENUNJANG'];
	$kebutuhan_edukasi = $dat_pengkajian['KEBUTUHAN_EDUKASI'];			
	$tanggal = $dat_pengkajian['TANGGAL'];			
	$jam = $dat_pengkajian['JAM'];			
	$menit = $dat_pengkajian['MENIT'];			
	$perawat = $dat_pengkajian['PERAWAT'];		
	$tanggal_pelengkap = $dat_pengkajian['TANGGAL_PELENGKAP'];			
	$jam_pelengkap = $dat_pengkajian['JAM_PELENGKAP'];			
	$menit_pelengkap = $dat_pengkajian['MENIT_PELENGKAP'];				
	$perawat_pelengkap = $dat_pengkajian['PERAWAT_PELENGKAP'];			

	$arr_tanda_vital = explode('||',$tanda_vital);
	$arr_penyakit_riwayat_keluarga = explode('||',$penyakit_riwayat_keluarga);
	$arr_penyakit_riwayat_penyakit = explode('||',$penyakit_riwayat_penyakit);
	$arr_status_psikologis = explode('||',$status_psikologis);
	$arr_status_mental = explode('||',$status_mental);
	$arr_status_sosial = explode('||',$status_sosial);
	$arr_status_sosial_kerabat = explode('||',$status_sosial_kerabat);
	$arr_pemeriksaan_fisik_kepala = explode('||',$pemeriksaan_fisik_kepala);
	$arr_pemeriksaan_fisik_mata = explode('||',$pemeriksaan_fisik_mata);
	$arr_pemeriksaan_fisik_telinga = explode('||',$pemeriksaan_fisik_telinga);
	$arr_pemeriksaan_fisik_hidung = explode('||',$pemeriksaan_fisik_hidung);
	$arr_pemeriksaan_fisik_mulut = explode('||',$pemeriksaan_fisik_mulut);
	$arr_pemeriksaan_fisik_leher = explode('||',$pemeriksaan_fisik_leher);
	$arr_pemeriksaan_fisik_thorax = explode('||',$pemeriksaan_fisik_thorax);
	$arr_pemeriksaan_fisik_abdomen = explode('||',$pemeriksaan_fisik_abdomen);
	$arr_pemeriksaan_fisik_kulit = explode('||',$pemeriksaan_fisik_kulit);
	$arr_skrining_gizi = explode('||',$skrining_gizi);
	$arr_risiko_cedera = explode('||',$risiko_cedera);
	$arr_skrining_nyeri = explode('||',$skrining_nyeri);
	$arr_kebutuhan_edukasi = explode('||',$kebutuhan_edukasi);
	
	$edoc_content = '<table width="100%" cellpadding="0" cellspacing="0" autosize="1" >
				<tr>
						<td width="260px">&nbsp;</td>
						<td>&nbsp;</td>
				</tr>
				<tr>
				<td>Tanggal</td>
				<td>:&nbsp;' . setGarisIfNull($tanggal) . '</td>
				</tr>
				<tr>
					<td>Perawat yang melakukan pengkajian</td>
					<td>:&nbsp;' .  setGarisIfNull($perawat) . '</td>
				</tr>
				<tr>
					<td>Tanggal</td><td>:&nbsp;' . setGarisIfNull($tanggal_pelengkap) . '</td>
				</tr>
				<tr>
					<td>Perawat yang melengkapi pengkajian</td>
					<td>:&nbsp;' . setGarisIfNull($perawat_pelengkap) . '</td>
				</tr>
				<tr>
						<td width="260px">&nbsp;</td>
						<td>&nbsp;</td>
				</tr>
			</table>
	<table width="100%" cellpadding="0" cellspacing="0" autosize="1" >
<tr>
    <td colspan="4">1. IDENTITAS PASIEN</td>
</tr>
<tr>
	<td width="150px;">&nbsp;</td>
    <td width="200px;">Nama Panggilan</td>
	<td colspan="2">:&nbsp;' . setGarisIfNull($nama_panggilan) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">Status Perkawinan</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="status_kawin" id="status_kawin" value="1" ' . (($status_kawin == '1') ? 'checked="checked"' : '') . ' />&nbsp;Kawin, Perkawinan ke
		' . setGarisIfNull($status_kawin_ket) . '
		<input type="checkbox" name="status_kawin" id="status_kawin" value="2" ' . (($status_kawin == '2') ? 'checked="checked"' : '') . ' />&nbsp;Janda
		<input type="checkbox" name="status_kawin" id="status_kawin" value="3" ' . (($status_kawin == '3') ? 'checked="checked"' : '') . ' />&nbsp;Duda
		<input type="checkbox" name="status_kawin" id="status_kawin" value="4" ' . (($status_kawin == '4') ? 'checked="checked"' : '') . ' />&nbsp;Belum Kawin</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>Jumlah Anak</td>
	<td colspan="2">:&nbsp;' . setGarisIfNull($jumlah_anak) . ' orang</td>
</tr>
<tr>
	<td>&nbsp;</td>	
    <td valign="top">Agama</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="agama" id="agama" value="1" ' . (($agama == '1') ? 'checked="checked"' : '') . ' />&nbsp;Islam
	<input type="checkbox" name="agama" id="agama" value="2" ' . (($agama == '3') ? 'checked="checked"' : '') . ' />&nbsp;Kristen Katolik
	<input type="checkbox" name="agama" id="agama" value="3" ' . (($agama == '2') ? 'checked="checked"' : '') . ' />&nbsp;Kristen Protestan
	<input type="checkbox" name="agama" id="agama" value="4" ' . (($agama == '5') ? 'checked="checked"' : '') . ' />&nbsp;Budha
	<input type="checkbox" name="agama" id="agama" value="5" ' . (($agama == '4') ? 'checked="checked"' : '') . ' />&nbsp;Hindu</td>
</tr>
<tr>
	<td>&nbsp;</td>	
    <td valign="top">Pendidikan</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pendidikan" id="pendidikan" value="1" ' . (($pendidikan == '1') ? 'checked="checked"' : '') . ' />&nbsp;SD
	<input type="checkbox" name="pendidikan" id="pendidikan" value="2" ' . (($pendidikan == '2') ? 'checked="checked"' : '') . ' />&nbsp;SMP
	<input type="checkbox" name="pendidikan" id="pendidikan" value="3" ' . (($pendidikan == '3') ? 'checked="checked"' : '') . ' />&nbsp;SMU
	<input type="checkbox" name="pendidikan" id="pendidikan" value="4" ' . (($pendidikan == '4') ? 'checked="checked"' : '') . ' />&nbsp;D3
	<input type="checkbox" name="pendidikan" id="pendidikan" value="5" ' . (($pendidikan == '5') ? 'checked="checked"' : '') . ' />&nbsp;S1
	<input type="checkbox" name="pendidikan" id="pendidikan" value="6" ' . (($pendidikan == '6') ? 'checked="checked"' : '') . ' />&nbsp;Dll
	&nbsp;' . setGarisIfNull($pendidikan_ket) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">Pekerjaan</td>
	<td colspan="2"><input type="checkbox" name="pekerjaan" id="pekerjaan" value="1" ' . (($pekerjaan == '1') ? 'checked="checked"' : '') . ' />&nbsp;Swasta
	<input type="checkbox" name="pekerjaan" id="pekerjaan" value="2" ' . (($pekerjaan == '2') ? 'checked="checked"' : '') . ' />&nbsp;BUMN
	<input type="checkbox" name="pekerjaan" id="pekerjaan" value="3" ' . (($pekerjaan == '3') ? 'checked="checked"' : '') . ' />&nbsp;PNS
	<input type="checkbox" name="pekerjaan" id="pekerjaan" value="4" ' . (($pekerjaan == '4') ? 'checked="checked"' : '') . ' />&nbsp;Wiraswasta
	<input type="checkbox" name="pekerjaan" id="pekerjaan" value="5" ' . (($pekerjaan == '5') ? 'checked="checked"' : '') . ' />&nbsp;Dll
	&nbsp;' . setGarisIfNull($pekerjaan_ket) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">Alamat</td>
	<td colspan="2">:&nbsp;' . setGarisIfNull($alamat) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>No Telepon</td>
	<td colspan="2">:&nbsp;' . setGarisIfNull($no_telepon) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">Tanggal Masuk</td>
	<td colspan="2"colspan="2">:&nbsp;' . setGarisIfNull($tanggal_masuk) . ' Pukul ' . setGarisIfNull($jam_masuk) . '
	Dengan <input type="checkbox" name="cara_masuk" id="cara_masuk" value="1" ' . (($cara_masuk == '1') ? 'checked="checked"' : '') . ' />&nbsp;Jalan
	<input type="checkbox" name="cara_masuk" id="cara_masuk" value="2" ' . (($cara_masuk == '2') ? 'checked="checked"' : '') . ' />&nbsp;Kursi Roda
	<input type="checkbox" name="cara_masuk" id="cara_masuk" value="3" ' . (($cara_masuk == '3') ? 'checked="checked"' : '') . ' />&nbsp;Brand Kard</td>
</tr>
<tr>
    <td colspan="4">&nbsp;</td>
</tr>
<tr>
    <td colspan="4" align="center">ALERGI/ REAKSI</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3"><input type="checkbox" name="tidak_ada_alergi" id="tidak_ada_alergi" value="1" ' . (($tidak_ada_alergi == '1') ? 'checked="checked"' : '') . ' />&nbsp;Tidak ada alergi</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3"><input type="checkbox" name="alergi_obat" id="alergi_obat" value="1" ' . (($alergi_obat == '1') ? 'checked="checked"' : '') . ' />&nbsp;Alergi obat, sebutkan
	&nbsp;' . setGarisIfNull($alergi_obat_ket) . '
	&nbsp;Reaksi&nbsp;&nbsp;' . setGarisIfNull($alergi_obat_reaksi) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3"><input type="checkbox" name="alergi_makanan" id="alergi_makanan" value="1" ' . (($alergi_makanan == '1') ? 'checked="checked"' : '') . ' />&nbsp;Alergi makanan, sebutkan
	&nbsp;' . setGarisIfNull($alergi_makanan_ket) . '
	&nbsp;Reaksi&nbsp;&nbsp;' . setGarisIfNull($alergi_makanan_reaksi) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3"><input type="checkbox" name="alergi_lainnya" id="alergi_lainnya" value="1" ' . (($alergi_lainnya == '1') ? 'checked="checked"' : '') . ' />&nbsp;Alergi lainnya, sebutkan
	&nbsp;' . setGarisIfNull($alergi_lainnya_ket) . '
	&nbsp;Reaksi&nbsp;&nbsp;' . setGarisIfNull($alergi_lainnya_reaksi) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3"><input type="checkbox" name="gelang_tanda_alergi" id="gelang_tanda_alergi" value="1" ' . (($gelang_tanda_alergi == '1') ? 'checked="checked"' : '') . ' />&nbsp;Gelang Tanda Alergi dipasang (warna merah)</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3"><input type="checkbox" name="alergi_tidak_diketahui" id="alergi_tidak_diketahui" value="1" ' . (($alergi_tidak_diketahui == '1') ? 'checked="checked"' : '') . ' />&nbsp;Tidak diketahui</td>
</tr>
<tr>
    <td colspan="4">&nbsp;</td>
</tr>
<tr>
    <td colspan="4">2. ALASAN MASUK RS (Keluhan utama saat masuk RS)</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td colspan="3">&nbsp;' . setGarisIfNull($alasan_masuk_rs) . '</td>
</tr>
<tr>
    <td colspan="4">&nbsp;</td>
</tr>
<tr>
    <td colspan="4">3. RIWAYAT KESEHATAN/ PENGOBATAN/ PERAWATAN SEBELUMNYA</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">Pernah dirawat</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pernah_dirawat" id="pernah_dirawat" value="1" ' . (($pernah_dirawat == '1') ? 'checked="checked"' : '') . ' />&nbsp;Ya
	<input type="checkbox" name="pernah_dirawat" id="pernah_dirawat" value="2" ' . (($pernah_dirawat == '2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak<br />
	Kapan &nbsp;' . setGarisIfNull($pernah_dirawat_kapan) . '&nbsp;Di mana &nbsp;' . setGarisIfNull($pernah_dirawat_dimana) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
    <td colspan="2">Diagnosis &nbsp;' . setGarisIfNull($diagnosis) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">Tanda-tanda vital</td>
	<td colspan="2">:&nbsp;Suhu&nbsp;' . ((isset($arr_tanda_vital[0])) ? setGarisIfNull($arr_tanda_vital[0]) : $adline) .' C,&nbsp;
	Nadi ' . ((isset($arr_tanda_vital[1]))? setGarisIfNull($arr_tanda_vital[1]) : $adline) . ' x/mnt&nbsp;
	<input type="checkbox" name="tanda_vital_3" id="tanda_vital_3" value="1" ' . ((isset($arr_tanda_vital[2]) and $arr_tanda_vital[2] == '1') ? 'checked="checked"' : '') . ' />&nbsp;reguler
	<input type="checkbox" name="tanda_vital_3" id="tanda_vital_3" value="2" ' . ((isset($arr_tanda_vital[2]) and $arr_tanda_vital[2] == '2') ? 'checked="checked"' : '') . ' />&nbsp;ireguler<br />
	TD ' . ((isset($arr_tanda_vital[3])) ? setGarisIfNull($arr_tanda_vital[3]) : $adline) . ' mmHg,&nbsp;
	Pernapasan ' . ((isset($arr_tanda_vital[4])) ? setGarisIfNull($arr_tanda_vital[4]) : $adline) . ' x/mnt,&nbsp;
	BB ' . ((isset($arr_tanda_vital[5])) ? setGarisIfNull($arr_tanda_vital[5]) : $adline) . ' kg&nbsp;<br />
	Tinggi badan ' . ((isset($arr_tanda_vital[6])) ? setGarisIfNull($arr_tanda_vital[6]) : $adline) . ' cm
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3"><input type="checkbox" name="terpasang_alat_implan" id="terpasang_alat_implan" value="1" ' . (($terpasang_alat_implan == '1') ? 'checked="checked"' : '') . ' />&nbsp;Alat implant yang terpasang, sebutkan
	' . setGarisIfNull($terpasang_alat_implan_ket) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td colspan="3">Apakah ada riwayat dalam keluarga
	(<input type="checkbox" name="penyakit_riwayat_keluarga_1" id="penyakit_riwayat_keluarga_1" value="1" ' . ((isset($arr_penyakit_riwayat_keluarga[0]) and $arr_penyakit_riwayat_keluarga[0] == '1') ? 'checked="checked"' : '') . ' />&nbsp;ayah
	<input type="checkbox" name="penyakit_riwayat_keluarga_2" id="penyakit_riwayat_keluarga_2" value="1" ' . ((isset($arr_penyakit_riwayat_keluarga[1]) and $arr_penyakit_riwayat_keluarga[1] == '1') ? 'checked="checked"' : '') . ' />&nbsp;ibu
	<input type="checkbox" name="penyakit_riwayat_keluarga_3" id="penyakit_riwayat_keluarga_3" value="1" ' . ((isset($arr_penyakit_riwayat_keluarga[2]) and $arr_penyakit_riwayat_keluarga[2] == '1') ? 'checked="checked"' : '') . ' />&nbsp;kakek
	<input type="checkbox" name="penyakit_riwayat_keluarga_4" id="penyakit_riwayat_keluarga_4" value="1" ' . ((isset($arr_penyakit_riwayat_keluarga[3]) and $arr_penyakit_riwayat_keluarga[3] == '1') ? 'checked="checked"' : '') . ' />&nbsp;nenek)
		memiliki penyakit Mayor
	<input type="checkbox" name="penyakit_riwayat_penyakit_1" id="penyakit_riwayat_penyakit_1" value="1" ' . ((isset($arr_penyakit_riwayat_penyakit[0]) and $arr_penyakit_riwayat_penyakit[0] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Asma
	<input type="checkbox" name="penyakit_riwayat_penyakit_2" id="penyakit_riwayat_penyakit_2" value="1" ' . ((isset($arr_penyakit_riwayat_penyakit[1]) and $arr_penyakit_riwayat_penyakit[1] == '1') ? 'checked="checked"' : '') . ' />&nbsp;DM<br />
	<input type="checkbox" name="penyakit_riwayat_penyakit_3" id="penyakit_riwayat_penyakit_3" value="1" ' . ((isset($arr_penyakit_riwayat_penyakit[2]) and $arr_penyakit_riwayat_penyakit[2] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Cardiovascular
	<input type="checkbox" name="penyakit_riwayat_penyakit_4" id="penyakit_riwayat_penyakit_4" value="1" ' . ((isset($arr_penyakit_riwayat_penyakit[3]) and $arr_penyakit_riwayat_penyakit[3] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Kanker
	<input type="checkbox" name="penyakit_riwayat_penyakit_5" id="penyakit_riwayat_penyakit_5" value="1" ' . ((isset($arr_penyakit_riwayat_penyakit[4]) and $arr_penyakit_riwayat_penyakit[4] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Talasemia
	<input type="checkbox" name="penyakit_riwayat_penyakit_6" id="penyakit_riwayat_penyakit_6" value="1" ' . ((isset($arr_penyakit_riwayat_penyakit[5]) and $arr_penyakit_riwayat_penyakit[5] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Lain-lain, sebutkan
	' . setGarisIfNull($penyakit_riwayat_ket) . '</td>
	</td>
</tr>
</table>';

ob_start();
include('edoc_rekammedik/edoc_frame_main.php');
$html = ob_get_contents();
ob_end_clean();
if($st_print == true) $mpdf->AddPage('P');
$mpdf->WriteHTML($html);

$edoc_content_2 = '<table width="100%" cellpadding="0" cellspacing="0" autosize="1" >
<tr>
    <td colspan="4">4. RIWAYAT PSIKOSOSIAL</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">Status Psikologis</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="status_psikologis_1" id="status_psikologis_1" value="1" ' . ((isset($arr_status_psikologis[0]) and $arr_status_psikologis[0] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Cemas
	<input type="checkbox" name="status_psikologis_2" id="status_psikologis_2" value="1" ' . ((isset($arr_status_psikologis[1]) and $arr_status_psikologis[1] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Takut
	<input type="checkbox" name="status_psikologis_3" id="status_psikologis_3" value="1" ' . ((isset($arr_status_psikologis[2]) and $arr_status_psikologis[2] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Marah
	<input type="checkbox" name="status_psikologis_4" id="status_psikologis_4" value="1" ' . ((isset($arr_status_psikologis[3]) and $arr_status_psikologis[3] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Sedih
	<input type="checkbox" name="status_psikologis_5" id="status_psikologis_5" value="1" ' . ((isset($arr_status_psikologis[4]) and $arr_status_psikologis[4] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Kecendrungan bunuh diri<br />
	<input type="checkbox" name="status_psikologis_6" id="status_psikologis_6" value="1" ' . ((isset($arr_status_psikologis[5]) and $arr_status_psikologis[5] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Senang
	<input type="checkbox" name="status_psikologis_7" id="status_psikologis_7" value="1" ' . ((isset($arr_status_psikologis[6]) and $arr_status_psikologis[6] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Gelisah
	<input type="checkbox" name="status_psikologis_8" id="status_psikologis_8" value="1" ' . ((isset($arr_status_psikologis[7]) and $arr_status_psikologis[7] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Cuek
	<input type="checkbox" name="status_psikologis_9" id="status_psikologis_9" value="1" ' . ((isset($arr_status_psikologis[8]) and $arr_status_psikologis[8] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Lain-lain, sebutkan
	' . setGarisIfNull($status_psikologis_ket) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">Status Mental</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="status_mental_1" id="status_mental_1" value="1" ' . ((isset($arr_status_mental[0]) and $arr_status_mental[0] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Sadar dan orientasi baik<br />
	<input type="checkbox" name="status_mental_2" id="status_mental_2" value="1" ' . ((isset($arr_status_mental[1]) and $arr_status_mental[1] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Ada masalah perilaku sebutkan
	' . setGarisIfNull($status_mental_ket_1) . '<br />
	<input type="checkbox" name="status_mental_3" id="status_mental_3" value="1" ' . ((isset($arr_status_mental[2]) and $arr_status_mental[2] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Perilaku kekerasan yang dialami pasien sebelumnya
	' . setGarisIfNull($status_mental_ket_2) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">Status Sosial</td>
	<td colspan="2">a. Hubungan pasien dengan anggota keluarga <input type="checkbox" name="status_sosial_1" id="status_sosial_1" value="1" ' . ((isset($arr_status_sosial[0]) and $arr_status_sosial[0] == '1') ? 'checked="checked"' : '') . ' />&nbsp;baik 
	<input type="checkbox" name="status_sosial_1" id="status_sosial_1" value="2" ' . ((isset($arr_status_sosial[0]) and $arr_status_sosial[0] == '2') ? 'checked="checked"' : '') . ' />&nbsp;tidak baik<br />
	b. Tempat tinggal <input type="checkbox" name="status_sosial_2" id="status_sosial_2" value="1" ' . ((isset($arr_status_sosial[1]) and $arr_status_sosial[1] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Rumah
	<input type="checkbox" name="status_sosial_2" id="status_sosial_2" value="2" ' . ((isset($arr_status_sosial[1]) and $arr_status_sosial[1] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Apartemen
	<input type="checkbox" name="status_sosial_2" id="status_sosial_2" value="3" ' . ((isset($arr_status_sosial[1]) and $arr_status_sosial[1] == '3') ? 'checked="checked"' : '') . ' />&nbsp;Panti<br />
	<input type="checkbox" name="status_sosial_2" id="status_sosial_2" value="4" ' . ((isset($arr_status_sosial[1]) and $arr_status_sosial[1] == '4') ? 'checked="checked"' : '') . ' />&nbsp;Lainnya
	' . setGarisIfNull($status_sosial_ket) . '<br />
	c. Kerabat terdekat yang dapat dihubungi : Nama ' . ((isset($arr_status_sosial_kerabat[0])) ? setGarisIfNull($arr_status_sosial_kerabat[0]) : $adline) . '<br />
	Hubungan ' . ((isset($arr_status_sosial_kerabat[1])) ? setGarisIfNull($arr_status_sosial_kerabat[1]) : $adline) . '
	Telepon ' . ((isset($arr_status_sosial_kerabat[2])) ? setGarisIfNull($arr_status_sosial_kerabat[2]) : $adline) . '</td>
</tr>
<tr>
    <td colspan="4">&nbsp;</td>
</tr>
<tr>
    <td colspan="4">5. PEMERIKSAAN FISIK</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">a. Kepala</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_kepala_1" id="pemeriksaan_fisik_kepala_1" value="1" ' . ((isset($arr_pemeriksaan_fisik_kepala[0]) and $arr_pemeriksaan_fisik_kepala[0] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Normal
	<input type="checkbox" name="pemeriksaan_fisik_kepala_1" id="pemeriksaan_fisik_kepala_1" value="2" ' . ((isset($arr_pemeriksaan_fisik_kepala[0]) and $arr_pemeriksaan_fisik_kepala[0] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Abnormal
	' . ((isset($arr_pemeriksaan_fisik_kepala[1])) ? setGarisIfNull($arr_pemeriksaan_fisik_kepala[1]) : $adline) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">b. Mata</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_mata_1" id="pemeriksaan_fisik_mata_1" value="1" ' . ((isset($arr_pemeriksaan_fisik_mata[0]) and $arr_pemeriksaan_fisik_mata[0] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Isokor
	<input type="checkbox" name="pemeriksaan_fisik_mata_2" id="pemeriksaan_fisik_mata_2" value="1" ' . ((isset($arr_pemeriksaan_fisik_mata[1]) and $arr_pemeriksaan_fisik_mata[1] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Anisokor
	<input type="checkbox" name="pemeriksaan_fisik_mata_3" id="pemeriksaan_fisik_mata_3" value="1" ' . ((isset($arr_pemeriksaan_fisik_mata[2]) and $arr_pemeriksaan_fisik_mata[2] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Lagoptalmus
	<input type="checkbox" name="pemeriksaan_fisik_mata_4" id="pemeriksaan_fisik_mata_4" value="1" ' . ((isset($arr_pemeriksaan_fisik_mata[3]) and $arr_pemeriksaan_fisik_mata[3] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Katarak
	<input type="checkbox" name="pemeriksaan_fisik_mata_5" id="pemeriksaan_fisik_mata_5" value="1" ' . ((isset($arr_pemeriksaan_fisik_mata[4]) and $arr_pemeriksaan_fisik_mata[4] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Strabismus
	<input type="checkbox" name="pemeriksaan_fisik_mata_6" id="pemeriksaan_fisik_mata_6" value="1" ' . ((isset($arr_pemeriksaan_fisik_mata[5]) and $arr_pemeriksaan_fisik_mata[5] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Uvitis
	<input type="checkbox" name="pemeriksaan_fisik_mata_7" id="pemeriksaan_fisik_mata_7" value="1" ' . ((isset($arr_pemeriksaan_fisik_mata[6]) and $arr_pemeriksaan_fisik_mata[6] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Ikterik
	<input type="checkbox" name="pemeriksaan_fisik_mata_8" id="pemeriksaan_fisik_mata_8" value="1" ' . ((isset($arr_pemeriksaan_fisik_mata[7]) and $arr_pemeriksaan_fisik_mata[7] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Madriasis<br />
	<input type="checkbox" name="pemeriksaan_fisik_mata_9" id="pemeriksaan_fisik_mata_9" value="1" ' . ((isset($arr_pemeriksaan_fisik_mata[8]) and $arr_pemeriksaan_fisik_mata[8] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Konjungtivitis
	<input type="checkbox" name="pemeriksaan_fisik_mata_10" id="pemeriksaan_fisik_mata_10" value="1" ' . ((isset($arr_pemeriksaan_fisik_mata[9]) and $arr_pemeriksaan_fisik_mata[9] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Menggunakan alat bantu
	' . ((isset($arr_pemeriksaan_fisik_mata[10])) ? setGarisIfNull($arr_pemeriksaan_fisik_mata[10]) : $adline) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">c. Telinga</td>
	<td colspan="2">&nbsp;</td>
</tr>	
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Bentuk</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_telinga_1" id="pemeriksaan_fisik_telinga_1" value="1" ' . ((isset($arr_pemeriksaan_fisik_telinga[0]) and $arr_pemeriksaan_fisik_telinga[0] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Simetris
	<input type="checkbox" name="pemeriksaan_fisik_telinga_1" id="pemeriksaan_fisik_telinga_1" value="2" ' . ((isset($arr_pemeriksaan_fisik_telinga[0]) and $arr_pemeriksaan_fisik_telinga[0] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak simetris
	<input type="checkbox" name="pemeriksaan_fisik_telinga_1" id="pemeriksaan_fisik_telinga_1" value="3" ' . ((isset($arr_pemeriksaan_fisik_telinga[0]) and $arr_pemeriksaan_fisik_telinga[0] == '3') ? 'checked="checked"' : '') . ' />
	' . ((isset($arr_pemeriksaan_fisik_telinga[1])) ? setGarisIfNull($arr_pemeriksaan_fisik_telinga[1]) : $adline) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Pendengaran</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_telinga_3" id="pemeriksaan_fisik_telinga_3" value="1" ' . ((isset($arr_pemeriksaan_fisik_telinga[2]) and $arr_pemeriksaan_fisik_telinga[2] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Baik
	<input type="checkbox" name="pemeriksaan_fisik_telinga_3" id="pemeriksaan_fisik_telinga_3" value="2" ' . ((isset($arr_pemeriksaan_fisik_telinga[2]) and $arr_pemeriksaan_fisik_telinga[2] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Kurang/ Tuli
	<input type="checkbox" name="pemeriksaan_fisik_telinga_4" id="pemeriksaan_fisik_telinga_4" value="1" ' . ((isset($arr_pemeriksaan_fisik_telinga[3]) and $arr_pemeriksaan_fisik_telinga[3] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Kiri
	<input type="checkbox" name="pemeriksaan_fisik_telinga_5" id="pemeriksaan_fisik_telinga_5" value="1" ' . ((isset($arr_pemeriksaan_fisik_telinga[4]) and $arr_pemeriksaan_fisik_telinga[4] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Kanan</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Lubang telinga</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_telinga_6" id="pemeriksaan_fisik_telinga_6" value="1" ' . ((isset($arr_pemeriksaan_fisik_telinga[5]) and $arr_pemeriksaan_fisik_telinga[5] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Bersih
	<input type="checkbox" name="pemeriksaan_fisik_telinga_6" id="pemeriksaan_fisik_telinga_6" value="2" ' . ((isset($arr_pemeriksaan_fisik_telinga[5]) and $arr_pemeriksaan_fisik_telinga[5] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Kotor
	<input type="checkbox" name="pemeriksaan_fisik_telinga_6" id="pemeriksaan_fisik_telinga_6" value="3" ' . ((isset($arr_pemeriksaan_fisik_telinga[5]) and $arr_pemeriksaan_fisik_telinga[5] == '3') ? 'checked="checked"' : '') . ' />&nbsp;Cerumen
	<input type="checkbox" name="pemeriksaan_fisik_telinga_6" id="pemeriksaan_fisik_telinga_6" value="4" ' . ((isset($arr_pemeriksaan_fisik_telinga[5]) and $arr_pemeriksaan_fisik_telinga[5] == '4') ? 'checked="checked"' : '') . ' />&nbsp;Ada warna
	' . ((isset($arr_pemeriksaan_fisik_telinga[6])) ? setGarisIfNull($arr_pemeriksaan_fisik_telinga[6]) : $adline) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Alat bantu dengar</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_telinga_8" id="pemeriksaan_fisik_telinga_8" value="1" ' . ((isset($arr_pemeriksaan_fisik_telinga[7]) and $arr_pemeriksaan_fisik_telinga[7] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Tidak
	<input type="checkbox" name="pemeriksaan_fisik_telinga_8" id="pemeriksaan_fisik_telinga_8" value="2" ' . ((isset($arr_pemeriksaan_fisik_telinga[7]) and $arr_pemeriksaan_fisik_telinga[7] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Ya, jenis alat bantu
	' . ((isset($arr_pemeriksaan_fisik_telinga[8])) ? setGarisIfNull($arr_pemeriksaan_fisik_telinga[8]) : $adline) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">d. Hidung</td>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Bentuk</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_hidung_1" id="pemeriksaan_fisik_hidung_1" value="1" ' . ((isset($arr_pemeriksaan_fisik_hidung[0]) and $arr_pemeriksaan_fisik_hidung[0] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Simetris
	<input type="checkbox" name="pemeriksaan_fisik_hidung_1" id="pemeriksaan_fisik_hidung_1" value="2" ' . ((isset($arr_pemeriksaan_fisik_hidung[0]) and $arr_pemeriksaan_fisik_hidung[0] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Pelana
	<input type="checkbox" name="pemeriksaan_fisik_hidung_1" id="pemeriksaan_fisik_hidung_1" value="3" ' . ((isset($arr_pemeriksaan_fisik_hidung[0]) and $arr_pemeriksaan_fisik_hidung[0] == '3') ? 'checked="checked"' : '') . ' />&nbsp;Polip
	<input type="checkbox" name="pemeriksaan_fisik_hidung_1" id="pemeriksaan_fisik_hidung_1" value="4" ' . ((isset($arr_pemeriksaan_fisik_hidung[0]) and $arr_pemeriksaan_fisik_hidung[0] == '4') ? 'checked="checked"' : '') . ' />&nbsp;Asimetris
	<input type="checkbox" name="pemeriksaan_fisik_hidung_1" id="pemeriksaan_fisik_hidung_1" value="5" ' . ((isset($arr_pemeriksaan_fisik_hidung[0]) and $arr_pemeriksaan_fisik_hidung[0] == '5') ? 'checked="checked"' : '') . ' />&nbsp;Sadlenose</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Membran mukosa</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_hidung_2" id="pemeriksaan_fisik_hidung_2" value="1" ' . ((isset($arr_pemeriksaan_fisik_hidung[1]) and $arr_pemeriksaan_fisik_hidung[1] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Kering
	<input type="checkbox" name="pemeriksaan_fisik_hidung_2" id="pemeriksaan_fisik_hidung_2" value="2" ' . ((isset($arr_pemeriksaan_fisik_hidung[1]) and $arr_pemeriksaan_fisik_hidung[1] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Lembab
	<input type="checkbox" name="pemeriksaan_fisik_hidung_2" id="pemeriksaan_fisik_hidung_2" value="3" ' . ((isset($arr_pemeriksaan_fisik_hidung[1]) and $arr_pemeriksaan_fisik_hidung[1] == '3') ? 'checked="checked"' : '') . ' />&nbsp;Mengeluarkan
	<input type="checkbox" name="pemeriksaan_fisik_hidung_3" id="pemeriksaan_fisik_hidung_3" value="1" ' . ((isset($arr_pemeriksaan_fisik_hidung[2]) and $arr_pemeriksaan_fisik_hidung[2] == '1') ? 'checked="checked"' : '') . ' />&nbsp;lendir
	<input type="checkbox" name="pemeriksaan_fisik_hidung_4" id="pemeriksaan_fisik_hidung_4" value="1" ' . ((isset($arr_pemeriksaan_fisik_hidung[3]) and $arr_pemeriksaan_fisik_hidung[3] == '1') ? 'checked="checked"' : '') . ' />&nbsp;darah</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Kemampuan menghidu</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_hidung_5" id="pemeriksaan_fisik_hidung_5" value="1" ' . ((isset($arr_pemeriksaan_fisik_hidung[4]) and $arr_pemeriksaan_fisik_hidung[4] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Baik
	<input type="checkbox" name="pemeriksaan_fisik_hidung_5" id="pemeriksaan_fisik_hidung_5" value="2" ' . ((isset($arr_pemeriksaan_fisik_hidung[4]) and $arr_pemeriksaan_fisik_hidung[4] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak baik
	<input type="checkbox" name="pemeriksaan_fisik_hidung_5" id="pemeriksaan_fisik_hidung_5" value="3" ' . ((isset($arr_pemeriksaan_fisik_hidung[4]) and $arr_pemeriksaan_fisik_hidung[4] == '3') ? 'checked="checked"' : '') . ' />&nbsp;Keluhan lain
	' . ((isset($arr_pemeriksaan_fisik_hidung[5])) ? setGarisIfNull($arr_pemeriksaan_fisik_hidung[5]) : $adline) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">e. Mulut</td>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Rongga mulut</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_mulut_1" id="pemeriksaan_fisik_mulut_1" value="1" ' . ((isset($arr_pemeriksaan_fisik_mulut[0]) and $arr_pemeriksaan_fisik_mulut[0] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Berbau
	<input type="checkbox" name="pemeriksaan_fisik_mulut_1" id="pemeriksaan_fisik_mulut_1" value="2" ' . ((isset($arr_pemeriksaan_fisik_mulut[0]) and $arr_pemeriksaan_fisik_mulut[0] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak berbau</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Membran mukosa</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_mulut_2" id="pemeriksaan_fisik_mulut_2" value="1" ' . ((isset($arr_pemeriksaan_fisik_mulut[1]) and $arr_pemeriksaan_fisik_mulut[1] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Warna
	' . ((isset($arr_pemeriksaan_fisik_mulut[2])) ? setGarisIfNull($arr_pemeriksaan_fisik_mulut[2]) : $adline) . '
	<input type="checkbox" name="pemeriksaan_fisik_mulut_2" id="pemeriksaan_fisik_mulut_2" value="2" ' . ((isset($arr_pemeriksaan_fisik_mulut[1]) and $arr_pemeriksaan_fisik_mulut[1] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Kering
	<input type="checkbox" name="pemeriksaan_fisik_mulut_2" id="pemeriksaan_fisik_mulut_2" value="3" ' . ((isset($arr_pemeriksaan_fisik_mulut[1]) and $arr_pemeriksaan_fisik_mulut[1] == '3') ? 'checked="checked"' : '') . ' />&nbsp;Basah</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Lidah</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_mulut_4" id="pemeriksaan_fisik_mulut_4" value="1" ' . ((isset($arr_pemeriksaan_fisik_mulut[3]) and $arr_pemeriksaan_fisik_mulut[3] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Kotor
	<input type="checkbox" name="pemeriksaan_fisik_mulut_4" id="pemeriksaan_fisik_mulut_4" value="2" ' . ((isset($arr_pemeriksaan_fisik_mulut[3]) and $arr_pemeriksaan_fisik_mulut[3] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Bersih</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Gigi</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_mulut_5" id="pemeriksaan_fisik_mulut_5" value="1" ' . ((isset($arr_pemeriksaan_fisik_mulut[4]) and $arr_pemeriksaan_fisik_mulut[4] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Caries
	<input type="checkbox" name="pemeriksaan_fisik_mulut_5" id="pemeriksaan_fisik_mulut_5" value="2" ' . ((isset($arr_pemeriksaan_fisik_mulut[4]) and $arr_pemeriksaan_fisik_mulut[4] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak
	<input type="checkbox" name="pemeriksaan_fisik_mulut_6" id="pemeriksaan_fisik_mulut_6" value="1" ' . ((isset($arr_pemeriksaan_fisik_mulut[5]) and $arr_pemeriksaan_fisik_mulut[5] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Palsu, jumlah gigi
	' . ((isset($arr_pemeriksaan_fisik_mulut[6])) ? setGarisIfNull($arr_pemeriksaan_fisik_mulut[6]) : $adline) . '</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Tonsil</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_mulut_8" id="pemeriksaan_fisik_mulut_8" value="1" ' . ((isset($arr_pemeriksaan_fisik_mulut[7]) and $arr_pemeriksaan_fisik_mulut[7] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Ada pembesaran
	<input type="checkbox" name="pemeriksaan_fisik_mulut_8" id="pemeriksaan_fisik_mulut_8" value="2" ' . ((isset($arr_pemeriksaan_fisik_mulut[7]) and $arr_pemeriksaan_fisik_mulut[7] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak ada
	<input type="checkbox" name="pemeriksaan_fisik_mulut_9" id="pemeriksaan_fisik_mulut_9" value="1" ' . ((isset($arr_pemeriksaan_fisik_mulut[8]) and $arr_pemeriksaan_fisik_mulut[8] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Peradangan Labio Schizis</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Kelainan/ gangguan lain</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_mulut_10" id="pemeriksaan_fisik_mulut_10" value="1" ' . ((isset($arr_pemeriksaan_fisik_mulut[9]) and $arr_pemeriksaan_fisik_mulut[9] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Palato Schizis
	<input type="checkbox" name="pemeriksaan_fisik_mulut_11" id="pemeriksaan_fisik_mulut_11" value="1" ' . ((isset($arr_pemeriksaan_fisik_mulut[10]) and $arr_pemeriksaan_fisik_mulut[10] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Stomatitis
	<input type="checkbox" name="pemeriksaan_fisik_mulut_12" id="pemeriksaan_fisik_mulut_12" value="1" ' . ((isset($arr_pemeriksaan_fisik_mulut[11]) and $arr_pemeriksaan_fisik_mulut[11] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Pelo</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">f. Leher</td>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Pergerakan</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_leher_1" id="pemeriksaan_fisik_leher_1" value="1" ' . ((isset($arr_pemeriksaan_fisik_leher[0]) and $arr_pemeriksaan_fisik_leher[0] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Bebas
	<input type="checkbox" name="pemeriksaan_fisik_leher_1" id="pemeriksaan_fisik_leher_1" value="2" ' . ((isset($arr_pemeriksaan_fisik_leher[0]) and $arr_pemeriksaan_fisik_leher[0] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Kaku
	<input type="checkbox" name="pemeriksaan_fisik_leher_2" id="pemeriksaan_fisik_leher_2" value="1" ' . ((isset($arr_pemeriksaan_fisik_leher[1]) and $arr_pemeriksaan_fisik_leher[1] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Benjolan
	' . ((isset($arr_pemeriksaan_fisik_leher[2])) ? setGarisIfNull($arr_pemeriksaan_fisik_leher[2]) : $adline) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Kelenjar tiroid</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_leher_4" id="pemeriksaan_fisik_leher_4" value="1" ' . ((isset($arr_pemeriksaan_fisik_leher[3]) and $arr_pemeriksaan_fisik_leher[3] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Teraba
	<input type="checkbox" name="pemeriksaan_fisik_leher_4" id="pemeriksaan_fisik_leher_4" value="2" ' . ((isset($arr_pemeriksaan_fisik_leher[3]) and $arr_pemeriksaan_fisik_leher[3] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak teraba
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Tekanan vena jugularis</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_leher_5" id="pemeriksaan_fisik_leher_5" value="1" ' . ((isset($arr_pemeriksaan_fisik_leher[4]) and $arr_pemeriksaan_fisik_leher[4] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Meningkat
	<input type="checkbox" name="pemeriksaan_fisik_leher_5" id="pemeriksaan_fisik_leher_5" value="2" ' . ((isset($arr_pemeriksaan_fisik_leher[4]) and $arr_pemeriksaan_fisik_leher[4] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Reflek menelan/ batuk</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_leher_6" id="pemeriksaan_fisik_leher_6" value="1" ' . ((isset($arr_pemeriksaan_fisik_leher[5]) and $arr_pemeriksaan_fisik_leher[5] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Ada
	<input type="checkbox" name="pemeriksaan_fisik_leher_6" id="pemeriksaan_fisik_leher_6" value="2" ' . ((isset($arr_pemeriksaan_fisik_leher[5]) and $arr_pemeriksaan_fisik_leher[5] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak
	<input type="checkbox" name="pemeriksaan_fisik_leher_7" id="pemeriksaan_fisik_leher_7" value="1" ' . ((isset($arr_pemeriksaan_fisik_leher[6]) and $arr_pemeriksaan_fisik_leher[6] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Dll
	' . ((isset($arr_pemeriksaan_fisik_leher[7])) ? setGarisIfNull($arr_pemeriksaan_fisik_leher[7]) : $adline) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Kelainan/ gangguan lain</td>
	<td colspan="2">:&nbsp;' . ((isset($arr_pemeriksaan_fisik_leher[8])) ? setGarisIfNull($arr_pemeriksaan_fisik_leher[8]) : $adline) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">g. Thorax</td>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Bentuk dada</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_thorax_1" id="pemeriksaan_fisik_thorax_1" value="1" ' . ((isset($arr_pemeriksaan_fisik_thorax[0]) and $arr_pemeriksaan_fisik_thorax[0] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Normal
	<input type="checkbox" name="pemeriksaan_fisik_thorax_1" id="pemeriksaan_fisik_thorax_1" value="2" ' . ((isset($arr_pemeriksaan_fisik_thorax[0]) and $arr_pemeriksaan_fisik_thorax[0] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Pigeon chest
	<input type="checkbox" name="pemeriksaan_fisik_thorax_1" id="pemeriksaan_fisik_thorax_1" value="3" ' . ((isset($arr_pemeriksaan_fisik_thorax[0]) and $arr_pemeriksaan_fisik_thorax[0] == '3') ? 'checked="checked"' : '') . ' />&nbsp;Funnel chest
	<input type="checkbox" name="pemeriksaan_fisik_thorax_1" id="pemeriksaan_fisik_thorax_1" value="4" ' . ((isset($arr_pemeriksaan_fisik_thorax[0]) and $arr_pemeriksaan_fisik_thorax[0] == '4') ? 'checked="checked"' : '') . ' />&nbsp;Barrel chest
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Pola napas</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_thorax_2" id="pemeriksaan_fisik_thorax_2" value="1" ' . ((isset($arr_pemeriksaan_fisik_thorax[1]) and $arr_pemeriksaan_fisik_thorax[1] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Apnoe
	<input type="checkbox" name="pemeriksaan_fisik_thorax_2" id="pemeriksaan_fisik_thorax_2" value="2" ' . ((isset($arr_pemeriksaan_fisik_thorax[1]) and $arr_pemeriksaan_fisik_thorax[1] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Dispnea
	<input type="checkbox" name="pemeriksaan_fisik_thorax_2" id="pemeriksaan_fisik_thorax_2" value="3" ' . ((isset($arr_pemeriksaan_fisik_thorax[1]) and $arr_pemeriksaan_fisik_thorax[1] == '3') ? 'checked="checked"' : '') . ' />&nbsp;Orthopnea
	<input type="checkbox" name="pemeriksaan_fisik_thorax_2" id="pemeriksaan_fisik_thorax_2" value="4" ' . ((isset($arr_pemeriksaan_fisik_thorax[1]) and $arr_pemeriksaan_fisik_thorax[1] == '4') ? 'checked="checked"' : '') . ' />&nbsp;Lainnya
	' . ((isset($arr_pemeriksaan_fisik_thorax[2])) ? setGarisIfNull($arr_pemeriksaan_fisik_thorax[2]) : $adline) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Bentuk tulang belakang</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_thorax_4" id="pemeriksaan_fisik_thorax_4" value="1" ' . ((isset($arr_pemeriksaan_fisik_thorax[3]) and $arr_pemeriksaan_fisik_thorax[3] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Normal
	<input type="checkbox" name="pemeriksaan_fisik_thorax_4" id="pemeriksaan_fisik_thorax_4" value="2" ' . ((isset($arr_pemeriksaan_fisik_thorax[3]) and $arr_pemeriksaan_fisik_thorax[3] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Kiposis
	<input type="checkbox" name="pemeriksaan_fisik_thorax_4" id="pemeriksaan_fisik_thorax_4" value="3" ' . ((isset($arr_pemeriksaan_fisik_thorax[3]) and $arr_pemeriksaan_fisik_thorax[3] == '3') ? 'checked="checked"' : '') . ' />&nbsp;Lordosis
	<input type="checkbox" name="pemeriksaan_fisik_thorax_4" id="pemeriksaan_fisik_thorax_4" value="4" ' . ((isset($arr_pemeriksaan_fisik_thorax[3]) and $arr_pemeriksaan_fisik_thorax[3] == '4') ? 'checked="checked"' : '') . ' />&nbsp;Scoliosis
	<input type="checkbox" name="pemeriksaan_fisik_thorax_4" id="pemeriksaan_fisik_thorax_4" value="5" ' . ((isset($arr_pemeriksaan_fisik_thorax[3]) and $arr_pemeriksaan_fisik_thorax[3] == '5') ? 'checked="checked"' : '') . ' />&nbsp;Gibus
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Suara napas</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_thorax_5" id="pemeriksaan_fisik_thorax_5" value="1" ' . ((isset($arr_pemeriksaan_fisik_thorax[4]) and $arr_pemeriksaan_fisik_thorax[4] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Vesikuler
	<input type="checkbox" name="pemeriksaan_fisik_thorax_5" id="pemeriksaan_fisik_thorax_5" value="2" ' . ((isset($arr_pemeriksaan_fisik_thorax[4]) and $arr_pemeriksaan_fisik_thorax[4] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Wheezzing
	<input type="checkbox" name="pemeriksaan_fisik_thorax_5" id="pemeriksaan_fisik_thorax_5" value="3" ' . ((isset($arr_pemeriksaan_fisik_thorax[4]) and $arr_pemeriksaan_fisik_thorax[4] == '3') ? 'checked="checked"' : '') . ' />&nbsp;Ronchi
	(<input type="checkbox" name="pemeriksaan_fisik_thorax_6" id="pemeriksaan_fisik_thorax_6" value="1" ' . ((isset($arr_pemeriksaan_fisik_thorax[5]) and $arr_pemeriksaan_fisik_thorax[5] == '1') ? 'checked="checked"' : '') . ' />&nbsp;L
	<input type="checkbox" name="pemeriksaan_fisik_thorax_7" id="pemeriksaan_fisik_thorax_7" value="1" ' . ((isset($arr_pemeriksaan_fisik_thorax[6]) and $arr_pemeriksaan_fisik_thorax[6] == '2') ? 'checked="checked"' : '') . ' />&nbsp;R)
	<input type="checkbox" name="pemeriksaan_fisik_thorax_5" id="pemeriksaan_fisik_thorax_5" value="4" ' . ((isset($arr_pemeriksaan_fisik_thorax[4]) and $arr_pemeriksaan_fisik_thorax[4] == '4') ? 'checked="checked"' : '') . ' />&nbsp;Reguler
	<input type="checkbox" name="pemeriksaan_fisik_thorax_5" id="pemeriksaan_fisik_thorax_5" value="5" ' . ((isset($arr_pemeriksaan_fisik_thorax[4]) and $arr_pemeriksaan_fisik_thorax[4] == '5') ? 'checked="checked"' : '') . ' />&nbsp;Ireguler
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Perkusi</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_thorax_8" id="pemeriksaan_fisik_thorax_8" value="1" ' . ((isset($arr_pemeriksaan_fisik_thorax[7]) and $arr_pemeriksaan_fisik_thorax[7] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Sonor
	<input type="checkbox" name="pemeriksaan_fisik_thorax_8" id="pemeriksaan_fisik_thorax_8" value="2" ' . ((isset($arr_pemeriksaan_fisik_thorax[7]) and $arr_pemeriksaan_fisik_thorax[7] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Redup
	<input type="checkbox" name="pemeriksaan_fisik_thorax_8" id="pemeriksaan_fisik_thorax_8" value="3" ' . ((isset($arr_pemeriksaan_fisik_thorax[7]) and $arr_pemeriksaan_fisik_thorax[7] == '3') ? 'checked="checked"' : '') . ' />&nbsp;Pekak
	<input type="checkbox" name="pemeriksaan_fisik_thorax_8" id="pemeriksaan_fisik_thorax_8" value="4" ' . ((isset($arr_pemeriksaan_fisik_thorax[7]) and $arr_pemeriksaan_fisik_thorax[7] == '4') ? 'checked="checked"' : '') . ' />&nbsp;Hipersonor
	<input type="checkbox" name="pemeriksaan_fisik_thorax_8" id="pemeriksaan_fisik_thorax_8" value="5" ' . ((isset($arr_pemeriksaan_fisik_thorax[7]) and $arr_pemeriksaan_fisik_thorax[7] == '5') ? 'checked="checked"' : '') . ' />&nbsp;Tympan
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Batuk</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_thorax_9" id="pemeriksaan_fisik_thorax_9" value="1" ' . ((isset($arr_pemeriksaan_fisik_thorax[8]) and $arr_pemeriksaan_fisik_thorax[8] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Produktif
	<input type="checkbox" name="pemeriksaan_fisik_thorax_9" id="pemeriksaan_fisik_thorax_9" value="2" ' . ((isset($arr_pemeriksaan_fisik_thorax[8]) and $arr_pemeriksaan_fisik_thorax[8] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Non produktif
	<input type="checkbox" name="pemeriksaan_fisik_thorax_10" id="pemeriksaan_fisik_thorax_10" value="1" ' . ((isset($arr_pemeriksaan_fisik_thorax[9]) and $arr_pemeriksaan_fisik_thorax[9] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Warna sputum
	' . ((isset($arr_pemeriksaan_fisik_thorax[10])) ? setGarisIfNull($arr_pemeriksaan_fisik_thorax[10]) : $adline) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Payudara</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_thorax_12" id="pemeriksaan_fisik_thorax_12" value="1" ' . ((isset($arr_pemeriksaan_fisik_thorax[11]) and $arr_pemeriksaan_fisik_thorax[11] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Simetris
	<input type="checkbox" name="pemeriksaan_fisik_thorax_12" id="pemeriksaan_fisik_thorax_12" value="2" ' . ((isset($arr_pemeriksaan_fisik_thorax[11]) and $arr_pemeriksaan_fisik_thorax[11] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Asimetris
	<input type="checkbox" name="pemeriksaan_fisik_thorax_13" id="pemeriksaan_fisik_thorax_13" value="1" ' . ((isset($arr_pemeriksaan_fisik_thorax[12]) and $arr_pemeriksaan_fisik_thorax[12] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Pembesaran
	(<input type="checkbox" name="pemeriksaan_fisik_thorax_14" id="pemeriksaan_fisik_thorax_14" value="1" ' . ((isset($arr_pemeriksaan_fisik_thorax[13]) and $arr_pemeriksaan_fisik_thorax[13] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Kanan
	<input type="checkbox" name="pemeriksaan_fisik_thorax_15" id="pemeriksaan_fisik_thorax_15" value="1" ' . ((isset($arr_pemeriksaan_fisik_thorax[14]) and $arr_pemeriksaan_fisik_thorax[14] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Kiri)
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">h. Abdomen</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_abdomen_1" id="pemeriksaan_fisik_abdomen_1" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[0]) and $arr_pemeriksaan_fisik_abdomen[0] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Kembung
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_2" id="pemeriksaan_fisik_abdomen_2" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[1]) and $arr_pemeriksaan_fisik_abdomen[1] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Distensi
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_3" id="pemeriksaan_fisik_abdomen_3" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[2]) and $arr_pemeriksaan_fisik_abdomen[2] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Datar
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_4" id="pemeriksaan_fisik_abdomen_4" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[3]) and $arr_pemeriksaan_fisik_abdomen[3] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Asites
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_5" id="pemeriksaan_fisik_abdomen_5" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[4]) and $arr_pemeriksaan_fisik_abdomen[4] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Konstipasi
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_6" id="pemeriksaan_fisik_abdomen_6" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[5]) and $arr_pemeriksaan_fisik_abdomen[5] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Flatus
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
	<td colspan="2">Bising usus ' . ((isset($arr_pemeriksaan_fisik_abdomen[6])) ? setGarisIfNull($arr_pemeriksaan_fisik_abdomen[6]) : $adline) . ' x/mnt,
	Lingkar perut ' . ((isset($arr_pemeriksaan_fisik_abdomen[7])) ? setGarisIfNull($arr_pemeriksaan_fisik_abdomen[7]) :  $adline) . ' cm<br />
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_9" id="pemeriksaan_fisik_abdomen_9" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[8]) and $arr_pemeriksaan_fisik_abdomen[8] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Nyeri
	(<input type="checkbox" name="pemeriksaan_fisik_abdomen_10" id="pemeriksaan_fisik_abdomen_10" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[9]) and $arr_pemeriksaan_fisik_abdomen[9] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Tekan
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_11" id="pemeriksaan_fisik_abdomen_11" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[10]) and $arr_pemeriksaan_fisik_abdomen[10] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Lepas),
	Kwadran ' . ((isset($arr_pemeriksaan_fisik_abdomen[11])) ? setGarisIfNull($arr_pemeriksaan_fisik_abdomen[11]) : $adline) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Pembesaran kelenjar</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_abdomen_13" id="pemeriksaan_fisik_abdomen_13" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[12]) and $arr_pemeriksaan_fisik_abdomen[12] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Inguinalis
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_14" id="pemeriksaan_fisik_abdomen_14" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[13]) and $arr_pemeriksaan_fisik_abdomen[13] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Umbilikus
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Genitalia</td>
	<td colspan="2">:&nbsp;' . ((isset($arr_pemeriksaan_fisik_abdomen[14])) ? setGarisIfNull($arr_pemeriksaan_fisik_abdomen[14]) : $adline) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Hemoroid</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_abdomen_16" id="pemeriksaan_fisik_abdomen_16" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[15]) and $arr_pemeriksaan_fisik_abdomen[15] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Ada
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_16" id="pemeriksaan_fisik_abdomen_16" value="2" ' . ((isset($arr_pemeriksaan_fisik_abdomen[15]) and $arr_pemeriksaan_fisik_abdomen[15] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	Anus (<input type="checkbox" name="pemeriksaan_fisik_abdomen_17" id="pemeriksaan_fisik_abdomen_17" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[16]) and $arr_pemeriksaan_fisik_abdomen[16] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Ada
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_17" id="pemeriksaan_fisik_abdomen_17" value="2" ' . ((isset($arr_pemeriksaan_fisik_abdomen[16]) and $arr_pemeriksaan_fisik_abdomen[16] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Tidak)
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Laki-laki, Scrotum</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_abdomen_18" id="pemeriksaan_fisik_abdomen_18" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[17]) and $arr_pemeriksaan_fisik_abdomen[17] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Simetris
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_18" id="pemeriksaan_fisik_abdomen_18" value="2" ' . ((isset($arr_pemeriksaan_fisik_abdomen[17]) and $arr_pemeriksaan_fisik_abdomen[17] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Asimetris
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_19" id="pemeriksaan_fisik_abdomen_19" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[18]) and $arr_pemeriksaan_fisik_abdomen[18] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Pembesaran
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_20" id="pemeriksaan_fisik_abdomen_20" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[19]) and $arr_pemeriksaan_fisik_abdomen[19] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Luka
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_21" id="pemeriksaan_fisik_abdomen_21" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[20]) and $arr_pemeriksaan_fisik_abdomen[20] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Dll
	' . ((isset($arr_pemeriksaan_fisik_abdomen[21])) ? setGarisIfNull($arr_pemeriksaan_fisik_abdomen[21]) : $adline) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Wanita</td>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pengeluaran secret berlebih</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_abdomen_23" id="pemeriksaan_fisik_abdomen_23" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[22]) and $arr_pemeriksaan_fisik_abdomen[22] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Ada
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_23" id="pemeriksaan_fisik_abdomen_23" value="2" ' . ((isset($arr_pemeriksaan_fisik_abdomen[22]) and $arr_pemeriksaan_fisik_abdomen[22] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_24" id="pemeriksaan_fisik_abdomen_24" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[23]) and $arr_pemeriksaan_fisik_abdomen[23] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Berbau
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_25" id="pemeriksaan_fisik_abdomen_25" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[24]) and $arr_pemeriksaan_fisik_abdomen[24] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Warna
	' . ((isset($arr_pemeriksaan_fisik_abdomen[25])) ? setGarisIfNull($arr_pemeriksaan_fisik_abdomen[25]) : $adline) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Haid</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_abdomen_27" id="pemeriksaan_fisik_abdomen_27" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[26]) and $arr_pemeriksaan_fisik_abdomen[26] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Teratur
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_27" id="pemeriksaan_fisik_abdomen_27" value="2" ' . ((isset($arr_pemeriksaan_fisik_abdomen[26]) and $arr_pemeriksaan_fisik_abdomen[26] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak teratur
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_28" id="pemeriksaan_fisik_abdomen_28" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[27]) and $arr_pemeriksaan_fisik_abdomen[27] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Amenorhea
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_29" id="pemeriksaan_fisik_abdomen_29" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[28]) and $arr_pemeriksaan_fisik_abdomen[28] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Dismenorhea
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hamil</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_abdomen_30" id="pemeriksaan_fisik_abdomen_30" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[29]) and $arr_pemeriksaan_fisik_abdomen[29] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Tidak
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_30" id="pemeriksaan_fisik_abdomen_30" value="2" ' . ((isset($arr_pemeriksaan_fisik_abdomen[29]) and $arr_pemeriksaan_fisik_abdomen[29] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Ya,
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_31" id="pemeriksaan_fisik_abdomen_31" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[30]) and $arr_pemeriksaan_fisik_abdomen[30] == '1') ? 'checked="checked"' : '') . ' />
	G ' . ((isset($arr_pemeriksaan_fisik_abdomen[31])) ? setGarisIfNull($arr_pemeriksaan_fisik_abdomen[31]) : $adline) . '
	P ' . ((isset($arr_pemeriksaan_fisik_abdomen[32])) ? setGarisIfNull($arr_pemeriksaan_fisik_abdomen[32]) : $adline) . '
	Ab ' . ((isset($arr_pemeriksaan_fisik_abdomen[33])) ? setGarisIfNull($arr_pemeriksaan_fisik_abdomen[33]) : $adline) . '<br />
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_35" id="pemeriksaan_fisik_abdomen_35" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[34]) and $arr_pemeriksaan_fisik_abdomen[34] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Usia
	' . ((isset($arr_pemeriksaan_fisik_abdomen[35])) ? setGarisIfNull($arr_pemeriksaan_fisik_abdomen[35]) : $adline) . ' minggu,
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_37" id="pemeriksaan_fisik_abdomen_37" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[36]) and $arr_pemeriksaan_fisik_abdomen[36] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Taksiran partus
	' . ((isset($arr_pemeriksaan_fisik_abdomen[37])) ? setGarisIfNull($arr_pemeriksaan_fisik_abdomen[37]) : $adline) . '<br />
	<input type="checkbox" name="pemeriksaan_fisik_abdomen_39" id="pemeriksaan_fisik_abdomen_39" value="1" ' . ((isset($arr_pemeriksaan_fisik_abdomen[38]) and $arr_pemeriksaan_fisik_abdomen[38] == '1') ? 'checked="checked"' : '') . ' />&nbsp;HPHT
	' . ((isset($arr_pemeriksaan_fisik_abdomen[39])) ? setGarisIfNull($arr_pemeriksaan_fisik_abdomen[39]) : $adline) . '</td>
</tr>
</table>';

ob_start();
include('edoc_rekammedik/edoc_frame_add.php');
$html = ob_get_contents();
ob_end_clean();
$mpdf->AddPage('P');
$mpdf->WriteHTML($html);

$edoc_content_2 = '<table width="100%" cellpadding="0" cellspacing="0" autosize="1" >
<tr>
	<td>&nbsp;</td>
    <td>i. Kulit</td>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Keadaan kulit</td>
	<td colspan="2">:&nbsp;<input type="checkbox" name="pemeriksaan_fisik_kulit_1" id="pemeriksaan_fisik_kulit_1" value="1" ' . ((isset($arr_pemeriksaan_fisik_kulit[0]) and $arr_pemeriksaan_fisik_kulit[0] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Normal
	<input type="checkbox" name="pemeriksaan_fisik_kulit_1" id="pemeriksaan_fisik_kulit_1" value="2" ' . ((isset($arr_pemeriksaan_fisik_kulit[0]) and $arr_pemeriksaan_fisik_kulit[0] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak normal, sebutkan
	' . ((isset($arr_pemeriksaan_fisik_kulit[1])) ? setGarisIfNull($arr_pemeriksaan_fisik_kulit[1]) : $adline) . '</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Skor Norton</td>
	<td colspan="2">:&nbsp;' . ((isset($arr_pemeriksaan_fisik_kulit[2])) ? setGarisIfNull($arr_pemeriksaan_fisik_kulit[2]) : $adline) . '/20,&nbsp;
	Risiko dekubitus <input type="checkbox" name="pemeriksaan_fisik_kulit_4" id="pemeriksaan_fisik_kulit_4" value="1" ' . ((isset($arr_pemeriksaan_fisik_kulit[3]) and $arr_pemeriksaan_fisik_kulit[3] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Ya
	<input type="checkbox" name="pemeriksaan_fisik_kulit_4" id="pemeriksaan_fisik_kulit_4" value="2" ' . ((isset($arr_pemeriksaan_fisik_kulit[3]) and $arr_pemeriksaan_fisik_kulit[3] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak,&nbsp;
	Terdapat luka <input type="checkbox" name="pemeriksaan_fisik_kulit_5" id="pemeriksaan_fisik_kulit_5" value="1" ' . ((isset($arr_pemeriksaan_fisik_kulit[4]) and $arr_pemeriksaan_fisik_kulit[4] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Ya
	<input type="checkbox" name="pemeriksaan_fisik_kulit_5" id="pemeriksaan_fisik_kulit_5" value="2" ' . ((isset($arr_pemeriksaan_fisik_kulit[4]) and $arr_pemeriksaan_fisik_kulit[4] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Lokasi luka/ lesi lain</td>
	<td colspan="2">(beri tanda x/arsiran lokasi luka/ edema ditubuh pasien pada gambar)</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td rowspan="6" colspan="2"><img src="askep/01.png" height="120px"/></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="2">Diberitahukan ke Dokter&nbsp;<input type="checkbox" name="pemeriksaan_fisik_kulit_6" id="pemeriksaan_fisik_kulit_6" value="1" ' . ((isset($arr_pemeriksaan_fisik_kulit[5]) and $arr_pemeriksaan_fisik_kulit[5] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Ya, Pukul
	' . ((isset($arr_pemeriksaan_fisik_kulit[6])) ? setGarisIfNull($arr_pemeriksaan_fisik_kulit[6]) : $adline) . '
	<input type="checkbox" name="pemeriksaan_fisik_kulit_6" id="pemeriksaan_fisik_kulit_6" value="2" ' . ((isset($arr_pemeriksaan_fisik_kulit[5]) and $arr_pemeriksaan_fisik_kulit[5] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td valign="top">j. Pemeriksaan fisik lain terkait penyakit pasien</td>
	<td colspan="2">' . setGarisIfNull($pemeriksaan_fisik_terkait_penyakit) . '</td>
</tr>
<tr>
    <td colspan="4">&nbsp;</td>
</tr>
<tr>
    <td colspan="4">6. PENAPISAN/ SKRINING GIZI (skrining gizi berdasarkan MST)</td>
</tr>
<tr>
    <td>&nbsp;</td>
	<td colspan="3">
	<table border="0">
		<tr>
			<td><strong>Parameter</strong></td>
			<td align="right"><strong>Skor</strong></td>
		</tr>
		<tr>
			<td>1. Apakah pasien mengalami penurunan BB yang tidak diinginkan dalam 3 bulan terakhir ?</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a. Tidak ada penurunan berat badan</td>
			<td align="right"><input type="checkbox" name="skrining_gizi_1" id="skrining_gizi_1" value="1" ';
			$total_skor = 0;
			if(isset($arr_skrining_gizi[0]) and $arr_skrining_gizi[0] == '1') {
				$edoc_content_2 = $edoc_content_2 . 'checked="checked"';
				$total_skor = $total_skor + 0;
			} 
			$edoc_content_2 = $edoc_content_2 . '/>&nbsp;0</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b. Tidak yakin/ tidak tahu/ terasa baju lebih longgar</td>
			<td align="right"><input type="checkbox" name="skrining_gizi_2" id="skrining_gizi_2" value="1" ';
			if(isset($arr_skrining_gizi[1]) and $arr_skrining_gizi[1] == '1') {
				$edoc_content_2 = $edoc_content_2 . 'checked="checked"';
				$total_skor = $total_skor + 2;
			} 
			$edoc_content_2 = $edoc_content_2 . '/>&nbsp;2</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c. Jika ya, berapa penurunan berat badan tersebut</td>
			<td align="right">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1 - 5 kg</td>
			<td align="right"><input type="checkbox" name="skrining_gizi_3" id="skrining_gizi_3" value="1" ';
			if(isset($arr_skrining_gizi[2]) and $arr_skrining_gizi[2] == '1') {
				$edoc_content_2 = $edoc_content_2 . 'checked="checked"';
				$total_skor = $total_skor + 1;
			} 
			$edoc_content_2 = $edoc_content_2 . '/>&nbsp;1</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;6 - 10 kg</td>
			<td align="right"><input type="checkbox" name="skrining_gizi_4" id="skrining_gizi_4" value="1" ';
			if(isset($arr_skrining_gizi[3]) and $arr_skrining_gizi[3] == '1') {
				$edoc_content_2 = $edoc_content_2 . 'checked="checked"';
				$total_skor = $total_skor + 2;
			} 
			$edoc_content_2 = $edoc_content_2 . '/>&nbsp;2</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;11 - 15 kg</td>
			<td align="right"><input type="checkbox" name="skrining_gizi_5" id="skrining_gizi_5" value="1" ';
			if(isset($arr_skrining_gizi[4]) and $arr_skrining_gizi[4] == '1') {
				$edoc_content_2 = $edoc_content_2 . 'checked="checked"';
				$total_skor = $total_skor + 3;
			} 
			$edoc_content_2 = $edoc_content_2 . '/>&nbsp;3</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;> 15 kg</td>
			<td align="right"><input type="checkbox" name="skrining_gizi_6" id="skrining_gizi_6" value="1" ';
			if(isset($arr_skrining_gizi[5]) and $arr_skrining_gizi[5] == '1') {
				$edoc_content_2 = $edoc_content_2 . 'checked="checked"';
				$total_skor = $total_skor + 4;
			} 
			$edoc_content_2 = $edoc_content_2 . '/>&nbsp;4</td>
		</tr>
		<tr>
			<td>2. Apakah asupan makanan berkurang karena tidak nafsu makan ?</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a. Tidak</td>
			<td align="right"><input type="checkbox" name="skrining_gizi_7" id="skrining_gizi_7" value="1" ';
			if(isset($arr_skrining_gizi[6]) and $arr_skrining_gizi[6] == '1') {
				$edoc_content_2 = $edoc_content_2 . 'checked="checked"';
				$total_skor = $total_skor + 0;
			} 
			$edoc_content_2 = $edoc_content_2 . '/>&nbsp;0</td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b. Ya</td>
			<td align="right"><input type="checkbox" name="skrining_gizi_8" id="skrining_gizi_8" value="1" ';
			if(isset($arr_skrining_gizi[7]) and $arr_skrining_gizi[7] == '1') {
				$edoc_content_2 = $edoc_content_2 . 'checked="checked"';
				$total_skor = $total_skor + 1;
			} 
			$edoc_content_2 = $edoc_content_2 . '/>&nbsp;1</td>
		</tr>
		<tr>
			<td>(Bila skor >= 2 dilakukan pengkajian lanjut oleh ahli gizi)</td>
			<td align="right">Total Skor :&nbsp;&nbsp;' . $total_skor . '</td>
		</tr>
	</table>
		</td>
	  </tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4">7. STATUS FUNGSIONAL</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">Aktivitas dan mobilisasi (Lampiran Formulir Pengkajian Status Fungsional Barthel Index)<br />
		<input type="checkbox" name="status_fungsional" id="status_fungsional" value="1" ' . (($status_fungsional == '1') ? 'checked="checked"' : '') . ' />&nbsp;Mandiri
		<input type="checkbox" name="status_fungsional" id="status_fungsional" value="2" ' . (($status_fungsional == '2') ? 'checked="checked"' : '') . ' />&nbsp;Perlu bantuan, sebutkan
		' . setGarisIfNull($status_fungsional_ket) . '
		<input type="checkbox" name="status_fungsional" id="status_fungsional" value="3" ' . (($status_fungsional == '3') ? 'checked="checked"' : '') . ' />&nbsp;Ketergantungan total<br />
		(Bila ketergantungan total kolaborasi ke DPJP/ PPDS untuk konsul ke Rehabilitasi Medik)
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4">8. RISIKO CEDERA/ JATUH (Gunakan Fornulir Penilaian Risiko Jatuh sesuai usia untuk penilaian)</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">
		<input type="checkbox" name="risiko_cedera_1" id="risiko_cedera_1" value="1" ' . ((isset($arr_risiko_cedera[0]) and $arr_risiko_cedera[0] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Tidak
		<input type="checkbox" name="risiko_cedera_1" id="risiko_cedera_1" value="2" ' . ((isset($arr_risiko_cedera[0]) and $arr_risiko_cedera[0] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Ya,
		bila ya isi formulir pemantauan pencegahan jatuh sesuai usia (Dewasa, Geriatri) sesuai kebutuhan. Jika ya, gelang risiko jatuh (di pasien) dan segitiga
		(di tempat tidur/ brankar/ kursi roda) warna kuning terpasang
		<input type="checkbox" name="risiko_cedera_2" id="risiko_cedera_2" value="1" ' . ((isset($arr_risiko_cedera[1]) and $arr_risiko_cedera[1] == '1') ? 'checked="checked"' : '') . ' /><br />
		Diberitahukan ke dokter <input type="checkbox" name="risiko_cedera_3" id="risiko_cedera_3" value="1" ' . ((isset($arr_risiko_cedera[2]) and $arr_risiko_cedera[2] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Ya, Pukul
		' . ((isset($arr_risiko_cedera[3])) ? setGarisIfNull($arr_risiko_cedera[3]) : $adline). '
		<input type="checkbox" name="risiko_cedera_3" id="risiko_cedera_3" value="2" ' . ((isset($arr_risiko_cedera[2]) and $arr_risiko_cedera[2] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak
		</td>
	</tr>
	</table>';
	
	ob_start();
	include('edoc_rekammedik/edoc_frame_add.php');
	$html = ob_get_contents();
	ob_end_clean();
	$mpdf->AddPage('P');
	$mpdf->WriteHTML($html);
	
	$edoc_footer = '';

	$edoc_content_2 = '<table width="100%" cellpadding="0" cellspacing="0" autosize="1" >
	<tr>
		<td colspan="4">9. PENAPISAN/ SKRINING NYERI</td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  <td rowspan="5"><img src="askep/02.png" alt="a" height="120px"/></td>
	  <td colspan="2" rowspan="5">
	  <table border="0">
		<tr>
		<td>O = onset</td>
		<td>' . ((isset($arr_skrining_nyeri[1])) ? setGarisIfNull($arr_skrining_nyeri[1]) : $adline) . '</td>
		</tr>
		<tr>
		<td>P = pemicu</td>
		<td>' . ((isset($arr_skrining_nyeri[2])) ? setGarisIfNull($arr_skrining_nyeri[2]) : $adline) . '</td>
		</tr>
		<tr>
		<td>Q = kwalitas</td>
		<td>' . ((isset($arr_skrining_nyeri[3])) ? setGarisIfNull($arr_skrining_nyeri[3]) : $adline) . '</td>
		</tr>
		<tr>
		<td>R = lokasi</td>
		<td>' . ((isset($arr_skrining_nyeri[4])) ? setGarisIfNull($arr_skrining_nyeri[4]) : $adline) . '</td>
		</tr>
		<tr>
		<td>S = skala nyeri</td>
		<td>' . ((isset($arr_skrining_nyeri[0])) ? setGarisIfNull($arr_skrining_nyeri[0]) :  $adline) . '</td>
		</tr>
	  </table>
	  </td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	  </tr>
	<tr>
	  <td>&nbsp;</td>
	  </tr>
	<tr>
	  <td>&nbsp;</td>
	  </tr>
	<tr>
	  <td>&nbsp;</td>
	  </tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">
		<input type="checkbox" name="skrining_nyeri_6" id="skrining_nyeri_6" value="1" ' . ((isset($arr_skrining_nyeri[5]) and $arr_skrining_nyeri[5] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Nyeri kronis
		<input type="checkbox" name="skrining_nyeri_6" id="skrining_nyeri_6" value="2" ' . ((isset($arr_skrining_nyeri[5]) and $arr_skrining_nyeri[5] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Nyeri akut
		<input type="checkbox" name="skrining_nyeri_6" id="skrining_nyeri_6" value="3" ' . ((isset($arr_skrining_nyeri[5]) and $arr_skrining_nyeri[5] == '3') ? 'checked="checked"' : '') . ' />&nbsp;Tidak ada nyeri
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">Nyeri hilang, bila :<br />
		<input type="checkbox" name="skrining_nyeri_7" id="skrining_nyeri_7" value="1" ' . ((isset($arr_skrining_nyeri[6]) and $arr_skrining_nyeri[6] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Minum obat
		<input type="checkbox" name="skrining_nyeri_8" id="skrining_nyeri_8" value="1" ' . ((isset($arr_skrining_nyeri[7]) and $arr_skrining_nyeri[7] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Istirahat
		<input type="checkbox" name="skrining_nyeri_9" id="skrining_nyeri_9" value="1" ' . ((isset($arr_skrining_nyeri[8]) and $arr_skrining_nyeri[8] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Mendengar musik
		<input type="checkbox" name="skrining_nyeri_10" id="skrining_nyeri_10" value="1" ' . ((isset($arr_skrining_nyeri[9]) and $arr_skrining_nyeri[9] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Berubah posisi/ tidur<br />
		<input type="checkbox" name="skrining_nyeri_11" id="skrining_nyeri_11" value="1" ' . ((isset($arr_skrining_nyeri[10]) and $arr_skrining_nyeri[10] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Lain-lain, sebutkan
		' . ((isset($arr_skrining_nyeri[11])) ? setGarisIfNull($arr_skrining_nyeri[11]) : $adline) . '<br />
		Diberitahukan ke dokter/ Tim Pain Manajemen <br /><input type="checkbox" name="skrining_nyeri_13" id="skrining_nyeri_13" value="1" ' . ((isset($arr_skrining_nyeri[12]) and $arr_skrining_nyeri[12] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Ya, pukul
		' . ((isset($arr_skrining_nyeri[13])) ? setGarisIfNull($arr_skrining_nyeri[13]) : $adline) . '
		<input type="checkbox" name="skrining_nyeri_13" id="skrining_nyeri_13" value="2" ' . ((isset($arr_skrining_nyeri[12]) and $arr_skrining_nyeri[12] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td valign="top">PEMERIKSAAN PENUNJANG (tuliskan hasil pemeriksaan penunjang baik Laboratorium, EKG, maupun pencitraan pasien)</td>
		<td colspan="2">' . setGarisIfNull($pemeriksaan_penunjang) . '</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4">10. KEBUTUHAN EDUKASI</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">a. Terdapat hambatan dalam pembelajaran <input type="checkbox" name="kebutuhan_edukasi_1" id="kebutuhan_edukasi_1" value="1" ' . ((isset($arr_kebutuhan_edukasi[0]) and $arr_kebutuhan_edukasi[0] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Tidak
		<input type="checkbox" name="kebutuhan_edukasi_1" id="kebutuhan_edukasi_1" value="2" ' . ((isset($arr_kebutuhan_edukasi[0]) and $arr_kebutuhan_edukasi[0] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Ya</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">b. Jika ya, sebutkan hambatannya<br /><input type="checkbox" name="kebutuhan_edukasi_2" id="kebutuhan_edukasi_2" value="1" ' . ((isset($arr_kebutuhan_edukasi[1]) and $arr_kebutuhan_edukasi[1] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Pendengaran
		<input type="checkbox" name="kebutuhan_edukasi_3" id="kebutuhan_edukasi_3" value="1" ' . ((isset($arr_kebutuhan_edukasi[2]) and $arr_kebutuhan_edukasi[2] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Penglihatan
		<input type="checkbox" name="kebutuhan_edukasi_4" id="kebutuhan_edukasi_4" value="1" ' . ((isset($arr_kebutuhan_edukasi[3]) and $arr_kebutuhan_edukasi[3] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Kognitif
		<input type="checkbox" name="kebutuhan_edukasi_5" id="kebutuhan_edukasi_5" value="1" ' . ((isset($arr_kebutuhan_edukasi[4]) and $arr_kebutuhan_edukasi[4] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Fisik
		<input type="checkbox" name="kebutuhan_edukasi_6" id="kebutuhan_edukasi_6" value="1" ' . ((isset($arr_kebutuhan_edukasi[5]) and $arr_kebutuhan_edukasi[5] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Budaya
		<input type="checkbox" name="kebutuhan_edukasi_7" id="kebutuhan_edukasi_7" value="1" ' . ((isset($arr_kebutuhan_edukasi[6]) and $arr_kebutuhan_edukasi[6] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Agama
		<input type="checkbox" name="kebutuhan_edukasi_8" id="kebutuhan_edukasi_8" value="1" ' . ((isset($arr_kebutuhan_edukasi[7]) and $arr_kebutuhan_edukasi[7] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Emosi
		<input type="checkbox" name="kebutuhan_edukasi_9" id="kebutuhan_edukasi_9" value="1" ' . ((isset($arr_kebutuhan_edukasi[8]) and $arr_kebutuhan_edukasi[8] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Bahasa<br />
		<input type="checkbox" name="kebutuhan_edukasi_10" id="kebutuhan_edukasi_10" value="1" ' . ((isset($arr_kebutuhan_edukasi[9]) and $arr_kebutuhan_edukasi[9] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Lainnya
		' . ((isset($arr_kebutuhan_edukasi[10])) ? setGarisIfNull($arr_kebutuhan_edukasi[10]) : $adline) . '</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">c. Dibutuhkan penerjemah <input type="checkbox" name="kebutuhan_edukasi_12" id="kebutuhan_edukasi_12" value="1" ' . ((isset($arr_kebutuhan_edukasi[11]) and $arr_kebutuhan_edukasi[11] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Tidak
		<input type="checkbox" name="kebutuhan_edukasi_12" id="kebutuhan_edukasi_12" value="2" ' . ((isset($arr_kebutuhan_edukasi[11]) and $arr_kebutuhan_edukasi[11] == '2') ? 'checked="checked"' : '') . ' />&nbsp;Ya, sebutkan
		' . ((isset($arr_kebutuhan_edukasi[12])) ? setGarisIfNull($arr_kebutuhan_edukasi[12]) : $adline) . '</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="3">d. Kebutuhan pembelajaran pasien (pilih topik pembelajaran)<br /><input type="checkbox" name="kebutuhan_edukasi_14" id="kebutuhan_edukasi_14" value="1" ' . ((isset($arr_kebutuhan_edukasi[13]) and $arr_kebutuhan_edukasi[13] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Diagnosa & manajemen
		<input type="checkbox" name="kebutuhan_edukasi_15" id="kebutuhan_edukasi_15" value="1" ' . ((isset($arr_kebutuhan_edukasi[14]) and $arr_kebutuhan_edukasi[14] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Obat-obatan
		<input type="checkbox" name="kebutuhan_edukasi_16" id="kebutuhan_edukasi_16" value="1" ' . ((isset($arr_kebutuhan_edukasi[15]) and $arr_kebutuhan_edukasi[15] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Perawatan luka
		<input type="checkbox" name="kebutuhan_edukasi_17" id="kebutuhan_edukasi_17" value="1" ' . ((isset($arr_kebutuhan_edukasi[16]) and $arr_kebutuhan_edukasi[16] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Rehabilitasi
		<input type="checkbox" name="kebutuhan_edukasi_18" id="kebutuhan_edukasi_18" value="1" ' . ((isset($arr_kebutuhan_edukasi[17]) and $arr_kebutuhan_edukasi[17] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Manajemen nyeri<br />
		<input type="checkbox" name="kebutuhan_edukasi_19" id="kebutuhan_edukasi_19" value="1" ' . ((isset($arr_kebutuhan_edukasi[18]) and $arr_kebutuhan_edukasi[18] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Diet & nutrisi
		<input type="checkbox" name="kebutuhan_edukasi_20" id="kebutuhan_edukasi_20" value="1" ' . ((isset($arr_kebutuhan_edukasi[19]) and $arr_kebutuhan_edukasi[19] == '1') ? 'checked="checked"' : '') . ' />&nbsp;Lainnya
		' . ((isset($arr_kebutuhan_edukasi[20])) ? setGarisIfNull($arr_kebutuhan_edukasi[20]) : $adline) . '</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4">11. MASALAH/ DIAGNOSA (cantumkan minimal dua masalah/ diagnosa keperawatan yang prioritas)</td>
	</tr>';

	$qry_diagnosa = 'SELECT MASALAH_DIAGNOSA_ID,MASALAH_DIAGNOSA
					FROM t_irna_askep_masalah_diagnosa
					WHERE PENGKAJIAN_AWAL_ID ="' . $idx . '"';
	$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
	if(mysql_num_rows($get_diagnosa) == 0){
		$edoc_content_2 = $edoc_content_2 . '<tr>
			<td align="right" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.&nbsp;</td>
			<td colspan="3">' . $adline . '</td>
			</tr>';
	}else{
		$d = 0;
		while($dat_diagnosa = mysql_fetch_array($get_diagnosa)){
			$edoc_content_2 = $edoc_content_2 . '<tr>
				<td align="right" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . ($d + 1) . '.&nbsp;</td>
				<td colspan="3">' . setGarisIfNull($dat_diagnosa['MASALAH_DIAGNOSA']) . '</td>
				</tr>';	
		$d++; }	
	}
	
	$edoc_content_2 = $edoc_content_2 . '</table>';
	
	ob_start();
	include('edoc_rekammedik/edoc_frame_add.php');
	$html = ob_get_contents();
	ob_end_clean();
	$mpdf->AddPage('P'); 
	$mpdf->WriteHTML($html);
	
	$edoc_first = '<table width="100%" cellpadding="0" cellspacing="0" autosize="1" >';
	
	$edoc_header = '<tr>
				<td colspan="4">12. PERENCANAAN KEPERAWATAN (uraikan tujuan, kriteria hasil, dan intervensi sesuai masalah keperawatan yang ditemukan pada pasien)</td>
			</tr>';
			
	$edoc_perencanaan = '';		
			
	$qry_perencanaan = 'SELECT PERENCANAAN_KEPERAWATAN_ID,DIAGNOSA,TUJUAN,KRITERIA_HASIL,INTERVENSI
						FROM t_irna_askep_perencanaan_keperawatan
					WHERE PENGKAJIAN_AWAL_ID ="' . $idx . '"';
	$get_perencanaan = mysql_query($qry_perencanaan) or die(mysql_error());
	if(mysql_num_rows($get_perencanaan) == 0){
		$edoc_perencanaan = $edoc_first . $edoc_header . '
				<tr>
				<td align="right" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.&nbsp;</td>
				<td>Diagnosa Keperawatan</td>
				<td colspan="2">:&nbsp;' . $adline . '</td>
				</tr>
				<tr>
					<td align="right">&nbsp;</td>
					<td>Tujuan</td>
					<td colspan="2">:&nbsp;' . $adline . '</td>
				</tr>
				<tr>
					<td align="right">&nbsp;</td>
					<td>Kriteria Hasil</td>
					<td colspan="2">:&nbsp;' . $adline . '</td>
				</tr>
				<tr>
					<td align="right">&nbsp;</td>
					<td>Intervensi</td>
					<td colspan="2">:&nbsp;' . $adline . '</td>
				</tr>
				</table>';	
		$edoc_content_2 = $edoc_perencanaan;
		ob_start();
		include('edoc_rekammedik/edoc_frame_add.php');
		$html = ob_get_contents();
		ob_end_clean();
		$mpdf->AddPage('P'); 
		$mpdf->WriteHTML($html);	
		
	}else{
		$d = 0;
		$e = 1;
		$fp = false;
		while($dat_perencanaan = mysql_fetch_array($get_perencanaan)){
			$edoc_perencanaan = $edoc_perencanaan . '
				<tr>
				<td align="right" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . ($d + 1) . '.&nbsp;</td>
				<td>Diagnosa Keperawatan</td>
				<td colspan="2">:&nbsp;' . setGarisIfNull($dat_perencanaan['DIAGNOSA']) . '</td>
				</tr>
				<tr>
					<td align="right">&nbsp;</td>
					<td>Tujuan</td>
					<td colspan="2">:&nbsp;' . setGarisIfNull($dat_perencanaan['TUJUAN']) . '</td>
				</tr>
				<tr>
					<td align="right">&nbsp;</td>
					<td>Kriteria Hasil</td>
					<td colspan="2">:&nbsp;' . setGarisIfNull($dat_perencanaan['KRITERIA_HASIL']) . '</td>
				</tr>
				<tr>
					<td align="right">&nbsp;</td>
					<td>Intervensi</td>
					<td colspan="2">:&nbsp;' . setGarisIfNull($dat_perencanaan['INTERVENSI']) . '</td>
				</tr>';	
				
				if($e == 3){
					if($fp == false) {
						$edoc_content_2  = $edoc_first . $edoc_header . $edoc_perencanaan . '</table>';
						$fp = true;
					}else{
						$edoc_content_2  = $edoc_first . $edoc_perencanaan . '</table>';
					}
					
					ob_start();
					include('edoc_rekammedik/edoc_frame_add.php');
					$html = ob_get_contents();
					ob_end_clean();
					$mpdf->AddPage('P'); 
					$mpdf->WriteHTML($html);
					$edoc_perencanaan = '';
					$e = 0;
				}
		$d++; 
		$e++;
		}

	if($edoc_perencanaan != ''){
		if($fp == false) {
			$edoc_content_2  = $edoc_first . $edoc_header . $edoc_perencanaan . '</table>';
		}else{
			$edoc_content_2  = $edoc_first . $edoc_perencanaan . '</table>';
		}
	
		ob_start();
		include('edoc_rekammedik/edoc_frame_add.php');
		$html = ob_get_contents();
		ob_end_clean();
		$mpdf->AddPage('P'); 
		$mpdf->WriteHTML($html);	
	}	
	}
				
	$st_print = true;
}
//end Pengkajian Awal Rawat Inap Umum	

//Catatan Keperawatan
$edoc_nama_documen = strtoupper('Catatan Keperawatan');

$qry_catatan_keperawatan = 'SELECT CATATAN_KEPERAWATAN_ID,IRNA_ID,
						DATE_FORMAT(TANGGAL,"%d/%m/%Y") AS TANGGAL,
						DATE_FORMAT(TANGGAL,"%H:%i") AS JAM,
						SOAP,PERAWAT,USER_ASKEP,NAMA_PEGAWAI
						FROM t_irna_askep_catatan_keperawatan
						LEFT JOIN m_pegawai ON (t_irna_askep_catatan_keperawatan.PERAWAT = m_pegawai.PEGAWAI_ID)
						WHERE IRNA_ID = "' . $idx . '"
						ORDER BY TANGGAL';
$get_catatan_keperawatan = mysql_query($qry_catatan_keperawatan) or die(mysql_error());
if(mysql_num_rows($get_catatan_keperawatan) > 0){
	$edoc_first = '<style>.tbl tr td {
				   border: 1px solid black;
				   padding-left:1px;
				   border-collapse: collapse;
			}</style>
	<table width="100%" class="tbl" cellpadding="0" cellspacing="0" autosize="1" >
					<tr>
					<td width="40" align="center" bgcolor="#CCCCCC" ><strong>No</strong></td>
					<td width="70" align="center" bgcolor="#CCCCCC" ><strong>Tanggal</strong></td>
					<td width="50" align="center" bgcolor="#CCCCCC" ><strong>Pukul</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Implementasi dan Evaluasi Keperawatan (SOAP)</strong></td>
					<td width="130" align="center" bgcolor="#CCCCCC" ><strong>Perawat</strong></td>
				</tr>';
	$edoc_end = '</table>';
	
	$edoc_main = '';
	
	$x = 1;
	$y = 1;
	$fp = false;
	$tanggal ='';
	while($dat_catatan_keperawatan = mysql_fetch_array($get_catatan_keperawatan)){
		$tgl = '';
		if($dat_catatan_keperawatan['TANGGAL'] != $tanggal){
			$tanggal = $dat_catatan_keperawatan['TANGGAL'];
			$tgl = $dat_catatan_keperawatan['TANGGAL'];
		}
		$edoc_main = $edoc_main . '<tr>
					<td align="center">' . $x . '</td>
					<td>' . $tgl . '</td>
					<td>' . $dat_catatan_keperawatan['JAM'] . '</td>
					<td>' . $dat_catatan_keperawatan['SOAP'] . '</td>
					<td>' . $dat_catatan_keperawatan['NAMA_PEGAWAI'] . '</td>
				</tr>';
				
			if($y == 5){
				if($fp == false){
					$edoc_content = $edoc_first . $edoc_main . $edoc_end;
					ob_start();
					include('edoc_rekammedik/edoc_frame_main.php');
					$html = ob_get_contents();
					ob_end_clean();
					if($st_print == true) $mpdf->AddPage('P');
					$mpdf->WriteHTML($html);
					
					$fp = true;
				}else{
					$edoc_content_2 = $edoc_first . $edoc_main . $edoc_end;
					ob_start();
					include('edoc_rekammedik/edoc_frame_add.php');
					$html = ob_get_contents();
					ob_end_clean();
					$mpdf->AddPage('P');
					$mpdf->WriteHTML($html);
				}
				$y = 0;
			$edoc_main = '';
			}	
	$x++;
	$y++;
	}
	
	if($edoc_main != ''){
		if($fp == false) {
			$edoc_content  = $edoc_first . $edoc_main . $edoc_end;
			ob_start();
			include('edoc_rekammedik/edoc_frame_main.php');
			$html = ob_get_contents();
			ob_end_clean();
			$mpdf->AddPage('P'); 
			$mpdf->WriteHTML($html);
		}else{
			$edoc_content_2  = $edoc_first . $edoc_main . $edoc_end;
			ob_start();
			include('edoc_rekammedik/edoc_frame_add.php');
			$html = ob_get_contents();
			ob_end_clean();
			$mpdf->AddPage('P'); 
			$mpdf->WriteHTML($html);	
		}
	}	
	
	$st_print = true;
}	
//Catatan Keperawatan

//Catatan Pemberian Obat
$edoc_nama_documen = strtoupper('Catatan Pemberian Obat<br />(One Day Dose Dispensing)');

$qry_catatan_pemberian_obat = 'SELECT DISTINCT TANGGAL,JAM,CATATAN,HARGA,PERAWAT,ENTRY_DATA,FARMASI
					FROM t_irna_askep_pemberian_obat
					WHERE IRNA_ID = "' . $idx . '"';
$get_catatan_pemberian_obat = mysql_query($qry_catatan_pemberian_obat) or die(mysql_error());
if(mysql_num_rows($get_catatan_pemberian_obat) > 0){
	$dat_catatan_pemberian_obat = mysql_fetch_assoc($get_catatan_pemberian_obat);
	$tanggal = explode('|',$dat_catatan_pemberian_obat['TANGGAL']);
	$jam = explode('|',$dat_catatan_pemberian_obat['JAM']);
	$catatan = $dat_catatan_pemberian_obat['CATATAN'];
	$harga = explode('|',$dat_catatan_pemberian_obat['HARGA']);
	$perawat = explode('|',$dat_catatan_pemberian_obat['PERAWAT']);
	$entry_data = explode('|',$dat_catatan_pemberian_obat['ENTRY_DATA']);
	$farmasi = explode('|',$dat_catatan_pemberian_obat['FARMASI']);	

	$edoc_first = '<style>.tbl tr td {
				   border: 1px solid black;
				   padding-left:1px;
				   border-collapse: collapse;
			}</style>
	<table width="100%" class="tbl" cellpadding="0" cellspacing="0" autosize="1" >
		<tr>
			<td rowspan="3" align="center" bgcolor="#CCCCCC" ><strong>No</strong></td>
			<td rowspan="3" align="center" bgcolor="#CCCCCC" ><strong>Dokter</strong></td>
			<td rowspan="3" align="center" bgcolor="#CCCCCC" ><strong>Obat/ Injeksi</strong></td>
			<td rowspan="3" align="center" bgcolor="#CCCCCC" ><strong>Dosis</strong></td>
			<td rowspan="3" align="center" bgcolor="#CCCCCC" ><strong>Aturai Pakai</strong></td>
			<td colspan="20" align="center" bgcolor="#CCCCCC" ><strong>Jadwal Pemberian/ Tanggal</strong></td>
			<td rowspan="3" align="center" bgcolor="#CCCCCC" ><strong>Keterangan</strong></td>
		</tr>
		  <tr>
			<td colspan="4" align="center" bgcolor="#CCCCCC" ><strong>' . ((isset($tanggal[0])) ? $tanggal[0]:'') . '</strong></td>
			<td colspan="4" align="center" bgcolor="#CCCCCC" ><strong>' . ((isset($tanggal[1])) ? $tanggal[1]:'') . '</strong></td>
			<td colspan="4" align="center" bgcolor="#CCCCCC" ><strong>' . ((isset($tanggal[2])) ? $tanggal[2]:'') . '</strong></td>
			<td colspan="4" align="center" bgcolor="#CCCCCC" ><strong>' . ((isset($tanggal[3])) ? $tanggal[3]:'') . '</strong></td>
			<td colspan="4" align="center" bgcolor="#CCCCCC" ><strong>' . ((isset($tanggal[4])) ? $tanggal[4]:'') . '</strong></td>
		  </tr>
		<tr>';
    $x = 0; 
	while($x < 20){ 
		$edoc_first = $edoc_first . '<td align="center" bgcolor="#CCCCCC" ><strong>' . ((isset($jam[$x])) ? $jam[$x]:'') . '</strong></td>';
    $x++; 
	}
	$edoc_first = $edoc_first . '</tr>';
  
	$qry_catatan_pemberian_obat_detail = 'SELECT PEMBERIAN_OBAT_ID,JADWAL,DOKTER,PERSEDIAAN_ID,NAMA_OBAT,DOSIS,ATURAN_PAKAI,KETERANGAN,NAMA_PEGAWAI
							FROM t_irna_askep_pemberian_obat
							LEFT JOIN m_pegawai ON (DOKTER = m_pegawai.PEGAWAI_ID)
							WHERE IRNA_ID = "' . $idx . '"';
	$get_catatan_pemberian_obat_detail = mysql_query($qry_catatan_pemberian_obat_detail) or die(mysql_error());
	$edoc_main = '';
	$i = 1;
	$j = 1;
	$fp = false;
	while($dat_catatan_pemberian_obat_detail = mysql_fetch_array($get_catatan_pemberian_obat_detail)){ 
		$edoc_main = $edoc_main . '<tr>
						<td align="center">' . $i . '</td>
						<td>' . $dat_catatan_pemberian_obat_detail['NAMA_PEGAWAI'] . '</td>
						<td>' . $dat_catatan_pemberian_obat_detail['NAMA_OBAT'] . '</td>
						<td>' . $dat_catatan_pemberian_obat_detail['DOSIS'] . '</td>
						<td>' . $dat_catatan_pemberian_obat_detail['ATURAN_PAKAI'] . '</td>';
	
					$jadwal = explode('|',$dat_catatan_pemberian_obat_detail['JADWAL']); 
					$x = 0; 
					while($x < 20){ 
						$n = $x + 1; 
						$edoc_main = $edoc_main . '<td align="center"><input type="checkbox" name="jadwal" value="1" ' . ((isset($jadwal[$x]) and $jadwal[$x] == '1') ? 'checked="checked"':'') . ' /></td>';
					$x++; 
					} 
					$edoc_main = $edoc_main . '<td>' . $dat_catatan_pemberian_obat_detail['KETERANGAN'] . '</td></tr>';
			if($j == 10){
				if($fp == false){
					$edoc_content = $edoc_first . $edoc_main . '</table>';
					ob_start();
					include('edoc_rekammedik/edoc_frame_main.php');
					$html = ob_get_contents();
					ob_end_clean();
					if($st_print == true) {
						$mpdf->AddPage('L');
					}else{
						$mpdf = new mPDF('utf-8', array($paper_height,$paper_width));
						$mpdf->autoPageBreak = false;
						$mpdf->SetHTMLHeader(setHeader($nomr,$nama_pasien));
						$mpdf->SetHTMLFooter(setFooter('Asuhan Keperawatan'));
						$st_ls = true;
					}	
					$mpdf->WriteHTML($html);
					
					$fp = true;
				}else{
					$edoc_content_2 = $edoc_first . $edoc_main . '</table>';
					ob_start();
					include('edoc_rekammedik/edoc_frame_add.php');
					$html = ob_get_contents();
					ob_end_clean();
					if($st_print == true){
						$mpdf->AddPage('L');
					}else{
						$mpdf->AddPage('P');
					}	
					$mpdf->WriteHTML($html);
				}
				$j = 0;
			$edoc_main = '';
			}
	$i++; 
	$j++;
	}	
	
	if($edoc_main != ''){
		if($fp == false) {
			$edoc_content  = $edoc_first . $edoc_main . '</table>';
			ob_start();
			include('edoc_rekammedik/edoc_frame_main.php');
			$html = ob_get_contents();
			ob_end_clean();
			if($st_print == true) {
				$mpdf->AddPage('L');
			}else{
				$mpdf = new mPDF('utf-8', array($paper_height,$paper_width));
				$mpdf->autoPageBreak = false;
				$mpdf->SetHTMLHeader(setHeader($nomr,$nama_pasien));
				$mpdf->SetHTMLFooter(setFooter('Asuhan Keperawatan'));
				$st_ls = true;
			}
			$mpdf->WriteHTML($html);
		}else{
			$edoc_content_2  = $edoc_first . $edoc_main . '</table>';
			ob_start();
			include('edoc_rekammedik/edoc_frame_add.php');
			$html = ob_get_contents();
			ob_end_clean();
			if($st_print == true){
				$mpdf->AddPage('L');
			}else{
				$mpdf->AddPage('P');
			}	
			$mpdf->WriteHTML($html);	
		}
	}
	
	
	$edoc_content_2 = str_replace('autosize="1"','',$edoc_first) . '<tr>
								<td colspan="3">Catatan</td>
								<td colspan="2">Pengisi (Farmasi) </td>
								<td colspan="4">' . ((isset($farmasi[0])) ? $farmasi[0] : '') . '</td>
								<td colspan="4">' . ((isset($farmasi[1])) ? $farmasi[1] : '') . '</td>
								<td colspan="4">' . ((isset($farmasi[2])) ? $farmasi[2] : '') . '</td>
								<td colspan="4">' . ((isset($farmasi[3])) ? $farmasi[3] : '') . '</td>
								<td colspan="4">' . ((isset($farmasi[4])) ? $farmasi[4] : '') . '</td>
								<td>&nbsp;</td>
							  </tr>
							  <tr>
								<td colspan="3" rowspan="3">' . setGarisIfNull($catatan) . '</td>
								<td colspan="2">Entry Data</td>
								<td colspan="4">' . ((isset($entry_data[0])) ? $entry_data[0] : '') . '</td>
								<td colspan="4">' . ((isset($entry_data[1])) ? $entry_data[1] : '') . '</td>
								<td colspan="4">' . ((isset($entry_data[2])) ? $entry_data[2] : '') . '</td>
								<td colspan="4">' . ((isset($entry_data[3])) ? $entry_data[3] : '') . '</td>
								<td colspan="4">' . ((isset($entry_data[4])) ? $entry_data[4] : '') . '</td>
								<td>&nbsp;</td>
							  </tr>
							  <tr>
								<td colspan="2">Subtotal (Rp) </td>
								<td colspan="4">' . ((isset($harga[0])) ? $harga[0] : '') . '</td>
								<td colspan="4">' . ((isset($harga[1])) ? $harga[1] : '') . '</td>
								<td colspan="4">' . ((isset($harga[2])) ? $harga[2] : '') . '</td>
								<td colspan="4">' . ((isset($harga[3])) ? $harga[3] : '') . '</td>
								<td colspan="4">' . ((isset($harga[4])) ? $harga[4] : '') . '</td>
								<td>&nbsp;</td>
							  </tr>
							  <tr>
								<td colspan="2">Perawat</td>';
								$x = 0; 
								while($x<20){ 
									$xperawat= '';
									if(isset($perawat[$x])) $xperawat = $perawat[$x]; 
									$edoc_content_2 = $edoc_content_2 . '<td>' . $arr_perawat[$xperawat] . '</td>';
								$x++; 
								} 
								$edoc_content_2 = $edoc_content_2 . '<td>&nbsp;</td>
													  </tr>
													  </table>';
	ob_start();
	include('edoc_rekammedik/edoc_frame_add.php');
	$html = ob_get_contents();
	ob_end_clean();
	if($st_print == true){
		$mpdf->AddPage('L');
	}else{
		$mpdf->AddPage('P');
	}	
	$mpdf->WriteHTML($html);												  
	
	$st_print = true;
}	
//End Catatan Pemberian Obat

//Formulir Pelaporan Efek Samping Obat
$edoc_nama_documen = strtoupper('Formulir Pelaporan Efek Samping Obat');

$qry_pelaporan_eso = 'SELECT PELAPORAN_ESO_ID,PENYAKIT_UTAMA,KESUDAHAN_PENYAKIT_UTAMA,PENYAKIT_LAIN_MENYERTAI,
			DATE_FORMAT(TANGGAL_MULAI_TERJADI,"%d/%m/%Y") AS TANGGAL_MULAI_TERJADI,
			DATE_FORMAT(TANGGAL_KESUDAHAN_ESO,"%d/%m/%Y") AS TANGGAL_KESUDAHAN_ESO,
			BENTUK_ESO,DATA_LABORATORIUM,KESUDAHAN_ESO,REAKSI_ESO,TINDAKAN,REAKSI_HILANG,REAKSI_TIMBUL,
			ALGHORITMA_NARANJO,PERAWAT,DATE_FORMAT(TANGGAL,"%d/%m/%Y") AS TANGGAL
			FROM t_irna_askep_pelaporan_eso
			WHERE PELAPORAN_ESO_ID = "' . $idx . '"';
$get_pelaporan_eso = mysql_query($qry_pelaporan_eso) or die(mysql_error());
if(mysql_num_rows($get_pelaporan_eso) > 0){
	$dat_pelaporan_eso = mysql_fetch_assoc($get_pelaporan_eso);
	$pelaporan_eso_id = $dat_pelaporan_eso['PELAPORAN_ESO_ID'];
	$penyakit_utama = $dat_pelaporan_eso['PENYAKIT_UTAMA'];
	$kesudahan_penyakit_utama = $dat_pelaporan_eso['KESUDAHAN_PENYAKIT_UTAMA'];
	$penyakit_lain_menyertai = $dat_pelaporan_eso['PENYAKIT_LAIN_MENYERTAI'];
	$tanggal_mulai_terjadi = $dat_pelaporan_eso['TANGGAL_MULAI_TERJADI'];
	$bentuk_eso = $dat_pelaporan_eso['BENTUK_ESO'];
	$data_laboratorium = $dat_pelaporan_eso['DATA_LABORATORIUM'];
	$kesudahan_eso = $dat_pelaporan_eso['KESUDAHAN_ESO'];
	$tanggal_kesudahan_eso = $dat_pelaporan_eso['TANGGAL_KESUDAHAN_ESO'];
	$reaksi_eso = $dat_pelaporan_eso['REAKSI_ESO'];
	$tindakan = $dat_pelaporan_eso['TINDAKAN'];
	$reaksi_hilang = $dat_pelaporan_eso['REAKSI_HILANG'];
	$reaksi_timbul = $dat_pelaporan_eso['REAKSI_TIMBUL'];
	$alghoritma_naranjo = $dat_pelaporan_eso['ALGHORITMA_NARANJO'];
	$tanggal = $dat_pelaporan_eso['TANGGAL'];
	$perawat = $dat_pelaporan_eso['PERAWAT'];

	$arr_penyakit_lain_menyertai = explode('|',$penyakit_lain_menyertai);
	$arr_alghoritma_naranjo = explode('|',$alghoritma_naranjo);

	$edoc_content = '<table border="0" width="100%" autosize="1">
			<tr>
				<td width="100">Tanggal</td>
				<td>:&nbsp;' . setGarisIfNull($tanggal) . '</td>
			</tr>
			<tr>
				<td width="100">Perawat</td>
				<td>:&nbsp;' . $arr_perawat[$perawat] . '</td>
			</tr>
			<tr>
				<td width="100">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			</table>
			<table width="100%" cellpadding="0" cellspacing="0" border="0" autosize="1" >
				<tr>
					<td colspan="3">1. PASIEN</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign="top">Penyakit Utama</td>
					<td>:&nbsp;' . setGarisIfNull($penyakit_utama) . '</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign="top">Kesudahan Penyakit Utama</td>
					<td>:&nbsp;
						<input type="checkbox" name="kesudahan_penyakit_utama" id="kesudahan_penyakit_utama" value="1" ' . (($kesudahan_penyakit_utama=='1') ? 'checked="checked"' : '') . ' />&nbsp;Sembuh
						<input type="checkbox" name="kesudahan_penyakit_utama" id="kesudahan_penyakit_utama" value="2" ' . (($kesudahan_penyakit_utama=='2') ? 'checked="checked"' : '') . ' />&nbsp;Meninggal
						<input type="checkbox" name="kesudahan_penyakit_utama" id="kesudahan_penyakit_utama" value="3" ' . (($kesudahan_penyakit_utama=='3') ? 'checked="checked"' : '') . ' />&nbsp;Sembuh dengan gejala sisa
						<input type="checkbox" name="kesudahan_penyakit_utama" id="kesudahan_penyakit_utama" value="4" ' . (($kesudahan_penyakit_utama=='4') ? 'checked="checked"' : '') . ' />&nbsp;Belum sembuh
						<input type="checkbox" name="kesudahan_penyakit_utama" id="kesudahan_penyakit_utama" value="5" ' . (($kesudahan_penyakit_utama=='5') ? 'checked="checked"' : '') . ' />&nbsp;Tidak tahu
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign="top">Penyakit/ kondisi lain yang menyertai</td>
					<td>:&nbsp;
						<input type="checkbox" name="penyakit_lain_menyertai_1" id="penyakit_lain_menyertai_1" value="1" ' . ((isset($arr_penyakit_lain_menyertai[0]) and $arr_penyakit_lain_menyertai[0]=='1') ? 'checked="checked"' : '') . ' />&nbsp;Gangguan ginjal
						<input type="checkbox" name="penyakit_lain_menyertai_2" id="penyakit_lain_menyertai_2" value="1" ' . ((isset($arr_penyakit_lain_menyertai[1]) and $arr_penyakit_lain_menyertai[1]=='1') ? 'checked="checked"' : '') . ' />&nbsp;Gangguan hati
						<input type="checkbox" name="penyakit_lain_menyertai_3" id="penyakit_lain_menyertai_3" value="1" ' . ((isset($arr_penyakit_lain_menyertai[2]) and $arr_penyakit_lain_menyertai[2]=='1') ? 'checked="checked"' : '') . ' />&nbsp;Alergi
						<input type="checkbox" name="penyakit_lain_menyertai_4" id="penyakit_lain_menyertai_4" value="1" ' . ((isset($arr_penyakit_lain_menyertai[3]) and $arr_penyakit_lain_menyertai[3]=='1') ? 'checked="checked"' : '') . ' />&nbsp;Kondisi medis lainnya
						<input type="checkbox" name="penyakit_lain_menyertai_5" id="penyakit_lain_menyertai_5" value="1" ' . ((isset($arr_penyakit_lain_menyertai[4]) and $arr_penyakit_lain_menyertai[4]=='1') ? 'checked="checked"' : '') . ' />&nbsp;Faktor industri, pertanian, kimia<br />
						<input type="checkbox" name="penyakit_lain_menyertai_6" id="penyakit_lain_menyertai_6" value="1" ' . ((isset($arr_penyakit_lain_menyertai[5]) and $arr_penyakit_lain_menyertai[5]=='1') ? 'checked="checked"' : '') . ' />&nbsp;Lain-lain
						' . ((isset($arr_penyakit_lain_menyertai[5])) ? setGarisIfNull($arr_penyakit_lain_menyertai[5]) : $adline) . '
					</td>
				</tr>
				<tr>
					<td colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3">2. EFEK SAMPING OBAT (ESO)</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign="top">Saat/ tanggal mulai terjadi</td>
					<td>:&nbsp;' . setGarisIfNull($tanggal_mulai_terjadi) . '</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign="top">Bentuk/ manifesto E.S.O yang terjadi</td>
					<td>:&nbsp;' . setGarisIfNull($bentuk_eso) . '</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign="top">Data laboratorium (jika ada)</td>
					<td>:&nbsp;' . setGarisIfNull($data_laboratorium) . '</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign="top">Kesudahan E.S.O</td>
					<td>:&nbsp;' . setGarisIfNull($tanggal_kesudahan_eso) . '</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>:&nbsp;
					<input type="checkbox" name="kesudahan_eso" id="kesudahan_eso" value="1" ' . (($kesudahan_eso=='1') ? 'checked="checked"' : '') . ' />&nbsp;Sembuh
					<input type="checkbox" name="kesudahan_eso" id="kesudahan_eso" value="2" ' . (($kesudahan_eso=='2') ? 'checked="checked"' : '') . ' />&nbsp;Meninggal
					<input type="checkbox" name="kesudahan_eso" id="kesudahan_eso" value="3" ' . (($kesudahan_eso=='3') ? 'checked="checked"' : '') . ' />&nbsp;Sembuh dengan gejala sisa
					<input type="checkbox" name="kesudahan_eso" id="kesudahan_eso" value="4" ' . (($kesudahan_eso=='4') ? 'checked="checked"' : '') . ' />&nbsp;Belum sembuh
					<input type="checkbox" name="kesudahan_eso" id="kesudahan_eso" value="5" ' . (($kesudahan_eso=='5') ? 'checked="checked"' : '') . ' />&nbsp;Tidak tahu
					</td>
				</tr>
				<tr>	
					<td>&nbsp;</td>
					<td valign="top">Reaksi E.S.O yang pernah dialami</td>
					<td>:&nbsp;' . setGarisIfNull($reaksi_eso) . '</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign="top">Tindakan yang telah dilakukan untuk mengatasi reaksi E.S.O</td>
					<td>:&nbsp;' . setGarisIfNull($tindakan) . '</td>
				</tr>
				</table>';
				
			ob_start();
			include('edoc_rekammedik/edoc_frame_main.php');
			$html = ob_get_contents();
			ob_end_clean();
			if($st_print == true){
				if($st_ls == true){
					$mpdf->AddPage('L');
				}else{
					$mpdf->AddPage('P');
				}
			} 
			$mpdf->WriteHTML($html);	
				
	$edoc_first = '<style>.tbl tr td {
				   border: 1px solid black;
				   padding-left:1px;
				   border-collapse: collapse;
			}</style>
			<table width="100%" class="tbl" cellpadding="0" cellspacing="0" autosize="1" >
							<tr>
								<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>No</strong></td>
								<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Nama Obat Yang Diberikan<br />(nama dagang/ pabrik)</strong></td>
								<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Bentuk Sediaan</strong></td>
								<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Nomor Batch</strong></td>
								<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Obat Yang<br />Dicurigai</strong></td>
								<td colspan="2" align="center" bgcolor="#CCCCCC" ><strong>Pemberian</strong></td>
								<td rowspan="2" align="center" bgcolor="#CCCCCC" ><strong>Indikasi Penggunaan</strong></td>
							</tr>
							<tr>
							  <td align="center" bgcolor="#CCCCCC" ><strong>Cara</strong></td>
							  <td align="center" bgcolor="#CCCCCC" ><strong>Tgl. Akhir</strong></td>
							</tr>';
	
	$qry_obat = 'SELECT ESO_OBAT_ID,PELAPORAN_ESO_ID,KODE_OBAT,NAMA_OBAT,BENTUK_SEDIAAN,NOMOR_BATCH,OBAT_DICURIGAI,
					CARA_PEMBERIAN,TANGGAL_AKHIR_PEMBERIAN,INDIKASI_PENGGUNAAN
					FROM t_irna_askep_pelaporan_eso_obat
					WHERE PELAPORAN_ESO_ID = "' . $idx . '"';
	$get_obat = mysql_query($qry_obat) or die(mysql_error());
	$i = 1;
	$j = 1;
	$edoc_main = '';
	$fp = false;	
	while($dat_obat = mysql_fetch_array($get_obat)){	
		$edoc_main = $edoc_main . '<tr>
				<td align="center">' . $i . '</td>
				<td>' . $dat_obat['NAMA_OBAT'] . '</td>
				<td>' . $dat_obat['BENTUK_SEDIAAN'] . '</td>
				<td>' . $dat_obat['NOMOR_BATCH'] . '</td>
				<td align="center">' . (($dat_obat['OBAT_DICURIGAI'] == '1') ? '&radic;' : '') . '</td>
				<td>' . $dat_obat['CARA_PEMBERIAN'] . '</td>
				<td>' . $dat_obat['TANGGAL_AKHIR_PEMBERIAN'] . '</td>
				<td>' . $dat_obat['INDIKASI_PENGGUNAAN'] . '</td>
				</tr>';
				
		if($j == 10){
			if($fp == false){
				$edoc_content_2 = '3. OBAT' . $edoc_first . $edoc_main . '</table>';
				ob_start();
				include('edoc_rekammedik/edoc_frame_add.php');
				$html = ob_get_contents();
				ob_end_clean();
				if($st_ls == true){
					$mpdf->AddPage('L');	
				}else{
					if($st_print == true) $mpdf->AddPage('P');
				}
						
				$mpdf->WriteHTML($html);
				$fp = true;
			}else{
				$edoc_content_2 = $edoc_first . $edoc_main . '</table>';
				ob_start();
				include('edoc_rekammedik/edoc_frame_add.php');
				$html = ob_get_contents();
				ob_end_clean();
				if($st_ls == true){
					$mpdf->AddPage('L');	
				}else{
					if($st_print == true) $mpdf->AddPage('P');
				}
				
				$mpdf->WriteHTML($html);
			}
			$j = 0;
			$edoc_main = '';
		}
			
	$i++; 
	$j++;
	}
	
	if($edoc_main != ''){
		if($fp == false){
				$edoc_content_2 = '3. OBAT' . $edoc_first . $edoc_main . '</table>';
				ob_start();
				include('edoc_rekammedik/edoc_frame_add.php');
				$html = ob_get_contents();
				ob_end_clean();
				if($st_ls == true){
					$mpdf->AddPage('L');	
				}else{
					if($st_print == true) $mpdf->AddPage('P');
				}
						
				$mpdf->WriteHTML($html);
				$fp = true;
			}else{
				$edoc_content_2 = $edoc_first . $edoc_main . '</table>';
				ob_start();
				include('edoc_rekammedik/edoc_frame_add.php');
				$html = ob_get_contents();
				ob_end_clean();
				if($st_ls == true){
					$mpdf->AddPage('L');	
				}else{
					if($st_print == true) $mpdf->AddPage('P');
				}
				
				$mpdf->WriteHTML($html);
			}
	}
	
	$edoc_content_2 = '<style>.tbl tr td {
				   border: 1px solid black;
				   padding-left:1px;
				   border-collapse: collapse;
			}</style>
			<table width="100%" cellpadding="0" cellspacing="0" border="0" autosize="1" >
					<tr>
					<td>&nbsp;</td>
					<td>Apakah reaksi E.S.O hilang setelah obat dihentikan</td>
					<td>:&nbsp;
						<input type="checkbox" name="reaksi_hilang" id="reaksi_hilang" value="1" ' . (($reaksi_hilang=='1') ? 'checked="checked"' : '') . ' />&nbsp;Ya
						<input type="checkbox" name="reaksi_hilang" id="reaksi_hilang" value="2" ' . (($reaksi_hilang=='2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak
						<input type="checkbox" name="reaksi_hilang" id="reaksi_hilang" value="3" ' . (($reaksi_hilang=='3') ? 'checked="checked"' : '') . ' />&nbsp;Tidak tahu
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>Apakah reaksi E.S.O yang sama timbul sewaktu obat<br />yang dicurigai digunakan kembali</td>
					<td>:&nbsp;
						<input type="checkbox" name="reaksi_timbul" id="reaksi_timbul" value="1" ' . (($reaksi_timbul=='1') ? 'checked="checked"' : '') . ' />&nbsp;Ya
						<input type="checkbox" name="reaksi_timbul" id="reaksi_timbul" value="2" ' . (($reaksi_timbul=='2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak
						<input type="checkbox" name="reaksi_timbul" id="reaksi_timbul" value="3" ' . (($reaksi_timbul=='3') ? 'checked="checked"' : '') . ' />&nbsp;Tidak tahu
					</td>
				</tr>
				<tr>
					<td colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3">4. ALGORITMA NARANJO</td>
				</tr>
			<tr>
				<td colspan="3">
				<table width="100%" class="tbl" cellpadding="0" cellspacing="0" autosize="1" >
				<tr>
					<td width="40px" align="center" bgcolor="#CCCCCC" ><strong>No</strong></td>
					<td align="center" bgcolor="#CCCCCC" ><strong>Pertanyaan</strong></td>
					<td width="100px" align="center" bgcolor="#CCCCCC" ><strong>Ya</strong></td>
					<td width="100px" align="center" bgcolor="#CCCCCC" ><strong>Tidak</strong></td>
					<td width="100px" align="center" bgcolor="#CCCCCC" ><strong>Tidak<br />Diketahui</strong></td>
				</tr>
				<tr>
					<td align="center">1</td>
					<td>Apakah ada laporan efek samping obat yang serupa ?</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_1" id="alghoritma_naranjo_1" value="1" ' . ((isset($arr_alghoritma_naranjo[0]) and $arr_alghoritma_naranjo[0]=='1') ? 'checked="checked"' : '') . ' />&nbsp;1</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_1" id="alghoritma_naranjo_1" value="2" ' . ((isset($arr_alghoritma_naranjo[0]) and $arr_alghoritma_naranjo[0]=='2') ? 'checked="checked"' : '') . ' />&nbsp;0</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_1" id="alghoritma_naranjo_1" value="3" ' . ((isset($arr_alghoritma_naranjo[0]) and $arr_alghoritma_naranjo[0]=='3') ? 'checked="checked"' : '') . ' />&nbsp;0</td>
				</tr>
				<tr>
					<td align="center">2</td>
					<td>Apakah ada laporan efek samping obat yang serupa yang dicurigai ?</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_2" id="alghoritma_naranjo_2" value="1" ' . ((isset($arr_alghoritma_naranjo[1]) and $arr_alghoritma_naranjo[1]=='1') ? 'checked="checked"' : '') . ' />&nbsp;2</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_2" id="alghoritma_naranjo_2" value="2" ' . ((isset($arr_alghoritma_naranjo[1]) and $arr_alghoritma_naranjo[1]=='2') ? 'checked="checked"' : '') . ' />&nbsp;-1</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_2" id="alghoritma_naranjo_2" value="3" ' . ((isset($arr_alghoritma_naranjo[1]) and $arr_alghoritma_naranjo[1]=='3') ? 'checked="checked"' : '') . ' />&nbsp;0</td>
				</tr>
				<tr>
					<td align="center">3</td>
					<td>Apakah efek samping obat membaik setelah obat dihentikan atau obat antagonis khusus diberikan ?</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_3" id="alghoritma_naranjo_3" value="1" ' . ((isset($arr_alghoritma_naranjo[2]) and $arr_alghoritma_naranjo[2]=='1') ? 'checked="checked"' : '') . ' />&nbsp;1</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_3" id="alghoritma_naranjo_3" value="2" ' . ((isset($arr_alghoritma_naranjo[2]) and $arr_alghoritma_naranjo[2]=='2') ? 'checked="checked"' : '') . ' />&nbsp;0</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_3" id="alghoritma_naranjo_3" value="3" ' . ((isset($arr_alghoritma_naranjo[2]) and $arr_alghoritma_naranjo[2]=='3') ? 'checked="checked"' : '') . ' />&nbsp;0</td>
				</tr>
				<tr>
					<td align="center">4</td>
					<td>Apakah efek samping terjadi berulang setelah obat diberikan kembali ?</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_4" id="alghoritma_naranjo_4" value="1" ' . ((isset($arr_alghoritma_naranjo[3]) and $arr_alghoritma_naranjo[3]=='1') ? 'checked="checked"' : '') . ' />&nbsp;2</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_4" id="alghoritma_naranjo_4" value="2" ' . ((isset($arr_alghoritma_naranjo[3]) and $arr_alghoritma_naranjo[3]=='2') ? 'checked="checked"' : '') . ' />&nbsp;-1</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_4" id="alghoritma_naranjo_4" value="3" ' . ((isset($arr_alghoritma_naranjo[3]) and $arr_alghoritma_naranjo[3]=='3') ? 'checked="checked"' : '') . ' />&nbsp;0</td>
				</tr>
				<tr>
					<td align="center">5</td>
					<td>Apakah ada alternatif penyebab yang dapat menjelaskan yang kemungkinan terjadi efek samping obat ?</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_5" id="alghoritma_naranjo_5" value="1" ' . ((isset($arr_alghoritma_naranjo[4]) and $arr_alghoritma_naranjo[4]=='1') ? 'checked="checked"' : '') . ' />&nbsp;-1</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_5" id="alghoritma_naranjo_5" value="2" ' . ((isset($arr_alghoritma_naranjo[4]) and $arr_alghoritma_naranjo[4]=='2') ? 'checked="checked"' : '') . ' />&nbsp;2</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_5" id="alghoritma_naranjo_5" value="3" ' . ((isset($arr_alghoritma_naranjo[4]) and $arr_alghoritma_naranjo[4]=='3') ? 'checked="checked"' : '') . ' />&nbsp;0</td>
				</tr>
				<tr>
					<td align="center">6</td>
					<td>Apakah efek samping obat muncul kembali ketika pasebo diberikan ?</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_6" id="alghoritma_naranjo_6" value="1" ' . ((isset($arr_alghoritma_naranjo[5]) and $arr_alghoritma_naranjo[5]=='1') ? 'checked="checked"' : '') . ' />&nbsp;-1</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_6" id="alghoritma_naranjo_6" value="2" ' . ((isset($arr_alghoritma_naranjo[5]) and $arr_alghoritma_naranjo[5]=='2') ? 'checked="checked"' : '') . ' />&nbsp;1</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_6" id="alghoritma_naranjo_6" value="3" ' . ((isset($arr_alghoritma_naranjo[5]) and $arr_alghoritma_naranjo[5]=='3') ? 'checked="checked"' : '') . ' />&nbsp;0</td>
				</tr>
				<tr>
					<td align="center">7</td>
					<td>Apakah obat yang dicurigai terdeteksi di dalam darah atau cairan tubuh lainnya dengan konsentrasi yang toksit ?</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_7" id="alghoritma_naranjo_7" value="1" ' . ((isset($arr_alghoritma_naranjo[6]) and $arr_alghoritma_naranjo[6]=='1') ? 'checked="checked"' : '') . ' />&nbsp;1</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_7" id="alghoritma_naranjo_7" value="2" ' . ((isset($arr_alghoritma_naranjo[6]) and $arr_alghoritma_naranjo[6]=='2') ? 'checked="checked"' : '') . ' />&nbsp;0</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_7" id="alghoritma_naranjo_7" value="3" ' . ((isset($arr_alghoritma_naranjo[6]) and $arr_alghoritma_naranjo[6]=='3') ? 'checked="checked"' : '') . ' />&nbsp;0</td>
				</tr>
				<tr>
					<td align="center">8</td>
					<td>Apakah efek samping obat bertambah parah ketika dosis obat ditingkatkan atau bertambah ringan ketika obat diturunkan dosisnya ?</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_8" id="alghoritma_naranjo_8" value="1" ' . ((isset($arr_alghoritma_naranjo[7]) and $arr_alghoritma_naranjo[7]=='1') ? 'checked="checked"' : '') . ' />&nbsp;1</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_8" id="alghoritma_naranjo_8" value="2" ' . ((isset($arr_alghoritma_naranjo[7]) and $arr_alghoritma_naranjo[7]=='2') ? 'checked="checked"' : '') . ' />&nbsp;0</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_8" id="alghoritma_naranjo_8" value="3" ' . ((isset($arr_alghoritma_naranjo[7]) and $arr_alghoritma_naranjo[7]=='3') ? 'checked="checked"' : '') . ' />&nbsp;0</td>
				</tr>
				<tr>
					<td align="center">9</td>
					<td>Apakah pasien pernah mengalami efek samping obat yang sama atau obat yang mirip sebelumnya ?</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_9" id="alghoritma_naranjo_9" value="1" ' . ((isset($arr_alghoritma_naranjo[8]) and $arr_alghoritma_naranjo[8]=='1') ? 'checked="checked"' : '') . ' />&nbsp;1</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_9" id="alghoritma_naranjo_9" value="2" ' . ((isset($arr_alghoritma_naranjo[8]) and $arr_alghoritma_naranjo[8]=='2') ? 'checked="checked"' : '') . ' />&nbsp;0</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_9" id="alghoritma_naranjo_9" value="3" ' . ((isset($arr_alghoritma_naranjo[8]) and $arr_alghoritma_naranjo[8]=='3') ? 'checked="checked"' : '') . ' />&nbsp;0</td>
				</tr>
				<tr>
					<td align="center">10</td>
					<td>Apakah efek samping obat bisa dikonfirmasikan dengan bukti yang objektif ?</td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_10" id="alghoritma_naranjo_10" value="1" ' . ((isset($arr_alghoritma_naranjo[9]) and $arr_alghoritma_naranjo[9]=='1') ? 'checked="checked"' : '') . ' /></td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_10" id="alghoritma_naranjo_10" value="2" ' . ((isset($arr_alghoritma_naranjo[9]) and $arr_alghoritma_naranjo[9]=='2') ? 'checked="checked"' : '') . ' /></td>
					<td align="center"><input type="checkbox" name="alghoritma_naranjo_10" id="alghoritma_naranjo_10" value="3" ' . ((isset($arr_alghoritma_naranjo[9]) and $arr_alghoritma_naranjo[9]=='3') ? 'checked="checked"' : '') . ' /></td>
				</tr>';

				$total_skor = 0;
				if(isset($arr_alghoritma_naranjo[0]) and $arr_alghoritma_naranjo[0]=='1') $total_skor = $total_skor + 1;

				if(isset($arr_alghoritma_naranjo[1]) and $arr_alghoritma_naranjo[1]=='1') $total_skor = $total_skor + 2;
				if(isset($arr_alghoritma_naranjo[1]) and $arr_alghoritma_naranjo[1]=='2') $total_skor = $total_skor - 1;

				if(isset($arr_alghoritma_naranjo[2]) and $arr_alghoritma_naranjo[2]=='1') $total_skor = $total_skor + 1;

				if(isset($arr_alghoritma_naranjo[3]) and $arr_alghoritma_naranjo[3]=='1') $total_skor = $total_skor + 2;
				if(isset($arr_alghoritma_naranjo[3]) and $arr_alghoritma_naranjo[3]=='2') $total_skor = $total_skor - 1;

				if(isset($arr_alghoritma_naranjo[4]) and $arr_alghoritma_naranjo[4]=='1') $total_skor = $total_skor - 1;
				if(isset($arr_alghoritma_naranjo[4]) and $arr_alghoritma_naranjo[4]=='2') $total_skor = $total_skor + 2;

				if(isset($arr_alghoritma_naranjo[5]) and $arr_alghoritma_naranjo[5]=='1') $total_skor = $total_skor - 1;
				if(isset($arr_alghoritma_naranjo[5]) and $arr_alghoritma_naranjo[5]=='2') $total_skor = $total_skor + 1;

				if(isset($arr_alghoritma_naranjo[6]) and $arr_alghoritma_naranjo[6]=='1') $total_skor = $total_skor + 1;
				if(isset($arr_alghoritma_naranjo[7]) and $arr_alghoritma_naranjo[7]=='1') $total_skor = $total_skor + 1;
				if(isset($arr_alghoritma_naranjo[8]) and $arr_alghoritma_naranjo[8]=='1') $total_skor = $total_skor + 1;
	
			$edoc_content_2 = $edoc_content_2 . '<tr>
					<td align="center" colspan="2">Total Skor</td>
					<td align="center" colspan="3">' . $total_skor . '</td>
				</tr>
				</table>
				</td>
			</tr>
			</table>';
			
			ob_start();
			include('edoc_rekammedik/edoc_frame_add.php');
			$html = ob_get_contents();
			ob_end_clean();
			if($st_ls == true){
				$mpdf->AddPage('L');	
			}else{
				if($st_print == true) $mpdf->AddPage('P');
			}
				
			$mpdf->WriteHTML($html);
			
    $st_print = true;
}	
//End Formulir Pelaporan Efek Samping Obat

//Grafik Tensi Nafas Suhu Nadi
$edoc_nama_documen = strtoupper('Grafik Pernafasan, Suhu, Nadi');

$qry_grafik_pernafasan = 'SELECT TENSI_ID,TANGGAL,NADI_SUHU,PERNAFASAN,
				TEKANAN_DARAH,BERAT_TINGGI_BADAN,USER_ASKEP
				FROM t_irna_askep_tensi_nafas_nadi_suhu
				WHERE TENSI_ID = "' . $idx . '"';
$get_grafik_pernafasan = mysql_query($qry_grafik_pernafasan) or die(mysql_error());
if(mysql_num_rows($get_grafik_pernafasan) > 0){
	$dat_grafik_pernafasan = mysql_fetch_assoc($get_grafik_pernafasan);
	$tensi_id = $dat_grafik_pernafasan['TENSI_ID'];
	$tanggal = explode('|',$dat_grafik_pernafasan['TANGGAL']);
	$nadi_suhu = explode('|',$dat_grafik_pernafasan['NADI_SUHU']);
	$pernafasan = explode('|',$dat_grafik_pernafasan['PERNAFASAN']);
	$tekanan_darah = explode('|',$dat_grafik_pernafasan['TEKANAN_DARAH']);
	$berat_tinggi_badan = explode('|',$dat_grafik_pernafasan['BERAT_TINGGI_BADAN']);

	$edoc_content = '<style>.tbl tr td {
				   border: 1px solid black;
				   padding-left:1px;
				   border-collapse: collapse;
			}</style>
			<table width="100%" cellpadding="0" cellspacing="0" border="0" autosize="1" class="tbl" >
				<tr>
					<td colspan="30" align="center" bgcolor="#CCCCCC" ><strong>GRAFIK</strong></td>
			  </tr>
			  <tr>
				<td colspan="2">TANGGAL</td>
				<td colspan="4" align="center">1-' . ((isset($tanggal[0])) ? $tanggal[0] : $adline) . '</td>
				<td colspan="4" align="center">2-' . ((isset($tanggal[1])) ? $tanggal[1] : $adline) . '</td>
				<td colspan="4" align="center">3-' . ((isset($tanggal[2])) ? $tanggal[2] : $adline) . '</td>
				<td colspan="4" align="center">4-' . ((isset($tanggal[3])) ? $tanggal[3] : $adline) . '</td>
				<td colspan="4" align="center">5-' . ((isset($tanggal[4])) ? $tanggal[4] : $adline) . '</td>
				<td colspan="4" align="center">6-' . ((isset($tanggal[5])) ? $tanggal[5] : $adline) . '</td>
				<td colspan="4" align="center">7-' . ((isset($tanggal[6])) ? $tanggal[6] : $adline) . '</td>
			  </tr>
			  <tr>
				<td align="center">Nadi</td>
				<td align="center">Suhu</td>
				<td align="center">6</td>
				<td align="center">12</td>
				<td align="center">18</td>
				<td align="center">24</td>
				<td align="center">6</td>
				<td align="center">12</td>
				<td align="center">18</td>
				<td align="center">24</td>
				<td align="center">6</td>
				<td align="center">12</td>
				<td align="center">18</td>
				<td align="center">24</td>
				<td align="center">6</td>
				<td align="center">12</td>
				<td align="center">18</td>
				<td align="center">24</td>
				<td align="center">6</td>
				<td align="center">12</td>
				<td align="center">18</td>
				<td align="center">24</td>
				<td align="center">6</td>
				<td align="center">12</td>
				<td align="center">18</td>
				<td align="center">24</td>
				<td align="center">6</td>
				<td align="center">12</td>
				<td align="center">18</td>
				<td align="center">24</td>
			  </tr>
			  <tr>
				<td rowspan="2" valign="top" align="center">180</td>
				<td rowspan="2" valign="top" align="center">42</td>';
				$x = 0; 
				while($x<28){ 
					$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
				$x++; 
				} 
			  
			 $edoc_content = $edoc_content . '</tr>
							<tr>';
				$x = 28; 
				while($x<56){ 
					$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
				$x++; 
				} 
			
			$edoc_content = $edoc_content . '</tr>
			  <tr>
				<td rowspan="3" valign="bottom" align="center">160</td>
				<td rowspan="3" valign="bottom" align="center">41</td>';
				$x = 56; 
				while($x<84){
					$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
				$x++; 
				} 
			$edoc_content = $edoc_content . '</tr>
				<tr>';
				$x = 84; 
				while($x<112){ 
					$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
				$x++; 
				} 
			$edoc_content = $edoc_content . '</tr>
				<tr>';
				$x = 112; 
				while($x<140){ 
					$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
				$x++; 
				} 
			$edoc_content = $edoc_content . '</tr>
			  <tr>
				<td rowspan="5" valign="bottom" align="center">140</td>
				<td rowspan="5" valign="bottom" align="center">40</td>';
			$x = 140; 
			while($x<168){ 
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			} 
			$edoc_content = $edoc_content . '</tr>
				<tr>';
			$x = 168; 
			while($x<196){ 
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			} 
			$edoc_content = $edoc_content . '</tr>
				<tr>';
			$x = 196; 
			while($x<224){ 
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			} 
			$edoc_content = $edoc_content . '</tr>
				<tr>';
			$x = 224; 
			while($x<252){ 
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			} 
			$edoc_content = $edoc_content . '</tr>
				<tr>';
			$x = 252; 
			while($x<280){ 
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			} 
			$edoc_content = $edoc_content . '</tr>
				  <tr>
					<td rowspan="5" valign="bottom" align="center">120</td>
					<td rowspan="5" valign="bottom" align="center">39</td>';
			$x = 280; 
			while($x<308){ 
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			} 
			$edoc_content = $edoc_content . '</tr>
				<tr>';
			$x = 308; 
			while($x<336){ 
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			} 
			$edoc_content = $edoc_content . '</tr>
					<tr>';
			$x = 336; 
			while($x<364){ 
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			} 
			$edoc_content = $edoc_content . '</tr>
					<tr>';
			$x = 364;
			while($x<392){ 
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			} 
			$edoc_content = $edoc_content . '</tr>
					<tr>';
			$x = 392; 
			while($x<420){ 
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			} 
			$edoc_content = $edoc_content . '</tr>
					<tr>
					<td rowspan="5" valign="bottom" align="center">100</td>
					<td rowspan="5" valign="bottom" align="center">38</td>';
			$x = 420; 
			while($x<448){ 
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			} 
			$edoc_content = $edoc_content . '</tr>
					<tr>';
			$x = 448; 
			while($x<476){ 
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			}
			$edoc_content = $edoc_content . '</tr>
					<tr>';
			$x = 476; 
			while($x<504){ 
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			}
			$edoc_content = $edoc_content . '</tr>
					<tr>';
			$x = 504; 
			while($x<532){ 
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			} 
			$edoc_content = $edoc_content . '</tr>
					<tr>';
			$x = 532; 
			while($x<560){
					$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			} 
			$edoc_content = $edoc_content . '</tr>
					<tr>
					<td rowspan="5" valign="bottom" align="center">80</td>
					<td rowspan="5" valign="bottom" align="center">37</td>';
			$x = 560; 
			while($x<588){ 
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			}
			$edoc_content = $edoc_content . '</tr>
					<tr>';
			$x = 588; 
			while($x<616){
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			}
			$edoc_content = $edoc_content . '</tr>
					<tr>';
			$x = 616; 
			while($x<644){
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			}
			$edoc_content = $edoc_content . '</tr>
					<tr>';
			$x = 644; 
			while($x<672){ 
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			} 
			$edoc_content = $edoc_content . '</tr>
					<tr>';
			$x = 672; 
			while($x<700){ 
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			} 
				$edoc_content = $edoc_content . '</tr>
					  <tr>
						<td rowspan="5" valign="bottom" align="center">60</td>
						<td rowspan="5" valign="bottom" align="center">36</td>';
			$x = 700; 
			while($x<728){
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			} 
			$edoc_content = $edoc_content . '</tr>
					<tr>';
			$x = 728; 
			while($x<756){
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			}
			$edoc_content = $edoc_content . '</tr>
					<tr>';
			$x = 756; 
			while($x<784){ 
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			}
			$edoc_content = $edoc_content . '</tr>
					<tr>';
			$x = 784;
			while($x<812){
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			} 
			$edoc_content = $edoc_content . '</tr>
					<tr>';
			$x = 812; 
			while($x<840){
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			}
			$edoc_content = $edoc_content . '</tr>
			  <tr>
				<td rowspan="5" valign="bottom" align="center">40</td>
				<td rowspan="5" valign="bottom" align="center">35</td>';
			$x = 840; 
			while($x<868){
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			}
			$edoc_content = $edoc_content . '</tr>
				<tr>';
			$x = 868; 
			while($x<896){
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			}
			$edoc_content = $edoc_content . '</tr>
				<tr>';
			$x = 896; 
			while($x<924){
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			}
			$edoc_content = $edoc_content . '</tr>
					<tr>';
			$x = 924; 
			while($x<952){
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			}
			$edoc_content = $edoc_content . '</tr>
				<tr>';
			$x = 952; 
			while($x<980){
				$edoc_content = $edoc_content . '<td align="center"><input type="checkbox" name="nadi_suhu" value="1" ' . ((isset($nadi_suhu[$x]) and $nadi_suhu[$x] == '1') ? 'checked="checked"' : '') . ' /></td>';
			$x++; 
			}
			$edoc_content = $edoc_content . '</tr>
				<tr>
					<td colspan="2">Pernafasan</td>';
			$x = 0; 
			while($x<28){
				$edoc_content = $edoc_content . '<td align="center">' . ((isset($pernafasan[$x])) ? $pernafasan[$x] : '') . '</td>';
			$x++; 
			}
			$edoc_content = $edoc_content . '</tr>
				<tr>
					<td colspan="2">Tekanan Darah </td>';
			$x = 0; 
			while($x<14){
				$edoc_content = $edoc_content . '<td colspan="2" align="center">' . ((isset($tekanan_darah[$x])) ? $tekanan_darah[$x] : '') . '</td>';
			$x++; 
			}
			$edoc_content = $edoc_content . '</tr>
				<tr>
					<td colspan="2">BB &amp; TB </td>';
			$x = 0; 
			while($x<7){
				$edoc_content = $edoc_content . '<td colspan="4" align="center">' . ((isset($berat_tinggi_badan[$x])) ? $berat_tinggi_badan[$x] : '') . '</td>';
			$x++; 
			}
			$edoc_content = $edoc_content . '</tr>
					</table>';
		
			ob_start();
			include('edoc_rekammedik/edoc_frame_main.php');
			$html = ob_get_contents();
			ob_end_clean();
			if($st_ls == true){
				$mpdf->AddPage('L');	
			}else{
				if($st_print == true) $mpdf->AddPage('P');
			}
				
			$mpdf->WriteHTML($html);
    $st_print = true;
}	
//End Grafik Tensi Nafas Suhu Nadi

//Catatan Keluar Masuk
$qry_catatan_keluarmasuk = 'SELECT DISTINCT t_irna_askep_catatan_keluar_masuk.IRNA_ID,
					DATE_FORMAT(t_irna_askep_catatan_keluar_masuk.TANGGAL,"%d/%m/%Y") AS TANGGAL,
					DATE_FORMAT(t_irna_askep_catatan_keluar_masuk.TANGGAL,"%H:%i:%s") AS JAM,
					t_irna_askep_catatan_keluar_masuk.JENIS_KELUAR_MASUK,t_irna_askep_catatan_keluar_masuk.CATATAN
					FROM t_irna_askep_catatan_keluar_masuk
					WHERE t_irna_askep_catatan_keluar_masuk.IRNA_ID = "' . $idx . '"
					ORDER BY t_irna_askep_catatan_keluar_masuk.TANGGAL';
$get_catatan_keluarmasuk = mysql_query($qry_catatan_keluarmasuk) or die(mysql_error());
if(mysql_num_rows($get_catatan_keluarmasuk) > 0){
	$edoc_first = '<style>.tbl tr td {
				   border: 1px solid black;
				   padding-left:1px;
				   border-collapse: collapse;
			}</style>
	<table width="100%" class="tbl" cellpadding="0" cellspacing="0" autosize="1" >
		<tr>
			<td width="40" align="center" bgcolor="#CCCCCC" ><strong>No</strong></td>
			<td width="70" align="center" bgcolor="#CCCCCC" ><strong>Tanggal</strong></td>
			<td width="50" align="center" bgcolor="#CCCCCC" ><strong>Pukul</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Jenis Keluar Masuk</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Catatan</strong></td>
		</tr>';
	
	$edoc_end = '</table>';
	
	$edoc_main = '';
	
	$x = 1;
	$y = 1;
	$fp = false;
	$tanggal ='';
	while($dat_catatan_keluarmasuk = mysql_fetch_array($get_catatan_keluarmasuk)){
		$tgl = '';
		if($dat_catatan_keluarmasuk['TANGGAL'] != $tanggal){
			$tanggal = $dat_catatan_keluarmasuk['TANGGAL'];
			$tgl = $dat_catatan_keluarmasuk['TANGGAL'];
		}
		$edoc_main = $edoc_main . '<tr>
					<td align="center">' . $x . '</td>
					<td>' . $tgl . '</td>
					<td>' . $dat_catatan_keluarmasuk['JAM'] . '</td>
					<td>' . $dat_catatan_keluarmasuk['JENIS_KELUAR_MASUK'] . '</td>
					<td>' . $dat_catatan_keluarmasuk['CATATAN'] . '</td>
				</tr>';
				
			if($y == 10){
					$edoc_content_2 = $edoc_first . $edoc_main . $edoc_end;
					ob_start();
					include('edoc_rekammedik/edoc_frame_add.php');
					$html = ob_get_contents();
					ob_end_clean();
					if($st_ls == true){
						$mpdf->AddPage('L');	
					}else{
						if($st_print == true) $mpdf->AddPage('P');
					}
					$mpdf->WriteHTML($html);
					$y = 0;
			$edoc_main = '';
			}	
	$x++;
	$y++;
	}
	
	if($edoc_main != ''){
		$edoc_content_2  = $edoc_first . $edoc_main . $edoc_end;
		ob_start();
		include('edoc_rekammedik/edoc_frame_add.php');
		$html = ob_get_contents();
		ob_end_clean();
		if($st_ls == true){
			$mpdf->AddPage('L');	
		}else{
			if($st_print == true) $mpdf->AddPage('P');
		}
		$mpdf->WriteHTML($html);	
	}	
	
	$st_print = true;
}	
//End Catatan Keluar Masuk

//Formulir Surveilans Pencegahan Dan Pengendalian Infeksi
$edoc_nama_documen = strtoupper('Formulir Surveilans Pencegahan Dan Pengendalian Infeksi');

$qry_surveilans = 'SELECT PENGENDALIAN_INFEKSI_ID,NO_FOR_SUR,CARA_DIRAWAT,SEBAB_KELUAR,DIAGNOSA_AKHIR,
				FAKTOR_RESIKO_OPERASI,AHLI_BEDAH,SCRUBE_NURSE,
				JENIS_OPERASI,TIPE_OPERASI,JENIS_LUKA,LAMA_OPERASI,ASA_SCORE,RISK_SCORE,
				DATE_FORMAT(TGL_KELUAR,"%d/%m/%Y") AS TGL_KELUAR,
				DATE_FORMAT(TGL_PASANG_CATETER_PERIFER,"%d/%m/%Y") AS TGL_PASANG_CATETER_PERIFER,
				DATE_FORMAT(TGL_PASANG_CATETER_SENTRAL,"%d/%m/%Y") AS TGL_PASANG_CATETER_SENTRAL,
				DATE_FORMAT(TGL_PASANG_CATETER_URINE,"%d/%m/%Y") AS TGL_PASANG_CATETER_URINE,
				DATE_FORMAT(TGL_PASANG_VENTILASI_MEKANIK,"%d/%m/%Y") AS TGL_PASANG_VENTILASI_MEKANIK,
				DATE_FORMAT(SD_PASANG_CATETER_PERIFER,"%d/%m/%Y") AS SD_PASANG_CATETER_PERIFER,
				DATE_FORMAT(SD_PASANG_CATETER_SENTRAL,"%d/%m/%Y") AS SD_PASANG_CATETER_SENTRAL,
				DATE_FORMAT(SD_PASANG_CATETER_URINE,"%d/%m/%Y") AS SD_PASANG_CATETER_URINE,
				DATE_FORMAT(SD_PASANG_VENTILASI_MEKANIK,"%d/%m/%Y") AS SD_PASANG_VENTILASI_MEKANIK,
				BB_LAHIR,BB_SEKARANG,KONDISI_GIZI,PEMAKAIAN_ANTIBIOTIKA,NAMA_JENIS_OBAT,
				PEMERIKSAAN_KULTUR,TEMP,HASIL_KULTUR,INFEKSI_NOSOKIMIAL,BAKTEREMIA,VAP,
				SALURAN_KEMIH,LUKA_OPERASI,DEKUBITUS,PLEBITIS,INFEKSI_LAIN,USER_ASKEP,FAKTOR_RESIKO
				FROM t_irna_askep_pengendalian_infeksi
				WHERE PENGENDALIAN_INFEKSI_ID = "' . $idx . '"';
$get_surveilans = mysql_query($qry_surveilans) or die(mysql_error());
if(mysql_num_rows($get_surveilans) > 0){
	$dat_surveilans = mysql_fetch_assoc($get_surveilans);
	$pengendalian_infeksi_id = $dat_surveilans['PENGENDALIAN_INFEKSI_ID'];
	$no_for_sur = $dat_surveilans['NO_FOR_SUR'];
	$tgl_keluar = $dat_surveilans['TGL_KELUAR'];
	$cara_dirawat = $dat_surveilans['CARA_DIRAWAT'];
	$sebab_keluar = $dat_surveilans['SEBAB_KELUAR'];
	$diagnosa_akhir = $dat_surveilans['DIAGNOSA_AKHIR'];
	$faktor_resiko_operasi = $dat_surveilans['FAKTOR_RESIKO_OPERASI'];
	$ahli_bedah = $dat_surveilans['AHLI_BEDAH'];
	$scrube_nurse = $dat_surveilans['SCRUBE_NURSE'];
	$jenis_operasi = $dat_surveilans['JENIS_OPERASI'];
	$tipe_operasi = $dat_surveilans['TIPE_OPERASI'];
	$jenis_luka = $dat_surveilans['JENIS_LUKA'];
	$lama_operasi = $dat_surveilans['LAMA_OPERASI'];
	$asa_score = $dat_surveilans['ASA_SCORE'];
	$risk_score = $dat_surveilans['RISK_SCORE'];
	$tgl_pasang_cateter_perifer = $dat_surveilans['TGL_PASANG_CATETER_PERIFER'];
	$tgl_pasang_cateter_sentral = $dat_surveilans['TGL_PASANG_CATETER_SENTRAL'];
	$tgl_pasang_cateter_urine = $dat_surveilans['TGL_PASANG_CATETER_URINE'];
	$tgl_pasang_ventilasi_mekanik = $dat_surveilans['TGL_PASANG_VENTILASI_MEKANIK'];
	$sd_pasang_cateter_perifer = $dat_surveilans['SD_PASANG_CATETER_PERIFER'];
	$sd_pasang_cateter_sentral = $dat_surveilans['SD_PASANG_CATETER_SENTRAL'];
	$sd_pasang_cateter_urine = $dat_surveilans['SD_PASANG_CATETER_URINE'];
	$sd_pasang_ventilasi_mekanik = $dat_surveilans['SD_PASANG_VENTILASI_MEKANIK'];
	$bb_lahir = $dat_surveilans['BB_LAHIR'];
	$bb_sekarang = $dat_surveilans['BB_SEKARANG'];
	$kondisi_gizi = $dat_surveilans['KONDISI_GIZI'];
	$pemakaian_antibiotika = $dat_surveilans['PEMAKAIAN_ANTIBIOTIKA'];
	$nama_jenis_obat = $dat_surveilans['NAMA_JENIS_OBAT'];
	$pemeriksaan_kultur = $dat_surveilans['PEMERIKSAAN_KULTUR'];
	$temp = $dat_surveilans['TEMP'];
	$hasil_kultur = $dat_surveilans['HASIL_KULTUR'];
	$infeksi_nosokimial = $dat_surveilans['INFEKSI_NOSOKIMIAL'];
	$bakteremia = $dat_surveilans['BAKTEREMIA'];
	$vap = $dat_surveilans['VAP'];
	$saluran_kemih = $dat_surveilans['SALURAN_KEMIH'];
	$luka_operasi = $dat_surveilans['LUKA_OPERASI'];
	$dekubitus = $dat_surveilans['DEKUBITUS'];
	$plebitis = $dat_surveilans['PLEBITIS'];
	$infeksi_lain = $dat_surveilans['INFEKSI_LAIN'];
	$faktor_resiko = $dat_surveilans['FAKTOR_RESIKO'];

	$arr_jenis_operasi = explode('|',$jenis_operasi);
	$arr_pemakaian_antibiotika = explode('|',$pemakaian_antibiotika);
	$arr_pemeriksaan_kultur = explode('|',$pemeriksaan_kultur);

	$edoc_content = '<table border="0" width="100%" autosize="1" style="font-size:14px;">
			<tr>
				<td colspan="2">Data Pasien</td>
			</tr>
			<tr>
				<td width="200px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No. For. Sur</td>
				<td>:&nbsp;' . setGarisIfNull($no_for_sur) . '</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cara Dirawat</td>
				<td>:&nbsp;
					<input type="checkbox" name="cara_dirawat" id="cara_dirawat" value="1" ' . (($cara_dirawat=='1') ? 'checked="checked"' : '') . ' />&nbsp;Emergency
					<input type="checkbox" name="cara_dirawat" id="cara_dirawat" value="2" ' . (($cara_dirawat=='2') ? 'checked="checked"' : '') . ' />&nbsp;Elektif
				</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="3">Tempat Dirawat</td>
			</tr>
			<tr>
				<td colspan="2">
				<table width="100%" border="0">';
			
	$sql_dirawat = 'SELECT INFEKSI_RAWAT_ID,PENGENDALIAN_INFEKSI_ID,RUANG_RAWAT,
					DATE_FORMAT(TANGGAL_DIRAWAT,"%d/%m/%Y") AS TANGGAL_DIRAWAT,
					DATE_FORMAT(SD_DIRAWAT,"%d/%m/%Y") AS SD_DIRAWAT,NAMA_RUANG
					FROM t_irna_askep_pengendalian_infeksi_rawat
					LEFT JOIN m_ruang 
					ON (t_irna_askep_pengendalian_infeksi_rawat.RUANG_RAWAT = m_ruang.RUANG_ID)
					WHERE PENGENDALIAN_INFEKSI_ID = "' . $idx . '"';
	$get_dirawat = mysql_query($sql_dirawat) or die(mysql_error());
	while($dat_dirawat = mysql_fetch_array($get_dirawat)){	
		$edoc_content = $edoc_content . '<tr>
				<td width="200px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ruang</td>
				<td width="150px">:&nbsp;' . setGarisIfNull($dat_dirawat['NAMA_RUANG']) . '</td>
				<td width="150px">Tanggal ' . setGarisIfNull($dat_dirawat['TANGGAL_DIRAWAT']) . '</td>
				<td>Sd ' . setGarisIfNull($dat_dirawat['SD_DIRAWAT']) . '</td>
				</tr>';	
	}
	
	$edoc_content = $edoc_content . '</table>
			</td>	
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr>
				<td>Tanggal Keluar</td>
				<td>:&nbsp;' . setGarisIfNull($tgl_keluar) . '</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sebab Keluar</td>
				<td>:&nbsp;' . setGarisIfNull($sebab_keluar) . '</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Diagnosa Akhir</td>
				<td>:&nbsp;' . setGarisIfNull($diagnosa_akhir) . '</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr>
				<td>Faktor Resiko</td>
				<td>:&nbsp;' . setGarisIfNull($faktor_resiko) . '</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Operasi</td>
				<td>:&nbsp;' . setGarisIfNull($faktor_resiko_operasi) . '
				&nbsp;&nbsp;&nbsp;Ahli Bedah ' . setGarisIfNull($arr_perawat[$ahli_bedah]) . '
				&nbsp;&nbsp;&nbsp;Scrub Nurse ' . setGarisIfNull($arr_perawat[$scrube_nurse]) . '</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jenis Operasi</td>
				<td>:&nbsp;
				<input type="checkbox" name="jenis_operasi_1" id="jenis_operasi_1" value="1" ' . ((isset($arr_jenis_operasi[0]) and $arr_jenis_operasi[0]=='1') ? 'checked="checked"' : '') . ' />&nbsp;Apendik
				<input type="checkbox" name="jenis_operasi_2" id="jenis_operasi_2" value="1" ' . ((isset($arr_jenis_operasi[1]) and $arr_jenis_operasi[1]=='1') ? 'checked="checked"' : '') . ' />&nbsp;CABG
				<input type="checkbox" name="jenis_operasi_3" id="jenis_operasi_3" value="1" ' . ((isset($arr_jenis_operasi[2]) and $arr_jenis_operasi[2]=='1') ? 'checked="checked"' : '') . ' />&nbsp;Hernia
				<input type="checkbox" name="jenis_operasi_4" id="jenis_operasi_4" value="1" ' . ((isset($arr_jenis_operasi[3]) and $arr_jenis_operasi[3]=='1') ? 'checked="checked"' : '') . ' />&nbsp;Dll
				' . ((isset($arr_jenis_operasi[4])) ? setGarisIfNull($arr_jenis_operasi[4]) : $adline) . '</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tipe Operasi</td>
				<td>:&nbsp;
				<input type="checkbox" name="tipe_operasi" id="tipe_operasi" value="1" ' . (($tipe_operasi=='1') ? 'checked="checked"' : '') . ' />&nbsp;Terbuka
				<input type="checkbox" name="tipe_operasi" id="tipe_operasi" value="2" ' . (($tipe_operasi=='2') ? 'checked="checked"' : '') . ' />&nbsp;Tertutup
				</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jenis Luka</td>
				<td>:&nbsp;
				<input type="checkbox" name="jenis_luka" id="jenis_luka" value="1" ' . (($jenis_luka=='1') ? 'checked="checked"' : '') . ' />&nbsp;Bersih 
				<input type="checkbox" name="jenis_luka" id="jenis_luka" value="2" ' . (($jenis_luka=='2') ? 'checked="checked"' : '') . ' />&nbsp;Bersih Kontaminasi
				<input type="checkbox" name="jenis_luka" id="jenis_luka" value="3" ' . (($jenis_luka=='3') ? 'checked="checked"' : '') . ' />&nbsp;Kontaminasi
				<input type="checkbox" name="jenis_luka" id="jenis_luka" value="4" ' . (($jenis_luka=='4') ? 'checked="checked"' : '') . ' />&nbsp;Kotor
				</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lama Operasi</td>
				<td>:&nbsp;
				<input type="checkbox" name="lama_operasi" id="lama_operasi" value="1" ' . (($lama_operasi=='1') ? 'checked="checked"' : '') . ' />&nbsp;1 jam
				<input type="checkbox" name="lama_operasi" id="lama_operasi" value="2" ' . (($lama_operasi=='2') ? 'checked="checked"' : '') . ' />&nbsp;2 jam
				<input type="checkbox" name="lama_operasi" id="lama_operasi" value="3" ' . (($lama_operasi=='3') ? 'checked="checked"' : '') . ' />&nbsp;5 jam
				</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ASA Score</td><td>:&nbsp;' . setGarisIfNull($asa_score) . '</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Risk Score</td><td>:&nbsp;' . setGarisIfNull($risk_score) . '</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="3">Pemasangan Alat</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Intra vena cateter perifer</td>
				<td>:&nbsp;Tanggal ' . setGarisIfNull($tgl_pasang_cateter_perifer) . '
				S.d ' . setGarisIfNull($sd_pasang_cateter_perifer) . '</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Intra vena cateter sentral</td>
				<td>:&nbsp;Tanggal ' . setGarisIfNull($tgl_pasang_cateter_sentral) . '
				S.d ' . setGarisIfNull($sd_pasang_cateter_perifer) . '</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kateter urine</td>
				<td>:&nbsp;Tanggal ' . setGarisIfNull($tgl_pasang_cateter_urine) . '
				S.d ' . setGarisIfNull($sd_pasang_cateter_urine) . '</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ventilasi mekanik</td>
				<td>:&nbsp;Tanggal ' . setGarisIfNull($tgl_pasang_ventilasi_mekanik) . '
				S.d ' . setGarisIfNull($sd_pasang_ventilasi_mekanik) . '</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BB Lahir</td>
				<td>:&nbsp;' . setGarisIfNull($bb_lahir) . '</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BB Sekarang</td>
				<td>:&nbsp;' . setGarisIfNull($bb_sekarang) . '</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kondisi Gizi</td>
				<td>:&nbsp;' . setGarisIfNull($kondisi_gizi) . '</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr>
				<td>Pemakaian Antibiotika</td>
				<td>:&nbsp;
				<input type="checkbox" name="pemakaian_antibiotika_1" id="pemakaian_antibiotika_1" value="1" ' . ((isset($arr_pemakaian_antibiotika[0]) and $arr_pemakaian_antibiotika[0]=='1') ? 'checked="checked"' : '') . ' />&nbsp;Ada
				<input type="checkbox" name="pemakaian_antibiotika_1" id="pemakaian_antibiotika_1" value="2" ' . ((isset($arr_pemakaian_antibiotika[0]) and $arr_pemakaian_antibiotika[0]=='2') ? 'checked="checked"' : '') . ' />&nbsp;Tidak ada
				&nbsp;&nbsp;&nbsp;
				<input type="checkbox" name="pemakaian_antibiotika_2" id="pemakaian_antibiotika_2" value="1" ' . ((isset($arr_pemakaian_antibiotika[1]) and $arr_pemakaian_antibiotika[1]=='1') ? 'checked="checked"' : '') . ' />&nbsp;Profilaksis
				<input type="checkbox" name="pemakaian_antibiotika_2" id="pemakaian_antibiotika_2" value="2" ' . ((isset($arr_pemakaian_antibiotika[1]) and $arr_pemakaian_antibiotika[1]=='2') ? 'checked="checked"' : '') . ' />&nbsp;Pengobatan
				</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama/ jenis obat</td>
				<td>:&nbsp;' . setGarisIfNull($nama_jenis_obat) . '</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pemeriksaan kultur</td>
				<td>:&nbsp;
				<input type="checkbox" name="pemeriksaan_kultur_1" id="pemeriksaan_kultur_1" value="1" ' . ((isset($arr_pemeriksaan_kultur[0]) and $arr_pemeriksaan_kultur[0]=='1') ? 'checked="checked"' : '') . ' />&nbsp;Darah
				<input type="checkbox" name="pemeriksaan_kultur_2" id="pemeriksaan_kultur_2" value="1" ' . ((isset($arr_pemeriksaan_kultur[1]) and $arr_pemeriksaan_kultur[1]=='1') ? 'checked="checked"' : '') . ' />&nbsp;Urine
				<input type="checkbox" name="pemeriksaan_kultur_3" id="pemeriksaan_kultur_3" value="1" ' . ((isset($arr_pemeriksaan_kultur[2]) and $arr_pemeriksaan_kultur[2]=='1') ? 'checked="checked"' : '') . ' />&nbsp;Sputum
				<input type="checkbox" name="pemeriksaan_kultur_4" id="pemeriksaan_kultur_4" value="1" ' . ((isset($arr_pemeriksaan_kultur[3]) and $arr_pemeriksaan_kultur[3]=='1') ? 'checked="checked"' : '') . ' />&nbsp;Pus luka
				&nbsp;&nbsp;&nbsp;Temp ' . setGarisIfNull($temp) . '</td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasil Kultur</td><td>:&nbsp;' . setGarisIfNull($hasil_kultur) . '</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Infeksi nosokimial yang terjadi</td><td>:&nbsp;' . setGarisIfNull($infeksi_nosokimial) . '</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bakteremia/ sepsis</td><td>:&nbsp;' . setGarisIfNull($bakteremia) . '</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VAP</td><td>:&nbsp;' . setGarisIfNull($vap) . '</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Infeksi saluran kemih</td><td>:&nbsp;' . setGarisIfNull($saluran_kemih) . '</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Infeksi luka operasi</td><td>:&nbsp;' . setGarisIfNull($luka_operasi) . '</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dekubitus</td><td>:&nbsp;' . setGarisIfNull($dekubitus) . '</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Plebitis</td><td>:&nbsp;' . setGarisIfNull($plebitis) . '</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Infeksi lain HIV, HBV, HCV</td><td>:&nbsp;' . setGarisIfNull($infeksi_lain) . '</td>
			</tr>
			</table>';
			
			ob_start();
			include('edoc_rekammedik/edoc_frame_main.php');
			$html = ob_get_contents();
			ob_end_clean();
			if($st_ls == true){
				$mpdf->AddPage('L');	
			}else{
				if($st_print == true) $mpdf->AddPage('P');
			}
				
			$mpdf->WriteHTML($html);
			
    $st_print = true;
}	
//End Formulir Surveilans Pencegahan Dan Pengendalian Infeksi

//Morse Fall Scale (Skala Jatuh Morse)
$edoc_nama_documen = strtoupper('Morse Fall Scale (Skala Jatuh Morse)');

$qry_morse = 'SELECT t_irna_askep_morse_fall_scale.MORSE_FALL_SCALE_ID,
			  t_irna_askep_morse_fall_scale.RIWAYAT_JATUH,
			  t_irna_askep_morse_fall_scale.DIAGNOSIS_SEKUNDER,
			  t_irna_askep_morse_fall_scale.ALAT_BANTU,
			  t_irna_askep_morse_fall_scale.TERPASANG_INFUS,
			  t_irna_askep_morse_fall_scale.GAYA_BERJALAN,
			  t_irna_askep_morse_fall_scale.STATUS_MENTAL,
			  t_irna_askep_morse_fall_scale.PERAWAT
			FROM t_irna_askep_morse_fall_scale
			WHERE t_irna_askep_morse_fall_scale.MORSE_FALL_SCALE_ID = "' . $idx . '"';
$get_morse = mysql_query($qry_morse) or die(mysql_error());
if(mysql_num_rows($get_morse) > 0){
	$dat_morse = mysql_fetch_assoc($get_morse);
	$morse_fall_scale_id = $dat_morse['MORSE_FALL_SCALE_ID'];
	$riwayat_jatuh = explode('|',$dat_morse['RIWAYAT_JATUH']);
	$diagnosis_sekunder = explode('|',$dat_morse['DIAGNOSIS_SEKUNDER']);
	$alat_bantu = explode('|',$dat_morse['ALAT_BANTU']);
	$terpasang_infus = explode('|',$dat_morse['TERPASANG_INFUS']);
	$gaya_berjalan = explode('|',$dat_morse['GAYA_BERJALAN']);
	$status_mental = explode('|',$dat_morse['STATUS_MENTAL']);
	$perawat = explode('|',$dat_morse['PERAWAT']);

	$edoc_content = '<style>.tbl tr td {
				   border: 1px solid black;
				   padding-left:1px;
				   border-collapse: collapse;
				   font-size:14px;
			}</style>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" autosize="1" class="tbl">
			<tr>
			<td align="center" bgcolor="#CCCCCC" ><strong>Faktor Risiko</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Skala</strong></td>		
			<td width="60px" align="center" bgcolor="#CCCCCC" ><strong>Point</strong></td>
		    <td align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		</tr>		
		<tr>
			<td rowspan="2" valign="top" style="padding-top:15px; ">RIWAYAT JATUH</td>			
			<td>Ya</td>
			<td align="center">25</td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_1" value="25" ' . ((isset($riwayat_jatuh[0]) and $riwayat_jatuh[0] == '25') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_2" value="25" ' . ((isset($riwayat_jatuh[1]) and $riwayat_jatuh[1] == '25') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_3" value="25" ' . ((isset($riwayat_jatuh[2]) and $riwayat_jatuh[2] == '25') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_4" value="25" ' . ((isset($riwayat_jatuh[3]) and $riwayat_jatuh[3] == '25') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_5" value="25" ' . ((isset($riwayat_jatuh[4]) and $riwayat_jatuh[4] == '25') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_6" value="25" ' . ((isset($riwayat_jatuh[5]) and $riwayat_jatuh[5] == '25') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_7" value="25" ' . ((isset($riwayat_jatuh[6]) and $riwayat_jatuh[6] == '25') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_8" value="25" ' . ((isset($riwayat_jatuh[7]) and $riwayat_jatuh[7] == '25') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_9" value="25" ' . ((isset($riwayat_jatuh[8]) and $riwayat_jatuh[8] == '25') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_10" value="25" ' . ((isset($riwayat_jatuh[9]) and $riwayat_jatuh[9] == '25') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>			
			<td>Tidak</td>		
			<td align="center">0</td>	
		    <td align="center"><input type="radio" name="riwayat_jatuh_1" value="0" ' . ((isset($riwayat_jatuh[0]) and $riwayat_jatuh[0] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_2" value="0" ' . ((isset($riwayat_jatuh[1]) and $riwayat_jatuh[1] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_3" value="0" ' . ((isset($riwayat_jatuh[2]) and $riwayat_jatuh[2] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_4" value="0" ' . ((isset($riwayat_jatuh[3]) and $riwayat_jatuh[3] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_5" value="0" ' . ((isset($riwayat_jatuh[4]) and $riwayat_jatuh[4] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_6" value="0" ' . ((isset($riwayat_jatuh[5]) and $riwayat_jatuh[5] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_7" value="0" ' . ((isset($riwayat_jatuh[6]) and $riwayat_jatuh[6] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_8" value="0" ' . ((isset($riwayat_jatuh[7]) and $riwayat_jatuh[7] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_9" value="0" ' . ((isset($riwayat_jatuh[8]) and $riwayat_jatuh[8] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_10" value="0" ' . ((isset($riwayat_jatuh[9]) and $riwayat_jatuh[9] == '0') ? 'checked="checked"' : '') . ' /></td>
		</tr>		
		<tr>
			<td rowspan="2" valign="top" style="padding-top:15px; ">DIAGNOSIS SEKUNDER ( <u>></u> 2 DIAGNOSISIS MEDIS)</td>			
			<td>Ya</td>
			<td align="center">15</td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_1" value="15" ' . ((isset($diagnosis_sekunder[0]) and $diagnosis_sekunder[0] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_2" value="15" ' . ((isset($diagnosis_sekunder[1]) and $diagnosis_sekunder[1] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_3" value="15" ' . ((isset($diagnosis_sekunder[2]) and $diagnosis_sekunder[2] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_4" value="15" ' . ((isset($diagnosis_sekunder[3]) and $diagnosis_sekunder[3] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_5" value="15" ' . ((isset($diagnosis_sekunder[4]) and $diagnosis_sekunder[4] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_6" value="15" ' . ((isset($diagnosis_sekunder[5]) and $diagnosis_sekunder[5] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_7" value="15" ' . ((isset($diagnosis_sekunder[6]) and $diagnosis_sekunder[6] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_8" value="15" ' . ((isset($diagnosis_sekunder[7]) and $diagnosis_sekunder[7] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_9" value="15" ' . ((isset($diagnosis_sekunder[8]) and $diagnosis_sekunder[8] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_10" value="15" ' . ((isset($diagnosis_sekunder[9]) and $diagnosis_sekunder[9] == '15') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>			
			<td>Tidak</td>			
			<td align="center">0</td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_1" value="0" ' . ((isset($diagnosis_sekunder[0]) and $diagnosis_sekunder[0] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_2" value="0" ' . ((isset($diagnosis_sekunder[1]) and $diagnosis_sekunder[1] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_3" value="0" ' . ((isset($diagnosis_sekunder[2]) and $diagnosis_sekunder[2] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_4" value="0" ' . ((isset($diagnosis_sekunder[3]) and $diagnosis_sekunder[3] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_5" value="0" ' . ((isset($diagnosis_sekunder[4]) and $diagnosis_sekunder[4] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_6" value="0" ' . ((isset($diagnosis_sekunder[5]) and $diagnosis_sekunder[5] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_7" value="0" ' . ((isset($diagnosis_sekunder[6]) and $diagnosis_sekunder[6] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_8" value="0" ' . ((isset($diagnosis_sekunder[7]) and $diagnosis_sekunder[7] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_9" value="0" ' . ((isset($diagnosis_sekunder[8]) and $diagnosis_sekunder[8] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_10" value="0" ' . ((isset($diagnosis_sekunder[9]) and $diagnosis_sekunder[9] == '0') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td rowspan="3" valign="top" style="padding-top:15px; ">ALAT BANTU</td>
			<td>Berpegangan pada perabot</td>
			<td align="center">30</td>
		    <td align="center"><input type="radio" name="alat_bantu_1" value="30" ' . ((isset($alat_bantu[0]) and $alat_bantu[0] == '30') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_2" value="30" ' . ((isset($alat_bantu[1]) and $alat_bantu[1] == '30') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_3" value="30" ' . ((isset($alat_bantu[2]) and $alat_bantu[2] == '30') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_4" value="30" ' . ((isset($alat_bantu[3]) and $alat_bantu[3] == '30') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_5" value="30" ' . ((isset($alat_bantu[4]) and $alat_bantu[4] == '30') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_6" value="30" ' . ((isset($alat_bantu[5]) and $alat_bantu[5] == '30') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_7" value="30" ' . ((isset($alat_bantu[6]) and $alat_bantu[6] == '30') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_8" value="30" ' . ((isset($alat_bantu[7]) and $alat_bantu[7] == '30') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_9" value="30" ' . ((isset($alat_bantu[8]) and $alat_bantu[8] == '30') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_10" value="30" ' . ((isset($alat_bantu[9]) and $alat_bantu[9] == '30') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>			
			<td>Tongkat / alat penopang</td>			
			<td align="center">15</td>
		    <td align="center"><input type="radio" name="alat_bantu_1" value="15" ' . ((isset($alat_bantu[0]) and $alat_bantu[0] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_2" value="15" ' . ((isset($alat_bantu[1]) and $alat_bantu[1] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_3" value="15" ' . ((isset($alat_bantu[2]) and $alat_bantu[2] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_4" value="15" ' . ((isset($alat_bantu[3]) and $alat_bantu[3] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_5" value="15" ' . ((isset($alat_bantu[4]) and $alat_bantu[4] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_6" value="15" ' . ((isset($alat_bantu[5]) and $alat_bantu[5] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_7" value="15" ' . ((isset($alat_bantu[6]) and $alat_bantu[6] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_8" value="15" ' . ((isset($alat_bantu[7]) and $alat_bantu[7] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_9" value="15" ' . ((isset($alat_bantu[8]) and $alat_bantu[8] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_10" value="15" ' . ((isset($alat_bantu[9]) and $alat_bantu[9] == '15') ? 'checked="checked"' : '') . ' /></td>
		</tr>		
		<tr>			
			<td>Tidak ada / kursi roda / perawat / tirah baring</td>			
			<td align="center">0</td>
		    <td align="center"><input type="radio" name="alat_bantu_1" value="0" ' . ((isset($alat_bantu[0]) and $alat_bantu[0] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_2" value="0" ' . ((isset($alat_bantu[1]) and $alat_bantu[1] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_3" value="0" ' . ((isset($alat_bantu[2]) and $alat_bantu[2] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_4" value="0" ' . ((isset($alat_bantu[3]) and $alat_bantu[3] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_5" value="0" ' . ((isset($alat_bantu[4]) and $alat_bantu[4] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_6" value="0" ' . ((isset($alat_bantu[5]) and $alat_bantu[5] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_7" value="0" ' . ((isset($alat_bantu[6]) and $alat_bantu[6] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_8" value="0" ' . ((isset($alat_bantu[7]) and $alat_bantu[7] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_9" value="0" ' . ((isset($alat_bantu[8]) and $alat_bantu[8] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="alat_bantu_10" value="0" ' . ((isset($alat_bantu[9]) and $alat_bantu[9] == '0') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td rowspan="2" valign="top" style="padding-top:15px; ">TERPASANG INFUS</td>
			<td>Ya</td>
			<td align="center">20</td>
		    <td align="center"><input type="radio" name="terpasang_infus_1" value="20" ' . ((isset($terpasang_infus[0]) and $terpasang_infus[0] == '20') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_2" value="20" ' . ((isset($terpasang_infus[1]) and $terpasang_infus[1] == '20') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_3" value="20" ' . ((isset($terpasang_infus[2]) and $terpasang_infus[2] == '20') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_4" value="20" ' . ((isset($terpasang_infus[3]) and $terpasang_infus[3] == '20') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_5" value="20" ' . ((isset($terpasang_infus[4]) and $terpasang_infus[4] == '20') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_6" value="20" ' . ((isset($terpasang_infus[5]) and $terpasang_infus[5] == '20') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_7" value="20" ' . ((isset($terpasang_infus[6]) and $terpasang_infus[6] == '20') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_8" value="20" ' . ((isset($terpasang_infus[7]) and $terpasang_infus[7] == '20') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_9" value="20" ' . ((isset($terpasang_infus[8]) and $terpasang_infus[8] == '20') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_10" value="20" ' . ((isset($terpasang_infus[9]) and $terpasang_infus[9] == '20') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>			
			<td>Tidak</td>			
			<td align="center">0</td>
		    <td align="center"><input type="radio" name="terpasang_infus_1" value="0" ' . ((isset($terpasang_infus[0]) and $terpasang_infus[0] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_2" value="0" ' . ((isset($terpasang_infus[1]) and $terpasang_infus[1] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_3" value="0" ' . ((isset($terpasang_infus[2]) and $terpasang_infus[2] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_4" value="0" ' . ((isset($terpasang_infus[3]) and $terpasang_infus[3] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_5" value="0" ' . ((isset($terpasang_infus[4]) and $terpasang_infus[4] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_6" value="0" ' . ((isset($terpasang_infus[5]) and $terpasang_infus[5] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_7" value="0" ' . ((isset($terpasang_infus[6]) and $terpasang_infus[6] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_8" value="0" ' . ((isset($terpasang_infus[7]) and $terpasang_infus[7] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_9" value="0" ' . ((isset($terpasang_infus[8]) and $terpasang_infus[8] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_10" value="0" ' . ((isset($terpasang_infus[9]) and $terpasang_infus[9] == '0') ? 'checked="checked"' : '') . ' /></td>
		</tr>		
		<tr>
			<td rowspan="3" valign="top" style="padding-top:15px; ">GAYA BERJALAN</td>
			<td>Terganggu</td>
			<td align="center">20</td>
		    <td align="center"><input type="radio" name="gaya_berjalan_1" value="20" ' . ((isset($gaya_berjalan[0]) and $gaya_berjalan[0] == '20') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_2" value="20" ' . ((isset($gaya_berjalan[1]) and $gaya_berjalan[1] == '20') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_3" value="20" ' . ((isset($gaya_berjalan[2]) and $gaya_berjalan[2] == '20') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_4" value="20" ' . ((isset($gaya_berjalan[3]) and $gaya_berjalan[3] == '20') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_5" value="20" ' . ((isset($gaya_berjalan[4]) and $gaya_berjalan[4] == '20') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_6" value="20" ' . ((isset($gaya_berjalan[5]) and $gaya_berjalan[5] == '20') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_7" value="20" ' . ((isset($gaya_berjalan[6]) and $gaya_berjalan[6] == '20') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_8" value="20" ' . ((isset($gaya_berjalan[7]) and $gaya_berjalan[7] == '20') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_9" value="20" ' . ((isset($gaya_berjalan[8]) and $gaya_berjalan[8] == '20') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_10" value="20" ' . ((isset($gaya_berjalan[9]) and $gaya_berjalan[9] == '20') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>			
			<td>Lemah</td>			
			<td align="center">10</td>
		    <td align="center"><input type="radio" name="gaya_berjalan_1" value="10" ' . ((isset($gaya_berjalan[0]) and $gaya_berjalan[0] == '10') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_2" value="10" ' . ((isset($gaya_berjalan[1]) and $gaya_berjalan[1] == '10') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_3" value="10" ' . ((isset($gaya_berjalan[2]) and $gaya_berjalan[2] == '10') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_4" value="10" ' . ((isset($gaya_berjalan[3]) and $gaya_berjalan[3] == '10') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_5" value="10" ' . ((isset($gaya_berjalan[4]) and $gaya_berjalan[4] == '10') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_6" value="10" ' . ((isset($gaya_berjalan[5]) and $gaya_berjalan[5] == '10') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_7" value="10" ' . ((isset($gaya_berjalan[6]) and $gaya_berjalan[6] == '10') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_8" value="10" ' . ((isset($gaya_berjalan[7]) and $gaya_berjalan[7] == '10') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_9" value="10" ' . ((isset($gaya_berjalan[8]) and $gaya_berjalan[8] == '10') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_10" value="10" ' . ((isset($gaya_berjalan[9]) and $gaya_berjalan[9] == '10') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>			
			<td>Normal / Tirah baring / Immobilisasi</td>			
			<td align="center">0</td>
		    <td align="center"><input type="radio" name="gaya_berjalan_1" value="0" ' . ((isset($gaya_berjalan[0]) and $gaya_berjalan[0] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_2" value="0" ' . ((isset($gaya_berjalan[1]) and $gaya_berjalan[1] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_3" value="0" ' . ((isset($gaya_berjalan[2]) and $gaya_berjalan[2] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_4" value="0" ' . ((isset($gaya_berjalan[3]) and $gaya_berjalan[3] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_5" value="0" ' . ((isset($gaya_berjalan[4]) and $gaya_berjalan[4] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_6" value="0" ' . ((isset($gaya_berjalan[5]) and $gaya_berjalan[5] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_7" value="0" ' . ((isset($gaya_berjalan[6]) and $gaya_berjalan[6] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_8" value="0" ' . ((isset($gaya_berjalan[7]) and $gaya_berjalan[7] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_9" value="0" ' . ((isset($gaya_berjalan[8]) and $gaya_berjalan[8] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_10" value="0" ' . ((isset($gaya_berjalan[9]) and $gaya_berjalan[9] == '0') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td rowspan="2" valign="top" style="padding-top:15px; ">STATUS MENTAL</td>
			<td>Sering lupa akan keterbatasan yang dimiliki</td>
			<td align="center">15</td>
		    <td align="center"><input type="radio" name="status_mental_1" value="15" ' . ((isset($status_mental[0]) and $status_mental[0] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="status_mental_2" value="15" ' . ((isset($status_mental[1]) and $status_mental[1] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="status_mental_3" value="15" ' . ((isset($status_mental[2]) and $status_mental[2] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="status_mental_4" value="15" ' . ((isset($status_mental[3]) and $status_mental[3] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="status_mental_5" value="15" ' . ((isset($status_mental[4]) and $status_mental[4] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="status_mental_6" value="15" ' . ((isset($status_mental[5]) and $status_mental[5] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="status_mental_7" value="15" ' . ((isset($status_mental[6]) and $status_mental[6] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="status_mental_8" value="15" ' . ((isset($status_mental[7]) and $status_mental[7] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="status_mental_9" value="15" ' . ((isset($status_mental[8]) and $status_mental[8] == '15') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="status_mental_10" value="15" ' . ((isset($status_mental[9]) and $status_mental[9] == '15') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>			
			<td>Sadar akan kemampuan diri sendiri</td>			
			<td align="center">0</td>
		    <td align="center"><input type="radio" name="status_mental_1" value="0" ' . ((isset($status_mental[0]) and $status_mental[0] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="status_mental_2" value="0" ' . ((isset($status_mental[1]) and $status_mental[1] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="status_mental_3" value="0" ' . ((isset($status_mental[2]) and $status_mental[2] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="status_mental_4" value="0" ' . ((isset($status_mental[3]) and $status_mental[3] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="status_mental_5" value="0" ' . ((isset($status_mental[4]) and $status_mental[4] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="status_mental_6" value="0" ' . ((isset($status_mental[5]) and $status_mental[5] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="status_mental_7" value="0" ' . ((isset($status_mental[6]) and $status_mental[6] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="status_mental_8" value="0" ' . ((isset($status_mental[7]) and $status_mental[7] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="status_mental_9" value="0" ' . ((isset($status_mental[8]) and $status_mental[8] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="radio" name="status_mental_10" value="0" ' . ((isset($status_mental[9]) and $status_mental[9] == '0') ? 'checked="checked"' : '') . ' /></td>
		</tr>';

		$total_skor_1 = 0;
		$total_skor_2 = 0;
		$total_skor_3 = 0;
		$total_skor_4 = 0;
		$total_skor_5 = 0;
		$total_skor_6 = 0;
		$total_skor_7 = 0;
		$total_skor_8 = 0;
		$total_skor_9 = 0;
		$total_skor_10 = 0;
		if(!empty($morse_fall_scale_id)){
			$total_skor_1 = $riwayat_jatuh[0] + $diagnosis_sekunder[0] + $alat_bantu[0] + $terpasang_infus[0] + $gaya_berjalan[0] + $status_mental[0];
			$total_skor_2 = $riwayat_jatuh[1] + $diagnosis_sekunder[1] + $alat_bantu[1] + $terpasang_infus[1] + $gaya_berjalan[1] + $status_mental[1];
			$total_skor_3 = $riwayat_jatuh[2] + $diagnosis_sekunder[2] + $alat_bantu[2] + $terpasang_infus[2] + $gaya_berjalan[2] + $status_mental[2];
			$total_skor_4 = $riwayat_jatuh[3] + $diagnosis_sekunder[3] + $alat_bantu[3] + $terpasang_infus[3] + $gaya_berjalan[3] + $status_mental[3];
			$total_skor_5 = $riwayat_jatuh[4] + $diagnosis_sekunder[4] + $alat_bantu[4] + $terpasang_infus[4] + $gaya_berjalan[4] + $status_mental[4];
			$total_skor_6 = $riwayat_jatuh[5] + $diagnosis_sekunder[5] + $alat_bantu[5] + $terpasang_infus[5] + $gaya_berjalan[5] + $status_mental[5];
			$total_skor_7 = $riwayat_jatuh[6] + $diagnosis_sekunder[6] + $alat_bantu[6] + $terpasang_infus[6] + $gaya_berjalan[6] + $status_mental[6];
			$total_skor_8 = $riwayat_jatuh[7] + $diagnosis_sekunder[7] + $alat_bantu[7] + $terpasang_infus[7] + $gaya_berjalan[7] + $status_mental[7];
			$total_skor_9 = $riwayat_jatuh[8] + $diagnosis_sekunder[8] + $alat_bantu[8] + $terpasang_infus[8] + $gaya_berjalan[8] + $status_mental[8];
			$total_skor_10 = $riwayat_jatuh[9] + $diagnosis_sekunder[9] + $alat_bantu[9] + $terpasang_infus[9] + $gaya_berjalan[9] + $status_mental[9];
		}	
		$edoc_content = $edoc_content . '<tr>
			<td colspan="3" style=" font-weight:bold;">TOTAL SKOR</td>
		    <td align="center">' . $total_skor_1 . '</td>
		    <td align="center">' . $total_skor_2. '</td>
		    <td align="center">' . $total_skor_3. '</td>
		    <td align="center">' . $total_skor_4. '</td>
		    <td align="center">' . $total_skor_5. '</td>
		    <td align="center">' . $total_skor_6. '</td>
		    <td align="center">' . $total_skor_7. '</td>
		    <td align="center">' . $total_skor_8. '</td>
		    <td align="center">' . $total_skor_9. '</td>
		    <td align="center">' . $total_skor_10. '</td>
		</tr>
		<tr>
			<td colspan="3" style=" font-weight:bold;">PERAWAT</td>
		    <td align="center">' . $arr_perawat[$perawat[0]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[1]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[2]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[3]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[4]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[5]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[6]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[7]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[8]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[9]] . '</td>
		</tr>
	</table>';
			
			ob_start();
			include('edoc_rekammedik/edoc_frame_main.php');
			$html = ob_get_contents();
			ob_end_clean();
			if($st_ls == true){
				$mpdf->AddPage('P');	
			}else{
				if($st_print == true) $mpdf->AddPage('L');
			}
				
			$mpdf->WriteHTML($html);
			
    $st_print = true;
}	
//End Morse Fall Scale (Skala Jatuh Morse)

//Comfort Scale
$edoc_nama_documen = strtoupper('Comfort Scale');

$qry_comfort = 'SELECT t_irna_askep_comport_scale.COMPORT_SCALE_ID,
			  t_irna_askep_comport_scale.KEWASPADAAN,
			  t_irna_askep_comport_scale.KETENANGAN,
			  t_irna_askep_comport_scale.DISTRES_PERNAPASAN,
			  t_irna_askep_comport_scale.MENANGIS,
			  t_irna_askep_comport_scale.PERGERAKAN,
			  t_irna_askep_comport_scale.TONUS_OTOT,
			  t_irna_askep_comport_scale.TEGANGAN_WAJAH,
			  t_irna_askep_comport_scale.TEKANAN_DARAH_BASAH,
			  t_irna_askep_comport_scale.TANGGAL,
			  t_irna_askep_comport_scale.PERAWAT,
			  t_irna_askep_comport_scale.USER_ASKEP
			FROM t_irna_askep_comport_scale
			WHERE t_irna_askep_comport_scale.COMPORT_SCALE_ID = "' . $idx . '"';
$get_comfort = mysql_query($qry_comfort) or die(mysql_error());
if(mysql_num_rows($get_comfort) > 0){
	$dat_comport = mysql_fetch_assoc($get_comfort);
	$comport_scale_id = $dat_comport['COMPORT_SCALE_ID'];
	$kewaspadaan = explode('|',$dat_comport['KEWASPADAAN']);
	$ketenangan = explode('|',$dat_comport['KETENANGAN']);
	$distres_pernapasan = explode('|',$dat_comport['DISTRES_PERNAPASAN']);
	$menangis = explode('|',$dat_comport['MENANGIS']);
	$pergerakan = explode('|',$dat_comport['PERGERAKAN']);
	$tonus_otot = explode('|',$dat_comport['TONUS_OTOT']);
	$tegangan_wajah = explode('|',$dat_comport['TEGANGAN_WAJAH']);
	$tekanan_darah_basah = explode('|',$dat_comport['TEKANAN_DARAH_BASAH']);
	$tanggal = explode('|',$dat_comport['TANGGAL']);
	$perawat = explode('|',$dat_comport['PERAWAT']);

	$edoc_content = '<style>.tbl tr td {
				   border: 1px solid black;
				   padding-left:1px;
				   border-collapse: collapse;
			}</style>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" autosize="1" class="tbl">
			<tr>
			<td align="center" bgcolor="#CCCCCC" ><strong>Kategori</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Skala</strong></td>		
			<td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		</tr>		
		<tr>
			<td rowspan="5" valign="top" style="padding-top:15px; ">KEWASPADAAN</td>			
			<td>1. Tidur pulas</td>
		    <td align="center"><input type="checkbox" name="kewaspadaan_1" value="1" ' . ((isset($kewaspadaan[0]) and $kewaspadaan[0] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kewaspadaan_2" value="1" ' . ((isset($kewaspadaan[1]) and $kewaspadaan[1] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kewaspadaan_3" value="1" ' . ((isset($kewaspadaan[2]) and $kewaspadaan[2] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kewaspadaan_4" value="1" ' . ((isset($kewaspadaan[3]) and $kewaspadaan[3] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kewaspadaan_5" value="1" ' . ((isset($kewaspadaan[4]) and $kewaspadaan[4] == '1') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>			
			<td>2. Tidur kurang nyenyak</td>		
		    <td align="center"><input type="checkbox" name="kewaspadaan_1" value="2" ' . ((isset($kewaspadaan[0]) and $kewaspadaan[0] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kewaspadaan_2" value="2" ' . ((isset($kewaspadaan[1]) and $kewaspadaan[1] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kewaspadaan_3" value="2" ' . ((isset($kewaspadaan[2]) and $kewaspadaan[2] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kewaspadaan_4" value="2" ' . ((isset($kewaspadaan[3]) and $kewaspadaan[3] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kewaspadaan_5" value="2" ' . ((isset($kewaspadaan[4]) and $kewaspadaan[4] == '2') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>			
			<td>3. Gelisah</td>		
		    <td align="center"><input type="checkbox" name="kewaspadaan_1" value="3" ' . ((isset($kewaspadaan[0]) and $kewaspadaan[0] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kewaspadaan_2" value="3" ' . ((isset($kewaspadaan[1]) and $kewaspadaan[1] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kewaspadaan_3" value="3" ' . ((isset($kewaspadaan[2]) and $kewaspadaan[2] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kewaspadaan_4" value="3" ' . ((isset($kewaspadaan[3]) and $kewaspadaan[3] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kewaspadaan_5" value="3" ' . ((isset($kewaspadaan[4]) and $kewaspadaan[4] == '3') ? 'checked="checked"' : '') . ' /></td>
		</tr>	
		<tr>			
			<td>4. Sadar sepenuhnya dan waspada</td>		
		    <td align="center"><input type="checkbox" name="kewaspadaan_1" value="4" ' . ((isset($kewaspadaan[0]) and $kewaspadaan[0] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kewaspadaan_2" value="4" ' . ((isset($kewaspadaan[1]) and $kewaspadaan[1] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kewaspadaan_3" value="4" ' . ((isset($kewaspadaan[2]) and $kewaspadaan[2] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kewaspadaan_4" value="4" ' . ((isset($kewaspadaan[3]) and $kewaspadaan[3] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kewaspadaan_5" value="4" ' . ((isset($kewaspadaan[4]) and $kewaspadaan[4] == '4') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>			
			<td>5. Hiper alert</td>		
		    <td align="center"><input type="checkbox" name="kewaspadaan_1" value="5" ' . ((isset($kewaspadaan[0]) and $kewaspadaan[0] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kewaspadaan_2" value="5" ' . ((isset($kewaspadaan[1]) and $kewaspadaan[1] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kewaspadaan_3" value="5" ' . ((isset($kewaspadaan[2]) and $kewaspadaan[2] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kewaspadaan_4" value="5" ' . ((isset($kewaspadaan[3]) and $kewaspadaan[3] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kewaspadaan_5" value="5" ' . ((isset($kewaspadaan[4]) and $kewaspadaan[4] == '5') ? 'checked="checked"' : '') . ' /></td>
		</tr>	
		<tr>
			<td rowspan="5" valign="top" style="padding-top:15px; ">KETENANGAN</td>			
			<td>1. Tenang</td>
		    <td align="center"><input type="checkbox" name="ketenangan_1" value="1" ' . ((isset($ketenangan[0]) and $ketenangan[0] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="ketenangan_2" value="1" ' . ((isset($ketenangan[1]) and $ketenangan[1] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="ketenangan_3" value="1" ' . ((isset($ketenangan[2]) and $ketenangan[2] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="ketenangan_4" value="1" ' . ((isset($ketenangan[3]) and $ketenangan[3] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="ketenangan_5" value="1" ' . ((isset($ketenangan[4]) and $ketenangan[4] == '1') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>2. Agak cemas</td>
		    <td align="center"><input type="checkbox" name="ketenangan_1" value="2" ' . ((isset($ketenangan[0]) and $ketenangan[0] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="ketenangan_2" value="2" ' . ((isset($ketenangan[1]) and $ketenangan[1] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="ketenangan_3" value="2" ' . ((isset($ketenangan[2]) and $ketenangan[2] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="ketenangan_4" value="2" ' . ((isset($ketenangan[3]) and $ketenangan[3] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="ketenangan_5" value="2" ' . ((isset($ketenangan[4]) and $ketenangan[4] == '2') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>3. Cemas</td>
		    <td align="center"><input type="checkbox" name="ketenangan_1" value="3" ' . ((isset($ketenangan[0]) and $ketenangan[0] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="ketenangan_2" value="3" ' . ((isset($ketenangan[1]) and $ketenangan[1] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="ketenangan_3" value="3" ' . ((isset($ketenangan[2]) and $ketenangan[2] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="ketenangan_4" value="3" ' . ((isset($ketenangan[3]) and $ketenangan[3] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="ketenangan_5" value="3" ' . ((isset($ketenangan[4]) and $ketenangan[4] == '3') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>4. Sangat cemas</td>
		    <td align="center"><input type="checkbox" name="ketenangan_1" value="4" ' . ((isset($ketenangan[0]) and $ketenangan[0] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="ketenangan_2" value="4" ' . ((isset($ketenangan[1]) and $ketenangan[1] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="ketenangan_3" value="4" ' . ((isset($ketenangan[2]) and $ketenangan[2] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="ketenangan_4" value="4" ' . ((isset($ketenangan[3]) and $ketenangan[3] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="ketenangan_5" value="4" ' . ((isset($ketenangan[4]) and $ketenangan[4] == '4') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>5. Panik</td>
		    <td align="center"><input type="checkbox" name="ketenangan_1" value="5" ' . ((isset($ketenangan[0]) and $ketenangan[0] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="ketenangan_2" value="5" ' . ((isset($ketenangan[1]) and $ketenangan[1] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="ketenangan_3" value="5" ' . ((isset($ketenangan[2]) and $ketenangan[2] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="ketenangan_4" value="5" ' . ((isset($ketenangan[3]) and $ketenangan[3] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="ketenangan_5" value="5" ' . ((isset($ketenangan[4]) and $ketenangan[4] == '5') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td rowspan="5" valign="top" style="padding-top:15px; ">DISTRES PERNAPASAN</td>
			<td>1. Tidak ada respirasi spontan dan tidak ada batuk</td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_1" value="1" ' . ((isset($distres_pernapasan[0]) and $distres_pernapasan[0] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_2" value="1" ' . ((isset($distres_pernapasan[1]) and $distres_pernapasan[1] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_3" value="1" ' . ((isset($distres_pernapasan[2]) and $distres_pernapasan[2] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_4" value="1" ' . ((isset($distres_pernapasan[3]) and $distres_pernapasan[3] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_5" value="1" ' . ((isset($distres_pernapasan[4]) and $distres_pernapasan[4] == '1') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>2. Respirasi spontan dengan sedikit/ tidak ada respon terhadap ventilasi</td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_1" value="2" ' . ((isset($distres_pernapasan[0]) and $distres_pernapasan[0] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_2" value="2" ' . ((isset($distres_pernapasan[1]) and $distres_pernapasan[1] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_3" value="2" ' . ((isset($distres_pernapasan[2]) and $distres_pernapasan[2] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_4" value="2" ' . ((isset($distres_pernapasan[3]) and $distres_pernapasan[3] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_5" value="2" ' . ((isset($distres_pernapasan[4]) and $distres_pernapasan[4] == '2') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>3. Kadang-kadang batuk atau terdapat tahanan terhadap ventilasi</td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_1" value="3" ' . ((isset($distres_pernapasan[0]) and $distres_pernapasan[0] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_2" value="3" ' . ((isset($distres_pernapasan[1]) and $distres_pernapasan[1] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_3" value="3" ' . ((isset($distres_pernapasan[2]) and $distres_pernapasan[2] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_4" value="3" ' . ((isset($distres_pernapasan[3]) and $distres_pernapasan[3] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_5" value="3" ' . ((isset($distres_pernapasan[4]) and $distres_pernapasan[4] == '3') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>4. Sering batuk, terdapat tahanan/ perlawanan terhadap ventilator</td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_1" value="4" ' . ((isset($distres_pernapasan[0]) and $distres_pernapasan[0] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_2" value="4" ' . ((isset($distres_pernapasan[1]) and $distres_pernapasan[1] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_3" value="4" ' . ((isset($distres_pernapasan[2]) and $distres_pernapasan[2] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_4" value="4" ' . ((isset($distres_pernapasan[3]) and $distres_pernapasan[3] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_5" value="4" ' . ((isset($distres_pernapasan[4]) and $distres_pernapasan[4] == '4') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>5. Melawan secara aktif terhadap ventilator, batuk terus menerus/ tersedak</td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_1" value="5" ' . ((isset($distres_pernapasan[0]) and $distres_pernapasan[0] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_2" value="5" ' . ((isset($distres_pernapasan[1]) and $distres_pernapasan[1] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_3" value="5" ' . ((isset($distres_pernapasan[2]) and $distres_pernapasan[2] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_4" value="5" ' . ((isset($distres_pernapasan[3]) and $distres_pernapasan[3] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="distres_pernapasan_5" value="5" ' . ((isset($distres_pernapasan[4]) and $distres_pernapasan[4] == '5') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td rowspan="5" valign="top" style="padding-top:15px; ">MENANGIS</td>
			<td>1. Bernapas dengan tenang</td>
		    <td align="center"><input type="checkbox" name="menangis_1" value="1" ' . ((isset($menangis[0]) and $menangis[0] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_2" value="1" ' . ((isset($menangis[1]) and $menangis[1] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_3" value="1" ' . ((isset($menangis[2]) and $menangis[2] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_4" value="1" ' . ((isset($menangis[3]) and $menangis[3] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_5" value="1" ' . ((isset($menangis[4]) and $menangis[4] == '1') ? 'checked="checked"' : '') . ' /></td>
		</tr>	
		<tr>
			<td>2. Terisak-isak</td>
		    <td align="center"><input type="checkbox" name="menangis_1" value="2" ' . ((isset($menangis[0]) and $menangis[0] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_2" value="2" ' . ((isset($menangis[1]) and $menangis[1] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_3" value="2" ' . ((isset($menangis[2]) and $menangis[2] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_4" value="2" ' . ((isset($menangis[3]) and $menangis[3] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_5" value="2" ' . ((isset($menangis[4]) and $menangis[4] == '2') ? 'checked="checked"' : '') . ' /></td>
		</tr>	
		<tr>
			<td>3. Meraung</td>
		    <td align="center"><input type="checkbox" name="menangis_1" value="3" ' . ((isset($menangis[0]) and $menangis[0] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_2" value="3" ' . ((isset($menangis[1]) and $menangis[1] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_3" value="3" ' . ((isset($menangis[2]) and $menangis[2] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_4" value="3" ' . ((isset($menangis[3]) and $menangis[3] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_5" value="3" ' . ((isset($menangis[4]) and $menangis[4] == '3') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>4. Menangis</td>
		    <td align="center"><input type="checkbox" name="menangis_1" value="4" ' . ((isset($menangis[0]) and $menangis[0] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_2" value="4" ' . ((isset($menangis[1]) and $menangis[1] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_3" value="4" ' . ((isset($menangis[2]) and $menangis[2] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_4" value="4" ' . ((isset($menangis[3]) and $menangis[3] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_5" value="4" ' . ((isset($menangis[4]) and $menangis[4] == '4') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>5. Berteriak</td>
		    <td align="center"><input type="checkbox" name="menangis_1" value="5" ' . ((isset($menangis[0]) and $menangis[0] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_2" value="5" ' . ((isset($menangis[1]) and $menangis[1] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_3" value="5" ' . ((isset($menangis[2]) and $menangis[2] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_4" value="5" ' . ((isset($menangis[3]) and $menangis[3] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_5" value="5" ' . ((isset($menangis[4]) and $menangis[4] == '5') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td rowspan="5" valign="top" style="padding-top:15px; ">PERGERAKAN</td>
			<td>1. Tidak ada pergerakan</td>
			<td align="center"><input type="checkbox" name="pergerakan_1" value="1" ' . ((isset($pergerakan[0]) and $pergerakan[0] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="pergerakan_2" value="1" ' . ((isset($pergerakan[1]) and $pergerakan[1] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="pergerakan_3" value="1" ' . ((isset($pergerakan[2]) and $pergerakan[2] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="pergerakan_4" value="1" ' . ((isset($pergerakan[3]) and $pergerakan[3] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="pergerakan_5" value="1" ' . ((isset($pergerakan[4]) and $pergerakan[4] == '1') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>2. Kadang-kadang bergerak perlahan</td>
			<td align="center"><input type="checkbox" name="pergerakan_1" value="2" ' . ((isset($pergerakan[0]) and $pergerakan[0] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="pergerakan_2" value="2" ' . ((isset($pergerakan[1]) and $pergerakan[1] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="pergerakan_3" value="2" ' . ((isset($pergerakan[2]) and $pergerakan[2] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="pergerakan_4" value="2" ' . ((isset($pergerakan[3]) and $pergerakan[3] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="pergerakan_5" value="2" ' . ((isset($pergerakan[4]) and $pergerakan[4] == '2') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>3. Sering bergerak perlahan</td>
			<td align="center"><input type="checkbox" name="pergerakan_1" value="3" ' . ((isset($pergerakan[0]) and $pergerakan[0] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="pergerakan_2" value="3" ' . ((isset($pergerakan[1]) and $pergerakan[1] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="pergerakan_3" value="3" ' . ((isset($pergerakan[2]) and $pergerakan[2] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="pergerakan_4" value="3" ' . ((isset($pergerakan[3]) and $pergerakan[3] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="pergerakan_5" value="3" ' . ((isset($pergerakan[4]) and $pergerakan[4] == '3') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>4. Pergerakan aktif/ gelisah</td>
			<td align="center"><input type="checkbox" name="pergerakan_1" value="4" ' . ((isset($pergerakan[0]) and $pergerakan[0] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="pergerakan_2" value="4" ' . ((isset($pergerakan[1]) and $pergerakan[1] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="pergerakan_3" value="4" ' . ((isset($pergerakan[2]) and $pergerakan[2] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="pergerakan_4" value="4" ' . ((isset($pergerakan[3]) and $pergerakan[3] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="pergerakan_5" value="4" ' . ((isset($pergerakan[4]) and $pergerakan[4] == '4') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>5. Bergerak aktif termasuk badan dan kepala</td>
			<td align="center"><input type="checkbox" name="pergerakan_1" value="5" ' . ((isset($pergerakan[0]) and $pergerakan[0] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="pergerakan_2" value="5" ' . ((isset($pergerakan[1]) and $pergerakan[1] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="pergerakan_3" value="5" ' . ((isset($pergerakan[2]) and $pergerakan[2] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="pergerakan_4" value="5" ' . ((isset($pergerakan[3]) and $pergerakan[3] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="pergerakan_5" value="5" ' . ((isset($pergerakan[4]) and $pergerakan[4] == '5') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		 </table>';
		 
		 $edoc_content_2 = '<style>.tbl tr td {
				   border: 1px solid black;
				   padding-left:1px;
				   border-collapse: collapse;
			}</style>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" autosize="1" class="tbl">
		<tr>
			<td align="center" bgcolor="#CCCCCC" ><strong>Kategori</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Skala</strong></td>		
			<td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		</tr>
		 <tr>
			<td rowspan="5" valign="top" style="padding-top:15px; ">TONUS OTOT</td>
			<td>1. Otot relaks sepenuhnya, tidak ada tonus otot</td>
		    <td align="center"><input type="checkbox" name="tonus_otot_1" value="1" ' . ((isset($tonus_otot[0]) and $tonus_otot[0] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tonus_otot_2" value="1" ' . ((isset($tonus_otot[1]) and $tonus_otot[1] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tonus_otot_3" value="1" ' . ((isset($tonus_otot[2]) and $tonus_otot[2] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tonus_otot_4" value="1" ' . ((isset($tonus_otot[3]) and $tonus_otot[3] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tonus_otot_5" value="1" ' . ((isset($tonus_otot[4]) and $tonus_otot[4] == '1') ? 'checked="checked"' : '') . ' /></td>
		 </tr>
		<tr>
			<td>2. Penurunan tonus otot</td>
		    <td align="center"><input type="checkbox" name="tonus_otot_1" value="2" ' . ((isset($tonus_otot[0]) and $tonus_otot[0] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tonus_otot_2" value="2" ' . ((isset($tonus_otot[1]) and $tonus_otot[1] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tonus_otot_3" value="2" ' . ((isset($tonus_otot[2]) and $tonus_otot[2] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tonus_otot_4" value="2" ' . ((isset($tonus_otot[3]) and $tonus_otot[3] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tonus_otot_5" value="2" ' . ((isset($tonus_otot[4]) and $tonus_otot[4] == '2') ? 'checked="checked"' : '') . ' /></td>
		 </tr>
		 <tr>
			<td>3. Tonus otot normal</td>
		    <td align="center"><input type="checkbox" name="tonus_otot_1" value="3" ' . ((isset($tonus_otot[0]) and $tonus_otot[0] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tonus_otot_2" value="3" ' . ((isset($tonus_otot[1]) and $tonus_otot[1] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tonus_otot_3" value="3" ' . ((isset($tonus_otot[2]) and $tonus_otot[2] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tonus_otot_4" value="3" ' . ((isset($tonus_otot[3]) and $tonus_otot[3] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tonus_otot_5" value="3" ' . ((isset($tonus_otot[4]) and $tonus_otot[4] == '3') ? 'checked="checked"' : '') . ' /></td>
		 </tr>
		 <tr>
			<td>4. Peningkatan tonus otot dan fleksi jari tangan dan kaki</td>
		    <td align="center"><input type="checkbox" name="tonus_otot_1" value="4" ' . ((isset($tonus_otot[0]) and $tonus_otot[0] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tonus_otot_2" value="4" ' . ((isset($tonus_otot[1]) and $tonus_otot[1] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tonus_otot_3" value="4" ' . ((isset($tonus_otot[2]) and $tonus_otot[2] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tonus_otot_4" value="4" ' . ((isset($tonus_otot[3]) and $tonus_otot[3] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tonus_otot_5" value="4" ' . ((isset($tonus_otot[4]) and $tonus_otot[4] == '4') ? 'checked="checked"' : '') . ' /></td>
		 </tr>
		 <tr>
			<td>5. Kekakuan otot ekstrim dan fleksi tangan dan kaki</td>
		    <td align="center"><input type="checkbox" name="tonus_otot_1" value="5" ' . ((isset($tonus_otot[0]) and $tonus_otot[0] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tonus_otot_2" value="5" ' . ((isset($tonus_otot[1]) and $tonus_otot[1] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tonus_otot_3" value="5" ' . ((isset($tonus_otot[2]) and $tonus_otot[2] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tonus_otot_4" value="5" ' . ((isset($tonus_otot[3]) and $tonus_otot[3] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tonus_otot_5" value="5" ' . ((isset($tonus_otot[4]) and $tonus_otot[4] == '5') ? 'checked="checked"' : '') . ' /></td>
		 </tr>
		 <tr>
			<td rowspan="5" valign="top" style="padding-top:15px; ">TEGANGAN WAJAH</td>
			<td>1. Otot wajah relaks sepenuhnya</td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_1" value="1" ' . ((isset($tegangan_wajah[0]) and $tegangan_wajah[0] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_2" value="1" ' . ((isset($tegangan_wajah[1]) and $tegangan_wajah[1] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_3" value="1" ' . ((isset($tegangan_wajah[2]) and $tegangan_wajah[2] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_4" value="1" ' . ((isset($tegangan_wajah[3]) and $tegangan_wajah[3] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_5" value="1" ' . ((isset($tegangan_wajah[4]) and $tegangan_wajah[4] == '1') ? 'checked="checked"' : '') . ' /></td>
		 </tr>
		 <tr>
			<td>2. Tonus otot wajah normal, tidak terlihat tegangan otot wajah yang nyata</td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_1" value="2" ' . ((isset($tegangan_wajah[0]) and $tegangan_wajah[0] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_2" value="2" ' . ((isset($tegangan_wajah[1]) and $tegangan_wajah[1] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_3" value="2" ' . ((isset($tegangan_wajah[2]) and $tegangan_wajah[2] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_4" value="2" ' . ((isset($tegangan_wajah[3]) and $tegangan_wajah[3] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_5" value="2" ' . ((isset($tegangan_wajah[4]) and $tegangan_wajah[4] == '2') ? 'checked="checked"' : '') . ' /></td>
		 </tr>
		 <tr>
			<td>3. Tegangan beberapa otot wajah nyata</td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_1" value="3" ' . ((isset($tegangan_wajah[0]) and $tegangan_wajah[0] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_2" value="3" ' . ((isset($tegangan_wajah[1]) and $tegangan_wajah[1] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_3" value="3" ' . ((isset($tegangan_wajah[2]) and $tegangan_wajah[2] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_4" value="3" ' . ((isset($tegangan_wajah[3]) and $tegangan_wajah[3] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_5" value="3" ' . ((isset($tegangan_wajah[4]) and $tegangan_wajah[4] == '3') ? 'checked="checked"' : '') . ' /></td>
		 </tr>
		 <tr>
			<td>4. Tegangan hampir di seluruh otot wajah</td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_1" value="4" ' . ((isset($tegangan_wajah[0]) and $tegangan_wajah[0] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_2" value="4" ' . ((isset($tegangan_wajah[1]) and $tegangan_wajah[1] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_3" value="4" ' . ((isset($tegangan_wajah[2]) and $tegangan_wajah[2] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_4" value="4" ' . ((isset($tegangan_wajah[3]) and $tegangan_wajah[3] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_5" value="4" ' . ((isset($tegangan_wajah[4]) and $tegangan_wajah[4] == '4') ? 'checked="checked"' : '') . ' /></td>
		 </tr>
		 <tr>
			<td>5. Seluruh otot wajah tegang, meringis</td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_1" value="5" ' . ((isset($tegangan_wajah[0]) and $tegangan_wajah[0] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_2" value="5" ' . ((isset($tegangan_wajah[1]) and $tegangan_wajah[1] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_3" value="5" ' . ((isset($tegangan_wajah[2]) and $tegangan_wajah[2] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_4" value="5" ' . ((isset($tegangan_wajah[3]) and $tegangan_wajah[3] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tegangan_wajah_5" value="5" ' . ((isset($tegangan_wajah[4]) and $tegangan_wajah[4] == '5') ? 'checked="checked"' : '') . ' /></td>
		 </tr>
		 <tr>
			<td rowspan="5" valign="top" style="padding-top:15px; ">TEKANAN DARAH BASAH</td>
			<td>1. Tekanan darah dibawah batas normal</td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_1" value="1" ' . ((isset($tekanan_darah_basah[0]) and $tekanan_darah_basah[0] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_2" value="1" ' . ((isset($tekanan_darah_basah[1]) and $tekanan_darah_basah[1] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_3" value="1" ' . ((isset($tekanan_darah_basah[2]) and $tekanan_darah_basah[2] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_4" value="1" ' . ((isset($tekanan_darah_basah[3]) and $tekanan_darah_basah[3] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_5" value="1" ' . ((isset($tekanan_darah_basah[4]) and $tekanan_darah_basah[4] == '1') ? 'checked="checked"' : '') . ' /></td>
		 </tr>
		 <tr>
			<td>2. Tekanan darah berada dibatas normal secara konsisten</td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_1" value="2" ' . ((isset($tekanan_darah_basah[0]) and $tekanan_darah_basah[0] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_2" value="2" ' . ((isset($tekanan_darah_basah[1]) and $tekanan_darah_basah[1] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_3" value="2" ' . ((isset($tekanan_darah_basah[2]) and $tekanan_darah_basah[2] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_4" value="2" ' . ((isset($tekanan_darah_basah[3]) and $tekanan_darah_basah[3] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_5" value="2" ' . ((isset($tekanan_darah_basah[4]) and $tekanan_darah_basah[4] == '2') ? 'checked="checked"' : '') . ' /></td>
		 </tr>
		 <tr>
			<td>3. Peningkatan tekanan darah sesekali >= 15% diatas batas normal (1 - 3 kali dalam observasi selama 2 menit)</td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_1" value="3" ' . ((isset($tekanan_darah_basah[0]) and $tekanan_darah_basah[0] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_2" value="3" ' . ((isset($tekanan_darah_basah[1]) and $tekanan_darah_basah[1] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_3" value="3" ' . ((isset($tekanan_darah_basah[2]) and $tekanan_darah_basah[2] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_4" value="3" ' . ((isset($tekanan_darah_basah[3]) and $tekanan_darah_basah[3] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_5" value="3" ' . ((isset($tekanan_darah_basah[4]) and $tekanan_darah_basah[4] == '3') ? 'checked="checked"' : '') . ' /></td>
		 </tr>
		 <tr>
			<td>4. Seringnya peningkatan tekanan darah >= 15% diatas batas normal (> 3 kali dalam observasi selama 2 menit)</td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_1" value="4" ' . ((isset($tekanan_darah_basah[0]) and $tekanan_darah_basah[0] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_2" value="4" ' . ((isset($tekanan_darah_basah[1]) and $tekanan_darah_basah[1] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_3" value="4" ' . ((isset($tekanan_darah_basah[2]) and $tekanan_darah_basah[2] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_4" value="4" ' . ((isset($tekanan_darah_basah[3]) and $tekanan_darah_basah[3] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_5" value="4" ' . ((isset($tekanan_darah_basah[4]) and $tekanan_darah_basah[4] == '4') ? 'checked="checked"' : '') . ' /></td>
		 </tr>
		 <tr>
			<td>5. Peningkatan tekanan darah secara terus-menerus >= 15%</td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_1" value="4" ' . ((isset($tekanan_darah_basah[0]) and $tekanan_darah_basah[0] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_2" value="4" ' . ((isset($tekanan_darah_basah[1]) and $tekanan_darah_basah[1] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_3" value="4" ' . ((isset($tekanan_darah_basah[2]) and $tekanan_darah_basah[2] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_4" value="4" ' . ((isset($tekanan_darah_basah[3]) and $tekanan_darah_basah[3] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="tekanan_darah_basah_5" value="4" ' . ((isset($tekanan_darah_basah[4]) and $tekanan_darah_basah[4] == '4') ? 'checked="checked"' : '') . ' /></td>
		 </tr>';
		
		$total_skor_1 = 0;
		$total_skor_2 = 0;
		$total_skor_3 = 0;
		$total_skor_4 = 0;
		$total_skor_5 = 0;
		if(!empty($comport_scale_id)){
			$total_skor_1 = $kewaspadaan[0] + $ketenangan[0] + $distres_pernapasan[0] + $menangis[0] + $pergerakan[0] + $tonus_otot[0] + $tegangan_wajah[0] + $tekanan_darah_basah[0];
			$total_skor_2 = $kewaspadaan[1] + $ketenangan[1] + $distres_pernapasan[1] + $menangis[1] + $pergerakan[1] + $tonus_otot[1] + $tegangan_wajah[1] + $tekanan_darah_basah[1];
			$total_skor_3 = $kewaspadaan[2] + $ketenangan[2] + $distres_pernapasan[2] + $menangis[2] + $pergerakan[2] + $tonus_otot[2] + $tegangan_wajah[2] + $tekanan_darah_basah[2];
			$total_skor_4 = $kewaspadaan[3] + $ketenangan[3] + $distres_pernapasan[3] + $menangis[3] + $pergerakan[3] + $tonus_otot[3] + $tegangan_wajah[3] + $tekanan_darah_basah[3];
			$total_skor_5 = $kewaspadaan[4] + $ketenangan[4] + $distres_pernapasan[4] + $menangis[4] + $pergerakan[4] + $tonus_otot[4] + $tegangan_wajah[4] + $tekanan_darah_basah[4];
		}	
	
		$edoc_content_2 = $edoc_content_2 . '<tr>
			<td colspan="2" style=" font-weight:bold;">TOTAL SKOR</td>
		    <td align="center">' . $total_skor_1 . '</td>
		    <td align="center">' . $total_skor_2 . '</td>
		    <td align="center">' . $total_skor_3 . '</td>
		    <td align="center">' . $total_skor_4 . '</td>
		    <td align="center">' . $total_skor_5 . '</td>
		</tr>
		<tr>
			<td colspan="2" style=" font-weight:bold;">PERAWAT</td>
		    <td align="center">' . $arr_perawat[$perawat[0]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[1]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[2]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[3]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[4]] . '</td>
		</tr>
		<tr>
			<td colspan="2" style=" font-weight:bold;">TANGGAL</td>
		    <td>' . ((isset($tanggal[0])) ? $tanggal[0] : '') . '</td>
		    <td>' . ((isset($tanggal[1])) ? $tanggal[1] : '') . '</td>
		    <td>' . ((isset($tanggal[2])) ? $tanggal[2] : '') . '</td>
		    <td>' . ((isset($tanggal[3])) ? $tanggal[3] : '') . '</td>
		    <td>' . ((isset($tanggal[4])) ? $tanggal[4] : '') . '</td>
		</tr>
	</table>';
			
			ob_start();
			include('edoc_rekammedik/edoc_frame_main.php');
			$html = ob_get_contents();
			ob_end_clean();
			if($st_ls == true){
				$mpdf->AddPage('P');	
			}else{
				if($st_print == true) $mpdf->AddPage('L');
			}
				
			$mpdf->WriteHTML($html);
			
			ob_start();
			include('edoc_rekammedik/edoc_frame_add.php');
			$html = ob_get_contents();
			ob_end_clean();
			if($st_ls == true){
				$mpdf->AddPage('P');	
			}else{
				if($st_print == true) $mpdf->AddPage('L');
			}
				
			$mpdf->WriteHTML($html);
			
    $st_print = true;
}	
//End Comfort Scale

//Skala Nyeri Flacc
$edoc_nama_documen = strtoupper('Skala Nyeri Flacc');

$qry_flacc = 'SELECT t_irna_askep_flacc_scale.FLACC_SCALE_ID,t_irna_askep_flacc_scale.MUKA,t_irna_askep_flacc_scale.KAKI,
				t_irna_askep_flacc_scale.AKTIVITAS,t_irna_askep_flacc_scale.MENANGIS,t_irna_askep_flacc_scale.RESPON_TUBUH,
				t_irna_askep_flacc_scale.PERAWAT,t_irna_askep_flacc_scale.TANGGAL,t_irna_askep_flacc_scale.USER_ASKEP
				FROM t_irna_askep_flacc_scale
				WHERE t_irna_askep_flacc_scale.FLACC_SCALE_ID = "' . $idx . '"';
$get_flacc = mysql_query($qry_flacc) or die(mysql_error());
if(mysql_num_rows($get_flacc) > 0){
	$dat_flacc = mysql_fetch_assoc($get_flacc);
	$flacc_scale_id = $dat_flacc['FLACC_SCALE_ID'];
	$muka = explode('|',$dat_flacc['MUKA']);
	$kaki = explode('|',$dat_flacc['KAKI']);
	$aktivitas = explode('|',$dat_flacc['AKTIVITAS']);
	$menangis = explode('|',$dat_flacc['MENANGIS']);
	$respon_tubuh = explode('|',$dat_flacc['RESPON_TUBUH']);
	$perawat = explode('|',$dat_flacc['PERAWAT']);
	$tanggal = explode('|',$dat_flacc['TANGGAL']);

	$edoc_content = '<style>.tbl tr td {
				   border: 1px solid black;
				   padding-left:1px;
				   border-collapse: collapse;
			}</style>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" autosize="1" class="tbl">
			<tr>
			<td align="center" bgcolor="#CCCCCC" ><strong>Parameter</strong></td>
			<td align="center" bgcolor="#CCCCCC" ><strong>Skala</strong></td>		
			<td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
			<td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		</tr>		
		<tr>
			<td rowspan="3" valign="top" style="padding-top:15px; ">FACE/ MUKA</td>			
			<td>0. Tidak ada ekspresi</td>
		    <td align="center"><input type="checkbox" name="muka_1" value="0" ' . ((isset($muka[0]) and $muka[0] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="muka_2" value="0" ' . ((isset($muka[1]) and $muka[1] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="muka_3" value="0" ' . ((isset($muka[2]) and $muka[2] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="muka_4" value="0" ' . ((isset($muka[3]) and $muka[3] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="muka_5" value="0" ' . ((isset($muka[4]) and $muka[4] == '0') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="muka_6" value="0" ' . ((isset($muka[5]) and $muka[5] == '0') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>1. Sesekali meringis</td>
		    <td align="center"><input type="checkbox" name="muka_1" value="1" ' . ((isset($muka[0]) and $muka[0] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="muka_2" value="1" ' . ((isset($muka[1]) and $muka[1] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="muka_3" value="1" ' . ((isset($muka[2]) and $muka[2] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="muka_4" value="1" ' . ((isset($muka[3]) and $muka[3] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="muka_5" value="1" ' . ((isset($muka[4]) and $muka[4] == '1') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="muka_6" value="1" ' . ((isset($muka[5]) and $muka[5] == '1') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>2. Mengatupkan rahang</td>
		    <td align="center"><input type="checkbox" name="muka_1" value="2" ' . ((isset($muka[0]) and $muka[0] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="muka_2" value="2" ' . ((isset($muka[1]) and $muka[1] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="muka_3" value="2" ' . ((isset($muka[2]) and $muka[2] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="muka_4" value="2" ' . ((isset($muka[3]) and $muka[3] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="muka_5" value="2" ' . ((isset($muka[4]) and $muka[4] == '2') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="muka_6" value="2" ' . ((isset($muka[5]) and $muka[5] == '2') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td rowspan="3" valign="top" style="padding-top:15px; ">LEGS/ KAKI</td>			
			<td>0. Posisi normal atau santai</td>
		    <td align="center"><input type="checkbox" name="kaki_1" value="0" ' . ((isset($kaki[0]) and $kaki[0] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kaki_2" value="0" ' . ((isset($kaki[1]) and $kaki[1] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kaki_3" value="0" ' . ((isset($kaki[2]) and $kaki[2] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kaki_4" value="0" ' . ((isset($kaki[3]) and $kaki[3] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kaki_5" value="0" ' . ((isset($kaki[4]) and $kaki[4] == '0') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="kaki_6" value="0" ' . ((isset($kaki[5]) and $kaki[5] == '0') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>1. Tidak nyaman/ tidak dapat istirahat, isah, tegang</td>
		    <td align="center"><input type="checkbox" name="kaki_1" value="1" ' . ((isset($kaki[0]) and $kaki[0] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kaki_2" value="1" ' . ((isset($kaki[1]) and $kaki[1] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kaki_3" value="1" ' . ((isset($kaki[2]) and $kaki[2] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kaki_4" value="1" ' . ((isset($kaki[3]) and $kaki[3] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kaki_5" value="1" ' . ((isset($kaki[4]) and $kaki[4] == '1') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="kaki_6" value="1" ' . ((isset($kaki[5]) and $kaki[5] == '1') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>2. Menendang, kaki diangkat keatas sengaja tidak bergerak</td>
		    <td align="center"><input type="checkbox" name="kaki_1" value="2" ' . ((isset($kaki[0]) and $kaki[0] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kaki_2" value="2" ' . ((isset($kaki[1]) and $kaki[1] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kaki_3" value="2" ' . ((isset($kaki[2]) and $kaki[2] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kaki_4" value="2" ' . ((isset($kaki[3]) and $kaki[3] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="kaki_5" value="2" ' . ((isset($kaki[4]) and $kaki[4] == '2') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="kaki_6" value="2" ' . ((isset($kaki[5]) and $kaki[5] == '2') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td rowspan="3" valign="top" style="padding-top:15px; ">ACTIVITY/ AKTIVITAS</td>			
			<td>0. Mudah berbaring dengan tenang</td>
		    <td align="center"><input type="checkbox" name="aktivitas_1" value="0" ' . ((isset($aktivitas[0]) and $aktivitas[0] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="aktivitas_2" value="0" ' . ((isset($aktivitas[1]) and $aktivitas[1] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="aktivitas_3" value="0" ' . ((isset($aktivitas[2]) and $aktivitas[2] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="aktivitas_4" value="0" ' . ((isset($aktivitas[3]) and $aktivitas[3] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="aktivitas_5" value="0" ' . ((isset($aktivitas[4]) and $aktivitas[4] == '0') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="aktivitas_6" value="0" ' . ((isset($aktivitas[5]) and $aktivitas[5] == '0') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>1. Menggeliat dengan tegang</td>
		    <td align="center"><input type="checkbox" name="aktivitas_1" value="1" ' . ((isset($aktivitas[0]) and $aktivitas[0] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="aktivitas_2" value="1" ' . ((isset($aktivitas[1]) and $aktivitas[1] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="aktivitas_3" value="1" ' . ((isset($aktivitas[2]) and $aktivitas[2] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="aktivitas_4" value="1" ' . ((isset($aktivitas[3]) and $aktivitas[3] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="aktivitas_5" value="1" ' . ((isset($aktivitas[4]) and $aktivitas[4] == '1') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="aktivitas_6" value="1" ' . ((isset($aktivitas[5]) and $aktivitas[5] == '1') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>2. Melengkung, kaku</td>
		    <td align="center"><input type="checkbox" name="aktivitas_1" value="2" ' . ((isset($aktivitas[0]) and $aktivitas[0] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="aktivitas_2" value="2" ' . ((isset($aktivitas[1]) and $aktivitas[1] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="aktivitas_3" value="2" ' . ((isset($aktivitas[2]) and $aktivitas[2] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="aktivitas_4" value="2" ' . ((isset($aktivitas[3]) and $aktivitas[3] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="aktivitas_5" value="2" ' . ((isset($aktivitas[4]) and $aktivitas[4] == '2') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="aktivitas_6" value="2" ' . ((isset($aktivitas[5]) and $aktivitas[5] == '2') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td rowspan="3" valign="top" style="padding-top:15px; ">CRY/ MENANGIS</td>			
			<td>0. Tidak menangis</td>
		    <td align="center"><input type="checkbox" name="menangis_1" value="0" ' . ((isset($menangis[0]) and $menangis[0] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_2" value="0" ' . ((isset($menangis[1]) and $menangis[1] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_3" value="0" ' . ((isset($menangis[2]) and $menangis[2] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_4" value="0" ' . ((isset($menangis[3]) and $menangis[3] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_5" value="0" ' . ((isset($menangis[4]) and $menangis[4] == '0') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="menangis_6" value="0" ' . ((isset($menangis[5]) and $menangis[5] == '0') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>1. Mengerang/ merintih</td>
		    <td align="center"><input type="checkbox" name="menangis_1" value="1" ' . ((isset($menangis[0]) and $menangis[0] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_2" value="1" ' . ((isset($menangis[1]) and $menangis[1] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_3" value="1" ' . ((isset($menangis[2]) and $menangis[2] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_4" value="1" ' . ((isset($menangis[3]) and $menangis[3] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_5" value="1" ' . ((isset($menangis[4]) and $menangis[4] == '1') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="menangis_6" value="1" ' . ((isset($menangis[5]) and $menangis[5] == '1') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>2. Menangis terus sampai menjerit</td>
		    <td align="center"><input type="checkbox" name="menangis_1" value="2" ' . ((isset($menangis[0]) and $menangis[0] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_2" value="2" ' . ((isset($menangis[1]) and $menangis[1] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_3" value="2" ' . ((isset($menangis[2]) and $menangis[2] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_4" value="2" ' . ((isset($menangis[3]) and $menangis[3] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="menangis_5" value="2" ' . ((isset($menangis[4]) and $menangis[4] == '2') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="menangis_6" value="2" ' . ((isset($menangis[5]) and $menangis[5] == '2') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td rowspan="3" valign="top" style="padding-top:15px; ">CONSATABILITY/ RESPON TUBUH</td>			
			<td>0. Santai</td>
		    <td align="center"><input type="checkbox" name="respon_tubuh_1" value="0" ' . ((isset($respon_tubuh[0]) and $respon_tubuh[0] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="respon_tubuh_2" value="0" ' . ((isset($respon_tubuh[1]) and $respon_tubuh[1] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="respon_tubuh_3" value="0" ' . ((isset($respon_tubuh[2]) and $respon_tubuh[2] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="respon_tubuh_4" value="0" ' . ((isset($respon_tubuh[3]) and $respon_tubuh[3] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="respon_tubuh_5" value="0" ' . ((isset($respon_tubuh[4]) and $respon_tubuh[4] == '0') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="respon_tubuh_6" value="0" ' . ((isset($respon_tubuh[5]) and $respon_tubuh[5] == '0') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>1. Mudah terangsang dengan sentuhan</td>
		    <td align="center"><input type="checkbox" name="respon_tubuh_1" value="1" ' . ((isset($respon_tubuh[0]) and $respon_tubuh[0] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="respon_tubuh_2" value="1" ' . ((isset($respon_tubuh[1]) and $respon_tubuh[1] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="respon_tubuh_3" value="1" ' . ((isset($respon_tubuh[2]) and $respon_tubuh[2] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="respon_tubuh_4" value="1" ' . ((isset($respon_tubuh[3]) and $respon_tubuh[3] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="respon_tubuh_5" value="1" ' . ((isset($respon_tubuh[4]) and $respon_tubuh[4] == '1') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="respon_tubuh_6" value="1" ' . ((isset($respon_tubuh[5]) and $respon_tubuh[5] == '1') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td>2. Mudah terangsang tanpa sentuhan</td>
		    <td align="center"><input type="checkbox" name="respon_tubuh_1" value="2" ' . ((isset($respon_tubuh[0]) and $respon_tubuh[0] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="respon_tubuh_2" value="2" ' . ((isset($respon_tubuh[1]) and $respon_tubuh[1] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="respon_tubuh_3" value="2" ' . ((isset($respon_tubuh[2]) and $respon_tubuh[2] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="respon_tubuh_4" value="2" ' . ((isset($respon_tubuh[3]) and $respon_tubuh[3] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="respon_tubuh_5" value="2" ' . ((isset($respon_tubuh[4]) and $respon_tubuh[4] == '2') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="respon_tubuh_6" value="2" ' . ((isset($respon_tubuh[5]) and $respon_tubuh[5] == '2') ? 'checked="checked"' : '') . ' /></td>
		</tr>';
	
		$total_skor_1 = 0;
		$total_skor_2 = 0;
		$total_skor_3 = 0;
		$total_skor_4 = 0;
		$total_skor_5 = 0;
		$total_skor_6 = 0;
		if(!empty($flacc_scale_id)){
			$total_skor_1 = $muka[0] + $kaki[0] + $aktivitas[0] + $menangis[0] + $respon_tubuh[0];
			$total_skor_2 = $muka[1] + $kaki[1] + $aktivitas[1] + $menangis[1] + $respon_tubuh[1];
			$total_skor_3 = $muka[2] + $kaki[2] + $aktivitas[2] + $menangis[2] + $respon_tubuh[2];
			$total_skor_4 = $muka[3] + $kaki[3] + $aktivitas[3] + $menangis[3] + $respon_tubuh[3];
			$total_skor_5 = $muka[4] + $kaki[4] + $aktivitas[4] + $menangis[4] + $respon_tubuh[4];
			$total_skor_6 = $muka[5] + $kaki[5] + $aktivitas[5] + $menangis[5] + $respon_tubuh[5];
		}	
		
		$edoc_content = $edoc_content . '<tr>
			<td colspan="2" style=" font-weight:bold;">TOTAL SKOR</td>
		    <td align="center">' .$total_skor_1 . '</td>
		    <td align="center">' .$total_skor_2 . '</td>
		    <td align="center">' .$total_skor_3 . '</td>
		    <td align="center">' .$total_skor_4 . '</td>
		    <td align="center">' .$total_skor_5 . '</td>
			<td align="center">' .$total_skor_6 . '</td>
		</tr>
		<tr>
			<td colspan="2" style=" font-weight:bold;">PERAWAT</td>
		    <td align="center">' . $arr_perawat[$perawat[0]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[1]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[2]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[3]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[4]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[5]] . '</td>
		</tr>
		<tr>
			<td colspan="2" style=" font-weight:bold;">TANGGAL</td>
		    <td>' . ((isset($tanggal[0])) ? $tanggal[0] : '') . '</td>
		    <td>' . ((isset($tanggal[1])) ? $tanggal[1] : '') . '</td>
		    <td>' . ((isset($tanggal[2])) ? $tanggal[2] : '') . '</td>
		    <td>' . ((isset($tanggal[3])) ? $tanggal[3] : '') . '</td>
		    <td>' . ((isset($tanggal[4])) ? $tanggal[4] : '') . '</td>
			<td>' . ((isset($tanggal[5])) ? $tanggal[5] : '') . '</td>
		</tr>
	</table>';
			
			ob_start();
			include('edoc_rekammedik/edoc_frame_main.php');
			$html = ob_get_contents();
			ob_end_clean();
			if($st_ls == true){
				$mpdf->AddPage('P');	
			}else{
				if($st_print == true) $mpdf->AddPage('L');
			}
				
			$mpdf->WriteHTML($html);
			
    $st_print = true;
}	
//End Skala Nyeri Flacc

//Numeric Rating Scale & Skala Nyeri Wong Baker
$edoc_nama_documen = strtoupper('Numeric Rating Scale & Skala Nyeri Wong Baker');

$qry_baker = 'SELECT t_irna_askep_numeric_rating_scale.NUMERIC_RATING_SCALE_ID,
				t_irna_askep_numeric_rating_scale.SKOR,t_irna_askep_numeric_rating_scale.PERAWAT,
				t_irna_askep_numeric_rating_scale.TANGGAL,t_irna_askep_numeric_rating_scale.USER_ASKEP
				FROM t_irna_askep_numeric_rating_scale
				WHERE t_irna_askep_numeric_rating_scale.NUMERIC_RATING_SCALE_ID = "' . $idx . '"';
$get_baker = mysql_query($qry_baker) or die(mysql_error());
if(mysql_num_rows($get_baker) > 0){
	$dat_baker = mysql_fetch_assoc($get_baker);
	$numeric_rating_scale_id = $dat_baker['NUMERIC_RATING_SCALE_ID'];
	$skor = explode('|',$dat_baker['SKOR']);
	$perawat = explode('|',$dat_baker['PERAWAT']);
	$tanggal = explode('|',$dat_baker['TANGGAL']);

	$edoc_content = '<style>.tbl tr td {
				   border: 1px solid black;
				   padding-left:1px;
				   border-collapse: collapse;
			}</style>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" autosize="1" class="tbl">
			<tr>
			<td align="center" bgcolor="#CCCCCC" ><strong>Skala</strong></td>		
			<td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		    <td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
			<td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
			<td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
			<td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
			<td width="130px" align="center" bgcolor="#CCCCCC" ><strong>Skor</strong></td>
		</tr>		
		<tr>
			<td align="center">0</td>
		    <td align="center"><input type="checkbox" name="skor_1" value="0" ' . ((isset($skor[0]) and $skor[0] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_2" value="0" ' . ((isset($skor[1]) and $skor[1] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_3" value="0" ' . ((isset($skor[2]) and $skor[2] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_4" value="0" ' . ((isset($skor[3]) and $skor[3] == '0') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_5" value="0" ' . ((isset($skor[4]) and $skor[4] == '0') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_6" value="0" ' . ((isset($skor[5]) and $skor[5] == '0') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_7" value="0" ' . ((isset($skor[6]) and $skor[6] == '0') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_8" value="0" ' . ((isset($skor[7]) and $skor[7] == '0') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_9" value="0" ' . ((isset($skor[8]) and $skor[8] == '0') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td align="center">1</td>
		    <td align="center"><input type="checkbox" name="skor_1" value="1" ' . ((isset($skor[0]) and $skor[0] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_2" value="1" ' . ((isset($skor[1]) and $skor[1] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_3" value="1" ' . ((isset($skor[2]) and $skor[2] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_4" value="1" ' . ((isset($skor[3]) and $skor[3] == '1') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_5" value="1" ' . ((isset($skor[4]) and $skor[4] == '1') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_6" value="1" ' . ((isset($skor[5]) and $skor[5] == '1') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_7" value="1" ' . ((isset($skor[6]) and $skor[6] == '1') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_8" value="1" ' . ((isset($skor[7]) and $skor[7] == '1') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_9" value="1" ' . ((isset($skor[8]) and $skor[8] == '1') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td align="center">2</td>
		    <td align="center"><input type="checkbox" name="skor_1" value="2" ' . ((isset($skor[0]) and $skor[0] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_2" value="2" ' . ((isset($skor[1]) and $skor[1] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_3" value="2" ' . ((isset($skor[2]) and $skor[2] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_4" value="2" ' . ((isset($skor[3]) and $skor[3] == '2') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_5" value="2" ' . ((isset($skor[4]) and $skor[4] == '2') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_6" value="2" ' . ((isset($skor[5]) and $skor[5] == '2') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_7" value="2" ' . ((isset($skor[6]) and $skor[6] == '2') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_8" value="2" ' . ((isset($skor[7]) and $skor[7] == '2') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_9" value="2" ' . ((isset($skor[8]) and $skor[8] == '2') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td align="center">3</td>
		    <td align="center"><input type="checkbox" name="skor_1" value="3" ' . ((isset($skor[0]) and $skor[0] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_2" value="3" ' . ((isset($skor[1]) and $skor[1] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_3" value="3" ' . ((isset($skor[2]) and $skor[2] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_4" value="3" ' . ((isset($skor[3]) and $skor[3] == '3') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_5" value="3" ' . ((isset($skor[4]) and $skor[4] == '3') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_6" value="3" ' . ((isset($skor[5]) and $skor[5] == '3') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_7" value="3" ' . ((isset($skor[6]) and $skor[6] == '3') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_8" value="3" ' . ((isset($skor[7]) and $skor[7] == '3') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_9" value="3" ' . ((isset($skor[8]) and $skor[8] == '3') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td align="center">4</td>
		    <td align="center"><input type="checkbox" name="skor_1" value="4" ' . ((isset($skor[0]) and $skor[0] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_2" value="4" ' . ((isset($skor[1]) and $skor[1] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_3" value="4" ' . ((isset($skor[2]) and $skor[2] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_4" value="4" ' . ((isset($skor[3]) and $skor[3] == '4') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_5" value="4" ' . ((isset($skor[4]) and $skor[4] == '4') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_6" value="4" ' . ((isset($skor[5]) and $skor[5] == '4') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_7" value="4" ' . ((isset($skor[6]) and $skor[6] == '4') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_8" value="4" ' . ((isset($skor[7]) and $skor[7] == '4') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_9" value="4" ' . ((isset($skor[8]) and $skor[8] == '4') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td align="center">5</td>
		    <td align="center"><input type="checkbox" name="skor_1" value="5" ' . ((isset($skor[0]) and $skor[0] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_2" value="5" ' . ((isset($skor[1]) and $skor[1] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_3" value="5" ' . ((isset($skor[2]) and $skor[2] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_4" value="5" ' . ((isset($skor[3]) and $skor[3] == '5') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_5" value="5" ' . ((isset($skor[4]) and $skor[4] == '5') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_6" value="5" ' . ((isset($skor[5]) and $skor[5] == '5') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_7" value="5" ' . ((isset($skor[6]) and $skor[6] == '5') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_8" value="5" ' . ((isset($skor[7]) and $skor[7] == '5') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_9" value="5" ' . ((isset($skor[8]) and $skor[8] == '5') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td align="center">6</td>
		    <td align="center"><input type="checkbox" name="skor_1" value="6" ' . ((isset($skor[0]) and $skor[0] == '6') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_2" value="6" ' . ((isset($skor[1]) and $skor[1] == '6') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_3" value="6" ' . ((isset($skor[2]) and $skor[2] == '6') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_4" value="6" ' . ((isset($skor[3]) and $skor[3] == '6') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_5" value="6" ' . ((isset($skor[4]) and $skor[4] == '6') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_6" value="6" ' . ((isset($skor[5]) and $skor[5] == '6') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_7" value="6" ' . ((isset($skor[6]) and $skor[6] == '6') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_8" value="6" ' . ((isset($skor[7]) and $skor[7] == '6') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_9" value="6" ' . ((isset($skor[8]) and $skor[8] == '6') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td align="center">7</td>
		    <td align="center"><input type="checkbox" name="skor_1" value="7" ' . ((isset($skor[0]) and $skor[0] == '7') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_2" value="7" ' . ((isset($skor[1]) and $skor[1] == '7') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_3" value="7" ' . ((isset($skor[2]) and $skor[2] == '7') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_4" value="7" ' . ((isset($skor[3]) and $skor[3] == '7') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_5" value="7" ' . ((isset($skor[4]) and $skor[4] == '7') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_6" value="7" ' . ((isset($skor[5]) and $skor[5] == '7') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_7" value="7" ' . ((isset($skor[6]) and $skor[6] == '7') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_8" value="7" ' . ((isset($skor[7]) and $skor[7] == '7') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_9" value="7" ' . ((isset($skor[8]) and $skor[8] == '7') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td align="center">8</td>
		    <td align="center"><input type="checkbox" name="skor_1" value="8" ' . ((isset($skor[0]) and $skor[0] == '8') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_2" value="8" ' . ((isset($skor[1]) and $skor[1] == '8') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_3" value="8" ' . ((isset($skor[2]) and $skor[2] == '8') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_4" value="8" ' . ((isset($skor[3]) and $skor[3] == '8') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_5" value="8" ' . ((isset($skor[4]) and $skor[4] == '8') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_6" value="8" ' . ((isset($skor[5]) and $skor[5] == '8') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_7" value="8" ' . ((isset($skor[6]) and $skor[6] == '8') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_8" value="8" ' . ((isset($skor[7]) and $skor[7] == '8') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_9" value="8" ' . ((isset($skor[8]) and $skor[8] == '8') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td align="center">9</td>
		    <td align="center"><input type="checkbox" name="skor_1" value="9" ' . ((isset($skor[0]) and $skor[0] == '9') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_2" value="9" ' . ((isset($skor[1]) and $skor[1] == '9') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_3" value="9" ' . ((isset($skor[2]) and $skor[2] == '9') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_4" value="9" ' . ((isset($skor[3]) and $skor[3] == '9') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_5" value="9" ' . ((isset($skor[4]) and $skor[4] == '9') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_6" value="9" ' . ((isset($skor[5]) and $skor[5] == '9') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_7" value="9" ' . ((isset($skor[6]) and $skor[6] == '9') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_8" value="9" ' . ((isset($skor[7]) and $skor[7] == '9') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_9" value="9" ' . ((isset($skor[8]) and $skor[8] == '9') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td align="center">10</td>
		    <td align="center"><input type="checkbox" name="skor_1" value="10" ' . ((isset($skor[0]) and $skor[0] == '10') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_2" value="10" ' . ((isset($skor[1]) and $skor[1] == '10') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_3" value="10" ' . ((isset($skor[2]) and $skor[2] == '10') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_4" value="10" ' . ((isset($skor[3]) and $skor[3] == '10') ? 'checked="checked"' : '') . ' /></td>
		    <td align="center"><input type="checkbox" name="skor_5" value="10" ' . ((isset($skor[4]) and $skor[4] == '10') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_6" value="10" ' . ((isset($skor[5]) and $skor[5] == '10') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_7" value="10" ' . ((isset($skor[6]) and $skor[6] == '10') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_8" value="10" ' . ((isset($skor[7]) and $skor[7] == '10') ? 'checked="checked"' : '') . ' /></td>
			<td align="center"><input type="checkbox" name="skor_9" value="10" ' . ((isset($skor[8]) and $skor[8] == '10') ? 'checked="checked"' : '') . ' /></td>
		</tr>
		<tr>
			<td style=" font-weight:bold;">PERAWAT</td>
		    <td align="center">' . $arr_perawat[$perawat[0]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[1]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[2]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[3]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[4]] . '</td>
		    <td align="center">' . $arr_perawat[$perawat[5]] . '</td>
			<td align="center">' . $arr_perawat[$perawat[6]] . '</td>
			<td align="center">' . $arr_perawat[$perawat[7]] . '</td>	
			<td align="center">' . $arr_perawat[$perawat[8]] . '</td>	
		</tr>
		<tr>
			<td style=" font-weight:bold;">TANGGAL</td>
		    <td>' . ((isset($tanggal[0])) ? $tanggal[0] : '') . '</td>
		    <td>' . ((isset($tanggal[1])) ? $tanggal[1] : '') . '</td>
		    <td>' . ((isset($tanggal[2])) ? $tanggal[2] : '') . '</td>
		    <td>' . ((isset($tanggal[3])) ? $tanggal[3] : '') . '</td>
		    <td>' . ((isset($tanggal[4])) ? $tanggal[4] : '') . '</td>
			<td>' . ((isset($tanggal[5])) ? $tanggal[5] : '') . '</td>
			<td>' . ((isset($tanggal[6])) ? $tanggal[6] : '') . '</td>
			<td>' . ((isset($tanggal[7])) ? $tanggal[7] : '') . '</td>
			<td>' . ((isset($tanggal[8])) ? $tanggal[8] : '') . '</td>
		</tr>
		<tr>
			<td colspan="4" >
			Keterangan Skala Nyeri Wong Baker :<br />
			0	=	tidak ada nyeri<br />
			2	= 	nyeri sangat ringan<br />
			4	=	nyeri ringan (agak mengganggu)<br />
			6	= 	nyeri sedang (mengganggu aktivitas)<br />
			8 	=	nyeri berat (sangat mengganggu)<br />
			10	=	nyeri tidak dapat ditahan	
			</td>
			<td colspan="4" valign="top">
			Keterangan Skala Nyeri Numeric Rating Scale :<br />
			0	=	tidak nyeri<br />
			1-3	=	nyeri ringan<br />
			4-6 =	nyeri sedang<br />
			7-10 =	nyeri berat
			</td>
			<td colspan="2" valign="top">
			* Untuk anak umur diatas 3 tahun dan dewasa
			</td>
		</tr>	
	</table>';
			
			ob_start();
			include('edoc_rekammedik/edoc_frame_main.php');
			$html = ob_get_contents();
			ob_end_clean();
			if($st_ls == true){
				$mpdf->AddPage('P');	
			}else{
				if($st_print == true) $mpdf->AddPage('L');
			}
				
			$mpdf->WriteHTML($html);
			
    $st_print = true;
}	
//End Numeric Rating Scale & Skala Nyeri Wong Baker

if($st_print == true) {
	$mpdf->Output($rmfile_path . '/' . $nomr . '/' . $filename);	
	saveData($nomr,$idx,'2',$id_document,$filename,$user_name,'','');
}	
}
?>