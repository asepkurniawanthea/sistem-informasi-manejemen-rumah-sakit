<?php
$generik = '1';
$group = '';
$nama = '';
$tanggal = '';
$obat_alkes = '1'; 
$depo = '20';

if (isset($_SESSION['farmasisearchpersediaanobat_generik']))
    $generik = $_SESSION['farmasisearchpersediaanobat_generik'];
if (isset($_SESSION['farmasisearchpersediaanobat_group']))
    $group = $_SESSION['farmasisearchpersediaanobat_group'];
if (isset($_SESSION['farmasisearchpersediaanobat_tanggal']))
    $tanggal = $_SESSION['farmasisearchpersediaanobat_tanggal'];	
if (isset($_SESSION['farmasisearchpersediaanobat_nama']))
    $nama = $_SESSION['farmasisearchpersediaanobat_nama'];		
if (isset($_SESSION['farmasisearchpersediaanobat_obat_alkes']))
    $obat_alkes = $_SESSION['farmasisearchpersediaanobat_obat_alkes'];			
if (isset($_SESSION['farmasisearchpersediaanobat_depo']))
    $depo = $_SESSION['farmasisearchpersediaanobat_depo'];		

if (isset($_GET['depo'])){
    $depo = $_GET['depo'];
	$_SESSION['farmasisearchpersediaanobat_depo'] = $_GET['depo'];
}	
if (isset($_GET['group'])){
    $group = $_GET['group'];
	$_SESSION['farmasisearchpersediaanobat_group'] = $_GET['group'];
}	
if (isset($_GET['tanggal'])){
    $tanggal = $_GET['tanggal'];
	$_SESSION['farmasisearchpersediaanobat_tanggal'] = $_GET['tanggal'];
}	
if (isset($_GET['nama'])){
    $nama = $_GET['nama'];
	$_SESSION['farmasisearchpersediaanobat_nama'] = $_GET['nama'];
}	
if (isset($_GET['obat_alkes'])){
    $obat_alkes = $_GET['obat_alkes'];
	$_SESSION['farmasisearchpersediaanobat_obat_alkes'] = $_GET['obat_alkes'];
}	

$tgl_filter = $tanggal;
if (empty($tanggal)) {
    $tgl_filter = getDateSkr();
}

$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());

?>
<form name="search" method="get" action="index.php">
   <table class="tableform" border="0" >
        <tr>
            <td>Depo</td>
            <td><select name="depo" id="depo" class="text_dt">
					<option value="20" <?php if($depo == '20') echo 'selected="selected"'; ?>>Depo Rawat Jalan</option>
					<option value="21" <?php if($depo == '21') echo 'selected="selected"'; ?>>Depo Kusta</option>
					<option value="22" <?php if($depo == '22') echo 'selected="selected"'; ?>>Depo IGD</option>
                </select>
            </td>
			<td colspan="2"><input type="radio" name="obat_alkes" value="1" <?php if ($obat_alkes == '1') echo 'checked="checked"'; ?> />&nbsp;Persediaan Obat
                &nbsp;<input type="radio" name="obat_alkes" value="2" <?php if ($obat_alkes == '2') echo 'checked="checked"'; ?> />&nbsp;Persediaan Alkes</td>
        </tr>
		<tr>
            <td>Tanggal</td>
            <td><input type="text" name="tanggal" id="tgl_1" value="<?php echo $tanggal; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/>
            </td>
			<td>Group</td>
            <td><select name="group" id="group" class="text_dt">
                    <option value=""> - </option>
                    <?php $sql = 'SELECT m_persediaan_group.PERSEDIAAN_GROUP_ID,m_persediaan_group.PERSEDIAAN_GROUP
								FROM m_persediaan_group
								WHERE m_persediaan_group.FARMASI = "1"';
						$get = mysql_query($sql) or die(mysql_error());	
						while($dat = mysql_fetch_array($get)){
							?>
								<option value="<?php echo $dat['PERSEDIAAN_GROUP_ID']; ?>" <?php if($dat['PERSEDIAAN_GROUP_ID'] == $group) echo 'selected="selected"'; ?> ><?php echo $dat['PERSEDIAAN_GROUP']; ?></option>
							<?php
						}	
					?>
                </select></td>
        </tr>
		<tr>
			<td>Nama Persediaan</td>	
            <td><input type="text" name="nama" value="<?php echo $nama; ?>" size="18" class="text_dt" /></td>
			<td colspan="2"><input type="radio" name="generik" value="1" <?php if ($generik == '1') echo 'checked="checked"'; ?> />&nbsp;Generik
                &nbsp;<input type="radio" name="generik" value="2" <?php if ($generik == '2') echo 'checked="checked"'; ?> />&nbsp;Non Generik</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
			
        	<td colspan="2" align="right"><input type="submit" value="Cari" class="myButton" />
			<input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" /></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>
<br />
<?php
$sql_date = 'SELECT DATE_FORMAT(DATE_ADD(' . fieldDate($tgl_filter) . ',INTERVAL -1 DAY),"%d/%m/%Y") AS TGL_KEMARIN';
$get_date = mysql_query($sql_date) or die(mysql_error());
$dat_date = mysql_fetch_assoc($get_date);
$tgl_kemarin = $dat_date['TGL_KEMARIN'];

$obat_alkes_filter = '';
if ($obat_alkes == '1') {
    $obat_alkes_filter = 'AND m_persediaan_farmasi.ALKES IS NULL';
} else {
    $obat_alkes_filter = 'AND m_persediaan_farmasi.ALKES = "1"';
}

$generik_filter = '';
if($obat_alkes == '1'){
	if ($generik == '1') {
		$generik_filter = 'AND m_persediaan_farmasi.GENERIK = "1"';
	} else {
		$generik_filter = 'AND m_persediaan_farmasi.GENERIK IS NULL';
	}
}

$group_filter = '';
if (!empty($group)) {
    $group_filter = 'AND m_persediaan_group.PERSEDIAAN_GROUP_ID = "' . $group . '"';
}

$nama_filter = '';
if (!empty($nama)) {
    $nama_filter = 'AND m_persediaan_farmasi.NAMA_PERSEDIAAN LIKE "%' . $nama . '%"';
}

$qry_persediaan = 'SELECT MAX(stok_table.TNDA) AS TNDA,m_persediaan_group.PERSEDIAAN_GROUP_ID,m_persediaan_group.PERSEDIAAN_GROUP,
						m_persediaan_farmasi.PERSEDIAAN_ID,m_persediaan_farmasi.NAMA_PERSEDIAAN,
						m_persediaan_farmasi.SATUAN,m_persediaan_farmasi.ALKES,m_persediaan_farmasi.GENERIK,
						SUM(stok_table.JUMLAH_SALDO_AWAL * stok_table.HARGA_BELI_SALDO_AWAL)
							/ SUM(stok_table.JUMLAH_SALDO_AWAL) AS HARGA_BELI_SALDO_AWAL,
						SUM(stok_table.JUMLAH_SALDO_AWAL * stok_table.HARGA_JUAL_SALDO_AWAL)
							/ SUM(stok_table.JUMLAH_SALDO_AWAL) AS HARGA_JUAL_SALDO_AWAL,
						SUM(stok_table.JUMLAH_SALDO_AWAL) AS JUMLAH_SALDO_AWAL,
						
						SUM((stok_table.JUMLAH_PENERIMAAN_MUTASI * stok_table.HARGA_BELI_PENERIMAAN_MUTASI)
							+ (stok_table.JUMLAH_PENGEMBALIAN_RESEP_MUTASI * stok_table.HARGA_BELI_PENGEMBALIAN_RESEP_MUTASI)
							+ (stok_table.JUMLAH_PENGIRIMAN_TERIMA_MUTASI * stok_table.HARGA_BELI_PENGIRIMAN_TERIMA_MUTASI))
							/ SUM(stok_table.JUMLAH_PENERIMAAN_MUTASI + stok_table.JUMLAH_PENGEMBALIAN_RESEP_MUTASI
								+ stok_table.JUMLAH_PENGIRIMAN_TERIMA_MUTASI) AS HARGA_BELI_PENERIMAAN,
						SUM((stok_table.JUMLAH_PENERIMAAN_MUTASI * stok_table.HARGA_JUAL_PENERIMAAN_MUTASI)
							+ (stok_table.JUMLAH_PENGEMBALIAN_RESEP_MUTASI * stok_table.HARGA_JUAL_PENGEMBALIAN_RESEP_MUTASI)
							+ (stok_table.JUMLAH_PENGIRIMAN_TERIMA_MUTASI * stok_table.HARGA_JUAL_PENGIRIMAN_TERIMA_MUTASI))
							/ SUM(stok_table.JUMLAH_PENERIMAAN_MUTASI + stok_table.JUMLAH_PENGEMBALIAN_RESEP_MUTASI
								+ stok_table.JUMLAH_PENGIRIMAN_TERIMA_MUTASI) AS HARGA_JUAL_PENERIMAAN,
						SUM(stok_table.JUMLAH_PENERIMAAN_MUTASI + stok_table.JUMLAH_PENGEMBALIAN_RESEP_MUTASI
							+ stok_table.JUMLAH_PENGIRIMAN_TERIMA_MUTASI) AS JUMLAH_PENERIMAAN,
						
						SUM((stok_table.JUMLAH_PENGELUARAN_MUTASI * stok_table.HARGA_BELI_PENGELUARAN_MUTASI)
							+ (stok_table.JUMLAH_PENGEMBALIAN_MUTASI * stok_table.HARGA_BELI_PENGEMBALIAN_MUTASI)
							+ (stok_table.JUMLAH_PENGIRIMAN_MUTASI * stok_table.HARGA_BELI_PENGIRIMAN_MUTASI))
							/ SUM(stok_table.JUMLAH_PENGELUARAN_MUTASI + stok_table.JUMLAH_PENGEMBALIAN_MUTASI
								+ stok_table.JUMLAH_PENGIRIMAN_MUTASI) AS HARGA_BELI_PENGELUARAN,
						SUM((stok_table.JUMLAH_PENGELUARAN_MUTASI * stok_table.HARGA_JUAL_PENGELUARAN_MUTASI)
							+ (stok_table.JUMLAH_PENGEMBALIAN_MUTASI * stok_table.HARGA_JUAL_PENGEMBALIAN_MUTASI)
							+ (stok_table.JUMLAH_PENGIRIMAN_MUTASI * stok_table.HARGA_JUAL_PENGIRIMAN_MUTASI))
							/ SUM(stok_table.JUMLAH_PENGELUARAN_MUTASI + stok_table.JUMLAH_PENGEMBALIAN_MUTASI
								+ stok_table.JUMLAH_PENGIRIMAN_MUTASI) AS HARGA_JUAL_PENGELUARAN,
						SUM(stok_table.JUMLAH_PENGELUARAN_MUTASI + stok_table.JUMLAH_PENGEMBALIAN_MUTASI
								+ stok_table.JUMLAH_PENGIRIMAN_MUTASI) AS JUMLAH_PENGELUARAN,
						
						SUM(stok_table.JUMLAH_SALDO_AKHIR * stok_table.HARGA_BELI_SALDO_AKHIR)
							/ SUM(stok_table.JUMLAH_SALDO_AKHIR) AS HARGA_BELI_SALDO_AKHIR,
						SUM(stok_table.JUMLAH_SALDO_AKHIR * stok_table.HARGA_JUAL_SALDO_AKHIR)
							/ SUM(stok_table.JUMLAH_SALDO_AKHIR) AS HARGA_JUAL_SALDO_AKHIR,
						SUM(stok_table.JUMLAH_SALDO_AKHIR) AS JUMLAH_SALDO_AKHIR
						
				FROM m_persediaan_farmasi
				INNER JOIN m_persediaan_group ON (m_persediaan_farmasi.PERSEDIAAN_GROUP_ID = m_persediaan_group.PERSEDIAAN_GROUP_ID)	
				INNER JOIN (
SELECT CASE WHEN SUM(t_farmasi_apotik_stokopname_harian.STOK) < 0 THEN 1 ELSE 0 END AS TNDA,
		m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_farmasi_detail.PERSEDIAAN_ID,	
		m_persediaan_farmasi_detail.HARGA_BELI AS HARGA_BELI_SALDO_AWAL,
		t_farmasi_apotik_stokopname_harian.HARGA_JUAL AS HARGA_JUAL_SALDO_AWAL,
		SUM(t_farmasi_apotik_stokopname_harian.STOK) AS JUMLAH_SALDO_AWAL,
		0 AS HARGA_BELI_PENERIMAAN_MUTASI,
		0 AS HARGA_JUAL_PENERIMAAN_MUTASI,
		0 AS JUMLAH_PENERIMAAN_MUTASI,
		0 AS HARGA_BELI_PENGEMBALIAN_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_MUTASI,
		0 AS JUMLAH_PENGEMBALIAN_MUTASI,
		0 AS HARGA_BELI_PENGEMBALIAN_RESEP_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_RESEP_MUTASI,
		0 AS JUMLAH_PENGEMBALIAN_RESEP_MUTASI,
		0 AS HARGA_BELI_PENGELUARAN_MUTASI,
		0 AS HARGA_JUAL_PENGELUARAN_MUTASI,
		0 AS JUMLAH_PENGELUARAN_MUTASI,
		0 AS HARGA_BELI_PENGIRIMAN_MUTASI,
		0 AS HARGA_JUAL_PENGIRIMAN_MUTASI,
		0 AS JUMLAH_PENGIRIMAN_MUTASI,
		0 AS HARGA_BELI_PENGIRIMAN_TERIMA_MUTASI,
		0 AS HARGA_JUAL_PENGIRIMAN_TERIMA_MUTASI,
		0 AS JUMLAH_PENGIRIMAN_TERIMA_MUTASI,
		0 AS HARGA_BELI_SALDO_AKHIR,
		0 AS HARGA_JUAL_SALDO_AKHIR,
		0 AS JUMLAH_SALDO_AKHIR	
		FROM m_persediaan_farmasi_detail 
		INNER JOIN t_farmasi_apotik_stokopname_harian ON (m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID = t_farmasi_apotik_stokopname_harian.PERSEDIAAN_DETAIL_ID)
		WHERE DATE_FORMAT(t_farmasi_apotik_stokopname_harian.TANGGAL,"%d/%m/%Y") = "' . $tgl_kemarin . '"
		AND t_farmasi_apotik_stokopname_harian.UNIT_ID = "' . $depo . '"
		GROUP BY m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_farmasi_detail.PERSEDIAAN_ID,	
		m_persediaan_farmasi_detail.HARGA_BELI,
		t_farmasi_apotik_stokopname_harian.HARGA_JUAL
UNION
SELECT 0 AS TNDA,
		m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_farmasi_detail.PERSEDIAAN_ID,	
		0 AS HARGA_BELI_SALDO_AWAL,
		0 AS HARGA_JUAL_SALDO_AWAL,
		0 AS JUMLAH_SALDO_AWAL,
		m_persediaan_farmasi_detail.HARGA_BELI AS HARGA_BELI_PENERIMAAN_MUTASI,
		t_farmasi_pengeluaran_detail.HARGA_JUAL AS HARGA_JUAL_PENERIMAAN_MUTASI,
		SUM(t_farmasi_pengeluaran_detail.JUMLAH_KELUAR) AS JUMLAH_PENERIMAAN_MUTASI,
		0 AS HARGA_BELI_PENGEMBALIAN_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_MUTASI,
		0 AS JUMLAH_PENGEMBALIAN_MUTASI,
		0 AS HARGA_BELI_PENGEMBALIAN_RESEP_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_RESEP_MUTASI,
		0 AS JUMLAH_PENGEMBALIAN_RESEP_MUTASI,
		0 AS HARGA_BELI_PENGELUARAN_MUTASI,
		0 AS HARGA_JUAL_PENGELUARAN_MUTASI,
		0 AS JUMLAH_PENGELUARAN_MUTASI,
		0 AS HARGA_BELI_PENGIRIMAN_MUTASI,
		0 AS HARGA_JUAL_PENGIRIMAN_MUTASI,
		0 AS JUMLAH_PENGIRIMAN_MUTASI,
		0 AS HARGA_BELI_PENGIRIMAN_TERIMA_MUTASI,
		0 AS HARGA_JUAL_PENGIRIMAN_TERIMA_MUTASI,
		0 AS JUMLAH_PENGIRIMAN_TERIMA_MUTASI,
		0 AS HARGA_BELI_SALDO_AKHIR,
		0 AS HARGA_JUAL_SALDO_AKHIR,
		0 AS JUMLAH_SALDO_AKHIR			
		FROM m_persediaan_farmasi_detail
		INNER JOIN t_farmasi_pengeluaran_detail ON (m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID = t_farmasi_pengeluaran_detail.PERSEDIAAN_DETAIL_ID)
		INNER JOIN t_farmasi_pengeluaran ON (t_farmasi_pengeluaran_detail.FARMASI_PENGELUARAN_ID = t_farmasi_pengeluaran.FARMASI_PENGELUARAN_ID)	
		WHERE t_farmasi_pengeluaran.NO_PENGELUARAN IS NOT NULL
		AND t_farmasi_pengeluaran.UNIT_ID = "' . $depo . '"
		AND t_farmasi_pengeluaran.ST_PENGELUARAN IS NOT NULL 
		AND t_farmasi_pengeluaran.TANGGAL_KELUAR = ' . fieldDate($tgl_filter) . '
		GROUP BY m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_farmasi_detail.PERSEDIAAN_ID,	
		m_persediaan_farmasi_detail.HARGA_BELI,
		t_farmasi_pengeluaran_detail.HARGA_JUAL
UNION
SELECT 0 AS TNDA,
		m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_farmasi_detail.PERSEDIAAN_ID,	
		0 AS HARGA_BELI_SALDO_AWAL,
		0 AS HARGA_JUAL_SALDO_AWAL,
		0 AS JUMLAH_SALDO_AWAL,
		0 AS HARGA_BELI_PENERIMAAN_MUTASI,
		0 AS HARGA_JUAL_PENERIMAAN_MUTASI,
		0 AS JUMLAH_PENERIMAAN_MUTASI,
		m_persediaan_farmasi_detail.HARGA_BELI AS HARGA_BELI_PENGEMBALIAN_MUTASI,
		t_farmasi_pengembalian_detail.HARGA_JUAL AS HARGA_JUAL_PENGEMBALIAN_MUTASI,
		SUM(t_farmasi_pengembalian_detail.JUMLAH_KEMBALI) AS JUMLAH_PENGEMBALIAN_MUTASI,
		0 AS HARGA_BELI_PENGEMBALIAN_RESEP_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_RESEP_MUTASI,
		0 AS JUMLAH_PENGEMBALIAN_RESEP_MUTASI,
		0 AS HARGA_BELI_PENGELUARAN_MUTASI,
		0 AS HARGA_JUAL_PENGELUARAN_MUTASI,
		0 AS JUMLAH_PENGELUARAN_MUTASI,
		0 AS HARGA_BELI_PENGIRIMAN_MUTASI,
		0 AS HARGA_JUAL_PENGIRIMAN_MUTASI,
		0 AS JUMLAH_PENGIRIMAN_MUTASI,
		0 AS HARGA_BELI_PENGIRIMAN_TERIMA_MUTASI,
		0 AS HARGA_JUAL_PENGIRIMAN_TERIMA_MUTASI,
		0 AS JUMLAH_PENGIRIMAN_TERIMA_MUTASI,
		0 AS HARGA_BELI_SALDO_AKHIR,
		0 AS HARGA_JUAL_SALDO_AKHIR,
		0 AS JUMLAH_SALDO_AKHIR			
		FROM m_persediaan_farmasi_detail 
		INNER JOIN t_farmasi_pengembalian_detail ON (m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID = t_farmasi_pengembalian_detail.PERSEDIAAN_DETAIL_ID)
		INNER JOIN t_farmasi_pengembalian ON (t_farmasi_pengembalian_detail.FARMASI_PENGEMBALIAN_ID = t_farmasi_pengembalian.FARMASI_PENGEMBALIAN_ID)
		WHERE t_farmasi_pengembalian.NO_PENGEMBALIAN IS NOT NULL
		AND t_farmasi_pengembalian.ST_PENGEMBALIAN IS NOT NULL
		AND t_farmasi_pengembalian.UNIT_ID = "' . $depo . '"
		AND t_farmasi_pengembalian.TANGGAL_PENGEMBALIAN = ' . fieldDate($tgl_filter) . '
		GROUP BY m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_farmasi_detail.PERSEDIAAN_ID,
		m_persediaan_farmasi_detail.HARGA_BELI,
		t_farmasi_pengembalian_detail.HARGA_JUAL
UNION 
SELECT 0 AS TNDA,
		m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_farmasi_detail.PERSEDIAAN_ID,	
		0 AS HARGA_BELI_SALDO_AWAL,
		0 AS HARGA_JUAL_SALDO_AWAL,
		0 AS JUMLAH_SALDO_AWAL,
		0 AS HARGA_BELI_PENERIMAAN_MUTASI,
		0 AS HARGA_JUAL_PENERIMAAN_MUTASI,
		0 AS JUMLAH_PENERIMAAN_MUTASI,
		0 AS HARGA_BELI_PENGEMBALIAN_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_MUTASI,
		0 AS JUMLAH_PENGEMBALIAN_MUTASI,
		m_persediaan_farmasi_detail.HARGA_BELI AS HARGA_BELI_PENGEMBALIAN_RESEP_MUTASI,
		t_farmasi_apotik_pengembalian_resep_detail.HARGA_JUAL AS HARGA_JUAL_PENGEMBALIAN_RESEP_MUTASI,
		SUM(t_farmasi_apotik_pengembalian_resep_detail.JUMLAH_KEMBALI) AS JUMLAH_PENGEMBALIAN_RESEP_MUTASI,
		0 AS HARGA_BELI_PENGELUARAN_MUTASI,
		0 AS HARGA_JUAL_PENGELUARAN_MUTASI,
		0 AS JUMLAH_PENGELUARAN_MUTASI,
		0 AS HARGA_BELI_PENGIRIMAN_MUTASI,
		0 AS HARGA_JUAL_PENGIRIMAN_MUTASI,
		0 AS JUMLAH_PENGIRIMAN_MUTASI,
		0 AS HARGA_BELI_PENGIRIMAN_TERIMA_MUTASI,
		0 AS HARGA_JUAL_PENGIRIMAN_TERIMA_MUTASI,
		0 AS JUMLAH_PENGIRIMAN_TERIMA_MUTASI,
		0 AS HARGA_BELI_SALDO_AKHIR,
		0 AS HARGA_JUAL_SALDO_AKHIR,
		0 AS JUMLAH_SALDO_AKHIR			
		FROM m_persediaan_farmasi_detail 
		INNER JOIN t_farmasi_apotik_pengembalian_resep_detail ON (m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID = t_farmasi_apotik_pengembalian_resep_detail.PERSEDIAAN_DETAIL_ID)
		INNER JOIN t_farmasi_apotik_pengembalian_resep ON (t_farmasi_apotik_pengembalian_resep.FARMASI_PENGEMBALIAN_APOTIK_ID = t_farmasi_apotik_pengembalian_resep_detail.FARMASI_PENGEMBALIAN_ID)
		WHERE t_farmasi_apotik_pengembalian_resep.NO_PENGEMBALIAN IS NOT NULL
		AND t_farmasi_apotik_pengembalian_resep.UNIT_ID = "' . $depo . '"
		AND t_farmasi_apotik_pengembalian_resep.TANGGAL_KEMBALI = ' . fieldDate($tgl_filter) . '
		GROUP BY m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_farmasi_detail.PERSEDIAAN_ID,
		m_persediaan_farmasi_detail.HARGA_BELI,
		t_farmasi_apotik_pengembalian_resep_detail.HARGA_JUAL
UNION
SELECT 0 AS TNDA,
		m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_farmasi_detail.PERSEDIAAN_ID,	
		0 AS HARGA_BELI_SALDO_AWAL,
		0 AS HARGA_JUAL_SALDO_AWAL,
		0 AS JUMLAH_SALDO_AWAL,
		0 AS HARGA_BELI_PENERIMAAN_MUTASI,
		0 AS HARGA_JUAL_PENERIMAAN_MUTASI,
		0 AS JUMLAH_PENERIMAAN_MUTASI,
		0 AS HARGA_BELI_PENGEMBALIAN_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_MUTASI,
		0 AS JUMLAH_PENGEMBALIAN_MUTASI,
		0 AS HARGA_BELI_PENGEMBALIAN_RESEP_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_RESEP_MUTASI,
		0 AS JUMLAH_PENGEMBALIAN_RESEP_MUTASI,
		m_persediaan_farmasi_detail.HARGA_BELI AS HARGA_BELI_PENGELUARAN_MUTASI,
		t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL AS HARGA_JUAL_PENGELUARAN_MUTASI,
		SUM(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) AS JUMLAH_PENGELUARAN_MUTASI,
		0 AS HARGA_BELI_PENGIRIMAN_MUTASI,
		0 AS HARGA_JUAL_PENGIRIMAN_MUTASI,
		0 AS JUMLAH_PENGIRIMAN_MUTASI,
		0 AS HARGA_BELI_PENGIRIMAN_TERIMA_MUTASI,
		0 AS HARGA_JUAL_PENGIRIMAN_TERIMA_MUTASI,
		0 AS JUMLAH_PENGIRIMAN_TERIMA_MUTASI,
		0 AS HARGA_BELI_SALDO_AKHIR,
		0 AS HARGA_JUAL_SALDO_AKHIR,
		0 AS JUMLAH_SALDO_AKHIR		
		FROM m_persediaan_farmasi_detail 
		INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID = t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_DETAIL_ID)
		INNER JOIN t_farmasi_apotik_pengeluaran ON (t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID = t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID)
		WHERE t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
		AND t_farmasi_apotik_pengeluaran.UNIT_ID = "' . $depo . '"
		AND t_farmasi_apotik_pengeluaran.TANGGAL_KELUAR = ' . fieldDate($tgl_filter) . '
		GROUP BY m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_farmasi_detail.PERSEDIAAN_ID,	
		m_persediaan_farmasi_detail.HARGA_BELI,
		t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL	
UNION
SELECT 0 AS TNDA,
		m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_farmasi_detail.PERSEDIAAN_ID,	
		0 AS HARGA_BELI_SALDO_AWAL,
		0 AS HARGA_JUAL_SALDO_AWAL,
		0 AS JUMLAH_SALDO_AWAL,
		0 AS HARGA_BELI_PENERIMAAN_MUTASI,
		0 AS HARGA_JUAL_PENERIMAAN_MUTASI,
		0 AS JUMLAH_PENERIMAAN_MUTASI,
		0 AS HARGA_BELI_PENGEMBALIAN_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_MUTASI,
		0 AS JUMLAH_PENGEMBALIAN_MUTASI,
		0 AS HARGA_BELI_PENGEMBALIAN_RESEP_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_RESEP_MUTASI,
		0 AS JUMLAH_PENGEMBALIAN_RESEP_MUTASI,
		0 AS HARGA_BELI_PENGELUARAN_MUTASI,
		0 AS HARGA_JUAL_PENGELUARAN_MUTASI,
		0 AS JUMLAH_PENGELUARAN_MUTASI,
		m_persediaan_farmasi_detail.HARGA_BELI AS HARGA_BELI_PENGIRIMAN_MUTASI,
		t_farmasi_apotik_pengiriman_detail.HARGA_JUAL AS HARGA_JUAL_PENGIRIMAN_MUTASI,	
		SUM(t_farmasi_apotik_pengiriman_detail.JUMLAH_KIRIM) AS JUMLAH_PENGIRIMAN_MUTASI,
		0 AS HARGA_BELI_PENGIRIMAN_TERIMA_MUTASI,
		0 AS HARGA_JUAL_PENGIRIMAN_TERIMA_MUTASI,
		0 AS JUMLAH_PENGIRIMAN_TERIMA_MUTASI,
		0 AS HARGA_BELI_SALDO_AKHIR,
		0 AS HARGA_JUAL_SALDO_AKHIR,
		0 AS JUMLAH_SALDO_AKHIR		
		FROM m_persediaan_farmasi_detail
		INNER JOIN t_farmasi_apotik_pengiriman_detail ON (m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID = t_farmasi_apotik_pengiriman_detail.PERSEDIAAN_DETAIL_ID)
		INNER JOIN t_farmasi_apotik_pengiriman ON (t_farmasi_apotik_pengiriman.FARMASI_PENGIRIMAN_APOTIK_ID = t_farmasi_apotik_pengiriman_detail.FARMASI_PENGIRIMAN_APOTIK_ID)
		WHERE t_farmasi_apotik_pengiriman.NO_PENGIRIMAN IS NOT NULL
		AND t_farmasi_apotik_pengiriman.UNIT_PENGIRIM_ID = "' . $depo . '"
		AND t_farmasi_apotik_pengiriman.TANGGAL_KIRIM = ' . fieldDate($tgl_filter) . '
		GROUP BY m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_farmasi_detail.PERSEDIAAN_ID,	
		m_persediaan_farmasi_detail.HARGA_BELI,
		t_farmasi_apotik_pengiriman_detail.HARGA_JUAL		
UNION
SELECT 0 AS TNDA,
		m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_farmasi_detail.PERSEDIAAN_ID,	
		0 AS HARGA_BELI_SALDO_AWAL,
		0 AS HARGA_JUAL_SALDO_AWAL,
		0 AS JUMLAH_SALDO_AWAL,
		0 AS HARGA_BELI_PENERIMAAN_MUTASI,
		0 AS HARGA_JUAL_PENERIMAAN_MUTASI,
		0 AS JUMLAH_PENERIMAAN_MUTASI,
		0 AS HARGA_BELI_PENGEMBALIAN_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_MUTASI,
		0 AS JUMLAH_PENGEMBALIAN_MUTASI,
		0 AS HARGA_BELI_PENGEMBALIAN_RESEP_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_RESEP_MUTASI,
		0 AS JUMLAH_PENGEMBALIAN_RESEP_MUTASI,
		0 AS HARGA_BELI_PENGELUARAN_MUTASI,
		0 AS HARGA_JUAL_PENGELUARAN_MUTASI,
		0 AS JUMLAH_PENGELUARAN_MUTASI,
		0 AS HARGA_BELI_PENGIRIMAN_MUTASI,
		0 AS HARGA_JUAL_PENGIRIMAN_MUTASI,	
		0 AS JUMLAH_PENGIRIMAN_MUTASI,
		m_persediaan_farmasi_detail.HARGA_BELI AS HARGA_BELI_PENGIRIMAN_TERIMA_MUTASI,
		t_farmasi_apotik_pengiriman_detail.HARGA_JUAL AS HARGA_JUAL_PENGIRIMAN_TERIMA_MUTASI,
		SUM(t_farmasi_apotik_pengiriman_detail.JUMLAH_KIRIM) AS JUMLAH_PENGIRIMAN_TERIMA_MUTASI,
		0 AS HARGA_BELI_SALDO_AKHIR,
		0 AS HARGA_JUAL_SALDO_AKHIR,
		0 AS JUMLAH_SALDO_AKHIR		
		FROM m_persediaan_farmasi_detail
		INNER JOIN t_farmasi_apotik_pengiriman_detail ON (m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID = t_farmasi_apotik_pengiriman_detail.PERSEDIAAN_DETAIL_ID)
		INNER JOIN t_farmasi_apotik_pengiriman ON (t_farmasi_apotik_pengiriman.FARMASI_PENGIRIMAN_APOTIK_ID = t_farmasi_apotik_pengiriman_detail.FARMASI_PENGIRIMAN_APOTIK_ID)
		WHERE t_farmasi_apotik_pengiriman.NO_PENGIRIMAN IS NOT NULL
		AND t_farmasi_apotik_pengiriman.ST_TERIMA IS NOT NULL
		AND t_farmasi_apotik_pengiriman.UNIT_PENERIMA_ID = "' . $depo . '"
		AND t_farmasi_apotik_pengiriman.TANGGAL_TERIMA = ' . fieldDate($tgl_filter) . '
		GROUP BY m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_farmasi_detail.PERSEDIAAN_ID,	
		m_persediaan_farmasi_detail.HARGA_BELI,
		t_farmasi_apotik_pengiriman_detail.HARGA_JUAL
UNION
SELECT CASE WHEN SUM(t_farmasi_apotik_stokopname_harian.STOK) < 0 THEN 1 ELSE 0 END AS TNDA,
		m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_farmasi_detail.PERSEDIAAN_ID,	
		0 AS HARGA_BELI_SALDO_AWAL,
		0 AS HARGA_JUAL_SALDO_AWAL,
		0 AS JUMLAH_SALDO_AWAL,
		0 AS HARGA_BELI_PENERIMAAN_MUTASI,
		0 AS HARGA_JUAL_PENERIMAAN_MUTASI,
		0 AS JUMLAH_PENERIMAAN_MUTASI,
		0 AS HARGA_BELI_PENGEMBALIAN_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_MUTASI,
		0 AS JUMLAH_PENGEMBALIAN_MUTASI,
		0 AS HARGA_BELI_PENGEMBALIAN_RESEP_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_RESEP_MUTASI,
		0 AS JUMLAH_PENGEMBALIAN_RESEP_MUTASI,
		0 AS HARGA_BELI_PENGELUARAN_MUTASI,
		0 AS HARGA_JUAL_PENGELUARAN_MUTASI,
		0 AS JUMLAH_PENGELUARAN_MUTASI,
		0 AS HARGA_BELI_PENGIRIMAN_MUTASI,
		0 AS HARGA_JUAL_PENGIRIMAN_MUTASI,	
		0 AS JUMLAH_PENGIRIMAN_MUTASI,
		0 AS HARGA_BELI_PENGIRIMAN_TERIMA_MUTASI,
		0 AS HARGA_JUAL_PENGIRIMAN_TERIMA_MUTASI,
		0 AS JUMLAH_PENGIRIMAN_TERIMA_MUTASI,
		m_persediaan_farmasi_detail.HARGA_BELI AS HARGA_BELI_SALDO_AKHIR,
		t_farmasi_apotik_stokopname_harian.HARGA_JUAL AS HARGA_JUAL_SALDO_AKHIR,
		SUM(t_farmasi_apotik_stokopname_harian.STOK) AS JUMLAH_SALDO_AKHIR
		FROM m_persediaan_farmasi_detail
		INNER JOIN t_farmasi_apotik_stokopname_harian ON (m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID = t_farmasi_apotik_stokopname_harian.PERSEDIAAN_DETAIL_ID)  
		WHERE DATE_FORMAT(t_farmasi_apotik_stokopname_harian.TANGGAL,"%d/%m/%Y") = "' . $tgl_filter . '"
		GROUP BY m_persediaan_farmasi_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_farmasi_detail.PERSEDIAAN_ID,		
		m_persediaan_farmasi_detail.HARGA_BELI,
		t_farmasi_apotik_stokopname_harian.HARGA_JUAL		
) stok_table 
ON (m_persediaan_farmasi.PERSEDIAAN_ID = stok_table.PERSEDIAAN_ID)
WHERE (m_persediaan_farmasi.TIDAK_AKTIF IS NULL OR m_persediaan_farmasi.TIDAK_AKTIF IS NULL = "") 
		' . $obat_alkes_filter . ' ' . $generik_filter . ' ' . $group_filter . ' ' . $nama_filter . '
GROUP BY m_persediaan_group.PERSEDIAAN_GROUP_ID,m_persediaan_group.PERSEDIAAN_GROUP,
		m_persediaan_farmasi.PERSEDIAAN_ID,m_persediaan_farmasi.NAMA_PERSEDIAAN,
		m_persediaan_farmasi.SATUAN,m_persediaan_farmasi.ALKES,m_persediaan_farmasi.GENERIK
ORDER BY m_persediaan_group.PERSEDIAAN_GROUP_ID,m_persediaan_farmasi.NAMA_PERSEDIAAN';

$extparam = '&group=' . $group . '&tanggal=' . $tanggal. '&depo=' . $depo . '&generik=' . $generik . '&nama=' . $nama . '&obat_alkes=' . $obat_alkes;
$action = '';
include('keuangan/keuangan_list_persediaan_depo_farmasi.php');
?>
