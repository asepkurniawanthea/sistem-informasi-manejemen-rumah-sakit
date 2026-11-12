<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$group = '';
$nama = '';
$tanggal = '';

if (isset($_POST['group']))
    $group = $_POST['group'];
if (isset($_POST['nama']))
    $nama = $_POST['nama'];
if (isset($_POST['tanggal']))
    $tanggal = $_POST['tanggal'];

$tgl_filter = $tanggal;
if (empty($tanggal)) {
    $tgl_filter = getDateSkr();
}

$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());

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
$qry = 'SELECT MAX(stok_table.TNDA) AS TNDA,m_persediaan_group.PERSEDIAAN_GROUP_ID,m_persediaan_group.PERSEDIAAN_GROUP,
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
				INNER JOIN (
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

$get = mysql_query($qry) or die(mysql_error());
?>
<table border="1">
    <tr>
        <th colspan="17">Report Persediaan Gudang RT Tanggal <?php echo $tanggal; ?></th>
    </tr>
   <tr>
        <th rowspan="2" scope="col">No</th>
        <th colspan="4" scope="col">Persediaan</th>
        <th colspan="3" scope="col">Saldo Awal </th>
        <th colspan="3" scope="col">Penerimaan</th>
        <th colspan="3" scope="col">Pengeluaran</th>
        <th colspan="3" scope="col">Saldo Akhir</th>
    </tr>
    <tr>
        <th>Group</th>
        <th>Kode</th>
        <th scope="col">Nama</th>
        <th scope="col">Satuan</th>
        <th scope="col">Hrg Beli </th>
        <th scope="col">Hrg Jual </th>
        <th scope="col">Jumlah</th>
        <th scope="col">Hrg Beli </th>
        <th scope="col">Hrg Jual </th>
        <th scope="col">Jumlah</th>
        <th scope="col">Hrg Beli </th>
        <th scope="col">Hrg Jual </th>
        <th scope="col">Jumlah</th>
        <th scope="col">Hrg Beli </th>
        <th scope="col">Hrg Jual </th>
        <th scope="col">Jumlah</th>
    </tr>
<?php
$no = 1;
while ($dat = mysql_fetch_array($get)) {
	?>
        <tr>
			<td align="center"><?php echo $no; ?></td>
            <td><?php echo $dat['PERSEDIAAN_GROUP']; ?></td>
            <td align="center">'<?php echo $dat['PERSEDIAAN_ID']; ?></td>
            <td <?php if($dat['TNDA'] == '1') echo 'style="color:#FF0000"'; ?> ><?php echo $dat['NAMA_PERSEDIAAN']; ?></td>
            <td><?php echo $dat['SATUAN']; ?></td>
			<td align="right"><?php echo currFormat($dat['HARGA_BELI_SALDO_AWAL'],2); ?></td>
			<td align="right"><?php echo currFormat($dat['HARGA_JUAL_SALDO_AWAL'],2); ?></td>
            <td align="right"><?php echo currFormat($dat['JUMLAH_SALDO_AWAL'],2); ?></td>
            <td align="right"><?php echo currFormat($dat['HARGA_BELI_PENERIMAAN'],2); ?></td>
			<td align="right"><?php echo currFormat($dat['HARGA_JUAL_PENERIMAAN'],2); ?></td>
            <td align="right"><?php echo currFormat($dat['JUMLAH_PENERIMAAN'],2); ?></td>
			<td align="right"><?php echo currFormat($dat['HARGA_BELI_PENGELUARAN'],2); ?></td>
			<td align="right"><?php echo currFormat($dat['HARGA_JUAL_PENGELUARAN'],2); ?></td>
            <td align="right"><?php echo currFormat($dat['JUMLAH_PENGELUARAN'],2); ?></td>
			<td align="right"><?php echo currFormat($dat['HARGA_BELI_SALDO_AKHIR'],2); ?></td>
			<td align="right"><?php echo currFormat($dat['HARGA_JUAL_SALDO_AKHIR'],2); ?></td>
            <td align="right"><?php echo currFormat($dat['JUMLAH_SALDO_AKHIR'],2); ?></td>
        </tr>
    <?php
    $no = $no + 1;
}
?>	