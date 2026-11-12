<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
        <th>Tanggal Order</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Alamat</th>
        <th>Klinik/Ruang/Instansi</th>
		<th>Dokter Pengirim</th>
        <th>Pembayaran</th>
		<th colspan="2">Cito/Status</th>
		<th>Pasien Baru</th>
		<th>Register</th>
        <th>Option</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_kunjungan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['PENUNJANG_ID'];
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
            <td align="center"><?php echo $data['TANGGAL_DAFTAR']; ?></td>
            <td align="center"><?php if(strlen($data['NOMR']) == 6){ echo formatNoMR($data['NOMR']); }else{ echo $data['NOMR']; } ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo changeDateFormat($data['TGL_LAHIR']); ?></td>
            <td><?php echo $data['ALAMAT']; ?></td>
            <td><?php $nama_unit = $data['NAMA_UNIT'];
			if($nama_unit == '') $nama_unit = $data['NAMA_RUANG'];
			if($nama_unit == '') $nama_unit = $data['INSTANSI_PENGIRIM'];
			if($data['EXT_NAMA_UNIT'] != '') $nama_unit .= '-' . $data['EXT_NAMA_UNIT'];
			echo $nama_unit; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td><?php echo $data['NAMA_JAMINAN'];  ?></td>
			<td align="center"><?php if($data['CITO'] > 0) echo '&radic;'; ?></td>
			<td align="center"><?php if($data['ST_PERIKSA'] == 0) echo 'Selesai'; ?></td>
			<td align="center"><?php if($data['ST_BARU'] == '1') echo '&radic;'; ?></td>
			<td><?php echo $data['USER_DIAGNOSA']; ?></td>
            <td align="center">
			<a href="index.php?link=<?php echo md5('laboratoriumformperiksa'); ?>&idx=<?php echo $id; ?>&ord=<?php echo strtolower($data['JNS_ORDER']); ?>&no=<?php echo $data['NO_TARIF']; ?>" >proses</a>
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