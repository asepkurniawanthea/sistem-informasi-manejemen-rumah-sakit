<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
        <th>Tanggal Daftar</th>
		<th>Unit</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Alamat</th>
        <th>Pengirim</th>
		<th>Dokter</th>
        <th>Pembayaran</th>
		<th>Status</th>
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
            <td><?php echo $data['NAMA_PENUNJANG']; ?></td>
			<td align="center"><?php if(strlen($data['NOMR']) > 6){ echo $data['NOMR']; }else{ echo formatNoMR($data['NOMR']); } ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo changeDateFormat($data['TGL_LAHIR']); ?></td>
            <td><?php echo $data['ALAMAT']; ?></td>
            <td><?php echo $data['NAMA_UNIT']; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td><?php echo $data['NAMA_JAMINAN'];  ?></td>
				<td align="center"><?php if($data['ST_PERIKSA'] > 0) echo 'Selesai'; ?></td>
			<td><?php echo $data['USER_PERIKSA']; ?></td>
            <td align="center">
			<a href="index.php?link=<?php echo md5('klinikviewpasienpenunjangrehabmedik'); ?>&idx=<?php echo $id; ?>&ord=<?php echo strtolower($data['JNS_ORDER']); ?>&no=<?php echo $data['NO_SJP']; ?>&up=<?php echo $data['UNIT_PENUNJANG_ID']; ?>" >detail</a>
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