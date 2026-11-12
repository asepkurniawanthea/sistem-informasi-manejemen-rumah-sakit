<table class="tableData" id="tfhover" border="1">
  <tr>
        <th rowspan="2" scope="col">No</th>
        <th colspan="4" scope="col">Persediaan</th>
        <th colspan="3" scope="col">Saldo Awal </th>
        <th colspan="3" scope="col">Penerimaan</th>
        <th colspan="3" scope="col">Pengeluaran</th>
        <th colspan="3" scope="col">Saldo Akhir</th>
    </tr>
    <tr>
        <th>Group</th>
        <th>Kode</th>
        <th scope="col">Nama</th>
        <th scope="col">Satuan</th>
        <th scope="col">Hrg Beli </th>
        <th scope="col">Hrg Jual </th>
        <th scope="col">Jumlah</th>
        <th scope="col">Hrg Beli </th>
        <th scope="col">Hrg Jual </th>
        <th scope="col">Jumlah</th>
        <th scope="col">Hrg Beli </th>
        <th scope="col">Hrg Jual </th>
        <th scope="col">Jumlah</th>
        <th scope="col">Hrg Beli </th>
        <th scope="col">Hrg Jual </th>
        <th scope="col">Jumlah</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_persediaan, 15, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['PERSEDIAAN_ID'];
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
    echo ($hal * 15) + $no;
        ?></td>
            <td><?php echo $data['PERSEDIAAN_GROUP']; ?></td>
            <td align="center"><?php echo $data['PERSEDIAAN_ID']; ?></td>
            <td <?php if($data['TNDA'] == '1') echo 'style="color:#FF0000"'; ?> ><?php echo $data['NAMA_PERSEDIAAN']; ?></td>
            <td><?php echo $data['SATUAN']; ?></td>
			<td align="right"><?php echo currFormat($data['HARGA_BELI_SALDO_AWAL'],2); ?></td>
			<td align="right"><?php echo currFormat($data['HARGA_JUAL_SALDO_AWAL'],2); ?></td>
            <td align="right"><?php echo currFormat($data['JUMLAH_SALDO_AWAL'],2); ?></td>
            <td align="right"><?php echo currFormat($data['HARGA_BELI_PENERIMAAN'],2); ?></td>
			<td align="right"><?php echo currFormat($data['HARGA_JUAL_PENERIMAAN'],2); ?></td>
            <td align="right"><?php echo currFormat($data['JUMLAH_PENERIMAAN'],2); ?></td>
			<td align="right"><?php echo currFormat($data['HARGA_BELI_PENGELUARAN'],2); ?></td>
			<td align="right"><?php echo currFormat($data['HARGA_JUAL_PENGELUARAN'],2); ?></td>
            <td align="right"><?php echo currFormat($data['JUMLAH_PENGELUARAN'],2); ?></td>
			<td align="right"><?php echo currFormat($data['HARGA_BELI_SALDO_AKHIR'],2); ?></td>
			<td align="right"><?php echo currFormat($data['HARGA_JUAL_SALDO_AKHIR'],2); ?></td>
            <td align="right"><?php echo currFormat($data['JUMLAH_SALDO_AKHIR'],2); ?></td>
        </tr>
        <?
    }
    ?>
</table>
<table width="100%" border="0" class="tableNav" >
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
				<form id="xls_export" name="xls_export" method="post">
				<input type="hidden" name="page_to_excel" value="1" />
				<input type="hidden" name="tanggal" value="<?php echo $tanggal; ?>" />
				<input type="hidden" name="obat_alkes" value="<?php echo $obat_alkes; ?>" />
				<input type="hidden" name="generik" value="<?php echo $generik; ?>" />
				<input type="hidden" name="group" value="<?php echo $group; ?>" />
				<input type="hidden" name="depo" value="<?php echo $depo; ?>" />
				<input type="hidden" name="xlsfile" value="keuangan/xls_keuangan_persediaan_depo_farmasi.php" />
				<input type="hidden" name="xlsname" value="rpt_persediaan_depo_farmasi.xls" />
				</form>
                </td>
            </tr>
        </table>