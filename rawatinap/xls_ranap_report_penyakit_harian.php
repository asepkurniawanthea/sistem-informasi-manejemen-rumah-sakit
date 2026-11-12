<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$tgl_1 = '';
if (isset($_POST['tgl_1']))
    $tgl_1 = $_POST['tgl_1'];
$tgl_2 = '';
if (isset($_POST['tgl_1']))
    $tgl_2 = $_POST['tgl_2'];

$unit_id = '';
if (isset($_POST['unit_id']))
		$unit_id = $_POST['unit_id'];

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$qry_filter = '';
if(!empty($unit_id))
	$qry_filter = 'AND t_irna.UNIT_ID = "' . $unit_id . '" ';	

$qry_kunjungan = 'SELECT m_unit.NAMA_UNIT,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%Y/%m"),CONCAT(CASE WHEN t_irna_diagnosa.ICD_CODE IS NOT NULL THEN t_irna_diagnosa.ICD_CODE ELSE "" END, "", t_irna_diagnosa.DIAGNOSA) AS DIAGNOSA,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "01" THEN 1 END) AS D_01,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "02" THEN 1 END) AS D_02,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "03" THEN 1 END) AS D_03,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "04" THEN 1 END) AS D_04,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "05" THEN 1 END) AS D_05,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "06" THEN 1 END) AS D_06,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "07" THEN 1 END) AS D_07,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "08" THEN 1 END) AS D_08,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "09" THEN 1 END) AS D_09,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "10" THEN 1 END) AS D_10,	
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "11" THEN 1 END) AS D_11,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "12" THEN 1 END) AS D_12,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "13" THEN 1 END) AS D_13,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "14" THEN 1 END) AS D_14,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "15" THEN 1 END) AS D_15,	
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "16" THEN 1 END) AS D_16,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "17" THEN 1 END) AS D_17,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "18" THEN 1 END) AS D_18,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "19" THEN 1 END) AS D_19,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "20" THEN 1 END) AS D_20,	
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "21" THEN 1 END) AS D_21,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "22" THEN 1 END) AS D_22,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "23" THEN 1 END) AS D_23,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "24" THEN 1 END) AS D_24,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "25" THEN 1 END) AS D_25,	
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "26" THEN 1 END) AS D_26,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "27" THEN 1 END) AS D_27,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "28" THEN 1 END) AS D_28,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "29" THEN 1 END) AS D_29,
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "30" THEN 1 END) AS D_30,		
				SUM(CASE WHEN DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d") = "31" THEN 1 END) AS D_31		
				FROM t_irna
				INNER JOIN m_unit ON (t_irna.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN t_irna_diagnosa ON (t_irna.IRNA_ID = t_irna_diagnosa.IRNA_ID)
				' . $qry_filter . '
				AND t_irna.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . '
				AND t_irna.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				GROUP BY m_unit.NAMA_UNIT,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%Y/%m"),CONCAT(CASE WHEN t_irna_diagnosa.ICD_CODE IS NOT NULL THEN t_irna_diagnosa.ICD_CODE ELSE "" END, "", t_irna_diagnosa.DIAGNOSA)
				ORDER BY m_unit.NAMA_UNIT,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%Y/%m"),t_irna_diagnosa.ICD_CODE';
?>
<table border="1" >
	<tr>
		<th colspan="35">Laporan Penyakit Harian Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
    <tr>
        <th>No</th>
		<th>Poliklinik</th>
		<th>Diagnosa</th>
		<th>Bulan</th>
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
		<th>Jumlah</th>
    </tr>
    <?
    $no = 1;
	$rs = mysql_query($qry_kunjungan) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
	?>
			<td><?php echo $no; ?></td>
			<td><?php echo $data['NAMA_UNIT']; ?></td>
			<td><?php echo $data['DIAGNOSA']; ?></td>
			<td><?php echo $data['TANGGAL_DAFTAR']; ?></td>
            <td align="right"><?php echo currFormat($data['D_01']); ?></td>
			<td align="right"><?php echo currFormat($data['D_02']); ?></td>
			<td align="right"><?php echo currFormat($data['D_03']); ?></td>
			<td align="right"><?php echo currFormat($data['D_04']); ?></td>
			<td align="right"><?php echo currFormat($data['D_05']); ?></td>
			<td align="right"><?php echo currFormat($data['D_06']); ?></td>
			<td align="right"><?php echo currFormat($data['D_07']); ?></td>
			<td align="right"><?php echo currFormat($data['D_08']); ?></td>
			<td align="right"><?php echo currFormat($data['D_09']); ?></td>
			<td align="right"><?php echo currFormat($data['D_10']); ?></td>
			<td align="right"><?php echo currFormat($data['D_11']); ?></td>
			<td align="right"><?php echo currFormat($data['D_12']); ?></td>
			<td align="right"><?php echo currFormat($data['D_13']); ?></td>
			<td align="right"><?php echo currFormat($data['D_14']); ?></td>
			<td align="right"><?php echo currFormat($data['D_15']); ?></td>
			<td align="right"><?php echo currFormat($data['D_16']); ?></td>
			<td align="right"><?php echo currFormat($data['D_17']); ?></td>
			<td align="right"><?php echo currFormat($data['D_18']); ?></td>
			<td align="right"><?php echo currFormat($data['D_19']); ?></td>
			<td align="right"><?php echo currFormat($data['D_20']); ?></td>
			<td align="right"><?php echo currFormat($data['D_21']); ?></td>
			<td align="right"><?php echo currFormat($data['D_22']); ?></td>
			<td align="right"><?php echo currFormat($data['D_23']); ?></td>
			<td align="right"><?php echo currFormat($data['D_24']); ?></td>
			<td align="right"><?php echo currFormat($data['D_25']); ?></td>
			<td align="right"><?php echo currFormat($data['D_26']); ?></td>
			<td align="right"><?php echo currFormat($data['D_27']); ?></td>
			<td align="right"><?php echo currFormat($data['D_28']); ?></td>
			<td align="right"><?php echo currFormat($data['D_29']); ?></td>
			<td align="right"><?php echo currFormat($data['D_30']); ?></td>
			<td align="right"><?php echo currFormat($data['D_31']); ?></td>
			<td align="right"><?php 
			$jumlah = $data['D_01'] + $data['D_02'] + $data['D_03'] + $data['D_04'] + $data['D_05'] + 
						$data['D_06'] + $data['D_07'] + $data['D_08'] + $data['D_09'] + $data['D_10'] +
						$data['D_11'] + $data['D_12'] + $data['D_13'] + $data['D_14'] + $data['D_15'] +
						$data['D_16'] + $data['D_17'] + $data['D_18'] + $data['D_19'] + $data['D_20'] +
						$data['D_21'] + $data['D_22'] + $data['D_23'] + $data['D_24'] + $data['D_25'] +
						$data['D_26'] + $data['D_27'] + $data['D_28'] + $data['D_29'] + $data['D_30'] +
						$data['D_31'];
			echo currFormat($jumlah); ?></td>
        </tr>
        <?
    $no++; }
    ?>
</table>
