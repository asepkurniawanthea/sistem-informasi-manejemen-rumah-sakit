<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
		<th>Tanggal</th>
		<th>Masuk</th>
		<th>Klinik</th>
		<th>No MR</th>
		<th>Nama Pasien</th>
        <th>Dokter</th>
        <th>Jenis Tindakan</th>
		<th>Jumlah</th>
		<?php if(currentModul() == 'keuangan'){ ?>
		<th>Harga</th>
		<?php } ?>
        <th>Jaminan</th>
        <th>Pelaksana</th>
		<th>Keluar</th>
		<th>Status</th>
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
			<td><?php echo $data['PASIEN_MASUK']; ?></td>
            <td><?php echo $data['NAMA_UNIT']; ?></td>
			<td><?php echo formatNomr($data['NOMR']); ?></td>
			<td><?php echo $data['NAMA_PASIEN']; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td><?php echo $data['NAMA_TARIF'] . ' (' . $data['NAMA_TARIF_GROUP'] . ')'; ?></td>
			<td align="right"><?php echo currFormat($data['KUANTITI']); ?></td>
			<?php if(currentModul() == 'keuangan'){ ?>
			<td align="right"><?php echo currFormat($data['KUANTITI'] * $data['TARIF_NON_KELAS']); ?></td>
			<?php } ?>
			<td><?php echo $data['NAMA_JAMINAN']; ?></td>
			<td><?php echo $data['PELAKSANA']; ?></td>
			<td><?php echo $data['PASIEN_KELUAR']; ?></td>
			<td><?php echo $data['KET_PASIEN_PULANG']; ?></td>
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
					<?php if(currentModul() == 'klinik' or currentModul() == 'igd' or currentModul() == 'kusta'){ ?>
					<input type="hidden" name="unit_id" value="<?php echo $_SESSION['SES_SIMRS_UNIT_ID']; ?>" />
					<?php }else{ ?>
                    <input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>" />
					<?php } ?>
                    <input type="hidden" name="pegawai_id" value="<?php echo $pegawai_id; ?>" />
					<input type="hidden" name="arr_karcis" value="<?php echo str_replace('"','`',$arr_karcis); ?>" />
                    <input type="hidden" name="xlsfile" value="klinik/xls_report_tindakan_dokter.php" />
                    <input type="hidden" name="xlsname" value="rpt_tindakan_poliklinik.xls" />            
        </form>