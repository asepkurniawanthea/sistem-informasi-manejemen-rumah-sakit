<form name="formx" id="formx" method="post">
<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Kode</th>
        <th>Nama Tarif</th>
		<th>Tarif</th>
		<th>Tahun Update</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_tindakan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
	$x = 1;	
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['TARIF_ID'];
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
            <td align="center"><?php echo $data['KODE_TARIF']; ?></td>
            <td><?php echo $data['NAMA_TARIF']; ?></td>
			<td align="right"><?php echo currFormat($data['TARIF_NON_KELAS']); ?></td>
			<td align="center"><?php echo $data['TAHUN_UPDATE']; ?></td>
        </tr>
        <?
    $x++; }
    ?>
</table>
<input type="hidden" name="cnr" value="<?php echo $x; ?>" />
<input type="hidden" name="group_id" value="<?php echo $group_id; ?>" />
<input type="hidden" name="tahun" value="<?php echo $tahun; ?>" />
</form>
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