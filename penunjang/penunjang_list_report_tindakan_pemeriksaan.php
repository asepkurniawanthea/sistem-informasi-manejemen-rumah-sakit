<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Tanggal</th>
		<th>Nama Pemeriksaan</th>
		<th>Pembayaran</th>
		<th>Jumlah</th>
		<th>Penanggungjawab</th>
        <th>Pelaksana</th>
    </tr>
    <?
    $no = 0;
	$pager = new PS_Pagination($connect, $qry_kunjungan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
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
			<td><?php echo $data['TANGGAL']; ?></td>
            <td><?php echo $data['NAMA_PEMERIKSAAN_ORDER']; ?></td>
			<td><?php echo $data['NAMA_JAMINAN']; ?></td>
			<td align="right"><?php echo $data['KUANTITI']; ?></td>
			<td><?php echo $data['DOKTER_PENANGGUNGJAWAB']; ?></td>
			<td><?php echo $data['PELAKSANA']; ?></td>
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
                    <input type="hidden" name="xlsfile" value="laboratorium/xls_report_tindakan_pemeriksaan.php" />
                    <input type="hidden" name="xlsname" value="rpt_tindakan_laboratorium.xls" />            
        </form>