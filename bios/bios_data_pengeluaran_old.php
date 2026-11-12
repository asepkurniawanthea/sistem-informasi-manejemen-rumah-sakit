<?php
include('keuangan/bos_refdata.php');

if(!isset($_SESSION['ref_akun_pengeluaran'])){
	$_SESSION['ref_akun_pengeluaran'] = '{"ref_pengeluaran":' . getBosDataRef('akun_pengeluaran') . '}';
}

$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
mysql_select_db($database_5, $connect_5) or die(mysql_error());

$keuangan_pengeluaran_id = '';
$tanggal = '';
$kode_akun = '';
$saldo = '';

if (isset($_POST['keuangan_pengeluaran_id'])) {
	$keuangan_pengeluaran_id = $_POST['keuangan_pengeluaran_id'];
    $tanggal = $_POST['tanggal'];
    $kode_akun = $_POST['kode_akun'];
    $saldo = $_POST['saldo'];
	
	date_default_timezone_set('UTC');
	$unix_time	= strval(time() - strtotime('1970-01-01 00:00:00'));
	$tgl_update = date('Y-m-d H:m:s', $unix_time);
   
    if (!empty($keuangan_pengeluaran_id)) {
        mysql_query('UPDATE bos_keuangan_pengeluaran SET TANGGALUPDATE = STR_TO_DATE("' . $tgl_update . '","%Y-%m-%d %H:%i:%s"),
					TANGGAL = ' . fieldDate($tanggal) . ',KODEAKUN = "' . $kode_akun . '",
					SALDO = "' . $saldo . '" WHERE KEUANGAN_PENGELUARAN_ID = "' . $keuangan_pengeluaran_id . '"') or die(mysql_error());
    } else {
        mysql_query('INSERT INTO bos_keuangan_pengeluaran(TANGGALUPDATE,TANGGAL,KODEAKUN,SALDO) VALUES(
					STR_TO_DATE("' . $tgl_update . '","%Y-%m-%d %H:%i:%s"),' . fieldDate($tanggal) . ',
					"' . $kode_akun . '","' . $saldo . '")') or die(mysql_error());
    }
    $keuangan_pengeluaran_id = '';
	$tanggal = '';
	$kode_akun = '';
	$saldo = '';
    $msg_info = 'Simpan Data Berhasil.';
}

if (isset($_GET['ide'])) {
    $keuangan_pengeluaran_id = $_GET['ide'];
    $sql = 'SELECT DATE_FORMAT(bos_keuangan_pengeluaran.TANGGAL,"%d/%m/%Y") AS TANGGAL,
			bos_keuangan_pengeluaran.KODEAKUN,bos_keuangan_pengeluaran.SALDO
			FROM bos_keuangan_pengeluaran WHERE KEUANGAN_PENGELUARAN_ID = ' . $keuangan_pengeluaran_id;
    $get = mysql_query($sql) or die(mysql_error());
    $dat = mysql_fetch_assoc($get);
    $tanggal = $dat['TANGGAL'];
    $kode_akun = $dat['KODEAKUN'];
    $saldo = $dat['SALDO'];
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM bos_keuangan_pengeluaran WHERE KEUANGAN_PENGELUARAN_ID = ' . $_GET['idx']) or die(mysql_error());
    $msg_info = 'Hapus Data Berhasil.';
}

$searchkey = '';
$sql_search = '';
if (!empty($_REQUEST['searchkey'])) {
    $searchkey = $_REQUEST['searchkey'];
    $sql_search = ' AND DATE_FORMAT(TANGGAL,"%d/%m/%Y") LIKE "%' . $searchkey . '" ';
}

if (isset($_GET['idd'])) {
    $keuangan_pengeluaran_id = $_GET['idd'];
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $keuangan_pengeluaran_id; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&idx=<?php echo $keuangan_pengeluaran_id; ?>&searchkey=<?php echo $searchkey; ?>";
        }
    </script>
    <?php
}
?>
<form name="search" method="post" action="index.php">
    <input type="hidden" name="keuangan_pengeluaran_id" id="keuangan_pengeluaran_id" value="<?php echo $keuangan_pengeluaran_id; ?>" />
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" />
    <table border="0" class="tableform" width="800">
        <tr><td>Tanggal</td>
			<td><input type="text" name="tanggal" id="tgl_1" value="<?php echo $tanggal; ?>" style="width:260px;" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/>
				</td>
		</tr>
		<tr><td>Kode Akun</td>
			<td><select name="kode_akun" id="kode_akun"  class="text_dt" style="width:270px;">
			<option value="" >--</option>
			<?php
			$json_response = json_decode($_SESSION['ref_akun_pengeluaran'],true);
			$json_data = $json_response['ref_pengeluaran'];
			foreach($json_data as $row){
				$selected = '';
				if($kode_akun == $row['Kode'] . '--' . $row['Uraian']) $selected = 'selected="selected"'; 
				echo '<option value="' . $row['Kode'] . '--' . $row['Uraian'] . '" ' . $selected . ' >' . $row['Kode'] . '--' . $row['Uraian'] . '</option>';
			} ?>	
			</select></td>
		</tr>
		<tr><td>Saldo</td>
			<td><input name="saldo" type="text" id="saldo"  class="text_dt" value="<?php echo $saldo; ?>" style="width:260px;text-align:right;" /></td>
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
			<th>Tanggal</th>
			<th>Kode Akun</th>
			<th>Saldo</th>
			<th>Tgl Update</th>
			<th>Publis</th>
			<th width="100">Option</th>
		</tr>
        <?php
        $sql = 'SELECT bos_keuangan_pengeluaran.KEUANGAN_PENGELUARAN_ID,bos_keuangan_pengeluaran.TANGGALUPDATE,
				bos_keuangan_pengeluaran.TANGGAL,bos_keuangan_pengeluaran.KODEAKUN,bos_keuangan_pengeluaran.SALDO,
				bos_keuangan_pengeluaran.PUBLISH
				FROM bos_keuangan_pengeluaran 
				WHERE 1 ' . $sql_search . ' 
				ORDER BY bos_keuangan_pengeluaran.TANGGAL DESC';
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
        
			echo '</td><td align="center">' . $dat['KEUANGAN_PENGELUARAN_ID'] . '</td>';
            echo '<td>' . $dat['TANGGAL'] . '</td>';
            echo '<td>' . $dat['KODEAKUN'] . '</td>';
			echo '<td align="right">' . currFormat($dat['SALDO']) . '</td>';
			echo '<td>' . $dat['TANGGALUPDATE'] . '</td>';
			echo '<td align="center">'; ?>
				<input type="checkbox" name="publish" id="publish_<?php echo $no; ?>" value="1" 
				<?php if($dat['PUBLISH']== '1') echo 'checked="checked"'; ?>  
				onclick="JavaScript : centang_opt('publish_<?php echo $no; ?>','<?php echo $dat['KEUANGAN_PENGELUARAN_ID']; ?>');" />        
			<?php echo '</td><td><a href="index.php?link=' . $_REQUEST['link'] . '&ide=' . $dat['KEUANGAN_PENGELUARAN_ID'] . '&searchkey=' . $searchkey . '">edit</a>&nbsp;
			<a href="index.php?link=' . $_REQUEST['link'] . '&idd=' . $dat['KEUANGAN_PENGELUARAN_ID'] . '&searchkey=' . $searchkey . '">hapus</a></td></tr>';
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
			MyAjaxRequest('bospublish','index.php?ajaxrequest=bospublish&opt=1&data=pengeluaran&id=' + id);
		}else{
			document.getElementById(ck).checked = false;
		}
		return false;
	}else{
		MyAjaxRequest('bospublish','index.php?ajaxrequest=bospublish&opt=2&data=pengeluaran&id=' + id);
		return false;
	}
}
</script>		