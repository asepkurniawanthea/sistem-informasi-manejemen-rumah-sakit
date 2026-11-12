<table border="1" class="tableData" id="tfhover" >
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
    $no = 0;
	$pager = new PS_Pagination($connect, $qry_rawat, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
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
                    <input type="hidden" name="tahun" value="<?php echo $tahun; ?>" />
                    <input type="hidden" name="bulan" value="<?php echo $bulan; ?>" />
					<input type="hidden" name="ruang_id" value="<?php echo $ruang_id; ?>" />
					<input type="hidden" name="arr_visite" value="<?php echo str_replace('"','`',$arr_visite); ?>" />
                    <input type="hidden" name="xlsfile" value="rawatinap/xls_ranap_report_visit_dokter.php" />
                    <input type="hidden" name="xlsname" value="rpt_visit_dokter.xls" />            
        </form>