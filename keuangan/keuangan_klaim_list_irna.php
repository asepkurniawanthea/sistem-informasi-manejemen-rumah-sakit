<table border="1" class="tableData" id="tfhover" >
     <tr>
        <th>No</th>
        <th>Tanggal<br />Masuk</th>
		<th>Tanggal<br />Keluar</th>
        <th>Nomor<br />MR</th>
		<th>Nomor SEP</th>
        <th>Nama Pasien</th>
        <th>Ruang</th>
		<th>Dokter</th>
        <th>Pembayaran</th>
		<th>Diagnosa</th>
		<th>Tarif RS</th>
		<th>Tarif Inacbg</th>
		<th>Selisih</th>
		<th>Klaim<br />Final</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_klaim, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['IRNA_ID'];
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
            <td align="center"><?php echo changeDateFormat($data['TANGGAL_MASUK']); ?></td>
			<td align="center"><?php echo changeDateFormat($data['TANGGAL_KELUAR']); ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
			<td><?php echo $data['NO_SEP']; ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td><?php echo $data['NAMA_RUANG']; ?></td>
            <td><?php echo $data['NAMA_PEGAWAI']; ?></td>
            <td><?php echo $data['NAMA_JAMINAN']; ?></td>
			<td><?php echo $data['DIAGNOSA']; ?></td>
			<?php $tarif_cbg = 0;
			if($data['KELAS_JAMINAN'] == '3') $tarif_cbg = $data['TARIF_CBG_KELAS_3'];
			if($data['KELAS_JAMINAN'] == '2') $tarif_cbg = $data['TARIF_CBG_KELAS_2'];
			if($data['KELAS_JAMINAN'] == '1') $tarif_cbg = $data['TARIF_CBG_KELAS_1'];	?>
			<td align="right"><?php echo currFormat($data['TARIF_RS']); ?></td>
			<td align="right"><?php echo currFormat($tarif_cbg); ?></td>
			<td align="right"><?php echo currFormat($tarif_cbg - $data['TARIF_RS']); ?></td>
            <td align="center"><?php if($data['KLAIM_FINAL'] == '1') echo '&radic;'; ?></td>
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
	<input type="hidden" name="nomr" value="<?php echo $nomr; ?>" />
	<input type="hidden" name="ruang_id" value="<?php echo $ruang_id; ?>" />
	<input type="hidden" name="jaminan_id" value="<?php echo $jaminan_id; ?>" />
	<input type="hidden" name="nosep" value="<?php echo $nosep; ?>" />
	<input type="hidden" name="xlsfile" value="keuangan/xls_report_klaim_rawat_inap.php" />
    <input type="hidden" name="xlsname" value="rpt_rekap_klaim_rawat_inap.xls" />            
</form>	