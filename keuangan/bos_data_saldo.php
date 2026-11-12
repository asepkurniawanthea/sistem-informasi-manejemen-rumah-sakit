<?php
include('keuangan/bos_refdata.php');

if(!isset($_SESSION['ref_akun_saldo'])){
	$_SESSION['ref_akun_saldo'] = '{"ref_saldo":' . getBosDataRef('kode_rekening') . '}';
}

$connect_5 = mysql_connect($hostname_5, $username_5, $password_5) or die(mysql_error());
mysql_select_db($database_5, $connect_5) or die(mysql_error());

$keuangan_saldo_id = '';
$tanggal = '';
$kode_akun = '';
$nama_bank = '';
$saldo = '';

if (isset($_POST['keuangan_saldo_id'])) {
	$keuangan_saldo_id = $_POST['keuangan_saldo_id'];
    $tanggal = $_POST['tanggal'];
    $kode_akun = $_POST['kode_akun'];
	$nama_bank = $_POST['nama_bank'];
    $saldo = $_POST['saldo'];
	
	date_default_timezone_set('UTC');
	$unix_time	= strval(time() - strtotime('1970-01-01 00:00:00'));
	$tgl_update = date('Y-m-d H:m:s', $unix_time);
   
    if (!empty($keuangan_saldo_id)) {
        mysql_query('UPDATE bos_keuangan_saldo SET TANGGALUPDATE = STR_TO_DATE("' . $tgl_update . '","%Y-%m-%d %H:%i:%s"),
					TANGGAL = ' . fieldDate($tanggal) . ',KODEJENISREKENING = "' . $kode_akun . '",
					NAMA_BANK = "' . $nama_bank . '",SALDO = "' . $saldo . '" 
					WHERE KEUANGAN_SALDO_ID = "' . $keuangan_saldo_id . '"') or die(mysql_error());
    } else {
        mysql_query('INSERT INTO bos_keuangan_saldo(TANGGALUPDATE,TANGGAL,KODEJENISREKENING,NAMA_BANK,SALDO) VALUES(
					STR_TO_DATE("' . $tgl_update . '","%Y-%m-%d %H:%i:%s"),' . fieldDate($tanggal) . ',
					"' . $kode_akun . '","' . $nama_bank . '","' . $saldo . '")') or die(mysql_error());
    }
    $keuangan_saldo_id = '';
	$tanggal = '';
	$kode_akun = '';
	$nama_bank = '';
	$saldo = '';
    $msg_info = 'Simpan Data Berhasil.';
}

if (isset($_GET['ide'])) {
    $keuangan_saldo_id = $_GET['ide'];
    $sql = 'SELECT DATE_FORMAT(bos_keuangan_saldo.TANGGAL,"%d/%m/%Y") AS TANGGAL,
			bos_keuangan_saldo.KODEJENISREKENING,bos_keuangan_saldo.NAMA_BANK,bos_keuangan_saldo.SALDO
			FROM bos_keuangan_saldo WHERE KEUANGAN_SALDO_ID = ' . $keuangan_saldo_id;
    $get = mysql_query($sql) or die(mysql_error());
    $dat = mysql_fetch_assoc($get);
    $tanggal = $dat['TANGGAL'];
    $kode_akun = $dat['KODEJENISREKENING'];
	$nama_bank = $dat['NAMA_BANK'];
    $saldo = $dat['SALDO'];
}

if (isset($_GET['idx'])) {
    mysql_query('DELETE FROM bos_keuangan_saldo WHERE KEUANGAN_SALDO_ID = ' . $_GET['idx']) or die(mysql_error());
    $msg_info = 'Hapus Data Berhasil.';
}

$searchkey = '';
$sql_search = '';
if (!empty($_REQUEST['searchkey'])) {
    $searchkey = $_REQUEST['searchkey'];
    $sql_search = ' AND DATE_FORMAT(TANGGAL,"%d/%m/%Y") LIKE "%' . $searchkey . '" ';
}

if (isset($_GET['idd'])) {
    $keuangan_saldo_id = $_GET['idd'];
    ?>
    <script language="JavaScript" >
        if(confirm("[<?php echo $keuangan_saldo_id; ?>] dihapus?")){
            window.location = "index.php?link=<?php echo $_REQUEST['link']; ?>&idx=<?php echo $keuangan_saldo_id; ?>&searchkey=<?php echo $searchkey; ?>";
        }
    </script>
    <?php
}
?>
<form name="search" method="post" action="index.php">
    <input type="hidden" name="keuangan_saldo_id" id="keuangan_saldo_id" value="<?php echo $keuangan_saldo_id; ?>" />
    <input type="hidden" name="link" id="link" value="<?php echo $_REQUEST['link']; ?>" />
    <input type="hidden" name="searchkey" id="searchkey" value="<?php echo $searchkey; ?>" />
    <table border="0" class="tableform" width="800">
        <tr><td>Tanggal</td>
			<td><input type="text" name="tanggal" id="tgl_1" value="<?php echo $tanggal; ?>" style="width:260px;" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/>
				</td>
		</tr>
		<tr><td>Kode Jenis Rekening</td>
			<td><select name="kode_akun" id="kode_akun"  class="text_dt" style="width:270px;">
			<option value="" >--</option>
			<?php
			$json_response = json_decode($_SESSION['ref_akun_saldo'],true);
			$json_data = $json_response['ref_saldo'];
			foreach($json_data as $row){
				$selected = '';
				if($kode_akun == $row['Kode'] . '--' . $row['Uraian']) $selected = 'selected="selected"'; 
				echo '<option value="' . $row['Kode'] . '--' . $row['Uraian'] . '" ' . $selected . ' >' . $row['Kode'] . '--' . $row['Uraian'] . '</option>';
			} ?>	
			</select></td>
		</tr>
		<tr><td>Nama Bank</td>
			<td><input name="nama_bank" type="text" id="nama_bank"  class="text_dt" value="<?php echo $nama_bank; ?>" style="width:260px;" /></td>
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
			<th>Kode Jenis Rekening</th>
			<th>Nama Bank</th>
			<th>Saldo</th>
			<th>Tgl Update</th>
			<th>Public</th>
			<th width="100">Option</th>
		</tr>
        <?php
        $sql = 'SELECT bos_keuangan_saldo.KEUANGAN_SALDO_ID,bos_keuangan_saldo.TANGGALUPDATE,
				bos_keuangan_saldo.TANGGAL,bos_keuangan_saldo.KODEJENISREKENING,
				bos_keuangan_saldo.NAMA_BANK,bos_keuangan_saldo.SALDO,
				bos_keuangan_saldo.PUBLISH
				FROM bos_keuangan_saldo 
				WHERE 1 ' . $sql_search . ' 
				ORDER BY bos_keuangan_saldo.TANGGAL DESC';
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
        
			echo '</td><td align="center">' . $dat['KEUANGAN_SALDO_ID'] . '</td>';
            echo '<td>' . $dat['TANGGAL'] . '</td>';
            echo '<td>' . $dat['KODEJENISREKENING'] . '</td>';
			echo '<td>' . $dat['NAMA_BANK'] . '</td>';
			echo '<td align="right">' . currFormat($dat['SALDO']) . '</td>';
			echo '<td>' . $dat['TANGGALUPDATE'] . '</td>';
			echo '<td align="center">'; ?>
				<input type="checkbox" name="publish" id="publish_<?php echo $no; ?>" value="1" 
				<?php if($dat['PUBLISH']== '1') echo 'checked="checked"'; ?>  
				onclick="JavaScript : centang_opt('publish_<?php echo $no; ?>','<?php echo $dat['KEUANGAN_SALDO_ID']; ?>');" />        
			<?php echo '</td><td><a href="index.php?link=' . $_REQUEST['link'] . '&ide=' . $dat['KEUANGAN_SALDO_ID'] . '&searchkey=' . $searchkey . '">edit</a>&nbsp;
			<a href="index.php?link=' . $_REQUEST['link'] . '&idd=' . $dat['KEUANGAN_SALDO_ID'] . '&searchkey=' . $searchkey . '">hapus</a></td></tr>';
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
			MyAjaxRequest('bospublish','index.php?ajaxrequest=bospublish&opt=1&data=saldo&id=' + id);
		}else{
			document.getElementById(ck).checked = false;
		}
		return false;
	}else{
		MyAjaxRequest('bospublish','index.php?ajaxrequest=bospublish&opt=2&data=saldo&id=' + id);
		return false;
	}
}
</script>		