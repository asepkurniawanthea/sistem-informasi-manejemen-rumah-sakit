<style>
.list_isi{
	height:550px;
}
</style>
<?php
$tgl_1 = '';
if (isset($_SESSION['kliniksearchrekaptindakan_tgl_1']))
    $tgl_1 = $_SESSION['kliniksearchrekaptindakan_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['kliniksearchrekaptindakan_tgl_1']))
    $tgl_2 = $_SESSION['kliniksearchrekaptindakan_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['kliniksearchrekaptindakan_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['kliniksearchrekaptindakan_tgl_2'] = $_GET['tgl_2'];
}

$unit_id = '';
if (isset($_SESSION['kliniksearchrekaptindakan_unit_id']))
		$unit_id = $_SESSION['kliniksearchrekaptindakan_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['kliniksearchrekaptindakan_unit_id'] = $unit_id;
}

$pegawai_id = '';
if (isset($_SESSION['kliniksearchrekaptindakan_pegawai_id']))
		$pegawai_id = $_SESSION['kliniksearchrekaptindakan_pegawai_id'];

if (isset($_GET['pegawai_id'])) {
    $pegawai_id = $_GET['pegawai_id'];
	$_SESSION['kliniksearchrekaptindakan_pegawai_id'] = $pegawai_id;
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" >
        <tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<?php if(currentModul() == 'klinik' or currentModul() == 'kusta' or currentModul() == 'igd'){ ?>	
			<td>Dokter Pelaksana</td>
			<td><select name="pegawai_id" class="text_dt" >
				<option value=""> - </option>
				<?php echo getDokter($pegawai_id,$_SESSION['SES_SIMRS_UNIT_ID']); ?>
			</select></td>	
			<?php }else{ ?>
			<td>Poliklinik</td>
			<td><select name="unit_id" class="text_dt" >
				<option value=""> - </option>
				<?php echo getUnit('irja',$unit_id); ?>
			</select></td>	
			<?php } ?>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>
            <td colspan="2" align="right"><input type="submit" value="cari" class="myButton" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_filter = '';
if(!empty($pegawai_id))
	$qry_filter = 'AND (t_irja.PEGAWAI_ID = "' . $pegawai_id . '" OR t_irja_tarif.PEGAWAI_ID = "' . $pegawai_id . '") ';
if(!empty($unit_id))
	$qry_filter = 'AND t_irja.UNIT_ID = "' . $unit_id . '" ';	

$qry_kunjungan = 'SELECT DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") AS TANGGAL,m_unit.NAMA_UNIT,m_pasien.NOMR,m_pasien.NAMA_PASIEN,
				m_pegawai.NAMA_PEGAWAI,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,SUM(t_irja_tarif.KUANTITI) AS KUANTITI,
				m_jaminan.NAMA_JAMINAN,m_pegawai1.NAMA_PEGAWAI AS PELAKSANA,
				DATE_FORMAT(t_irja.PASIEN_MASUK,"%d/%m/%Y %H:%i:%s") AS PASIEN_MASUK,
				DATE_FORMAT(t_irja.PASIEN_KELUAR,"%d/%m/%Y %H:%i:%s") AS PASIEN_KELUAR,
				m_pasien_pulang.KET_PASIEN_PULANG,m_tarif.TARIF_NON_KELAS
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_pegawai m_pegawai1 ON (t_irja_tarif.PEGAWAI_ID = m_pegawai1.PEGAWAI_ID)
				LEFT JOIN m_pasien_pulang ON (t_irja.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
				WHERE DATE(t_irja_tarif.TGL_TARIF) >= ' . $tgl_filter_1 . '
				AND DATE(t_irja_tarif.TGL_TARIF) <= ' . $tgl_filter_2 . ' 
				' . $qry_filter . '
				AND t_irja_tarif.NO_TARIF IS NOT NULL AND t_irja_tarif.ST_BAYAR <> "Batal"
				AND t_irja.ST_BATAL IS NULL AND m_tarif.KODE_TARIF_GROUP NOT IN ("01","92")	 
				GROUP BY DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),m_unit.NAMA_UNIT,m_pasien.NOMR,m_pasien.NAMA_PASIEN,
				m_pegawai.NAMA_PEGAWAI,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,
				m_jaminan.NAMA_JAMINAN,m_pegawai1.NAMA_PEGAWAI,
				DATE_FORMAT(t_irja.PASIEN_MASUK,"%d/%m/%Y %H:%i:%s"),
				DATE_FORMAT(t_irja.PASIEN_KELUAR,"%d/%m/%Y %H:%i:%s"),
				m_pasien_pulang.KET_PASIEN_PULANG,m_tarif.TARIF_NON_KELAS
				ORDER BY m_unit.NAMA_UNIT,m_pegawai.NAMA_PEGAWAI,m_pasien.NOMR,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF';
	
$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_id=' . $unit_id . '&pegawai_id=' . $pegawai_id;
include('klinik/klinik_list_report_tindakan_dokter.php');
?>
