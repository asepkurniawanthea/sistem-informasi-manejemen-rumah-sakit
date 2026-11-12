<style>
td.menu{background:#FFFFFF}
table.menu{
	font-size:100%;
	position:absolute;
	right:5px;
	visibility:hidden;
	border:1px solid red;
	padding:1;
	spacing:1;
    font-size:12px;    
    width:140px;
    height:180px;
    border-width: 1px;
    border-color: #FF0000;
    border-collapse: collapse;
	z-index : 99999999;
}

a.menupopup:link {
	border:none;	
    color: #000000;
}
a.menupopup:hover {
	border:none;	
    color: #FF0000;
 }
a.menupopup:active {
	border:none;	
    color: #000000;
}
a.menupopup:visited {
	border:none;	
    color: #000000;
}
</style>
<script>
function showmenu(elmnt)
{
document.getElementById(elmnt).style.visibility="visible";
}
function hidemenu(elmnt)
{
document.getElementById(elmnt).style.visibility="hidden";
}
</script>
<table border="1" class="tableData" id="tfhover" >
        <tr>
        <th rowspan="3">No</th>
        <th rowspan="3">Tanggal<br />Masuk</th>
		<th rowspan="3">Tanggal<br />Keluar</th>
        <th rowspan="3">Nomor<br />MR</th>
		<th rowspan="3">Nomor SEP</th>
        <th rowspan="3">Nama Pasien</th>
        <th rowspan="3">Tanggal<br />Lahir</th>
        <th rowspan="3">Jenis<br />Kelamin</th>
        <th rowspan="3">Klinik</th>
		<th rowspan="3">Dokter</th>
        <th rowspan="3">Pembayaran</th>
		<th colspan="7">Status Klaim </th>
		<th rowspan="3">option</th>
    </tr>
    <tr>
      <th rowspan="2">Buat</th>
      <th rowspan="2">Update</th>
      <th colspan="2">Grouper</th>
      <th rowspan="2">Final</th>
      <th rowspan="2">Reedit</th>
      <th rowspan="2">Kirim</th>
    </tr>
    <tr>
      <th>St 1 </th>
      <th>St 2 </th>
    </tr>
    <?
    $no = 0;
    $pager = new PS_Pagination($connect, $qry_klaim, 10, 5, $extparam, 'index.php?link=' . $_REQUEST['link']);
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
            <td align="center"><?php echo changeDateFormat($data['TANGGAL_MASUK']); ?></td>
			<td align="center"><?php echo changeDateFormat($data['TANGGAL_KELUAR']); ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
			<td><?php echo $data['NO_SEP']; ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo changeDateFormat($data['TGL_LAHIR']); ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
            <td><?php echo $data['NAMA_UNIT']; 
			if($data['JML_PELAYANAN'] > 1) echo ' (' . $data['JML_PELAYANAN'] . ')'; ?></td>
            <td><?php echo $data['NAMA_PEGAWAI']; ?></td>
            <td><?php echo $data['NAMA_JAMINAN']; ?></td>
            <td align="center"><?php if($data['KLAIM_BARU'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php if($data['UPDATE_KLAIM'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php if($data['GROUPER_STAGE_1'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php if($data['GROUPER_STAGE_2'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php if($data['KLAIM_FINAL'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php if($data['KLAIM_REEDIT'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php if($data['KLAIM_SEND'] == '1') echo '&radic;'; ?></td>
			<td align="center" onmouseover="showmenu('tutorials<?php echo ($hal * 10) + $no; ?>')" onmouseout="hidemenu('tutorials<?php echo ($hal * 10) + $no; ?>')">
			<?php $mh = 0;
			if(isset($_GET['kusta'])) $mh = 1; ?>
			<a href="#">action</a><br>
			   <table class="menu" id="tutorials<?php echo ($hal * 10) + $no; ?>" width="120">
			   <tr><td class="menu"><a href="#" class="menupopup" onclick="klaim_baru('<?php echo $data['NO_PESERTA']; ?>','<?php echo $data['NO_SEP']; ?>','<?php echo $data['NOMR']; ?>','<?php echo str_replace("'","`",$data['NAMA_PASIEN']); ?>','<?php echo $data['TGL_LAHIR']; ?>','<?php echo $data['JNS_KELAMIN2']; ?>','<?php echo $data['IRJA_ID']; ?>','2','<?php echo $mh; ?>');" >> buat klaim</a></td></tr>
			   <tr><td class="menu"><a href="#" class="menupopup" onclick="updatepasien_show('<?php echo $data['NOMR']; ?>','<?php echo $data['NO_SEP']; ?>','<?php echo $data['IRJA_ID']; ?>','2','<?php echo $mh; ?>');" >> update data pasien</a></td></tr>
			   <tr><td class="menu"><a href="#" class="menupopup" onclick="hapus_pasien('<?php echo $data['NO_SEP']; ?>','<?php echo $data['NOMR']; ?>','<?php echo $data['IRJA_ID']; ?>','2','<?php echo $mh; ?>');" >> hapus data pasien</a></td></tr>
			   <tr><td class="menu"><a href="#" class="menupopup" onclick="updateklaim_show('<?php echo $data['NOMR']; ?>','<?php echo $data['NO_SEP']; ?>','<?php echo $data['TANGGAL_MASUK']; ?>','<?php echo $data['JENIS_BAYAR_ID']; ?>','<?php echo $data['IRJA_ID']; ?>','2','<?php echo $mh; ?>');" >> isi & update data klaim</a></td></tr>
			   <tr><td class="menu"><a href="#" class="menupopup" onclick="groupingfinal_show('<?php echo $data['NOMR']; ?>','<?php echo str_replace("'","`",$data['NAMA_PASIEN']); ?>','<?php echo $data['NO_SEP']; ?>','<?php echo $data['IRJA_ID']; ?>','2','<?php echo $mh; ?>');" >> grouping & final klaim</a></td></tr>
			   <tr><td class="menu"><a href="#" class="menupopup" onclick="klaim_reedit('<?php echo $data['NO_SEP']; ?>','<?php echo $data['IRJA_ID']; ?>','2','<?php echo $mh; ?>');" >> reedit klaim</a></td></tr>
			   <tr><td class="menu"><a href="#" class="menupopup" onclick="send_data('<?php echo $data['NO_SEP']; ?>','<?php echo $data['IRJA_ID']; ?>','2','<?php echo $mh; ?>');" >> kirim data klaim</a></td></tr>
			   <tr><td class="menu"><a href="#" class="menupopup" onclick="klaimdetail_show('<?php echo $data['NOMR']; ?>','<?php echo str_replace("'","`",$data['NAMA_PASIEN']); ?>','<?php echo $data['NO_SEP']; ?>','<?php echo $data['IRJA_ID']; ?>','2','<?php echo $mh; ?>');" >> detail klaim</a></td></tr>
			   <tr><td class="menu"><a href="#" class="menupopup" onclick="klaim_status('<?php echo $data['NO_SEP']; ?>','<?php echo $mh; ?>');" >> status klaim</a></td></tr>
			   <tr><td class="menu"><a href="#" class="menupopup" onclick="hapus_klaim('<?php echo $data['NO_SEP']; ?>','<?php echo $mh; ?>','<?php echo $data['IRJA_ID']; ?>','2');" >> hapus klaim</a></td></tr>
			   <tr><td class="menu"><a href="#" class="menupopup" onclick="unduh_arsip('<?php echo $data['NO_SEP']; ?>','<?php echo $mh; ?>','<?php echo $data['IRJA_ID']; ?>','2');" >> unduh arsip</a></td></tr>
			   </table>
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
<script language="javascript">
function updateklaim_show(nomr,nosep,tanggal,jenis_bayar,idx,jnsrawat,mh){
	window.open('index.php?popup=inacbgformupdateklaim&nomr=' + nomr + '&nosep=' + nosep + '&tanggal=' + tanggal + '&jenis_bayar=' + jenis_bayar + '&idx=' + idx + '&jnsrawat=' + jnsrawat + '&mh=' + mh,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=900,height=650');
}

function groupingfinal_show(nomr,nama_pasien,nosep,idx,jnsrawat,mh){
	window.open('index.php?popup=inacbgformgrouping&nomr=' + nomr + '&nosep=' + nosep + '&idx=' + idx + '&jnsrawat=' + jnsrawat + '&mh=' + mh + '&nama_pasien=' + nama_pasien,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=900,height=650');
}

function updatepasien_show(nomr,nosep,idx,jnsrawat,mh){
	window.open('index.php?popup=inacbgformupdatepasien&nomr=' + nomr + '&nosep=' + nosep + '&idx=' + idx + '&jnsrawat=' + jnsrawat + '&mh=' + mh,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=900,height=350');
}

function klaimdetail_show(nomr,nama_pasien,nosep,idx,jnsrawat,mh){
	window.open('index.php?popup=inacbgformdetailklaim&nomr=' + nomr + '&nosep=' + nosep + '&idx=' + idx + '&jnsrawat=' + jnsrawat + '&mh=' + mh + '&nama_pasien=' + nama_pasien,'','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=900,height=650');
}

function unduh_arsip(sep,mh,id,rawat){
	if(sep == ''){
		alert('Nomor SEP belum diisi.');
	}else{
		window.open('<?php echo currentURL(); ?>&eklaim=1&sep=' + sep + '&id=' + id + '&rawat=' + rawat);
	}	
}
</script>