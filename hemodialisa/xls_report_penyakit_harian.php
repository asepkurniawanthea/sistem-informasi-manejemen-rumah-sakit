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

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$qry_kunjungan = 'SELECT DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y/%m") AS TANGGAL_DAFTAR,
				t_irja_diagnosa.DIAGNOSA,
				CONCAT(m_icd_x.ICD_CODE," ",m_icd_x.DESKRIPSI) AS ICD,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "01" THEN 1 END) AS D_01,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "02" THEN 1 END) AS D_02,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "03" THEN 1 END) AS D_03,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "04" THEN 1 END) AS D_04,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "05" THEN 1 END) AS D_05,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "06" THEN 1 END) AS D_06,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "07" THEN 1 END) AS D_07,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "08" THEN 1 END) AS D_08,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "09" THEN 1 END) AS D_09,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "10" THEN 1 END) AS D_10,	
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "11" THEN 1 END) AS D_11,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "12" THEN 1 END) AS D_12,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "13" THEN 1 END) AS D_13,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "14" THEN 1 END) AS D_14,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "15" THEN 1 END) AS D_15,	
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "16" THEN 1 END) AS D_16,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "17" THEN 1 END) AS D_17,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "18" THEN 1 END) AS D_18,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "19" THEN 1 END) AS D_19,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "20" THEN 1 END) AS D_20,	
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "21" THEN 1 END) AS D_21,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "22" THEN 1 END) AS D_22,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "23" THEN 1 END) AS D_23,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "24" THEN 1 END) AS D_24,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "25" THEN 1 END) AS D_25,	
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "26" THEN 1 END) AS D_26,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "27" THEN 1 END) AS D_27,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "28" THEN 1 END) AS D_28,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "29" THEN 1 END) AS D_29,
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "30" THEN 1 END) AS D_30,		
				SUM(CASE WHEN DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d") = "31" THEN 1 END) AS D_31		
				FROM t_irja
				INNER JOIN t_irja_diagnosa ON (t_irja.IRJA_ID = t_irja_diagnosa.IRJA_ID)
				LEFT JOIN m_icd_x ON (t_irja_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
				WHERE t_irja.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '"
				AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . '
				AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . '
				GROUP BY DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y/%m"),CONCAT(m_icd_x.ICD_CODE," ",m_icd_x.DESKRIPSI),t_irja_diagnosa.DIAGNOSA';
				
$qry_hemodialisa = 'SELECT DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%Y/%m") AS TANGGAL_DAFTAR,
				t_hemodialisa_diagnosa.DIAGNOSA,
				CONCAT(m_icd_x.ICD_CODE," ",m_icd_x.DESKRIPSI) AS ICD,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "01" THEN 1 END) AS D_01,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "02" THEN 1 END) AS D_02,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "03" THEN 1 END) AS D_03,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "04" THEN 1 END) AS D_04,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "05" THEN 1 END) AS D_05,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "06" THEN 1 END) AS D_06,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "07" THEN 1 END) AS D_07,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "08" THEN 1 END) AS D_08,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "09" THEN 1 END) AS D_09,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "10" THEN 1 END) AS D_10,	
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "11" THEN 1 END) AS D_11,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "12" THEN 1 END) AS D_12,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "13" THEN 1 END) AS D_13,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "14" THEN 1 END) AS D_14,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "15" THEN 1 END) AS D_15,	
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "16" THEN 1 END) AS D_16,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "17" THEN 1 END) AS D_17,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "18" THEN 1 END) AS D_18,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "19" THEN 1 END) AS D_19,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "20" THEN 1 END) AS D_20,	
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "21" THEN 1 END) AS D_21,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "22" THEN 1 END) AS D_22,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "23" THEN 1 END) AS D_23,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "24" THEN 1 END) AS D_24,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "25" THEN 1 END) AS D_25,	
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "26" THEN 1 END) AS D_26,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "27" THEN 1 END) AS D_27,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "28" THEN 1 END) AS D_28,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "29" THEN 1 END) AS D_29,
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "30" THEN 1 END) AS D_30,		
				SUM(CASE WHEN DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d") = "31" THEN 1 END) AS D_31		
				FROM t_hemodialisa
				INNER JOIN t_hemodialisa_diagnosa ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_diagnosa.HEMODIALISA_ID)
				LEFT JOIN m_icd_x ON (t_hemodialisa_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
				WHERE STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
				AND STR_TO_DATE(DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				GROUP BY DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%Y/%m"),CONCAT(m_icd_x.ICD_CODE," ",m_icd_x.DESKRIPSI),t_hemodialisa_diagnosa.DIAGNOSA';				
$qry_report = 'SELECT TANGGAL_DAFTAR, DIAGNOSA, ICD,
				SUM(D_01) AS D_01,
				SUM(D_02) AS D_02,
				SUM(D_03) AS D_03,
				SUM(D_04) AS D_04,
				SUM(D_05) AS D_05,
				SUM(D_06) AS D_06,
				SUM(D_07) AS D_07,
				SUM(D_08) AS D_08,
				SUM(D_09) AS D_09,
				SUM(D_10) AS D_10,
				SUM(D_11) AS D_11,
				SUM(D_12) AS D_12,
				SUM(D_13) AS D_13,
				SUM(D_14) AS D_14,
				SUM(D_15) AS D_15,
				SUM(D_16) AS D_16,
				SUM(D_17) AS D_17,
				SUM(D_18) AS D_18,
				SUM(D_19) AS D_19,
				SUM(D_20) AS D_20,
				SUM(D_21) AS D_21,
				SUM(D_22) AS D_22,
				SUM(D_23) AS D_23,
				SUM(D_24) AS D_24,
				SUM(D_25) AS D_25,
				SUM(D_26) AS D_26,
				SUM(D_27) AS D_27,
				SUM(D_28) AS D_28,
				SUM(D_29) AS D_29,
				SUM(D_30) AS D_30,
				SUM(D_31) AS D_31
			FROM(' . $qry_kunjungan . ' UNION ' . $qry_hemodialisa . ') t_report
			GROUP BY TANGGAL_DAFTAR, DIAGNOSA, ICD
			ORDER BY TANGGAL_DAFTAR, DIAGNOSA, ICD';
?>
<table border="1" >
	<tr>
		<th colspan="36">Laporan Penyakit Harian Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>
    <tr>
        <th>No</th>
		<th>Diagnosa</th>
		<th>ICD</th>
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
	$rs = mysql_query($qry_report) or die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
	?>
			<td><?php echo $no; ?></td>
			<td><?php echo $data['DIAGNOSA']; ?></td>
			<td><?php echo $data['ICD']; ?></td>
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
