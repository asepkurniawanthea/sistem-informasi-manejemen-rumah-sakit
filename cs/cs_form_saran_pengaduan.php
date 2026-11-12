<?php
$tgl_1 = '';
if (isset($_SESSION['saranpengaduan_tgl_1']))
    $tgl_1 = $_SESSION['saranpengaduan_tgl_1'];
$tgl_2 = '';
if (isset($_SESSION['saranpengaduan_tgl_1']))
    $tgl_2 = $_SESSION['saranpengaduan_tgl_2'];
if (isset($_GET['tgl_1'])) {
    $tgl_1 = $_GET['tgl_1'];
    $_SESSION['saranpengaduan_tgl_1'] = $_GET['tgl_1'];
}
if (isset($_GET['tgl_2'])) {
    $tgl_2 = $_GET['tgl_2'];
    $_SESSION['saranpengaduan_tgl_2'] = $_GET['tgl_2'];
}

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	
?>
<form name="search" method="get" action="index.php">
    <table class="tableform" border="0">
        <tr>
            <td>Tanggal</td>
            <td><input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/></td>
			<td>&nbsp;</td>
            <td>&nbsp;</td>	
        </tr>
		<tr>
			<td>S/d</td>
            <td><input type="text" name="tgl_2" id="tgl_2" value="<?php echo $tgl_2; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/></td>	
			<td align="right" colspan="2">
			<input type="submit" value="cari" class="myButton" />&nbsp;
			<a href="index.php?link=733925474c6fb6fcf0f917b9364a43af">
			<input type="button" value="saran - pengaduan baru" class="myButton" />
			</a></td>
		</tr>
    </table>
    <input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>" />
</form>		
    <table border="1" class="tableData" id="tfhover">
        <tr>
			<th>No</th>
			<th>Tanggal</th>
			<th>Nama</th>
			<th>Alamat</th>
			<th>No Telp</th>
			<th>Email</th>
			<th>Perihal</th>
			<th>Deskripsi</th>
			<th>Media</th>
			<th>Followup</th>
			<th>Option</th>
		</tr>
        <?php
		$connect = mysql_connect($hostname_8, $username_8, $password_8) or die(mysql_error());
		mysql_select_db($database_8, $connect) or die(mysql_error());

        $sql = 'SELECT t_saran_pengaduan.SARAN_PENGADUAN_ID,t_saran_pengaduan.NAMA,t_saran_pengaduan.ALAMAT,
				t_saran_pengaduan.NO_CONTACT,t_saran_pengaduan.EMAIL,t_saran_pengaduan.PERIHAL,t_saran_pengaduan.DESKRIPSI,
				t_saran_pengaduan.TGL_SARAN,t_saran_pengaduan.FOLLOW_UP,t_saran_pengaduan.MEDIA
				FROM t_saran_pengaduan
				WHERE STR_TO_DATE(DATE_FORMAT(t_saran_pengaduan.TGL_SARAN,"%d/%m/%Y"),"%d/%m/%Y") >= ' . $tgl_filter_1 . '
				AND STR_TO_DATE(DATE_FORMAT(t_saran_pengaduan.TGL_SARAN,"%d/%m/%Y"),"%d/%m/%Y") <= ' . $tgl_filter_2 . '
				ORDER BY t_saran_pengaduan.TGL_SARAN';
		$no = 0;
		$pager = new PS_Pagination($connect, $sql, 15, 15, '', 'index.php?link=' . $_REQUEST['link']);
		$rs = $pager->paginate();
		if (!$rs)
        die(mysql_error());
		while ($data = mysql_fetch_array($rs)) {
        $id = $data['SARAN_PENGADUAN_ID'];
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
            <td align="center"><?php echo $data['TGL_SARAN']; ?></td>
            <td><?php echo $data['NAMA']; ?></td>
			<td><?php echo $data['ALAMAT']; ?></td>
			<td><?php echo $data['NO_CONTACT']; ?></td>
			<td><?php echo $data['EMAIL']; ?></td>
			<td><?php echo $data['PERIHAL']; ?></td>
			<td><?php echo $data['DESKRIPSI']; ?></td>
			<td><?php if($data['MEDIA'] == '1') echo 'Aplikasi CS';
					if($data['MEDIA'] == '2') echo 'Telepon';
					if($data['MEDIA'] == '3') echo 'Surat';
					if($data['MEDIA'] == '4') echo 'Langsung';
					if($data['MEDIA'] == '5') echo 'Lain-lain';?></td>
			<td align="center">
			<input type="checkbox" name="followup" id="followup_<?php echo $no; ?>" value="1" 
				<?php if(!empty($data['FOLLOW_UP'])) echo 'checked="checked"'; ?>  
				onclick="JavaScript : centang_opt('followup_<?php echo $no; ?>','<?php echo $id; ?>');" />
				<?php if(!empty($data['FOLLOW_UP'])) echo '<br />' . $data['FOLLOW_UP']; ?>  
			</td>
			<td align="center"><?php if($data['MEDIA'] != '1'){?>
					<a href="index.php?link=733925474c6fb6fcf0f917b9364a43af&idx=<?php echo $data['NAMA']; ?>">buka</a>
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
		</form>	
<div id="msg_ta"></div>		
<script language="JavaScript" >
function centang_opt(ck,id){
	if(document.getElementById(ck).checked){
		MyAjaxRequest('msg_ta','index.php?ajaxrequest=followup&opt=1&id=' + id);
		return false;
	}else{
		MyAjaxRequest('msg_ta','index.php?ajaxrequest=followup&opt=2&id=' + id);
		return false;
	}
}
</script>		