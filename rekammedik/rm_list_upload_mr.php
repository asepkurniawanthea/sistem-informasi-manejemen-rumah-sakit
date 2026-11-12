<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th width="20">No</th>
		<th width="200">Kunjungan/ Rawat</th>
		<th width="200">Jenis Status/ Dokumen</th>
        <th>Keterangan</th>
        <th width="150">Register</th>
        <th width="100">Option</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_riwayat, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['FILE_ID'];
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
            <td align="center"><?php echo $data['PASIEN_MASUK'] . ' ' . $data['NAMA_UNIT']; ?></td>
			<td><?php echo $data['JENIS_DOKUMEN']; ?></td>
			<td><?php echo $data['KETERANGAN']; ?></td>
			<td><?php echo $data['USER_UPLOAD']; ?></td>
			<td>
			<a href="#" onclick="window.open('index.php?flex=<?php echo $data['FILE_ID']; ?>', '_blank');" >lihat</a>
			<a href="<?php echo currentUrl(); ?>&flid=<?php echo $data['FILE_ID']; ?>&flnm=<?php echo $data['PASIEN_MASUK'] . ' ' . $data['NAMA_UNIT'] . ' ' . $data['JENIS_DOKUMEN']; ?>" >hapus</a>
			</td>
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