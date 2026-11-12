<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
        <th>Masuk</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
        <th>Kunjungan<br />Baru</th>
        <th>Pembayaran</th>
		<th>Dokter DPJP</th>
		<th>Pengirim</th>
		<th>Ambil<br/>Resep</th>
		<th>Keluar</th>
		<th>Status Pulang</th>
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
        $id = $data['HEMODIALISA_ID'];
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
            <td align="center"><?php echo $data['PASIEN_MASUK']; ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo changeDateFormat($data['TGL_LAHIR']); ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
            <td align="center"><?php if($data['ST_BARU_LAMA'] == '1') echo '&radic;'; ?></td>
            <td><?php echo $data['NAMA_JAMINAN']; ?></td>
			<td><?php echo $data['NAMA_DOKTER_DPJP']; ?></td>
			<td><?php $nama_unit = '';
				if($data['NAMA_UNIT'] != '') $nama_unit .= $data['NAMA_UNIT'];
				if($data['NAMA_RUANG'] != '') $nama_unit .= $data['NAMA_RUANG'];
				if($data['NAMA_PEGAWAI'] != '') $nama_unit .= '/' . $data['NAMA_PEGAWAI'];
				echo $nama_unit; ?></td>
			<td align="center"><?php if($data['AMBIL_RESEP'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php echo $data['PASIEN_KELUAR']; ?></td>
			<td><?php echo $data['KET_PASIEN_PULANG']; ?></td>
			<td><?php echo $data['USER_IRJA']; ?></td>
            <td align="center">
			<?php //if($data['NO_KLINIK'] == ''){ ?>
				<a href="index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&idx=<?php echo $data['HEMODIALISA_ID']; ?>&ord=<?php echo $data['JNS_ORDER']; ?>" >periksa</a>
			<?php //}else{ if($_SESSION['SES_SIMRS_ADMIN'] == '1'){ ?>
				<!--<a href="index.php?link=<?php echo md5('hemodialisaformeditpasienperiksa'); ?>&idx=<?php echo $data['HEMODIALISA_ID']; ?>&ord=<?php echo $data['JNS_ORDER']; ?>" >ubah</a>-->
			<?php //}else{ ?>
				<!--<a href="index.php?link=<?php echo md5('hemodialisaviewpasienperiksa'); ?>&idx=<?php echo $data['HEMODIALISA_ID']; ?>&ord=<?php echo $data['JNS_ORDER']; ?>" >detail</a>-->
			<?php //} } ?>
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