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
		<th>Tanggal Operasi</th>
		<th>Dokter Pelaksana Operasi</th>
		<th>Selesai</th>
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
        $id = $data['OPERASI_ID'];
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
            <td align="center"><?php echo $data['TANGGAL_ORDER']; ?></td>
            <td align="center"><?php if(strlen($data['NOMR']) == 6){ echo formatNoMR($data['NOMR']); }else{ echo $data['NOMR']; } ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo changeDateFormat($data['TGL_LAHIR']); ?></td>
            <td><?php echo $data['ALAMAT']; ?></td>
            <td><?php echo $data['NAMA_UNIT']; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td><?php echo $data['TANGGAL_OPERASI'];  ?></td>
			<td><?php echo $data['DOKTER_OPERASI'];  ?></td>
			<td align="center"><?php if($data['ST_OPERASI'] == '1') echo 'Selesai'; ?></td>
			<td><?php echo $data['USER_OPERASI'];  ?></td>
            <td align="center">
			<?php if(empty($data['ST_APPROVE'])){ ?> 
			<a href="index.php?link=<?php echo md5('operasiformjadwal'); ?>&idx=<?php echo $id; ?>&ord=<?php echo $data['JNS_ORDER']; ?>" >proses jadwal</a>
			<? }else{ 
				if($_SESSION['SES_SIMRS_ADMIN'] == '1'){ ?>
				<a href="index.php?link=<?php echo md5('operasiformeditjadwal'); ?>&idx=<?php echo $id; ?>&ord=<?php echo $data['JNS_ORDER']; ?>" >ubah</a>
				<?php }else{ ?>
				<a href="index.php?link=<?php echo md5('operasiviewjadwal'); ?>&idx=<?php echo $id; ?>&ord=<?php echo $data['JNS_ORDER']; ?>" >detail</a>
			<?php } } ?>
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