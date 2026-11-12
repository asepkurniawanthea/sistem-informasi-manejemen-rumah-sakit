<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
        <th>ICD Code</th>
        <th>Deskripsi</th>
        <th>Deskripsi Lokal</th>
        <th>Penyebab</th>
		<th>Register</th>
		<?php if($_SESSION['SES_SIMRS_ADMIN'] == '1' &&  currentModul() == 'rekam medik'){ 
		echo '<th width="50">Option</th>	';
		} ?>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_icd, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
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
            <td align="center"><?php echo $data['ICD_CODE']; ?></td>
            <td><?php echo $data['DESKRIPSI']; ?></td>
			<td><?php echo $data['LOKAL']; ?></td>
			<td><?php echo $data['PENYEBAB']; ?></td>
			<td><?php echo $data['USER_RM']; ?></td>
			<?php if($_SESSION['SES_SIMRS_ADMIN'] == '1' &&  currentModul() == 'rekam medik'){ 
				echo '<td><a href="index.php?link=' . md5('rmformicd10') . '&icd=' . $data['ICD_CODE'] . '" >ubah</td>	';
			} ?>
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