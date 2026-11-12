<table border="1" class="tableData" id="tfhover" >
    <tr>
        <th>No</th>
        <th>Tanggal Daftar</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Jenis Kelamin</th>
        <th>Alamat</th>
        <th>Kunjungan</th>
        <th>Klinik/Unit</th>
        <th>Pembayaran</th>
		<!--<th>Diagnosa</th>
		<th>Tindakan</th>-->
		<th colspan="3" width="120">Tracer/Kirim RM/RRKRJ</th>
		<th width="120">Register</th>
        <th width="204">Option</th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_kunjungan, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
    $rs = $pager->paginate();
    if (!$rs)
        die(mysql_error());
    while ($data = mysql_fetch_array($rs)) {
        $id = $data['RAWAT_ID'];
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
            <td align="center"><?php echo changeDateFormat($data['TGL_LAHIR']); ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
            <td><?php echo $data['ALAMAT']; ?></td>
            <td align="center"><?php if($data['ST_BARU_LAMA'] == 'v'){ echo 'Baru'; }else{ if($data['ST_RUJUKAN'] == 'v') echo 'Rujukan'; } ?></td>
            <td><?php echo $data['NAMA_UNIT']; ?></td>
            <td><?php echo $data['NAMA_JAMINAN']; ?></td>
			<!--<td><?php echo $data['DIAGNOSA']; ?></td>
			<td><?php echo $data['TINDAKAN']; ?></td>-->
			<td align="center"><?php if($data['PRINT_TRACER'] == '1') echo '&radic;'; ?></td><td align="center"><?php if($data['RM_TRACER_ID'] != '') echo '&radic;'; ?></td><td align="center"><?php if($data['PRINT_RRKRJ'] == '1') echo '&radic;'; ?></td>
			<td><?php echo $data['USER_RM']; ?></td>
			<?php
			$status = 'LAMA';
			if($data['ST_BARU_LAMA'] == 'v') $status = 'BARU';
			$nama = $data['NAMA_PASIEN'];
			$nomr = formatNoMR($data['NOMR']);
			$tujuan = $data['NAMA_UNIT'];
			$tanggal = changeDateFormat($data['TANGGAL_DAFTAR']);
			$bayar = $data['NAMA_JAMINAN'];
			$petugas_array = explode('|', $data['USER_RM']);
			$petugas='';
			if (count($petugas_array)>1) $petugas = $petugas_array[1];
			?>
            <td align="center" width="125px"><a href="#" onclick="javascript : cetak_tracer('<?php echo $status; ?>','<?php echo $nama; ?>','<?php echo $nomr; ?>','<?php echo $tujuan; ?>','<?php echo $tanggal; ?>','<?php echo $bayar; ?>','<?php echo $petugas; ?>','<?php echo $data['RAWAT_ID']; ?>'); return false;"  >tracer</a>
			<?php if(empty($data['RM_TRACER_ID'])){ ?>
				<a href="#" onclick="javascript : kirim_rm('<?php echo $data['RAWAT_ID']; ?>','<?php echo $data['NOMR']; ?>'); return false;" >kirim rm</a>
			<?php }else{ ?>
				<a href="#">kirim rm</a>
			<?php } ?>
			<a href="#" onclick="javascript : cetak_rrkrj('<?php echo $data['RAWAT_ID']; ?>'); return false;"  >rrkrj</a>
			<a href="#" onclick='javascript : cetak_label("<?php echo str_replace("'","`",$data['NAMA_PASIEN']) . '","' . formatNoMR($data['NOMR']) . '","' . jenisKelamin($data['JNS_KELAMIN']) . '","' . changeDateFormat($data['TGL_LAHIR']) . '","' . $data['RAWAT_ID']; ?>"); return false;'  >label</a>
			<a href="#" onclick="javascript : cetak_kiup('<?php echo $data['RAWAT_ID']; ?>'); return false;"  >kiup</a></td>
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
			<input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>" />
			<input type="hidden" name="jaminan_id" value="<?php echo $jaminan_id; ?>" />
            <input type="hidden" name="xlsfile" value="rekammedik/xls_pasien_rawat_jalan.php" />
            <input type="hidden" name="xlsname" value="rpt_pasien_rawat_jalan.xls" />            
        </form>
<div id="trc" ></div>		
<script language="javascript" type="text/javascript">
function cetak_tracer(status,nama,nomr,tujuan,tanggal,bayar,petugas,idx){
	window.open('http://localhost/nsimrs_print/print_tracer.php?status=' + status + '&nama=' + nama + '&nomr=' + nomr + '&tujuan=' + tujuan + '&tanggal=' + tanggal + '&bayar=' + bayar + '&petugas=' + petugas,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
	MyAjaxRequest('trc','index.php?ajaxrequest=update_sttracer&idx=' + idx);
}
function cetak_rrkrj(idx){
	window.open("index.php?print=rrkrj&idx="+ idx,"RRKRJ");
}
function kirim_rm(idx,nomr){
	window.open("index.php?popup=rmformkirim&idx=" + idx + "&nomr=" + nomr,"","toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=550,height=300");	
}
function cetak_kiup(idx){
	window.open("pdf/kiupmrpasien.php?idx="+ idx,"KIUP");
}
function cetak_label(nama,nomr,jnskel,tanggal,idx){
	window.open('http://localhost/nsimrs_print/print_label.php?nama=' + nama + '&nomr=' + nomr + '&jnskel=' + jnskel + '&tanggal=' + tanggal + '&idx=' + idx,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=no,resizable=no,width=300,height=220');
}
</script>	