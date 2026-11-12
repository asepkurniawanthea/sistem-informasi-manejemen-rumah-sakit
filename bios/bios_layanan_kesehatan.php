<?php
include('keuangan/bos_refdata.php');

if(!isset($_SESSION['ref_data_kelas'])){
	$_SESSION['ref_data_kelas'] = getBosDataRef('kelas');
}

$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
mysql_select_db($database_5, $connect_5) or die(mysql_error());

$layanan_kesehatan_id = '';
$tahun = '';
$bulan = '';
$kelas = '';
$jumlah_pasien = '';
$jumlah_hari = '';

if (isset($_POST['layanan_kesehatan_id'])) {
	$layanan_kesehatan_id = $_POST['layanan_kesehatan_id'];
    $tahun = $_POST['tahun'];
    $bulan = $_POST['bulan'];
    $kelas = $_POST['kelas'];
    $jumlah_pasien = $_POST['jumlah_pasien'];
    $jumlah_hari = $_POST['jumlah_hari'];
   
    if (!empty($layanan_kesehatan_id)) {
        mysql_query('UPDATE bos_layanan_kesehatan SET TGL_UPDATE = NOW(),
					TAHUN = "' . $tahun . '",BULAN = "' . $bulan . '",KELAS = "' . $kelas . '",
					JUMLAH_PASIEN = "' . $jumlah_pasien . '",JUMLAH_HARI = "' . $jumlah_hari . '"
					WHERE LAYANAN_KESEHATAN_ID = "' . $layanan_kesehatan_id . '"') or die(mysql_error());
    } else {
        mysql_query('INSERT INTO bos_layanan_kesehatan(TGL_UPDATE,TAHUN,BULAN,KELAS,JUMLAH_PASIEN,JUMLAH_HARI)
					VALUES(NOW(),"' . $tahun . '","' . $bulan . '","' . $kelas . '","' . $jumlah_pasien . '",
					"' . $jumlah_hari . '")') or die(mysql_error());
    }
    $layanan_kesehatan_id = '';
	$tahun = '';
	$bulan = '';
	$kelas = '';
	$jumlah_pasien = '';
	$jumlah_hari = '';
    $msg_info = 'Simpan Data Berhasil.';
}

if (isset($_GET['ide'])) {
    $layanan_kesehatan_id = $_GET['ide'];
    $sql = 'SELECT * FROM bos_layanan_kesehatan WHERE LAYANAN_KESEHATAN_ID = ' . $layanan_kesehatan_id;
    $get = mysql_query($sql) or die(mysql_error());
    $dat = mysql_fetch_assoc($get);
    $tahun = $dat['TAHUN'];
    $bulan = $dat['BULAN'];
    $kelas = $dat['KELAS'];
    $jumlah_pasien = $dat['JUMLAH_PASIEN'];
    $jumlah_hari = $dat['JUMLAH_HARI'];
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM bos_layanan_kesehatan WHERE LAYANAN_KESEHATAN_ID = ' . $_GET['idx']) or die(mysql_error());
    $msg_info = 'Hapus Data Berhasil.';
}

$searchkey = '';
$sql_search = '';
if (!empty($_REQUEST['searchkey'])) {
    $searchkey = $_REQUEST['searchkey'];
    $sql_search = ' AND CONCAT(TAHUN,BULAN) LIKE "' . $searchkey . '%" ';
}

if (isset($_GET['idd'])) {
    $layanan_kesehatan_id = $_GET['idd'];
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $layanan_kesehatan_id; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&idx=<?php echo $layanan_kesehatan_id; ?>&searchkey=<?php echo $searchkey; ?>";
        }
    </script>
    <?php
}
?>
<form name="form1" method="post" action="index.php">
    <input type="hidden" name="layanan_kesehatan_id" id="layanan_kesehatan_id" value="<?php echo $layanan_kesehatan_id; ?>" />
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" />
    <table border="0" class="tableform" width="800">
        <tr><td>Tahun Layanan</td>
			<td><select name="tahun" id="tahun"  class="text_dt" style="width:270px;">
				<option value="" >--</option>
				<option value="2016" <?php if($tahun=='2016') echo 'selected="selected"'; ?> >2016</option>
				<option value="2017" <?php if($tahun=='2017') echo 'selected="selected"'; ?> >2017</option>
				<option value="2018" <?php if($tahun=='2018') echo 'selected="selected"'; ?> >2018</option>
				<option value="2019" <?php if($tahun=='2019') echo 'selected="selected"'; ?> >2019</option>
				<option value="2020" <?php if($tahun=='2020') echo 'selected="selected"'; ?> >2020</option>
				</select>
				</td>
		</tr>
		<tr><td>Bulan Layanan</td>
			<td><select name="bulan" id="bulan"  class="text_dt" style="width:270px;">
				<option value="" >--</option>
				<option value="01" <?php if($bulan=='01') echo 'selected="selected"'; ?> >01</option>
				<option value="02" <?php if($bulan=='02') echo 'selected="selected"'; ?> >02</option>
				<option value="03" <?php if($bulan=='03') echo 'selected="selected"'; ?> >03</option>
				<option value="04" <?php if($bulan=='04') echo 'selected="selected"'; ?> >04</option>
				<option value="05" <?php if($bulan=='05') echo 'selected="selected"'; ?> >05</option>
				<option value="06" <?php if($bulan=='06') echo 'selected="selected"'; ?> >06</option>
				<option value="07" <?php if($bulan=='07') echo 'selected="selected"'; ?> >07</option>
				<option value="08" <?php if($bulan=='08') echo 'selected="selected"'; ?> >08</option>
				<option value="09" <?php if($bulan=='09') echo 'selected="selected"'; ?> >09</option>
				<option value="10" <?php if($bulan=='10') echo 'selected="selected"'; ?> >10</option>
				<option value="11" <?php if($bulan=='11') echo 'selected="selected"'; ?> >11</option>
				<option value="12" <?php if($bulan=='12') echo 'selected="selected"'; ?> >12</option>
				</select></td>
		</tr>
		<tr><td>Kelas</td>
			<td><select name="kelas" id="kelas"  class="text_dt" style="width:270px;">
			<option value="" >--</option>
			<?php
			$json_response = json_decode($_SESSION['ref_data_kelas'],true);
			$json_data = $json_response['ref_kelas'];
			foreach($json_data as $row){
				$selected = '';
				if($kelas == $row['kode_kelas'] . '--' . $row['nama_kelas']) $selected = 'selected="selected"'; 
				echo '<option value="' . $row['kode_kelas'] . '--' . $row['nama_kelas'] . '" ' . $selected . ' >' . $row['kode_kelas'] . '--' . $row['nama_kelas'] . '</option>';
			} ?>	
			</select></td>
		</tr>
		<tr><td>Jumlah Pasien</td>
			<td><input name="jumlah_pasien" type="text" id="jumlah_pasien"  class="text_dt" value="<?php echo $jumlah_pasien; ?>" style="width:260px;text-align:right;" /></td>
		</tr>	
		<tr><td>Jumlah Hari</td>
			<td><input name="jumlah_hari" type="text" id="jumlah_hari"  class="text_dt" value="<?php echo $jumlah_hari; ?>" style="width:260px;text-align:right;" /></td>
		</tr>
		<tr><td>&nbsp;</td>
			<td><input type="submit" id="simpan"  class="myButton" value="simpan" /></td>
		</tr>
    </table>
</form>
<br />
<form name="form2" method="post" action="index.php">
   <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <table border="0" width="100%" class="tableNav">
        <tr>
            <td align="right">
                <input type="text" name="searchkey" class="text_dt" id="searchkey" value="<?php echo $searchkey; ?>" />&nbsp;&nbsp;<input type="submit" value="cari" class="myButton" />
            </td>			
        </tr> 
	</table>		
    <table border="1" class="tableData" id="tfhover">
        <tr>
            <th width="50">No</th>
			<th width="50">Id</th>
			<th>Tahun</th>
			<th>Bulan</th>
			<th>Kelas</th>
			<th>Jumlah Pasien</th>
			<th>Jumlah Hari</th>
			<th>Tgl Update</th>
			<th>Publis</th>
			<th width="100">Option</th>
		</tr>
        <?php
        $sql = 'SELECT bos_layanan_kesehatan.LAYANAN_KESEHATAN_ID,bos_layanan_kesehatan.TGL_UPDATE,bos_layanan_kesehatan.TAHUN,
				bos_layanan_kesehatan.BULAN,bos_layanan_kesehatan.KELAS,bos_layanan_kesehatan.JUMLAH_PASIEN,bos_layanan_kesehatan.JUMLAH_HARI,
				bos_layanan_kesehatan.PUBLISH
				FROM bos_layanan_kesehatan 
				WHERE 1 ' . $sql_search . ' 
				ORDER BY bos_layanan_kesehatan.TAHUN DESC,bos_layanan_kesehatan.BULAN DESC';
        $no = 0;
		$pager = new PS_Pagination($connect, $sql, 20, 5, '&searchkey=' . $searchkey, 'index.php?link=' . $_REQUEST['link']);
        $rs = $pager->paginate();
        if (!$rs)
            die(mysql_error());
        while ($dat = mysql_fetch_array($rs)) {
            echo '<tr><td align="center">';
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
        
			echo '</td><td align="center">' . $dat['LAYANAN_KESEHATAN_ID'] . '</td>';
            echo '<td>' . $dat['TAHUN'] . '</td>';
            echo '<td>' . $dat['BULAN'] . '</td>';
            echo '<td>' . $dat['KELAS'] . '</td>';
			echo '<td align="right">' . currFormat($dat['JUMLAH_PASIEN']) . '</td>';
			echo '<td align="right">' . currFormat($dat['JUMLAH_HARI']) . '</td>';
			echo '<td>' . $dat['TGL_UPDATE'] . '</td>';
			echo '<td align="center">'; ?>
				<input type="checkbox" name="publish" id="publish_<?php echo $no; ?>" value="1" 
				<?php if($dat['PUBLISH']== '1') echo 'checked="checked"'; ?>  
				onclick="JavaScript : centang_opt('publish_<?php echo $no; ?>','<?php echo $dat['LAYANAN_KESEHATAN_ID']; ?>');" />        
			<?php echo '</td><td><a href="index.php?link=' . $_REQUEST['link'] . '&ide=' . $dat['LAYANAN_KESEHATAN_ID'] . '&searchkey=' . $searchkey . '">edit</a>&nbsp;
			<a href="index.php?link=' . $_REQUEST['link'] . '&idd=' . $dat['LAYANAN_KESEHATAN_ID'] . '&searchkey=' . $searchkey . '">hapus</a></td></tr>';
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
<div id="bospublish"></div>		
<script language="JavaScript" >
function centang_opt(ck,id){
	if(document.getElementById(ck).checked){
		if(confirm('Publish ?')){
			MyAjaxRequest('bospublish','index.php?ajaxrequest=bospublish&opt=1&data=layanankes&id=' + id);
		}else{
			document.getElementById(ck).checked = false;
		}
		return false;
	}else{
		MyAjaxRequest('bospublish','index.php?ajaxrequest=bospublish&opt=2&data=layanankes&id=' + id);
		return false;
	}
}
</script>		