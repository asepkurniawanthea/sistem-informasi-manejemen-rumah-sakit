<table border="1" class="tableData" id="tfhover" >
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
    $no = 0;
	$pager = new PS_Pagination($connect, $qry_report, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = '';
        ?>
        <tr>
            <td align="center"><?
    $no = ($no + 1);
    if (isset($_GET['page'])) {
        if ($_GET['page'] == 0) {
            $hal = 0;
        } else {
            $hal = $_GET['page'] - 1;
        }
    } else {
        $hal = 0;
    }
    echo ($hal * 10) + $no;
        ?></td>
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
    }
    ?>
</table>
<table width="100%" border="0" height="50%" class="tableNav" >
            <tr >
                <td align="right" valign="middle" >
                    <div style="background-color:#fff; height:80%; width:30%">
                        <table width="100%" align="center" height="100%" class="tableNavSub">
                            <tr>
								<td align="center">
                                    <?php
                                    echo $pager->renderSummary();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?php
                                    echo $pager->renderFirst();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderPrev();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderNav();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderNext();
                                    ?>							
                                </td>
                                <td align="center">
                                    <?
                                    echo $pager->renderLast();
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
            </tr>
        </table>
		 <form id="xls_export" name="xls_export" method="post">
                    <input type="hidden" name="page_to_excel" value="1" />
                    <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
                    <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
					<input type="hidden" name="xlsfile" value="hemodialisa/xls_report_penyakit_harian.php" />
                    <input type="hidden" name="xlsname" value="rpt_penyakit_harian.xls" />            
        </form>