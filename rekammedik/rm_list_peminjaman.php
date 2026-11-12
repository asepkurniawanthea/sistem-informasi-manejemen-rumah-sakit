<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th><th>Nomor MR</th><th>Nama Pasien</th>
		<th>Tanggal Pinjam</th><th>Tanggal Kembali</th><th>Peminjam</th><th>Unit/Instansi</th><th>Register</th><th>Option</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_kunjungan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['PEMINJAMAN_RM_ID'];
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
            <td align="center"><?php echo $data['TGL_PINJAM']; ?></td>
			<td align="center"><?php echo $data['TGL_KEMBALI']; ?></td>
            <td><?php echo $data['NAMA_PEMINJAM']; ?></td>
            <td><?php echo $data['INSTANSI']; ?></td>
			<td><?php echo $data['USER_RM']; ?></td>
            <td align="center"><a href="index.php?link=<?php echo md5('rmviewpeminjaman'); ?>&idx=<?php echo $id; ?>" >detail</a>
			<?php if($data['TGL_KEMBALI'] == ''){ ?>
			<a href="index.php?link=<?php echo md5('rmformpengembalian'); ?>&idx=<?php echo $id; ?>" >kembali</a>
			<?php } ?>
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