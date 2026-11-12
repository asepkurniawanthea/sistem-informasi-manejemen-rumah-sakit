<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th width="30">No</th>
        <th width="100">Tanggal</th>
		<th width="100">Nomor MR/ NIK</th>
		<th>Nama Pasien</th>
		<th>Alamat</th>
		<th>Klinik/ Ruang</th>
        <th>Pembayaran</th>
		<th>Resep</th>
		<th width="100">Status</th>
		<th width="100">Option</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_farmasi, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = '';
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
            <td align="center"><?php echo $data['TANGGAL_KELUAR']; ?></td>
            <td align="center"><?php if(strlen($data['NIK']) == 6){ echo formatNomr($data['NIK']); }else{ echo $data['NIK']; } ?></td>
			<td><?php echo $data['NAMA_PELANGGAN']; ?></td>
			<td><?php echo $data['ALAMAT']; ?></td>
            <td><?php echo $data['INSTANSI_PENGIRIM']; ?></td>
            <td><?php echo $data['NAMA_JAMINAN']; ?></td>
			<td><?php if($data['JENIS_PENGELUARAN'] == '1') echo 'Rawat Jalan'; if($data['JENIS_PENGELUARAN'] == '2') echo 'Rawat Inap'; if($data['JENIS_PENGELUARAN'] == '3') echo 'Penjualan Mandiri'; ?></td>
			<td align="center"><?php if($data['ST_BAYAR'] == 0) echo 'Lunas'; ?></td>
            <td align="center"><?php 
			$link = str_replace('###', $data['FARMASI_ID'], $action);
			$link = str_replace('$$$', $data['JENIS_PENGELUARAN'], $link);	
			echo $link; ?></td>
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