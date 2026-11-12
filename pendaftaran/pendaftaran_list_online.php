<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
        <th>Tanggal Rencana Kunjungan</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
        <th>Nama Ibu</th>
        <th>Alamat</th>
        <th>Klinik Tujuan</th>
        <th>Pembayaran</th>
		<th>Dokter</th>
		<th width="120">Tanggal Daftar</th>
		<th>No Telepon</th>
        <th>Option</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_kunjungan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['DAFTAR_ID'];
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
            <td align="center"><?php echo changeDateFormat($data['TGL_RENCANA_KUNJUNGAN']); ?></td>
            <td align="center"><?php if(empty($data['NOMR'])){
				echo 'Pasien Baru';
			}else{
				echo formatNoMR($data['NOMR']); 
			} ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo changeDateFormat($data['TGL_LAHIR']); ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
            <td><?php echo $data['NAMA_IBU']; ?></td>
            <td><?php echo $data['ALAMAT']; ?></td>
            <td><?php echo $arr_unit[$data['UNIT_ID']]; ?></td>
            <td><?php echo $arr_jaminan[$data['CARA_BAYAR']]; ?></td>
			<td><?php if(isset($arr_dokter[$data['DOKTER_ID']])) echo $arr_dokter[$data['DOKTER_ID']]; ?></td>
			<td align="center"><?php echo changeDateFormat($data['TGL_DAFTAR']); ?></td>
			<td><?php echo $data['NO_CONTACT']; ?></td>
            <td align="center">
			<?php if(empty($data['NOMR'])) $link = 'bd63966c788afb9fc25039f01ff924b9&pasien=online&baru=1&ol=' . $data['DAFTAR_ID'];
			if(!empty($data['NOMR'])) $link = 'bd63966c788afb9fc25039f01ff924b9&pasien=online&nomr=' . $data['NOMR'] . '&ol='. $data['DAFTAR_ID'];
			if(empty($data['ST_KUNJUNGAN'])){ ?>
			<a href="index.php?link=<?php echo $link; ?>" >daftar</a>
			<?php } ?></td>
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