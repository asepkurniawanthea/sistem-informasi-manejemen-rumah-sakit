<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
        <th>Tanggal Operasi</th>
		<th>Jam</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
        <th>Pembayaran</th>
		<th>Klinik/Ruang/Instansi</th>
		<th>Dokter Pengirim</th>
		<th>Status Pasien</th>
		<th>Dokter</th>
		<th>Status Operasi</th>
		<th width="120">Register</th>
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
            <td align="center"><?php echo $data['TANGGAL_OPERASI']; ?></td>
			<td align="center"><?php echo $data['JAM_OPERASI']; ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo changeDateFormat($data['TGL_LAHIR']); ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
            <td><?php echo $data['NAMA_JAMINAN']; ?></td>
			<td><?php echo $data['NAMA_UNIT']; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td><?php echo $data['STATUS_PASIEN']; ?></td>
			<td><?php echo $data['DOKTER_OPERASI']; ?></td>
			<td align="center"><?php if($data['ST_OPERASI'] == '1') echo 'Selesai'; ?></td>
			<td><?php echo $data['USER_OPERASI']; ?></td>
            <td align="center">
			<?php if($data['NO_OPERASI'] == ''){ ?>
				<a href="index.php?link=<?php echo md5('operasiformpasienperiksa'); ?>&idx=<?php echo $data['OPERASI_ID']; ?>&ord=<?php echo$data['JNS_ORDER']; ?>&msk=<?php echo$data['ST_MASUK']; ?>" >operasi</a>
			<?php }else{ if($_SESSION['SES_SIMRS_ADMIN'] == '1'){ ?>
				<a href="index.php?link=<?php echo md5('operasiformeditpasienperiksa'); ?>&idx=<?php echo $data['OPERASI_ID']; ?>&ord=<?php echo$data['JNS_ORDER']; ?>&msk=<?php echo$data['ST_MASUK']; ?>" >ubah</a>
			<?php }else{ ?>
				<a href="index.php?link=<?php echo md5('operasiviewpasienperiksa'); ?>&idx=<?php echo $data['OPERASI_ID']; ?>&ord=<?php echo$data['JNS_ORDER']; ?>&msk=<?php echo$data['ST_MASUK']; ?>" >detail</a>
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