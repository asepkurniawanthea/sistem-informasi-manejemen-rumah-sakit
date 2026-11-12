<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
        <th>Masuk</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
		<th>Alamat</th>
		<th>No Telepon</th>
        <th>Kunjungan<br />Baru</th>
        <th>Pembayaran</th>
		<th>No Kartu</th>
		<th>Poliklinik/ Ruang</th>
		<th>Dokter</th>
		<th>Keluar</th>
		<th>Status Pulang</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_kunjungan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['IRJA_ID'];
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
            <td align="center"><?php echo $data['TGL_LAHIR']; ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
			<td><?php $alamat = ''; 
				if($data['ALAMAT'] != '') $alamat .= $data['ALAMAT'];
				if($data['ALAMAT_RT'] != '') $alamat .= ' Rt.' . $data['ALAMAT_RT'];
				if($data['ALAMAT_RW'] != '') $alamat .= ' Rw.' . $data['ALAMAT_RW'];
				if($data['NAMA_KELURAHAN'] != '') $alamat .= ' ' . $data['NAMA_KELURAHAN'];
				if($data['NAMA_KECAMATAN'] != '') $alamat .= ' ' . $data['NAMA_KECAMATAN'];
				if($data['NAMA_KOTA'] != '') $alamat .= ' ' . $data['NAMA_KOTA'];
				echo $alamat; ?></td>
			<td><?php 
			$no_telepon = $data['NO_TELEPON'];
			$no_telepon_baru = '';
			if(strlen($no_telepon) >= 10){
				if(substr($no_telepon,0,2) == '08'){
					$no_telepon_baru = '628' . substr($no_telepon,2,strlen($no_telepon) - 2);
				}else if(substr($no_telepon,0,4) == '+628'){
					$no_telepon_baru = substr($no_telepon,1,strlen($no_telepon) - 1);	
				}else{
					$no_telepon_baru = $no_telepon;
				}	
			}	
			if(substr($no_telepon_baru,0,3) == '628'){
				echo '<div onclick="openwhatsapp(' . $no_telepon_baru . ');"><img src="image/whatsapp.png" width="15" height="15" style="float:left;">&nbsp;' . $no_telepon . '</div>';	
			}else{
				echo $no_telepon;
			}
			?></td>
            <td align="center"><?php if($data['ST_BARU_LAMA'] == '1') echo '&radic;'; ?></td>
            <td><?php echo $data['NAMA_JAMINAN']; ?></td>
			<td><?php echo $data['NO_PESERTA']; ?></td>
			<td><?php echo $data['NAMA_UNIT']; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td align="center"><?php echo $data['PASIEN_KELUAR']; ?></td>
			<td><?php echo $data['KET_PASIEN_PULANG']; ?></td>
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
<form id="xls_export" name="xls_export" method="post">
    <input type="hidden" name="page_to_excel" value="1" />
    <input type="hidden" name="tgl_1" value="<?php echo $tgl_1; ?>" />
    <input type="hidden" name="tgl_2" value="<?php echo $tgl_2; ?>" />
	<input type="hidden" name="searchkey" value="<?php echo $searchkey; ?>" />
	<input type="hidden" name="jaminan_id" value="<?php echo $jaminan_id; ?>" />
	<input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>" />
    <input type="hidden" name="xlsfile" value="ipaap/xls_report_rajal.php" />
    <input type="hidden" name="xlsname" value="rpt_rawat_jalan.xls" />            
</form>		
<script language="javascript">
function openwhatsapp(phone){
	window.open('https://wa.me/' + phone);
}	
</script>		