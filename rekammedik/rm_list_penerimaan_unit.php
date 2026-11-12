<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
        <th>Tanggal Masuk</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
		<th>RM Kirim</th>
		<th>Klinik</th>
        <th>Klinik Terima</th>
		<th>Pasien Pulang</th>
        <th>Ranap</th>
		<th>Ranap Terima</th>
		<th>Pasien Pulang</th>
        <th>RM Terima</th>
        <th>Option</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_kunjungan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['RM_TRACER_ID'];
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
            <td align="center"><?php echo changeDateFormat($data['TANGGAL_DAFTAR']); ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo $data['RM_KIRIM']; ?></td>
			<td><?php echo $data['NAMA_UNIT']; ?></td>
            <td align="center"><?php echo $data['IRJA_TERIMA']; ?></td>
			<td><?php echo $data['KET_PASIEN_PULANG']; ?></td>
			<td><?php echo $data['NAMA_RUANG']; ?></td>
			<td align="center"><?php echo $data['ADMS_TERIMA'] . '<br />' . $data['NAMA_RUANG_TERIMA']; ?></td>
			<td align="center"><?php echo $data['KET_PASIEN_PULANG_RANAP']; ?></td>
            <td align="center"><?php echo $data['RM_TERIMA']; ?></td>
			<td align="center">
			<?php $act = '';
			if(currentModul() == 'klinik' or currentModul() == 'igd' or currentModul() == 'kusta'){
				if(empty($data['IRJA_TERIMA'])) $act = 'onclick="javascript : terima_rm_unit(' . $data['RM_TRACER_ID'] . ',' . $data['NOMR'] . '); return false;"';
			}else if(currentModul() == 'rawat inap'){
				$act = 'onclick="javascript : terima_rm_unit(' . $data['RM_TRACER_ID'] . ',' . $data['NOMR'] . '); return false;"';
			}else{
				if(empty($data['ADMS_TERIMA'])) $act = 'onclick="javascript : terima_rm_unit(' . $data['RM_TRACER_ID'] . ',' . $data['NOMR'] . '); return false;"';
			}				
			?>
			<a href="#" <?php echo $act; ?> >terima rm</a></td>
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
<script language="javascript" type="text/javascript">
function terima_rm_unit(idx,nomr){
	window.open("index.php?popup=rmformterimaunit&idx=" + idx + "&nomr=" + nomr,"","toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=550,height=300");	
}
</script>	