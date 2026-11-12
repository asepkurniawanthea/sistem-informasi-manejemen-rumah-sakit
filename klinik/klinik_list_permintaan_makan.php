<table border="1" class="tableData" id="tfhover" >
    <tr>
		<th>No</th>
		<th>Tanggal</th>
		<th>Waktu Makan</th>
		<th>Nomor MR</th>      
		<th>Nama Pasien</th>
		<th>Tgl Lahir</th>
		<th>Diagnosa</th>
		<th>Alergi</th>
		<th>Diet</th>
		<th>Vegetarian</th>
		<th>Puasa</th>
		<th>Bentuk Makan</th>
		<th>Register</th>
		<th>Option</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_menugizi, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
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
				<td align="center"><?php echo $data['TANGGAL_PERMINTAAN']; ?></td>
				<td align="center"><?php echo $data['WAKTU_MAKAN']; ?></td>
				<td><?php echo formatNomr($data['NOMR']); ?></td>
				<td><?php echo $data['NAMA_PASIEN']; ?></td>
				<td align="center"><?php echo changeDateFormat($data['TGL_LAHIR']) . ' [' . $data['JNS_KELAMIN'] . ']'; ?></td>
				<td><?php echo str_replace('||',', ',$data['DIAGNOSA']); ?></td>
				<td><?php echo str_replace('||',', ',$data['ALERGI']); ?></td>
				<td><?php echo str_replace('||',', ',$data['DIET']); ?></td>
				<td align="center"><?php if($data['VEGETARIAN'] == '1') echo '&radic;'; ?></td>
				<td align="center"><?php if($data['PUASA'] == '1') echo '&radic;'; ?></td>
				<td><?php echo $data['JENIS_MAKAN']; ?></td>
				<td><?php echo $data['USER_UNIT']; ?></td>
				<td align="center">
				<a href="index.php?link=940994c9c151f91d8c5f3756773551a4&idm=<?php echo $data['GIZI_PERMINTAAN_ID']; ?>">ubah</a>
				</td>
        </tr>
	<?php } ?>	
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