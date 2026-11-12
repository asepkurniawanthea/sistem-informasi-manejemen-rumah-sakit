<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
        <th>Tanggal Daftar</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
        <th>Alamat</th>
        <th>Kunjungan<br />Baru</th>
        <th>Pembayaran</th>
		<th>Dokter</th>
		<th>Masuk</th>
        <th>Keluar</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_kunjungan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['IRJA_ID'];
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
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo changeDateFormat($data['TGL_LAHIR']); ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
            <td><?php echo $data['ALAMAT']; ?></td>
            <td align="center"><?php if($data['ST_BARU_LAMA'] == '1') echo '&radic;'; ?></td>
            <td><?php echo $data['NAMA_JAMINAN']; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td align="center"><?php echo $data['PASIEN_MASUK']; ?></td>
			<td align="center"><?php echo $data['PASIEN_KELUAR']; ?></td>
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
					<input type="hidden" name="jaminan_id" value="<?php echo $jaminan_id; ?>" />
					<input type="hidden" name="pegawai_id" value="<?php echo $pegawai_id; ?>" />
                    <input type="hidden" name="xlsfile" value="klinik/xls_report_data_pasien.php" />
                    <input type="hidden" name="xlsname" value="rpt_pasien.xls" />            
        </form>