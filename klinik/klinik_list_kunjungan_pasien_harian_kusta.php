<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th rowspan="2">No</th>
        <th rowspan="2">Tanggal Daftar</th>
        <th rowspan="2">Dewasa</th>
        <th rowspan="2">Anak</th>
        <th rowspan="2">Pasien Baru</th>
        <th rowspan="2">Laki-laki</th>
        <th rowspan="2">Perempuan</th>
        <th colspan="3">PB</th>
		<th colspan="3">MB</th>
		<th rowspan="2">Observasi</th>
		<th rowspan="2">Non MH</th>
        <th rowspan="2">RFT (COT) </th>
		<th rowspan="2">Kunjungan Pertama</th>
        <th rowspan="2">Opname</th>
    </tr>
	 <tr>
        <th>N</th>
		<th>TT</th>
		<th>BT</th>
		<th>BB</th>
        <th>BL</th>
        <th>LL</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_kunjungan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
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
            <td align="center"><?php echo changeDateFormat($data['TANGGAL_DAFTAR']); ?></td>
            <td align="right"><?php echo $data['DEWASA']; ?></td>
			<td align="right"><?php echo $data['ANAK']; ?></td>
			<td align="right"><?php echo $data['PASIEN_BR']; ?></td>
			<td align="right"><?php echo $data['LK']; ?></td>
			<td align="right"><?php echo $data['PR']; ?></td>
			<td align="right"><?php echo $data['NR']; ?></td>
			<td align="right"><?php echo $data['TT']; ?></td>
			<td align="right"><?php echo $data['BT']; ?></td>
			<td align="right"><?php echo $data['BB']; ?></td>
			<td align="right"><?php echo $data['BL']; ?></td>
			<td align="right"><?php echo $data['LL']; ?></td>
			<td align="right"><?php echo $data['OBSERVASI']; ?></td>
			<td align="right"><?php echo $data['NON_MH']; ?></td>
			<td align="right"><?php echo $data['RFT']; ?></td>
			<td align="right"><?php echo $data['PERTAMA']; ?></td>
			<td align="right"><?php echo $data['OPNAME']; ?></td>
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
					<input type="hidden" name="pegawai_id" value="<?php echo $pegawai_id; ?>" />
                    <input type="hidden" name="xlsfile" value="klinik/xls_report_kunjungan_pasien_harian_kusta.php" />
                    <input type="hidden" name="xlsname" value="rpt_kunjungan_pasien_harian_kusta.xls" />            
        </form>