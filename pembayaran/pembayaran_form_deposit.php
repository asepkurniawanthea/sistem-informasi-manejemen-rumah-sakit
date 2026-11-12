<?php
$tgl_1 = '';
if (isset($_SESSION['pembayaransearchdeposit_tgl_1']))
    $tgl_1 = $_SESSION['pembayaransearchdeposit_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['pembayaransearchdeposit_tgl_1']))
    $tgl_2 = $_SESSION['pembayaransearchdeposit_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['pembayaransearchdeposit_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['pembayaransearchdeposit_tgl_2'] = $_GET['tgl_2'];
}

$searchkey = '';
if (isset($_SESSION['pembayaransearchdeposit_searchkey']))
		$searchkey = $_SESSION['pembayaransearchdeposit_searchkey'];

if (isset($_GET['searchkey'])) {
    $searchkey = $_GET['searchkey'];
	$_SESSION['pembayaransearchdeposit_searchkey'] = $searchkey;
}
$unit_id = '';
if (isset($_SESSION['pembayaransearchdeposit_unit_id']))
		$unit_id = $_SESSION['pembayaransearchdeposit_unit_id'];

if (isset($_GET['unit_id'])) {
    $unit_id = $_GET['unit_id'];
	$_SESSION['pembayaransearchdeposit_unit_id'] = $unit_id;
}
$ruang_id = '';
if (isset($_SESSION['pembayaransearchdeposit_ruang_id']))
		$ruang_id = $_SESSION['pembayaransearchdeposit_ruang_id'];

if (isset($_GET['ruang_id'])) {
    $ruang_id = $_GET['ruang_id'];
	$_SESSION['pembayaransearchdeposit_ruang_id'] = $ruang_id;
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
			<td>IGD</td>
			<td><select name="unit_id" id="unit_id" class="text_dt" style="width:228px;">
			<option value=""> - </option>
			<?php echo getUnit('igd',$unit_id); ?>
            </select></td>	
			<td>Nomor MR/ Nama Pasien</td>
            <td><input type="text" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" class="text_dt"/></td>
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>
            </td>	
			<td>Ruang</td>
			<td><select name="ruang_id" id="ruang_id" class="text_dt" style="width:228px;">
			<option value=""> - </option>
			<?php echo getRuangRawat($ruang_id); ?>
            </select></td>	
			<td>&nbsp;</td>
            <td align="right"><input type="submit" value="cari" class="myButton" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
	<input type="hidden" name="kasir" value="<?php echo $kasir; ?>" />
</form>
<br />
<?php
$arr_igd = '0,';
foreach(getArrUnitIGD() as $row){
	$arr_igd .= $row . ','; 
}
$arr_igd = substr($arr_igd,0,strlen($arr_igd) - 1);	

$arr_bayar = '0,';
foreach(getArrNonJaminan() as $row){
	$arr_bayar .= $row . ','; 
}

$arr_bayar = substr($arr_bayar,0,strlen($arr_bayar) - 1);	
$qry_kunjungan = 'SELECT * FROM (
					SELECT t_irja.IRJA_ID AS RAWAT_ID, 
					DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_DAFTAR,
					t_irja.NOMR,m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
					m_pasien.ALAMAT,m_unit.NAMA_UNIT,
					m_jaminan.NAMA_JAMINAN,
					t_irja.UNIT_ID, NULL AS RUANG_ID, NULL AS KELAS,
					DATE_FORMAT(t_irja.PASIEN_KELUAR,"%d/%m/%Y %H:%i") AS PASIEN_KELUAR
					FROM t_irja
					INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR) 
					INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
					LEFT JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					LEFT JOIN t_irna ON (t_irja.IRJA_ID = t_irna.IRNA_ID
						AND t_irna.NO_PENDAFTARAN IS NOT NULL
						AND t_irna.ST_BATAL IS NULL
						AND t_irna.PASIEN_MASUK IS NOT NULL)
					WHERE t_irja.NO_PENDAFTARAN IS NOT NULL 
					AND t_irja.ST_BATAL IS NULL	
					AND t_irja.UNIT_ID IN (' . $arr_igd . ')
					AND t_irja.JENIS_BAYAR_ID IN (' . $arr_bayar . ')
					AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' 
					AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
					' . (($searchkey != '') ? 'AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"' : '') . '
					AND t_irna.IRNA_ID IS NULL
					UNION ALL
					SELECT t_irna.IRNA_ID AS RAWAT_ID, 
					DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_DAFTAR,
					t_irna.NOMR,m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
					m_pasien.ALAMAT,m_ruang.NAMA_RUANG AS NAMA_UNIT,
					m_jaminan.NAMA_JAMINAN,
					NULL AS UNIT_ID,t_irna.RUANG_ID,m_ruang.KELAS_RAWAT AS KELAS,
					DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d/%m/%Y %H:%i") AS PASIEN_KELUAR
					FROM t_irna
					INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR) 
					INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
					LEFT JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE t_irna.NO_PENDAFTARAN IS NOT NULL
					AND t_irna.ST_BATAL IS NULL
					AND t_irna.PASIEN_MASUK IS NOT NULL
					AND t_irna.JENIS_BAYAR_ID IN (' . $arr_bayar . ')
					AND ((t_irna.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . '
					AND t_irna.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . ')
					OR t_irna.ST_PULANG IS NULL)
					' . (($searchkey != '') ? 'AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"' : '') . '
				) t_daftar 
				WHERE 1
				ORDER BY NAMA_PASIEN,RAWAT_ID';
			
$extparam = '&searchkey=' . $searchkey . '&tgl_1=' . $tgl_1 . '&tgl_2=' . $tgl_2 . '&unit_id=' . $unit_id . '&ruang_id=' . $ruang_id;
include('pembayaran/pembayaran_list_form_deposit.php');
?>