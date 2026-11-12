<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$arr_bulan['01'] = 'Januari';	
$arr_bulan['02'] = 'Februari';	
$arr_bulan['03'] = 'Maret';	
$arr_bulan['04'] = 'April';	
$arr_bulan['05'] = 'Mei';	
$arr_bulan['06'] = 'Juni';	
$arr_bulan['07'] = 'Juli';	
$arr_bulan['08'] = 'Agustus';	
$arr_bulan['09'] = 'September';	
$arr_bulan['10'] = 'Oktober';	
$arr_bulan['11'] = 'Nopember';	
$arr_bulan['12'] = 'Desember';

$arr_visite = '';
if (isset($_POST['arr_visite']))
    $arr_visite = str_replace('`','"',$_POST['arr_visite']);

$tahun = '';
if (isset($_POST['tahun']))
    $tahun = $_POST['tahun'];
$bulan = '';
if (isset($_POST['bulan']))
    $bulan = $_POST['bulan'];

$ruang_id = '';
if (isset($_POST['ruang_id']))
		$ruang_id = $_POST['ruang_id'];

$qry_filter_ruang = '';
if(!empty($ruang_id))
	$qry_filter_ruang = 'AND m_ruang.BANGSAL = "' . $ruang_id . '" ';	
$qry_rawat = 'SELECT COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "01" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_01,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "02" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_02,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "03" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_03,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "04" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_04,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "05" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_05,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "06" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_06,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "07" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_07,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "08" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_08,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "09" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_09,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "10" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_10,
				
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "11" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_11,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "12" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_12,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "13" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_13,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "14" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_14,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "15" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_15,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "16" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_16,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "17" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_17,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "18" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_18,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "19" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_19,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "20" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_20,
				
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "21" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_21,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "22" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_22,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "23" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_23,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "24" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_24,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "25" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_25,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "26" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_26,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "27" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_27,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "28" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_28,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "29" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_29,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "30" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_30,
				COUNT(CASE WHEN DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d") = "31" THEN t_irna_tarif.IRNA_TARIF_ID END) AS TANGGAL_31,
				COUNT(t_irna_tarif.IRNA_TARIF_ID) AS JUMLAH,
				m_pegawai.NAMA_PEGAWAI
				FROM t_irna_tarif
				INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN t_irna ON (t_irna_tarif.IRNA_ID = t_irna.IRNA_ID)
				INNER JOIN m_ruang ON (t_irna_tarif.RUANG_ID = m_ruang.RUANG_ID)
				LEFT JOIN m_pegawai ON (t_irna_tarif.PEGAWAI_PELAKSANA_ID = m_pegawai.PEGAWAI_ID)
				WHERE DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%Y") = ' . $tahun . '
				AND DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%m") = ' . $bulan . '
				AND t_irna_tarif.NO_TARIF IS NOT NULL AND t_irna_tarif.ST_BAYAR <> "Batal"
				AND t_irna.ST_BATAL IS NULL AND m_tarif.KODE_TARIF_GROUP IN (' . $arr_visite . ')
				' . $qry_filter_ruang . '
				GROUP BY m_pegawai.NAMA_PEGAWAI
				ORDER BY m_pegawai.NAMA_PEGAWAI';
?>
<table border="1" >
	<tr>
		<th colspan="34">Laporan Visit Dokter Di Ruang Rawat Tahun <?php echo $tahun; ?> Bulan <?php echo $arr_bulan[$bulan]; ?></th>
	</tr>
    <tr>
        <th rowspan="2">No</th>
		<th rowspan="2">Nama Dokter </th>
		<th colspan="31">Tanggal</th>
		<th rowspan="2">Jumlah</th>
	</tr>
    <tr>
      <th>01</th>
      <th>02</th>
      <th>03</th>
      <th>04</th>
      <th>05</th>
      <th>06</th>
      <th>07</th>
      <th>08</th>
      <th>09</th>
      <th>10</th>
      <th>11</th>
      <th>12</th>
      <th>13</th>
      <th>14</th>
      <th>15</th>
      <th>16</th>
      <th>17</th>
      <th>18</th>
      <th>19</th>
      <th>20</th>
      <th>21</th>
      <th>22</th>
      <th>23</th>
      <th>24</th>
      <th>25</th>
      <th>26</th>
      <th>27</th>
      <th>28</th>
      <th>29</th>
      <th>30</th>
      <th>31</th>
    </tr>
    <?
    $no = 1;
	$rs = mysql_query($qry_rawat) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
	?>
			<td><?php echo $no; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_01']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_02']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_03']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_04']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_05']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_06']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_07']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_08']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_09']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_10']); ?></td>
			
			<td align="right"><?php echo currFormat($data['TANGGAL_11']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_12']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_13']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_14']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_15']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_16']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_17']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_18']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_19']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_20']); ?></td>
			
			<td align="right"><?php echo currFormat($data['TANGGAL_21']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_22']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_23']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_24']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_25']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_26']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_27']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_28']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_29']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_30']); ?></td>
			<td align="right"><?php echo currFormat($data['TANGGAL_31']); ?></td>
			<td align="right"><?php echo currFormat($data['JUMLAH']); ?></td>
        </tr>
        <?
    $no++; }
    ?>
</table>
