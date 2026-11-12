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
			<td>&nbsp;</td>
			<td>&nbsp;</td>	
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
$qry_kunjungan = 'SELECT TANGGAL,NOMR,NAMA_PASIEN,
				NAMA_PEGAWAI,NAMA_TARIF,NAMA_TARIF_GROUP,SUM(KUANTITI) AS KUANTITI,
				NAMA_JAMINAN,PELAKSANA,PASIEN_MASUK,PASIEN_KELUAR,KET_PASIEN_PULANG 
				FROM (
				SELECT DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") AS TANGGAL,
				m_unit.NAMA_UNIT,m_pasien.NOMR,m_pasien.NAMA_PASIEN,
				m_pegawai.NAMA_PEGAWAI,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,SUM(t_irja_tarif.KUANTITI) AS KUANTITI,
				m_jaminan.NAMA_JAMINAN,m_pegawai1.NAMA_PEGAWAI AS PELAKSANA,
				DATE_FORMAT(t_irja.PASIEN_MASUK,"%d/%m/%Y %H:%i:%s") AS PASIEN_MASUK,
				DATE_FORMAT(t_irja.PASIEN_KELUAR,"%d/%m/%Y %H:%i:%s") AS PASIEN_KELUAR,
				m_pasien_pulang.KET_PASIEN_PULANG
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
				WHERE STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
				AND STR_TO_DATE(DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . ' 
				AND t_irja.UNIT_ID = "55"
				AND t_irja_tarif.NO_TARIF IS NOT NULL AND t_irja_tarif.ST_BAYAR <> "Batal"
				AND t_irja.ST_BATAL IS NULL AND m_tarif.KODE_TARIF_GROUP NOT IN ("01","92")	 
				GROUP BY DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y"),m_unit.NAMA_UNIT,m_pasien.NOMR,m_pasien.NAMA_PASIEN,
				m_pegawai.NAMA_PEGAWAI,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,
				m_jaminan.NAMA_JAMINAN,m_pegawai1.NAMA_PEGAWAI,
				DATE_FORMAT(t_irja.PASIEN_MASUK,"%d/%m/%Y %H:%i:%s"),
				DATE_FORMAT(t_irja.PASIEN_KELUAR,"%d/%m/%Y %H:%i:%s"),
				m_pasien_pulang.KET_PASIEN_PULANG
				UNION
				SELECT DATE_FORMAT(t_hemodialisa_tarif.TGL_TARIF,"%d/%m/%Y") AS TANGGAL,
				"" AS NAMA_UNIT,m_pasien.NOMR,m_pasien.NAMA_PASIEN,
				m_pegawai.NAMA_PEGAWAI,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,SUM(t_hemodialisa_tarif.KUANTITI) AS KUANTITI,
				m_jaminan.NAMA_JAMINAN,m_pegawai1.NAMA_PEGAWAI AS PELAKSANA,
				DATE_FORMAT(t_hemodialisa.PASIEN_MASUK,"%d/%m/%Y %H:%i:%s") AS PASIEN_MASUK,
				DATE_FORMAT(t_hemodialisa.PASIEN_KELUAR,"%d/%m/%Y %H:%i:%s") AS PASIEN_KELUAR,
				m_pasien_pulang.KET_PASIEN_PULANG
				FROM t_hemodialisa
				INNER JOIN m_pasien ON (t_hemodialisa.NOMR = m_pasien.NOMR)
				INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
				INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_pegawai ON (t_hemodialisa.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				INNER JOIN m_jaminan ON (t_hemodialisa.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				LEFT JOIN m_pegawai m_pegawai1 ON (t_hemodialisa_tarif.PEGAWAI_ID = m_pegawai1.PEGAWAI_ID)
				LEFT JOIN m_pasien_pulang ON (t_hemodialisa.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
				WHERE t_hemodialisa_tarif.NO_TARIF IS NOT NULL AND t_hemodialisa_tarif.ST_BAYAR <> "Batal"
				AND t_hemodialisa.ST_BATAL IS NULL AND m_tarif.KODE_TARIF_GROUP NOT IN ("01","92")	 
				AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
				AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				GROUP BY DATE_FORMAT(t_hemodialisa_tarif.TGL_TARIF,"%d/%m/%Y"),m_pasien.NOMR,m_pasien.NAMA_PASIEN,
				m_pegawai.NAMA_PEGAWAI,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,
				m_jaminan.NAMA_JAMINAN,m_pegawai1.NAMA_PEGAWAI,
				DATE_FORMAT(t_hemodialisa.PASIEN_MASUK,"%d/%m/%Y %H:%i:%s"),
				DATE_FORMAT(t_hemodialisa.PASIEN_KELUAR,"%d/%m/%Y %H:%i:%s"),
				m_pasien_pulang.KET_PASIEN_PULANG
				) t_report
				GROUP BY TANGGAL,NOMR,NAMA_PASIEN,
				NAMA_PEGAWAI,NAMA_TARIF,NAMA_TARIF_GROUP,
				NAMA_JAMINAN,PELAKSANA,PASIEN_MASUK,PASIEN_KELUAR,KET_PASIEN_PULANG
				ORDER BY NAMA_PEGAWAI,NOMR,NAMA_TARIF_GROUP,NAMA_TARIF';
	
$extparam = '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2;
include('hemodialisa/hemodialisa_list_report_tindakan_dokter.php');
?>