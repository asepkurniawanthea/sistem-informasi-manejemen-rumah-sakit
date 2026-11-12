<?php
$nomr = '';
if (isset($_SESSION['rmsearchriwayat_nomr']))
    $nomr = $_SESSION['rmsearchriwayat_nomr'];

if (isset($_GET['nomr'])){
    $nomr = $_GET['nomr'];
	$_SESSION['rmsearchriwayat_nomr'] = $nomr;
}	
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0" >
        <tr>
			<td>Nomor MR</td>
            <td colspan="2"><input type="text" name="nomr" id="nomr" value="<?php echo $nomr; ?>" class="text_dt"/></td>
        </tr>
		<tr>
			<td>&nbsp;</td>
            <td align="right"><input name="submit" type="submit" class="myButton" value="cari" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<?php
if(!empty($nomr)){

$sql_search = 'SELECT *,DATE_FORMAT(TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR FROM m_pasien WHERE NOMR = "' . $nomr . '"';
$get_search = mysql_query($sql_search) or die(mysql_error());
if(mysql_num_rows($get_search) > 0){
	$dat_pasien = mysql_fetch_assoc($get_search);
	$nama_pasien = $dat_pasien['NAMA_PASIEN'];
	$tgl_lahir = $dat_pasien['TGL_LAHIR'];
	$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
	$alamat = $dat_pasien['ALAMAT'];
	$nik = $dat_pasien['NIK'];
	
	$umur = getUmur($tgl_lahir);
	?>
	<div style=" height:auto; padding:15px; padding-bottom:0px;">
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
 	</div>
	<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
	<?php
	
	if(currentModul() != 'klinik' and currentModul() != 'kusta' and currentModul() != 'igd' and currentModul() != 'rawat inap'){
		if($_SESSION['SES_SIMRS_ADMIN'] != '1') die;
	}
	
	$qry_riwayat = 'SELECT DISTINCT * FROM (SELECT t_irja.IRJA_ID AS RAWAT_ID,STR_TO_DATE(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") AS PASIEN_MASUK,
						STR_TO_DATE(DATE_FORMAT(t_irja.PASIEN_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") AS TGL_KELUAR,
						CASE WHEN t_irja.UNIT_ID = 9 THEN "IGD" ELSE CONCAT("Rawat Jalan"," (",m_unit.NAMA_UNIT,")") END AS PELAYANAN,
						(SELECT MIN(CONCAT(t_irja_diagnosa.DIAGNOSA," (",t_irja_diagnosa.ICD_CODE,")")) 
							FROM t_irja_diagnosa WHERE t_irja_diagnosa.IRJA_ID = t_irja.IRJA_ID
							AND t_irja_diagnosa.DIAGNOSA_ORDER = 0
							GROUP BY t_irja_diagnosa.IRJA_ID) AS DIAGNOSA,
						m_pasien_pulang.KET_PASIEN_PULANG,
						"1" AS JNS_RAWAT,"RJ" AS ID_JNS_PERAWATAN
						FROM t_irja
						INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
						LEFT JOIN m_pasien_pulang ON (t_irja.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
						WHERE t_irja.NOMR = "' . $nomr . '" 
						AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
						UNION ALL
						SELECT t_irna.IRNA_ID AS RAWAT_ID,STR_TO_DATE(DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") AS PASIEN_MASUK,
						STR_TO_DATE(DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") AS TGL_KELUAR,
						CONCAT("Rawat Inap"," (",m_ruang.NAMA_RUANG,CASE WHEN LENGTH(m_ruang.DESKRIPSI) > 0 THEN CONCAT("-",m_ruang.DESKRIPSI) ELSE "" END,")") AS PELAYANAN,
						(SELECT MIN(CONCAT(t_irna_diagnosa.DIAGNOSA," (",t_irna_diagnosa.ICD_CODE,")")) 
							FROM t_irna_diagnosa WHERE t_irna_diagnosa.IRNA_ID = t_irna.IRNA_ID
							AND t_irna_diagnosa.DIAGNOSA_ORDER = 0
							GROUP BY t_irna_diagnosa.IRNA_ID) AS DIAGNOSA,
						m_pasien_pulang.KET_PASIEN_PULANG,
						"2" AS JNS_RAWAT,"RI" AS ID_JNS_PERAWATAN
						FROM t_irna
						INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
						LEFT JOIN m_pasien_pulang ON (t_irna.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
						WHERE t_irna.NOMR = "' . $nomr . '"
						AND t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL
						) riwayat_table
						ORDER BY PASIEN_MASUK DESC';
	$extparam = '&nomr=' . $nomr;
	include('rekammedik/rm_list_riwayat_pasien.php');
	echo '</div>';
	}else{
	$msg_info = 'Data Pasien Tidak Ditemukan.';
}
}
?>
