<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th width="10">No</th>
        <th width="80">Nomor MR</th>
        <th>Nama Pasien</th>
        <th width="80">Tanggal Lahir</th>
        <th width="80">Jenis Kelamin</th>
        <th>Nama Ibu</th>
        <th>Alamat</th>
        <th width="120">Kelurahan</th>
        <th width="120">Kecamatan</th>
        <th width="120">Kota</th>
		<th width="120">Register</th>
        <th width="50">Option</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_pasien, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['PASIEN_ID'];
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
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo changeDateFormat($data['TGL_LAHIR']); ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
            <td><?php echo $data['NAMA_IBU']; ?></td>
            <td><?php echo $data['ALAMAT'] . ' ' . $data['ALAMAT_RT'] . ' ' . $data['ALAMAT_RW']; ?></td>
            <td><?php echo $data['NAMA_KELURAHAN']; ?></td>
            <td><?php echo $data['NAMA_KECAMATAN']; ?></td>
            <td><?php echo $data['NAMA_KOTA']; ?></td>
			<td><?php echo $data['USER_PENDAFTARAN']; ?></td>
            <td align="center"><?php echo str_replace('###', $data['NOMR'], $action); ?></td>
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