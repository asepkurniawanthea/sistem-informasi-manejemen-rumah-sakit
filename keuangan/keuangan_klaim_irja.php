<?php
$tgl_1 = '';
if (isset($_SESSION['eklaimsearchirja_tgl_1']))
    $tgl_1 = $_SESSION['eklaimsearchirja_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['eklaimsearchirja_tgl_1']))
    $tgl_2 = $_SESSION['eklaimsearchirja_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['eklaimsearchirja_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['eklaimsearchirja_tgl_2'] = $_GET['tgl_2'];
}

$nomr = '';
if (isset($_SESSION['eklaimsearchirja_nomr']))
		$nomr = $_SESSION['eklaimsearchirja_nomr'];

if (isset($_GET['nomr'])) {
    $nomr = $_GET['nomr'];
	$_SESSION['eklaimsearchirja_nomr'] = $nomr;
}
$unit_id = '';
if (isset($_SESSION['eklaimsearchirja_unit_id']))
		$unit_id = $_SESSION['eklaimsearchirja_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['eklaimsearchirja_unit_id'] = $unit_id;
}
$jaminan_id = '';
if (isset($_SESSION['eklaimsearchirja_jaminan_id']))
		$jaminan_id = $_SESSION['eklaimsearchirja_jaminan_id'];

if (isset($_GET['jaminan_id'])) {
    $jaminan_id = $_GET['jaminan_id'];
	$_SESSION['eklaimsearchirja_jaminan_id'] = $jaminan_id;
}
$nosep = '';
if (isset($_SESSION['eklaimsearchirja_nosep']))
		$nosep = $_SESSION['eklaimsearchirja_nosep'];

if (isset($_GET['nosep'])) {
    $nosep = $_GET['nosep'];
	$_SESSION['eklaimsearchirja_nosep'] = $nosep;
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
   <table class="tableform" border="0" >
        <tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td>Jenis Pembayaran</td>
			<td> <select name="jaminan_id" id="jaminan_id" class="text_dt" style="width:228px;">
                    <option value=""> - </option>
                    <?php echo getJnsBayar($jaminan_id,''); ?>
                </select></td>	
			<td>Nomor MR/ Nama Pasien</td>
            <td colspan="2"><input type="text" name="nomr" id="nomr" value="<?php echo $nomr; ?>" class="text_dt"/></td>
			<td width="80px">&nbsp;</td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>            </td>	
			<td>Klinik</td>
			<td><select name="unit_id" id="unit_id" class="text_dt" style="width:228px;">
			<option value=""> - </option>
			<?php echo getUnit('irja',$unit_id); ?>
            </select></td>	
			<td>Nomor SEP</td>
			<td><input type="text" name="nosep" id="nosep" value="<?php echo $nosep; ?>" class="text_dt" /></td>
            <td align="right"><input name="submit" type="submit" class="myButton" value="cari" />&nbsp;
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" />
			</td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$qry_klaim = 'SELECT DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") AS TANGGAL_MASUK,
	DATE_FORMAT(t_irja.PASIEN_KELUAR,"%Y-%m-%d") AS TANGGAL_KELUAR,
	CASE WHEN t_irja.JENIS_BAYAR_ID = 12 THEN t_irja.NO_SEP ELSE t_irja.NO_SJP END AS NO_SEP,
	t_irja.NOMR,m_pasien.NAMA_PASIEN,m_unit.NAMA_UNIT,m_pegawai.NAMA_PEGAWAI,m_jaminan.NAMA_JAMINAN,
	t_cbg_claim.DIAGNOSA,t_cbg_claim.TARIF_RS,t_cbg_claim.TARIF_CBG_KELAS_3,t_cbg_claim.KLAIM_FINAL,
	x_irj.IRJA_ID,t_irja.NO_PESERTA,t_irja.JENIS_BAYAR_ID,x_irj.JML_PELAYANAN
	FROM 
		(SELECT MIN(irj.IRJA_ID) AS IRJA_ID, COUNT(irj.IRJA_ID) AS JML_PELAYANAN,
		irj.TANGGAL_DAFTAR,irj.NOMR,irj.JENIS_BAYAR_ID 
		FROM t_irja irj 
		WHERE irj.NO_PENDAFTARAN IS NOT NULL AND irj.ST_BATAL IS NULL 
		AND irj.IRJA_ID NOT IN (SELECT t_irna.IRNA_ID FROM t_irna WHERE t_irna.NOMR = irj.NOMR)
		AND irj.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND irj.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
		GROUP BY irj.TANGGAL_DAFTAR,irj.NOMR,irj.JENIS_BAYAR_ID)
	x_irj
	INNER JOIN t_irja ON (x_irj.IRJA_ID = t_irja.IRJA_ID)
	INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
	INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
	INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
	INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
	LEFT JOIN t_cbg_claim ON (x_irj.IRJA_ID = t_cbg_claim.RAWAT_ID AND t_cbg_claim.JNS_RAWAT = 2)
	WHERE 1';
	
if(!empty($nomr)){
	$nomr = str_replace(' ', '%', $nomr);
	$qry_klaim = $qry_klaim . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $nomr . '%"';
}	
if (!empty($unit_id)) {
    $qry_klaim = $qry_klaim . ' AND t_irja.UNIT_ID = "' . $unit_id . '"';
}
if (!empty($jaminan_id)) {
    $qry_klaim = $qry_klaim . ' AND t_irja.JENIS_BAYAR_ID = "' . $jaminan_id . '"';
}
if (!empty($nosep)) {
    $qry_klaim = $qry_klaim . ' AND t_irja.NO_SEP = "' . $nosep . '"';
}
$qry_klaim = $qry_klaim . ' ORDER BY m_pasien.NAMA_PASIEN,m_pasien.NOMR';

$extparam = '&nomr=' . $nomr . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_id=' . $unit_id . '&jaminan_id=' . $jaminan_id . '&nosep=' . $nosep;
$action = '';		
include('keuangan/keuangan_klaim_list_irja.php');
?>