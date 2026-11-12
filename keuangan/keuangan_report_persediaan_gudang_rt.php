<?php
$group = '';
$nama = '';
$tanggal = '';

if (isset($_SESSION['gudangsearchpersediaan_group']))
    $group = $_SESSION['gudangsearchpersediaan_group'];
if (isset($_SESSION['gudangsearchpersediaan_tanggal']))
    $tanggal = $_SESSION['gudangsearchpersediaan_tanggal'];	
if (isset($_SESSION['gudangsearchpersediaan_nama']))
    $nama = $_SESSION['gudangsearchpersediaan_nama'];		

if (isset($_GET['group'])){
    $group = $_GET['group'];
	$_SESSION['gudangsearchpersediaan_group'] = $_GET['group'];
}	
if (isset($_GET['tanggal'])){
    $tanggal = $_GET['tanggal'];
	$_SESSION['gudangsearchpersediaan_tanggal'] = $_GET['tanggal'];
}	
if (isset($_GET['nama'])){
    $nama = $_GET['nama'];
	$_SESSION['gudangsearchpersediaan_nama'] = $_GET['nama'];
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
            <td>Tanggal</td>
            <td><input type="text" name="tanggal" id="tgl_1" value="<?php echo $tanggal; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/>
            </td>
			<td>Group</td>
            <td><select name="group" id="group" class="text_dt" >
                    <option value=""> - </option>
                    <?php $sql = 'SELECT m_persediaan_group.PERSEDIAAN_GROUP_ID,m_persediaan_group.PERSEDIAAN_GROUP
								FROM m_persediaan_group
								WHERE m_persediaan_group.GUDANG = "1"';
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
			<td colspan="2">&nbsp;</td>
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

$group_filter = '';
if (!empty($group)) {
    $group_filter = 'AND m_persediaan_group.PERSEDIAAN_GROUP_ID = "' . $group . '"';
}

$nama_filter = '';
if (!empty($nama)) {
    $nama_filter = 'AND m_persediaan_gudang.NAMA_PERSEDIAAN LIKE "%' . $nama . '%"';
}
$qry_persediaan = 'SELECT MAX(stok_table.TNDA) AS TNDA,m_persediaan_group.PERSEDIAAN_GROUP_ID,m_persediaan_group.PERSEDIAAN_GROUP,
						m_persediaan_gudang.PERSEDIAAN_ID,m_persediaan_gudang.NAMA_PERSEDIAAN,
						m_persediaan_gudang.SATUAN,
						SUM(stok_table.JUMLAH_SALDO_AWAL * stok_table.HARGA_BELI_SALDO_AWAL)
							/ SUM(stok_table.JUMLAH_SALDO_AWAL) AS HARGA_BELI_SALDO_AWAL,
						SUM(stok_table.JUMLAH_SALDO_AWAL * stok_table.HARGA_JUAL_SALDO_AWAL)
							/ SUM(stok_table.JUMLAH_SALDO_AWAL) AS HARGA_JUAL_SALDO_AWAL,
						SUM(stok_table.JUMLAH_SALDO_AWAL) AS JUMLAH_SALDO_AWAL,
						
						SUM((stok_table.JUMLAH_PENERIMAAN_MUTASI * stok_table.HARGA_BELI_PENERIMAAN_MUTASI)
							+ (stok_table.JUMLAH_PENGEMBALIAN_MUTASI * stok_table.HARGA_BELI_PENGEMBALIAN_MUTASI))
							/ SUM(stok_table.JUMLAH_PENERIMAAN_MUTASI + stok_table.JUMLAH_PENGEMBALIAN_MUTASI) AS HARGA_BELI_PENERIMAAN,
						SUM((stok_table.JUMLAH_PENERIMAAN_MUTASI * stok_table.HARGA_JUAL_PENERIMAAN_MUTASI)
							+ (stok_table.JUMLAH_PENGEMBALIAN_MUTASI * stok_table.HARGA_JUAL_PENGEMBALIAN_MUTASI))
							/ SUM(stok_table.JUMLAH_PENERIMAAN_MUTASI + stok_table.JUMLAH_PENGEMBALIAN_MUTASI) AS HARGA_JUAL_PENERIMAAN,
						SUM(stok_table.JUMLAH_PENERIMAAN_MUTASI + stok_table.JUMLAH_PENGEMBALIAN_MUTASI) AS JUMLAH_PENERIMAAN,
						
						SUM((stok_table.JUMLAH_PENGELUARAN_MUTASI * stok_table.HARGA_BELI_PENGELUARAN_MUTASI)
							+ (stok_table.JUMLAH_PENGEMBALIAN_SUPLIER_MUTASI * stok_table.HARGA_BELI_PENGEMBALIAN_SUPLIER_MUTASI))
							/ SUM(stok_table.JUMLAH_PENGELUARAN_MUTASI + stok_table.JUMLAH_PENGEMBALIAN_SUPLIER_MUTASI) AS HARGA_BELI_PENGELUARAN,
						SUM((stok_table.JUMLAH_PENGELUARAN_MUTASI * stok_table.HARGA_JUAL_PENGELUARAN_MUTASI)
							+ (stok_table.JUMLAH_PENGEMBALIAN_SUPLIER_MUTASI * stok_table.HARGA_JUAL_PENGEMBALIAN_SUPLIER_MUTASI))
							/ SUM(stok_table.JUMLAH_PENGELUARAN_MUTASI + stok_table.JUMLAH_PENGEMBALIAN_SUPLIER_MUTASI) AS HARGA_JUAL_PENGELUARAN,
						SUM(stok_table.JUMLAH_PENGELUARAN_MUTASI + stok_table.JUMLAH_PENGEMBALIAN_SUPLIER_MUTASI) AS JUMLAH_PENGELUARAN,
						
						SUM(stok_table.JUMLAH_SALDO_AKHIR * stok_table.HARGA_BELI_SALDO_AKHIR)
							/ SUM(stok_table.JUMLAH_SALDO_AKHIR) AS HARGA_BELI_SALDO_AKHIR,
						SUM(stok_table.JUMLAH_SALDO_AKHIR * stok_table.HARGA_JUAL_SALDO_AKHIR)
							/ SUM(stok_table.JUMLAH_SALDO_AKHIR) AS HARGA_JUAL_SALDO_AKHIR,
						SUM(stok_table.JUMLAH_SALDO_AKHIR) AS JUMLAH_SALDO_AKHIR
				FROM m_persediaan_gudang
				INNER JOIN m_persediaan_group ON (m_persediaan_gudang.PERSEDIAAN_GROUP_ID = m_persediaan_group.PERSEDIAAN_GROUP_ID)	
				LEFT JOIN (
SELECT CASE WHEN SUM(t_gudang_stokopname_harian.STOK) < 0 THEN 1 ELSE 0 END AS TNDA,
		m_persediaan_gudang_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_gudang_detail.PERSEDIAAN_ID,	
		m_persediaan_gudang_detail.HARGA_BELI AS HARGA_BELI_SALDO_AWAL,
		t_gudang_stokopname_harian.HARGA_JUAL AS HARGA_JUAL_SALDO_AWAL,
		SUM(t_gudang_stokopname_harian.STOK) AS JUMLAH_SALDO_AWAL,
		0 AS HARGA_BELI_PENERIMAAN_MUTASI,
		0 AS HARGA_JUAL_PENERIMAAN_MUTASI,		
		0 AS JUMLAH_PENERIMAAN_MUTASI,
		0 AS HARGA_BELI_PENGELUARAN_MUTASI,
		0 AS HARGA_JUAL_PENGELUARAN_MUTASI,		
		0 AS JUMLAH_PENGELUARAN_MUTASI,
		0 AS HARGA_BELI_PENGEMBALIAN_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_MUTASI,		
		0 AS JUMLAH_PENGEMBALIAN_MUTASI,			
		0 AS HARGA_BELI_PENGEMBALIAN_SUPLIER_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_SUPLIER_MUTASI,				
		0 AS JUMLAH_PENGEMBALIAN_SUPLIER_MUTASI,
		0 AS HARGA_BELI_SALDO_AKHIR,
		0 AS HARGA_JUAL_SALDO_AKHIR,
		0 AS JUMLAH_SALDO_AKHIR
		FROM m_persediaan_gudang_detail
		INNER JOIN t_gudang_stokopname_harian ON (m_persediaan_gudang_detail.PERSEDIAAN_DETAIL_ID = t_gudang_stokopname_harian.PERSEDIAAN_DETAIL_ID)  
		WHERE DATE_FORMAT(t_gudang_stokopname_harian.TANGGAL,"%d/%m/%Y") = "' . $tgl_kemarin . '"
		GROUP BY m_persediaan_gudang_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_gudang_detail.PERSEDIAAN_ID,		
		m_persediaan_gudang_detail.HARGA_BELI,
		t_gudang_stokopname_harian.HARGA_JUAL
UNION
SELECT 0 AS TNDA,
		m_persediaan_gudang_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_gudang_detail.PERSEDIAAN_ID,
		0 AS HARGA_BELI_SALDO_AWAL,
		0 AS HARGA_JUAL_SALDO_AWAL,
		0 AS JUMLAH_SALDO_AWAL,
		m_persediaan_gudang_detail.HARGA_BELI AS HARGA_BELI_PENERIMAAN_MUTASI,
		t_gudang_penerimaan_detail.HARGA_JUAL AS HARGA_JUAL_PENERIMAAN_MUTASI,
		SUM(t_gudang_penerimaan_detail.JUMLAH_TERIMA) AS JUMLAH_PENERIMAAN_MUTASI,
		0 AS HARGA_BELI_PENGELUARAN_MUTASI,
		0 AS HARGA_JUAL_PENGELUARAN_MUTASI,		
		0 AS JUMLAH_PENGELUARAN_MUTASI,
		0 AS HARGA_BELI_PENGEMBALIAN_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_MUTASI,		
		0 AS JUMLAH_PENGEMBALIAN_MUTASI,			
		0 AS HARGA_BELI_PENGEMBALIAN_SUPLIER_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_SUPLIER_MUTASI,				
		0 AS JUMLAH_PENGEMBALIAN_SUPLIER_MUTASI,
		0 AS HARGA_BELI_SALDO_AKHIR,
		0 AS HARGA_JUAL_SALDO_AKHIR,
		0 AS JUMLAH_SALDO_AKHIR
		FROM m_persediaan_gudang_detail
		INNER JOIN t_gudang_penerimaan_detail ON (m_persediaan_gudang_detail.PERSEDIAAN_DETAIL_ID = t_gudang_penerimaan_detail.PERSEDIAAN_DETAIL_ID)
		INNER JOIN t_gudang_penerimaan ON (t_gudang_penerimaan_detail.GUDANG_PENERIMAAN_ID = t_gudang_penerimaan.GUDANG_PENERIMAAN_ID)	
		WHERE t_gudang_penerimaan.NO_PENERIMAAN IS NOT NULL 
		AND t_gudang_penerimaan.TANGGAL_TERIMA = ' . fieldDate($tgl_filter) . '
		GROUP BY m_persediaan_gudang_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_gudang_detail.PERSEDIAAN_ID,	
		m_persediaan_gudang_detail.HARGA_BELI,
		t_gudang_penerimaan_detail.HARGA_JUAL
UNION
SELECT 0 AS TNDA,
		m_persediaan_gudang_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_gudang_detail.PERSEDIAAN_ID,
		0 AS HARGA_BELI_SALDO_AWAL,
		0 AS HARGA_JUAL_SALDO_AWAL,
		0 AS JUMLAH_SALDO_AWAL,
		0 AS HARGA_BELI_PENERIMAAN_MUTASI,
		0 AS HARGA_JUAL_PENERIMAAN_MUTASI,
		0 AS JUMLAH_PENERIMAAN_MUTASI,		
		m_persediaan_gudang_detail.HARGA_BELI AS HARGA_BELI_PENGELUARAN_MUTASI,
		t_gudang_pengeluaran_detail.HARGA_JUAL AS HARGA_JUAL_PENGELUARAN_MUTASI,
		SUM(t_gudang_pengeluaran_detail.JUMLAH_KELUAR) AS JUMLAH_PENGELUARAN_MUTASI,
		0 AS HARGA_BELI_PENGEMBALIAN_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_MUTASI,		
		0 AS JUMLAH_PENGEMBALIAN_MUTASI,			
		0 AS HARGA_BELI_PENGEMBALIAN_SUPLIER_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_SUPLIER_MUTASI,				
		0 AS JUMLAH_PENGEMBALIAN_SUPLIER_MUTASI,
		0 AS HARGA_BELI_SALDO_AKHIR,
		0 AS HARGA_JUAL_SALDO_AKHIR,
		0 AS JUMLAH_SALDO_AKHIR
		FROM m_persediaan_gudang_detail 
		INNER JOIN t_gudang_pengeluaran_detail ON (m_persediaan_gudang_detail.PERSEDIAAN_DETAIL_ID = t_gudang_pengeluaran_detail.PERSEDIAAN_DETAIL_ID)
		INNER JOIN t_gudang_pengeluaran ON (t_gudang_pengeluaran_detail.GUDANG_PENGELUARAN_ID = t_gudang_pengeluaran.GUDANG_PENGELUARAN_ID)
		WHERE t_gudang_pengeluaran.NO_PENGELUARAN IS NOT NULL
		AND t_gudang_pengeluaran.TANGGAL_KELUAR = ' . fieldDate($tgl_filter) . '
		GROUP BY m_persediaan_gudang_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_gudang_detail.PERSEDIAAN_ID,	
		m_persediaan_gudang_detail.HARGA_BELI,
		t_gudang_pengeluaran_detail.HARGA_JUAL
UNION 
SELECT 0 AS TNDA,
		m_persediaan_gudang_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_gudang_detail.PERSEDIAAN_ID,	
		0 AS HARGA_BELI_SALDO_AWAL,
		0 AS HARGA_JUAL_SALDO_AWAL,
		0 AS JUMLAH_SALDO_AWAL,
		0 AS HARGA_BELI_PENERIMAAN_MUTASI,
		0 AS HARGA_JUAL_PENERIMAAN_MUTASI,
		0 AS JUMLAH_PENERIMAAN_MUTASI,		
		0 AS HARGA_BELI_PENGELUARAN_MUTASI,
		0 AS HARGA_JUAL_PENGELUARAN_MUTASI,
		0 AS JUMLAH_PENGELUARAN_MUTASI,
		m_persediaan_gudang_detail.HARGA_BELI AS HARGA_BELI_PENGEMBALIAN_MUTASI,
		t_gudang_pengembalian_detail.HARGA_JUAL AS HARGA_JUAL_PENGEMBALIAN_MUTASI,
		SUM(t_gudang_pengembalian_detail.JUMLAH_KEMBALI) AS JUMLAH_PENGEMBALIAN_MUTASI,					
		0 AS HARGA_BELI_PENGEMBALIAN_SUPLIER_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_SUPLIER_MUTASI,				
		0 AS JUMLAH_PENGEMBALIAN_SUPLIER_MUTASI,
		0 AS HARGA_BELI_SALDO_AKHIR,
		0 AS HARGA_JUAL_SALDO_AKHIR,
		0 AS JUMLAH_SALDO_AKHIR
		FROM m_persediaan_gudang_detail
		INNER JOIN t_gudang_pengembalian_detail ON (m_persediaan_gudang_detail.PERSEDIAAN_DETAIL_ID = t_gudang_pengembalian_detail.PERSEDIAAN_DETAIL_ID)
		INNER JOIN t_gudang_pengembalian ON (t_gudang_pengembalian_detail.GUDANG_PENGEMBALIAN_ID = t_gudang_pengembalian.GUDANG_PENGEMBALIAN_ID)
		WHERE t_gudang_pengembalian.NO_PENGEMBALIAN IS NOT NULL
		AND t_gudang_pengembalian.TANGGAL_PENGEMBALIAN = ' . fieldDate($tgl_filter) . '
		GROUP BY m_persediaan_gudang_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_gudang_detail.PERSEDIAAN_ID,	
		m_persediaan_gudang_detail.HARGA_BELI,
		t_gudang_pengembalian_detail.HARGA_JUAL
UNION
SELECT 0 AS TNDA,
		m_persediaan_gudang_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_gudang_detail.PERSEDIAAN_ID,	
		0 AS HARGA_BELI_SALDO_AWAL,
		0 AS HARGA_JUAL_SALDO_AWAL,
		0 AS JUMLAH_SALDO_AWAL,
		0 AS HARGA_BELI_PENERIMAAN_MUTASI,
		0 AS HARGA_JUAL_PENERIMAAN_MUTASI,
		0 AS JUMLAH_PENERIMAAN_MUTASI,		
		0 AS HARGA_BELI_PENGELUARAN_MUTASI,
		0 AS HARGA_JUAL_PENGELUARAN_MUTASI,
		0 AS JUMLAH_PENGELUARAN_MUTASI,
		0 AS HARGA_BELI_PENGEMBALIAN_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_MUTASI,
		0 AS JUMLAH_PENGEMBALIAN_MUTASI,
		m_persediaan_gudang_detail.HARGA_BELI AS HARGA_BELI_PENGEMBALIAN_SUPLIER_MUTASI,
		t_gudang_pengembalian_suplier_detail.HARGA_JUAL AS HARGA_JUAL_PENGEMBALIAN_SUPLIER_MUTASI,
		SUM(t_gudang_pengembalian_suplier_detail.JUMLAH_KEMBALI) AS JUMLAH_PENGEMBALIAN_SUPLIER_MUTASI,
		0 AS HARGA_BELI_SALDO_AKHIR,
		0 AS HARGA_JUAL_SALDO_AKHIR,
		0 AS JUMLAH_SALDO_AKHIR	
		FROM m_persediaan_gudang_detail
		INNER JOIN t_gudang_pengembalian_suplier_detail ON (m_persediaan_gudang_detail.PERSEDIAAN_DETAIL_ID = t_gudang_pengembalian_suplier_detail.PERSEDIAAN_DETAIL_ID)
		INNER JOIN t_gudang_pengembalian_suplier ON (t_gudang_pengembalian_suplier_detail.GUDANG_PENGEMBALIAN_SUPLIER_ID = t_gudang_pengembalian_suplier.GUDANG_PENGEMBALIAN_SUPLIER_ID)
		WHERE t_gudang_pengembalian_suplier.NO_PENGEMBALIAN IS NOT NULL
		AND t_gudang_pengembalian_suplier.TANGGAL_PENGEMBALIAN = ' . fieldDate($tgl_filter) . '
		GROUP BY m_persediaan_gudang_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_gudang_detail.PERSEDIAAN_ID,	
		m_persediaan_gudang_detail.HARGA_BELI,
		t_gudang_pengembalian_suplier_detail.HARGA_JUAL
UNION
SELECT CASE WHEN SUM(t_gudang_stokopname_harian.STOK) < 0 THEN 1 ELSE 0 END AS TNDA,
		m_persediaan_gudang_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_gudang_detail.PERSEDIAAN_ID,	
		0 AS HARGA_BELI_SALDO_AWAL,
		0 AS HARGA_JUAL_SALDO_AWAL,
		0 AS JUMLAH_SALDO_AWAL,
		0 AS HARGA_BELI_PENERIMAAN_MUTASI,
		0 AS HARGA_JUAL_PENERIMAAN_MUTASI,		
		0 AS JUMLAH_PENERIMAAN_MUTASI,
		0 AS HARGA_BELI_PENGELUARAN_MUTASI,
		0 AS HARGA_JUAL_PENGELUARAN_MUTASI,		
		0 AS JUMLAH_PENGELUARAN_MUTASI,
		0 AS HARGA_BELI_PENGEMBALIAN_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_MUTASI,		
		0 AS JUMLAH_PENGEMBALIAN_MUTASI,			
		0 AS HARGA_BELI_PENGEMBALIAN_SUPLIER_MUTASI,
		0 AS HARGA_JUAL_PENGEMBALIAN_SUPLIER_MUTASI,				
		0 AS JUMLAH_PENGEMBALIAN_SUPLIER_MUTASI,
		m_persediaan_gudang_detail.HARGA_BELI AS HARGA_BELI_SALDO_AKHIR,
		t_gudang_stokopname_harian.HARGA_JUAL AS HARGA_JUAL_SALDO_AKHIR,
		SUM(t_gudang_stokopname_harian.STOK) AS JUMLAH_SALDO_AKHIR
		FROM m_persediaan_gudang_detail
		INNER JOIN t_gudang_stokopname_harian ON (m_persediaan_gudang_detail.PERSEDIAAN_DETAIL_ID = t_gudang_stokopname_harian.PERSEDIAAN_DETAIL_ID)  
		WHERE DATE_FORMAT(t_gudang_stokopname_harian.TANGGAL,"%d/%m/%Y") = "' . $tgl_filter . '"
		GROUP BY m_persediaan_gudang_detail.PERSEDIAAN_DETAIL_ID,
		m_persediaan_gudang_detail.PERSEDIAAN_ID,		
		m_persediaan_gudang_detail.HARGA_BELI,
		t_gudang_stokopname_harian.HARGA_JUAL		
) stok_table 
ON (m_persediaan_gudang.PERSEDIAAN_ID = stok_table.PERSEDIAAN_ID)
WHERE 1 ' . $group_filter . ' ' . $nama_filter . '
GROUP BY m_persediaan_group.PERSEDIAAN_GROUP_ID,m_persediaan_group.PERSEDIAAN_GROUP,
		m_persediaan_gudang.PERSEDIAAN_ID,m_persediaan_gudang.NAMA_PERSEDIAAN,
		m_persediaan_gudang.SATUAN
ORDER BY m_persediaan_group.PERSEDIAAN_GROUP_ID,m_persediaan_gudang.NAMA_PERSEDIAAN';

$extparam = '&group=' . $group . '&tanggal=' . $tanggal . '&nama=' . $nama;
$action = '';
include('keuangan/keuangan_list_persediaan_gudang_rt.php');
?>
