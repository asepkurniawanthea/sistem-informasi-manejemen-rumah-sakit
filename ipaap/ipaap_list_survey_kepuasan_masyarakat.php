<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th rowspan="2">No</th>
        <th rowspan="2">Tanggal</th>
        <th rowspan="2">Jns Kelamin</th>
        <th rowspan="2">Umur</th>
        <th rowspan="2">Pembiayaan</th>
        <th rowspan="2">Poliklinik/ Ruang</th>
		<th colspan="10">Survey</th>
    </tr>
	<tr>
		<th>1</th>
		<th>2</th>
		<th>3</th>
		<th>4</th>
		<th>5</th>
		<th>6</th>
		<th>7</th>
		<th>8</th>
		<th>9</th>
		<th>10</th>
	</tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_survey, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['ID_SURVEY'];
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
            <td align="center"><?php echo $data['TANGGAL']; ?></td>
            <td><?php echo $data['JNS_KELAMIN']; ?></td>
			<td><?php echo $data['UMUR']; ?></td>
			<td><?php echo $data['PEMBIAYAAN']; ?></td>
			<td><?php echo $data['POLIKLINIK_RUANG']; ?></td>
			<td><?php echo $data['SURVEY_1']; ?></td>
			<td><?php echo $data['SURVEY_2']; ?></td>
			<td><?php echo $data['SURVEY_3']; ?></td>
			<td><?php echo $data['SURVEY_4']; ?></td>
			<td><?php echo $data['SURVEY_5']; ?></td>
			<td><?php echo $data['SURVEY_6']; ?></td>
			<td><?php echo $data['SURVEY_7']; ?></td>
			<td><?php echo $data['SURVEY_8']; ?></td>
			<td><?php echo $data['SURVEY_9']; ?></td>
			<td><?php echo $data['SURVEY_10']; ?></td>
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
    <input type="hidden" name="xlsfile" value="ipaap/xls_survey_kepuasan_masyarakat.php" />
    <input type="hidden" name="xlsname" value="survey_kepusan_masyarakat.xls" />            
</form>				